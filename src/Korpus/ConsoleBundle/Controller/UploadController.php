<?php

namespace Korpus\ConsoleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Korpus\DataBundle\Entity\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class UploadController extends Controller
{

    public function fileAction(Request $request)
    {
        $file = new File();

        //$uploadedFile = new UploadedFile();
        $uploadedFile = $request->files->get('file');

        $supportedMimeTypes = array(
            'image/png',
            'image/jpg'
        );

        //if (in_array($uploadedFile->getMimeType(), $supportedMimeTypes)) {
            $file->setCreationDate(new \DateTime('now'));
            $file->setHash(md5($uploadedFile->getClientOriginalExtension()));
            $file->setSlug('dwdw');
            $file->setPath('');
            $file->setTitle('wdw');
            
            $fileType = $this->getDoctrine()->getRepository('KorpusDataBundle:FileType')->findOneByExtension(str_replace('.', '', $uploadedFile->getClientOriginalExtension()));
            
            $file->setType($fileType);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($file);
            $em->flush();
            
            $uploadedFile->move($file->getAbsolutePath(), $file->getHash());
        //}

        $response = new Response(json_encode(array('status' => '#')));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}
