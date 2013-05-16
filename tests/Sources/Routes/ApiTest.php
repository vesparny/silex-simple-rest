<?php

use Silex\WebTestCase;

class ApiTest extends WebTestCase
{
     
    public $app = null;

    static private $instance = null;

    //Create App Singleton
    static public function getInstance()
    {
        if (null === self::$instance) {
             self::$instance =  require __DIR__.'/../../../src/boot.php';
        }
         return self::$instance;
    }
    
    public function createApplication()
    {
        $this->app = ApiTest::getInstance();
        return $this->app;
    }

    public function testRoot()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        $response = $client->getResponse();
        $this->assertTrue($response->isOk(), "response status code is : ".$response->getStatusCode());
        $this->assertTrue($response instanceof  Symfony\Component\HttpFoundation\Response, "not a valid response");

    }
    
}
