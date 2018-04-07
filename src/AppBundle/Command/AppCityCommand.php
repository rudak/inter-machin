<?php

namespace AppBundle\Command;

use AppBundle\Services\Command\CityPrices;
use AppBundle\Services\Command\CityRotation;
use AppBundle\Utils\Cron\Timer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AppCityCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:city')
            ->setDescription('Tout ce qui concerne la ville.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (Timer::isTimeToRun('30 10 * * *') || Timer::isTimeToRun('30 22 * * *')) {
            $this->getContainer()->get(CityPrices::class)->update();
        }
        if (Timer::isTimeToRun('30 5 * * *')) {
            $this->getContainer()->get(CityRotation::class)->execute();
        }
    }

}
