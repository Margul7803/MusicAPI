<?php

namespace App\DataPersister;

use ApiPlatform\State\ProcessorInterface;
use Psr\Log\LoggerInterface;
use App\Dto\UserInput;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Metadata\Operation;

class UserDataPersister implements ProcessorInterface
{
    private $passwordEncoder;
    private $entityManager;
    private $logger;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }
    public function process($data, Operation $operation, array $variable = [], array $context = [])
    {
        echo('Persisting a new user');
        $user = new User();
        $user->setEmail($data->email);
        $user->setPassword($data->password);
        $user->setPseudo($data->pseudo);
        $user->setNom($data->nom);
        $user->setPrenom($data->prenom);
        $user->setTel($data->tel);


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