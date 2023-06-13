<?php

namespace App\Service;

use App\Entity\Branch;
use App\Repository\BranchRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BranchService
{
    private BranchRepository $branchRepository;

    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
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

        if ($branch)
        {
            return $branch;
        } else {
            throw new HttpException(404, 'Not Found');
        }
    }

    public function removeBranchById(int $id): void
    {
        $branch = $this->branchRepository->findOneBy(['id' => $id]);

        if ($branch)
        {
            $this->branchRepository->remove($branch, true);
        } else {
            throw new HttpException(404, 'Not Found');
        }
    }

}