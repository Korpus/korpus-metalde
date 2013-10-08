<?php

namespace Korpus\ConsoleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Korpus\DataBundle\Entity\NewsPost;
use Symfony\Component\HttpFoundation\Request;

class CMSController extends Controller
{

    /**
     * News
     */
    public function newsAction()
    {
        $posts = $this->getDoctrine()->getRepository('KorpusDataBundle:NewsPost')->findAll();
        $postsAvailable = !(!$posts);

        return $this->render('KorpusConsoleBundle:CMS:news.html.twig', array('posts' => $posts, 'posts_available' => $postsAvailable));
    }

    public function createNewsAction(Request $request)
    {
        $post = new NewsPost();

        $form = $this->createFormBuilder($post)
                ->add('title', 'text')
                ->add('text', 'text')
                ->add('publishDate')
                ->add('save', 'submit')
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database

            return $this->redirect($this->generateUrl('task_success'));
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
