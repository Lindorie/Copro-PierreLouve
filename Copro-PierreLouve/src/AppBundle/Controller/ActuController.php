<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Actu;
use Symfony\Component\HttpFoundation\Request;

class ActuController extends Controller
{
    public function indexAction()
    {
        return $this->render('Actu/index.html.twig');
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
	    		$userlog = $this->getUser();
	    		$actu->setAuteur($userlog);
	    		$em = $this->getDoctrine()->getManager();
	    		$em->persist($actu);
	    		$em->flush();
	    		$this->get('session')->getFlashBag()->add(
	    				'notice',
	    				'L\'actualité a bien été créée.'
	    		);
	    		return $this->redirect($this->generateUrl('homepage'));
	    	}

    	return $this->render('Actu/form_create.html.twig', array('form' => $form->createView()));
    }

}