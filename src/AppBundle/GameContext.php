<?php

namespace AppBundle;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\WordContext;
use AppBundle\Game;
class GameContext
{
    private $session;
    public function __construct(Session $session)
    {
        $this->session = $session;
    }
    /**
     * Reset game context
     */
    public function reset()
    {
        $this->session->set('hangman', array());
    }
    /**
     * Create a new game 
     * @param WordContext $wordContext
     * @return Game
     */
    public function newGame(WordContext $wordContext)
    {
        return new Game($wordContext);
    }
    /**
     * Load game context from session 
     * or create new game if no game is found
     * 
     * @return Game|boolean
     */
    public function loadGame()
    {
        $data = $this->session->get('hangman'); 
        if (!$data) {
            return false;
        }              
        return new Game($data['wordContext'], $data['attempts']);
    }
    /**
     * Save current game
     * @param Game $game
     */
    public function save(Game $game)
    {
        $this->session->set('hangman', $game->gameData());
    }    
}