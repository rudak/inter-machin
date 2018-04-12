<?php

namespace AppBundle\Services\Command\User;

use UserBundle\Entity\User;
use AppBundle\Utils\AppConfig;
use AppBundle\Utils\Log\LogCreator;

class LuckMoney extends CronEmCommand implements CronCommandInterface
{

    public function execute()
    {
        foreach ($this->em->getRepository('UserBundle:User')->findAll() as $user) {
            if (!$user->getAlive() || mt_rand(0, 100) > AppConfig::LUCK_PERCENTAGE) {
                continue;
            }
            $this->updateUser($user);
        }
        $this->em->flush();
    }

    public function updateUser(User $user)
    {
        $amount = $this->getAmount($user);
        $user->addMoney($amount);
        $this->em->persist($user);
        $this->em->persist(LogCreator::getLog($user, true, sprintf($this->getRandReason(), $user->getUsername(), $amount), LogCreator::TYPE_LUCK));
    }

    private function getAmount(User $user)
    {
        return rand(1, 5) * $user->getCompetences()->getLevel();
    }

    private function getRandReason()
    {
        $reasons = [
            '[user] a trouvé [money]$ par terre.',
            '[user] a trouvé [money]$ à Leclerc',
            '[user] a trouvé [money]$ dans sa boite a gants',
            '[user] a trouvé [money]$ sur le bord d\'une la fenetre',
            '[user] a pris [money]$ a un enfant qui voulait acheter des bonbons.',
            '[user] a gagné [money]$ au PMU',
            '[user] a gagné [money]$ au poker',
            '[user] a gagné [money]$ au loto',
            '[user] a gagné [money]$ au tacotac',
            '[user] a gagné [money]$ au morpion',
            'Un passant donne [money]$ à [user]',
            'Un clodo donne [money]$ à [user]',
            'Un roumain donne [money]$ à [user]',
            'Un ami donne [money]$ à [user]',
            'Une femme donne [money]$ à [user]',
            'Un salafiste donne [money]$ à [user]',
            'Un clandestin donne [money]$ à [user]',
            'Le boulanger donne [money]$ à [user]',
            'Le patron de  [user] lui donne [money]$ pour son excelent travail',
            'Le meilleur ami de [user] lui file [money]$ pour le remercier de l\'écouter quand il va mal.',
            'Le voisin de [user] lui file [money]$ pour le remercier de l\'avoir ramené samedi soir.',
        ];
        return str_replace(['[user]', '[money]'], ['%1$s', '%2$d'], $reasons[array_rand($reasons)]);
    }


}