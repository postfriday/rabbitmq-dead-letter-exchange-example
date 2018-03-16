<?php
require_once __DIR__ . '/config.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
$channel = $connection->channel();

/*
    name: $queue
    passive: false
    durable: true // the queue will survive server restarts
    exclusive: false // the queue can be accessed in other channels
    auto_delete: false //the queue won't be deleted once the channel is closed.
*/
$channel->queue_declare($queue, false, true, false, false, false, [
    'x-dead-letter-exchange'    => array('S', $exchange . $dlx)
]);
$channel->queue_declare($queue . $dlx, false, true, false, false);


/*
    name: $exchange
    type: direct
    passive: false
    durable: true // the exchange will survive server restarts
    auto_delete: false //the exchange won't be deleted once the channel is closed.
*/
$channel->exchange_declare($exchange, 'direct', false, true, false);
$channel->exchange_declare($exchange . $dlx, 'direct', false, true, false);

$channel->queue_bind($queue, $exchange, $routing_key);
$channel->queue_bind($queue . $dlx, $exchange . $dlx, $routing_key);

$messageBody = 'Body random content: ' . rand();
$message = new AMQPMessage($messageBody, array('content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
$channel->basic_publish($message, $exchange, $routing_key);
$channel->close();
$connection->close();
