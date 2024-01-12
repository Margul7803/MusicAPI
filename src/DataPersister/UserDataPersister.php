<?php

namespace App\DataPersister;

use ApiPlatform\State\ProcessorInterface;
use App\Dto\UserInput;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Metadata\Operation;

class UserDataPersister implements ProcessorInterface
{
    private $passwordEncoder;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }
    public function process($data, Operation $operation, array $variable = [], array $context = [])
    {
        $user = new User();
        $user->setEmail($data->email);
        $user->setPassword($data->password);
        $user->setPseudo($data->pseudo);
        $user->setNom($data->nom);
        $user->setPrenom($data->prenom);
        $user->setTel($data->tel);

        // Enregistrement de l'utilisateur dans la base de données
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }

    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}