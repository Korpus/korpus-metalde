<?php

namespace Korpus\MainPageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{

    public function indexAction()
    {
        return $this->newsAction();
    }

    /**
     * News
     */
    public function newsAction()
    {
        $day = '01';
        $month = '01';
        $year = '2013';

        return $this->redirect($this->generateUrl('korpus_main_page_news_post', array('day' => $day, 'month' => $month, 'year' => $year)));
    }

    public function newsPostAction($day, $month, $year)
    {
        return $this->render('KorpusMainPageBundle:Page:newsPost.index.html');
    }
    
    /**
     * Impressum
     */
    public function impressumAction()
    {
        return $this->render('KorpusMainPageBundle:Page:impressum.html.twig');
    }
    
    /**
     * Datenschutz
     */
    public function datenschutzAction()
    {
        return $this->render('KorpusMainPageBundle:Page:datenschutz.html.twig');
    }
    
    /**
     * Band
     */
    public function bandAction()
    {
        return $this->redirect($this->generateUrl('korpus_main_page_bio'));
    }

    public function bioAction()
    {
        return $this->render('KorpusMainPageBundle:Page:bio.html.twig');
    }

    public function memberAction($name)
    {
        if ($name === null)
            return $this->redirect($this->generateUrl('korpus_main_page_news', array('name' => 'Gastel'), true));
        else {
            return $this->render('KorpusMainPageBundle:Page:member.html.twig');
        }
    }

}
