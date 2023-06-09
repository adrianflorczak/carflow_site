<?php

namespace App\Controller\Website;

use App\Service\BranchService;
use App\Service\CarService;
use App\Service\OrganizationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/catalog')]
class CatalogController extends AbstractController
{
    private OrganizationService $organizationService;
    private BranchService $branchService;
    private CarService $carService;

    public function __construct(
        OrganizationService $organizationService,
        BranchService       $branchService,
        CarService          $carService
    )
    {
        $this->organizationService = $organizationService;
        $this->branchService = $branchService;
        $this->carService = $carService;
    }

    #[Route('/organizations', name: 'app_website_catalog_organizations', methods: ['GET'], priority: 10)]
    public function getOrganizations(): Response
    {
        $organizations = $this->organizationService->getAllOrganizations();

        return $this->render('website/view/catalog/organizations/index.html.twig', [
            'organizations' => $organizations
        ]);
    }

    #[Route('/branches', name: 'app_website_catalog_branches', methods: ['GET'], priority: 10)]
    public function branches(): Response
    {
        $branches = $this->branchService->getBranches();

        return $this->render('website/view/catalog/branches/index.html.twig', [
            'branches' => $branches
        ]);
    }

    #[Route('/cars', name: 'app_website_catalog_cars', methods: ['GET'], priority: 10)]
    public function cars(): Response
    {
        $cars = $this->carService->getCars();

        return $this->render('website/view/catalog/cars/index.html.twig', [
            'cars' => $cars
        ]);
    }
}