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

        return $this->render('KorpusEventsBundle:Event:' . $event->getSlug() . '.html.twig', array('event' => $event));
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
            $resMessage = \Swift_Message::newInstance()
                    ->setContentType("text/html")
                    ->setSubject($event->getTitle() . ' | Reservation')
                    ->setFrom($email)
                    ->setTo('order@korpus-metal.de')
                    ->setBody(
                    $this->renderView(
                            'KorpusEventsBundle:Email:reservation.html.twig', array('event' => $event, 'reservation' => $reservation)
                    )
                    )
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

            //to user
            $confirmMessage = \Swift_Message::newInstance()
                    ->setContentType("text/html")
                    ->setSubject($event->getTitle() . ' | Reservationsbestätigung')
                    ->setFrom('order@korpus-metal.de')
                    ->setTo($email)
                    ->setBody(
                    $this->renderView(
                            'KorpusEventsBundle:Email:confirmation.html.twig', array('event' => $event, 'reservation' => $reservation)
                    )
                    )
            ;

            $this->get('mailer')->send($confirmMessage);

            $transport = $this->get('mailer')->getTransport();
            if (!$transport instanceof \Swift_Transport_SpoolTransport) {
                return;
            }

            $spool = $transport->getSpool();
            if (!$spool instanceof \Swift_MemorySpool) {
                return;
            }

            $spool->flushQueue($this->get('swiftmailer.transport.real'));

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
