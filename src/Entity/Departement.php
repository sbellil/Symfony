<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="string", length=255)
     */
    private $nom_departement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_responsable;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom_responsable;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email_responsable;

    public function getNomResponsable(): ?string
    {
        return $this->nom_responsable;
    }

    public function setNomResponsable(string $nom_responsable): self
    {
        $this->nom_responsable = $nom_responsable;

        return $this;
    }

    public function getPrenomResponsable(): ?string
    {
        return $this->prenom_responsable;
    }

    public function setPrenomResponsable(string $prenom_responsable): self
    {
        $this->prenom_responsable = $prenom_responsable;

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

    public function getEmailResponsable(): ?string
    {
        return $this->email_responsable;
    }

    public function setEmailResponsable(string $email_responsable): self
    {
        $this->email_responsable = $email_responsable;

        return $this;
    }


}
