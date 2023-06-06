<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/privacy-policy')]
class PrivacyPolicyController extends AbstractController
{
    #[Route('', name: 'app_website_privacy-policy', methods: ['GET'], priority: 10)]
    public function privacyPolicy(): Response {
        return $this->render('website/view/privacyPolicy/index.html.twig', []);
    }
}