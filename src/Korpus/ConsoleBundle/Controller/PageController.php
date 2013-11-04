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
        $sourceLogs = $this->getDoctrine()->getRepository('KorpusDataBundle:SourceLog')->findAllPerNewsPost();

        $logs = array();

        foreach ($sourceLogs as $log) {
            $logs[] = array(
                'count' => $log[1],
                'title' => $log[0]->getPost()->getTitle(),
                'source' => $log[0]->getSource()
            );
        }

        return $this->render('KorpusConsoleBundle:Page:dashboard.html.twig', array(
                    'logs' => $logs
        ));
    }

}
