<?php

namespace CoteauxChasse\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    public function indexAction(Request $request)
    {
    	$contactForm = $this->createFormBuilder()
    						->add('nom', 'text')
    						->add('email', 'email')
    						->add('message', 'textarea')
    						->add('Envoyer', 'submit')
    						->getForm();
    	
    		
    	$contactForm->handleRequest($request);
    	
	    if ($contactForm->isValid()) {
	    	$data = $contactForm->getData();
	    	var_dump($data);
	    	$message = \Swift_Message::newInstance()
		    	->setSubject('Hello Email')
		    	->setFrom(array('john@doe.com' => 'John Doe'))
		    	->setReplyTo(array($data['email'] => $data['nom']))
		    	->setTo('pic.carine@gmail.com')
		    	->setBody($data['message'])
	    	;
	    	$this->get('mailer')->send($message);
	    	
	    	$this->get('session')->getFlashBag()->add(
	    			'notice',
	    			'Le message a bien été envoyé.'
	    	);
	    	return $this->redirect($this->generateUrl('homepage')); 
	    	
	    }
    	    	
        return $this->render('CoteauxChasseSiteBundle:Default:contact.html.twig', array('contactForm' => $contactForm->createView()));
    }
}
