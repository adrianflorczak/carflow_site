<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebsiteController extends AbstractController
{
    #[Route('', name: 'app_website_home')]
    public function home(): Response {
        return $this->render('website/view/home.html.twig');
    }

    #[Route('/contact', name: 'app_website_contact', methods: ['GET'])]
    public function contact(): Response {
        return $this->render('website/view/contact.html.twig', [
            'title' => 'Kontakt'
        ]);
    }
}