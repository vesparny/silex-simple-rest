<?php

namespace Vesparny\Silex\Provider\Service;

use Silex\ServiceProviderInterface;
use Silex\Application;

class BusinessServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app->before(function() use ($app) {
            foreach ($app["business.container"] as $label => $class) {
                $app["business.".$label] = $app->share(function() use ($class, $app) {
                   return new $class($app['db']); 
                });
            }
        });
    }
    public function boot(Application $app)
    {

    }
}