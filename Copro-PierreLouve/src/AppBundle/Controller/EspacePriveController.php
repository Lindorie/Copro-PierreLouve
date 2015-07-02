<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class EspacePriveController extends Controller
{
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository('AppBundle:User');
        $user = $userRepository->findOneById($id);

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
             ORDER BY d.id DESC'
        )
        ->setParameters($voir)
        ->setMaxResults(5);;

        $docus = $query->getResult();

        $em = $this->getDoctrine()->getManager();
        $coprosRepository = $em->getRepository('AppBundle:User');
        $copros = $coprosRepository->findBy(array('type' => 'coproprietaire'), array('numero' => 'asc'));

        // On cherche tous les documents
        $where = '(d.type = :type1 OR d.type = :type2) AND d.user = :userId';
        $params = array();
        $params['type1'] = 'releve_perso';
        $params['type2'] = 'autre_perso';
        $params['userId'] = $id;

        $em = $this->getDoctrine()->getManager();
        $em->getRepository('AppBundle:Document');
        $query = $em->createQuery(
            'SELECT d
             FROM AppBundle:Document d
             WHERE ('.$where.')
             ORDER BY d.type ASC'
        )->setParameters($params);

        $docsPersos = $query->getResult();

        return $this->render('EspacePrive/tableaudebord.html.twig', array('user' => $user, 'docus' => $docus, 'docus_persos' => $docsPersos));
    }

    public function userEditOwnAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository('AppBundle:User');
        $user = $userRepository->findOneById($id);
        
        $form = $this->createFormBuilder($user)
        ->add('telephone1', 'text', array('label' => 'Téléphone 1', 'required' => true))
        ->add('telephone2', 'text', array('label' => 'Téléphone 2', 'required' => false))
        ->add('mail1', 'text', array('label' => 'Email 1', 'required' => true))
        ->add('mail2', 'text', array('label' => 'Email 2', 'required' => false))
        ->getForm();

        $form->handleRequest($request);


        if ($form->isValid()) {
            // sauvegarder en base
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Vos informations ont bien été modifiées.'
            );
            return $this->redirect($this->generateUrl('tableau_de_bord', array('id' => $user->getId())));
        }

        return $this->render('EspacePrive/userEditOwn.html.twig', array('user' => $user, 'form' => $form->createView()));
    }

    public function editPasswordAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository('AppBundle:User');
        $user = $userRepository->findOneById($id);

        $form = $this->createFormBuilder($user)
            ->add('password', 'password', array('label' => 'Mot de passe', 'required' => true))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            // sauvegarder en base
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Votre mot de passe a bien été modifié.'
            );
            return $this->redirect($this->generateUrl('tableau_de_bord', array('id' => $user->getId())));
        }

        return $this->render('EspacePrive/edit_password.html.twig', array('user' => $user, 'form' => $form->createView()));
    }

    public function mesDocumentsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository('AppBundle:User');
        $user = $userRepository->findOneById($id);

        // On cherche tous les documents
        $where = '(d.type = :type1 OR d.type = :type2) AND d.user = :userId';
        $params = array();
        $params['type1'] = 'releve_perso';
        $params['type2'] = 'autre_perso';
        $params['userId'] = $user;

        $em = $this->getDoctrine()->getManager();
        $em->getRepository('AppBundle:Document');
        $query = $em->createQuery(
            'SELECT d
             FROM AppBundle:Document d
             WHERE ('.$where.')
             ORDER BY d.type ASC'
        )->setParameters($params);

        $docsPersos = $query->getResult();

        return $this->render('EspacePrive/docs_persos.html.twig', array('user' => $user, 'docus' => $docsPersos ));
    }

}
