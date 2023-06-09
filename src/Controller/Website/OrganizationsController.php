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

        return $this->render('website/view/organizations/organization/branch/index.html.twig', [
            'branch' => $branch,
            'organization' => $organization
        ]);
    }
}