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
        $commandNames = [
            'app:luck', 'app:no-luck', 'app:bank', 'app:bank:accounts', 'app:city', 'app:action-point',
        ];

        foreach ($commandNames as $commandName) {
            $action = $this->getApplication()->find($commandName);
            $action->run(new ArrayInput([]), new NullOutput());
        }
    }

}
