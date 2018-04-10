<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

class AppCronCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:cron')
            ->setDescription('Commande qui sera lancée par le cron job')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // commande de chance
        $luckyCommand = $this->getApplication()->find('app:luck');
        $luckyCommand->run(new ArrayInput([]), new NullOutput());
        // commande de poisse
        $NoluckCommand = $this->getApplication()->find('app:no-luck');
        $NoluckCommand->run(new ArrayInput([]), new NullOutput());
        // commande du banquier
        $bankCommand = $this->getApplication()->find('app:bank');
        $bankCommand->run(new ArrayInput([]), new NullOutput());
        // commande de la banque
        $bankAccounts = $this->getApplication()->find('app:bank:accounts');
        $bankAccounts->run(new ArrayInput([]), new NullOutput());
        // cities command
        $cityCommand = $this->getApplication()->find('app:city');
        $cityCommand->run(new ArrayInput([]), new NullOutput());
        // action point command
        $actionPoint = $this->getApplication()->find('app:action-point');
        $actionPoint->run(new ArrayInput([]), new NullOutput());
    }

}
