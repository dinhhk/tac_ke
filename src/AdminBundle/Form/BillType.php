<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class BillType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('total')
            ->add('payment', TextareaType::class)
            ->add('note', TextareaType::class)
            ->add('customer', EntityType::class, array('class' => 'AdminBundle:Customer',
                    'required' => FALSE,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                                  ->orderBy('c.name', 'ASC');
                    },
                    'choice_label' => 'name',
                ))
            ->add('bill_details', CollectionType::class, array(
                'entry_type' => 'AdminBundle\Form\BillDetailType',
                'data' => $options['pagination'],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'prototype_name' => '__name__',
                'by_reference' => false,
                'constraints' => array(new Valid())
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Bill',
            'pagination' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'admin_bill';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'admin_bill';
    }

}
