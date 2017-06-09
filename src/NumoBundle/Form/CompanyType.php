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
        $builder->add('contactEmail', TextType::class, array('label' => 'Email'));
        $builder->add('city', TextType::class, array('label' => 'Ville'));
        $builder->add('postalCode', TextType::class, array('label' => 'Code Postal'));
        $builder->add('adress', TextType::class, array('label' => 'Adresse'));
        $builder->add('phone', TextType::class, array('label' => 'Téléphone'));
//        $builder->add('imageUrl', FileType::class, array('label' => 'Image'));
        $builder->add('pdf', FileType::class, array('label' => 'RIB (PDF File)'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Company::class,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'numobundle_company';
    }


}
