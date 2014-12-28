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
    	$actus = $actusRepository->findAll();
    	    	
        return $this->render('CoteauxChasseSiteBundle:Default:index.html.twig', array('actus' => $actus));
    }
}
