<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        // TODO : check if it is OK
        $data_test = array('cle_test' => 'valeur_test');
        $data_test2 = array('cle_test2' => 'valeur_test2');
        $this->assertContains($data_test, $crawler->filter('#container h1')->text());

    }

    public function testExample()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/example');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        // TODO
        // $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    }
}
