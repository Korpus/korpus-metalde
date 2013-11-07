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
        
        //serverinfo
        $currentUsage = disk_total_space('/') - disk_free_space('/');
        $maxSize = disk_total_space('/');
        $percentage = number_format(($currentUsage / $maxSize) * 100, 2, '.', '');
        $freeSpace = disk_free_space('/');
        
        $currentUsageMB = $currentUsage / 1000000;
        $maxSizeMB = $maxSize / 1000000;
        $freeSpaceMB = $freeSpace / 1000000;

        return $this->render('KorpusConsoleBundle:Page:dashboard.html.twig', array(
                    'logs' => $logs,
                    'percentage' => $percentage,
                    'current_usage' => number_format($currentUsageMB, 2, ',', '.'),
                    'max_size' => number_format($maxSizeMB, 2, ',', '.'),
                    'free_space' => number_format($freeSpaceMB, 2, ',', '.')
        ));
    }

}
