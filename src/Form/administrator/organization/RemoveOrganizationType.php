<?php

namespace App\Form\administrator\organization;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class RemoveOrganizationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
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