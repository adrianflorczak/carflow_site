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

    public function saveFaqItem(Faq $faq): Faq {
        return $this->repository->save($faq, true);
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
            throw new NotFoundHttpException('Not Found with id' . $id);
        }
    }

    public function removeItemById(int $id): void
    {
        $item = $this->repository->findOneBy(['id' => $id]);

        if ($item)
        {
            $this->repository->remove($item, true);
        }
        else
        {
            throw new NotFoundHttpException('Not Found');
        }
    }

}