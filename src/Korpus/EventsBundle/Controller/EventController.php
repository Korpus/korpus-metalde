<?php

namespace Korpus\EventsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventController extends Controller
{

    public function indexAction()
    {
        return $this->redirect($this->generateUrl('korpus_main_page_live_events'));
    }

    public function showAction($slug)
    {
        $event = $this->getDoctrine()->getRepository('KorpusDataBundle:Event')->findOneBySlug($slug);
        
        if(!$event) {
            return $this->redirect($this->generateUrl('korpus_main_page_live_events'));
        }
        
        return $this->render('KorpusEventsBundle:Event:' . $event->getSlug() . '.html.twig', array('event' => $event));
    }

}
