<?php

define('ROOT_PATH',    __DIR__ . '/..');
define('APP_PATH',   ROOT_PATH . '/app');

require_once(ROOT_PATH."/vendor/autoload.php");

$app = require(ROOT_PATH."/src/vesparny/bootstrap/boot.php");

if ($app['debug']) {
    $app->run();
}else{
	$app['http_cache']->run();
}
