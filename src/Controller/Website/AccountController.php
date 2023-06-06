<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/account')]
class AccountController extends AbstractController
{
    #[Route('', name: 'app_website_account', methods: ['GET'], priority: 10)]
    public function account(): Response {
        return $this->render('website/view/account/index.html.twig', []);
    }
}