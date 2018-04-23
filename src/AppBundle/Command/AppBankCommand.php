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
        if (Timer::isTimeToRun('0 * * * *') || Timer::isTimeToRun('20 * * * *') || Timer::isTimeToRun('40 * * * *')) {
            $this->getContainer()->get(Banker::class)->friendlyVisit();
        }
        if (Timer::isTimeToRun(Timer::PATTERN_ALL_MINUTES)) {
            $this->getContainer()->get(Banker::class)->answeringRequestedLoan();
            $this->getContainer()->get(Banker::class)->savingInterests();
        }
        if (Timer::isTimeToRun(Timer::PATTERN_ALL_DAYS)) {
            $this->getContainer()->get(Banker::class)->reminderLoan();
        }
    }
}
