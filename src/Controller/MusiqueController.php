<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Musique;


class MusiqueController extends AbstractController
{
    #[Route('/musiques', name: 'list_musiques', methods: ['GET'])]
    public function listMusiques(ManagerRegistry $orm): Response
    {
        $musiques = $orm->getRepository(Musique::class)->findAll();
        $musiquesArray = [];
        foreach ($musiques as $musique) {
            $musiquesArray[] = [
                'id' => $musique->getId(),
                'titre' => $musique->getTitre(),
                'duree' => $musique->getDuree(),
                'dateSortie' => $musique->getDateSortie()->format('Y-m-d'),
                'parole' => $musique->getParole(),
            ];
        }

        // Utilisez la classe Response pour retourner une réponse classique
        return new Response(json_encode($musiquesArray), 200, ['Content-Type' => 'application/json']);
    }

    #[Route('/musiques/album/{id}', name: 'list_musiques_albums', methods: ['GET'])]
    public function listMusiquesAlb(ManagerRegistry $orm, $id): Response
    {
        $musiques = $orm->getRepository(Musique::class)->findAll();
        $musiquesArray = [];
        foreach ($musiques as $musique) {
            $alb = $musique->getAlbum();
            if ($alb->getId() == $id) {
                $musiquesArray[] = [
                    'id' => $musique->getId(),
                    'titre' => $musique->getTitre(),
                    'duree' => $musique->getDuree(),
                    'dateSortie' => $musique->getDateSortie()->format('Y-m-d'),
                    'parole' => $musique->getParole(),
                ];
            }
        }

        // Utilisez la classe Response pour retourner une réponse classique
        return $this->render('musique/index.html.twig',
                            ['liste' => $musiquesArray]);
    }

    #[Route('/musiques/{id}', name: 'list_Autremusiques_albums', methods: ['GET'])]
    public function listAutreMusiquesAlb(ManagerRegistry $orm, $id): Response
    {
        $musique = $orm->getRepository(Musique::class)->find($id);
        $alb = $musique->getAlbum();

        $musiques = $orm->getRepository(Musique::class)->findAll();
        $musiquesArray = [];
        foreach ($musiques as $msc) {
            $albTemp = $msc->getAlbum();
            $idAlb = $albTemp->getId();
            if ($alb->getId() == $idAlb && $msc != $musique) {
                $musiquesArray[] = [
                    'id' => $msc->getId(),
                    'titre' => $msc->getTitre(),
                    'duree' => $msc->getDuree(),
                    'dateSortie' => $msc->getDateSortie()->format('Y-m-d'),
                    'parole' => $msc->getParole(),
                ];
            }
        }


        // Utilisez la classe Response pour retourner une réponse classique
        return $this->json($musiquesArray);
    }

    #[Route('/musiques/del/{id}', name: 'delete_musique', methods: ['DELETE'])]
    public function deleteMusique(ManagerRegistry $orm, $id): Response
    {
        $musique = $orm->getRepository(Musique::class)->find($id);
        $orm->getRepository(Musique::class)->remove($musique);
    }
}

