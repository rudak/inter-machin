<?php

namespace AppBundle\Command;

use AppBundle\Services\Command\Banker;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AppBankCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:bank')
            ->setDescription('Action du banquier')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get(Banker::class)->execute();
    }
}
