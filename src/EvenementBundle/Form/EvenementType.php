<?php

namespace EvenementBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
class EvenementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomEvenement')
            ->add('pseudoAdmin')
            ->add('type',ChoiceType::class, array(
                'choices'=>array
                (  'animation'=>"animation",
                    'competition'=>"competition",
                    'visite guide'=>"visite guide",
                ),))
            ->add('lieu')
            ->add('dateDebut', DateType::class, ['widget' => 'single_text','format' => 'yyyy-MM-dd'])
            ->add('dateFin', DateType::class, ['widget' => 'single_text','format' => 'yyyy-MM-dd'])
            ->add('description',TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('path',FileType::class,array( 'data_class' => null))
            ->add('max');
           /** ->add('idAdmin',EntityType::class,
                array(

                    'class' => 'EvenementBundle:User',

                    'choice_label' => 'id',
                    'multiple' => false
                )); */
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EvenementBundle\Entity\Evenement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'evenementbundle_evenement';
    }


}
