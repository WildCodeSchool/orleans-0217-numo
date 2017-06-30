<?php

namespace NumoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Test\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\CallbackValidator;

class SelectEventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod("GET")
            ->add('startDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'invalid_message' => 'Date début de période invalide (format attendu : jj/mm/aaaa). ',
            ])
            ->add('endDate', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'invalid_message' => 'Date fin de période invalide (format attendu : jj/mm/aaaa). ',
            ])
            ->add('category', EntityType::class, [
                'class' => 'NumoBundle:Category',
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => '- Toutes -',
            ])
            ->add('passed', hiddenType::class, [
                'required' => false
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'NumoBundle\Entity\SelectEvent'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'numobundle_select_event';
    }


}
