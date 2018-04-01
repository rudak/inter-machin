<?php

namespace AppBundle\Services\Action;

use AppBundle\Entity\Action\Steal;
use AppBundle\Utils\Log\LogCreator;
use UserBundle\Entity\User;

class StealHandler
{

    const INDEX_ENTITY      = 'entity';
    const INDEX_MESSAGE     = 'message';
    const INDEX_LOG_VICTIM  = 'log-victim';
    const INDEX_LOG_BURGLAR = 'log-burglar';

    private $message;

    public function execute(User $victim, User $burglar)
    {
        $steal = new Steal($victim, $burglar);

        if (
            $this->checkLevel($victim, $burglar) &&
            $this->checkSkills($victim, $burglar)
        ) {
            $steal->setStatus(Steal::STATUS_SUCCESSFULL);
            $steal->setBurglarSkill($this->getBurglarSkill());
            $steal->setBurglarDamage($this->getBurglarDamage());
            $steal->setVictimDamage($this->getVictimDamage($steal));
            $steal->setLoot($this->getLootAmount($steal));
        }
        $this->updateMessage($steal);
        $this->updateProtagonists($steal);

        return [
            self::INDEX_MESSAGE     => $this->message,
            self::INDEX_ENTITY      => $steal,
            self::INDEX_LOG_VICTIM  => $this->createLogVictim($steal),
            self::INDEX_LOG_BURGLAR => $this->createLogBurglar($steal),
        ];
    }


    /**
     * Mise a jour des entités User
     *
     * @param Steal $steal
     */
    private function updateProtagonists(Steal $steal)
    {
        // argent
        $steal->getVictim()->removeMoney($steal->getLoot());
        $steal->getBurglar()->addMoney($steal->getLoot());
        // dommages
        $steal->getVictim()->getCompetences()->removePowerPoints($steal->getVictimDamage());
        $steal->getBurglar()->getCompetences()->removePowerPoints($steal->getBurglarDamage());
        // habileté
        $steal->getVictim()->getCompetences()->addSkillPoints($steal->getBurglarSkill());
        $steal->getBurglar()->getCompetences()->addSkillPoints($steal->getBurglarSkill() * 2);
    }

    private function createLogVictim(Steal $steal)
    {
        if (!$steal->getLoot()) {
            return LogCreator::getLog($steal->getVictim(), false, "Quelqu'un a essayé de vous voler, raté...", LogCreator::TYPE_STEAL);
        }
        return LogCreator::getLog($steal->getVictim(), false, sprintf("Vous venez de vous faire voler %d$.", $steal->getLoot()), LogCreator::TYPE_STEAL);
    }

    private function createLogBurglar(Steal $steal)
    {
        if (!$steal->getLoot()) {
            return LogCreator::getLog($steal->getBurglar(), false, sprintf("Vous ratez le vol de %s.", $steal->getVictim()->getUsername()), LogCreator::TYPE_STEAL);
        }
        return LogCreator::getLog($steal->getBurglar(), false, sprintf("Vous volez %d$ à %s.", $steal->getLoot(), $steal->getVictim()->getUsername()), LogCreator::TYPE_STEAL);
    }

    /**
     * Renvoi le montant volé.
     *
     * @param Steal $steal
     * @return int
     */
    private function getLootAmount(Steal $steal)
    {
        $amount = $steal->getBurglarSkill() * $steal->getVictimDamage() - $steal->getBurglarDamage();
        return $amount > $steal->getVictim()->getMoney() ? $steal->getVictim()->getMoney() : $amount;
    }

    private function getBurglarDamage()
    {
        return rand(1, 5);
    }

    private function getVictimDamage()
    {
        return rand(0, 5);
    }

    /**
     * Si la victime a plus de dégats que le voleur, le voleur prend des skills
     *
     * @param Steal $steal
     * @return int
     */
    private function getBurglarSkill(Steal $steal)
    {
        $skillDiff = $steal->getVictimDamage() - $steal->getBurglarDamage();
        return $skillDiff > 0 ? $skillDiff : 0;
    }

    /**
     * On verifie que la victime soit au niveau egal ou superieur
     *
     * @param User $victim
     * @param User $burglar
     * @return bool
     */
    private function checkLevel(User $victim, User $burglar)
    {
        $checkLevel = $victim->getCompetences()->getLevel() >= $burglar->getCompetences()->getLevel();
        if (!$checkLevel) {
            $this->message = sprintf("Vous ne pouvez pas voler %s, son niveau est trop faible.", $victim->getUsername());
        }
        return $checkLevel;
    }

    /**
     * Verifie si l'habileté du voleur est supérieure a celle de la victime
     *
     * @param User $victim
     * @param User $burglar
     * @return bool
     */
    private function checkSkills(User $victim, User $burglar)
    {
        $victimSkillTotal  = $victim->getCompetences()->getSkill() * $victim->getCompetences()->getLevel();
        $burglarSkillTotal = $burglar->getCompetences()->getSkill() * $burglar->getCompetences()->getLevel();

        $checkSkill = $victimSkillTotal < $burglarSkillTotal;
        if (!$checkSkill) {
            $this->message = sprintf("Votre habileté est inférieure à celle de %s, c'est un échec.", $victim->getUsername());
        }
        return $checkSkill;
    }

    private function updateMessage(Steal $steal)
    {
        $msg = [];
        if ($steal->getLoot() > 0) {
            $msg[] .= sprintf("Vous volez %d$ à %s", $steal->getLoot(), $steal->getVictim()->getUsername());
        }
        if ($steal->getBurglarSkill() > 0) {
            $msg[] .= sprintf("vous gagnez %d pts d'habilité", $steal->getBurglarSkill());
        }
        if ($steal->getBurglarDamage() > 0) {
            $msg[] .= sprintf("vous perdez %d pts de power", $steal->getBurglarSkill());
        }
        $this->message .= implode(', ', $msg) . '.';
    }


}