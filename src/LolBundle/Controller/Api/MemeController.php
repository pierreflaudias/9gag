<?php
/**
 * Created by PhpStorm.
 * User: analbessar
 * Date: 15/06/17
 * Time: 09:53.
 */

namespace LolBundle\Controller\Api;

use LolBundle\Entity\Comment;
use LolBundle\Entity\Meme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MemeController extends Controller
{
    private $serializer;

    /**
     * @inheritdoc
     */
    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->serializer = $this->get('lol.serializer.default');
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        $memes = $this->get('meme_reader')->getAll();

        return new Response($this->serializer->serialize($memes, 'json'), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @param $id
     * @param $note
     * @return JsonResponse
     */
    public function noteAction($id, $note)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $meme = $this->get('meme_reader')->getOneById($id);
        if ($meme != null) {
            $this->get('meme_modifier')->noteOne($meme, $note);

            return new JsonResponse(['message' => $this->getUser()->getUsername().' have marked '.$note.' for '.$meme->getTitle()]);
        } else {
            return new JsonResponse(['message' => 'This LOL doesn\'t exist.'], 404);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function removeAction($id)
    {
        $meme = $this->get('meme_reader')->getOneById($id);
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') || $this->getUser() !== $meme->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $this->get('meme_modifier')->removeOne($meme);

        return new JsonResponse(null, 204);
    }

    /**
     * @param $id
     * @param $comment_id
     * @return JsonResponse
     */
    public function removeCommentAction($id, $comment_id)
    {
        $comment = $this->get('comment_reader')->getOneById($comment_id);
        $meme = $this->get('meme_reader')->getOneById($id);

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') || $this->getUser() !== $meme->getUser() || $this->getUser() !== $comment->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $this->get('meme_modifier')->removeComment($comment);

        return new JsonResponse(null, 204);
    }

    /**
     * @param $id
     * @return JsonResponse|Response
     */
    public function showAction($id)
    {
        $meme = $this->get('meme_reader')->getOneById($id);
        if ($meme == null) {
            return new JsonResponse(['message' => 'This LOL doesn\'t exist.'], 404);
        }

        return new Response($this->serializer->serialize($meme, 'json'), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $data = ['image' => $request->files->get('image'), 'title' => json_decode($request->get('content'))->title];
        $meme = $this->serializer->denormalize($data, Meme::class, 'json');
        $this->get('meme_modifier')->createOne($meme, $this->getUser());

        return new JsonResponse(['message' => 'LOL '.$meme->getId().' created'], 201);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function commentAction(Request $request, $id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $meme = $this->get('meme_reader')->getOneById($id);
        $comment = $this->serializer->deserialize($request->getContent(), Comment::class, 'json');
        $this->get('meme_modifier')->addComment($meme, $this->getUser(), $comment);

        return new JsonResponse(['message' => 'Comment added to LOL '.$meme->getId()], 201);
    }
}
