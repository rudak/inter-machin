<?php

namespace AppBundle\Command;

use AppBundle\Services\Command\ActionPointHandler;
use AppBundle\Utils\Cron\Timer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppActionPointCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:action-point')
            ->setDescription('Gestion des points d\'action')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (true || Timer::isTimeToRun(Timer::PATTERN_ALL_HOURS)) {
            $this->getContainer()->get(ActionPointHandler::class)->addPoints();
        }
    }

}
