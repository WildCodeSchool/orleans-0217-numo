<?php

namespace NumoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('required' => false))
            ->add('description', TextType::class, array('required' => false))
            ->add('freeText', TextareaType::class, array('required' => false))
            ->add('tags', TextType::class, array('required' => false))
            ->add('image', fileType::class, array('required' => false))
            ->add('placename', TextType::class, array('required' => false))
            ->add('address', TextType::class, array('required' => false))
            ->add('latitude', TextType::class, array('required' => false))
            ->add('longitude', TextType::class, array('required' => false))
            ->add('ticketLink', TextType::class, array('required' => false))
            ->add('pricingInfo', TextType::class, array('required' => false))
            ->add('evtDates', CollectionType::class, array(
                'entry_type' => EvtDateCollectionType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NumoBundle\Entity\Event'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'numobundle_event';
    }


}
