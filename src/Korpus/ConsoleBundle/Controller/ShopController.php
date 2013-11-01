<?php

namespace Korpus\ConsoleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Korpus\DataBundle\Entity\Article;
use Symfony\Component\HttpFoundation\Request;
use Korpus\HelperBundle\Component\ArticleHelper;

class ShopController extends Controller
{

    /**
     * Articles
     */
    public function articlesAction()
    {
        $articles = $this->getDoctrine()->getRepository('KorpusDataBundle:Article')->findAll();

        return $this->render('KorpusConsoleBundle:Shop:articles.html.twig', array(
                    'articles' => $articles
        ));
    }

    public function createArticleAction(Request $request)
    {
        $article = new Article();

        $form = $this->createFormBuilder($article)
                ->add('title', 'text', array('label' => 'Titel'))
                ->add('price', 'number', array('label' => 'Preis'))
                ->add('group', 'entity', array(
                    'class' => 'KorpusDataBundle:ArticleGroup',
                    'property' => 'title',
                    'label' => 'Artikelgruppe'
                ))
                ->add('save', 'submit', array('label' => 'Speichern'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $article->setCreationDate(new \DateTime('now'));
            $article->setSlug(ArticleHelper::generateSlug($article->getTitle()));

            if ($request->get('img_hash') !== null || $request->get('img_hash') !== "") {
                $photo = $this->getDoctrine()->getRepository('KorpusDataBundle:File')->findOneByHash($request->get('img_hash'));
                if (!(!$photo)) {
                    $article->setPhoto($photo);
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirect($this->generateUrl('korpus_console_shop_articles'));
        }

        $tmpl = array(
            'form' => $form->createView(),
            'subpage' => 'article',
            'pagename' => 'Artikel',
            'backpath' => $this->generateUrl('korpus_console_shop_articles')
        );

        return $this->render('KorpusConsoleBundle:Shop:create_article.html.twig', $tmpl);
    }

    public function updateArticleAction(Request $request, $slug)
    {
        $article = $this->getDoctrine()->getRepository('KorpusDataBundle:Article')->findOneBySlug($slug);

        $form = $this->createFormBuilder($article)
                ->add('title', 'text', array('label' => 'Titel'))
                ->add('price', 'number', array('label' => 'Preis'))
                ->add('group', 'entity', array(
                    'class' => 'KorpusDataBundle:ArticleGroup',
                    'property' => 'title',
                    'label' => 'Artikelgruppe'
                ))
                ->add('save', 'submit', array('label' => 'Speichern'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $article->setEditDate(new \DateTime('now'));
            $article->setSlug(ArticleHelper::generateSlug($article->getTitle()));

            if ($request->get('img_hash') !== null || $request->get('img_hash') !== "") {
                $photo = $this->getDoctrine()->getRepository('KorpusDataBundle:File')->findOneByHash($request->get('img_hash'));
                if (!(!$photo)) {
                    $article->setPhoto($photo);
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect($this->generateUrl('korpus_console_shop_articles'));
        }

        $tmpl = array(
            'form' => $form->createView(),
            'subpage' => 'article',
            'pagename' => 'Artikel',
            'backpath' => $this->generateUrl('korpus_console_shop_articles')
        );

        return $this->render('KorpusConsoleBundle:Shop:update_article.html.twig', $tmpl);
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

}
