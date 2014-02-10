<?php

namespace Korpus\AdminPanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('korpus_admin_panel_dashboard'));
    }

    public function dashboardAction()
    {
        return $this->render('KorpusAdminPanelBundle:Page:dashboard.html.twig');
    }
}
