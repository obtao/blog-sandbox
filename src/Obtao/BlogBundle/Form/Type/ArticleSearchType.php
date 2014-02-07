<?php

namespace Obtao\BlogBundle\Form\Type;

use Obtao\BlogBundle\Model\ArticleSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('dateFrom', 'date', array(
                'required' => false,
                'widget' => 'single_text'
            ))
            ->add('dateTo', 'date', array(
                'required' => false,
                'widget' => 'single_text'
            ))
            ->add('isPublished','choice', array(
                'choices' => array(0=>'non',1=>'oui'),
                'required' => false,
            ))
            ->add('search','submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            // avoid to pass the csrf token in the url (but it's not protected anymore)
            'csrf_protection' => false,
            'data_class' => 'Obtao\BlogBundle\Model\ArticleSearch'
        ));
    }

    public function getName()
    {
        return 'article_search_type';
    }
}