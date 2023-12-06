<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginSignUpController extends AbstractController
{
    #[Route('/login', name: 'app_LoginSignUp')]
    public function login(): Response
    {
        return $this->render('loginSignUp/login.html.twig', [
            'login' => 'LoginSignUpController',
        ]);
    }
    #[Route('/signup', name: 'app_LoginSignUp')]
    public function signup(): Response
    {
        return $this->render('loginSignUp/signup.html.twig', [
            'signup' => 'LoginSignUpController',
        ]);
    }
}
