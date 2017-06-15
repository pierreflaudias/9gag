<?php
/**
 * Created by PhpStorm.
 * User: analbessar
 * Date: 12/06/17
 * Time: 14:39
 */

namespace LolBundle\Controller;



use LolBundle\Entity\Meme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;


class BaseMemeController extends Controller
{
    private $negotiator;
    protected $serializer;

    protected $memes;
    protected $currentMeme;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->negotiator = $this->get('negotiator');
        $this->serializer = $this->get('lol.serializer.default');
    }

    public function indexAction(Request $request)
    {
        $this->memes = $this->getDoctrine()->getRepository('LolBundle:Meme')
            ->findBy([],['date' => 'DESC'], 5, 0);
    }

    public function noteAction($id, $note){
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        $repo =$em->getRepository('LolBundle:Meme');
        $this->currentMeme = $repo->find($id);
        if ($note == 'upvote') {
            $this->currentMeme->upVote();
        } elseif ($note == 'downvote') {
            $this->currentMeme->downVote();
        }
        $em->persist($this->currentMeme);
        $em->flush();
    }

    public function showAction(Request $request, $id)
    {
        $repo = $this->getDoctrine()->getRepository('LolBundle:Meme');
        $this->currentMeme = $repo->find($id);
    }

    public function createAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $this->currentMeme = new Meme();
    }
}