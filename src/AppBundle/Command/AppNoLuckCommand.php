<?php

namespace AppBundle\Command;

use AppBundle\Services\Command\NoLuckMoney;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AppNoLuckCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:no-luck')
            ->setDescription('no luck command')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get(NoLuckMoney::class)->updateMoney();
    }

}
