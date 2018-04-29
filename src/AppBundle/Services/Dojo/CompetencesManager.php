<?php

namespace AppBundle\Services\Dojo;

use UserBundle\Entity\User;

class CompetencesManager extends CompetencesMaster
{
    public function execute(User $user, $competence)
    {
        switch ($competence) {
            case CompetencesMaster::ATTACK:
                $this->userCanPay($user, $user->getCompetences()->getAttack());
                $this->addAttack($user);
                break;
            case CompetencesMaster::DEFENSE:
                $this->userCanPay($user, $user->getCompetences()->getDefense());
                $this->addDefense($user);
                break;
            case CompetencesMaster::SKILL:
                $this->userCanPay($user, $user->getCompetences()->getSkill());
                $this->addSkill($user);
                break;
            default:
                $this->session->getFlashBag()->add('warning', "Cette compétence n'existe pas");
                return;
        }
        $this->persistUser($user);
        $this->session->getFlashBag()->add('success', "La compétence à été apprise");
    }

    private function userCanPay(User $user, $competenceValue)
    {
        if ($user->getMoney() < $this->getCompetencePrice($competenceValue)) {
            $this->session->getFlashBag()->add('warning', "Le prix pour apprendre cette compétence est trop élevé");
            return;
        }
    }

    private function addAttack(User $user)
    {
        $user->removeMoney($this->getCompetencePrice($user->getCompetences()->getAttack()));
        $user->getCompetences()->addAttackPoints(1);
    }

    private function addDefense(User $user)
    {
        $user->removeMoney($this->getCompetencePrice($user->getCompetences()->getDefense()));
        $user->getCompetences()->addDefensePoints(1);
    }

    private function addSkill(User $user)
    {
        $user->removeMoney($this->getCompetencePrice($user->getCompetences()->getSkill()));
        $user->getCompetences()->addSkillPoints(1);
    }
}