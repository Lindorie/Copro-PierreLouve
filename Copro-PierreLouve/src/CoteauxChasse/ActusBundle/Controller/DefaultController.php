<?php

namespace CoteauxChasse\ActusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CoteauxChasseActusBundle:Default:index.html.twig'));
    }
}
