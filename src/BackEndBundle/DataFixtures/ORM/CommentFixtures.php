<?php
// src/BackEndBundle/DataFixtures/ORM/CommentFixtures.php

namespace BackEndBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Comment;

class CommentFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cmt1 = new Comment();
        $cmt1->setContent('1111 Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut velocity magna. Etiam vehicula nunc non leo hendrerit commodo.');
        $cmt1->setAuthor($manager->merge($this->getReference('user_2')));
        $cmt1->setPost($manager->merge($this->getReference('post_1')));
        $cmt1->setLikes(11);
        $cmt1->setCreated(new \DateTime());
        $cmt1->setUpdated($cmt1->getCreated());
        $manager->persist($cmt1);

        $cmt2 = new Comment();
        $cmt2->setContent('2222 Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut velocity magna. Etiam vehicula nunc non leo hendrerit commodo.');
        $cmt2->setAuthor($manager->merge($this->getReference('user_2')));
        $cmt2->setPost($manager->merge($this->getReference('post_2')));
        $cmt2->setLikes(1);
        $cmt2->setCreated(new \DateTime());
        $cmt2->setUpdated($cmt2->getCreated());
        $manager->persist($cmt2);

        $cmt3 = new Comment();
        $cmt3->setContent('3333 Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut velocity magna. Etiam vehicula nunc non leo hendrerit commodo.');
        $cmt3->setAuthor($manager->merge($this->getReference('user_2')));
        $cmt3->setPost($manager->merge($this->getReference('post_2')));
        $cmt3->setLikes(1);
        $cmt3->setCreated(new \DateTime());
        $cmt3->setUpdated($cmt3->getCreated());
        $manager->persist($cmt3);

        $manager->flush();

        $this->addReference('comment_1', $cmt1);
        $this->addReference('comment_2', $cmt2);
        $this->addReference('comment_3', $cmt3);
    }

    public function getOrder()
    {
        return 4;
    }
}