<?php

use Silex\Application;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Igorw\Silex\ConfigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Monolog\Logger;
use Classes\Routes\Api;
use Vesparny\Silex\Provider\Service\BusinessServiceProvider;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Silex\Provider\HttpCacheServiceProvider;



error_reporting(E_ALL);
ini_set('display_errors', "On");

$app = new Application();
$app->register(new ValidatorServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new SessionServiceProvider());

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_mysql',
        'dbname'     => "silex",
        'host'     => "localhost",
        'user'     => "root",
        'password'     => "root"
    ),
));

$app->register(new HttpCacheServiceProvider(), array(   'http_cache.cache_dir' => APP_PATH.'/cache/',   ));

$app->register(new BusinessServiceProvider(), array("business.container" => array(
    "api"      => "Classes\\Business\\Api"
)));

$env = getenv('APP_ENV') ? getenv('APP_ENV') : 'dev';
$app->register(new ConfigServiceProvider(APP_PATH."/config/$env.json"));

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => APP_PATH."/logs/app.log",
    'monolog.level' => Logger::DEBUG,
    'monolog.name' => "application"
    
));



$app->get('/', function () use ($app) {
    $request = Request::create("/api/", 'GET');
    return $app->handle($request, HttpKernelInterface::SUB_REQUEST);
});

$app->mount('/api', new Api());

$app->error(function (\Exception $e, $code) {
    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
    }

    return new Response($message, $code);
});

return $app;