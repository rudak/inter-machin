<?php

namespace AppBundle\Services\Command\Trade;

use AppBundle\Entity\Stats\ResourceStatus;
use AppBundle\Entity\Trade\Resource;
use AppBundle\Services\Command\CronEmCommand;
use AppBundle\Utils\Trade\ResourceHelper;

class ResourcesValues extends CronEmCommand
{

    const AMOUNT_PERCENTAGE = 20;
    const RESET_PERCENTAGE  = 15;

    public function updateThemAll()
    {
        $ressources = $this->em->getRepository(Resource::class)->findAll();
        foreach ($ressources as $resource) {
            /** @var $resource Resource */
            if (rand(0, 100) <= $resource->getCoef()) continue;
            $this->updateResource($resource);
            $this->em->persist($resource);
        }
        $this->em->flush();
    }

    private function updateResource(Resource $resource)
    {
        if (rand(0, self::RESET_PERCENTAGE) == self::RESET_PERCENTAGE) {
            $this->setDefaultValue($resource);
            return;
        }
        $amount = $this->getAmount($resource);

        ResourceHelper::addToValue($resource, $amount);
        return;
    }

    private function setDefaultValue(Resource $resource)
    {
        $resource->setValue($resource->getDefault());
    }

    private function getAmount(Resource $ressource)
    {
        $max = round(self::AMOUNT_PERCENTAGE * $ressource->getDefault() / 100);
        return rand(-$max, $max);
    }

}