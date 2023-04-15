<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Manager\HandManager;
use App\Repository\CardCardValueRepository;
use App\Repository\CardColorRepository;
use App\Repository\CardValueRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/', name: 'app_game')]
    public function index(): Response
    {
        return $this->render('game/index.html.twig');
    }

    #[Route('/nouvelle-partie', name: 'app_game_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $game = new Game();
        $gameForm = $this->createForm(GameType::class, $game);
        $gameForm->handleRequest($request);

        if ($gameForm->isSubmitted() && $gameForm->isValid()) {
            $entityManager->persist($game);
            $entityManager->flush();
            return $this->redirectToRoute('app_game_show_unordered_hand', [
                'id' => $game->getId()
            ]);
        }

        return $this->render('game/new.html.twig', [
            'gameForm' => $gameForm->createView(),
        ]);
    }

    #[Route('/partie/{id<\d+>}/main-non-ordonnee', name: 'app_game_show_unordered_hand')]
    public function show_unordered_hand(Game $game, HandManager $handManager): Response
    {
        if ($game->getHand() === \null) $handManager->constructHand($game);
        return $this->render('game/show_unordered_hand.html.twig', [
            'game' => $game
        ]);
    }

    #[Route('/partie/{id<\d+>}/main-ordonnee', name: 'app_game_show_ordered_hand')]
    public function show_ordered_hand(Game $game, HandManager $handManager): Response
    {
        $cards = $handManager->sortHandAndGetIt($game);
        return $this->render('game/show_ordered_hand.html.twig', [
            'game' => $game,
            'cards' => $cards,
        ]);
    }
}
