<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepartementRepository")
 */
class Departement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numero_departement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_departement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroDepartement(): ?int
    {
        return $this->numero_departement;
    }

    public function setNumeroDepartement(int $numero_departement): self
    {
        $this->numero_departement = $numero_departement;

        return $this;
    }

    public function getNomDepartement(): ?string
    {
        return $this->nom_departement;
    }

    public function setNomDepartement(string $nom_departement): self
    {
        $this->nom_departement = $nom_departement;

        return $this;
    }
}
