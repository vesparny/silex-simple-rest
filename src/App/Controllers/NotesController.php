<?php

namespace App\Controllers;


class NotesController extends \App\Controller
{

    /**
     * Array of endpoints to expose in the api
     *
     * @return array
     */
    public function endpoints()
    {
        $endpoint = $this->getControllerName();

        return array(
            'get' => array(
                $endpoint => $endpoint.".controller:getAll"
            ),
            'post'=> array(
                $endpoint => $endpoint.".controller:save"
            ),
            'put'=> array(
                $endpoint."/{id}" => $endpoint.".controller:update"
            ),
            'delete'=>array(
                $endpoint."/{id}" => $endpoint.".controller:delete"
            )
        );

    }
}
