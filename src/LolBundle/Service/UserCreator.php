<?php
/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 18/06/17
 * Time: 13:14.
 */

namespace LolBundle\Service;

use Doctrine\ORM\EntityManager;
use LolBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class UserCreator
{
    private $em;
    private $encoder;

    /**
     * UserCreator constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em, UserPasswordEncoder $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
    }

    public function registerUser(User $user)
    {
        $password = $this->encoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);

        $user->setApiKey(hash('sha256', $user->getEmail().$user->getPassword()));

        $this->em->persist($user);
        $this->em->flush();
    }
}
