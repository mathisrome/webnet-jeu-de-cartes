<?php

namespace App\Manager;

use App\Entity\Card;
use App\Entity\Game;
use App\Entity\Hand;
use App\Repository\CardColorRepository;
use App\Repository\CardValueRepository;
use Doctrine\ORM\EntityManagerInterface;

class HandManager
{
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function constructHand(Game $game)
    {
        $nbCards = $game->getNbCards();

        $cards = [];
        foreach ($game->getColors() as $color) {
            foreach ($game->getValeurs() as $value) {
                $card = (new Card())
                    ->setColor($color)
                    ->setValue($value);
                array_push($cards, $card);
            }
        }

        \shuffle($cards);

        $cards = array_slice($cards, 0, $nbCards);

        $hand = new Hand();
        foreach ($cards as $card) {
            $hand->addCard($card);
        }

        $game->setHand($hand);
        $this->entityManager->persist($game);
        $this->entityManager->flush();
    }

    public function sortHandAndGetIt(Game $game)
    {
        $colors = $game->getColors();
        $values = $game->getValeurs();
        $cards = $game->getHand()->getCards()->toArray();

        usort($cards, function ($card1, $card2) use ($colors, $values) {
            $color1 = array_search($card1->getColor(), $colors);
            $color2 = array_search($card2->getColor(), $colors);
            if ($color1 == $color2) {
                $value1 = array_search($card1->getValue(), $values);
                $value2 = array_search($card2->getValue(), $values);
                return $value1 - $value2;
            }
            return $color1 - $color2;
        });

        return $cards;
    }
}
