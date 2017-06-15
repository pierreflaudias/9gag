<?php
/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 08/06/17
 * Time: 23:01
 */

namespace LolBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use LolBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setUsername('admin');
        $user1->setPassword(password_hash('admin', PASSWORD_BCRYPT));
        $user1->setEmail('admin@8lol.com');
        $user1->setApiKey(hash('sha256', $user1->getEmail() . $user1->getPassword()));

        $user2 = new User();
        $user2->setEmail('test@gmail.com');
        $user2->setUsername('test');
        $user2->setPassword(password_hash('test', PASSWORD_BCRYPT));
        $user2->setApiKey(hash('sha256', $user2->getEmail() . $user2->getPassword()));

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->flush();

        $this->addReference('user1', $user1);
        $this->addReference('user2', $user2);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 0;
    }
}