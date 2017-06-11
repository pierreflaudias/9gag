<?php
/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 10/06/17
 * Time: 20:50
 */

namespace LolBundle\Security;


use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ApiKeyUserProvider implements UserProviderInterface
{
    public function getUsernameForApiKey($apiKey)
    {
        $repository = $this->getRepository();
        $user = $repository->findOneByApiKey($apiKey);
        return $user->getUsername();
    }

    public function loadUserByUsername($username)
    {
        $repository = $this->getRepository();
        return $repository->findOneByUsername($username);
    }

    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }
}