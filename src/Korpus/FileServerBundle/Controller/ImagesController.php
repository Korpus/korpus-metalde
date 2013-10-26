<?php

namespace Korpus\FileServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\Request;

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

        if ($folder == 'root') {
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

    public function objectAction($folder, $slug, $extension, Request $request)
    {
        $image = $this->getDoctrine()->getRepository('KorpusDataBundle:File')->findOneBySlug($slug);

        $thumbnail = (bool) $request->get('thumbnail');
        if ($thumbnail === null)
            $thumbnail = false;

        if (!$image) {
            throw new FileNotFoundException($this->generateUrl('korpus_file_server_images_object', array('folder' => $folder, 'slug' => $slug, 'extension' => $extension)));
        } else {
            if ($image->getFolder() == $folder) {
                if ($image->getType()->getExtension() == $extension) {
                    $filename = '../files/uploads/' . $image->getHash();
                    $file = file_get_contents($filename);

                    if ($thumbnail == true) {
                        // Set a maximum height and width
                        $width = 100;
                        $height = 100;

                        // Get new dimensions
                        list($width_orig, $height_orig) = getimagesize($filename);

                        $ratio_orig = $width_orig / $height_orig;

                        if ($width / $height > $ratio_orig) {
                            $width = $height * $ratio_orig;
                        } else {
                            $height = $width / $ratio_orig;
                        }

                        // Resample
                        $image_p = imagecreatetruecolor($width, $height);
                        $imageh = imagecreatefromjpeg($filename);
                        imagecopyresampled($image_p, $imageh, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

                        // Output
                        $file = imagejpeg($image_p, null, 100);
                        $file = $image_p;
                        
                        //var_dump($image_p);
                    }

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
