<?php

namespace App\Controller\Api\v_0_0_1;

use App\Entity\Branch;
use App\Entity\Organization;
use App\Service\BranchService;
use App\Service\OrganizationService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v-0-0-1/organizations')]
class OrganizationController extends AbstractController
{
    private OrganizationService $organizationService;
    private BranchService $branchService;
    private UserService $userService;
    private Security $security;


    public function __construct(
        OrganizationService $organizationService,
        BranchService $branchService,
        UserService $userService,
        Security $security
    )
    {
        $this->organizationService = $organizationService;
        $this->branchService = $branchService;
        $this->userService = $userService;
        $this->security = $security;
    }

    #[Route('', name: 'app_api_organizations_new-organization', methods: ['POST'])]
    public function newOrganization(Request $request): Response
    {
        $payload = json_decode($request->getContent(), false);

        $loggedUser = $this->security->getUser();
        $userEmail = $loggedUser->getUserIdentifier();
        $user = $this->userService->getUserByEmail($userEmail);

        $organization = new Organization();

        $organization->setAdmin($user);
        $organization->setName($payload->name);
        $organization->setEmail($payload->email);
        $organization->setAddress($payload->address);
        $organization->setBuildingAndApartmentNumber($payload->buildingAndApartmentNumber);
        $organization->setPostCode($payload->postCode);
        $organization->setCity($payload->city);
        $organization->setCountry($payload->country);
        $organization->setSlug($payload->slug);

        $this->organizationService->saveOrganization($organization);

        return $this->json(null, 201);


    }

    #[Route('', name: 'app_api_organizations_get-organizations-by-admin-email', methods: ['GET'])]
    public function getOrganizationsByAdminEmail(): Response
    {
        $loggedUser = $this->security->getUser();
        $userEmail = $loggedUser->getUserIdentifier();

        $organizations = $this->organizationService->getOrganizationsByEmailLoggedUser($userEmail);

        $array = [];

        foreach ($organizations as $organization)
        {
            $item = [
                'id' => $organization->getId(),
                'name' => $organization->getName()
            ];
            array_push($array, $item);
        }

        return $this->json([
            'organizations' => $array
        ], 200);
    }

    #[Route('/{id}/branches/new', name: 'app_api_organizations_new-branch-in-organization', methods: ['POST'])]
    public function newBranchInOrganization(Request $request, string $id): Response
    {
        $payload = json_decode($request->getContent(), false);

        $loggedUser = $this->security->getUser();
        $userEmail = $loggedUser->getUserIdentifier();

        $organizations = $this->organizationService->getOrganizationsByEmailLoggedUser($userEmail);
        $organization = null;

        foreach ($organizations as $localOrganization)
        {
            if ($localOrganization->getId() === intval($id))
            {
                $organization = $localOrganization;
            }
        }

        if ($organization)
        {
            $branch = new Branch();
            $branch->setOrganization($organization);
            $branch->setName($payload->name);
            $branch->setSlug($payload->slug);

            $this->branchService->saveBranch($branch);

            return $this->json(null, 201);

        } else {
            throw new HttpException(403, 'Brak dostępu');
        }
    }

    #[Route('/{id}/branches', name: 'app_api_organizations_get-branches-by-organization-by-admin-email', methods: ['GET'])]
    public function getBranchesByOrganizationByAdminEmail(string $id): Response
    {
        $loggedUser = $this->security->getUser();
        $userEmail = $loggedUser->getUserIdentifier();

        $organizations = $this->organizationService->getOrganizationsByEmailLoggedUser($userEmail);
        $organization = null;


        foreach ($organizations as $localOrganization)
        {
            if ($localOrganization->getId() === intval($id))
            {
                $organization = $localOrganization;
            }
        }

        if ($organization)
        {
            $branches = $organization->getBranches();
            $response = [];

            foreach ($branches as $branch)
            {
                $response[] = [
                    'id' => $branch->getId(),
                    'name' => $branch->getName()
                ];
            }

            return $this->json($response);

        } else {
            throw new HttpException(403, 'Brak dostępu');
        }
    }

    #[Route('/{id}/branches/{branchId}/cars', name: 'app_api_organizations_new-car-in-branch-in-organization', methods: ['GET'])]
    public function newCarInBranchInOrganization(string $id): Response
    {
        $loggedUser = $this->security->getUser();
        $userEmail = $loggedUser->getUserIdentifier();

        $organizations = $this->organizationService->getOrganizationsByEmailLoggedUser($userEmail);
        $organization = null;


        foreach ($organizations as $localOrganization)
        {
            if ($localOrganization->getId() === intval($id))
            {
                $organization = $localOrganization;
            }
        }

        if ($organization)
        {
            $branches = $organization->getBranches();
            $cars = [];

            foreach ($branches as $branch)
            {
                array_push($cars, []);
            }

            return $this->json([
                'data' => $branches
            ]);

        } else {
            throw new HttpException(403, 'Brak dostępu');
        }
    }
}