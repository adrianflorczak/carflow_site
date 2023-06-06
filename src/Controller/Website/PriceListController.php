<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/price-list')]
class PriceListController extends AbstractController
{
    #[Route('', name: 'app_website_price-list', methods: ['GET'], priority: 10)]
    public function priceList(): Response {
        return $this->render('website/view/priceList/index.html.twig', []);
    }
}