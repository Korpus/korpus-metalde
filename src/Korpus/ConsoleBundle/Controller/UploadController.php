<?php

namespace Korpus\ConsoleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Korpus\DataBundle\Entity\File;

class UploadController extends Controller
{

    public function fileAction(Request $request)
    {
        $file = new File();
        $form = $this->createFormBuilder($file)
                ->add('name')
                ->add('file')
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $file->upload();

            $em->persist($file);
            $em->flush();

            return $this->redirect($this->generateUrl('korpus_console_homepage'));
        }

        return array('form' => $form->createView());
    }

}
