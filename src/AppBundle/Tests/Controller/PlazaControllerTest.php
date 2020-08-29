<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlazaControllerTest extends WebTestCase
{
    public function testGetplazas()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'plazas');
    }

}
