<?php

namespace CoteauxChasse\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	// On cherche toutes les actus
    	$em = $this->getDoctrine()->getManager();
    	$actusRepository = $em->getRepository('CoteauxChasseActusBundle:Actu');
    	$actus = $actusRepository->findBy(array(), array('date' => 'desc'), 2);
    	    	
        return $this->render('CoteauxChasseSiteBundle:Default:accueil.html.twig', array('actus' => $actus));
    }
}
