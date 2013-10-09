<?php

namespace Korpus\ConsoleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Korpus\DataBundle\Entity\NewsPost;
use Symfony\Component\HttpFoundation\Request;
use Korpus\HelperBundle\Component\NewsPostHelper;
use Korpus\DataBundle\Entity\Concert;
use Korpus\HelperBundle\Component\ConcertHelper;

class CMSController extends Controller
{

    /**
     * News
     */
    public function newsAction()
    {
        $posts = $this->getDoctrine()->getRepository('KorpusDataBundle:NewsPost')->findAllOrdered();
        $postsAvailable = !(!$posts);

        return $this->render('KorpusConsoleBundle:CMS:news.html.twig', array('posts' => $posts, 'posts_available' => $postsAvailable));
    }

    public function createNewsAction(Request $request)
    {
        $post = new NewsPost();

        $form = $this->createFormBuilder($post)
                ->add('title', 'text', array('label' => 'Titel'))
                ->add('text', 'textarea', array('label' => 'Text'))
//                ->add('publishDate', 'datetime', array('widget' => 'single_text', 'label' => 'VÖ-Datum'))
                ->add('publishDate', 'datetime', array('label' => 'VÖ-Datum'))
                ->add('save', 'submit', array('label' => 'Speichern'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $post->setCreationDate(new \DateTime('now'));
            $post->setSlug(NewsPostHelper::generateSlug($post->getTitle()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirect($this->generateUrl('korpus_console_cms_news'));
        }

        return $this->render('KorpusConsoleBundle:CMS:news_create.html.twig', array('form' => $form->createView()));
    }

    public function updateNewsAction(Request $request, $slug)
    {
        $post = $this->getDoctrine()->getRepository('KorpusDataBundle:NewsPost')->findOneBySlug($slug);

        $form = $this->createFormBuilder($post)
                ->add('title', 'text', array('label' => 'Titel'))
                ->add('text', 'textarea', array('label' => 'Text'))
//                ->add('publishDate', 'datetime', array('widget' => 'single_text', 'label' => 'VÖ-Datum'))
                ->add('publishDate', 'datetime', array('label' => 'VÖ-Datum'))
                ->add('save', 'submit', array('label' => 'Speichern'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $post->setEditDate(new \DateTime('now'));
            $post->setSlug(NewsPostHelper::generateSlug($post->getTitle()));

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect($this->generateUrl('korpus_console_cms_news'));
        }

        return $this->render('KorpusConsoleBundle:CMS:news_update.html.twig', array('form' => $form->createView()));
    }

    public function deleteNewsAction(Request $request, $slug)
    {
        $post = $this->getDoctrine()->getRepository('KorpusDataBundle:NewsPost')->findOneBySlug($slug);

        if ($request->get('delete') == 1) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();

            return $this->redirect($this->generateUrl('korpus_console_cms_news'));
        }

        return $this->render('KorpusConsoleBundle:CMS:news_delete.html.twig', array('post' => $post));
    }

    public function viewNewsAction()
    {
        return $this->render('KorpusConsoleBundle:CMS:news_view.html.twig');
    }

    /**
     * Concert
     */
    public function concertAction()
    {
        $concerts = $this->getDoctrine()->getRepository('KorpusDataBundle:Concert')->findAllOrdered();
        $concertsAvailable = !(!$concerts);

        return $this->render('KorpusConsoleBundle:CMS:concert.html.twig', array('concerts' => $concerts, 'concerts_available' => $concertsAvailable));
    }

    public function createConcertAction(Request $request)
    {
        $concert = new Concert();

        $form = $this->createFormBuilder($concert)
                ->add('event', 'text', array('label' => 'Event'))
                ->add('venue', 'text', array('label' => 'Location'))
                ->add('city', 'text', array('label' => 'Stadt'))
                ->add('concertDate', 'datetime', array('label' => 'Konzert-Datum'))
                ->add('facebookLink', 'text', array('label' => 'Facebook Link (optional)', 'required' => false))
                ->add('info', 'text', array('label' => 'Information (optional)', 'required' => false))
                ->add('save', 'submit', array('label' => 'Speichern'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $concert->setCreationDate(new \DateTime('now'));
            $concert->setSlug(ConcertHelper::generateSlug($concert->getConcertDate(), $concert->getEvent(), $concert->getCity()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($concert);
            $em->flush();

            return $this->redirect($this->generateUrl('korpus_console_cms_concert'));
        }

        return $this->render('KorpusConsoleBundle:CMS:concert_create.html.twig', array('form' => $form->createView()));
    }

    public function updateConcertAction(Request $request, $slug)
    {
        $concert = $this->getDoctrine()->getRepository('KorpusDataBundle:Concert')->findOneBySlug($slug);

        $form = $this->createFormBuilder($concert)
                ->add('event', 'text', array('label' => 'Event'))
                ->add('venue', 'text', array('label' => 'Location'))
                ->add('city', 'text', array('label' => 'Stadt'))
                ->add('concertDate', 'datetime', array('label' => 'Konzert-Datum'))
                ->add('facebookLink', 'text', array('label' => 'Facebook Link (optional)', 'required' => false))
                ->add('info', 'text', array('label' => 'Information (optional)', 'required' => false))
                ->add('save', 'submit', array('label' => 'Speichern'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $concert->setEditDate(new \DateTime('now'));
            $concert->setSlug(ConcertHelper::generateSlug($concert->getConcertDate(), $concert->getEvent(), $concert->getCity()));

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect($this->generateUrl('korpus_console_cms_concert'));
        }

        return $this->render('KorpusConsoleBundle:CMS:concert_create.html.twig', array('form' => $form->createView()));
    }

    public function deleteConcertAction(Request $request, $slug)
    {
        $concert = $this->getDoctrine()->getRepository('KorpusDataBundle:Concert')->findOneBySlug($slug);

        if ($request->get('delete') == 1) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($concert);
            $em->flush();

            return $this->redirect($this->generateUrl('korpus_console_cms_concert'));
        }

        return $this->render('KorpusConsoleBundle:CMS:concert_delete.html.twig', array('concert' => $concert));
    }

    public function viewConcertAction()
    {
        return $this->render('KorpusConsoleBundle:CMS:concert_view.html.twig');
    }

}
