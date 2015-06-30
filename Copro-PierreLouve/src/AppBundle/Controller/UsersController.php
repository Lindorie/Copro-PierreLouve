<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class UsersController extends Controller
{
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $usersRepository = $em->getRepository('AppBundle:User');
        $users = $usersRepository->findBy(array(), array('id' => 'desc'));

        return $this->render('User/index.html.twig', array('users' => $users));
    }

    public function addAction(Request $request)
    {
        $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('type', 'choice', array('choices' => array('coproprietaire' => 'Copropriétaire', 'admin' => 'Administrateur'), 'label' => 'Type d\'utilisateur'))
            ->add('nom', 'text', array('label' => 'Nom', 'required' => true ))
            ->add('prenom', 'text', array('label' => 'Prénom', 'required' => false))
            ->add('mail1', 'email', array('label' => 'Adresse email n°1', 'required' => true))
            ->add('mail2', 'email', array('required' => false, 'label' => 'Adresse email n°2'))
            ->add('numero', 'text', array('label' => 'Numéro de rue', 'required' => false))
            ->add('telephone1', 'text', array('label' => 'Téléphone n°1', 'required' => false))
            ->add('telephone2', 'text', array('required' => false, 'label' => 'Téléphone n°2'))
            ->add('file', 'file', array('required' => false, 'label' => 'Photo de profil'))
            ->add('milliemes', 'number', array('label' => 'Nombre de millièmes', 'required' => false))
            ->add('save','submit', array('label' => 'Ajouter l\'utilisateur'))
            ->getForm();


        $form->handleRequest($request);

        if ($form->isValid()) {
            // sauvegarder en base
            //$user->retrieveSetExtension();
            $data = $form->getData();
            $username = $data->getNumero().ucfirst(mb_strtolower($data->getNom()));
            $user->setUsername($username);
            $user->setPassword($username);
            $user->setEmail($data->getMail1());
            // attribution du role par défaut
            $role = array('ROLE_COPRO');
            $user->setRoles($role);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            //$user->upload($this->container->getParameter('img_dir'));
            $this->get('session')->getFlashBag()->add(
                'notice',
                'L\'utilisateur a été ajouté.'
            );
            return $this->redirect($this->generateUrl('users_list'));
        }

        return $this->render('User/add.html.twig', array('form' => $form->createView()));

    }
    
    public function editAction(Request $request, $userId)
    {
        $em = $this->getDoctrine()->getManager();
        $usersRepository = $em->getRepository('AppBundle:User');
        $user = $usersRepository->findOneById($userId);

        $form = $this->createFormBuilder($user)
            ->add('type', 'choice', array('choices' => array('admin' => 'Administrateur', 'coproprietaire' => 'Copropriétaire'), 'label' => 'Type d\'utilisateur'))
            ->add('nom', 'text', array('label' => 'Nom', 'data' => $user->getNom()))
            ->add('prenom', 'text', array('required' => false, 'label' => 'Prénom', 'data' => $user->getPrenom()))
            ->add('mail1', 'email', array('label' => 'Adresse email n°1', 'data' => $user->getMail1()))
            ->add('mail2', 'email', array('required' => false, 'label' => 'Adresse email n°2', 'data' => $user->getMail2()))
            ->add('numero', 'text', array('required' => false, 'label' => 'Numéro de rue', 'data' => $user->getNumero()))
            ->add('telephone1', 'text', array('required' => false, 'label' => 'Téléphone n°1', 'data' => $user->getTelephone1()))
            ->add('telephone2', 'text', array('required' => false, 'label' => 'Téléphone n°2', 'data' => $user->getTelephone2()))
            ->add('file', 'file', array('required' => false, 'label' => 'Photo de profil'))
            ->add('milliemes', 'number', array('required' => false, 'label' => 'Nombre de millièmes', 'data' => $user->getMilliemes()))
            ->add('save','submit', array('label' => 'Modifier l\'utilisateur'))
            ->getForm();


        $form->handleRequest($request);

        if ($form->isValid()) {
            // sauvegarder en base
            //$user->retrieveSetExtension();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            //$user->upload($this->container->getParameter('img_dir'));
            $this->get('session')->getFlashBag()->add(
                'notice',
                'L\'utilisateur a été modifié.'
            );
            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('User/edit.html.twig', array('users' => $user, 'form' => $form->createView()));
    }

    public function deleteAction($userId)
    {

        $em = $this->getDoctrine()->getManager();
        $usersRepository = $em->getRepository('AppBundle:User');
        $user = $usersRepository->findOneById($userId);
        $em->remove($user);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'notice',
            'L\'utilisateur a bien été supprimé.'
        );

        return $this->redirect($this->generateUrl('homepage'));

    }

    public function roleEditAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $usersRepository = $em->getRepository('AppBundle:User');
        $user = $usersRepository->findOneById($id);


        $form = $this->createFormBuilder($user)
            ->add('roles', 'collection', array(
                    'type' => 'choice',
                    'options' => array(
                        'choices' => array(
                            'ROLE_COPRO' => 'Copropriétaire',
                            'ROLE_GEST' => 'Gestionnaire',
                            'ROLE_ADMIN' => 'Administrateur',
                            'ROLE_USER' => 'Utilisateur'
                        ),
                        'label' => 'Rôle'
                    )
                )
            )
            ->getForm();


        $form->handleRequest($request);

        if ($form->isValid()) {
            // sauvegarder en base
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Le rôle de l\'utilisateur a été modifié.'
            );
            return $this->redirect($this->generateUrl('users_list'));
        }

        return $this->render('User/role_edit.html.twig', array('user' => $user, 'form' => $form->createView()));
    }
     
    public function resetPasswordAction($id) {

        $em = $this->getDoctrine()->getManager();
        $usersRepository = $em->getRepository('AppBundle:User');
        $user = $usersRepository->findOneById($id);

        $username = $user->getNumero().ucfirst(mb_strtolower($user->getNom()));
        $user->setUsername($username);
        $user->setPassword($username);

        return $this->render('User/reset_password.html.twig', array('user' => $user));
    }
}
