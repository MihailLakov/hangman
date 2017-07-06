<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
class StatsController extends Controller
{
    /**
     * @Route("/statistics", name="statistics")
     */
    public function indexAction(Request $request)
    {                   
        $statsService = $this->container->get('app.hangman_stats_service');        
        $stats = $statsService->getStatisticsForUser($this->getUser());
        return $this->render('game/statistics.html.twig', [
            'stats' => $stats
        ]);
    }
    
    
}
