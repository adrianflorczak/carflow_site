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
        return $this->render('website/view/functionalities/index.html.twig');
    }
}