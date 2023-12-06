<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginSignUpController extends AbstractController
{
    /**
     * @Route("/login", name="login_form")
     */
    public function login(): Response
    {
        return $this->render('base.html.twig', [
            'login' => 'ta mere'
    ]);
    }

        /**
     * @Route("/signup", name="signup_form")
     */
    public function signup(): Response
    {
        return $this->render('LoginSignUp/signup.html.twig', [
            'signup' => 'ta mere'
    ]);
    }
}
