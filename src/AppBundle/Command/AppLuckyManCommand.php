<?php

namespace AppBundle\Command;

use AppBundle\Services\Command\User\LuckMoney;
use AppBundle\Services\Command\User\LuckPA;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AppLuckyManCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:luck')
            ->setDescription("Commande qui te file des trucs par moment si t'as de la chatte")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get(LuckMoney::class)->execute();
        $this->getContainer()->get(LuckPA::class)->execute();
    }

}
