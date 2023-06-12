<?php

namespace App\Form\administrator\car;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand', TextType::class)
            ->add('model', TextType::class)
            ->add('vin', TextType::class)
            ->add('segment', ChoiceType::class, [
                'choices' => [
                    'INNE' => 'OTHER',
                    'A' => 'A',
                    'B' => 'B',
                    'C' => 'C',
                    'D' => 'D',
                    'SUV' => 'SUV',
                    'CROSSOVER' => 'CROSSOVER',
                ]
            ])
            ->add('bodyType', ChoiceType::class, [
                'choices' => [
                    'INNE' => 'OTHER',
                    'SEDAN' => 'SEDAN',
                    'COMBI' => 'COMBI',
                    'HATCHBACK' => 'HATCHBACK',
                    'COUPE' => 'COUPE',
                ]
            ])
            ->add('color', ColorType::class)
            ->add('fuel', ChoiceType::class, [
                'choices' => [
                    'INNE' => 'OTHER',
                    'BEV ( Pojazd elektryczny z akumulatorem )' => 'EV',
                    'PHEV ( Hybrydowy pojazd elektryczny typu plug-in )' => 'PHEV',
                    'HEV ( Hybrydowy pojazd elektryczny )' => 'HEV',
                    'WODÓR' => 'WODÓR',
                    'DIESEL' => 'DIESEL',
                    'PB 100' => 'PB 100',
                    'PB 98' => 'PB 98',
                    'PB 95' => 'PB 95'
                ]
            ])
            ->add('numberOfSeats', IntegerType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 9
                ]
            ])
            ->add('numberOfDoors', IntegerType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 5
                ]
            ])
            ->add('registrationNumber', TextType::class)
            ->add('technicalExaminationDate', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('insuranceExpirationDate', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('mileage', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 999999
                ]
            ]);
    }
}