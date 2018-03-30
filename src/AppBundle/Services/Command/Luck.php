<?php

namespace AppBundle\Services\Command;

use AppBundle\Entity\Log;
use AppBundle\Utils\Log\LogCreator;
use Doctrine\ORM\EntityManagerInterface;
use UserBundle\Entity\User;

class Luck
{
    private $em;

    /**
     * Luck constructor.
     * @param $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function updateMoney()
    {
        $users = $this->em->getRepository('UserBundle:User')->findAll();

        foreach ($users as $user) {
            if ('admin' == $user->getUsername()) {
                continue;
            }
            if (rand(0, 100) > 10) {
                continue;
            }
            if (!$user->getAlive() && $user->getMoney() >= 20) {
                continue;
            }
            $this->updateUserWallet($user);
        }
    }

    private function updateUserWallet(User $user)
    {
        $amount = $this->getNewAmount($user);
        $user->setMoney($user->getMoney() + $amount);
        $this->em->persist($user);
        $this->addLog($user, $amount);
        $this->em->flush();

    }

    private function getNewAmount(User $user)
    {
        return rand(1, 5) * $user->getCompetences()->getLevel();

    }

    private function addLog(User $user, $amount)
    {
        $this->em->persist(LogCreator::getLog($user, true, sprintf($this->getRandReason(), $user->getUsername(), $amount), LogCreator::TYPE_LUCK));
    }

    private function getRandReason()
    {
        $reasons = [
            '%1$s a trouvé %2$d$ par terre.',
            '%1$s a trouvé %2$d$ à Leclerc',
            '%1$s a trouvé %2$d$ dans sa boite a gants',
            '%1$s a trouvé %2$d$ sur le bord d\'une la fenetre',
            '%1$s a pris %2$d$ a un enfant qui voulait acheter des bonbons.',
            '%1$s a gagné %2$d$ au PMU',
            '%1$s a gagné %2$d$ au poker',
            '%1$s a gagné %2$d$ au loto',
            '%1$s a gagné %2$d$ au tacotac',
            '%1$s a gagné %2$d$ au morpion',
            'Un passant donne %2$d$ à %1$s',
            'Un clodo donne %2$d$ à %1$s',
            'Un roumain donne %2$d$ à %1$s',
            'Un ami donne %2$d$ à %1$s',
            'Une femme donne %2$d$ à %1$s',
            'Un salafiste donne %2$d$ à %1$s',
            'Un clandestin donne %2$d$ à %1$s',
            'Le boulanger donne %2$d$ à %1$s',
            'Le patron de  %1$s lui donne %2$d$ pour son excelent travail',
            'Le meilleur ami de %1$s lui file %2$d$ pour le remercier de l\écouter quand il va mal.',
            'Le voisin de %1$s lui file %2$d$ pour le remercier de l\'avoir ramené samedi soir.',
        ];
        return $reasons[array_rand($reasons)];
    }


}