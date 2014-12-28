<?php

namespace CoteauxChasse\ActusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CoteauxChasse\ActusBundle\Entity\Actu;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CoteauxChasseActusBundle:Default:index.html.twig');
    }
    
    public function createAction(Request $request) {
    	$actu = new Actu();
    	
    	$form = $this->createFormBuilder($actu)
    						->add('titre', 'text')
    						->add('texte', 'textarea')
    						->getForm();
    	
    		
    		$form->handleRequest($request);
    	
	    	if ($form->isValid()) {
	    		// sauvegarder en base
	    		$actu->getDate();
	    		$em = $this->getDoctrine()->getManager();
	    		$em->persist($actu);
	    		$em->flush();
	    		$this->get('session')->getFlashBag()->add(
	    				'notice',
	    				'L\'actualité a bien été créée.'
	    		);
	    		return $this->redirect($this->generateUrl('homepage'));
	    	}
    	
    	return $this->render('CoteauxChasseActusBundle:Default:form_create.html.twig', array('form' => $form->createView()));
    }
    
}
