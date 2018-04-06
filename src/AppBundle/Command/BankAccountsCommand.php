<?php

namespace AppBundle\Command;

use AppBundle\Services\Command\BankAccounts;
use AppBundle\Utils\Cron\Timer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BankAccountsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:bank:accounts')
            ->setDescription('instantané de l\'état des comptes en bdd pour etablir des graphiques bancaires')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (
            Timer::isTimeToRun('0 0 * * *') ||
            Timer::isTimeToRun('0 6 * * *') ||
            Timer::isTimeToRun('0 12 * * *') ||
            Timer::isTimeToRun('0 18 * * *')
        ) {
            $this->getContainer()->get(BankAccounts::class)->execute();
        }
    }

}
