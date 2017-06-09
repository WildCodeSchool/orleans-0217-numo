<?php
/**
 * Created by PhpStorm.
 * User: fanny
 * Date: 31/05/17
 * Time: 10:29
 */

namespace NumoBundle\Form;

use NumoBundle\Entity\User;
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
        $builder->add('name', TextType::class, array('label' => 'Nom'));
        $builder->add('firstname', TextType::class, array('label' => 'Prénom'));
        $builder->add('description', TextareaType::class, array('label' => 'Description', 'required' => false));
        $builder->add('imageUrl',FileType::class, array('data_class' => null, 'label' => 'Image', 'required' => false));
        $builder->remove('username');
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