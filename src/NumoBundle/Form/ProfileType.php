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
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('imageUrl',FileType::class, [
                'data_class' => null,
                'label' => 'Image',
                'required' => false,
            ])
            ->add('freeText',TextareaType::class, [
                'label' => 'Présentation',
                'required' => false,
            ])
            ->add('phone',TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('webSite',TextType::class, [
                'label' => 'Site Web',
                'required' => false,
            ])
            ->add('address',AddressType::class, [
                'label' => 'Adresse',
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