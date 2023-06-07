<?php

namespace App\Entity;

use App\Repository\PriceListItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PriceListItemRepository::class)]
class PriceListItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $priority = null;

    #[ORM\Column]
    private ?int $least = null;

    #[ORM\Column]
    private ?int $most = null;

    #[ORM\Column]
    private ?int $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getLeast(): ?int
    {
        return $this->least;
    }

    public function setLeast(int $least): self
    {
        $this->least = $least;

        return $this;
    }

    public function getMost(): ?int
    {
        return $this->most;
    }

    public function setMost(int $most): self
    {
        $this->most = $most;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
