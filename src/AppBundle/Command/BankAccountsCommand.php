<?php

namespace AppBundle\Command;

use AppBundle\Services\Command\Stats\BankAccounts;
use AppBundle\Utils\Cron\Timer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
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
        if (Timer::isTimeToRun(Timer::PATTERN_ALL_HOURS)) {
            $this->getContainer()->get(BankAccounts::class)->execute();
        }
    }

}
