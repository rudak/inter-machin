<?php

namespace AppBundle\Services\Command;

use AppBundle\Utils\Log\LogCreator;
use Doctrine\ORM\EntityManagerInterface;
use UserBundle\Entity\User;

class LuckMoney
{
    const RECURRENCE_PERCENTAGE = 3;

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
            if (rand(0, 100) > self::RECURRENCE_PERCENTAGE) {
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
        $this->em->persist(LogCreator::getLog($user, true, sprintf($this->getRandReason(), $user->getUsername(), $amount), LogCreator::TYPE_LUCK));
        $this->em->flush();
    }

    private function getNewAmount(User $user)
    {
        return rand(1, 5) * $user->getCompetences()->getLevel();
    }

    private function getRandReason()
    {
        $reasons = [
            '[user] a trouvé [money] par terre.',
            '[user] a trouvé [money] à Leclerc',
            '[user] a trouvé [money] dans sa boite a gants',
            '[user] a trouvé [money] sur le bord d\'une la fenetre',
            '[user] a pris [money] a un enfant qui voulait acheter des bonbons.',
            '[user] a gagné [money] au PMU',
            '[user] a gagné [money] au poker',
            '[user] a gagné [money] au loto',
            '[user] a gagné [money] au tacotac',
            '[user] a gagné [money] au morpion',
            'Un passant donne [money] à [user]',
            'Un clodo donne [money] à [user]',
            'Un roumain donne [money] à [user]',
            'Un ami donne [money] à [user]',
            'Une femme donne [money] à [user]',
            'Un salafiste donne [money] à [user]',
            'Un clandestin donne [money] à [user]',
            'Le boulanger donne [money] à [user]',
            'Le patron de  [user] lui donne [money] pour son excelent travail',
            'Le meilleur ami de [user] lui file [money] pour le remercier de l\'écouter quand il va mal.',
            'Le voisin de [user] lui file [money] pour le remercier de l\'avoir ramené samedi soir.',
        ];
        return str_replace(['[user]', '[money]'], ['%1$s', '%2$d$'], $reasons[array_rand($reasons)]);
    }


}