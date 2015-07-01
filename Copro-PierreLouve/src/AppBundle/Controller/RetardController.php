<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Retard;

class RetardController extends Controller
{
    public function indexAction()
    {
        // On cherche tous les retards
        $em = $this->getDoctrine()->getManager();
        $retardsRepository = $em->getRepository('AppBundle:Retard');
        $retards = $retardsRepository->findAll();


        return $this->render('Retard/index.html.twig', array('retards' => $retards));
    }

    public function addAction(Request $request)
    {
        $retard = new Retard();
        $form = $this->createFormBuilder($retard)
            ->add(
                'user',
                'entity',
                array(
                    'label' => 'Copropriétaire concerné',
                    'class' => 'AppBundle:User',
                    'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false
                )
            )
            ->add('montant')
            ->add('commentaire')
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
            $retard->getDateSaisie();
            $em = $this->getDoctrine()->getManager();
            $em->persist($retard);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Le retard a bien été ajouté.'
            );
            return $this->redirect($this->generateUrl('retards'));
        }

        return $this->render('Retard/add.html.twig', array('form' => $form->createView()));
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $retardRepository = $em->getRepository('AppBundle:Retard');
        $retard = $retardRepository->findOneById($id);

        $form = $this->createFormBuilder($retard)
            ->add(
                'user',
                'entity',
                array(
                    'label' => 'Copropriétaire concerné',
                    'class' => 'AppBundle:User',
                    'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false
                )
            )
            ->add('montant')
            ->add('commentaire')
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

            // sauvegarder en base
            $em = $this->getDoctrine()->getManager();
            $em->persist($retard);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Le retard a bien été modifié.'
            );
            return $this->redirect($this->generateUrl('retards'));
        }

        return $this->render('Retard/edit.html.twig', array('form' => $form->createView()));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $retardsRepository = $em->getRepository('AppBundle:Retard');
        $retard = $retardsRepository->findOneById($id);
        $em->remove($retard);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'notice',
            'Le retard a bien été supprimé.'
        );

        return $this->redirect($this->generateUrl('retards'));
    }

}
