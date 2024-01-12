<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Playlist;
use App\Dto\PlaylistInput;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class PlaylistDataPersister implements ContextAwareDataPersisterInterface
{
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof PlaylistInput;
    }

    public function persist($data, array $context = [])
    {
        $playlist = new Playlist();
        $playlist->setTitre($data->titre);

        if ($data->userEmail) {
            $user = $this->userRepository->find($data->userEmail);
            if ($user) {
                $playlist->setUser($user);
            } else {
                throw new \Exception("Utilisateur non trouvé.");
            }
        }

        $this->entityManager->persist($playlist);
        $this->entityManager->flush();

        return $playlist;
    }

    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}
