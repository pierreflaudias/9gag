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

class MemeNote
{
    private $em;

    /**
     * MemeModifier constructor.
     *
     * @param EntityRepository $repository
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
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

}
