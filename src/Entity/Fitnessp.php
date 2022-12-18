<?php

namespace App\Entity;

use App\Repository\FitnesspRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FitnesspRepository::class)]
class Fitnessp
{
    #[ORM\Id]
    #[ORM\Column(length: 10)]
    #[ORM\OneToMany(targetEntity: FitnesspAdmin::class, mappedBy: 'marque')]
    private ?string $marque = null;


    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }
}