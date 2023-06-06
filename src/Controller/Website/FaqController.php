<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/faq')]
class FaqController extends AbstractController
{
    #[Route('', name: 'app_website_faq', methods: ['GET'], priority: 10)]
    public function faq(): Response {
        return $this->render('website/view/faq/index.html.twig', []);
    }
}