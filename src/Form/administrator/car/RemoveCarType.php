<?php

namespace App\Form\administrator\car;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class RemoveCarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('confirmation', ChoiceType::class, [
                'choices' => [
                    'NIE' => 0,
                    'TAK' => 1
                ]
            ]);
    }
}