<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AdminBundle\Form\ImportDetailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ImportType extends AbstractType
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
            ->add('provider', EntityType::class, array('class' => 'AdminBundle:Provider',
                    'attr' => array('disabled' => 'disabled'),
                    'required' => FALSE,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('s')
                                  ->orderBy('s.name', 'ASC');
                    },
                    'choice_label' => 'name',
                ))
            ->add('import_details', CollectionType::class, array(
                'entry_type' => 'AdminBundle\Form\ImportDetailType',
                'data' => $options['pagination'],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'prototype_name' => '__name__',
                'by_reference' => false,
                'constraints' => array(new Valid())
            ));

        $builder->addEventListener(
            FormEvents::SUBMIT,
            function(FormEvent $event) use ($options) {
                $form = $event->getForm(); // FormInterface
                $data = $event->getData(); 
                $import_details = $data->getImportDetails();
                $total = 0;
                if($import_details) {
                    foreach($import_details as $import_detail) {
                        $quantity = $import_detail->getQuantity();
                        $unitPrice = $import_detail->getUnitPrice();
                        $total += $quantity * $unitPrice;
                    }    
                }
                $form->getData()->setTotal($total);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Import',
            'pagination' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'admin_import';
    }

    public function getName()
    {
        return 'admin_import';
    }
}
