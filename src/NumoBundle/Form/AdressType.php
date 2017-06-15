<?php

namespace NumoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdressType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('addr1', TextType::class, array('label' => 'Adr 1', 'required' => false))
            ->add('addr2', TextType::class, array('label' => 'Adr 2', 'required' => false))
            ->add('postalCode', TextType::class, array('label' => 'Code Postal', 'required' => false))
            ->add('city', TextType::class, array('label' => 'Ville', 'required' => false))
            ->remove('geoLat')
            ->remove('geoLng');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NumoBundle\Entity\Adress'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'numobundle_adress';
    }


}
