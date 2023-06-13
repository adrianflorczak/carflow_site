<?php

namespace App\Form\administrator\branch;

use App\Entity\Branch;
use App\Repository\OrganizationRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BranchType extends AbstractType
{
    private array $organizationsArray = [];

    public function __construct(OrganizationRepository $organizationRepository)
    {
        $organizationsFromDb = $organizationRepository->findAll();

        foreach ($organizationsFromDb as $organization) {
            $this->organizationsArray += [
                $organization->getName() => $organization
            ];
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Branch::class,
            'organizations' => $this->organizationsArray
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('organization', ChoiceType::class, [
                'choices' => $options['organizations']
            ])
            ->add('name', TextType::class)
            ->add('slug', TextType::class);
    }
}