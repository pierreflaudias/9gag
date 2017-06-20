<?php
/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 18/06/17
 * Time: 14:06.
 */

namespace LolBundle\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MemeControllerTest extends WebTestCase
{
    public function testIndexAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $this->assertGreaterThan(0, $crawler->filter('h2')->count());
    }
}
