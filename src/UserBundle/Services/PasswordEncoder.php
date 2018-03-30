<?php

namespace UserBundle\Services;

use UserBundle\Entity\User;

class PasswordEncoder
{
    private $encoder;

    /**
     * PasswordEncoder constructor.
     * @param $encoder
     */
    public function __construct($encoder)
    {
        $this->encoder = $encoder;
    }


    public function getEncodedPassword(User $user)
    {
        return $this->encoder->encodePassword($user, $user->getPassword());
    }

    public function encodePasswordForUser(User $user)
    {
        $user->setPassword(self::getEncodedPassword($user));
    }


}