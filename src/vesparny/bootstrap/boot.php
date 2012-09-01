<?php

use Silex\Application;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Igorw\Silex\ConfigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Monolog\Logger;
use App\Routes\Def;


error_reporting(E_ALL);
ini_set('display_errors', 1);

$app = new Application();
$app->register(new ValidatorServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new SessionServiceProvider());

$env = getenv('APP_ENV') ? getenv('APP_ENV') : 'dev';
//$app->register(new ConfigServiceProvider(APP_PATH."/config/$env.json"));

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => APP_PATH."/logs/app.log",
    'monolog.level' => Logger::DEBUG,
    'monolog.name' => "application"
    
));


$app->match("/", function(){
	
	
})->bind('homepage');

$app->get("/a", function() use ($app){
	
	return $app->redirect($app['url_generator']->generate('homepage'));
});

// definitions

return $app;