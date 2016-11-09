<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentControllerTest extends WebTestCase
{
    public function testCreate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/comment/create');
    }

    public function testLike()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/comment/{id}/like');
    }

    public function testShare()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/comment/{id}/share');
    }

}
