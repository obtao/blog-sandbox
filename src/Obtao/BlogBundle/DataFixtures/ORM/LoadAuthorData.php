<?php

namespace Obtao\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Obtao\BlogBundle\DataFixtures\ORM\AbstractFixture;
use Obtao\BlogBundle\Entity\Author;

class LoadAuthorData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $author1 = new Author();
        $author1->setFirstname("Francois");
        $author1->setSurname("francoisg");

        $this->addReference('author_1', $author1);
        $manager->persist($author1);

        $author2 = new Author();
        $author2->setFirstname("Gregory");
        $author2->setSurname("gregquat");

        $this->addReference('author_2', $author2);
        $manager->persist($author2);

        $author3 = new Author();
        $author3->setFirstname("Jb");
        $author3->setSurname("Jibé");

        $this->addReference('author_3', $author3);
        $manager->persist($author3);

        $manager->flush();

    }

    public function getOrder()
    {
        return 1;
    }
}