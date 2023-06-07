<?php

namespace App\Controller\Website;

use App\Service\PriceListItemService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/price-list')]
class PriceListController extends AbstractController
{
    private PriceListItemService $service;

    public function __construct(PriceListItemService $service)
    {
        $this->service = $service;
    }

    #[Route('', name: 'app_website_price-list', methods: ['GET'], priority: 10)]
    public function priceList(): Response {
        $items = $this->service->getAllItems();
        return $this->render('website/view/priceList/index.html.twig', [
            'items' => $items
        ]);
    }
}