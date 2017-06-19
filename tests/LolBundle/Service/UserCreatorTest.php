<?php
/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 18/06/17
 * Time: 14:04.
 */

namespace LolBundle\Service;

use Doctrine\ORM\EntityRepository;

class UserCreatorTest extends \PHPUnit_Framework_TestCase
{
    private $em;

    public function testRegisterUser()
    {
        $this->em = $this
            ->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
