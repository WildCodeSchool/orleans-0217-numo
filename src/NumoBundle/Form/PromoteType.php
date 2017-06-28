<?php
/**
 * Created by PhpStorm.
 * User: fanny
 * Date: 28/06/17
 * Time: 15:41
 */

namespace NumoBundle\Form;

use NumoBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromoteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Roles', ChoiceType::class, [
                'choices' => [
                        'ROLE_USER' => 'ROLE_USER',
                        'ROLE_ADHERENT' => 'ROLE_ADHERENT',
                        'ROLE_MODERATOR' => 'ROLE_MODERATOR',
                        'ROLE_ADMIN' => 'ROLE_ADMIN',
                ]
            ])
            ->add('Ok', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'numobundle_promote';
    }
}