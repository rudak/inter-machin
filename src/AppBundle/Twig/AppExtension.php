<?php

namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('duration', [$this, 'duration']),
        ];
    }

    public function duration(\DateTime $datetime)
    {
        $now = new \DateTime('NOW');
        $interval = $now->diff($datetime);
        return $interval->format('%a');
    }
}