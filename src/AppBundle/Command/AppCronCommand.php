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
        $luckyCommand = $this->getApplication()->find('app:lucky-man');
        $luckyCommand->run(new ArrayInput([]), new NullOutput());
        $output->writeln('luck ok');
    }

}
