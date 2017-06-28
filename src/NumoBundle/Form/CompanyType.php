<?php

namespace NumoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            ->add('phone', TextType::class, [
                'label' => 'Téléphone',
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
            ->add('presentationTitle', TextType::class, [
                'label' => 'Titre (présentation de l\'association)',
            ])
            ->add('presentationContent', TextareaType::class, [
                'label' => 'Contenu (présentation de l\'association)',
            ])
            ->add('adherentTitle', TextType::class, [
                'label' => 'Titre (adhésion à Num\'O)',
            ])
            ->add('adherentContent', TextareaType::class, [
                'label' => 'Contenu (adhésion à Num\'O)',
            ])
            ->add('imageUrl', FileType::class, [
                'label'=>'Modifier le logo de Num\'O',
            ])
            ->add('pdf', FileType::class, [
                'label' => 'Modifier le RIB de l\'association',
            ])
            ;
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
/*    public function getBlockPrefix()
    {
        return 'numobundle_company';
    }
*/

}
