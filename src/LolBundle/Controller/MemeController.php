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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type as Form;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class MemeController extends Controller
{

    private $negotiator;
    private $serializer;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->negotiator = $this->get('negotiator');
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(['comments']);
        $this->serializer = new Serializer([$normalizer], [new JsonEncoder()]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $memes = $this->getDoctrine()->getRepository('LolBundle:Meme')
            ->findBy([],['date' => 'DESC'], 5, 0);

        if ($this->negotiator->guessBestFormat() == MediaTypeNegotiator::APPLICATION_JSON) {
            return new JsonResponse(['memes' => $this->serializer->serialize($memes, 'json')]);
        } elseif ($this->negotiator->guessBestFormat() == MediaTypeNegotiator::TEXT_HTML) {
            return $this->render('LolBundle:Meme:index.html.twig', [
                    'memes' => $memes
                ]
            );
        }
    }

    /**
     * @param $id
     * @param $note
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function noteAction($id, $note)
    {
        $em = $this->getDoctrine()->getManager();
        $repo =$em->getRepository('LolBundle:Meme');
        $meme = $repo->find($id);
        if ($note == 'upvote') {
            $meme->upVote();
        } elseif ($note == 'downvote') {
            $meme->downVote();
        }
        $em->persist($meme);
        $em->flush();
        return $this->redirectToRoute('lol_show_meme', [
            'id' => $meme->getId()
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $meme = new Meme();
        return $this->processForm($request, $meme);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $meme = $this->getDoctrine()->getRepository('LolBundle:Meme')
            ->find($id);
        return $this->processForm($request, $meme);
    }

    /**
     * @param Request $request
     * @param $meme
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    private function processForm(Request $request, $meme)
    {
        $form = $this->createForm(MemeType::class, $meme);

        if ($form->handleRequest($request)->isValid()) {
            $image = $meme->getImage();
            $file_name = md5(uniqid()).'.'.$image->guessExtension();
            $image->move(
                $this->getParameter('memes_images_directory'),
                $file_name
            );
            $meme->setImage($file_name);

            $em = $this->getDoctrine()->getManager();
            $em->persist($meme);
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
        $repo = $this->getDoctrine()->getRepository('LolBundle:Meme');
        $meme = $repo->find($id);

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
                $comment->setUser($this->getUser());
            }
            $comment->setMeme($meme);
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('lol_show_meme', [
                'id' => $meme->getId()
            ]);
        }

        return $this->render('LolBundle:Meme:show.html.twig', [
                'meme' => $meme,
                'form' => $form->createView()
            ]
        );
    }
}