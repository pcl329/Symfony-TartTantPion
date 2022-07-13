<?php

namespace App\Entity;

use App\Entity\Interfaces\IRole;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, IRole
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'User')]
    private $service;

    #[ORM\Column(type: 'string', length: 80)]
    private $nom;

    #[ORM\Column(type: 'string', length: 80)]
    private $prenom;

    #[ORM\Column(type: 'datetime')]
    private $dateinscription;

    #[ORM\Column(type: 'datetime')]
    private $datenaissance;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateemploi;

    #[ORM\ManyToOne(targetEntity: Poste::class, inversedBy: 'poste')]
    private $Poste;

    public function __construct()
{
    $this->addRole(self::ROLE_MEMBER);
    $this->setDateinscription(new DateTime('now'));
}

public function addRole($role)
{
    array_push($this->roles,$role);
}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateinscription(): ?\DateTimeInterface
    {
        return $this->dateinscription;
    }

    public function setDateinscription(\DateTimeInterface $dateinscription): self
    {
        $this->dateinscription = $dateinscription;

        return $this;
    }

    public function getDatenaissance(): ?\DateTimeInterface
    {
        return $this->datenaissance;
    }

    public function setDatenaissance(\DateTimeInterface $datenaissance): self
    {
        $this->datenaissance = $datenaissance;

        return $this;
    }

    public function getDateemploi(): ?\DateTimeInterface
    {
        return $this->dateemploi;
    }

    public function setDateemploi(?\DateTimeInterface $dateemploi): self
    {
        $this->dateemploi = $dateemploi;

        return $this;
    }

    public function getPoste(): ?Poste
    {
        return $this->Poste;
    }

    public function setPoste(?Poste $Poste): self
    {
        $this->Poste = $Poste;

        return $this;
    }
}
