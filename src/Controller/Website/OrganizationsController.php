<?php

namespace App\Controller\Website;

use App\Service\OrganizationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrganizationsController extends AbstractController
{
    private OrganizationService $organizationService;

    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
    }

    #[Route('/{organizationSlug}', name: 'app_website_organization', methods: ['GET'])]
    public function organization(string $organizationSlug): Response
    {
        $organization = $this->organizationService->getOrganizationBySlug($organizationSlug);
        $branches = $organization->getBranches();

        return $this->render('website/view/organizations/organization/index.html.twig', [
            'organization' => $organization,
            'branches' => $branches
        ]);
    }

    #[Route('/{organizationSlug}/{branchSlug}', name: 'app_website_organization_branch', methods: ['GET'])]
    public function branch(string $organizationSlug, string $branchSlug): Response
    {
        $branch = $this->organizationService->getBranchByOrganizationAndBranchSlug($organizationSlug, $branchSlug);
        $organization = $branch->getOrganization();
        $cars = $branch->getCars();

        return $this->render('website/view/organizations/organization/branch/index.html.twig', [
            'branch' => $branch,
            'organization' => $organization,
            'cars' => $cars
        ]);
    }

    #[Route('/{organizationSlug}/{branchSlug}/cars/{carId}', name: 'app_website_organization_branch_car', methods: ['GET'])]
    public function car(string $organizationSlug, string $branchSlug, string $carId): Response
    {
        $car = $this->organizationService->getCarByOrganizationSlugAndBranchSlugAndCarId(
            $organizationSlug,
            $branchSlug,
            $carId
        );

        $branch = $car->getBranch();

        $organization = $branch->getOrganization();

        return $this->render('website/view/organizations/organization/branch/car/index.html.twig', [
            'car' => $car,
            'branch' => $branch,
            'organization' => $organization
        ]);
    }
}