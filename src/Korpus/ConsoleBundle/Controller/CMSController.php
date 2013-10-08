<?php

namespace Korpus\ConsoleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CMSController extends Controller
{

    /**
     * News
     */
    public function newsAction()
    {
        return $this->render('KorpusConsoleBundle:CMS:news.html.twig');
    }

    public function createNewsAction()
    {
        return $this->render('KorpusConsoleBundle:CMS:news_create.html.twig');
    }

    public function updateNewsAction()
    {
        return $this->render('KorpusConsoleBundle:CMS:news_update.html.twig');
    }

    public function deleteNewsAction()
    {
        return $this->render('KorpusConsoleBundle:CMS:news_delete.html.twig');
    }

    public function viewNewsAction()
    {
        return $this->render('KorpusConsoleBundle:CMS:news_view.html.twig');
    }

    /**
     * Concert
     */
    public function concertAction()
    {
        return $this->render('KorpusConsoleBundle:CMS:concert.html.twig');
    }

    public function createConcertAction()
    {
        return $this->render('KorpusConsoleBundle:CMS:concert_create.html.twig');
    }

    public function updateConcertAction()
    {
        return $this->render('KorpusConsoleBundle:CMS:concert_update.html.twig');
    }

    public function deleteConcertAction()
    {
        return $this->render('KorpusConsoleBundle:CMS:concert_delete.html.twig');
    }

    public function viewConcertAction()
    {
        return $this->render('KorpusConsoleBundle:CMS:concert_view.html.twig');
    }

}
