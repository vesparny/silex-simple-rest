<?php

use Silex\WebTestCase;

class ApiTest extends WebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__.'/../../../src/boot.php';

        $app['catch_exceptions'] = false;


        unset($app['exception_handler']);

        return $app;
    }

    public function testRoot()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/');
        $response = $client->getResponse();
        $this->assertTrue($response->isOk(), "response status code is : ".$response->getStatusCode());

    }
}
