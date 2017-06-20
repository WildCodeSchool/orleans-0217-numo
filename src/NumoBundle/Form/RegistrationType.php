<?php


namespace NumoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;



class RegistrationType extends AbstractType
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
                'label' => 'Image',
                'required' => false,
            ])
            ->add('trust', HiddenType::class)
            ->add('freeText', HiddenType::class)
            ->add('phone', HiddenType::class)
            ->add('webSite', HiddenType::class)
            ->remove('address')
            ->remove('username');

    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
}
