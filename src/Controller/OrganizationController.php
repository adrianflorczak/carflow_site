<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/organization')]
class OrganizationController extends AbstractController
{
    #[Route('', name: 'app_organization_home', methods: ['GET'])]
    public function home(): Response {
        return $this->render('organization/view/home.html.twig');
    }
}