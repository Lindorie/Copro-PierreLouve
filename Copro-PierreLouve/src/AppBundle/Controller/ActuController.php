<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Actu;
use Symfony\Component\HttpFoundation\Request;

class ActuController extends Controller
{
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$actusRepository = $em->getRepository('AppBundle:Actu');
    	$actus = $actusRepository->findBy(array(), array('date' => 'desc'), 10);

        return $this->render('Actu/index.html.twig', array('actus' => $actus));
    }

    public function createAction(Request $request) {
    	$actu = new Actu();

    	$form = $this->createFormBuilder($actu)
    						->add('titre', 'text')
    						->add('file', 'file', array('required' => false, 'label' => 'Image'))
    						->add('texte', 'textarea')
    						->getForm();


    		$form->handleRequest($request);

	    	if ($form->isValid()) {
	    		// sauvegarder en base
	    		$actu->getDate();
	    		$userlog = $this->getUser();
	    		$actu->setAuteur($userlog);
	    		$actu->retrieveSetExtension();
	    		$em = $this->getDoctrine()->getManager();
	    		$em->persist($actu);
	    		$em->flush();
	    		$actu->upload($this->container->getParameter('img_dir'));
	    		$this->get('session')->getFlashBag()->add(
	    				'notice',
	    				'L\'actualité a bien été créée.'
	    		);
	    		return $this->redirect($this->generateUrl('homepage'));
	    	}

    	return $this->render('Actu/form_create.html.twig', array('form' => $form->createView()));
    }
    
    // fonction de modif
    public function modifActuAction(Request $request, $actuId) {
    
    $em = $this->getDoctrine()->getManager();
    $actusRepository = $em->getRepository('AppBundle:Actu');
    $actu = $actusRepository->findOneById($actuId);
    //var_dump($actuId);die;
    
    $form = $this->createFormBuilder($actu)
    						->add('titre', 'text', array('data' => $actu->getTitre()))
    						->add('file', 'file', array('label' => 'Modifier l\'image'))
    						->add('texte', 'textarea')
    						->getForm();

    		$form->handleRequest($request);
    		
    
    	if ($form->isValid()) {
	    		// sauvegarder en base
	    		$actu->getDate();
	    		$userlog = $this->getUser();
	    		$actu->setAuteur($userlog);
	    		$actu->retrieveSetExtension();
	    		$em = $this->getDoctrine()->getManager();
	    		$em->persist($actu);
	    		$em->flush();
	    		$actu->upload($this->container->getParameter('img_dir'));
	    		$this->get('session')->getFlashBag()->add(
	    				'notice',
	    				'L\'actualité a bien été modifiée.'
	    		);
	    		return $this->redirect($this->generateUrl('homepage'));
    	}
    	
    return $this->render('Actu/form_modif.html.twig', array('actus' => $actu, 'form' => $form->createView()));
    
    }

}
