<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Psr\Log\LoggerInterface;
use App\Dto\UserInput;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserDataPersister implements ContextAwareDataPersisterInterface
{
    private $passwordEncoder;
    private $entityManager;
    private $logger;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof UserInput;
    }

    public function persist($data, array $context = [])
    {
        $this->logger->info('Persisting a new user');
        $user = new User();
        $user->setEmail($data->email);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $data->password));
        $user->setPseudo($data->pseudo);
        $user->setNom($data->nom);
        $user->setPrenom($data->prenom);
        $user->setTel($data->tel);
        $user->setIsVerified(true);
        $user->setRoles(["USER"]);
        $user->setArtiste("/api/artistes/71");


        $this->logger->info('User created with email: ' . $user->getEmail());

        // Enregistrement de l'utilisateur dans la base de données
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->logger->info('User persisted and flushed');

        return $user;
    }

    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}