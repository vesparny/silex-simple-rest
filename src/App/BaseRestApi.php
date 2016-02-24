<?php
/**
 * Created by PhpStorm.
 * User: johnleytondiaz
 * Date: 29/01/16
 * Time: 8:05 PM
 */

namespace App;

use \Silex\Application;


class BaseRestApi
{

    /**
     * @var Application
     */
    public $api;

    /**
     * DB Instance
     *
     * @var mixed
     */
    protected $db;

    public function __construct($api)
    {
        $this->api = $api;
        $this->db = $this->api[ "db" ];
    }
}