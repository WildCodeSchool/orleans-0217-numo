<?php

namespace NumoBundle\Form;

use NumoBundle\Entity\Adress;
use NumoBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Nom'
            ))
            ->add('firstname', TextType::class, array(
                'label' => 'Prénom'
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Description',
                'required' => false
            ))
            ->add('imageUrl',FileType::class, array(
                'data_class' => null,
                'label' => 'Image',
                'required' => false
            ))
            ->add('freeText',TextareaType::class, array(
                'label' => 'Présentation',
                'required' => false
            ))
            ->add('phone',TextType::class, array(
                'label' => 'Téléphone',
                'required' => false
            ))
            ->add('webSite',TextType::class, array(
                'label' => 'Site Web',
                'required' => false
            ))
            ->add('adress',AddressType::class, array(
                'label' => 'Adresse',
                'required' => false
            ))
            ->remove('username');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }
}