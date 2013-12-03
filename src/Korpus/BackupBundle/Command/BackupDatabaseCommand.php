<?php

namespace Korpus\BackupBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BackupDatabaseCommand extends Command
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
        $allDB = false;
        if ($database)
            $allDB = true;

        $target = $input->getArgument('target');
        if (!$target) {
            $output->writeln('Target is empty!');
            return;
        }

        $targettype = $input->getArgument('targettype');
        if (!in_array(strtolower($targettype), array('mail', 'folder'))) {
            $output->writeln('Target Type not matched!');
            return;
        } else {
            $output->writeln('Saved!');
        }
    }

}