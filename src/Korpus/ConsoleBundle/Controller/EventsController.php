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

    public function reservationsAction($id)
    {
        $event = $this->getDoctrine()->getRepository('KorpusDataBundle:Event')->findOneById($id);

        if (!$event) {
            throw new $this->createNotFoundException("This Event does not Exist!");
        }

        $reservations = $this->getDoctrine()->getRepository('KorpusDataBundle:EventReservation')->findBy(array('event' => $event), array('creationDate' => 'desc'));
        $tickets = 0;
        foreach ($reservations as $res) {
            $tickets += (int)$res->getAmount();
        }

        return $this->render('KorpusConsoleBundle:Events:reservations.html.twig', array('event' => $event, 'reservations' => $reservations, 'tickets' => $tickets));
    }

    public function printReportAction($id)
    {
        $event = $this->getDoctrine()->getRepository('KorpusDataBundle:Event')->findOneById($id);

        if (!$event) {
            throw new $this->createNotFoundException("This Event does not Exist!");
        }

        $reservations = $this->getDoctrine()->getRepository('KorpusDataBundle:EventReservation')->findBy(array('event' => $event), array('creationDate' => 'desc'));
        $tickets = 0;
        foreach ($reservations as $res) {
            $tickets += (int)$res->getAmount();
        }

        return $this->render('KorpusConsoleBundle:Events:printReservations.html.twig', array('event' => $event, 'reservations' => $reservations, 'tickets' => $tickets));
    }
}
