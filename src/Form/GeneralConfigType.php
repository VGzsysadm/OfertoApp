<?php

namespace App\Form;

use App\Entity\GeneralConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class GeneralConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('siteName')
            ->add('logo', FileType::class, array('label' => false, 'data_class' => null))
            ->add('facebook')
            ->add('twitter')
            ->add('instagram')
            ->add('telegram')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GeneralConfig::class,
        ]);
    }
}
