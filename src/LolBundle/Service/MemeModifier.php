<?php
/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 17/06/17
 * Time: 17:31.
 */

namespace LolBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use LolBundle\Entity\Comment;
use LolBundle\Entity\Meme;
use LolBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;

class MemeModifier
{
    private $em;
    private $container;

    /**
     * MemeModifier constructor.
     *
     * @param EntityRepository $repository
     */
    public function __construct(ContainerInterface $container, EntityManager $em)
    {
        $this->em = $em;
        $this->container = $container;
    }

    /**
     * @param Meme $meme
     * @param $note
     */
    public function noteOne(Meme $meme, $note)
    {
        if ($note == 'upvote') {
            $meme->upVote();
        } elseif ($note == 'downvote') {
            $meme->downVote();
        }
        $this->em->persist($meme);
        $this->em->flush();
    }

    public function createOne(Meme $meme, User $user)
    {
        $image = $meme->getImage();
        $file_name = md5(uniqid()).'.'.$image->guessExtension();
        $image->move(
            $this->container->getParameter('memes_images_directory'),
            $file_name
        );
        $meme->setImage($file_name);
        $meme->setUser($user);
        $this->em->persist($meme);
        $this->em->flush();
    }

    public function removeOne(Meme $meme)
    {
        $fs = new Filesystem();
        $fs->remove($this->container->getParameter('memes_images_directory').'/'.$meme->getImage());
        foreach ($meme->getComments() as $comment) {
            $this->em->remove($comment);
        }
        $this->em->remove($meme);
        $this->em->flush();
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
