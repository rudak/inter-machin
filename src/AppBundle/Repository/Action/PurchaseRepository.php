<?php

namespace AppBundle\Repository\Action;

use UserBundle\Entity\User;

/**
 * PurchaseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PurchaseRepository extends \Doctrine\ORM\EntityRepository implements ActionRepositoryInterface
{
    public function getPurchases()
    {
        $qb = $this->createQueryBuilder('p')
                   ->addSelect('u,w')
                   ->leftJoin('p.user', 'u')
                   ->leftJoin('p.weapon', 'w')
                   ->orderBy('p.id', 'DESC')
                   ->getQuery()
        ;
        return $qb->execute();
    }

    public function getCountPurchasesByWeapon()
    {
        $qb = $this->createQueryBuilder('p')
                   ->addSelect('u,w')
                   ->select('COUNT(1) as nb_achat,w.id')
                   ->leftJoin('p.user', 'u')
                   ->leftJoin('p.weapon', 'w')
                   ->groupBy('w.id')
                   ->getQuery()
        ;

        return $qb->execute();
    }

    public function getByUser(User $user, \DateTime $date)
    {
        $qb = $this->createQueryBuilder('p')
                   ->addSelect('u,w')
                   ->leftJoin('p.user', 'u')
                   ->leftJoin('p.weapon', 'w')
                   ->where('p.user = :user')
                   ->andWhere('p.date > :date')
                   ->setParameters([
                       'user' => $user,
                       'date' => $date,
                   ])
                   ->getQuery()
        ;
        return $qb->execute();
    }
}
