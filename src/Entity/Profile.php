<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Profile
{
    use TimeStampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 70)]
    private $url;

    #[ORM\Column(type: 'string', length: 255)]
    private $reseau_social;

    #[ORM\OneToOne(mappedBy: 'Profile', targetEntity: Personne::class, cascade: ['persist', 'remove'])]
    private $personne;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getReseauSocial(): ?string
    {
        return $this->reseau_social;
    }

    public function setReseauSocial(string $reseau_social): self
    {
        $this->reseau_social = $reseau_social;

        return $this;
    }

    public function getPersonne(): ?Personne
    {
        return $this->personne;
    }

    public function setPersonne(?Personne $personne): self
    {
        // unset the owning side of the relation if necessary
        if ($personne === null && $this->personne !== null) {
            $this->personne->setProfile(null);
        }

        // set the owning side of the relation if necessary
        if ($personne !== null && $personne->getProfile() !== $this) {
            $personne->setProfile($this);
        }

        $this->personne = $personne;

        return $this;
    }
}
