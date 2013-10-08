<?php

namespace Korpus\ConsoleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{

    public function indexAction()
    {
        return $this->redirect($this->generateUrl('korpus_console_dashboard'));
    }
    
    public function dashboardAction()
    {
        return $this->render('KorpusConsoleBundle:Page:dashboard.html.twig');
    }

}
