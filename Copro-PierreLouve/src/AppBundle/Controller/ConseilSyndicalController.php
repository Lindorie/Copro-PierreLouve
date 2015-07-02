<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\ConseilSyndical;
use Symfony\Component\HttpFoundation\Request;

class ConseilSyndicalController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $conseilRepository = $em->getRepository('AppBundle:ConseilSyndical');
        $conseil = $conseilRepository->findAll();

        return $this->render('ConseilSyndical/index.html.twig', array('conseil' => $conseil));
    }
    public function addAction(Request $request)
    {
        $conseil = new ConseilSyndical();

        $form = $this->createFormBuilder($conseil)
            ->add(
                'president',
                'entity',
                array(
                    'label' => 'Président',
                    'class' => 'AppBundle:User',
                    'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false
                )
            )
            ->add(
                'vice_president',
                'entity',
                array(
                    'label' => 'Président adjoint',
                    'class' => 'AppBundle:User',
                    'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false
                )
            )
            ->add(
                'secretaire',
                'entity',
                array(
                    'label' => 'Secrétaire',
                    'class' => 'AppBundle:User',
                    'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false
                )
            )
            ->add(
                'vice_secretaire',
                'entity',
                array(
                    'label' => 'Secrétaire adjoint',
                    'class' => 'AppBundle:User',
                    'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false
                )
            )
            ->add(
                'tresorier',
                'entity',
                array(
                    'label' => 'Trésorier',
                    'class' => 'AppBundle:User',
                    'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false
                )
            )
            ->add(
                'vice_tresorier',
                'entity',
                array(
                    'label' => 'Trésorier adjoint',
                    'class' => 'AppBundle:User',
                    'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false
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

            $em = $this->getDoctrine()->getManager();
            $em->persist($conseil);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Le conseil a bien été ajouté.'
            );
            return $this->redirect($this->generateUrl('conseil_syndical'));
        }

        return $this->render('ConseilSyndical/add.html.twig', array('conseil' => $conseil, 'form' => $form->createView()));
    }
    public function addMembreAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $conseilRepository = $em->getRepository('AppBundle:ConseilSyndical');
        $conseil = $conseilRepository->findOneById($id);

        $form = $this->createFormBuilder($conseil)
            ->add(
                'membres',
                'repeated',
                array(
                    'label' => 'Président',
                    'class' => 'AppBundle:User',
                    'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false
                )
            )
            ->add(
                'vice_president',
                'entity',
                array(
                    'label' => 'Président adjoint',
                    'class' => 'AppBundle:User',
                    'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false
                )
            )
            ->add(
                'secretaire',
                'entity',
                array(
                    'label' => 'Secrétaire',
                    'class' => 'AppBundle:User',
                    'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false
                )
            )
            ->add(
                'vice_secretaire',
                'entity',
                array(
                    'label' => 'Secrétaire adjoint',
                    'class' => 'AppBundle:User',
                    'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false
                )
            )
            ->add(
                'tresorier',
                'entity',
                array(
                    'label' => 'Trésorier',
                    'class' => 'AppBundle:User',
                    'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false
                )
            )
            ->add(
                'vice_tresorier',
                'entity',
                array(
                    'label' => 'Trésorier adjoint',
                    'class' => 'AppBundle:User',
                    'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false
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

            $em = $this->getDoctrine()->getManager();
            $em->persist($conseil);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Le conseil a bien été modifié.'
            );
            return $this->redirect($this->generateUrl('conseil_syndical'));
        }


        return $this->render('ConseilSyndical/addMembre.html.twig', array('form' => $form->createView()));

    }
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $conseilRepository = $em->getRepository('AppBundle:ConseilSyndical');
        $conseil = $conseilRepository->findOneById($id);

        $form = $this->createFormBuilder($conseil)
            ->add(
                'president',
                'entity',
                array(
                    'label' => 'Président',
                    'class' => 'AppBundle:User',
                    'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false
                )
            )
            ->add(
                'vice_president',
                'entity',
                array(
                    'label' => 'Président adjoint',
                    'class' => 'AppBundle:User',
                    'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false
                )
            )
            ->add(
                'secretaire',
                'entity',
                array(
                    'label' => 'Secrétaire',
                    'class' => 'AppBundle:User',
                    'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false
                )
            )
            ->add(
                'vice_secretaire',
                'entity',
                array(
                    'label' => 'Secrétaire adjoint',
                    'class' => 'AppBundle:User',
                    'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false
                )
            )
            ->add(
                'tresorier',
                'entity',
                array(
                    'label' => 'Trésorier',
                    'class' => 'AppBundle:User',
                    'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false
                )
            )
            ->add(
                'vice_tresorier',
                'entity',
                array(
                    'label' => 'Trésorier adjoint',
                    'class' => 'AppBundle:User',
                    'property' => 'getNomPrenom',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false
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

            $em = $this->getDoctrine()->getManager();
            $em->persist($conseil);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Le conseil a bien été modifié.'
            );
            return $this->redirect($this->generateUrl('conseil_syndical'));
        }


        return $this->render('ConseilSyndical/edit.html.twig', array('form' => $form->createView()));
    }
    public function deleteMembreAction()
    {
        $em = $this->getDoctrine()->getManager();
        $conseilRepository = $em->getRepository('AppBundle:ConseilSyndical');
        $conseil = $conseilRepository->findAll();


        return $this->render('ConseilSyndical/index.html.twig', array('conseil' => $conseil));
    }

}
