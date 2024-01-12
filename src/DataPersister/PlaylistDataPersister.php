<?php

namespace App\DataPersister;

use ApiPlatform\State\ProcessorInterface;
use App\Entity\Playlist;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Metadata\Operation;
use App\Repository\UserRepository;

class PlaylistDataPersister implements ProcessorInterface
{
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    public function process($data, Operation $operation, array $variable = [], array $context = [])
    {
        $playlist = new Playlist();
        $playlist->setTitre($data->titre);

        if ($data->user_id) {
            $user = $this->userRepository->find($data->user_id);
            if ($user) {
                $playlist->setUser($user);

                $this->entityManager->persist($playlist);
                $this->entityManager->flush();

                // After persisting the playlist, add it to the user's playlists
                // This will also update the playlistLinks in User entity
                $user->addPlaylist($playlist);
                $this->entityManager->persist($user);
                $this->entityManager->flush();

            } else {
                throw new \Exception("Utilisateur non trouvé.");
            }
        } else {
            $this->entityManager->persist($playlist);
            $this->entityManager->flush();
        }

        return $playlist;
    }

    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}