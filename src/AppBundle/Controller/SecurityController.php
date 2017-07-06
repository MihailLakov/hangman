<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use AppBundle\Entity\Role;
use AppBundle\Entity\UserStats;
class SecurityController extends Controller 
{

    /**
     * @Route("/login", name="security-login") 
     * @return Response 
     */
    public function loginAction(Request $request) {
        
        $authenticationUtils = $this->get('security.authentication_utils');        
        $error = $authenticationUtils->getLastAuthenticationError();        
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('default/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
   
    }
    /**
     * @Route("/register", name="security-register") 
     * @param Request $request
     * @return Response
     */
    public function registerAction(Request $request) {

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);      
        
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());  
            $userRole = $this->getDoctrine()->getRepository(Role::class)->findOneBy(['name' => 'ROLE_USER']);
            
            $user->setPassword($password);             
            $userStats = new UserStats($user);            
            $user->setUserStats($userStats);   
            $user->addRole($userRole);           
            $user->setCreated(new \DateTime());
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($userStats);
            $em->persist($user);
            $em->flush();
            
            $this->get('session')->getFlashBag()->set('success', "You have registered an account, please log in!");
            return $this->redirectToRoute('security-login');
        }

        return $this->render('default/register.html.twig',
                ['registerForm' => $form->createView()]
                );
    }
    /**
     * @Route("/logout", name="security-logout")
     * @param Request $request
     * @return Response
     */
    public function logoutAction(Request $request){
        $this->get('session')->getFlashBag()->set('success', "You have been loged out");
        return new Response();
    }
    
    /**
     * @Route("/error403", name="error403")
     */
    public function unauthorisedAction(){
        return $this->render('default/403.html.twig');
    }
   

}
