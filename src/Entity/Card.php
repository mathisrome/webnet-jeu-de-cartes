<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardRepository::class)]
class Card
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cards')]
    private ?Hand $hand = null;

    #[ORM\Column(length: 255)]
    private ?string $color = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    public function __toString()
    {
        return \sprintf('%s %s', $this->color, $this->value);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHand(): ?Hand
    {
        return $this->hand;
    }

    public function setHand(?Hand $hand): self
    {
        $this->hand = $hand;

        return $this;
    }

    /**
     * Get the value of color
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * Set the value of color
     */
    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get the value of value
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * Set the value of value
     */
    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getImage()
    {
        if ($this->color === 'Carreau') {
            $color = 's';
        } elseif ($this->color === 'Coeur') {
            $color = 'h';
        } elseif ($this->color === 'Trèfle') {
            $color = 'c';
        } else {
            $color = 'd';
        }

        return \sprintf('%s%s.gif', \strtolower($this->getValue()), $color);
    }
}
