<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\LetterType;
use AppBundle\Form\WordGuessType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/**
 * @Route("/game")
 * @Security("has_role('ROLE_USER')") 
 */
class GameController extends Controller {

    /**
     * @Route("/", name="game")
     * @param Request $request
     */
    public function indexAction(Request $request) {

        $context = $this->container->get('app.hangman_context');
        $wordContext = $this->container->get('app.hangman_word_service')->getWordContext();
        $form = $this->createForm(LetterType::class);
        $formWord = $this->createForm(WordGuessType::class);
        
        if (!$game = $context->loadGame()) {
            
            $game = $context->newGame($wordContext);
            $context->save($game);
            $statsService = $this->container->get('app.hangman_stats_service');
            $statsService->increaseGamesPlayed($this->getUser());
        }

        return $this->render('game/index.html.twig', [
                    'game' => $game,
                    'form' => $form->createView(),
                    'formWord' => $formWord->createView()
        ]);
    }

    /**
     * @Route("/letter", name="try_letter")     
     * 
     * @param Request $request
     */

    public function letterAction(Request $request) {

        $context = $this->container->get('app.hangman_context');

        $form = $this->createForm(LetterType::class);
        $form->handleRequest($request);

        if (!$game = $context->loadGame()) {
            throw $this->createNotFoundException('Unable to load the previous game context.');
        }
        if ($form->isSubmitted() && $form->isValid()) {
            
            $statsService = $this->container->get('app.hangman_stats_service');
            $statsService->increaseLettersGuessed($this->getUser());
            
            $letter = $form->get('letter')->getData();
            $game->tryLetter($letter);
            $context->save($game);
            
            if ($game->isWon()) {
                return $this->redirect($this->generateUrl('game_won'));
            }
            if ($game->isHanged()) {
                return $this->redirect($this->generateUrl('game_hanged'));
            }
        }
        
        $formWord = $this->createForm(WordGuessType::class);
        return $this->render('game/index.html.twig', [
                    'game' => $game,
                    'form' => $form->createView(),
                    'formWord' => $formWord->createView()
        ]);
    }

    /**
     * 
     * @Route("/word", name="try_word")  
     * @param Request $request  
     */
    public function wordAction(Request $request) {

        $context = $this->container->get('app.hangman_context');
        if (!$game = $context->loadGame()) {
            throw $this->createNotFoundException('Unable to load the previous game context.');
        }
        $formWord = $this->createForm(WordGuessType::class);
        $formWord->handleRequest($request);
        if ($formWord->isSubmitted() && $formWord->isValid()) {
            $game->tryWord($formWord->get('word')->getData());
            $context->save($game);
            
            $statsService = $this->container->get('app.hangman_stats_service');
            $statsService->increasedWholeWordsGuessed($this->getUser());
            
            if ($game->isWon()) {
                return $this->redirect($this->generateUrl('game_won'));
            }
            return $this->redirect($this->generateUrl('game_hanged'));
        }

        $form = $this->createForm(LetterType::class);
        
        return $this->render('game/index.html.twig', [
                    'game' => $game,
                    'form' => $form->createView(),
                    'formWord' => $formWord->createView()
        ]);
        
    }

    /**
     *
     * @Route("/hanged", name="game_hanged")
     * @param Request $request
     * @return array Template variables
     * @throws NotFoundHttpException
     */
    public function hangedAction() {

        $context = $this->container->get('app.hangman_context');
        if (!$game = $context->loadGame()) {
            throw $this->createNotFoundException('Unable to load the previous game context.');
        }
        if (!$game->isHanged()) {
            throw $this->createNotFoundException('User is not yet hanged.');
        }
        $statsService = $this->container->get('app.hangman_stats_service');
        $statsService->increaseGamesLost($this->getUser());
        return $this->render('game/hanged.html.twig', [
                    'word' => $game->getWord()
        ]);
    }

    /**
     *
     * @Route("/won", name="game_won")
     *
     * @return array Template variables
     * @throws NotFoundHttpException
     */
    public function wonAction() {
        $context = $this->container->get('app.hangman_context');

        if (!$game = $context->loadGame()) {
            throw $this->createNotFoundException('Unable to load the previous game context.');
        }
        if (!$game->isWon()) {
            throw $this->createNotFoundException('Game is not yet won.');
        }
        $statsService = $this->container->get('app.hangman_stats_service');
        $statsService->increaseGamesWon($this->getUser());
        return $this->render('game/won.html.twig', [
                    'word' => $game->getWord()
        ]);
    }

    /**
     * @Route("/reset", name="game_reset")
     *
     * @return RedirectResponse
     */
    public function resetAction() {
        $context = $this->container->get('app.hangman_context');
        $context->reset();

        return $this->redirect($this->generateUrl('game'));
    }

}
