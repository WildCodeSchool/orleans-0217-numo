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
                'label' => 'Présentation de l\'association (titre)',
            ])
            ->add('presentationContent', TextareaType::class, [
                'label' => 'Présentation de l\'association (contenu)',
            ])
            ->add('adherentTitle', TextType::class, [
                'label' => 'Adhérer à Num\'O (titre)',
            ])
            ->add('adherentContent', TextareaType::class, [
                'label' => 'Adhérer à Num\'O (contenu)',
            ])
            ->add('imageUrl', FileType::class, [
                'label'=>'Uploader le logo de Num\'O',
            ])
            ->add('pdf', FileType::class, [
                'label' => 'Uploader le RIB de l\'association',
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
