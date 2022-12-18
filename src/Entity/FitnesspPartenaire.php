<?php

namespace App\Entity;

use App\Repository\FitnesspPartenaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/*
J'ai rajouté ici (entre autres) tout ce qui suit après "implements" et TOUTES 
les méthodes après setPermNewsletter. Ce sont elles qui seront lues par la 
page de login.
*/

#[ORM\Entity(repositoryClass: FitnesspPartenaireRepository::class)]
#[UniqueEntity(fields: ['mail'], message: 'Ce mail est déjà utilisé.')]
class FitnesspPartenaire implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Column(length: 10)]
    #[ORM\OneToMany(targetEntity: FitnesspStructure::class, mappedBy: 'mail_partenaire')]
    #[ORM\ManyToOne(targetEntity: Fitnessp::class, inversedBy: 'marque')]
    private ?string $marque = null;

    #[ORM\Column(length: 100, unique: true)]
    private ?string $nom = null;
    
    #[ORM\Id]
    #[ORM\Column(length: 100)]
    private ?string $mail = null;

    #[ORM\Column(length: 100)]
    private ?string $mot_de_passe = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $niveau_droits = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $premiere_connexion = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $nombre_de_structures = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $perm_boissons = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $perm_planning = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $perm_newsletter = null;


    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->mot_de_passe;
    }

    public function setMotDePasse(string $mot_de_passe): self
    {
        $this->mot_de_passe = $mot_de_passe;

        return $this;
    }

    public function getNiveauDroits(): ?int
    {
        return $this->niveau_droits;
    }

    public function setNiveauDroits(int $niveau_droits): self
    {
        $this->niveau_droits = $niveau_droits;

        return $this;
    }

    public function getPremiereConnexion(): ?int
    {
        return $this->premiere_connexion;
    }

    public function setPremiereConnexion(int $premiere_connexion): self
    {
        $this->premiere_connexion = $premiere_connexion;

        return $this;
    }

    public function getNombreDeStructures(): ?int
    {
        return $this->nombre_de_structures;
    }

    public function setNombreDeStructures(int $nombre_de_structures): self
    {
        $this->nombre_de_structures = $nombre_de_structures;

        return $this;
    }

    public function getPermBoissons(): ?int
    {
        return $this->perm_boissons;
    }

    public function setPermBoissons(?int $perm_boissons): self
    {
        $this->perm_boissons = $perm_boissons;

        return $this;
    }

    public function getPermPlanning(): ?int
    {
        return $this->perm_planning;
    }

    public function setPermPlanning(?int $perm_planning): self
    {
        $this->perm_planning = $perm_planning;

        return $this;
    }

    public function getPermNewsletter(): ?int
    {
        return $this->perm_newsletter;
    }

    public function setPermNewsletter(?int $perm_newsletter): self
    {
        $this->perm_newsletter = $perm_newsletter;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->mail;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        // $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_PARTNER';

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
        return $this->mot_de_passe;
    }


    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}