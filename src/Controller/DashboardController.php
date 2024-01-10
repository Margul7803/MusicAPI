<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface; 
use App\Entity\Musique; 
use App\Entity\Album;
use App\Entity\Artiste;

class DashboardController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        // Récupérer les musiques
        $musiques = $this->entityManager->getRepository(Musique::class)->findAll();

        // Récupérer les albums
        $albums = $this->entityManager->getRepository(Album::class)->findAll();

        // Récupérer les artists
        $artistes = $this->entityManager->getRepository(Artiste::class)->findAll();

        return $this->render('Dashboard/acceuil.html.twig', [
            'controller_name' => 'DashboardController',
            'musiques' => $musiques,
            'albums' => $albums,
            'artistes' => $artistes,
        ]);
    }

}
