<?php

namespace App\Service;

use App\Entity\Faq;
use App\Repository\FaqRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function getItemById(int $id): Faq
    {
        $item = $this->repository->findOneBy(['id' => $id]);

        if ($item)
        {
            return $item;
        }
        else
        {
            throw new NotFoundHttpException('Not Found');
        }
    }

}