<?php

namespace App\Controller\Administrator;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administrator-panel')]
class HomeController extends AbstractController
{
    #[Route('', name: 'app_administrator_home', methods: ['GET'])]
    public function home(): Response {
        return $this->render('administrator/view/home/index.html.twig');
    }
}