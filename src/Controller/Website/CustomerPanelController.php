<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/customer-panel')]
class CustomerPanelController extends AbstractController
{
    #[Route('/', name: 'app_website_customerPanel', methods: ['GET'], priority: 10)]
    public function customerPanel(): Response {
        return $this->render('website/view/customerPanel/index.html.twig', []);
    }
}