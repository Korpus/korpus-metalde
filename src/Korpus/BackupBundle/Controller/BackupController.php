<?php

namespace Korpus\BackupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BackupController extends Controller
{

    public function indexAction()
    {
        return $this->render('KorpusBackupBundle:Backup:index.html.twig');
    }

    public function allDBAction()
    {
        return $this->render('KorpusBackupBundle:Backup:allDB.html.twig');
    }

    public function oneDBAction($db_name)
    {
        return $this->render('KorpusBackupBundle:Backup:oneDB.html.twig');
    }

}
