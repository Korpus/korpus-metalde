<?php

namespace Korpus\BackupBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Korpus\BackupBundle\Component\BackupMaker;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Filesystem\Filesystem;

class BackupDatabaseCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
                ->setName('backup:database')
                ->setDescription('Backup some or all Database')
                ->addArgument(
                        'targettype', InputArgument::REQUIRED, 'Which TargetType -> mail, folder'
                )
                ->addArgument(
                        'target', InputArgument::REQUIRED, 'Target, whether mailaddress or folderlocation'
                )
                ->addArgument(
                        'database', InputArgument::REQUIRED, 'Which DB to Backup, optional'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //get and check database argument
        $database = $input->getArgument('database');
        if (!$database) {
            $output->writeln('Database Argument is empty!');
            return;
        }

        //get and check targettype argument
        $targettype = $input->getArgument('targettype');
        if (!in_array(strtolower($targettype), array('mail', 'folder'))) {
            $output->writeln('Target Type not matched!');
            return;
        }

        //get and check target argument
        $target = $input->getArgument('target');
        if (!$target) {
            $output->writeln('Target Argument is empty!');
            return;
        }

        //put DS at end of path
        if ($targettype == 'folder') {
            if (substr($target, -1) != DIRECTORY_SEPARATOR)
                $target .= DIRECTORY_SEPARATOR;
        }

        //get db parameters from container
        $host = $this->getContainer()->getParameter('database_host');
        $user = $this->getContainer()->getParameter('database_user');
        $password = $this->getContainer()->getParameter('database_password') != 'null' ? $this->getContainer()->getParameter('database_password') : '';

        //get filesystem handle
        $fs = new Filesystem();

        //dump the db in a string
        $dump = BackupMaker::backupTables($host, $user, $password, $database);

        if ($targettype == 'folder') {
            //output file path
            $path = $target . date('YmdHis') . '_backup_' . $database . '.sql';

            //write file
            $fs->dumpFile($path, $dump);
            $output->writeln('File written to: ' . $path);
        } else if ($targettype == 'mail') {
            $tempPath = sys_get_temp_dir();

            if (substr($tempPath, -1) != DIRECTORY_SEPARATOR)
                $tempPath .= DIRECTORY_SEPARATOR;

            $tempFile = $tempPath . date('YmdHis') . '_backup_' . $database . '.sql';

            $message = \Swift_Message::newInstance()
                    ->setSubject('DATABASE BACKUP : ' . $database . ' : ' . date('Y.m.d H:i:s'))
                    ->setFrom('backup@biesti.com')
                    ->setTo($target)
                    ->setBody('Backup');
//                    ->attach(\Swift_Attachment::fromPath($tempFile));

            $this->getContainer()->get('mailer')->send($message);

            $fs->remove($tempFile);

            $output->writeln('File was sent to ' . $target);
        }
    }

}