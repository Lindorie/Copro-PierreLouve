<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function slideshowAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$imagesRepository = $em->getRepository('AppBundle:Image');
    	$images = $imagesRepository->findBy(array(), array('id' => 'desc'));
    	 

        return $this->render('Admin/slideshow_gerer.html.twig', array('images' => $images));
    }
    
    public function slideshowRemoveImgAction()
    {
    	 
        return $this->render('Admin/slideshow_gerer.html.twig', array('images' => $images));
    }
    
    public function slideshowAddImgAction()
    {
    
    	return $this->render('Admin/slideshow_gerer.html.twig', array('images' => $images));
    }   
     
    public function slideshowAddImgAction()
    {
    
    	return $this->render('Admin/slideshow_gerer.html.twig', array('images' => $images));
    }
}
