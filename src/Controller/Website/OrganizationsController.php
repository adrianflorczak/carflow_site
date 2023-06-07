<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrganizationsController extends AbstractController
{
    #[Route('/{organization}', name: 'app_website_organization', methods: ['GET'])]
    public function organization(string $organization): Response {
        return $this->render('website/view/organizations/organization/index.html.twig', [
            'organization' => $organization
        ]);
    }

    #[Route('/{organization}/{branch}', name: 'app_website_organization_branch', methods: ['GET'])]
    public function branch(string $organization, string $branch): Response {
        return $this->render('website/view/organizations/organization/branch/index.html.twig', [
            'organization' => $organization,
            'branch' => $branch
        ]);
    }
}