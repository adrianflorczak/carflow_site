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
        return $this->render('website/view/priceList/home/index.html.twig', [
            'items' => $items
        ]);
    }

    #[Route('/for-client', name: 'app_website_price-list_for-client', methods: ['GET'], priority: 10)]
    public function priceListForClient(): Response {
        $items = $this->service->getAllItems();
        return $this->render('website/view/priceList/forClient/index.html.twig', []);
    }

    #[Route('/for-car-flow-site-rentals', name: 'app_website_price-list_for-car-flow-site-rentals', methods: ['GET'], priority: 10)]
    public function priceListForCarFlowSiteRentals(): Response {
        $items = $this->service->getAllItems();
        return $this->render('website/view/priceList/forCarFlowSiteRentals/index.html.twig', []);
    }

    
    #[Route('/for-external-rentals', name: 'app_website_price-list_for-external-rentals', methods: ['GET'], priority: 10)]
    public function priceListForExternalRentals(): Response {
        $items = $this->service->getAllItems();
        return $this->render('website/view/priceList/forExternalRentals/index.html.twig', []);
    }
}