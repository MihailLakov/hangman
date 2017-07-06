<?php

namespace AppBundle;
use AppBundle\Entity\Word;
class WordContext {

    private $word;
    private $category;
    private $hint;
    private $foundLetters;
    private $triedLetters;
    
    /**
     * 
     * @param Word $word
     */
    public function __construct(Word $word) {
        $this->word = strtolower($word->getWord());
        $this->category = strtolower($word->getCategory()->getTitle());
        $this->hint = strtolower($word->getHint());
        $this->foundLetters = array();
        $this->triedLetters = array();
        $this->setInitialFoundLetters();
    }
    
    /**
     * Sets first and last letter of the word as found
     */
    public function setInitialFoundLetters(){        
        $letters = $this->split();        
        $wordLenth = strlen($this->getWord());        
        $this->foundLetters[] = $letters[0];
        $this->foundLetters[] = $letters[$wordLenth-1];
    }
    
    /**
     * Split the word into letters 
     * @return array
     */
    public function split() {
        return str_split($this->word);
    }
    
    /**
     * Set all letters as found
     */
    public function guessed() {
        $this->foundLetters = $this->getLetters();
    }
    
    /**
     * @return Array found letters
     */
    public function getFoundLetters() {
        return $this->foundLetters;
    }
    /**
     * 
     * @return Array tried letters
     */
    public function getTriedLetters() {
        return $this->triedLetters;
    }

    /**
     * Get all letters of the workd
     * @return Array 
     */
    public function getLetters() {
        return array_unique(str_split($this->word));
    }
    
    /**
     * Test if the word is guess by comparing word letters with found letters
     * @return boolean
     */
    public function isGuessed() {        
        $diff = array_diff($this->getLetters(), $this->foundLetters);
        return 0 === count($diff);
    }
  
    /**
     * Test if a letter is contained in the word
     * @param string $letter
     * @return boolean
     * @throws \InvalidArgumentException
     */    
    public function tryLetter($letter) {        
        $letter = strtolower($letter);       

        if (in_array($letter, $this->triedLetters)) {
            throw new \InvalidArgumentException(sprintf('The letter "%s" has already been tried.', $letter));
        }

        $this->triedLetters[] = $letter;
        if (false !== strpos($this->word, $letter)) {
            $this->foundLetters[] = $letter;
            return true;
        }
        return false;
    }
    
    /**
     * @return string
     */
    public function getWord() {
        return $this->word;
    }
    
    /**
     * @return string
     */
    public function getCategory(){
        return $this->category;        
    }
    
    /**
     * @return string
     */
    public function getHint(){
        return $this->hint;
    }

}
