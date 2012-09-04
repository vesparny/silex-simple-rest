<?php

namespace Classes\Routes;

use Silex\ControllerProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Api implements ControllerProviderInterface
{


	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];

		$controllers->get('/', function (Application $app) {
			return $app->json(array("ok"));
			
		});
		
		$controllers->get("hello", function (Application $app) {
			$post = $app['business.api']->getAll();
			return $app->json($post);
		});

		return $controllers;
	}

}