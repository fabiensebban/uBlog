<?php
// src/BackEndBundle/DataFixtures/ORM/PostFixtures.php

namespace BackEndBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Post;

class PostFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $post1 = new Post();
        $post1->setTitle('Title of post 1');
        $post1->setBody('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut velocity magna. Etiam vehicula nunc non leo hendrerit commodo. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras el mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras elementum molestie vestibulum. Morbi id quam nisl. Praesent hendrerit, orci sed elementum lobortis, justo mauris lacinia libero, non facilisis purus ipsum non mi. Aliquam sollicitudin, augue id vestibulum iaculis, sem lectus convallis nunc, vel scelerisque lorem tortor ac nunc. Donec pharetra eleifend enim vel porta.');
        $post1->setAuthor($manager->merge($this->getReference('user_1')));
        $post1->setCategory($manager->merge($this->getReference('category_1')));
        $post1->setImage('post1.jpg');
        $post1->setTags('post1, symfony, esgi');
        $post1->setSlug($post1->getTitle());
        $post1->setLikes(2);
        $post1->setShares(0);
        $post1->setIsPublished(true);
        $post1->setIsApproved(true);
        $post1->setCreated(new \DateTime());
        $post1->setUpdated($post1->getCreated());
        $manager->persist($post1);


        $post2 = new Post();
        $post2->setTitle('Title of post 2');
        $post2->setBody('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut velocity magna. Etiam vehicula nunc non leo hendrerit commodo. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras el mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras elementum molestie vestibulum. Morbi id quam nisl. Praesent hendrerit, orci sed elementum lobortis, justo mauris lacinia libero, non facilisis purus ipsum non mi. Aliquam sollicitudin, augue id vestibulum iaculis, sem lectus convallis nunc, vel scelerisque lorem tortor ac nunc. Donec pharetra eleifend enim vel porta.');
        $post2->setAuthor($manager->merge($this->getReference('user_2')));
        $post2->setCategory($manager->merge($this->getReference('category_2')));
        $post2->setImage('post2.jpg');
        $post2->setTags('post2, symfony, esgi');
        $post2->setSlug($post2->getTitle());
        $post2->setLikes(5);
        $post2->setShares(2);
        $post2->setIsPublished(true);
        $post2->setIsApproved(true);
        $post2->setCreated(new \DateTime());
        $post2->setUpdated($post2->getCreated());
        $manager->persist($post2);

        $manager->flush();

        $this->addReference('post_1', $post1);
        $this->addReference('post_2', $post2);
    }

    public function getOrder()
    {
        return 3;
    }
}