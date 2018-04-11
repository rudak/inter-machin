<?php

namespace AppBundle\Repository\Action;

/**
 * GameRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GameRepository extends \Doctrine\ORM\EntityRepository
{

    public function getGameInfos($game)
    {
        $qb = $this->createQueryBuilder('g')
                   ->select('SUM(g.status) as total_win,COUNT(g.id) as total')
                   ->where('g.game = :game')
                   ->setParameters([
                       'game' => $game,
                   ])
                   ->getQuery()
        ;
        return $qb->execute();
    }
}