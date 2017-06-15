<?php
/**
 * Created by PhpStorm.
 * User: analbessar
 * Date: 29/05/17
 * Time: 09:27
 */

namespace LolBundle\Controller;

use LolBundle\Entity\Comment;
use LolBundle\Entity\Meme;
use LolBundle\Form\MemeType;
use LolBundle\Form\CommentType;
use LolBundle\Service\MediaTypeNegotiator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type as Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

class MemeController extends BaseMemeController
{

    private $negotiator;

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        parent::indexAction($request);
        return $this->render('LolBundle:Meme:index.html.twig', [
                'memes' => $this->memes
            ]
        );
    }

    /**
     * @param $id
     * @param $note
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function noteAction($id, $note)
    {
        parent::noteAction($id, $note);
        return $this->redirectToRoute('lol_show_meme', [
            'id' => $this->currentMeme->getId()
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        parent::createAction($request);

        $form = $this->createForm(MemeType::class, $this->currentMeme);

        if ($form->handleRequest($request)->isValid()) {
            $image = $this->currentMeme->getImage();
            $file_name = md5(uniqid()).'.'.$image->guessExtension();
            $image->move(
                $this->getParameter('memes_images_directory'),
                $file_name
            );
            $this->currentMeme->setImage($file_name);
            $this->currentMeme->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($this->currentMeme);
            $em->flush();
            return $this->redirectToRoute('lol_homepage');
        }

        return $this->render(
            'LolBundle:Meme:form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $request, $id)
    {
        parent::showAction($request, $id);
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        if ($form->handleRequest($request)->isValid()) {
            if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
                throw $this->createAccessDeniedException();
            }
            $em = $this->getDoctrine()->getManager();
            $comment->setUser($this->getUser());
            $comment->setMeme($this->currentMeme);
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('lol_show_meme', [
                'id' => $this->currentMeme->getId()
            ]);
        }
        return $this->render('LolBundle:Meme:show.html.twig',
            [
                'meme' => $this->currentMeme,
                'form' => $form->createView()
            ]
        );
    }
}