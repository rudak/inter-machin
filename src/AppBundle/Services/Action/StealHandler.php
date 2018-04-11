<?php

namespace AppBundle\Services\Action;

use AppBundle\Entity\Action\Steal;
use AppBundle\Utils\AppConfig;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UserBundle\Entity\User;

class StealHandler
{
    protected $em;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @param $em
     */
    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->em      = $em;
        $this->session = $session;
    }

    public function execute(User $victim, User $burglar)
    {
        if (!$this->burglarCanSteal($victim, $burglar)) {
            return false;
        }
        $this->stealHim($victim, $burglar);
        $this->em->persist($victim, $burglar);
        $this->em->flush();
        return;
    }

    private function burglarCanSteal(User $victim, User $burglar)
    {
        if ($burglar->getAction() < AppConfig::ACTION_POINTS_FOR_STEAL) {
            $this->session->getFlashBag()->add('warning', sprintf("Impossible de voler %s, vous n'avez pas assez de PA_COST!", $victim->getUsername()));
            return false;
        }
        if (!$victim->getAlive()) {
            $this->session->getFlashBag()->add('warning', sprintf("Impossible de voler %s, il est mort!", $victim->getUsername()));
            return false;
        }
        if (!$victim->getMoney()) {
            $this->session->getFlashBag()->add('warning', sprintf("Impossible de voler %s, il est fauché! ...Frappez le plutot ^^", $victim->getUsername()));
            return false;
        }
        if ($victim->getCompetences()->getSkill() > $burglar->getCompetences()->getSkill()) {
            $this->session->getFlashBag()->add('warning', sprintf("Impossible de voler %s, il est plus habile que vous!", $victim->getUsername()));
            return false;
        }
        return true;
    }

    private function stealHim(User $victim, User $burglar)
    {
        $amountToSteal = mt_rand(1, $this->maxCanSteal($victim));
        $this->em->persist($stealAction = $this->getStealAction($victim, $burglar, $amountToSteal));
        $this->updateUsersWithSteal($victim, $burglar, $stealAction);
    }

    private function updateUsersWithSteal(User $victim, User $burglar, Steal $steal)
    {
        $victim->removeMoney($steal->getLoot());
        $victim->getCompetences()->removeLifePoints($steal->getVictimDamage());
        $burglar->addMoney($steal->getLoot());
        $burglar->removeActionPoint(AppConfig::ACTION_POINTS_FOR_STEAL);
        $burglar->getCompetences()->addSkillPoints($steal->getBurglarSkill());
        $burglar->getCompetences()->removeLifePoints($steal->getBurglarDamage());
    }

    private function getStealAction(User $victim, User $burglar, $amount)
    {
        $steal = new Steal($victim, $burglar);
        $steal->setLoot($amount);
        $steal->setStatus(Steal::STATUS_SUCCESSFULL);
        $steal->setBurglarDamage(mt_rand(0, 5));
        $steal->setVictimDamage(mt_rand(0, 5));
        $steal->setBurglarSkill(rand(1, 3));
        return $steal;
    }

    private function maxCanSteal(User $victim)
    {
        $theoreticalMax = AppConfig::MAX_STEAL_BASE_VALUE * $victim->getCompetences()->getLevel();
        return $theoreticalMax > $victim->getMoney() ? $victim->getMoney() : $theoreticalMax;
    }
}