<?php

namespace App\Entity;

use App\Repository\PosteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PosteRepository::class)]
class Poste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 80)]
    private $nom;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\OneToMany(mappedBy: 'Poste', targetEntity: User::class, fetch:"EAGER")]
    private $poste;

    public function __construct()
    {
        $this->poste = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getPoste(): Collection
    {
        return $this->poste;
    }

    public function addPoste(User $poste): self
    {
        if (!$this->poste->contains($poste)) {
            $this->poste[] = $poste;
            $poste->setPoste($this);
        }

        return $this;
    }

    public function removePoste(User $poste): self
    {
        if ($this->poste->removeElement($poste)) {
            // set the owning side to null (unless already changed)
            if ($poste->getPoste() === $this) {
                $poste->setPoste(null);
            }
        }

        return $this;
    }
}
