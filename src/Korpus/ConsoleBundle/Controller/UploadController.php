<?php

namespace Korpus\ConsoleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Korpus\DataBundle\Entity\File;
use Symfony\Component\HttpFoundation\Response;
use Korpus\HelperBundle\Component\FileHelper;

class UploadController extends Controller
{

    public function fileAction(Request $request)
    {
        $file = new File();
        $returnData = array();

        //$uploadedFile = new UploadedFile();
        $uploadedFile = $request->files->get('file');
        $title = $request->get('title');
        $folder = $request->get('folder');

        if ($title === null) {
            $returnData['status'] = 'error';
            $returnData['message'] = 'Title Attribute must be provided!';

            $response = new Response(json_encode($returnData));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        if ($folder === null) {
            $folder = 'root';
        }

        $supportedFileTypes = $this->getDoctrine()->getRepository('KorpusDataBundle:FileType')->findAllActiveTypes();

        $fileType = $this->getDoctrine()->getRepository('KorpusDataBundle:FileType')->findOneByExtension(str_replace('.', '', $uploadedFile->getClientOriginalExtension()));

        try {
            //check if file exists
            $dbfile = $this->getDoctrine()->getRepository('KorpusDataBundle:File')->findOneByHash(md5($uploadedFile->getClientOriginalName()));
            if (!$dbfile) {
                if (in_array($fileType, $supportedFileTypes)) {
                    $file->setCreationDate(new \DateTime('now'));
                    $file->setHash(md5($uploadedFile->getClientOriginalName()));
                    $file->setSlug(FileHelper::generateSlug(str_replace($uploadedFile->getClientOriginalExtension(), '', $uploadedFile->getClientOriginalName())));
                    $file->setPath('');

                    $file->setFolder($folder);
                    $file->setTitle($title);

                    $file->setType($fileType);

                    $uploadedFile->move($file->getAbsolutePath(), $file->getHash());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($file);
                    $em->flush();

                    $returnData['status'] = 'success';
                } else {
                    $returnData['status'] = 'error';
                    $returnData['message'] = 'Unsupported FileType!';
                }
            } else {
                $returnData['status'] = 'error';
                $returnData['message'] = 'This File does already exist!';
            }
        } catch (\Exception $exc) {
            $returnData['status'] = 'error';
            $returnData['message'] = $exc->getMessage();
        }


        $response = new Response(json_encode($returnData));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}
