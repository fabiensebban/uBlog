<?php
// src/BackEndBundle/DataFixtures/ORM/CategoryFixtures.php

namespace BackEndBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Category;

class CategoryFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $category1 = new Category();
        $category1->setDisplayName('Category 1');
        $category1->setNameId('category-1');
        $category1->setCreated(new \DateTime());
        $category1->setUpdated($category1->getCreated());
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setDisplayName('Category 2');
        $category2->setNameId('category-2');
        $category2->setCreated(new \DateTime());
        $category2->setUpdated($category2->getCreated());
        $manager->persist($category2);


        $manager->flush();

        $this->addReference('category_1', $category1);
        $this->addReference('category_2', $category2);
    }

    public function getOrder()
    {
        return 2;
    }
}