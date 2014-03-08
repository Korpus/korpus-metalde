<?php

namespace Korpus\AdminPanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Korpus\DataBundle\Entity\Event;
use Korpus\DataBundle\Helper\EventHelper;

class EventsController extends Controller
{
    public function indexAction()
    {
        $nextEvents = $this->getDoctrine()->getRepository('KorpusDataBundle:Event')->findNextEvents();

        return $this->render('KorpusAdminPanelBundle:Events:index.html.twig', array('nextEvents' => $nextEvents));
    }

    public function createAction(Request $request)
    {
        $session = $request->getSession();

        if ($request->get('sent') == 1) {
            $title = $request->get('title');
            $venue = $request->get('venue');
            $city = $request->get('city');
            $facebookLink = $request->get('facebookLink');
            $eventDate = $request->get('eventDate');

            $event = new Event();
            $event->setCity($city);
            $event->setCreationDate(new \DateTime('now'));

            if ($facebookLink != "") {
                $event->setFacebookLink($facebookLink);
            }

            $event->setIsReservable(false);
            $event->setIsViewable(false);
            $event->setTitle($title);
            $event->setVenue($venue);
            $event->setEventDate(new \DateTime($eventDate));
            $event->setSlug(EventHelper::generateSlug($title));

            //validate event
            $validator = $this->get('validator');
            $errors = $validator->validate($event);

            if (count($errors) > 0) {
                $errorsString = (string)$errors;
                $session->getFlashBag()->add('error', $errorsString);
            } else {
                //persist event
                $em = $this->getDoctrine()->getManager();
                $em->persist($event);
                $em->flush();

                $session->getFlashBag()->add('notice', 'Ein neues Event wurde hinzugefügt!');

                return $this->redirect($this->generateUrl('korpus_admin_panel_events_index'));
            }
        }

        return $this->render('KorpusAdminPanelBundle:Events:create.html.twig');
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
