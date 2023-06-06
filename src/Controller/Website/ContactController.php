<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact')]
class ContactController extends AbstractController
{
    #[Route('', name: 'app_website_contact', methods: ['GET'], priority: 10)]
    public function contact(): Response {
        return $this->render('website/view/contact/index.html.twig', []);
    }
}