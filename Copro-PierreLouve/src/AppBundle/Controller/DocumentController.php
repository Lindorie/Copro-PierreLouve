<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Document;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DocumentController extends Controller
{
    public function indexAction()
    {
    	// On cherche tous les documents
    	$em = $this->getDoctrine()->getManager();
    	$docusRepository = $em->getRepository('AppBundle:Document');
    	$docus = $docusRepository->findBy(array(), array('type' => 'asc'));

        return $this->render('Documents/index.html.twig', array('docus' => $docus));
    }
    
    public function addAction(Request $request) {
    	
    	$document = new Document();
    	$form = $this->createFormBuilder($document)
    	->add('titre')
    	->add('description')
    	->add(
    			'type',
    			'choice', 
    			array(
    					'label' => 'Type', 
    					'choices' => 
	    					array(
	    						'Document public',
	    						'Document commun' => 
	    							array(
    									'Compte-rendu d\'AG',
    									'Compte-rendu de réunion du conseil syndical',
    									'Budget',
    									'Devis',
    									'Contrat d\'entretien',
    									'Avis d\'échéance',
    									'Autre document'
	    							),
	    						'Document personnel' =>
	    							array(
    									'Relevé de compte personnel',
	    								'Autre document personnel'
	    							)
	    						
	    					)	
    			)
    		)
    	->add('file')
    	->add(
    			'gerer', 
    			'choice', 
    			array(
    					'label' => 'Gérer', 
    					'choices' => 
    					array(
    							'ROLE_COPRO' => 'Copropriétaire', 
    							'ROLE_GEST' => 'Gestionnaire', 
    							'ROLE_ADMIN' => 'Administrateur'
    					)	
    			)
    		)
    	->add('voir', 'choice',
    					array('choices' =>
    							array('IS_AUTHENTICATED_ANONYMOUSLY' => 'public',
    									'ROLE_COPRO' => 'Copropriétaire',
    									'ROLE_GEST' => 'Gestionnaire',
    									'ROLE_ADMIN' => 'Administrateur')
    					)
    			)
    	->add('add', 'submit', array('label' => 'Ajouter'))
    	->getForm();
    	
    	$form->handleRequest($request);
    	
    	if ($form->isValid()) {
    		// sauvegarder en base
    		$em = $this->getDoctrine()->getManager();
    		$document->retrieveSetExtension();
    		$em->persist($document);
    		$em->flush();
    		
    		$document->upload($this->container->getParameter('doc_dir'));
    		$this->get('session')->getFlashBag()->add(
    				'notice',
    				'Le document a bien été ajouté.'
    		);
    		return $this->redirect($this->generateUrl('documents'));
    	}
    	
    	return $this->render('Documents/add.html.twig', array('form_add' => $form->createView()));
    }
    
    public function downloadFileAction($docId)
    {
    	$em = $this->getDoctrine()->getManager();
    	$docsRepository = $em->getRepository('AppBundle:Document');
    	$doc = $docsRepository->findOneById($docId);
    	//var_dump(get_class($doc));die;
    	
    	$path = $this->container->getParameter('doc_dir')."/".$doc->getFileName();
    	$content = file_get_contents($path);
    
    	$response = new Response();
    
    	//$response->headers->set('Content-Type', 'text/csv');
    	$response->headers->set('Content-Disposition', 'attachment;filename="'.$doc->getFileName());
    
    	$response->setContent($content);
    	return $response;
    }
}
