<?php
/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 10/06/17
 * Time: 20:50
 */

namespace LolBundle\Security;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ApiKeyUserProvider implements UserProviderInterface
{
    private $repository;
    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getUserForApiKey($apiKey)
    {
        $user = $this->repository->findOneByApiKey($apiKey);
        if ($user == null){
            throw new AccessDeniedException();
        }
        return $user;
    }

    public function loadUserByUsername($username)
    {
        return $this->repository->findOneByUsername($username);
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