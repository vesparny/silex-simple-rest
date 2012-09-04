<?php

use Silex\WebTestCase;

class ApiTest extends WebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__.'/../../../src/boot.php';
        return $app;
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
