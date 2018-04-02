<?php

namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    private $now;

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('duration', [$this, 'duration']),
        ];
    }

    /**
     * Renvoie la période entre aujourd'hui et la date passée en parametre (sortie en nb de jours).
     *
     * @param \DateTime $datetime
     * @return string
     */
    public function duration(\DateTime $datetime)
    {
        return $this->getNow()->diff($datetime)->format('%a');
    }

    private function getNow()
    {
        if (null == $this->now) {
            $this->now = new \DateTime('NOW');
        }
        return $this->now;
    }

}