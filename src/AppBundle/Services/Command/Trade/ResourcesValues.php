<?php

namespace AppBundle\Services\Command\Trade;

use AppBundle\Entity\Stats\ResourceStatus;
use AppBundle\Entity\Trade\Resource;
use AppBundle\Services\Command\CronEmCommand;
use AppBundle\Utils\Trade\ResourceHelper;

class ResourcesValues extends CronEmCommand
{

    const RESET_PERCENTAGE = 15;

    public function updateThemAll()
    {
        $ressources = $this->em->getRepository(Resource::class)->findAll();
        foreach ($ressources as $resource) {
            /** @var $resource Resource */
            if (rand(0, 100) <= $resource->getCoef()) continue;
            $this->updateResource($resource);
            $this->em->persist($resource);
//            $this->em->persist(new ResourceStatus($resource));
        }
        $this->em->flush();
    }

    private function updateResource(Resource $resource)
    {
        if (rand(0, self::RESET_PERCENTAGE) == self::RESET_PERCENTAGE) {
            $this->setDefaultValue($resource);
            return;
        }
        $amount = rand(1, $resource->getCoef());
        if (rand(0, 1)) {
            ResourceHelper::addToValue($resource, $amount);
            return;
        }
        ResourceHelper::removeToValue($resource, $amount);
    }

    private function setDefaultValue(Resource $resource)
    {
        $resource->setValue($resource->getDefault());
    }

}