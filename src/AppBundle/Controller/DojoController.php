<?php

namespace AppBundle\Controller;

use AppBundle\Services\Dojo\Attack;
use AppBundle\Services\Dojo\CompetencesManager;
use AppBundle\Services\Dojo\CompetencesMaster;
use AppBundle\Services\Dojo\Defense;
use AppBundle\Services\Dojo\ManageCompetences;
use AppBundle\Services\Dojo\Skill;
use AppBundle\Utils\Dojo\Helper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DojoController extends Controller
{
    public function dojoIndexAction()
    {
        $priceAttack  = Helper::getAttackPrice($this->getUser());
        $priceDefense = Helper::getDefensePrice($this->getUser());
        $priceSkill   = Helper::getSkillPrice($this->getUser());
        return $this->render(':dojo:dojo.html.twig', [
            'priceAttack'  => $priceAttack,
            'priceDefense' => $priceDefense,
            'priceSkill'   => $priceSkill,
        ]);
    }

    public function dojoAddAttackAction()
    {
        $this->get(CompetencesManager::class)->execute($this->getUser(), CompetencesMaster::ATTACK);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('dojo_index');
    }

    public function dojoAddDefenseAction()
    {
        $this->get(CompetencesManager::class)->execute($this->getUser(), CompetencesMaster::DEFENSE);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('dojo_index');
    }

    public function dojoAddSkillAction()
    {
        $this->get(CompetencesManager::class)->execute($this->getUser(), CompetencesMaster::SKILL);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('dojo_index');
    }
}