<?php

namespace NumoBundle\Form;

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
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'validation_groups' => ['Registration', 'Profile'],
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'validation_groups' => ['Registration', 'Profile'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'validation_groups' => ['Registration', 'Profile'],
                'required' => false,
            ])
            ->add('imageUrl',FileType::class, [
                'data_class' => null,
                'label' => 'Image',
                'validation_groups' => ['Registration', 'Profile'],
                'required' => false,
            ])
            ->add('freeText',TextareaType::class, [
                'label' => 'Présentation',
                'validation_groups' => ['Registration', 'Profile'],
                'required' => false,
            ])
            ->add('phone',TextType::class, [
                'label' => 'Téléphone',
                'validation_groups' => ['Registration', 'Profile'],
                'required' => false,
            ])
            ->add('webSite',TextType::class, [
                'label' => 'Site Web',
                'validation_groups' => ['Registration', 'Profile'],
                'required' => false,
            ])
            ->add('facebook',TextType::class, [
                'label' => 'Lien Facebook',
                'validation_groups' => ['Registration', 'Profile'],
                'required' => false,
            ])
            ->add('twitter',TextType::class, [
                'label' => 'Lien Twitter',
                'validation_groups' => ['Registration', 'Profile'],
                'required' => false,
            ])
            ->add('linkedin',TextType::class, [
                'label' => 'Lien Linkedin',
                'validation_groups' => ['Registration', 'Profile'],
                'required' => false,
            ])

            ->remove('username');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
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