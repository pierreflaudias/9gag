<?php
/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 18/06/17
 * Time: 14:04.
 */

namespace LolBundle\Service;

use Doctrine\ORM\EntityManager;
use LolBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class UserCreatorTest extends \PHPUnit_Framework_TestCase
{
    private $userCreator;

    public function testRegisterUser()
    {
        $mockUser = $this->createMock(User::class);

        $mockUser->expects($this->once())
            ->method('getPlainPassword')
            ->will($this->returnValue('plain_password'));

        $em = $this
            ->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $encoder = $this
            ->getMockBuilder(UserPasswordEncoder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $encoder->expects($this->once())
            ->method('encodePassword')
            ->will($this->returnValue('hashed_password'));

        $this->userCreator = new UserCreator($em, $encoder);

        $this->userCreator->registerUser($mockUser);

        $this->assertEquals('hashed_password', $mockUser->getPassword());
    }
}
