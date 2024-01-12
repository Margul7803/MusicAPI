<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Patch;
use App\Dto\PlaylistInput;
use App\Repository\PlaylistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(input: Playlist::class, output: PlaylistInput::class),
        new Get(),
        new Put(),
        new Delete(),
        new Patch()
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['user' => 'exact'])]
class Playlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "playlists")]
    #[ORM\JoinColumn(name: "user_email", referencedColumnName: "email")]
    private ?User $user;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\ManyToMany(targetEntity: Musique::class, inversedBy: 'playlists')]
    private Collection $musiques;

    public function __construct()
    {
        $this->musiques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

        return $this;
    }

    public function removeMusique(Musique $musique): static
    {
        $this->musiques->removeElement($musique);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    
}
