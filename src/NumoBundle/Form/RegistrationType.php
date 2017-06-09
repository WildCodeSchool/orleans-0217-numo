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
        $builder->add('name', TextType::class, array('label' => 'Nom'));
        $builder->add('firstname', TextType::class, array('label' => 'Prénom'));
        $builder->add('description', TextareaType::class, array('label' => 'Description', 'required' => false));
        $builder->add('imageUrl',FileType::class, array('label' => 'Image', 'required' => false));
        $builder->add('trust',HiddenType::class);
        $builder->add('freeText',HiddenType::class);
        $builder->add('phone',HiddenType::class);
        $builder->add('webSite',HiddenType::class);
        $builder->add('adress',HiddenType::class);
        $builder->remove('username');

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
