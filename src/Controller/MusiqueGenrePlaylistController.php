<?php

namespace App\Controller;

use App\Repository\MusiqueRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class MusiqueGenrePlaylistController extends AbstractController
{
    private MusiqueRepository $musiqueRepository;
    private PlaylistRepository $playlistRepository;

    public function __construct(MusiqueRepository $musiqueRepository, PlaylistRepository $playlistRepository)
    {
        $this->musiqueRepository = $musiqueRepository;
        $this->playlistRepository = $playlistRepository;
    }

    public function __invoke(string $id, string $name): Response
    {
        // Fetch the user by ID
        $playlist = $this->playlistRepository->find($id);

        // Check if the user was found
        if (!$playlist) {
            return $this->json($playlist);
        }

        // Fetch musiques associated with the playlist
        $musiques = $playlist->getMusiques();


        $musiques = $this->musiqueRepository->findBy(['genre' => $name]);
        // Return the playlists in JSON format
        return $this->json($musiques);
    }
}
