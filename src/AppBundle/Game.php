<?php

namespace AppBundle;

/**
 * Game
 */
class Game {

    const MAX_ATTEMPTS = 5;

    private $wordContext;
    private $attempts;

    public function __construct(WordContext $wordContext, $attempts = 0) {
        $this->wordContext = $wordContext;
        $this->attempts = $attempts;
    }
    
    /**
     * Get game data
     * @return array
     */
    public function gameData() {
        return array(
            'wordContext' => $this->wordContext,
            'attempts' => $this->attempts
        );
    }
    
    /**
     * 
     * @return int
     */
    public function getMaxAttempts() {
        return GAME::MAX_ATTEMPTS;
    }
    /**
     * Get remaining attempts
     * @return int
     */
    public function getRemainingAttempts() {
        return $this->getMaxAttempts() - $this->attempts;
    }
    
    /**
     * @param string $letter
     * @return boolean
     */
    public function isLetterFound($letter) {
        return in_array(strtolower($letter), $this->wordContext->getFoundLetters());
    }
    /**
     * 
     * @param type $letter
     * @return boolean
     */
    public function isLetterTried($letter) {
        return in_array(strtolower($letter), $this->wordContext->getTriedLetters());
    }
    /**
     * Check if the user lost the game
     * @return boolean
     */
    public function isHanged() {
        return $this->getMaxAttempts() === $this->attempts;
    }
    
    /**
     * Check if the user has won the game
     * @return boolean
     */
    public function isWon() {
        return $this->wordContext->isGuessed();
    }

    /**
     * Get the word in current context
     * @return string
     */
    public function getWord() {
        return $this->wordContext->getWord();
    }

    /**
     * Get current word context
     * @return WordContext
     */
    public function getWordContext() {
        return $this->wordContext;
    }
    
    /**
     * Get letters of the current word
     * @return array
     */
    public function getWordLetters() {
        return $this->wordContext->split();
    }
    
    /**
     * Get letters that have been already tried
     * @return array
     */
    public function getTriedLetters() {
        return $this->wordContext->getTriedLetters();
    }
    /**
     * Get hint for current word
     * @return string
     */
    public function getHint() {
        return $this->wordContext->getHint();
    }
    /**
     * Get category for current word
     * @return string
     */
    public function getCategory(){
        return $this->wordContext->getCategory();
    }
    /**
     * Get attempts made so far
     * @return int
     */
    public function getAttempts() {
        return $this->attempts;
    }

    /**
     * Function to test if a letter is guessed correctly 
     * @param string $letter
     * @return boolean
     */
    public function tryLetter($letter) {
        $result = false;
        try {
            $result = $this->wordContext->tryLetter($letter);
        } catch (\InvalidArgumentException $e) {
            $result = false;
        }
        if (false === $result) {
            $this->attempts++;
        }
        return $result;
    }
    
    /**
     * Function to test if a word is guessed correctly 
     * @param string $word
     * @return boolean
     */
    public function tryWord($word) {
        $word = strtolower($word);
        if ($word === $this->getWord()) {
            $this->wordContext->guessed();
            return true;
        }
        $this->attempts = GAME::MAX_ATTEMPTS;
        return false;
    }

}
