<?php

namespace AppBundle\Utils;

class AppConfig
{
    const BANKER_VALIDATION_PERCENTAGE = 20;
    const BANKER_MIN_INTERESTS         = 1;
    const LOAN_MAX_PERCENTAGE          = 15;
    const MAX_ACTIVE_LOANS_ALLOWED     = 3;
    const LUCK_PERCENTAGE              = 1;
    const LUCK_PA_PERCENTAGE           = 5;
    const NO_LUCK_PERCENTAGE           = 3;
    const USER_MAX_ACTION_POINT        = 24;
    const USER_DEFAULT_ACTION_POINT    = 3;
    const MAX_STEAL_BASE_VALUE         = 20;
    const ACTION_POINTS_FOR_STEAL      = 2;
    const ACTION_POINT_FOR_ATTACK      = 8;
    const MAX_LIFE_POINTS_PER_ATTACK   = 100;
    const COEF_BUY_COMPETENCES   = 100;
}