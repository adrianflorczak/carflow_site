<?php

namespace App\Service;

use App\Entity\Branch;
use App\Entity\Car;
use App\Entity\Organization;
use App\Repository\BranchRepository;
use App\Repository\CarRepository;
use App\Repository\OrganizationRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

class OrganizationService
{
    private OrganizationRepository $organizationRepository;
    private BranchRepository $branchRepository;
    private CarRepository $carRepository;

    public function __construct(
        OrganizationRepository $organizationRepository,
        BranchRepository       $branchRepository,
        CarRepository          $carRepository
    )
    {
        $this->organizationRepository = $organizationRepository;
        $this->branchRepository = $branchRepository;
        $this->carRepository = $carRepository;
    }

    public
    function getAllOrganizations(): array
    {
        return $this->organizationRepository->findAll();
    }

    public
    function getOrganizationBySlug(string $slug): Organization
    {
        $organization = $this->organizationRepository->findOneBy(['slug' => $slug]);

        if ($organization) {
            return $organization;
        } else {
            throw new HttpException(404, 'Not Found');
        }
    }

    public
    function getBranchByOrganizationAndBranchSlug(string $organizationSlug, string $branchSlug): Branch
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

    public
    function getCarByOrganizationSlugAndBranchSlugAndCarId(
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

}