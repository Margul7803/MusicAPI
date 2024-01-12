<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MusiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use App\Filter\RegexpFilter;

#[ORM\Entity(repositoryClass: MusiqueRepository::class)]
#[ApiResource]
#[ApiFilter(RegexpFilter::class)]
class Musique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateSortie = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $parole = null;

    #[ORM\ManyToMany(targetEntity: Artiste::class)]
    private Collection $Artiste;

    #[ORM\ManyToOne]
    private ?Album $Album = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Genre $genre = null;

    #[ORM\ManyToMany(targetEntity: Playlist::class, mappedBy: 'musiques')]
    private Collection $playlists;

    public function __construct()
    {
        $this->Artiste = new ArrayCollection();
        $this->playlists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function gettitre(): ?string
    {
        return $this->titre;
    }

    public function settitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getduree(): ?int
    {
        return $this->duree;
    }

    public function setduree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->dateSortie;
    }

    public function setDateSortie(\DateTimeInterface $dateSortie): static
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    public function getParole(): ?string
    {
        return $this->parole;
    }

    public function setParole(?string $parole): static
    {
        $this->parole = $parole;

        return $this;
    }

    /**
     * @return Collection<int, Artiste>
     */
    public function getArtiste(): Collection
    {
        return $this->Artiste;
    }

    public function addArtiste(Artiste $artiste): static
    {
        if (!$this->Artiste->contains($artiste)) {
            $this->Artiste->add($artiste);
        }

        return $this;
    }

    public function removeArtiste(Artiste $artiste): static
    {
        $this->Artiste->removeElement($artiste);

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->Album;
    }

    public function setAlbum(?Album $Album): static
    {
        $this->Album = $Album;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function updateMusique(array $data): self
    {
        foreach ($data as $key => $value) {
            $setter = 'set' . ucfirst($key);

            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Playlist>
     */
    public function getPlaylists(): Collection
    {
        return $this->playlists;
    }

    public function addPlaylist(Playlist $playlist): static
    {
        if (!$this->playlists->contains($playlist)) {
            $this->playlists->add($playlist);
            $playlist->addMusique($this);
        }

        return $this;
    }

    public function removePlaylist(Playlist $playlist): static
    {
        if ($this->playlists->removeElement($playlist)) {
            $playlist->removeMusique($this);
        }

        return $this;
    }
}
