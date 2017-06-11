<?php
/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 11/06/17
 * Time: 10:47
 */

namespace LolBundle\Service;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;


class MediaTypeNegotiatorTest extends TestCase
{
    public function testGuessBestFormat(){
        $neg = new MediaTypeNegotiator();
        $accept_html = 'text/html';
        $accept_json = 'application/json';
        $accept_default = $accept_html;

        $this->assertEquals($neg->guessBestFormat($accept_html), MediaTypeNegotiator::TEXT_HTML);
        $this->assertEquals($neg->guessBestFormat($accept_default), MediaTypeNegotiator::TEXT_HTML);
        $this->assertEquals($neg->guessBestFormat($accept_json), MediaTypeNegotiator::APPLICATION_JSON);
    }
}
