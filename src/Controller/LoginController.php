<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login_form")
     */
    public function login(): Response
    {
        return $this->render('Connexion/login.html.twig', [
            'login' => 'ta mere',
        ]);
    }
}
