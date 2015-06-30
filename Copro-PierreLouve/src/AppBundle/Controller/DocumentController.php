<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Document;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;

class DocumentController extends Controller
{
    public function indexAction()
    {
    	// On cherche tous les documents
    	$em = $this->getDoctrine()->getManager();
    	$em->getRepository('AppBundle:Document');
 		
    	if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')){
    		$userlog = $this->getUser();
    		$userRole = $userlog->getRoles();
    	}
    	else {
    		$userRole[] = 'IS_AUTHENTICATED_ANONYMOUSLY';
    	}
    	
    	//var_dump($userRole);

    	$where = '(d.type != :type1 AND d.type != :type2) AND ';
        $voir = array(
            'type1' => 'releve_perso',
            'type2' => 'autre_perso'
        );
    	if (in_array('ROLE_ADMIN', $userRole)){
            $where .= '(d.voir = :voir OR d.voir = :voir2 OR d.voir = :voir3 OR d.voir = :voir4)';
            $voir['voir'] = 'ROLE_GEST';
            $voir['voir2'] = 'ROLE_COPRO';
            $voir['voir3'] = 'IS_AUTHENTICATED_ANONYMOUSLY';
            $voir['voir4'] = 'ROLE_ADMIN';
    	}
    	elseif (in_array('ROLE_GEST', $userRole)) {
    		$where .= '(d.voir = :voir OR d.voir = :voir2 OR d.voir = :voir3)';
            $voir['voir'] = 'ROLE_GEST';
            $voir['voir2'] = 'ROLE_COPRO';
            $voir['voir3'] = 'IS_AUTHENTICATED_ANONYMOUSLY';
    	}
    	elseif (in_array('ROLE_COPRO', $userRole)) {
            $where .= '(d.voir = :voir2 OR d.voir = :voir3)';
            $voir['voir2'] = 'ROLE_COPRO';
            $voir['voir3'] = 'IS_AUTHENTICATED_ANONYMOUSLY';
    	}
    	else {
            $where .= '(d.voir = :voir3)';
            $voir['voir3'] = 'IS_AUTHENTICATED_ANONYMOUSLY';
    	}

        $query = $em->createQuery(
            'SELECT d
             FROM AppBundle:Document d
             WHERE ('.$where.')
             ORDER BY d.type ASC'
        )->setParameters($voir);

        $docus = $query->getResult();
        //var_dump($docus);
        return $this->render('Documents/index.html.twig', array('docus' => $docus));
    }

    public function listePersoAction() {

        $em = $this->getDoctrine()->getManager();
        $coprosRepository = $em->getRepository('AppBundle:User');
        $copros = $coprosRepository->findBy(array('type' => 'coproprietaire'), array('numero' => 'asc'));

        // On cherche tous les documents
        $where = 'd.type = :type1 OR d.type = :type2';
        $params = array();
        $params['type1'] = 'releve_perso';
        $params['type2'] = 'autre_perso';

        $em = $this->getDoctrine()->getManager();
        $em->getRepository('AppBundle:Document');
        $query = $em->createQuery(
            'SELECT d
             FROM AppBundle:Document d
             WHERE ('.$where.')
             ORDER BY d.type ASC'
        )->setParameters($params);

        $docus = $query->getResult();

        return $this->render('Documents/persos.html.twig', array('docus' => $docus, 'copros' => $copros));
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
	    						'Document public' => 'Document public',
	    						'Document commun' => 
	    							array(
    									'Compte-rendu d\'AG' => 'Compte-rendu d\'AG',
    									'Compte-rendu de réunion du conseil syndical' => 'Compte-rendu de réunion du conseil syndical',
    									'Budget' => 'Budget',
    									'Devis' => 'Devis',
    									'Contrat d\'entretien' => 'Contrat d\'entretien',
    									'Avis d\'échéance' => 'Avis d\'échéance',
    									'Autre document' => 'Autre document'
	    							),
	    						'Document personnel' =>
	    							array(
    									'releve_perso' => 'Relevé de compte personnel',
	    								'autre_perso' => 'Autre document personnel'
	    							)
	    						
	    					),
    					'data' => 'Autre document'
    			)
    		)
    	->add('file', 'file', array('required' => true, 'label' => 'Document'))
    	->add(
    			'user',
    			'entity',
    			array(
    					'label' => 'Copropriétaire concerné',
    					'class' => 'AppBundle:User',
                        'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false
    			)
    		)
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
    							array('IS_AUTHENTICATED_ANONYMOUSLY' => 'Public',
    									'ROLE_COPRO' => 'Copropriétaire',
    									'ROLE_GEST' => 'Gestionnaire',
    									'ROLE_ADMIN' => 'Administrateur')
    					)
    			)
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
    	} else {echo "toto"; }
    	
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
    

    public function deleteAction($docId)
    {
    	$em = $this->getDoctrine()->getManager();
    	$docsRepository = $em->getRepository('AppBundle:Document');
    	$doc = $docsRepository->findOneById($docId);
    	// supprimer le document en base + physique
    	$path = $this->container->getParameter('doc_dir')."/".$doc->getFileName();
    	if (file_exists($path)) {
    		unlink($path); 
    	}
    	$em->remove($doc);
    	$em->flush();
    	//var_dump(get_class($doc));die;
    	
    	$this->get('session')->getFlashBag()->add(
    			'notice',
    			'Le document a bien été supprimé.'
    	);

    	return $this->redirect($this->generateUrl('documents'));
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $docRepository = $em->getRepository('AppBundle:Document');
        $document = $docRepository->findOneById($id);

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
                            'Document public' => 'Document public',
                            'Document commun' =>
                                array(
                                    'Compte-rendu d\'AG' => 'Compte-rendu d\'AG',
                                    'Compte-rendu de réunion du conseil syndical' => 'Compte-rendu de réunion du conseil syndical',
                                    'Budget' => 'Budget',
                                    'Devis' => 'Devis',
                                    'Contrat d\'entretien' => 'Contrat d\'entretien',
                                    'Avis d\'échéance' => 'Avis d\'échéance',
                                    'Autre document' => 'Autre document'
                                ),
                            'Document personnel' =>
                                array(
                                    'releve_perso' => 'Relevé de compte personnel',
                                    'autre_perso' => 'Autre document personnel'
                                )

                        )
                )
            )
            ->add('file', 'file', array('required' => false, 'label' => 'Document'))
            ->add(
                'user',
                'entity',
                array(
                    'label' => 'Copropriétaire concerné',
                    'class' => 'AppBundle:User',
                    'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false
                )
            )
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
                    array('IS_AUTHENTICATED_ANONYMOUSLY' => 'Public',
                        'ROLE_COPRO' => 'Copropriétaire',
                        'ROLE_GEST' => 'Gestionnaire',
                        'ROLE_ADMIN' => 'Administrateur')
                )
            )
            ->getForm();

        $form->handleRequest($request);


        if ($form->isValid()) {
            // sauvegarder en base
            $doc = $form->getData();
            if ($doc->file != '') {
                $em = $this->getDoctrine()->getManager();
                $document->retrieveSetExtension();
            }
            $em->persist($document);
            $em->flush();

            $document->upload($this->container->getParameter('doc_dir'));
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Le document a bien été modifié.'
            );
            return $this->redirect($this->generateUrl('documents'));
        }

        return $this->render('Documents/edit.html.twig', array('doc' => $document, 'form' => $form->createView()));
    }
   
}
