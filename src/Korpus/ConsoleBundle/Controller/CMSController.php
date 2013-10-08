<?php

namespace Korpus\ConsoleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Korpus\DataBundle\Entity\NewsPost;
use Symfony\Component\HttpFoundation\Request;
use Korpus\HelperBundle\Component\NewsPostHelper;

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

    public function updateNewsAction()
    {
        return $this->render('KorpusConsoleBundle:CMS:news_update.html.twig');
    }

    public function deleteNewsAction()
    {
        return $this->render('KorpusConsoleBundle:CMS:news_delete.html.twig');
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
        $concerts = $this->getDoctrine()->getRepository('KorpusDataBundle:Concert')->findAll();
        $concertsAvailable = !(!$concerts);

        return $this->render('KorpusConsoleBundle:CMS:concert.html.twig', array('concerts' => $concerts, 'concerts_available' => $concertsAvailable));
    }

    public function createConcertAction()
    {
        return $this->render('KorpusConsoleBundle:CMS:concert_create.html.twig');
    }

    public function updateConcertAction()
    {
        return $this->render('KorpusConsoleBundle:CMS:concert_update.html.twig');
    }

    public function deleteConcertAction()
    {
        return $this->render('KorpusConsoleBundle:CMS:concert_delete.html.twig');
    }

    public function viewConcertAction()
    {
        return $this->render('KorpusConsoleBundle:CMS:concert_view.html.twig');
    }

}
