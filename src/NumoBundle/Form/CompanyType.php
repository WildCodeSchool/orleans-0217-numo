<?php

namespace NumoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use NumoBundle\Entity\Company;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CompanyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contactEmail', TextType::class, [
                'label' => 'Email',
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Code Postal',
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
            ])
            ->add('phone', TextType::class, ['
            label' => 'Téléphone',
            ])
            ->add('imageUrl', FileType::class, [
                'label' => 'Image',
            ])
            ->add('pdf', FileType::class, [
                'label' => 'RIB (PDF File)',
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'numobundle_company';
    }


}
