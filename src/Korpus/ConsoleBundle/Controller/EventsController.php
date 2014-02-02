<?php

namespace Korpus\ConsoleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Korpus\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class EventsController extends Controller
{

    public function indexAction()
    {
        $nextEvents = $this->getDoctrine()->getRepository('KorpusDataBundle:Event')->findNextEvents();

        return $this->render('KorpusConsoleBundle:Events:index.html.twig', array('nextEvents' => $nextEvents));
    }

}
