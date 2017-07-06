<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStats
 *
 * @ORM\Table(name="user_stats")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserStatsRepository")
 */
class UserStats
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string     
     * One user has One user statistic.
     * @ORM\OneToOne(targetEntity="User", inversedBy="userStats")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var float
     *
     * @ORM\Column(name="letters_guessed", type="float", nullable=true)
     */
    private $lettersGuessed;

    /**
     * @var int
     *
     * @ORM\Column(name="games_played", type="integer", nullable=true)
     */
    private $gamesPlayed;

    /**
     * @var int
     *
     * @ORM\Column(name="games_won", type="integer", nullable=true)
     */
    private $gamesWon;

    /**
     * @var int
     *
     * @ORM\Column(name="games_lost", type="integer", nullable=true)
     */
    private $gamesLost;

    
    /**
     *
     * @var int
     * @ORM\Column(name="whole_words_guessed", type="integer", nullable=true)
     */
    private $wholeWordsGuessed;

    
    
    public function __construct(User $user) {
        $this->user = $user;
        $this->gamesLost = 0;
        $this->gamesWon = 0;
        $this->gamesPlayed = 0;
        $this->lettersGuessed = 0;
        $this->wholeWordsGuessed = 0;
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param string $userId
     *
     * @return UserStats
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set lettersGuessed
     *
     * @param float $lettersGuessed
     * @return UserStats
     */
    public function setLettersGuessed($lettersGuessed)
    {
        $this->lettersGuessed = $lettersGuessed;

        return $this;
    }

    /**
     * Get lettersGuseed
     *
     * @return float
     */
    public function getLettersGuessed()
    {
        return $this->lettersGuessed;
    }
    
    /**
     * Increase letters guessed statistic by 1
     * @return UserStats
     */
     public function increaseLettersGuessed(){
        $this->lettersGuessed++;
        return $this;
    }
    /**
     * Set gamesPlayed
     *
     * @param integer $gamesPlayed
     *
     * @return UserStats
     */
    public function setGamesPlayed($gamesPlayed)
    {
        $this->gamesPlayed = $gamesPlayed;

        return $this;
    }

    /**
     * Get gamesPlayed
     *
     * @return int
     */
    public function getGamesPlayed()
    {
        return $this->gamesPlayed;
    }
    
     
    /**
     * Increase games played statistic by 1
     * @return UserStats
     */
     public function increaseGamesPlayed(){
        $this->gamesPlayed++;
        return $this;
    }
    /**
     * Set gamesWon
     *
     * @param integer $gamesWon
     *
     * @return UserStats
     */
    public function setGamesWon($gamesWon)
    {
        $this->gamesWon = $gamesWon;

        return $this;
    }

    /**
     * Get gamesWon
     *
     * @return int
     */
    public function getGamesWon()
    {
        return $this->gamesWon;
    }
    
    /**
     * Increase games won statistic by 1
     * @return UserStats
     */
     public function increaseGamesWon(){
        $this->gamesWon++;
        return $this;
    }
    /**
     * Set gamesLost
     *
     * @param integer $gamesLost
     *
     * @return UserStats
     */
    public function setGamesLost($gamesLost)
    {
        $this->gamesLost = $gamesLost;

        return $this;
    }

    /**
     * Get gamesLost
     * @return int
     */
    public function getGamesLost()
    {
        return $this->gamesLost;
    }
    /**
     * Increase Games Lost count by 1
     * @return UserStats
     */
    public function increaseGamesLost(){
        $this->gamesLost++;
        return $this;
    }
    
    
     /**
     * Set wholeWordsGussed
     * @param integer $wholeWordsGuessed
     * @return UserStats
     */
    public function setWholeWordsGuessed($wholeWordsGuessed)
    {
        $this->wholeWordsGuessed = $wholeWordsGuessed;

        return $this;
    }

    /**
     * Get wholeWordsGuessed
     * @return int
     */
    public function getWholeWordsGuessed()
    {
        return $this->wholeWordsGuessed;
    }
    /**
     * Increase whole words guessed count by 1
     * @return UserStats
     */
    public function increasedWholeWordsGuessed(){
        $this->wholeWordsGuessed++;
        return $this;
    }
    
    
}

