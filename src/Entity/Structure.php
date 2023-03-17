<?php

namespace App\Entity;

use App\Repository\StructureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StructureRepository::class)]
class Structure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'structures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Brand $brand_name = null;

    #[ORM\ManyToOne(inversedBy: 'structures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Partner $city = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

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

    #[ORM\Column(length: 255)]
    private ?string $address = null;

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

    public function getCity(): ?Partner
    {
        return $this->city;
    }

    public function setCity(?Partner $city): self
    {
        $this->city = $city;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }
}
