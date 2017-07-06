<?php

namespace AppBundle\Service;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\User;
use AppBundle\Entity\UserStats;
class GameStatsService
{
    private $entityManager;
    
    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }
    
    /**
     * Increases the games lost statistic by 1
     * @param User $user
     */
    public function increaseGamesLost(User $user){           
        $stats = $this->entityManager->getRepository(UserStats::class)->find($user);
        $stats->increaseGamesLost();
        $this->entityManager->flush();        
    }
    
    /**
     * Increases the games won statistic by 1
     * @param User $user
     */
    public function increaseGamesWon(User $user){           
        $stats = $this->entityManager->getRepository(UserStats::class)->find($user);
        $stats->increaseGamesWon();
        $this->entityManager->flush();        
    }
    
    /**
     * Increases letter guessed statistic by 1
     * @param User $user
     */
    public function increaseLettersGuessed(User $user){           
        $stats = $this->entityManager->getRepository(UserStats::class)->find($user);
        $stats->increaseLettersGuessed();
        $this->entityManager->flush();        
    }
    
    /**
     * Increases the games played statistic by 1
     * @param User $user
     */
    public function increaseGamesPlayed(User $user){           
        $stats = $this->entityManager->getRepository(UserStats::class)->find($user);
        $stats->increaseGamesPlayed();
        $this->entityManager->flush();        
    }
    
    /**
     * Increases the whole words guessed statistic by 1
     * @param User $user
     */
    public function increasedWholeWordsGuessed(User $user){           
        $stats = $this->entityManager->getRepository(UserStats::class)->find($user);
        $stats->increasedWholeWordsGuessed();
        $this->entityManager->flush();        
    }
    
    /**
     * Get statistics for a specific user
     * @param User $user
     * @return UserStats
     */
    public function getStatisticsForUser(User $user){        
        $stats = $this->entityManager->getRepository(UserStats::class)->find($user);
        return $stats;
    }
}