<?php

/**
 * Default timezone
 */
$timezone = 'America/Sao_Paulo';
date_default_timezone_set($timezone);

/**
 * Log configurations
 */
$app['log.level'] = Monolog\Logger::ERROR;

/**
 * API configurations
 */
$app['api.version'] = "v1";
$app['api.endpoint'] = "/api";

/**
 * DB Configurations
 */
$app['db.options'] = array(
    'driver' => 'pdo_sqlite',
    'path' => realpath(ROOT_PATH . '/app.db'),
);

/**
 * DB Configurations Doctrine
 */
$dbConfig = array(
    "db.options" => $app["db.options"]
);

/**
 * HTTP Cache Configurations
 */
$httpConfig = array(
    "http_cache.cache_dir" => ROOT_PATH . "/storage/cache"
);

/**
 * Monolog Configurations
 */
$monologConfig = array(
    "monolog.logfile" => ROOT_PATH . "/storage/logs/" . Carbon\Carbon::now($timezone)->format("Y-m-d") . ".log",
    "monolog.level" => $app["log.level"],
    "monolog.name" => "application"
);
