<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/functionalities')]
class FunctionalitiesController extends AbstractController
{
    #[Route('', name: 'app_website_functionalities', methods: ['GET'], priority: 10)]
    public function functionalities(): Response {
        return $this->render('website/view/functionalities/home/index.html.twig');
    }

    #[Route('/for-client', name: 'app_website_functionalities_for-client', methods: ['GET'], priority: 10)]
    public function functionalitiesForClient(): Response {
        return $this->render('website/view/functionalities/forClient/index.html.twig');
    }

    #[Route('/for-car-flow-site-rentals', name: 'app_website_functionalities_for-car-flow-site-rentals', methods: ['GET'], priority: 10)]
    public function functionalitiesForCarFlowSiteRentals(): Response {
        return $this->render('website/view/functionalities/forCarFlowSiteRentals/index.html.twig');
    }

    #[Route('/for-external-rentals', name: 'app_website_functionalities_for-external-rentals', methods: ['GET'], priority: 10)]
    public function functionalitiesForExternalRentals(): Response {
        return $this->render('website/view/functionalities/forExternalRentals/index.html.twig');
    }
}