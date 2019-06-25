<?php

namespace App\Form;

use App\Entity\ExportPeriodAndLocation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExportPeriodAndLocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $periods = [];
        if(isset($options['periods'])) {
            $periods = $options['periods'];
        }

        $locations = [];
        if(isset($options['locations'])) {
            $locations = $options['locations'];
        }

        $builder
            ->add('period', ChoiceType::class, [
                'choices' => $periods,
            ])
            ->add('location', ChoiceType::class, [
                'choices' => $locations,
            ])
            ->add('export', SubmitType::class, array('label' => 'Export', 'attr' => ['class' => 'btn btn-primary']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => ExportPeriodAndLocation::class,
            'periods' => [],
            'locations' => []
        ]);
    }
}
