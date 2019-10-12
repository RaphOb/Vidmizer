<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
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
    private $titre;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     */
    private $point;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vente", mappedBy="produit")
     */
    private $ventes;

    public function __construct()
    {
        $this->date_creation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPoint(): ?int
    {
        return $this->point;
    }

    public function setPoint(int $point): self
    {
        $this->point = $point;

        return $this;
    }

    /**
     * @return Collection|Vente[]
     */
    public function getDateCreation(): Collection
    {
        return $this->date_creation;
    }

    public function addDateCreation(Vente $dateCreation): self
    {
        if (!$this->date_creation->contains($dateCreation)) {
            $this->date_creation[] = $dateCreation;
            $dateCreation->setProduit($this);
        }

        return $this;
    }

    public function removeDateCreation(Vente $dateCreation): self
    {
        if ($this->date_creation->contains($dateCreation)) {
            $this->date_creation->removeElement($dateCreation);
            // set the owning side to null (unless already changed)
            if ($dateCreation->getProduit() === $this) {
                $dateCreation->setProduit(null);
            }
        }

        return $this;
    }
}
