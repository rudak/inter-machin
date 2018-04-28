<?php

namespace AppBundle\Services\Command\Stats;

use AppBundle\Entity\Stats\ResourceStatus;
use AppBundle\Entity\Trade\Resource;
use AppBundle\Services\Command\CronEmCommand;

class RessourceStatusHandler extends CronEmCommand
{
    public function execute()
    {
        foreach ($this->em->getRepository(Resource::class)->findAll() as $resource) {
            /** @var $resource Resource */
            $this->em->persist(new ResourceStatus($resource));
        }
        $this->em->flush();
    }
}