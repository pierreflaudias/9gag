<?php
/**
 * Created by PhpStorm.
 * User: analbessar
 * Date: 03/06/17
 * Time: 09:10.
 */

namespace LolBundle\Controller\Website;

use LolBundle\Entity\User;
use LolBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('user_creator')->registerUser($user);

            return $this->redirectToRoute('lol_homepage');
        }

        return $this->render('LolBundle:User:register.html.twig', [
            'form' => $form->createView(),
            ]
        );
    }

    public function showAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $repo = $this->getDoctrine()->getRepository('LolBundle:User');
        $user = $repo->find($id);

        return $this->render('LolBundle:User:show.html.twig', [
            'user' => $user,
        ]);
    }

    public function loginAction()
    {
        $authUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('LolBundle:User:login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }
}
