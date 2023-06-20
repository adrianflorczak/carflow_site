<?php

namespace App\Controller\Api\v_0_0_1;

use App\Service\BranchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v-0-0-1/organizations/{organizationId}/branches')]
class BranchController extends AbstractController
{
    private BranchService $service;

    public function __construct(BranchService $service)
    {
        $this->service = $service;
    }

    #[Route('', name: 'app_api_branches_create-new-branch-by-admin-email', methods: ['POST'])]
    public function createNewBranch(Request $request, string $organizationId): Response
    {
        $payload = json_decode($request->getContent(), false);
        $branchName = $payload->name;
        $branchSlug = $payload->slug;

        $this->service->createBranchForCurrentlyLoggedUser($organizationId, $branchName, $branchSlug);

        return $this->json(null, 201);
    }

    #[Route('', name: 'app_api_branches_get-branches-by-admin-email', methods: ['GET'])]
    public function getBranches(string $organizationId): Response
    {
        $branches = $this->service->getBranchesCurrentlyLoggedUser($organizationId);

        return $this->json($branches);
    }
}