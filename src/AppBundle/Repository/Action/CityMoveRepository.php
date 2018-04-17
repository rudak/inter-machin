<?php

namespace AppBundle\Repository\Action;

use UserBundle\Entity\User;

/**
 * CityMoveRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CityMoveRepository extends \Doctrine\ORM\EntityRepository implements ActionRepositoryInterface
{
    public function getByUser(User $user, \DateTime $date)
    {
        $qb = $this->createQueryBuilder('c')
                   ->where('c.user = :user')
                   ->andWhere('c.date > :date')
                   ->setParameters([
                       'user' => $user,
                       'date' => $date,
                   ])
                   ->getQuery()
        ;
        return $qb->execute();
    }
}
