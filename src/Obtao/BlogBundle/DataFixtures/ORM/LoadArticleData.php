<?php

namespace Obtao\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Obtao\BlogBundle\Entity\Article;

class LoadArticleData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $article1 = new Article();
        $article1->setTitle('Export datas to a csv file with Symfony2');
        $article1->addAuthor($this->getReference('author_1'));
        $article1->addAuthor($this->getReference('author_2'));
        $article1->setCategory($this->getReference('category_3'));
        $article1->setContent(
            'I recently had to export a huge set of data to a csv file. This is easy and fast to do if you don’t care about memory and User Experience. I wanted the memory consumption does not increase with the volume of data.
            I got inspiration from this post (in French) but, in spite of what is written in the post, some tests with the memory_get_usage function proved that the memory consumption increased quickly with the number of datas.
        ');
        $article1->setTags(array('CSV','Symfony2'));

        $this->addReference('article_1', $article1);
        $manager->persist($article1);


        $article2 = new Article();
        $article2->setPublishedAt(\DateTime::createFromFormat('Y-m-d H:i:s', '2013-09-24 13:53:00'));
        $article2->setTitle('How to use WSSE in Android app');
        $article2->addAuthor($this->getReference('author_3'));
        $article2->addAuthor($this->getReference('author_1'));
        $article2->setCategory($this->getReference('category_1'));
        $article2->setContent(
            'After publishing an article about WSSE configuration in Symfony2, we received a lot of questions about using WSSE in Android application. We hope this article will answer some of these questions!
            Note that we will only speak about WSSE and not about designing a rest client in Android application.
        ');
        $article2->setTags(array('WSSE','Android'));

        $this->addReference('article_2', $article2);
        $manager->persist($article2);


        $article3 = new Article();
        $article3->setPublishedAt(\DateTime::createFromFormat('Y-m-d H:i:s', '2013-09-13 10:57:00'));
        $article3->setTitle('Create a custom form theme block with Twig');
        $article3->addAuthor($this->getReference('author_2'));
        $article3->setCategory($this->getReference('category_3'));
        $article3->setContent(
            'I wanted to use the following block. As you see, in addition to the specific p element, the div and their specific classes, the big difference with the native Twig form_row method is that the radio labels are not in a label tag (but there is a label tag for the parent form field).
        ');
        $article3->setTags(array('Twig','Symfony2'));

        $this->addReference('article_3', $article3);
        $manager->persist($article3);


        $article4 = new Article();
        $article4->setPublishedAt(\DateTime::createFromFormat('Y-m-d H:i:s', '2013-10-17 11:34:00'));
        $article4->setTitle('Efficient Elasticsearch indexing configuration');
        $article4->addAuthor($this->getReference('author_1'));
        $article4->addAuthor($this->getReference('author_2'));
        $article4->setCategory($this->getReference('category_2'));
        $article4->setContent(
            'This post is about elasticsearch which is a great search engine.
            The biggest difficulty we meet is that we do not know how to configure it to have relevant search results. Another difficulty is (sorry to say that), the documentation is not very well done. Ok, it’s my opinion and I can’t denied we found usefull information in it, but information are sometimes difficult to find.
        ');
        $article4->setTags(array('Elasticsearch'));

        $this->addReference('article_4', $article4);
        $manager->persist($article4);


        $article5 = new Article();
        $article5->setTitle('Configure WSSE on Symfony2 with FOSRestBundle');
        $article5->addAuthor($this->getReference('author_1'));
        $article5->addAuthor($this->getReference('author_3'));
        $article5->setCategory($this->getReference('category_1'));
        $article5->setContent(
            'The client–server communication is further constrained by no client context being stored on the server between requests. Each request from any client contains all of the information necessary to service the request, and any session state is held in the client.
        ');
        $article5->setTags(array('Symfony2','WSSE'));

        $this->addReference('article_5', $article5);
        $manager->persist($article5);


        $article6 = new Article();
        $article6->setPublishedAt(\DateTime::createFromFormat('Y-m-d H:i:s', '2013-06-21 16:24:00'));
        $article6->setTitle('How to keep your translations well organized in Symfony2');
        $article6->addAuthor($this->getReference('author_2'));
        $article6->setCategory($this->getReference('category_3'));
        $article6->setContent(
            'We are working at the moment on a big internationalized project, and we have consequently many translations in our application. These translations are dispatched in many bundles (7 for now) and are used throughout the application. At the begining of the development, we hadn’t any specific organisation for the translations and we put the translation in a random bundle (the one on which we were working, most of the time).'
        );
        $article6->setTags('Symfony2');

        $this->addReference('article_6', $article6);
        $manager->persist($article6);


        $article7 = new Article();
        $article7->setPublishedAt(\DateTime::createFromFormat('Y-m-d H:i:s', '2013-05-31 15:13:00'));
        $article7->setTitle('Install Rest in Symfony2 existing application');
        $article7->addAuthor($this->getReference('author_1'));
        $article7->setCategory($this->getReference('category_1'));
        $article7->setContent(
            'As we needed a connection between a Symfony2 web application and an Android application, we had to learn and understand how to make this in a simple and secured way, based on our existing entities.
            We chose WSSE for security access, FOSRestBundle for datas restitution and JMSSerializerBundle for serialization. 
        ');
        $article7->setTags(array('Symfony2','REST'));

        $this->addReference('article_7', $article7);
        $manager->persist($article7);


        $article8 = new Article();
        $article8->setPublishedAt(\DateTime::createFromFormat('Y-m-d H:i:s', '2013-04-21 11:44:00'));
        $article8->setTitle('DateTimePicker field type with Symfony2 and jQuery');
        $article8->setCategory($this->getReference('category_3'));
        $article8->addAuthor($this->getReference('author_1'));
        $article8->setContent(
            'In this third post, we’ll explain how to create a great custom field type that uses jQuery DatePicker to handle date input, and then, how to extend it to create a datetime field type. And the best? The datepicker is localized according to the user’s locale.
        ');
        $article8->setTags(array('Symfony2','jQuery'));

        $this->addReference('article_8', $article8);
        $manager->persist($article8);


        $article9 = new Article();
        $article9->setTitle('Currency Change rates update on Symfony2 using openexchangerates.org API');
        $article9->addAuthor($this->getReference('author_1'));
        $article9->setCategory($this->getReference('category_3'));
        $article9->setContent(
            'In this post, we’ll explain how to create and maintain a database with currencies and change rates.
            In order to update our changes rates, we will user openexchangerates.org solution. (Exists as free, premium and pro)
        ');
        $article9->setTags(array('Symfony2','Currency'));

        $this->addReference('article_9', $article9);
        $manager->persist($article9);


        $article10 = new Article();
        $article10->setPublishedAt(\DateTime::createFromFormat('Y-m-d H:i:s', '2012-11-05 11:00:00'));
        $article10->setTitle('Create a breadcrumb menu with KnpMenuBundle');
        $article10->addAuthor($this->getReference('author_2'));
        $article10->setCategory($this->getReference('category_3'));
        $article10->setContent(
            'In this first post, I’ll explain how to make a breadcrumb menu with the great KnpMenuBundle. The documentation explains the basics and how to make a common menu, but a breadcrumb menu has a particular behaviour.
        ');
        $article10->setTags(array('Symfony2','KnpMenuBundle'));

        $this->addReference('article_10', $article10);
        $manager->persist($article10);


        $article11 = new Article();
        $article11->setPublishedAt(\DateTime::createFromFormat('Y-m-d H:i:s', '2013-05-29 17:39:00'));
        $article11->setTitle('Create new log file/channel for a Symfony2 Service (With monolog)');
        $article11->addAuthor($this->getReference('author_2'));
        $article11->addAuthor($this->getReference('author_3'));
        $article11->setCategory($this->getReference('category_3'));
        $article11->setContent(
            'In this article about WSSE and Rest, we describe how to create a new log file/channel with monolog in Symfony2
        ');
        $article11->setTags(array('WSSE','REST','Symfony2'));

        $this->addReference('article_11', $article11);
        $manager->persist($article11);


        $article12 = new Article();
        $article12->setTitle('Java');
        $article12->addAuthor($this->getReference('author_3'));
        $article12->setCategory($this->getReference('category_4'));
        $article12->setContent(
            'What is Java ?'
        );
        $article12->setTags(array('Java'));

        $this->addReference('article_12', $article12);
        $manager->persist($article12);

        $manager->flush();

    }

    public function getOrder()
    {
        return 3;
    }
}