<?php

namespace Korpus\BackupBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Korpus\BackupBundle\Component\BackupMaker;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

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
                        'database', InputArgument::OPTIONAL, 'Which DB to Backup, optional'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $database = $input->getArgument('database');
        $allDB = true;
        if ($database)
            $allDB = false;

        $target = $input->getArgument('target');
        if (!$target) {
            $output->writeln('Target is empty!');
            return;
        }

        if (substr($target, -1) != DIRECTORY_SEPARATOR)
            $target .= DIRECTORY_SEPARATOR;

        $targettype = $input->getArgument('targettype');
        if (!in_array(strtolower($targettype), array('mail', 'folder'))) {
            $output->writeln('Target Type not matched!');
            return;
        } else {
            $host = $this->getContainer()->getParameter('database_host');
            $user = $this->getContainer()->getParameter('database_user');
            $password = $this->getContainer()->getParameter('database_password') != 'null' ? $this->getContainer()->getParameter('database_password') : '';

            $fs = new Filesystem();
            $dumps = array();

            if (!$allDB) {
                $dumps[] = BackupMaker::backupTables($host, $user, $password, $database);
                $output->writeln($allDB);
            } else {
                $output->writeln($allDB);
            }
            
            $output->writeln($target);

            foreach ($dumps as $dump) {
                if ($targettype == 'folder') {
                    $fs->dumpFile($target . 'db-backup-' . $database . '-' . time() . '.sql', $dump);
                    $output->writeln($target . 'db-backup-' . $database . '-' . time() . '.sql');
                } else if ($targettype == 'mail') {
                    
                }
            }

            $output->writeln('Saved!');
        }
    }

}