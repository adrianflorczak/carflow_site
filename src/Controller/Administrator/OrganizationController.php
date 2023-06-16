<?php

namespace App\Controller\Administrator;

use App\Entity\Organization;
use App\Form\administrator\organization\helper\ConfirmationClass;
use App\Form\administrator\organization\OrganizationType;
use App\Form\administrator\organization\RemoveOrganizationType;
use App\Service\CarService;
use App\Service\OrganizationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administrator-panel/organization')]
class OrganizationController extends AbstractController
{

    private OrganizationService $organizationService;

    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
    }

    #[Route('', name: 'app_administrator_organization_home', methods: ['GET'])]
    public function getHome(): Response
    {
        $count = $this->organizationService->getCount();

        return $this->render('administrator/view/organization/dashboard/index.html.twig', [
            'count' => $count
        ]);
    }

    #[Route('/create-new', name: 'app_administrator_organization_create-new', methods: ['GET', 'POST'])]
    public function createNew(Request $request): Response
    {
        $organization = new Organization();

        $form = $this->createForm(OrganizationType::class, $organization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $organization->setAdmin($data->getAdmin());
            $organization->setName($data->getName());
            $organization->setEmail($data->getEmail());
            $organization->setAddress($data->getAddress());
            $organization->setBuildingAndApartmentNumber($data->getBuildingAndApartmentNumber());
            $organization->setPostCode($data->getPostCode());
            $organization->setCity($data->getCity());
            $organization->setCountry($data->getCountry());
            $organization->setSlug($data->getSlug());

            try {
                $this->organizationService->saveOrganization($organization);
                $this->addFlash('new_organization_success', 'Poprawnie utworzono nową organizację');
            } catch (HttpException $e) {
                $this->addFlash('new_organization_error', 'Próba utworzenia nowej organizacji zakończona niepowodzeniem.');
            } finally {
                return $this->redirectToRoute('app_administrator_organization_show-all');
            }
        }

        return $this->render('administrator/view/organization/new/index.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/show-all', name: 'app_administrator_organization_show-all', methods: ['GET'])]
    public function getAllOrganizations(): Response
    {
        $organizations = $this->organizationService->getAllOrganizations();

        return $this->render('administrator/view/organization/showAll/index.html.twig', [
            'organizations' => $organizations
        ]);
    }

    #[Route('/{id}', name: 'app_administrator_organization_show-one', methods: ['GET'])]
    public function getOrganization(string $id): Response
    {
        $organization = $this->organizationService->getOrganizationById($id);
        $branches = $organization->getBranches();


        return $this->render('administrator/view/organization/showOne/index.html.twig', [
            'organization' => $organization,
            'branches' => $branches
        ]);
    }

    #[Route('/{id}/update-organization', name: 'app_administrator_organization_update-one', methods: ['GET', 'POST'])]
    public function updateOrganizationBySlug(string $id, Request $request): Response
    {
        $organization = $this->organizationService->getOrganizationById(intval($id));

        $form = $this->createForm(OrganizationType::class, $organization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $organization->setAdmin($data->getAdmin());
            $organization->setName($data->getName());
            $organization->setEmail($data->getEmail());
            $organization->setAddress($data->getAddress());
            $organization->setBuildingAndApartmentNumber($data->getBuildingAndApartmentNumber());
            $organization->setPostCode($data->getPostCode());
            $organization->setCity($data->getCity());
            $organization->setCountry($data->getCountry());
            $organization->setSlug($data->getSlug());

            try {
                $this->organizationService->saveOrganization($organization);
                $this->addFlash('new_organization_success', 'Poprawnie zaktualizowano organizację');
            } catch (HttpException $e) {
                $this->addFlash('new_organization_error', 'Podczas aktualizacji organizacji wystąpił błąd');
            } finally {
                return $this->redirectToRoute('app_administrator_organization_show-all');
            }
        }

        return $this->render('administrator/view/organization/updateOne/index.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}/remove', name: 'app_administrator_organization_remove-one', methods: ['GET', 'POST'])]
    public function removeCarBySlug(string $id, Request $request): Response
    {
        $confirmation = new ConfirmationClass();

        $form = $this->createForm(RemoveOrganizationType::class, $confirmation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();

            if ($data->getConfirmation())
            {

                if (count($this->organizationService->getOrganizationById(intval($id))->getBranches()))
                {
                    $this->addFlash('remove_organization_info', 'Nie można usunąć organizacji ponieważ posiada ona aktywne oddziały.');
                    return $this->redirectToRoute('app_administrator_organization_show-all');
                } else
                {
                    try {
                        $this->organizationService->removeOrganizationById(intval($id));
                        $this->addFlash('remove_organization_success', 'Usówanie organizacji przebiegło pomyślnie');
                    } catch (HttpException $e) {
                        $this->addFlash('remove_organization_error', 'Usówanie organizacji zakończyło się niepowodzeniem');
                    } finally {
                        return $this->redirectToRoute('app_administrator_organization_show-all');
                    }
                }
            } else {
                $this->addFlash('organization_confirmation_reject_error', 'Proces usówania organizacji został przerwany przez użytkownika');
                return $this->redirectToRoute('app_administrator_organization_show-all');
            }
        }

        return $this->render('administrator/view/organization/removeOne/index.html.twig', [
            'form' => $form
        ]);
    }
}