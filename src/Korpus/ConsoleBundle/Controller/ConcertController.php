<?php

namespace Korpus\ConsoleBundle\Controller;

/**
 * ConcertController
 *
 * @author Florian Weber <florian.weber.dd@icloud.com>
 */

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Korpus\DataBundle\Entity\Concert;
use Korpus\HelperBundle\Component\ConcertHelper;

class ConcertController extends Controller
{

    public function collectionAction()
    {
        $concerts = $this->getDoctrine()->getRepository('KorpusDataBundle:Concert')->findNextConcerts();

        return $this->render('KorpusConsoleBundle:Concert:collection.html.twig', array('concerts' => $concerts));
    }

    public function createAction(Request $request)
    {
        $session = $request->getSession();

        if ($request->get('sent')) {
            $concert = new Concert();
            $concert->setCity($request->get('city'));
            $concert->setConcertDate(new \DateTime($request->get('concertDate')));
            $concert->setCreationDate(new \DateTime('now'));
            $concert->setEventName($request->get('eventName'));
            $concert->setFacebookLink($request->get('facebookLink'));
            $concert->setInfo($request->get('info'));
            $concert->setSlug(ConcertHelper::generateSlug(new \DateTime($request->get('concertDate')), $request->get('eventName'), $request->get('city')));
            $concert->setState($request->get('state'));
            $concert->setVenue($request->get('venue'));

            $validator = $this->container->get('validator');
            $errors = $validator->validate($concert);

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $session->getFlashBag()->add('error', $error);
                }
                return $this->render('KorpusConsoleBundle:Concert:create.html.twig');
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($concert);
            $em->flush();

            return $this->redirect($this->generateUrl('korpus_console_concerts_collection'));
        }

        return $this->render('KorpusConsoleBundle:Concert:create.html.twig');
    }

    public function objectAction(Request $request, $id)
    {

    }

    public function updateAction(Request $request, $id)
    {
        $concert = $this->getDoctrine()->getRepository('KorpusDataBundle:Concert')->findOneById($id);
        $session = $request->getSession();

        if (!$concert) {
            $session->getFlashBag()->add('error', 'Konzert nicht gefunden!');
            return $this->redirect($this->generateUrl('korpus_console_concerts_collection'));
        }

        if ($request->get('sent')) {
            $concert->setCity($request->get('city'));
            $concert->setConcertDate(new \DateTime($request->get('concertDate')));
            $concert->setEditDate(new \DateTime('now'));
            $concert->setEventName($request->get('eventName'));
            $concert->setFacebookLink($request->get('facebookLink'));
            $concert->setInfo($request->get('info'));
            $concert->setSlug(ConcertHelper::generateSlug(new \DateTime($request->get('concertDate')), $request->get('eventName'), $request->get('city')));
            $concert->setState($request->get('state'));
            $concert->setVenue($request->get('venue'));

            $validator = $this->container->get('validator');
            $errors = $validator->validate($concert);

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $session->getFlashBag()->add('error', $error);
                }
                return $this->render('KorpusConsoleBundle:Concert:update.html.twig', array(
                    'concert' => $concert
                ));
            }

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect($this->generateUrl('korpus_console_concerts_collection'));
        }

        return $this->render('KorpusConsoleBundle:Concert:update.html.twig', array(
            'concert' => $concert
        ));
    }

    public function deleteAction(Request $request, $id)
    {

    }

}
