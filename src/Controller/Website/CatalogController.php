<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/catalog')]
class CatalogController extends AbstractController
{
    #[Route('/organizations', name: 'app_website_catalog_organizations', methods: ['GET'], priority: 10)]
    public function organizations(): Response {
        return $this->render('website/view/catalog/organizations/index.html.twig', []);
    }

    #[Route('/branches', name: 'app_website_catalog_branches', methods: ['GET'], priority: 10)]
    public function branches(): Response {
        return $this->render('website/view/catalog/branches/index.html.twig', []);
    }
}