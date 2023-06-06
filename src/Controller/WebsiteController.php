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

    #[Route('/{organization}', name: 'app_website_organization', methods: ['GET'])]
    public function organization(string $organization): Response {
        return $this->render('website/view/organization/index.html.twig', [
            'organization' => $organization
        ]);
    }

    #[Route('/{organization}/{branch}', name: 'app_website_organization_branch', methods: ['GET'])]
    public function branch(string $organization, string $branch): Response {
        return $this->render('website/view/organization/branch/index.html.twig', [
            'organization' => $organization,
            'branch' => $branch
        ]);
    }

    #[Route('/faq', name: 'app_website_faq', methods: ['GET'], priority: 10)]
    public function faq(): Response {
        return $this->render('website/view/faq.html.twig', []);
    }

    #[Route('/rodo', name: 'app_website_rodo', methods: ['GET'], priority: 10)]
    public function rodo(): Response {
        return $this->render('website/view/rodo.html.twig', []);
    }



    #[Route('/privacy-policy', name: 'app_website_privacy-policy', methods: ['GET'], priority: 10)]
    public function privacyPolicy(): Response {
        return $this->render('website/view/privacyPolicy.html.twig', []);
    }

    #[Route('/contact', name: 'app_website_contact', methods: ['GET'], priority: 10)]
    public function contact(): Response {
        return $this->render('website/view/contact.html.twig', []);
    }
}