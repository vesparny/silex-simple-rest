<?php

use Silex\Application;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Igorw\Silex\ConfigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Monolog\Logger;
use Vesparny\Silex\Provider\Service\BusinessServiceProvider;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Silex\Provider\HttpCacheServiceProvider;


define('ROOT_PATH',    __DIR__ . '/..');
define('APP_PATH',   ROOT_PATH . '/app');

$app = new Application();
$app->register(new UrlGeneratorServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new HttpCacheServiceProvider(), array("http_cache.cache_dir" => APP_PATH."/cache/",   ));

//loading default configuration
$app->register(new ConfigServiceProvider(APP_PATH."/config/default.json"));

$env = getenv("APP_ENV") ? getenv("APP_ENV") : "dev";

//overwriting configuration with enviroment specific
$app->register(new ConfigServiceProvider(APP_PATH."/config/$env.json"));

//turn on error reporting for dev purpose
if ($env === "dev"){
	error_reporting(E_ALL | E_STRICT);
	ini_set('display_errors', 1);
	ini_set('log_errors', 1);
}

//create connection if configured
if ($app->offsetExists("database.connection")) {
	$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
			"db.options" => $app["database.connection"],
	));
}

//registering logger
$app->register(new MonologServiceProvider(), array(
		"monolog.logfile" => APP_PATH."/logs/".date("Y-m-d").".log",
		"monolog.level" => $app["log.level"],
		"monolog.name" => "application"
));

//load routes files
$routesDir  = APP_PATH."/Classes/Routes";
$routes = scandir($routesDir);
foreach ($routes as $file){
	if (pathinfo($file, PATHINFO_EXTENSION) === "php"){
		$exploded = explode(".", $file);
		$routeToLoad = "Classes\\Routes\\".$exploded[0];
		$app->mount("/".strtolower($exploded[0]), new $routeToLoad);
	}
}

//load business components
$businessDir  = APP_PATH."/Classes/Business";
$business = scandir($businessDir);
$arryToLoad = array();
foreach ($business as $file){
	if (pathinfo($file, PATHINFO_EXTENSION) === "php"){
		$exploded = explode(".", $file);
		$arryToLoad[strtolower($exploded[0])] = "Classes\\Business\\".$exploded[0];
	}
}
$app->register(new BusinessServiceProvider(),array("business.container" =>  $arryToLoad));

//handling calls to the root to a default route manager
$app->get("/", function () use ($app) {
	$request = Request::create($app["base.route"], "GET");
	return $app->handle($request, HttpKernelInterface::SUB_REQUEST);
});

//managing errors
$app->error(function (\Exception $e, $code) use ($app) {
	$app['monolog']->addInfo($e->getMessage());
	$app['monolog']->addInfo($e->getTraceAsString());
	switch ($code) {
		case 404:
			$message = "Resource not found.";
			break;
		case 401:
			$message = "Unauthorized.";
			break;
		default:
			$message = "Internal server error.";
	}
	return $app->json(array("statusCode"=>$code, "message" => $message));
});

return $app;