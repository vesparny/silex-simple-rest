<?php

use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\ServicesLoader;
use App\RoutesLoader;

//accepting JSON
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

$app->register(new \Euskadi31\Silex\Provider\CorsServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new DoctrineServiceProvider(), $dbConfig);
$app->register(new HttpCacheServiceProvider(), $httpConfig);
$app->register(new MonologServiceProvider(), $monologConfig);

//load services
$servicesLoader = new App\ServicesLoader($app);
$servicesLoader->bindServicesIntoContainer();

//load routes
$routesLoader = new App\RoutesLoader($app);
$routesLoader->bindRoutesToControllers();

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    $app['monolog']->addError($e->getMessage());
    $app['monolog']->addError($e->getTraceAsString());
    $arrayReturn = array(
        "statusCode" => $code,
        "message" => $e->getMessage(),
        "stacktrace" => $e->getTraceAsString()
    );
    return new JsonResponse($arrayReturn);
});

return $app;
