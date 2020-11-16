<?php

namespace ForumBundle\Form;

use ForumBundle\Entity\Sujet;
use ForumBundle\ForumBundle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType ;



class SujetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('nomSujet',TextType::class, array(
            'required'   => false,
        ))

                 /*->add('type',EntityType::class, array(
                         'class' => 'ForumBundle:CategorieSujet',
                         'choice_label' => 'type',
                         'multiple'=>false)
                 )*/
                ->add('type',ChoiceType::class,
                    array('choices'=>array
                    (   'Plantation'=>"Plantation",
                        'Entretien'=>"Entretien",
                        'Conseils'=>"Conseils",
                    ),))

                ->add('idCategorieSujet',EntityType::class,array(
                    'class' => 'ForumBundle:CategorieSujet',
                    'choice_label' => 'NomCategorieSujet',
                    'multiple'=>false)
                     )

                ->add('description', TextareaType::class, array(
                'required'   => false,
                    ))
                ->add('image',FileType::class,array('label'=>'Image','data_class'=>null));

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ForumBundle\Entity\Sujet'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'forumbundle_sujet';
    }


}
