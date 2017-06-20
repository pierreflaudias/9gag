<?php
/**
 * Created by PhpStorm.
 * User: analbessar
 * Date: 29/05/17
 * Time: 09:27.
 */

namespace LolBundle\Controller\Website;

use LolBundle\Entity\Comment;
use LolBundle\Entity\Meme;
use LolBundle\Form\MemeType;
use LolBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type as Form;

class MemeController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $memes = $this->get('meme_reader')->getAll();

        return $this->render('LolBundle:Meme:index.html.twig', [
                'memes' => $memes,
            ]
        );
    }

    /**
     * @param $id
     * @param $note
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function noteAction($id, $note)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $meme = $this->get('meme_reader')->getOneById($id);
        if ($meme != null) {
            $this->get('meme_note')->noteOne($meme, $note);
        }

        return $this->redirectToRoute('lol_show_meme', [
            'id' => $meme->getId(),
        ]);
    }

    public function removeAction(Request $request, $id)
    {
        $meme = $this->get('meme_reader')->getOneById($id);
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') || $this->getUser() !== $meme->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $this->get('meme_factory')->removeOne($meme);

        return $this->redirectToRoute('lol_homepage');
    }

    public function removeCommentAction(Request $request, $id, $comment_id)
    {
        $comment = $this->get('comment_reader')->getOneById($comment_id);
        $meme = $this->get('meme_reader')->getOneById($id);

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') || $this->getUser() !== $meme->getUser() || $this->getUser() !== $comment->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $this->get('meme_commenter')->removeComment($comment);

        return $this->redirectToRoute('lol_show_meme', [
            'id' => $meme->getId(),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $meme = new Meme();
        $form = $this->createForm(MemeType::class, $meme);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('meme_factory')->createOne($meme, $this->getUser());

            return $this->redirectToRoute('lol_homepage');
        }

        return $this->render(
            'LolBundle:Meme:form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $request, $id)
    {
        $meme = $memes = $this->get('meme_reader')->getOneById($id);
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
                throw $this->createAccessDeniedException();
            }
            $this->get('meme_commenter')->addComment($meme, $this->getUser(), $comment);

            return $this->redirectToRoute('lol_show_meme', [
                'id' => $meme->getId(),
            ]);
        }

        return $this->render('LolBundle:Meme:show.html.twig',
            [
                'meme' => $meme,
                'form' => $form->createView(),
            ]
        );
    }
}
