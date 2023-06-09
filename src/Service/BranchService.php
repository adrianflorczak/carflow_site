<?php

namespace App\Service;

use App\Repository\BranchRepository;

class BranchService
{
    private BranchRepository $branchRepository;

    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }

    public function getBranches(): array
    {
        return $this->branchRepository->findAll();
    }

}