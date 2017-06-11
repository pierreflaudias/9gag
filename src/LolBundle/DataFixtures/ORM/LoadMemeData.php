<?php
/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 08/06/17
 * Time: 22:40
 */

namespace LolBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use LolBundle\Entity\Meme;

class LoadMemeData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $meme1 = new Meme();
        $meme1->setTitle('What an incredible HTTP server');
        $meme1->setImage('126995887f44982c91ef485506a94386.png');
        $meme1->downVote();
        for ($i = 0; $i <= 5; $i++) {
            $meme1->upVote();
        }
        $meme1->setUser($this->getReference('user1'));


        $meme2 = new Meme();
        $meme2->setTitle('Beautiful landscape');
        $meme2->setImage('ae2d99f559df35940b209ad8f29e664b.jpg');
        $meme2->downVote();
        $meme2->downVote();
        for ($i = 0; $i <= 3; $i++) {
            $meme2->upVote();
        }
        $meme2->setUser($this->getReference('user1'));


        $meme3 = new Meme();
        $meme3->setTitle('Nyan cat !');
        $meme3->setImage('a11c6cc8a446e573b2d1f0fa1aa234e1.jpg');
        $meme3->upVote();
        $meme3->upVote();
        for ($i = 0; $i <= 5; $i++) {
            $meme3->downVote();
        }
        $meme3->setUser($this->getReference('user2'));


        $manager->persist($meme1);
        $manager->persist($meme2);
        $manager->persist($meme3);
        $manager->flush();

        $this->addReference('meme1', $meme1);
        $this->addReference('meme2', $meme2);
        $this->addReference('meme3', $meme3);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}