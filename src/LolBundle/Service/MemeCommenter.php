<?php
/**
 * Created by PhpStorm.
 * User: analbessar
 * Date: 20/06/17
 * Time: 11:46
 */

namespace LolBundle\Service;


use Doctrine\ORM\EntityManager;
use LolBundle\Entity\Comment;
use LolBundle\Entity\Meme;
use LolBundle\Entity\User;

class MemeCommenter
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function addComment(Meme $meme, User $user, Comment $comment)
    {
        $comment->setUser($user);
        $comment->setMeme($meme);
        $this->em->persist($comment);
        $this->em->flush();
    }

    public function removeComment(Comment $comment)
    {
        $this->em->remove($comment);
        $this->em->flush();
    }

}