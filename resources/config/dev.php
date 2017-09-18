<?php

require __DIR__ . '/prod.php';

/**
 * Log configurations
 */
$app['debug'] = true;
$app['log.level'] = Monolog\Logger::DEBUG;
