<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('Admin/index.html.twig');
    }

    public function coproprietairesListeAction() {
        $em = $this->getDoctrine()->getManager();
        $coprosRepository = $em->getRepository('AppBundle:User');
        $copros = $coprosRepository->findBy(array('type' => 'coproprietaire'), array('numero' => 'asc'));

        return $this->render('Admin/coproprietaires.html.twig', array('copros' => $copros));
    }

    public function slideshowAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$imagesRepository = $em->getRepository('AppBundle:Image');
    	$images = $imagesRepository->findBy(array(), array('id' => 'desc'));
    	 

        return $this->render('Admin/slideshow_gerer.html.twig', array('images' => $images));
    }
    
    public function slideshowRemoveImgAction()
    {
    	 
        return $this->render('Admin/slideshow_gerer.html.twig');
    }
    
    public function slideshowAddImgAction()
    {
    
    	return $this->render('Admin/slideshow_gerer.html.twig');
    }   
     
    
}
