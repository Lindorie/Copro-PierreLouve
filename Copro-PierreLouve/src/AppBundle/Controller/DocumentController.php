<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DocumentController extends Controller
{
    public function indexAction()
    {
    	// On cherche tous les documents
    	$em = $this->getDoctrine()->getManager();
    	$actusRepository = $em->getRepository('AppBundle:Document');
    	$actus = $actusRepository->findBy(array(), array('type' => 'asc'));

        return $this->render('Default/accueil.html.twig', array('docus' => docus));
    }
}
