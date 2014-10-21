<?php

namespace Obtao\BlogBundle\Form\Type;

use Obtao\BlogBundle\Model\ArticleSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleSearchType extends AbstractType
{
    protected $perPage = 5;
    protected $perPageChoices = array(2,5,10);


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // the perPage choices list is hard coded. In a real project, you won't do like that
        $perPageChoices = array();
        foreach($this->perPageChoices as $choice){
            $perPageChoices[$choice] = 'Display '.$choice.' items';
        }

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
                'choices' => array('false'=>'no','true'=>'yes'),
                'required' => false,
            ))
            ->add('sort', 'text', array(
                'required' => false,
            ))
            ->add('direction', 'text', array(
                'required' => false,
            ))
            ->add('sortSelect','choice',array(
                'choices' => ArticleSearch::$sortChoices,
            ))
            ->add('perPage', 'choice', array(
                'choices' => $perPageChoices,
            ))
            ->add('search','submit',array(
                'attr' => array(
                    'class' => 'btn btn-primary',
                )
            ))
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                // emulate sortSelect submission to prefill the field
                $articleSearch = $event->getData();

                if(array_key_exists('sort',$articleSearch) && array_key_exists('direction',$articleSearch)){
                    $articleSearch['sortSelect'] = $articleSearch['sort'].' '.$articleSearch['direction'];
                }else{
                    $articleSearch['sortSelect'] = '';
                }

                $event->setData($articleSearch);
            })
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
   {
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
