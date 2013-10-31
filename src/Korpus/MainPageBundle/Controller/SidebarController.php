<?php

namespace Korpus\MainPageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SidebarController extends Controller
{

    public function nextConcertsAction($max = 3)
    {
        $concerts = $this->getDoctrine()->getRepository('KorpusDataBundle:Concert')->findXNextConcerts($max);

        return $this->render('KorpusMainPageBundle:Sidebar:nextConcerts.html.twig', array(
                    'concerts' => $concerts
        ));
    }

}
