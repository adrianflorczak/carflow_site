<?php

namespace App\Controller\Administrator;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/administrator-panel/organization')]
class OrganizationController extends AbstractController
{
    #[Route('', name: 'app_administrator_organization_home', methods: ['GET'])]
    public function getHome(): Response
    {
        return $this->render('administrator/view/organization/dashboard/index.html.twig', [

        ]);
    }

    #[Route('/create-new', name: 'app_administrator_organization_create-new', methods: ['GET', 'POST'])]
    public function createNew(): Response
    {
        return $this->render('administrator/view/organization/new/index.html.twig', [

        ]);
    }

    #[Route('/show-all', name: 'app_administrator_organization_show-all', methods: ['GET'])]
    public function getAllOrganizations(): Response
    {
        return $this->render('administrator/view/organization/showAll/index.html.twig', [

        ]);
    }
}