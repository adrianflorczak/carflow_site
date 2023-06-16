<?php

namespace App\Form\administrator\organization;

use App\Entity\Organization;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganizationType extends AbstractType
{
    private array $users = [];

    public function __construct(UserRepository $userRepository)
    {
        $usersFromDb = $userRepository->findAll();
        foreach ($usersFromDb as $user)
        {
            array_push($this->users, [$user->getEmail() => $user]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Organization::class,
            'users' => $this->users
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
            ->add('slug', TextType::class)
            ->add('admin', ChoiceType::class, [
                'choices' => $options['users']
            ]);
    }
}