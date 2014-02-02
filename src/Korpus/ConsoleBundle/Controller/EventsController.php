<?php

namespace Korpus\ConsoleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Korpus\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventsController extends Controller
{

    public function indexAction()
    {
        $nextEvents = $this->getDoctrine()->getRepository('KorpusDataBundle:Event')->findNextEvents();

        return $this->render('KorpusConsoleBundle:Events:index.html.twig', array('nextEvents' => $nextEvents));
    }

    public function toggleViewableAction($slug)
    {
        $event = $this->getDoctrine()->getRepository('KorpusDataBundle:Event')->findOneBySlug($slug);

        if (!(!$event)) {
            $event->setIsViewable(!$event->getIsViewable());
        }

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = new Response(json_encode(true));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function toggleReservableAction($slug)
    {
        $event = $this->getDoctrine()->getRepository('KorpusDataBundle:Event')->findOneBySlug($slug);

        if (!(!$event)) {
            $event->setIsReservable(!$event->getIsReservable());
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = new Response(json_encode(true));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
