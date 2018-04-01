<?php
namespace AppBundle\Services\Command;

use UserBundle\Entity\User;

interface CronCommandInterface
{
    public function execute();

    public function updateUser(User $user);
}