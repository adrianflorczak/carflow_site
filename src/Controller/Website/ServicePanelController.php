<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/service-panel')]
class ServicePanelController extends AbstractController
{
    #[Route(
        '/{reactRouterOne}/{reactRouterTwo}/{reactRouterThree}/{reactRouterFour}/{reactRouterFive}/{reactRouterSix}',
        name: 'app_website_servicePanel',
        defaults: [
            'reactRouterOne' => null,
            'reactRouterTwo' => null,
            'reactRouterThree' => null,
            'reactRouterFour' => null,
            'reactRouterFive' => null,
            'reactRouterSix' => null
        ],
        methods: ['GET'],
        priority: 10
    )]
    public function organizationsPanel(): Response {
        return $this->render('website/view/servicePanel/index.html.twig', []);
    }
}