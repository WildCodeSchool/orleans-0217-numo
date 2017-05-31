<?php
/**
 * Created by PhpStorm.
 * User: fanny
 * Date: 31/05/17
 * Time: 10:29
 */

namespace NumoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array('label' => 'Nom'));
        $builder->add('firstname', TextType::class, array('label' => 'Prénom'));
        $builder->add('description');
        $builder->add('imageUrl',FileType::class, array('label' => 'Image'));
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