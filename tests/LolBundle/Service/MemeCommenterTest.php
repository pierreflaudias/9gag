<?php
/**
 * Created by PhpStorm.
 * User: analbessar
 * Date: 20/06/17
 * Time: 11:58
 */

namespace LolBundle\Service;


use Doctrine\ORM\EntityManager;
use LolBundle\Factory\MemeCommenter;

class MemeCommenterTest extends \PHPUnit\Framework\TestCase
{
    private $memeCommenter;

    public function addComment()
    {
        // create entity manager mock
        $em = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->setMethods(array('persist', 'flush'))
            ->disableOriginalConstructor()
            ->getMock();

        // now you can get some assertions if you want, eg.:
        $em->expects($this->once())
            ->method('flush');

        $this->memeCommenter = new MemeCommenter($em);

        $this->memeCommenter->addComment($meme, $user, $comment);
    }
}
