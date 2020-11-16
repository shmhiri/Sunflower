<?php

namespace ServiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType ;


class ServiceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomService',TextType::class, array(
            'required'   => false,
        ))
            ->add('type',ChoiceType::class, array(
                'choices'=>array
                (  'Service Jardinage'=>"Service Jardinage",
                    'Service agricole'=>"Service agricole",
                    'autre Service'=>"autre Service",
                ),
            ))
            ->add('prix',TextType::class, array(
                'required'   => false,
            ))
            ->add('description',TextareaType::class, array(
                'required'   => false,
            ))
            ->add('etat',TextType::class, array(
                'required'   => false,
            ))

            ->add('region',TextType::class, array(
                'required'   => false,
            ))
            ->add('image',FileType::class,array('label'=>'Image','data_class'=>null))



           ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ServiceBundle\Entity\Service'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'servicebundle_service';
    }


}
