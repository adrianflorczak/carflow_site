<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/client')]
class ClientController extends AbstractController
{
    #[Route('', name: 'app_client_home', methods: ['GET'])]
    public function home(): Response {
        return $this->render('client/view/home.html.twig');
    }
}