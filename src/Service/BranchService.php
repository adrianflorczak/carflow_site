<?php

namespace App\Service;

use App\Entity\Branch;
use App\Repository\BranchRepository;
use App\Repository\OrganizationRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BranchService
{
    private OrganizationRepository $organizationRepository;
    private BranchRepository $branchRepository;
    private Security $security;

    public function __construct(
        OrganizationRepository $organizationRepository,
        BranchRepository       $branchRepository,
        Security               $security
    )
    {
        $this->organizationRepository = $organizationRepository;
        $this->branchRepository = $branchRepository;
        $this->security = $security;
    }

    public function createBranchForCurrentlyLoggedUser(
        int    $organizationId,
        string $branchName,
        string $branchSlug
    ): void
    {
        $organization = $this->organizationRepository->findOneBy(['id' => $organizationId]);
        if ($organization) {
            $loggedUserIdentifier = $this->security->getUser()->getUserIdentifier();
            $organizationAdminIdentifier = $organization->getAdmin()->getUserIdentifier();
            if ($loggedUserIdentifier == $organizationAdminIdentifier) {
                $branch = new Branch();
                $branch->setOrganization($organization);
                $branch->setName($branchName);
                $branch->setSlug($branchSlug);

                try {
                    $this->branchRepository->save($branch, true);
                } catch (HttpException $exception) {
                    throw new HttpException(500, 'Podczas zapisu oddziału wystąpił błąd');
                }
            } else {
                throw new HttpException(403, 'Brak uprawnień do zasobu');
            }
        } else {
            throw new HttpException(404, 'Wyszukiwana organizacja nie istnieje');
        }
    }

    public function getBranchesCurrentlyLoggedUser(int $organizationId): array
    {
        $organization = $this->organizationRepository->findOneBy(['id' => $organizationId]);
        if ($organization) {
            $loggedUserIdentifier = $this->security->getUser()->getUserIdentifier();
            $organizationAdminIdentifier = $organization->getAdmin()->getUserIdentifier();
            if ($loggedUserIdentifier == $organizationAdminIdentifier) {
                $response = [];
                foreach ($organization->getBranches() as $branch) {
                    array_push(
                        $response,
                        [
                            'id' => $branch->getId(),
                            'name' => $branch->getName()
                        ]
                    );
                }

                return $response;
            } else {
                throw new HttpException(403, 'Brak uprawnień do zasobu');
            }
        } else {
            throw new HttpException(404, 'Wyszukiwana organizacja nie istnieje');
        }
    }

    public function getCount(): int
    {
        return $this->branchRepository->count([]);
    }

    public function saveBranch(Branch $branch): Branch
    {
        return $this->branchRepository->save($branch, true);
    }

    public function getBranches(): array
    {
        return $this->branchRepository->findAll();
    }

    public function getBranchById(int $id): Branch
    {
        $branch = $this->branchRepository->findOneBy(['id' => $id]);

        if ($branch) {
            return $branch;
        } else {
            throw new HttpException(404, 'Not Found');
        }
    }

    public function removeBranchById(int $id): void
    {
        $branch = $this->branchRepository->findOneBy(['id' => $id]);

        if ($branch) {
            $this->branchRepository->remove($branch, true);
        } else {
            throw new HttpException(404, 'Not Found');
        }
    }

}