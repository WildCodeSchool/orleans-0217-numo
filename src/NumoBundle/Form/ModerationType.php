<?php
/**
 * Created by PhpStorm.
 * User: wilder9
 * Date: 06/07/17
 * Time: 10:13
 */

namespace NumoBundle\Form;


use NumoBundle\Entity\ModerationRefusal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModerationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label'=> 'Nom de l\'événement:'
            ])
            ->add('contactEmail', TextType::class, [
                'label' => 'Email de l\'auteur'
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Raisons du refus :'
            ])
            ->add('eventId', HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ModerationRefusal::class,
        ]);
    }

}