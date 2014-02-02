<?php

namespace Korpus\EventsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Korpus\DataBundle\Entity\EventReservation;

class EventController extends Controller
{

    public function indexAction()
    {
        return $this->redirect($this->generateUrl('korpus_main_page_live_events'));
    }

    public function showAction($slug)
    {
        $event = $this->getDoctrine()->getRepository('KorpusDataBundle:Event')->findOneBySlug($slug);

        if (!$event) {
            return $this->redirect($this->generateUrl('korpus_main_page_live_events'));
        }

        if (!$event->getIsViewable()) {
            return $this->redirect($this->generateUrl('korpus_main_page_live_events'));
        }

        return $this->render('KorpusEventsBundle:Event:' . $event->getSlug() . '.html.twig', array('event' => $event));
    }

    private function sendEmail($subject, $from, $to, $body)
    {
        $resMessage = \Swift_Message::newInstance()
                ->setContentType("text/html")
                ->setSubject($subject)
                ->setFrom($from)
                ->setTo($to)
                ->setBody($body)
        ;

        $this->get('mailer')->send($resMessage);

        $transport = $this->get('mailer')->getTransport();
        if (!$transport instanceof \Swift_Transport_SpoolTransport) {
            return;
        }

        $spool = $transport->getSpool();
        if (!$spool instanceof \Swift_MemorySpool) {
            return;
        }

        $spool->flushQueue($this->get('swiftmailer.transport.real'));
    }

    public function reservateAction(Request $request, $slug)
    {
        $event = $this->getDoctrine()
                ->getRepository('KorpusDataBundle:Event')
                ->findOneBySlug($slug);

        if (!$event) {
            return $this->redirect($this->generateUrl('korpus_main_page_live_events'));
        }

        $session = $request->getSession();

        //check isReservable state
        if (!$event->getIsReservable()) {
            return $this->redirect($request->get('referer'));
        }

        $name = $request->get('name');
        $email = $request->get('email');
        $amount = (int) $request->get('amount');
        $address = $request->get('address');

        if ($name != "" && $email != "" && $amount > 0 && $address != "") {
            //add reservation
            $reservation = new EventReservation();
            $reservation->setAddress($address);
            $reservation->setAmount($amount);
            $reservation->setCreationDate(new \DateTime('now'));
            $reservation->setEmail($email);
            $reservation->setEvent($event);
            $reservation->setName($name);

            //persist reservation
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();

            //send email
            //to korpus
            $this->sendEmail($event->getTitle() . ' | Reservation', $email, 'order@korpus-metal.de', $this->renderView('KorpusEmailBundle:Events:reservation.html.twig', array('event' => $event, 'reservation' => $reservation)));

            //to user
            $this->sendEmail($event->getTitle() . ' | Reservationsbestätigung', 'order@korpus-metal.de', $email, $this->renderView('KorpusEmailBundle:Events:confirmation.html.twig', array('event' => $event, 'reservation' => $reservation)));

            //set flash message                    
            $session->getFlashBag()->add('notice', 'Die Reservierung wurde vorgenommen! Sie werden in kürze eine Bestätigungsemail erhalten!');

            return $this->redirect($request->get('referer'));
        } else {
            //set flash message                    
            $session->getFlashBag()->add('notice', 'Alle Felder müssen ausgefüllt werden!');

            return $this->redirect($request->get('referer'));
        }
    }

}
