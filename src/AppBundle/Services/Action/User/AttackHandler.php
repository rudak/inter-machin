<?php

namespace AppBundle\Services\Action\User;

use AppBundle\Entity\Item;
use AppBundle\Services\Action\ActionMaster;
use AppBundle\Utils\AppConfig;
use AppBundle\Utils\User\UserItems;
use AppBundle\Utils\User\UserLevel;
use AppBundle\Utils\User\UserWeapon;
use UserBundle\Entity\User;

class AttackHandler extends ActionMaster
{


    public function execute(User $victim, User $attacker)
    {
        if (!$this->userCanAttack($victim, $attacker)) {
            return false;
        }
        $this->attackHim($victim, $attacker);
        $this->em->persist($victim);
        $this->em->persist($attacker);
        $this->em->flush();
    }

    private function userCanAttack(User $victim, User $attacker)
    {

        if ($victim->getCity() != $attacker->getCity()) {
            $this->session->getFlashBag()->add('warning', sprintf("Vous ne pouvez pas attaquer %s, il est dans %s !", $victim->getUsername(), $victim->getCity()->getName()));
            return false;
        }
        if (!$victim->getAlive()) {
            $this->session->getFlashBag()->add('warning', sprintf("Vous ne pouvez pas attaquer %s, il est déja mort !", $victim->getUsername()));
            return false;
        }
        if ($attacker->getAction() < AppConfig::ACTION_POINT_FOR_ATTACK) {
            $this->session->getFlashBag()->add('warning', sprintf(
                "Vous ne pouvez pas attaquer %s, vous n'avez que %dPA sur %d!",
                $victim->getUsername(),
                $attacker->getAction(),
                AppConfig::ACTION_POINT_FOR_ATTACK
            ))
            ;
            return false;
        }
        if (UserLevel::getLvl($attacker) > UserLevel::getLvl($victim)) {
            $this->session->getFlashBag()->add('warning', sprintf("Vous ne pouvez pas attaquer %s, votre niveau est trop élevé !", $victim->getUsername()));
            return false;
        }
        return true;
    }

    /**
     * Attaquer la victime !!
     * @param User $victim
     * @param User $attacker
     */
    private function attackHim(User $victim, User $attacker)
    {
        $userItems = UserItems::getActiveItemsNames($attacker);
        $damage    = $this->getDamages($victim, $attacker);
        $skillGain = rand(1, 4);
        $victim->getCompetences()->removeLifePoints($damage);
        $victim->getCompetences()->removeSkillPoints($skillGain);
        $attacker->getCompetences()->addSkillPoints($skillGain);
        $attacker->removeActionPoint(AppConfig::ACTION_POINT_FOR_ATTACK);
        #TODO: signaler qu'on perd une arme
        UserItems::updateItemsUses($attacker);
        if (!$victim->getAlive()) {
            $this->victimIsDead($victim, $attacker, $skillGain);
            return;
        }
        $this->session->getFlashBag()->add('success', sprintf(
            "Vous bastonnez %s avec %s et vous lui enlevez %s de vie ! Vous gagnez %s d'habileté.",
            $victim->getUsername(),
            $userItems,
            $this->getPointsText($damage),
            $this->getPointsText($skillGain)
        ))
        ;
    }

    private function victimIsDead(User $victim, User $attacker, $skillGain)
    {
        $victim->kill();
        $victimMoney = $victim->getMoney();
        $gainMoney   = round($victimMoney * 90 / 100);
        $victim->removeMoney($gainMoney);
        $attacker->addMoney($gainMoney);
        $attacker->getCompetences()->addSkillPoints($skillGain); // 2eme ajout
        $skillGain *= 2;

        $this->session->getFlashBag()->add('success', sprintf(
            "Vous tuez %s et vous lui prenez %d$ !!!! Vous gagnez %s d'habileté !",
            $victim->getUsername(),
            $gainMoney,
            $this->getPointsText($skillGain)
        ))
        ;
    }


    private function getDamages(User $victim, User $attacker)
    {
        $attackerItemsPoints = UserWeapon::getItemsAmountPointsForUser($attacker);
        $victimItemsPoints   = UserWeapon::getItemsAmountPointsForUser($victim);
        $damageMax           = $this->getDamageMax($attackerItemsPoints, $attacker);
        $defenseMax          = $this->getVictimsDefensePoints($victimItemsPoints, $victim);
        $damage              = $damageMax - $defenseMax;
        return $damage < UserLevel::getLvl($attacker) ? UserLevel::getLvl($attacker) : $damage;
    }

    private function getDamageMax($itemsPoints, User $attacker)
    {
        $attackPoints = ($itemsPoints[UserWeapon::ATTACK_POINTS] + $attacker->getCompetences()->getAttack()) / 2;
        return round(($attackPoints * AppConfig::MAX_LIFE_POINTS_PER_ATTACK) / 100);
    }

    private function getVictimsDefensePoints($itemsPoints, User $victim)
    {
        return ($itemsPoints[UserWeapon::DEFENSE_POINTS] + $victim->getCompetences()->getDefense()) / 2;
    }

}