<?php

namespace AppBundle\Command;

use AppBundle\Services\Command\Stats\RessourceStatusHandler;
use AppBundle\Services\Command\Trade\ResourcesValues;
use AppBundle\Utils\Cron\Timer;
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
            ->setDescription('Tout ce qui concerne le trading par cron')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (
            Timer::isTimeToRun('5 * * * *') ||
            Timer::isTimeToRun('25 * * * *') ||
            Timer::isTimeToRun('45 * * * *')
        ) {
            $this->getContainer()->get(ResourcesValues::class)->updateThemAll();
            $this->getContainer()->get(RessourceStatusHandler::class)->execute();
        }
    }

}
