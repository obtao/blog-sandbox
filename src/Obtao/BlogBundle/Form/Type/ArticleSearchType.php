<?php

namespace Obtao\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',null,array(
                'required' => false,
            ))
            ->add('dateFrom', 'date', array(
                'required' => false,
                'widget' => 'single_text',
            ))
            ->add('dateTo', 'date', array(
                'required' => false,
                'widget' => 'single_text',
            ))
            ->add('published','choice', array(
                'choices' => array('false'=>'non','true'=>'oui'),
                'required' => false,
            ))
            ->add('search','submit',array(
                'attr' => array(
                    'class' => 'btn btn-primary',
                )
            ))
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