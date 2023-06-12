<?php

namespace App\Form\administrator\organization;

use App\Entity\Organization;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganizationType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Organization::class
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('email', TextType::class)
            ->add('address', TextType::class)
            ->add('buildingAndApartmentNumber', TextType::class)
            ->add('postCode', TextType::class)
            ->add('city', TextType::class)
            ->add('country', TextType::class)
            ->add('slug', TextType::class);
    }
}