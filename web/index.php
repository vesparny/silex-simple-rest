<?php
require_once( __DIR__ ."/../vendor/autoload.php");
$app = require( __DIR__ ."/../src/boot.php");
if ($app['debug']) {
    $app->run();
}else{
	$app['http_cache']->run();
}
