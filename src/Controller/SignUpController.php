<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignUpController extends AbstractController
{
    /**
     * @Route("/signup", name="signup_form")
     */
    public function signup(): Response
    {
        return $this->render('Connexion/signup.html.twig', [
            'signup' => 'ta mere',
        ]);
    }
}
