<?php

namespace Korpus\FileServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

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
            $o['hash'] = $image->getHash();
            $output[] = $o;
        }

        $serializer = $this->get('jms_serializer');
        $data = $serializer->serialize($output, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function collectionThumbnailsAction($folder)
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
                'extension' => $image->getType()->getExtension(),
                'thumbnail' => 'true'
            ));
            $o['title'] = $image->getTitle();
            $o['hash'] = $image->getHash();
            $output[] = $o;
        }

        $serializer = $this->get('jms_serializer');
        $data = $serializer->serialize($output, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function getImageAction(Request $request, $folder, $slug, $extension)
    {
        /** @var $image Korpus\DataBundle\Entity\File */
        $image = $this->getDoctrine()->getRepository('KorpusDataBundle:File')->findOneBySlug($slug);

        $thumbnail = (bool)$request->get('thumbnail');
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
                        $imageinfo = getimagesize($filename);
                        $maxwidth = 150;
                        $maxheight = 150;

                        if ($request->get('maxwidth') != null) $maxwidth = $request->get('maxwidth');
                        if ($request->get('maxheight') != null) $maxheight = $request->get('maxheight');

                        //check if thumbnail exists
                        $thumbFolder = '../files/uploads/thumbs/';
                        $thumbFile = $thumbFolder . $image->getHash() . '_' . $maxwidth . 'x' . $maxheight;
                        $fs = new Filesystem();

                        //if thumbnail exists load its file
                        if ($fs->exists($thumbFile)) {
                            $file = file_get_contents($thumbFile);
                        } else {
                            $origratio = $imageinfo[0] / $imageinfo[1];

                            $width = $imageinfo[0];
                            $height = $imageinfo[1];

                            if ($height > $maxheight) {
                                $faktor = $maxheight / $imageinfo[1];
                                if ($faktor < 1) {
                                    $width = round($width * $faktor);
                                    $height = round($height * $faktor);
                                }
                            }

                            if ($width > $maxwidth) {
                                $faktor = $maxwidth / $width;
                                if ($faktor < 1) {
                                    $width = round($width * $faktor);
                                    $height = round($height * $faktor);
                                }
                            }

                            $image_p = imagecreatetruecolor($width, $height);

                            switch ($imageinfo[2]):
                                case IMAGETYPE_GIF:
                                    $img = imagecreatefromgif($filename);
                                    break;
                                case IMAGETYPE_JPEG:
                                case IMAGETYPE_JPEG2000:
                                    $img = imagecreatefromjpeg($filename);
                                    break;
                                case IMAGETYPE_PNG:
                                    $img = imagecreatefrompng($filename);
                                    break;
                                default:
                                    throw new Exception("invalid image");
                                    break;
                            endswitch;

                            imagecopyresampled($image_p, $img, 0, 0, 0, 0, $width, $height, $imageinfo[0], $imageinfo[1]);

                            //create thumb folder if not exists
                            if (!$fs->exists($thumbFolder)) {
                                $fs->mkdir($thumbFolder);
                            }

                            //generate empty file
                            $fs->touch($thumbFile);

                            //save generated thumbnail
                            switch ($imageinfo[2]):
                                case IMAGETYPE_GIF:
                                    imagegif($image_p, $thumbFile);
                                    break;
                                case IMAGETYPE_JPEG:
                                case IMAGETYPE_JPEG2000:
                                    imagejpeg($image_p, $thumbFile);
                                    break;
                                case IMAGETYPE_PNG:
                                    imagepng($image_p, $thumbFile);
                                    break;
                                default:
                                    throw new Exception("invalid image");
                                    break;
                            endswitch;

                            //load file
                            $file = file_get_contents($thumbFile);
                        }
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
