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
                        'target', InputArgument::REQUIRED, 'Output Folder'
                )
                ->addArgument(
                        'database', InputArgument::REQUIRED, 'Which DB to Backup'
                )
                ->addArgument(
                        'mail', InputArgument::OPTIONAL, 'MailAddress, optional'
        );
    }

    protected function sendMail($to, $from, $subject, $body, $attachmentPath = null)
    {
        $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($from)
                ->setTo($to)
                ->setBody($body)
        ;

        if ($attachmentPath != null)
            $message->attach(\Swift_Attachment::fromPath($attachmentPath));

        $this->getContainer()->get('mailer')->send($message);

        $transport = $this->getContainer()->get('mailer')->getTransport();
        if (!$transport instanceof \Swift_Transport_SpoolTransport) {
            return;
        }

        $spool = $transport->getSpool();
        if (!$spool instanceof \Swift_MemorySpool) {
            return;
        }

        $spool->flushQueue($this->getContainer()->get('swiftmailer.transport.real'));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //get and check database argument
        $database = $input->getArgument('database');
        if (!$database) {
            $output->writeln('Database Argument is empty!');
            return;
        }

        //get and check target argument
        $target = $input->getArgument('target');
        if (!$target) {
            $output->writeln('Target Argument is empty!');
            return;
        }

        //get and check mail argument
        $mail = $input->getArgument('mail');
        if (!$mail) {
            $mail = null;
        }

        //put DS at end of path
        if (substr($target, -1) != DIRECTORY_SEPARATOR)
            $target .= DIRECTORY_SEPARATOR;

        //get db parameters from container
        $host = $this->getContainer()->getParameter('database_host');
        $user = $this->getContainer()->getParameter('database_user');
        $password = $this->getContainer()->getParameter('database_password') != 'null' ? $this->getContainer()->getParameter('database_password') : '';

        //get filesystem handle
        $fs = new Filesystem();

        //dump the db in a string
        $dump = BackupMaker::backupTables($host, $user, $password, $database);

        //output file path
        $path = $target . date('YmdHis') . '_backup_' . $database . '.sql';

        //write file
        $fs->dumpFile($path, $dump);
        $output->writeln('File written to: ' . $path);

        //send mail
        if ($mail != null) {
            if ($dump != '' && $dump != null) {
                $this->sendMail($mail, 'backup@biesti.com', 'DATABASE BACKUP : ' . $database . ' : ' . date('Y.m.d H:i:s'), 'Backup', $path);
                $output->writeln('File was sent to ' . $mail);
            }
            else
                $this->sendMail($mail, 'backup@biesti.com', 'Database Backup Failed! ' . date('Y.m.d H:i:s'), 'Backup Failed ' . date('Y.m.d H:i:s'));
        }
    }

}