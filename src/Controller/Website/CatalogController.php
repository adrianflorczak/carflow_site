<?php

namespace App\Controller\Website;

use App\Service\OrganizationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/catalog')]
class CatalogController extends AbstractController
{
    private OrganizationService $organizationService;

    public function __construct(
        OrganizationService $organizationService
    )
    {
        $this->organizationService = $organizationService;
    }

    #[Route('/organizations', name: 'app_website_catalog_organizations', methods: ['GET'], priority: 10)]
    public function getOrganizations(): Response {
        $organizations = $this->organizationService->getAllOrganizations();

        return $this->render('website/view/catalog/organizations/index.html.twig', [
            'organizations' => $organizations
        ]);
    }

    #[Route('/branches', name: 'app_website_catalog_branches', methods: ['GET'], priority: 10)]
    public function branches(): Response {
        return $this->render('website/view/catalog/branches/index.html.twig', []);
    }
}