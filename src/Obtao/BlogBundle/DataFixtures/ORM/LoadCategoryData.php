<?php

namespace Obtao\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Obtao\BlogBundle\DataFixtures\ORM\AbstractFixture;
use Obtao\BlogBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $category1 = new Category();
        $category1->setLabel("Android and API");

        $this->addReference('category_1', $category1);
        $manager->persist($category1);


        $category2 = new Category();
        $category2->setLabel("Elasticsearch");

        $this->addReference('category_2', $category2);
        $manager->persist($category2);


        $category3 = new Category();
        $category3->setLabel("Symfony2");

        $this->addReference('category_3', $category3);
        $manager->persist($category3);


        $category4 = new Category();
        $category4->setLabel("Java");

        $this->addReference('category_4', $category4);
        $manager->persist($category4);

        $manager->flush();

    }

    public function getOrder()
    {
        return 2;
    }
}