<?php

namespace AvisserviceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class AvisServiceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomAvis',TextType::class, array(
            'required'   => false,
        ))
            ->add('commentaire',TextareaType::class, array(
                'required'   => false,
            ))
            ->add('rating',ChoiceType::class, array(
                'choices'=>array
                (  '0'=>"0",
                    '1'=>"1",
                    '2'=>"2",
                    '3'=>"3",
                    '4'=>"4",
                    '5'=>"5",
                ),
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AvisserviceBundle\Entity\AvisService'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'avisservicebundle_avisservice';
    }


}
