<?php

namespace App\Routes;

use Silex\ControllerProviderInterface;
use Silex\Application;

class Api implements ControllerProviderInterface
{


    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', function (Application $app) {
            $post = $app['business.api']->getAll();
            var_dump($post);
        });

        return $controllers;
    }

}