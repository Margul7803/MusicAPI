<?php

namespace App\Entity;

<<<<<<< HEAD
use ApiPlatform\Metadata\ApiResource;
use App\Repository\PlaylistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistRepository::class)]
#[ApiResource]
=======
use App\Repository\PlaylistRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistRepository::class)]
>>>>>>> c3ba139b5715676d53e1efcf75abae210cdd12f8
class Playlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

<<<<<<< HEAD
    #[ORM\ManyToMany(targetEntity: Musique::class, inversedBy: 'playlists')]
    private Collection $musiques;

    public function __construct()
    {
        $this->musiques = new ArrayCollection();
    }
=======
    #[ORM\Column(length: 255)]
    private ?string $artist = null;

    #[ORM\Column(length: 255)]
    private ?string $album = null;
>>>>>>> c3ba139b5715676d53e1efcf75abae210cdd12f8

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

<<<<<<< HEAD
    /**
     * @return Collection<int, Musique>
     */
    public function getMusiques(): Collection
    {
        return $this->musiques;
    }

    public function addMusique(Musique $musique): static
    {
        if (!$this->musiques->contains($musique)) {
            $this->musiques->add($musique);
        }
=======
    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(string $artist): static
    {
        $this->artist = $artist;
>>>>>>> c3ba139b5715676d53e1efcf75abae210cdd12f8

        return $this;
    }

<<<<<<< HEAD
    public function removeMusique(Musique $musique): static
    {
        $this->musiques->removeElement($musique);
=======
    public function getAlbum(): ?string
    {
        return $this->album;
    }

    public function setAlbum(string $album): static
    {
        $this->album = $album;
>>>>>>> c3ba139b5715676d53e1efcf75abae210cdd12f8

        return $this;
    }
}
