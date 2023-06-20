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

    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
    }

    #[Route('/count', name: 'app_api_organizations_get-count', methods: ['GET'])]
    public function getCount(): Response
    {
        $count = $this->organizationService->getCountForCurrentlyLoggedUser();
        return $this->json($count);
    }

    #[Route('', name: 'app_api_organizations_create-new-organization', methods: ['POST'])]
    public function createNewOrganization(Request $request): Response
    {
        $payload = json_decode($request->getContent(), false);
        $organization = [
            'name' => $payload->name,
            'email' => $payload->email,
            'address' => $payload->address,
            'buildingAndApartmentNumber' => $payload->buildingAndApartmentNumber,
            'postCode' => $payload->postCode,
            'city' => $payload->city,
            'country' => $payload->country,
            'slug' => $payload->slug
        ];
        $this->organizationService->createOrganizationForCurrentlyLoggedUser($organization);

        return $this->json(null, 201);
    }

    #[Route('', name: 'app_api_organizations_get-organizations', methods: ['GET'])]
    public function getOrganizations(): Response
    {
        $organizations = $this->organizationService->getOrganizationsCurrentlyLoggedUser();

        return $this->json($organizations);
    }

//    #[Route('', name: 'app_api_organizations_new-organization', methods: ['POST'])]
//    public function newOrganization(Request $request): Response
//    {
//        $payload = json_decode($request->getContent(), false);
//
//        $loggedUser = $this->security->getUser();
//        $userEmail = $loggedUser->getUserIdentifier();
//        $user = $this->userService->getUserByEmail($userEmail);
//
//        $organization = new Branches();
//
//        $organization->setAdmin($user);
//        $organization->setName($payload->name);
//        $organization->setEmail($payload->email);
//        $organization->setAddress($payload->address);
//        $organization->setBuildingAndApartmentNumber($payload->buildingAndApartmentNumber);
//        $organization->setPostCode($payload->postCode);
//        $organization->setCity($payload->city);
//        $organization->setCountry($payload->country);
//        $organization->setSlug($payload->slug);
//
//        $this->organizationService->saveOrganization($organization);
//
//        return $this->json(null, 201);
//
//
//    }
//
//    #[Route('', name: 'app_api_organizations_get-organizations-by-admin-email', methods: ['GET'])]
//    public function getOrganizationsByAdminEmail(): Response
//    {
//        $loggedUser = $this->security->getUser();
//        $userEmail = $loggedUser->getUserIdentifier();
//
//        $organizations = $this->organizationService->getOrganizationsByEmailLoggedUser($userEmail);
//
//        $array = [];
//
//        foreach ($organizations as $organization)
//        {
//            $item = [
//                'id' => $organization->getId(),
//                'name' => $organization->getName()
//            ];
//            array_push($array, $item);
//        }
//
//        return $this->json([
//            'organizations' => $array
//        ], 200);
//    }
}