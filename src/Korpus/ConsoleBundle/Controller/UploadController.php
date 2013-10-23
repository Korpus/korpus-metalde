<?php

namespace Korpus\ConsoleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Korpus\DataBundle\Entity\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Korpus\HelperBundle\Component\FileHelper;

class UploadController extends Controller
{

    public function fileAction(Request $request)
    {
        $file = new File();

        //$uploadedFile = new UploadedFile();
        $uploadedFile = $request->files->get('file');

        $supportedFileTypes = $this->getDoctrine()->getRepository('KorpusDataBundle:FileType')->findAllActiveTypes();

        $returnData = array();
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

                    if ($request->get('title') !== null)
                        $file->setTitle($request->get('title'));
                    else
                        $file->setTitle('');

                    if ($request->get('folder') !== null) {
                        $file->setFolder($request->get('folder'));
                    } else {
                        $file->setFolder('root');
                    }

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
