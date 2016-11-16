<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author Koen Vinken <vinkenkoen@gmail.com>
 */
class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /*public function testJson()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/json/example');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }*/
}
