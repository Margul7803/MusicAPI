<?php

namespace App\Controller;

use App\Entity\Artiste;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
class ArtisteController extends AbstractController
{
    /**
     * @Route("/api/artistes", name="api_artistes_list", methods={"GET"})
     */
    public function listArtists(EntityManagerInterface $entityManager): JsonResponse
    {
        $artistes = $entityManager->getRepository(Artiste::class)->findAll();
        $data = [];

        foreach ($artistes as $artiste) {
            $data[] = $this->serializeArtiste($artiste);
        }

        return $this->json($data, 200, [], ['groups' => 'api']);
    }
    /**
     * @Route("/api/artistes", name="api_artiste_create", methods={"POST"})
     */
    public function createArtiste(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $artiste = new Artiste();
        $artiste->setNom($data['nom'] ?? null);
        $artiste->setGenre($data['genre'] ?? null);
        $artiste->setBio($data['bio'] ?? null);
        $artiste->setReseau($data['reseau'] ?? null);

        $entityManager->persist($artiste);
        $entityManager->flush();

        return $this->json($this->serializeArtiste($artiste), 201, [], ['groups' => 'api']);
    }
    /**
     * @Route("/api/artistes/{id}", name="api_artiste_detail", methods={"GET"})
     */
    public function getArtisteDetail(Artiste $artiste): JsonResponse
    {
        $data = $this->serializeArtiste($artiste);

        return $this->json($data, 200, [], ['groups' => 'api']);
    }

    private function serializeArtiste(Artiste $artiste): array
    {
        return [
            'id'    => $artiste->getId(),
            'nom'   => $artiste->getNom(),
            'genre' => $artiste->getGenre(),
            'bio'   => $artiste->getBio(),
            'reseau'=> $artiste->getReseau(),
        ];
    }
    /**
     * @Route("/api/artistes/{id}", name="api_artiste_update", methods={"PUT"})
     */
    public function updateArtiste(Request $request, Artiste $artiste, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $artiste->setNom($data['nom'] ?? $artiste->getNom());
        $artiste->setGenre($data['genre'] ?? $artiste->getGenre());
        $artiste->setBio($data['bio'] ?? $artiste->getBio());
        $artiste->setReseau($data['reseau'] ?? $artiste->getReseau());

        $entityManager->persist($artiste);
        $entityManager->flush();

        return $this->json($this->serializeArtiste($artiste), 200, [], ['groups' => 'api']);
    }

    /**
     * @Route("/api/artistes/{id}", name="api_artiste_delete", methods={"DELETE"})
     */
    public function deleteArtiste(Artiste $artiste, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($artiste);
        $entityManager->flush();

        return $this->json(['message' => 'Artiste supprimé avec succès.'], 204);
    }
}
