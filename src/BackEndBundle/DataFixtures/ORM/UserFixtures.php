<?php
// src/BackEndBundle/DataFixtures/ORM/UserFixtures.php

namespace BackEndBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class UserFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setFirstName('Mou');
        $user1->setLastName('Uness');
        $user1->setUsername('uness_mou');
        $user1->setEmail('uness.mou@scarpa-team.com');
        $user1->setPlainPassword('pwd');
        $user1->setEnabled(true);
        $user1->setRoles(array('ROLE_ADMIN'));
        $manager->persist($user1);

        $user2 = new User();
        $user2->setFirstName('Seb');
        $user2->setLastName('Fabien');
        $user2->setUsername('fabien_seb');
        $user2->setEmail('fabien.seb@scarpa-team.com');
        $user2->setPlainPassword('pwd');
        $user2->setEnabled(true);
        $manager->persist($user2);

        $manager->flush();

        $this->addReference('user_1', $user1);
        $this->addReference('user_2', $user2);
    }

    public function getOrder()
    {
        return 1;
    }
}