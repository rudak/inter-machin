<?php

namespace AppBundle\Utils\Trade;

use AppBundle\Entity\Trade\Resource;

class ResourceHelper
{

    public static function isQuantityAvailable(Resource $resource, $quantity)
    {
        return $resource->getQuantity() >= $quantity;
    }

    public static function removeQuantity(Resource $resource, $quantity)
    {
        $resource->setQuantity($resource->getQuantity() - $quantity);
    }

    public static function addQuantity(Resource $resource, $quantity)
    {
        $resource->setQuantity($resource->getQuantity() + $quantity);
    }

    public static function addToValue(Resource $resource, $amount)
    {
        $resource->setValue($resource->getValue() + $amount);
    }

    public static function removeToValue(Resource $resource, $amount)
    {
        $resource->setValue($resource->getValue() - $amount);
        if ($resource->getValue() < Resource::MIN_PRICE) {
            $resource->setValue(Resource::MIN_PRICE);
        }
    }
}