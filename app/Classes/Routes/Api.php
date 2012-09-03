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
			$post = $app['business.api']->getAll();
			return $app->json($post);
		});
		
		$controllers->get('/hello', function (Application $app) {
			return $app->abort(401);
		});

		return $controllers;
	}

}