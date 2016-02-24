<?php

date_default_timezone_set('Europe/London');
define("ROOT_PATH", __DIR__ . "/..");

$app['debug']       = true;
$app['log.level']   = \Monolog\Logger::DEBUG;
$app['api.version'] = "v1";
$app['api.endpoint'] = "/api";

$dbConfig = array(
    "db.options" => array(
        "driver" => "pdo_sqlite",
        'path'   => realpath(ROOT_PATH . '/app.db')
    )
);

$globalConfig = array(
    'timeZone'   => 'Europe/London',
    'dateFormat' => 'Y-m-d'
);