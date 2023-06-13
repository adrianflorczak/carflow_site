<?php

namespace App\Controller\Administrator;

use App\Entity\Branch;
use App\Form\administrator\branch\BranchType;
use App\Form\administrator\branch\helper\ConfirmationClass;
use App\Form\administrator\organization\RemoveOrganizationType;
use App\Service\BranchService;
use App\Service\OrganizationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administrator-panel/branches')]
class BranchController extends AbstractController
{
    private BranchService $branchService;
    private OrganizationService $organizationService;

    public function __construct(BranchService $branchService, OrganizationService $organizationService)
    {
        $this->branchService = $branchService;
        $this->organizationService = $organizationService;
    }

    #[Route('', name: 'app_administrator_branch_home', methods: ['GET'])]
    public function getHome(): Response
    {
        $count = $this->branchService->getCount();

        return $this->render('administrator/view/branch/dashboard/index.html.twig', [
            'count' => $count
        ]);
    }

    #[Route('/create-new', name: 'app_administrator_branch_create-new', methods: ['GET', 'POST'])]
    public function createBranch(Request $request): Response
    {
        if (count($this->organizationService->getAllOrganizations()))
        {
            $branch = new Branch();

            $form = $this->createForm(BranchType::class, $branch);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                $data = $form->getData();

                $branch->setName($data->getName());
                $branch->setOrganization($data->getOrganization());
                $branch->setSlug($data->getSlug());

                try {
                    $this->branchService->saveBranch($branch);
                    $this->addFlash('create_branch_success', 'Pomyślnie utworzono nowy oddział');
                } catch (HttpException $e) {
                    $this->addFlash('create_branch_error', 'Podczas tworzenia nowego oddziału wystąpił błąd');
                } finally {
                    return $this->redirectToRoute('app_administrator_branch_show-all');
                }
            }

            return $this->render('administrator/view/branch/new/index.html.twig', [
                'form' => $form
            ]);
        } else {
            $this->addFlash('not_organization_in_branch_error', 'Aby utworzyć nowy oddział w systemie musi być zarejestrowana przynajmniej jedna organizacja.');
            return $this->redirectToRoute('app_administrator_branch_show-all');
        }
    }

    #[Route('/show-all', name: 'app_administrator_branch_show-all', methods: ['GET'])]
    public function getBranches(): Response
    {
        $branchesForView = [];
        $branches = $this->branchService->getBranches();

        foreach ($branches as $branch) {
            $organization = $branch->getOrganization();

            array_push($branchesForView, ["branch" => $branch, "organization" => $organization]);
        }

        return $this->render('administrator/view/branch/showAll/index.html.twig', [
            'branches' => $branchesForView
        ]);
    }


    // get one
    #[Route('/{id}', name: 'app_administrator_branch_show-one', methods: ['GET'])]
    public function getBranch(string $id): Response
    {
        $branch = $this->branchService->getBranchById(intval($id));
        $organization = $branch->getOrganization();

        return $this->render('administrator/view/branch/showOne/index.html.twig',[
            'branch' => $branch,
            'organization' => $organization
        ]);
    }

    #[Route('/{id}/update-one', name: 'app_administrator_branch_update-one', methods: ['GET', 'POST'])]
    public function updateBranch(string $id, Request $request): Response
    {
        $branch = $this->branchService->getBranchById(intval($id));
        $organization = $branch->getOrganization();

        $form = $this->createForm(BranchType::class, $branch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();

            $branch->setName($data->getName());
            $branch->setOrganization($data->getOrganization());
            $branch->setSlug($data->getSlug());

            try {
                $this->branchService->saveBranch($branch);
                $this->addFlash('update_branch_success', 'Pomyślnie zaktualizowano nowy oddział');
            } catch (HttpException $e) {
                $this->addFlash('update_branch_error', 'Podczas aktualizacji oddziału wystąpił błąd');
            } finally {
                return $this->redirectToRoute('app_administrator_branch_show-all');
            }
        }

        return $this->render('administrator/view/branch/update/index.html.twig', [
            'form' => $form,
            'branch' => $branch,
            'organization' => $organization
        ]);
    }

    #[Route('/{id}/remove', name: 'app_administrator_branch_remove-one', methods: ['GET', 'POST'])]
    public function deleteBranchById(string $id, Request $request): Response
    {
        $branch = $this->branchService->getBranchById(intval($id));
        $organization = $branch->getOrganization();
        $confirmation = new ConfirmationClass();

        $form = $this->createForm(RemoveOrganizationType::class, $confirmation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();

            if ($data->getConfirmation())
            {
                if (count($this->branchService->getBranchById(intval($id))->getCars())) {
                    $this->addFlash('remove_branch_info', 'Nie można usunąć oddziału ponieważ posiada on aktywne pojazdy.');
                    return $this->redirectToRoute('app_administrator_branch_show-all');
                } else {
                    try {
                        $this->branchService->removeBranchById(intval($id));
                        $this->addFlash('remove_branch_success', 'Oddział został poprawnie usunięty.');
                    } catch (HttpException $e)
                    {
                        $this->addFlash('remove_branch_exception', 'Usówanie oddziału zakończyło się niepowodzeniem');
                    } finally {
                        return $this->redirectToRoute('app_administrator_branch_show-all');
                    }
                }
            } else {
                $this->addFlash('branch_remove_confirmation_reject_error', 'Proces usówania oddziału został przerwany przez użytkownika');
                return $this->redirectToRoute('app_administrator_branch_show-all');
            }
        }

        return $this->render('administrator/view/branch/delete/index.html.twig', [
            'form' => $form,
            'branch' => $branch,
            'organization' => $organization
        ]);
    }
}