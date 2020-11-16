<?php

namespace PromotionBundle\Form;


use Doctrine\ORM\EntityRepository;
use PromotionBundle\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityManagerInterface;


class PromotionType extends AbstractType
{


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $options['id'];
        $builder->add('nomPromotion')
            ->add('nomAgent')
            ->add('nomProduit')
            ->add('prixHab')
            ->add('pourcentage')
            ->add('dateDebut', DateType::class, ['widget' => 'single_text','format' => 'yyyy-MM-dd'])
            ->add('dateFin', DateType::class, ['widget' => 'single_text','format' => 'yyyy-MM-dd'])
            ->add('description')
            ->add('idProduit',EntityType::class,
                [
                    'class' => Produit::class,



                    'query_builder' => function (EntityRepository $er) use($id) {
                        return $er->createQueryBuilder('p')


                            ->where('p.idAgent= ?1')
                            ->setParameter(1, $id)

                            ;

                    },


                    'choice_label' => 'nomProduit',



                ]


                )
            ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PromotionBundle\Entity\Promotion',
             'id'=> null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'promotionbundle_promotion';
    }


}
