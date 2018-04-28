<?php

namespace AppBundle\Command;

use AppBundle\Services\Command\Trade\ResourcesValues;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AppTradeCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:trade')
            ->setDescription('tout ce qui concerne le trading par cron')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get(ResourcesValues::class)->updateThemAll();
    }

}
