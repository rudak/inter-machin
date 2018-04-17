<?php

namespace AppBundle\Utils\Action;

use AppBundle\Entity\Action\ActionInterface;
use AppBundle\Entity\Action\CityMove;
use AppBundle\Entity\Action\Game;
use AppBundle\Entity\Action\Purchase;
use AppBundle\Entity\Action\Steal;
use AppBundle\Utils\UtilsMaster;
use UserBundle\Entity\User;

class ActionHandler extends UtilsMaster
{
    /**
     * Renvoie les actions par ordre décroissant
     *
     * @param User      $user
     * @param \DateTime $date
     * @return array
     */
    public function getActions(User $user, \DateTime $date)
    {
        $actionEntities = $this->getActionsCollections($user, $date);
        usort($actionEntities, [$this, 'dateComparison']);
        return $actionEntities;
    }

    /**
     * Renvoie la liste des actions a renvoyer dans les 'logs'
     * @return array
     */
    private function getActionsEntities()
    {
        return [
            CityMove::class,
            Game::class,
            Purchase::class,
            Steal::class,
        ];
    }

    /**
     * Renvoie la liste des 'entités actions' pèle mèle
     * @param User $user
     * @return array
     */
    private function getActionsCollections(User $user, \DateTime $date)
    {
        $raw = [];
        foreach ($this->getActionsEntities() as $entity) {
            $raw = array_merge($this->em->getRepository($entity)->getByUser($user, $date), $raw);
        }
        return $raw;
    }

    /**
     * Fonction qui permet d'utiliser USORT et de trier les actions par date DESC
     * @param $a
     * @param $b
     * @return bool
     */
    public function dateComparison($a, $b)
    {
        /**
         * @var $a ActionInterface
         * @var $b ActionInterface
         */
        return $a->getDate() < $b->getDate();
    }
}