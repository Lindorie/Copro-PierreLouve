<?php

namespace CoteauxChasse\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CoteauxChasseSiteBundle:Default:index.html.twig');
    }
}
