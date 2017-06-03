<?php
/**
 * Created by PhpStorm.
 * User: analbessar
 * Date: 29/05/17
 * Time: 09:27
 */

namespace LolBundle\Controller;

use LolBundle\Entity\Meme;
use LolBundle\Form\MemeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type as Form;

class MemeController extends Controller
{
    public function indexAction()
    {
        $repo = $this->getDoctrine()->getRepository('LolBundle:Meme');
        $memes = $repo->findBy([],['date' => 'DESC'], 5, 0);
        return $this->render('LolBundle:Meme:index.html.twig', [
                'memes' => $memes
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $meme = new Meme();
        $form = $this->createForm(MemeType::class, $meme);

        if ($form->handleRequest($request)->isValid()) {
            $image = $meme->getImage();
            $fileName = md5(uniqid()).'.'.$image->guessExtension();
            $image->move(
                $this->getParameter('memes_images_directory'),
                $fileName
            );
            $meme->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($meme);
            $em->flush();
            return $this->redirect($this->generateUrl('lol_homepage'));
        }

        return $this->render('LolBundle:Meme:create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function showAction($id)
    {
        $repo = $this->getDoctrine()->getRepository('LolBundle:Meme');
        $meme = $repo->findOneById($id);
        return $this->render('LolBundle:Meme:show.html.twig', [
                'meme' => $meme
            ]
        );
    }
}