<?php
require_once __DIR__ . '/../vendor/autoload.php';

define('HOST', 'rabbitmq');
define('PORT', 5672);
define('USER', getenv('RABBITMQ_DEFAULT_USER'));
define('PASS', getenv('RABBITMQ_DEFAULT_PASS'));
define('VHOST', '/');

//If this is enabled you can see AMQP output on the CLI
define('AMQP_DEBUG', false);

$exchange = 'router';
$queue = 'msgs';
$dlx = '-dlx';
$routing_key = 'main_routing_key';
