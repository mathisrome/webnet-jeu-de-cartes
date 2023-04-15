<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Unique;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    public const VALEURS = ['AS', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Valet', 'Dame', 'Roi'];
    public const COLORS = ['Carreau', 'Coeur', 'Trèfle', 'Pique'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Range(min: 2, max: 52)]
    private ?int $nbCards = null;

    #[ORM\OneToOne(inversedBy: 'game', cascade: ['persist', 'remove'])]
    private ?Hand $hand = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    #[Unique(message: 'Les éléments de la liste des couleurs doivent être unique')]
    private array $colors = [];

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    #[Unique(message: 'Les éléments de la liste des valeurs doivent être unique')]
    private array $valeurs = [];

    public function __construct()
    {
        $valeurs = self::VALEURS;
        \shuffle($valeurs);
        $this->valeurs = $valeurs;

        $colors = self::COLORS;
        \shuffle($colors);
        $this->colors = $colors;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbCards(): ?int
    {
        return $this->nbCards;
    }

    public function setNbCards(int $nbCards): self
    {
        $this->nbCards = $nbCards;

        return $this;
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
     * Get the value of colors
     */
    public function getColors(): array
    {
        return $this->colors;
    }

    public function setColors(array $colors): self
    {
        $this->colors = $colors;

        return $this;
    }

    public function getValeurs(): array
    {
        return $this->valeurs;
    }

    public function setValeurs(array $valeurs): self
    {
        $this->valeurs = $valeurs;

        return $this;
    }
}
