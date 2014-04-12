<?php

namespace Korpus\MainPageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

class MerchController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryCollectionAction()
    {
        $articleGroups = $this->getDoctrine()->getRepository('KorpusDataBundle:ArticleGroup')->findAll();

        return $this->render('KorpusMainPageBundle:Merch:categoryCollection.html.twig', array(
            'groups' => $articleGroups
        ));
    }

    public function articleCollectionAction($catId)
    {
        $group = $this->getDoctrine()->getRepository('KorpusDataBundle:ArticleGroup')->findOneById($catId);

        if (!$group) {
            throw new NotFoundHttpException('This Category doesn\'t exist!');
        }

        return $this->render('KorpusMainPageBundle:Merch:articleCollection.html.twig', array(
            'group' => $group
        ));
    }

    /**
     * @param int $catId
     * @param string $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function articleAction($catId, $slug)
    {
        $article = $this->getDoctrine()->getRepository('KorpusDataBundle:Article')->findOneBySlug($slug);

        return $this->render('KorpusMainPageBundle:Merch:article.html.twig', array(
            'article' => $article
        ));
    }

    public function orderAction($catId, $slug)
    {
    }
}
