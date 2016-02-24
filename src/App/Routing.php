<?php

namespace App;

use Silex\Application;

class Routing
{
    /**
     * @var Application
     */
    private $api;

    /**
     * @var string
     */
    private $mappedClass;

    /**
     * Routing constructor.
     *
     * @param Application $app
     * @param bool      $service
     * @param string      $mappedClass
     */
    public function __construct(Application $app, $service , $mappedClass)
    {
        $this->api         = $app;
        $this->mappedClass = $mappedClass;
        $this->service     = $service;
    }

    /**
     * @return object
     */
    private function getController()
    {

        $controller = "App\\Controllers\\" . $this->mappedClass . "Controller";
        $controller = new $controller($this->api, $this->api[ $this->service.".service" ]);

        $this->api[ "$this->service.controller" ] = $this->api->share(function () use ($controller) {
            return $controller;
        });


        return $controller;

    }

    public function registerService()
    {
        $this->api[ $this->service.".service" ] = $this->api->share(function () {

            $service = "App\\Services\\" . $this->mappedClass . "Service";

            return new $service($this->api);
        });

    }


    /**
     * Register the controller endpoints
     */
    public function register()
    {
        $this->registerService();
        $controller = $this->getController();
        $endpoints  = $controller->endpoints();
        $api        = $this->api[ "controllers_factory" ];

        //TODO modify api call loader to lazy load the endpoints

        foreach ($endpoints as $method => $endpoint) {
            self::registerEndpoints($api, $method, $endpoint);
        }

        $this->api->mount($this->api[ "api.endpoint" ] . '/' . $this->api[ "api.version" ], $api);

    }

    /**
     * Register endpoints
     *
     * @param Application $api
     * @param string      $method
     * @param array       $endpoints
     */
    public static function registerEndpoints(&$api, $method, array $endpoints)
    {
        foreach ($endpoints as $endpoint => $callback) {
            $api->{$method}($endpoint, $callback);
        }
    }

}
