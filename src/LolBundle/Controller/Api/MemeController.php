<?php
/**
 * Created by PhpStorm.
 * User: analbessar
 * Date: 15/06/17
 * Time: 09:53
 */

namespace LolBundle\Controller\Api;


use LolBundle\Controller\BaseMemeController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MemeController extends BaseMemeController
{
    public function indexAction(Request $request)
    {
        parent::indexAction($request);
        return new Response($this->serializer->serialize($this->memes, 'json'), 200, ['Content-Type' => 'application/json']);
    }

    public function noteAction($id, $note)
    {
        parent::noteAction($id, $note);
        if ($this->currentMeme == null) {
            return new JsonResponse(json_encode(['message' => 'This LOL doesn\'t exist.']), 404);
        }
        return new JsonResponse(['message' => 'You have marked ' . $note . ' for ' . $this->currentMeme->getTitle()]);
    }

    public function showAction(Request $request, $id)
    {
        parent::showAction($request, $id);
        if ($this->currentMeme == null) {
            return new Response(json_encode(['message' => 'This LOL doesn\'t exist.']), 404, ['Content-Type' => 'application/json']);
        }
        return new Response($this->serializer->serialize($this->currentMeme, 'json'), 200, ['Content-Type' => 'application/json']);
    }

    public function createAction(Request $request)
    {
        parent::createAction($request);
        var_dump($request->getMethod());
        if ($request->getMethod() != 'POST') {
            //throw $this->c
        }
        var_dump($request->getContent());
        die;
    }
}