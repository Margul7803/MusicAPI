<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserPlaylistsController extends AbstractController
{
    private UserRepository $userRepository;
    private PlaylistRepository $playlistRepository;

    public function __construct(UserRepository $userRepository, PlaylistRepository $playlistRepository)
    {
        $this->userRepository = $userRepository;
        $this->playlistRepository = $playlistRepository;
    }

    public function __invoke(string $id): Response
    {
        // Fetch the user by ID
        $user = $this->userRepository->find($id);

        // Check if the user was found
        if (!$user) {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        // Fetch playlists associated with the user
        $playlists = $this->playlistRepository->findBy(['user' => $user]);

        // Return the playlists in JSON format
        return $this->json($playlists);
    }
}