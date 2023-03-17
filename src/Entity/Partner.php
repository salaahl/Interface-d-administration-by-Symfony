<?php

namespace App\Entity;

use App\Repository\PartnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartnerRepository::class)]
class Partner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'partners')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Brand $brand_name = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $rights = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $drinks_permission = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $newsletter_permission = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $planning_permission = null;

    #[ORM\OneToMany(mappedBy: 'city', targetEntity: Structure::class, orphanRemoval: true)]
    private Collection $structures;

    public function __construct()
    {
        $this->structures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrandName(): ?Brand
    {
        return $this->brand_name;
    }

    public function setBrandName(?Brand $brand_name): self
    {
        $this->brand_name = $brand_name;

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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRights(): ?int
    {
        return $this->rights;
    }

    public function setRights(int $rights): self
    {
        $this->rights = $rights;

        return $this;
    }

    public function getDrinksPermission(): ?int
    {
        return $this->drinks_permission;
    }

    public function setDrinksPermission(?int $drinks_permission): self
    {
        $this->drinks_permission = $drinks_permission;

        return $this;
    }

    public function getNewsletterPermission(): ?int
    {
        return $this->newsletter_permission;
    }

    public function setNewsletterPermission(?int $newsletter_permission): self
    {
        $this->newsletter_permission = $newsletter_permission;

        return $this;
    }

    public function getPlanningPermission(): ?int
    {
        return $this->planning_permission;
    }

    public function setPlanningPermission(?int $planning_permission): self
    {
        $this->planning_permission = $planning_permission;

        return $this;
    }

    /**
     * @return Collection<int, Structure>
     */
    public function getStructures(): Collection
    {
        return $this->structures;
    }

    public function addStructure(Structure $structure): self
    {
        if (!$this->structures->contains($structure)) {
            $this->structures->add($structure);
            $structure->setCity($this);
        }

        return $this;
    }

    public function removeStructure(Structure $structure): self
    {
        if ($this->structures->removeElement($structure)) {
            // set the owning side to null (unless already changed)
            if ($structure->getCity() === $this) {
                $structure->setCity(null);
            }
        }

        return $this;
    }
}
