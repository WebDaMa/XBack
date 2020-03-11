<?php

namespace App\Form;

use App\Entity\ExportPeriodAndLocation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExportPeriodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $periods = [];
        if(isset($options['periods'])) {
            $periods = $options['periods'];
        }

        $builder
            ->add('period', ChoiceType::class, [
                'choices' => $periods,
            ])
            ->add('export', SubmitType::class, array('label' => 'Export', 'attr' => ['class' => 'btn btn-primary']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => ExportPeriodAndLocation::class,
            'periods' => []
        ]);
    }
}
