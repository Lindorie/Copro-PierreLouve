<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Entreprise;
use Symfony\Component\HttpFoundation\Request;

class EntrepriseController extends Controller
{
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$entrepriseRepository = $em->getRepository('AppBundle:Entreprise');
    	$entreprises = $entrepriseRepository->findAll();

        return $this->render('Entreprise/index.html.twig', array('entreprises' => $entreprises));
    }
    public function detailAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$entrepriseRepository = $em->getRepository('AppBundle:Entreprise');
    	$entreprise = $entrepriseRepository->findOneById($id);

        return $this->render('Entreprise/detail.html.twig', array('entreprise' => $entreprise));
    }

    public function addAction(Request $request) {
    	$entreprise = new Entreprise();

    	$form = $this->createFormBuilder($entreprise)
    						->add('nom', 'text')
    						->add('contact', 'text', array('required' => false))
    						->add('adresse', 'textarea', array('required' => false))
    						->add('telephone', 'text', array('required' => false))
    						->add('email', 'email', array('required' => false))
    						->add('domaine', 'text', array('required' => false))
    						->add('opac', 'choice', array('choices' => array(1 => 'Oui', 0 => 'Non'), 'required' => false))
    						->add('commentaire', 'textarea', array('required' => false))
                            ->add('add', 'submit',
                                array(
                                    'label' => 'Ajouter',
                                    'attr' => array(
                                        'class' => 'btn btn-success'
                                    )
                                )
                            )
    						->getForm();


    		$form->handleRequest($request);

	    	if ($form->isValid()) {

	    		$em = $this->getDoctrine()->getManager();
	    		$em->persist($entreprise);
	    		$em->flush();
	    		$this->get('session')->getFlashBag()->add(
	    				'notice',
	    				'L\'entreprise a bien été créée.'
	    		);
	    		return $this->redirect($this->generateUrl('entreprises'));
	    	}

    	return $this->render('Entreprise/add.html.twig', array('form' => $form->createView()));
    }

    public function editAction(Request $request, $id) {
    
    $em = $this->getDoctrine()->getManager();
    $entreprisesRepository = $em->getRepository('AppBundle:Entreprise');
    $entreprise = $entreprisesRepository->findOneById($id);

        $form = $this->createFormBuilder($entreprise)
            ->add('nom', 'text')
            ->add('contact', 'text', array('required' => false))
            ->add('adresse', 'textarea', array('required' => false))
            ->add('telephone', 'text', array('required' => false))
            ->add('email', 'email', array('required' => false))
            ->add('domaine', 'text', array('required' => false))
            ->add('opac', 'choice', array('choices' => array(1 => 'Oui', 0 => 'Non'), 'required' => false))
            ->add('commentaire', 'textarea', array('required' => false))
            ->add('add', 'submit',
                array(
                    'label' => 'Modifier',
                    'attr' => array(
                        'class' => 'btn btn-success'
                    )
                )
            )
            ->getForm();


        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entreprise);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'L\'entreprise a bien été modifiée.'
            );
            return $this->redirect($this->generateUrl('entreprises'));
        }

        return $this->render('Entreprise/edit.html.twig', array('form' => $form->createView()));
    
    }

    public function deleteAction($id) {
    
    	$em = $this->getDoctrine()->getManager();
    	$entreprisesRepository = $em->getRepository('AppBundle:Entreprise');
    	$entreprise = $entreprisesRepository->findOneById($id);
    	$em->remove($entreprise);
    	$em->flush();
    	
    	$this->get('session')->getFlashBag()->add(
    			'notice',
    			'L\'entreprise a bien été supprimée.'
    	);
    	
    	return $this->redirect($this->generateUrl('entreprises'));
    
    }

}
