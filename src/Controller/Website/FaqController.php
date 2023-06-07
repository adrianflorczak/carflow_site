<?php

namespace App\Controller\Website;

use App\Service\FaqService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/faq')]
class FaqController extends AbstractController
{
    private FaqService $service;

    public function __construct(FaqService $service)
    {
        $this->service = $service;
    }

    #[Route('', name: 'app_website_faq', methods: ['GET'], priority: 10)]
    public function faq(): Response {
        $faqs = $this->service->getAllFaqs();
        return $this->render('website/view/faq/index.html.twig', [
            'faqs' => $faqs
        ]);
    }
}