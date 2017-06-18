<?php
/**
 * Created by PhpStorm.
 * User: analbessar
 * Date: 15/06/17
 * Time: 09:59.
 */

namespace LolBundle\Controller\Api;

use LolBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private $serializer;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->serializer = $this->get('lol.serializer.default');
    }

    public function registerAction(Request $request)
    {
        $user = $this->serializer->deserialize($request->getContent(), User::class, 'json');
        $this->get('user_creator')->registerUser($user);

        return new JsonResponse(['message' => 'User '.$user->getUsername().' created.'], 201);
    }

    public function showAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        return new Response($this->serializer->serialize($this->getUser(), 'json'), 200, ['Content-Type' => 'application/json']);
    }
}
