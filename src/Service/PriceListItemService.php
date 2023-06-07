<?php

namespace App\Service;

use App\Repository\PriceListItemRepository;

class PriceListItemService
{
    private PriceListItemRepository $repository;
    public function __construct(PriceListItemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllItems(): array
    {
        // sort here
        return $this->repository->findAll();
    }
}