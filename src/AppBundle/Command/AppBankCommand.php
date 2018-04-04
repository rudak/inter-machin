<?php

namespace AppBundle\Command;

use AppBundle\Services\Command\Banker;
use AppBundle\Utils\Cron\Timer;
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
            ->setDescription('Actions du banquier')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (true || Timer::isTimeToRun(Timer::PATTERN_ALL_MINUTES)) {
            $this->getContainer()->get(Banker::class)->friendlyVisit();
            $this->getContainer()->get(Banker::class)->reminderLoan();
            $this->getContainer()->get(Banker::class)->answeringRequestedLoan();
        }
        if (Timer::isTimeToRun(Timer::PATTERN_ALL_DAYS)) {
            $this->getContainer()->get(Banker::class)->reminderLoan();
        }
    }
}
