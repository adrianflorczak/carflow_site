<?php

namespace App\Controller\Administrator;

use App\Service\FaqService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

#[Route('/administrator-panel/faq')]
class FaqController extends AbstractController
{
    private FaqService $faqService;

    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
    }

    #[Route('/create-new', name: 'app_administrator_faq_create-new', methods: ['GET'])]
    public function createNewFaqItem(): Response
    {
        return $this->render('administrator/view/faq/view/new/index.html.twig', []);
    }

    #[Route('', name: 'app_administrator_faq_home', methods: ['GET'])]
    public function getFaqDashboard(): Response
    {
        return $this->render('administrator/view/faq/view/dashboard/index.html.twig', []);
    }


    #[Route('/show-all', name: 'app_administrator_faq_show-all', methods: ['GET'])]
    public function getAllFaqItems(): Response {
        $faqs = $this->faqService->getAllFaqs();
        return $this->render('administrator/view/faq/view/showAll/index.html.twig', [
            'faqs' => $faqs
        ]);
    }

    // update one

    #[Route('/{id}/delete', name: 'app_administrator_faq_delete', methods: ['GET', 'POST'])]
    public function deleteOneFaqItem(string $id): Response
    {

        $item = $this->faqService->getItemById(intval($id));

        return $this->render('administrator/view/faq/view/delete/index.html.twig', [
            'item' => $item
        ]);
    }
}