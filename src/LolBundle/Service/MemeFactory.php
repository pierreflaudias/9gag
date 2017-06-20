<?php
/**
 * Created by PhpStorm.
 * User: analbessar
 * Date: 20/06/17
 * Time: 11:16
 */

namespace LolBundle\Service;


use Doctrine\ORM\EntityManager;
use LolBundle\Entity\Meme;
use LolBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;

class MemeFactory
{
    private $em;
    private $container;

    /**
     * MemeCreator constructor.
     * @param ContainerInterface $container
     * @param EntityManager $em
     */
    public function __construct(ContainerInterface $container, EntityManager $em)
    {
        $this->em = $em;
        $this->container = $container;
    }

    /**
     * @param Meme $meme
     * @param User $user
     */
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
}