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
        $meme = new Meme();
        $meme->setTitle('Un serveur incroyable');
        $meme->setImage('126995887f44982c91ef485506a94386.png');
        $meme->downVote();
        for ($i = 0; $i <= 5; $i++) {
            $meme->upVote();
        }
        $meme->setUser($this->getReference('user1'));

        $manager->persist($meme);
        $manager->flush();

        $this->addReference('meme1', $meme);
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