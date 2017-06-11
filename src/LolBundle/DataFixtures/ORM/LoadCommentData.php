<?php
/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 10/06/17
 * Time: 20:32
 */

namespace LolBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use LolBundle\Entity\Comment;

class LoadCommentData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $comment1 = new Comment();
        $comment1->setContent('So powerful !');
        $comment1->setMeme($this->getReference('meme1'));
        $comment1->setUser($this->getReference('user1'));

        $comment2 = new Comment();
        $comment2->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vel massa ornare, ultricies leo ut, fermentum nisl. Donec facilisis velit vel lorem suscipit molestie. Etiam leo odio, rutrum non malesuada nec, consequat eget massa. Integer feugiat auctor leo, eu fringilla felis blandit non. Nulla interdum suscipit metus nec auctor.');
        $comment2->setMeme($this->getReference('meme1'));
        $comment2->setUser($this->getReference('user2'));

        $comment3 = new Comment();
        $comment3->setContent('I love this cat !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! <3');
        $comment3->setMeme($this->getReference('meme3'));
        $comment3->setUser($this->getReference('user2'));

        $manager->persist($comment1);
        $manager->persist($comment2);
        $manager->persist($comment3);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}