<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rodo')]
class RodoController extends AbstractController
{
    #[Route('', name: 'app_website_rodo', methods: ['GET'], priority: 10)]
    public function rodo(): Response {
        return $this->render('website/view/rodo/index.html.twig', []);
    }
}