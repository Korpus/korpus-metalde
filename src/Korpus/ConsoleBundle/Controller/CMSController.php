<?php

namespace Korpus\ConsoleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Korpus\DataBundle\Entity\NewsPost;
use Symfony\Component\HttpFoundation\Request;
use Korpus\HelperBundle\Component\NewsPostHelper;
use Korpus\DataBundle\Entity\Concert;
use Korpus\HelperBundle\Component\ConcertHelper;
use Korpus\DataBundle\Entity\BandMember;
use Korpus\DataBundle\Entity\Record;
use Korpus\DataBundle\Entity\RecordTrack;

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

        $tmpl = array(
            'form' => $form->createView(),
            'subpage' => 'news',
            'pagename' => 'News',
            'backpath' => $this->generateUrl('korpus_console_cms_news')
        );

        return $this->render('KorpusConsoleBundle:CMS:create.html.twig', $tmpl);
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

        $tmpl = array(
            'form' => $form->createView(),
            'subpage' => 'news',
            'pagename' => 'News',
            'backpath' => $this->generateUrl('korpus_console_cms_news')
        );

        return $this->render('KorpusConsoleBundle:CMS:update.html.twig', $tmpl);
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

        $concert->setConcertDate(new \DateTime('now'));

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

            if ($request->get('img_hash') !== null || $request->get('img_hash') !== "") {
                $flyer = $this->getDoctrine()->getRepository('KorpusDataBundle:File')->findOneByHash($request->get('img_hash'));
                if (!(!$flyer)) {
                    $concert->setFlyer($flyer);
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($concert);
            $em->flush();

            return $this->redirect($this->generateUrl('korpus_console_cms_concert'));
        }

        $tmpl = array(
            'form' => $form->createView(),
            'subpage' => 'concert',
            'pagename' => 'Konzerte',
            'backpath' => $this->generateUrl('korpus_console_cms_concert')
        );

        return $this->render('KorpusConsoleBundle:CMS:create_concert.html.twig', $tmpl);
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

            if ($request->get('img_hash') !== null || $request->get('img_hash') !== "") {
                $flyer = $this->getDoctrine()->getRepository('KorpusDataBundle:File')->findOneByHash($request->get('img_hash'));
                if (!(!$flyer)) {
                    $concert->setFlyer($flyer);
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect($this->generateUrl('korpus_console_cms_concert'));
        }

        $tmpl = array(
            'form' => $form->createView(),
            'subpage' => 'concert',
            'pagename' => 'Konzerte',
            'backpath' => $this->generateUrl('korpus_console_cms_concert')
        );

        return $this->render('KorpusConsoleBundle:CMS:update_concert.html.twig', $tmpl);
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

    /**
     * Member
     */
    public function memberAction()
    {
        $members = $this->getDoctrine()->getRepository('KorpusDataBundle:BandMember')->findAll();
        $membersAvailable = !(!$members);

        return $this->render('KorpusConsoleBundle:CMS:member.html.twig', array('members' => $members, 'members_available' => $membersAvailable));
    }

    public function createMemberAction(Request $request)
    {
        $member = new BandMember();

        $form = $this->createFormBuilder($member)
                ->add('nickname', 'text', array('label' => 'Nickname'))
                ->add('firstName', 'text', array('label' => 'Vorname'))
                ->add('lastName', 'text', array('label' => 'Nachname'))
                ->add('position', 'text', array('label' => 'Position'))
                ->add('equipment', 'text', array('label' => 'Equipment'))
                ->add('musik', 'text', array('label' => 'Musik'))
                ->add('interessen', 'text', array('label' => 'Interessen'))
                ->add('filme', 'text', array('label' => 'Filme'))
                ->add('bestesAlbum', 'text', array('label' => 'Bestes Album'))
                ->add('besteBand', 'text', array('label' => 'Beste Band'))
                ->add('lieblingsEssen', 'text', array('label' => 'Lieblings Essen'))
                ->add('besterDrink', 'text', array('label' => 'Bester Drink'))
                ->add('save', 'submit', array('label' => 'Speichern'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $member->setCreationDate(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($member);
            $em->flush();

            return $this->redirect($this->generateUrl('korpus_console_cms_member'));
        }

        $tmpl = array(
            'form' => $form->createView(),
            'subpage' => 'member',
            'pagename' => 'Mitglieder',
            'backpath' => $this->generateUrl('korpus_console_cms_member')
        );

        return $this->render('KorpusConsoleBundle:CMS:create.html.twig', $tmpl);
    }

    public function updateMemberAction(Request $request, $slug)
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

        $tmpl = array(
            'form' => $form->createView(),
            'subpage' => 'member',
            'pagename' => 'Mitglieder',
            'backpath' => $this->generateUrl('korpus_console_cms_member')
        );

        return $this->render('KorpusConsoleBundle:CMS:update.html.twig', $tmpl);
    }

    public function deleteMemberAction(Request $request, $slug)
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

    /**
     * Media
     */
    public function mediaAction()
    {
        $records = $this->getDoctrine()->getRepository('KorpusDataBundle:Record')->findAll();

        return $this->render('KorpusConsoleBundle:CMS:media.html.twig', array('records' => $records));
    }

    /**
     * Record
     */
    public function createMediaRecordAction(Request $request)
    {
        $record = new Record();

        $form = $this->createFormBuilder($record)
                ->add('title', 'text', array('label' => 'Titel'))
                ->add('publishDate', 'datetime', array('label' => 'VÖ-Datum'))
                ->add('save', 'submit', array('label' => 'Speichern'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $record->setCreationDate(new \DateTime('now'));

            if ($request->get('img_hash') !== null || $request->get('img_hash') !== "") {
                $cover = $this->getDoctrine()->getRepository('KorpusDataBundle:File')->findOneByHash($request->get('img_hash'));
                if (!(!$cover)) {
                    $record->setCover($cover);
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($record);
            $em->flush();

            return $this->redirect($this->generateUrl('korpus_console_cms_media'));
        }

        $tmpl = array(
            'form' => $form->createView(),
            'subpage' => 'record',
            'pagename' => 'Records',
            'backpath' => $this->generateUrl('korpus_console_cms_media')
        );

        return $this->render('KorpusConsoleBundle:CMS:create_record.html.twig', $tmpl);
    }

    public function updateMediaRecordAction(Request $request, $slug)
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

        $tmpl = array(
            'form' => $form->createView(),
            'subpage' => 'member',
            'pagename' => 'Mitglieder',
            'backpath' => $this->generateUrl('korpus_console_cms_member')
        );

        return $this->render('KorpusConsoleBundle:CMS:update.html.twig', $tmpl);
    }

    public function deleteMediaRecordAction(Request $request, $slug)
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
