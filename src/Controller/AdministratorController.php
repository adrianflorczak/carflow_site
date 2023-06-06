<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administrator')]
class AdministratorController extends AbstractController
{
    #[Route('', name: 'app_administrator_home', methods: ['GET'])]
    public function home(): Response {
        return $this->render('administrator/view/home.html.twig');
    }
}