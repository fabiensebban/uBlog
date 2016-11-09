<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

    public function testAbout()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/about');
    }

    public function testContact()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contact');
    }

}
