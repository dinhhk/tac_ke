<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class TypeProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', EntityType::class, array('class' => 'AdminBundle:Type',
                    'required' => FALSE,
                    'choice_label' => 'name',
                ))
            // ->add('size', EntityType::class, array('class' => 'AdminBundle:Size',
            //         'required' => FALSE,
            //         'query_builder' => function (EntityRepository $er) {
            //             return $er->createQueryBuilder('s');
            //         },
            //         //'multiple' => TRUE,
            //         'choice_label' => 'name'
            //     ))
            ->add('unit', EntityType::class, array('class' => 'AdminBundle:Unit',
                    'required' => FALSE,
                    'choice_label' => 'name',
                ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\TypeProduct'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'admin_typeproduct';
    }


}
