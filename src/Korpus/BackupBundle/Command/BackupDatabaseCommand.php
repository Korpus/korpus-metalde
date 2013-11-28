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
                        'database', InputArgument::OPTIONAL, 'Which DB to Backup, optional'
                )
                ->addArgument(
                        'target', InputArgument::REQUIRED, 'Target, whether mailaddress or folderlocation'
                )
                ->addArgument(
                        'targettype', InputArgument::REQUIRED, 'Which TargetType -> mail, folder'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
    }

}