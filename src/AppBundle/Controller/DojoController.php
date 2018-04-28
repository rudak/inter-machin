<?php

namespace AppBundle\Controller;

use AppBundle\Services\Dojo\Attack;
use AppBundle\Services\Dojo\ManageCompetences;
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
        $this->get(Attack::class)->execute($this->getUser());
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('dojo_index');
    }

    public function dojoAddDefenseAction()
    {
        ManageCompetences::addDefenseToUser($this->getUser());
        return $this->redirectToRoute('dojo_index');
    }

    public function dojoAddSkillAction()
    {
        ManageCompetences::addSkillToUser($this->getUser());
        return $this->redirectToRoute('dojo_index');
    }
}