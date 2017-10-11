<?php

namespace NumoBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use NumoBundle\Entity\Category;
use NumoBundle\Entity\PricingInfo;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => false,
            ])
            ->add('description', TextType::class, [
                'required' => false,
            ])
            ->add('freeText', TextareaType::class, [
                'required' => false,
            ])
            ->add('tags', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'required' => true,
            ])
            ->add('image', fileType::class, [
                'required' => false,
            ])
            ->add('placename', TextType::class, [
                'required' => false,
            ])
            ->add('address', TextType::class, [
                'required' => false,
            ])
            ->add('latitude', TextType::class, [
                'required' => false,
            ])
            ->add('longitude', TextType::class, [
                'required' => false,
            ])
            ->add('ticketLink', TextType::class, [
                'required' => false,
            ])
            ->add('pricingInfo', EntityType::class, [
                'class' => PricingInfo::Class,
                'choice_label' => 'pricing',
                'required' => true,
            ])
            ->add('evtDates', CollectionType::class, [
                'entry_type' => EvtDateCollectionType::class,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'NumoBundle\Entity\Event',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'numobundle_event';
    }


}
