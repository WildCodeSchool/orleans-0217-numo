<?php
/**
 * Created by PhpStorm.
 * User: wilder9
 * Date: 06/07/17
 * Time: 10:13
 */

namespace NumoBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use NumoBundle\Entity\Contact;


class ModerationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', HiddenType::class)
            ->add('contactEmail', HiddenType::class)
            ->add('comment', TextareaType::class, [
                'label' => 'Raisons du refus :'
            ])
            ->add('id', HiddenType::class);
    }
}