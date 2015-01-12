<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	// On cherche toutes les actus
    	$em = $this->getDoctrine()->getManager();
    	$actusRepository = $em->getRepository('AppBundle:Actu');
    	$actus = $actusRepository->findBy(array(), array('date' => 'desc'), 2);
    	$img = $this->container->getParameter('img_dir') . '/';

        return $this->render('Default/accueil.html.twig', array('actus' => $actus, 'imgDir' => $img));
    }
    
    public function plusInfosAction()
    {
    	
        return $this->render('Default/plus_infos.html.twig');
    }
}
