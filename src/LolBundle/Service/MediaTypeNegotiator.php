<?php
/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 07/06/17
 * Time: 00:37
 */

namespace LolBundle\Service;


class MediaTypeNegotiator
{
    const TEXT_HTML = "text/html";
    const APPLICATION_JSON = "application/json";

    public function guessBestFormat()
    {
        $negotiator = new \Negotiation\Negotiator();
        if (isset($_SERVER['HTTP_ACCEPT'])) {
            $accept_header = $_SERVER['HTTP_ACCEPT'];
        } else {
            $accept_header = 'text/html, application/json, application/x-www-form-urlencoded';
        }
        $priorities = array('text/html', 'application/json', 'application/x-www-form-urlencoded');
        $media_type = $negotiator->getBest($accept_header, $priorities);
        return $media_type->getValue();
    }
}