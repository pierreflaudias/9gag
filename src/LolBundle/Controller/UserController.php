<?php
/**
 * Created by PhpStorm.
 * User: analbessar
 * Date: 03/06/17
 * Time: 09:10
 */

namespace LolBundle\Controller;


use LolBundle\Entity\User;
use LolBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller
{
    public function registerAction(Request $request) //, UserPasswordEncoderInterface $passwordEncoder
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $passwordEncoder = $this->get('security.password_encoder');
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('lol_homepage');
        }

        return $this->render('LolBundle:User:register.html.twig',[
            'form' => $form->createView()
            ]
        );
    }
}