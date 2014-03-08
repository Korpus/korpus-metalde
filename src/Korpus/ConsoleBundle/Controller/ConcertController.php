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

class ConcertController extends Controller
{

    public function collectionAction()
    {
        $concerts = $this->getDoctrine()->getRepository('KorpusDataBundle:Concert')->findAllOrdered();

        return $this->render('KorpusConsoleBundle:Concert:collection.html.twig', array('concerts' => $concerts));
    }

    public function createAction(Request $request)
    {

    }

    public function objectAction(Request $request, $id)
    {

    }

    public function updateAction(Request $request, $id)
    {

    }

    public function deleteAction(Request $request, $id)
    {

    }

}
