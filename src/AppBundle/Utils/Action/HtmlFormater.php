<?php

namespace AppBundle\Utils\Action;

use AppBundle\Entity\Action\Alive;
use AppBundle\Entity\Action\Attack;
use AppBundle\Entity\Action\CityMove;
use AppBundle\Entity\Action\Game;
use AppBundle\Entity\Action\Purchase;
use AppBundle\Entity\Action\Saving;
use AppBundle\Entity\Action\Steal;
use Symfony\Component\Templating\EngineInterface;
use UserBundle\Entity\User;

class HtmlFormater
{
    private $user;

    private $htmlElements = [];

    /**
     * @var TemplatingRendererEngine
     */
    private $twig;

    public function __construct(EngineInterface $twig)
    {
        $this->twig = $twig;
    }

    public function getHtmlForActions(User $user, array $actions)
    {
        $this->user = $user;
        foreach ($actions as $action) {
            $this->createActionHtmlElement($action);
        }
        return $this->getHtml();
    }

    /**
     * Renvoie le résultat en HTML
     * @return string
     */
    private function getHtml()
    {
        return implode('', $this->htmlElements);
    }

    private function createActionHtmlElement($action)
    {
        $this->htmlElements[] = $this->twig->render(
            $this->getPatternForAction($action), [
                'action' => $action,
            ]
        );
    }

    /**
     * Renvoie le pattern qui servira de modèle a l'affichage du log de l'action
     * @param $action
     * @return string
     */
    private function getPatternForAction($action)
    {
        if ($action instanceof CityMove) {
            return 'render/action/patterns/city-move.html.twig';
        }
        if ($action instanceof Game) {
            return 'render/action/patterns/game.html.twig';
        }
        if ($action instanceof Purchase) {
            return 'render/action/patterns/purchase.html.twig';
        }
        if ($action instanceof Steal) {
            return $this->getStealPattern($action);
        }
        if ($action instanceof Attack) {
            return $this->getAttackPattern($action);
        }
        if ($action instanceof Alive) {
            return 'render/action/patterns/alive.html.twig';
        }
        if ($action instanceof Saving) {
            return 'render/action/patterns/saving.html.twig';
        }
    }

    /**
     * Cas particulier : on peut etre le voleur ou le volé
     * @param Steal $action
     * @return string
     */
    private function getStealPattern(Steal $action)
    {
        if ($action->getVictim() == $this->user) {
            return 'render/action/patterns/steal-victim.html.twig';
        }
        return 'render/action/patterns/steal-burglar.html.twig';
    }

    /**
     * Cas particulier : on peut etre le voleur ou le volé
     * @param Steal $action
     * @return string
     */
    private function getAttackPattern(Attack $action)
    {
        if ($action->getVictim() == $this->user) {
            return 'render/action/patterns/attack-victim.html.twig';
        }
        return 'render/action/patterns/attack.html.twig';
    }
}