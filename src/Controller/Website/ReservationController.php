<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('', name: 'app_website_reservation', methods: ['GET'], priority: 10)]
    public function reservation(): Response {
        return $this->render('website/view/reservation/index.html.twig', []);
    }
}