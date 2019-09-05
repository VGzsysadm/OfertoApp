<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $discount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $referal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $oldprice;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $newprice;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $finish;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    public function setDiscount(string $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getReferal(): ?string
    {
        return $this->referal;
    }

    public function setReferal(string $referal): self
    {
        $this->referal = $referal;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getOldprice(): ?string
    {
        return $this->oldprice;
    }

    public function setOldprice(string $oldprice): self
    {
        $this->oldprice = $oldprice;

        return $this;
    }

    public function getNewprice(): ?string
    {
        return $this->newprice;
    }

    public function setNewprice(string $newprice): self
    {
        $this->newprice = $newprice;

        return $this;
    }

    public function getFinish(): ?bool
    {
        return $this->finish;
    }

    public function setFinish(?bool $finish): self
    {
        $this->finish = $finish;

        return $this;
    }
}
