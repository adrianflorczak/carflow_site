<?php

namespace App\Service;

use App\Entity\Branch;
use App\Entity\Car;
use App\Entity\Organization;
use App\Repository\BranchRepository;
use App\Repository\CarRepository;
use App\Repository\OrganizationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\HttpException;

class OrganizationService
{
    private OrganizationRepository $organizationRepository;
    private BranchRepository $branchRepository;
    private CarRepository $carRepository;
    private UserRepository $userRepository;
    private Security $security;

    public function __construct(
        OrganizationRepository $organizationRepository,
        BranchRepository       $branchRepository,
        CarRepository          $carRepository,
        UserRepository         $userRepository,
        Security               $security
    )
    {
        $this->organizationRepository = $organizationRepository;
        $this->branchRepository = $branchRepository;
        $this->carRepository = $carRepository;
        $this->userRepository = $userRepository;
        $this->security = $security;
    }

    public function createOrganizationForCurrentlyLoggedUser(array $organizationData): void
    {
        $admin = $this->security->getUser();

        $organization = new Organization();
        $organization->setAdmin($admin);
        $organization->setName($organizationData['name']);
        $organization->setEmail($organizationData['email']);
        $organization->setAddress($organizationData['address']);
        $organization->setBuildingAndApartmentNumber($organizationData['buildingAndApartmentNumber']);
        $organization->setPostCode($organizationData['postCode']);
        $organization->setCity($organizationData['city']);
        $organization->setCountry($organizationData['country']);
        $organization->setSlug($organizationData['slug']);

        try {
            $this->organizationRepository->save($organization, true);
        } catch (HttpException $exception) {
            throw new HttpException(500, 'Podczas zapisu organizacji wystąpił błąd');
        }
    }

    public function getOrganizationsCurrentlyLoggedUser(): array
    {
        $admin = $this->security->getUser();
        $organizations = $this->organizationRepository->findBy(['admin' => $admin]);
        $response = [];
        if ($organizations) {
            foreach ($organizations as $organization) {
                array_push(
                    $response,
                    [
                        'id' => $organization->getId(),
                        'name' => $organization->getName(),
                        'email' => $organization->getEmail(),
                        'address' => $organization->getAddress(),
                        'buildingAndApartmentNumber' => $organization->getBuildingAndApartmentNumber(),
                        'postCode' => $organization->getPostCode(),
                        'city' => $organization->getCity(),
                        'country' => $organization->getCountry(),
                        'slug' => $organization->getSlug()
                    ]
                );
            }
        }
        return $response;
    }

    public function getCount(): int
    {
        return $this->organizationRepository->count([]);
    }

    public function getAllOrganizations(): array
    {
        return $this->organizationRepository->findAll();
    }

    public function getOrganizationsByEmailLoggedUser(string $email): array
    {
        $organizationsForController = [];

        $user = $this->userRepository->findOneBy(['email' => $email]);

        return $this->organizationRepository->findBy(['admin' => $user]);
    }

    public function getOrganizationBySlug(string $slug): Organization
    {
        $organization = $this->organizationRepository->findOneBy(['slug' => $slug]);

        if ($organization) {
            return $organization;
        } else {
            throw new HttpException(404, 'Not Found');
        }
    }

    public function getOrganizationById(int $id): Organization
    {
        $organization = $this->organizationRepository->findOneBy(['id' => $id]);

        if ($organization) {
            return $organization;
        } else {
            throw new HttpException(404, 'Not Found');
        }
    }

    public function removeOrganizationById(int $id): void
    {
        $organization = $this->organizationRepository->findOneBy(["id" => $id]);

        if ($organization) {
            $this->organizationRepository->remove($organization, true);
        } else {
            throw new HttpException(404, 'Not Found');
        }
    }

    public function getBranchByOrganizationAndBranchSlug(string $organizationSlug, string $branchSlug): Branch
    {
        $organization = $this->organizationRepository->findOneBy(['slug' => $organizationSlug]);


        if ($organization) {
            $organizationId = $organization->getId();
            $branch = null;
            $branches = $this->branchRepository->findBy(['slug' => $branchSlug]);

            foreach ($branches as $item) {
                if ($item->getOrganization()->getId() == $organizationId) {
                    $branch = $item;
                }
            }

            if ($branch) {
                return $branch;
            } else {
                throw new HttpException(404, 'Not Found');
            }

        } else {
            throw new HttpException(404, 'Not Found');
        }
    }

    public function getCarByOrganizationSlugAndBranchSlugAndCarId(
        string $organizationSlug,
        string $branchSlug,
        int    $carId
    ): Car
    {
        $organization = $this->organizationRepository->findOneBy(['slug' => $organizationSlug]);


        if ($organization) {
            $organizationId = $organization->getId();
            $branch = null;
            $branches = $this->branchRepository->findBy(['slug' => $branchSlug]);

            foreach ($branches as $item) {
                if ($item->getOrganization()->getId() == $organizationId) {
                    $branch = $item;
                }
            }

            if ($branch) {
                $car = $this->carRepository->findOneBy(['id' => $carId]);

                if ($car) {
                    return $car;
                } else {
                    throw new HttpException('404', 'Not Found');
                }


            } else {
                throw new HttpException(404, 'Not Found');
            }

        } else {
            throw new HttpException(404, 'Not Found');
        }
    }

    public function saveOrganization(Organization $organization): Organization
    {
        return $this->organizationRepository->save($organization, true);
    }

}