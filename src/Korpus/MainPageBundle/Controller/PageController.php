<?php

namespace Korpus\MainPageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Korpus\DataBundle\Entity\NewsPost;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends Controller
{

    public function indexAction()
    {
        return $this->newsAction();
    }

    /**
     * News
     */
    public function newsAction()
    {
        $newsPost = $this->getDoctrine()->getRepository('KorpusDataBundle:NewsPost')->findLatestPost();

        if (!$newsPost) {
            throw new NotFoundHttpException("There is currently no NewsPost!");
        } else {
            $day = $newsPost->getPublishDay();
            $month = $newsPost->getPublishMonth();
            $year = $newsPost->getPublishYear();
            $slug = $newsPost->getSlug();

            return $this->redirect($this->generateUrl('korpus_main_page_news_post', array('day' => $day, 'month' => $month, 'year' => $year, 'slug' => $slug)));
        }
    }

    public function newsListAction()
    {
        $posts = $this->getDoctrine()->getRepository('KorpusDataBundle:NewsPost')->findAll();

        if (!$posts) {
            throw new NotFoundHttpException("There are currently no NewsPosts!");
        } else {
            return $this->render('KorpusMainPageBundle:Page:newsList.html.twig', array('posts' => $posts));
        }
    }

    public function newsPostAction($day, $month, $year, $slug)
    {
        $newsPost = $this->getDoctrine()->getRepository('KorpusDataBundle:NewsPost')->findOneBySlug($slug);

        if (!$newsPost) {
            throw new NotFoundHttpException("This NewsPost does not exist!");
        } else {
            if ($day != $newsPost->getPublishDay() || $month != $newsPost->getPublishMonth() || $year != $newsPost->getPublishYear()) {
                throw new NotFoundHttpException("This NewsPost does not exist!");
            }
        }

        $surroundingPosts = $this->getDoctrine()->getRepository('KorpusDataBundle:NewsPost')->findSurroundingPosts($slug);

        return $this->render('KorpusMainPageBundle:Page:newsPost.html.twig', array('newspost' => $newsPost, 'leftpost' => $surroundingPosts[0], 'rightpost' => $surroundingPosts[1]));
    }

    /**
     * Impressum
     */
    public function impressumAction()
    {
        return $this->render('KorpusMainPageBundle:Page:impressum.html.twig');
    }

    /**
     * Datenschutz
     */
    public function datenschutzAction()
    {
        return $this->render('KorpusMainPageBundle:Page:datenschutz.html.twig');
    }

    /**
     * Band
     */
    public function bandAction()
    {
        return $this->redirect($this->generateUrl('korpus_main_page_bio'));
    }

    public function bioAction()
    {
        return $this->render('KorpusMainPageBundle:Page:bio.html.twig');
    }

    public function memberAction($name)
    {
        if ($name === null)
            return $this->redirect($this->generateUrl('korpus_main_page_news', array('name' => 'Gastel'), true));
        else {
            return $this->render('KorpusMainPageBundle:Page:member.html.twig');
        }
    }
    
    /**
     * Live
     */
    public function liveAction() {
        $concerts = $this->getDoctrine()->getRepository('KorpusDataBundle:Concert')->findNextConcerts();
        $concertsAvailable = ($concerts != null);
        
        return $this->render('KorpusMainPageBundle:Page:live.html.twig', array('concerts' => $concerts, 'concerts_available' => $concertsAvailable));
    }
    
    public function concertAction($slug) {
        $concert = $this->getDoctrine()->getRepository('KorpusDataBundle:Concert')->findOneBySlug($slug);
        
        if(!$concert) {
            throw new NotFoundHttpException("This Concert does not exist!");
        } else {
            return $this->render('KorpusMainPageBundle:Page:concert.html.twig', array('concert' => $concert));
        }
    }

}
