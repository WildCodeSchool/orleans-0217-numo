<?php

namespace NumoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['required' => false])
            ->add('description', TextType::class, ['required' => false])
            ->add('freeText', TextareaType::class, ['required' => false])
            ->add('tags', TextType::class, ['required' => false])
            ->add('image', TextType::class, ['required' => false])
            ->add('placename', TextType::class, ['required' => false])
            ->add('address', TextType::class, ['required' => false])
            ->add('ticketLink', TextType::class, ['required' => false])
            ->add('pricingInfo', TextType::class, ['required' => false])
            ->add('evtDates', CollectionType::class, [
                'entry_type' => EvtDateType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ]);

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
