<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use AppBundle\WordContext;
use AppBundle\Entity\Word;

class WordService {

    private $entityManager;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }
    
    /**
     * Get a random word from the database
     * @return Word $word
     */
    public function getRandomWord() {

        $repo = $this->entityManager->getRepository('AppBundle:Word');
        $totalWordsCount = $repo->createQueryBuilder('a')
                ->select('count(a.id)')
                ->getQuery()
                ->getSingleScalarResult();

        $word = $repo->createQueryBuilder('w')
                ->where('w.id IN (:id)')
                ->setParameter('id', rand(1, $totalWordsCount))
                ->setMaxResults(1)
                ->getQuery()
                ->getResult();

        return $word;
    }
    /**
     * Create word context from a word
     * @return WordContext
     */
    public function getWordContext(){
        $word = $this->getRandomWord(); 
        
        return new WordContext($word[0]);
    }

}
