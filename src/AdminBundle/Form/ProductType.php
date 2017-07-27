<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('file', FileType::class)
            ->add('price')
            ->add('size', EntityType::class, array('class' => 'AdminBundle:Size',
                    'required' => FALSE,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('s')
                                  ->orderBy('s.name', 'ASC');
                    },
                    'choice_label' => 'name',
                ))
            ->add('type', EntityType::class, array('class' => 'AdminBundle:Type',
                    'required' => FALSE,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('t')
                                  ->orderBy('t.name', 'ASC');
                    },
                    'choice_label' => 'name',
                ))
            ->add('unit', EntityType::class, array('class' => 'AdminBundle:Unit',
                    'required' => FALSE,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                                  ->orderBy('u.name', 'ASC');
                    },
                    'choice_label' => 'name',
                ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'admin_product';
    }


}
