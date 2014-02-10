<?php

namespace Korpus\AdminPanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventsController extends Controller
{
    public function indexAction()
    {
        $nextEvents = $this->getDoctrine()->getRepository('KorpusDataBundle:Event')->findNextEvents();

        return $this->render('KorpusAdminPanelBundle:Events:index.html.twig', array('nextEvents' => $nextEvents));
    }

    public function toggleViewableAction($id)
    {
        $event = $this->getDoctrine()->getRepository('KorpusDataBundle:Event')->findOneById($id);

        if (!(!$event)) {
            $event->setIsViewable(!$event->getIsViewable());
        }

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $response = new Response(json_encode(true));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function toggleReservableAction($id)
    {
        $event = $this->getDoctrine()->getRepository('KorpusDataBundle:Event')->findOneById($id);

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
