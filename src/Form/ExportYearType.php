<?php

namespace App\Form;

use App\Entity\ExportPeriodAndLocation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExportYearType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $years = [];
        if(isset($options['years'])) {
            $years = $options['years'];
        }

        $builder
            ->add('period', ChoiceType::class, [
                'choices' => $years,
                'attr' => ['data-widget' => 'select2']
            ])
            ->add('export', SubmitType::class, array('label' => 'Export', 'attr' => ['class' => 'btn btn-primary']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => ExportPeriodAndLocation::class,
            'years' => []
        ]);
    }
}
