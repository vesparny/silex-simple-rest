<?php
$app['log.level'] = Monolog\Logger::ERROR;
$app['api.version'] = "v1";
$app['api.endpoint'] = "/api";
$app['db.options'] = array(
  "driver" => "pdo_mysql",
  "user" => "root",
  "password" => "root",
  "dbname" => "prod_db",
  "host" => "prod_host",
);
