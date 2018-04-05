<?php

namespace UserBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{


    public function getBestUsers()
    {
        $qb = $this->createQueryBuilder('u')
                   ->leftJoin('u.competences', 'c')
                   ->orderBy('c.level', 'DESC')
                   ->addOrderBy('c.life', 'DESC')
                   ->addOrderBy('u.money', 'DESC')
                   ->setMaxResults(3)
                   ->getQuery()
        ;
        return $qb->execute();
    }

    // **  ADMIN  **

    public function getAllUsersForAdmin()
    {
        $qb = $this->createQueryBuilder('u')
                   ->addSelect('c,i')
                   ->leftJoin('u.competences', 'c')
                   ->leftJoin('u.items', 'i')
                   ->orderBy('u.username', 'ASC')
                   ->getQuery()
        ;
        return $qb->execute();
    }
}
