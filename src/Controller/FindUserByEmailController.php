<?php

// src/Controller/FindUserByEmailController.php
namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FindUserByEmailController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/api/users/email", methods={"GET"})
     */
    public function __invoke(Request $request): Response
    {
        $email = $request->query->get('email');
        $user = $this->userRepository->findOneByEmail($email);
        
        // Return the playlists in JSON format
        return $this->json($user);
    }
}
