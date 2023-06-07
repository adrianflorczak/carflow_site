<?php

namespace App\Service;

use App\Repository\FaqRepository;

class FaqService
{
    private FaqRepository $repository;

    public function __construct(FaqRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllFaqs(): array
    {
        // sort here
        return $this->repository->findAll();
    }

}