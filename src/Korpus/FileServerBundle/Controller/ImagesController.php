<?php

namespace Korpus\FileServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class ImagesController extends Controller
{

    public function indexAction()
    {
        return $this->render('KorpusFileServerBundle:Images:index.html.twig');
    }

    public function collectionAction($folder)
    {
        $images = null;
        $output = array();

        if ($folder == null) {
            $images = $this->getDoctrine()->getRepository('KorpusDataBundle:File')->findAllImages();
        } else {
            $images = $this->getDoctrine()->getRepository('KorpusDataBundle:File')->findAllImagesInFolder($folder);
        }

        //TODO
        //generate image path, then put into json
        foreach ($images as $image) {
            $o['path'] = $this->generateUrl('korpus_file_server_images_object', array(
                'folder' => $image->getFolder(),
                'slug' => $image->getSlug(),
                'extension' => $image->getType()->getExtension()
            ));
            $o['title'] = $image->getTitle();
            $output[] = $o;
        }

        $serializer = $this->get('jms_serializer');
        $data = $serializer->serialize($output, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function objectAction($folder, $slug, $extension)
    {
        $image = $this->getDoctrine()->getRepository('KorpusDataBundle:File')->findOneBySlug($slug);

        if (!$image) {
            throw new FileNotFoundException($this->generateUrl('korpus_file_server_images_object', array('folder' => $folder, 'slug' => $slug, 'extension' => $extension)));
        } else {
            if ($image->getFolder() == $folder) {
                if ($image->getType()->getExtension() == $extension) {
                    $file = file_get_contents('../files/uploads/' . $image->getHash());

                    return new Response($file, 200, array(
                        'Content-Type' => 'image/' . $image->getType()->getExtension()
                    ));
                } else {
                    throw new FileNotFoundException($this->generateUrl('korpus_file_server_images_object', array('folder' => $folder, 'slug' => $slug, 'extension' => $extension)));
                }
            } else {
                throw new FileNotFoundException($this->generateUrl('korpus_file_server_images_object', array('folder' => $folder, 'slug' => $slug, 'extension' => $extension)));
            }
        }
    }

}
