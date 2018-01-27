<?php

namespace App\Form;

use App\Entity\BOUpload;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BOUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('boPeriodFile', FileType::class, array('label' => 'BO lijst (Excel file)'))
            ->add('import', SubmitType::class, array('label' => 'Import', 'attr' => ['class' => 'btn btn-primary']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => BOUpload::class,
        ]);
    }
}
