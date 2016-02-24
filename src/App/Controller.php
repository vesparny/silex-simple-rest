<?php

namespace App;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Created by PhpStorm.
 * User: johnleytondiaz
 * Date: 28/01/16
 * Time: 9:42 PM
 *
 * This is the global controller to use when trying to extend the application, every controller
 * must extend this class, also if you are declaring a controllername other than the SQL table name,
 * must specify the service name
 */
abstract class Controller extends \App\BaseRestApi
{
    /**
     * Controller linked service
     *
     * @var object
     */
    public $service;

    /**
     * Url endpoint name is equivalent to the controller name
     *
     * @var string
     */
    public $endpointName;

    /**
     * Controller constructor.
     *
     * @param Application $api
     * @param             $service
     */
    public function __construct($api, $service)
    {
        $this->api = $api;
        parent::__construct($api);
        $this->service = $service;
    }

    /**
     * Formats the given class name to an api enpoint name.
     *
     * @return mixed|string
     */
    public function getControllerName()
    {

        $class = new \ReflectionClass(get_class($this));

        $this->endpointName = str_replace("controller", "", strtolower($class->getShortName()));

        return $this->endpointName;
    }

    /**
     * Must return an array with api calls to register
     *
     * @return array
     */
    abstract public function endpoints();

    /**
     * Gets all records for the current service
     *
     * @return JsonResponse
     */
    public function getAll()
    {
        return new JsonResponse($this->service->getAll());
    }

    /**
     * Saves a record into the current service
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function save(Request $request)
    {
        $attributes = $this->getDataFromRequest($request);

        return new JsonResponse(array("id" => $this->service->save($attributes)));

    }

    public function update($id, Request $request)
    {
        $attributes = $this->getDataFromRequest($request);
        $this->service->update($id, $attributes);

        return new JsonResponse($attributes);

    }

    public function delete($id)
    {

        return new JsonResponse($this->service->delete($id));

    }

    public function getDataFromRequest(Request $request)
    {
        return array(
            $this->endpointName => $request->request->get($this->endpointName)
        );
    }

}
