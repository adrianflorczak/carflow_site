<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_website_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        if ( $this->getUser() ) {
            return $this->redirectToRoute('app_website_home');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('website/view/login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }
}