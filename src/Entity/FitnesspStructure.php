<?php

namespace App\Entity;

use App\Repository\FitnesspStructureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: FitnesspStructureRepository::class)]
#[UniqueEntity(fields: ['adresse'], message: 'Cette adresse est déjà utilisée.')]
class FitnesspStructure implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Column(length: 100)]
    #[ORM\ManyToOne(targetEntity: FitnesspPartenaire::class, inversedBy: 'mail')]
    private ?string $mail_partenaire = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $adresse = null;

    #[ORM\Id]
    #[ORM\Column(length: 100)]
    private ?string $mail = null;

    #[ORM\Column(length: 100)]
    private ?string $mot_de_passe = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $niveau_droits = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $premiere_connexion = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $perm_boissons = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $perm_planning = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $perm_newsletter = null;


    public function getMailPartenaire(): ?string
    {
        return $this->mail_partenaire;
    }

    public function setMailPartenaire(string $mail_partenaire): self
    {
        $this->mail_partenaire = $mail_partenaire;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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
        $roles[] = 'ROLE_STRUCTURE';

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