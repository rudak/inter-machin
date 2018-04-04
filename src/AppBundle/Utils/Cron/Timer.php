<?php

namespace AppBundle\Utils\Cron;

class Timer
{
    const PATTERN_ALL_MINUTES = '* * * * *';
    const PATTERN_ALL_HOURS   = '0 * * * *';
    const PATTERN_ALL_DAYS    = '0 4 * * *';
    const FORMAT_MINUTE       = 'i';
    const FORMAT_HOUR         = 'H';
    const FORMAT_DAY_OF_MONTH = 'j';
    const FORMAT_MONTH        = 'n';
    const FORMAT_DAY_OF_WEEK  = 'w';

    /**
     * Vérifie si une chaine type crontab correspond a l'heure actuelle.
     * Renvoie false si la chaine est foirée ou si on est pas dans le timming demandé dans la chaine
     * TODO: Prendre en charge les slashes, eventuellement
     *
     * @param $cronTime
     * @return bool
     */
    public static function isTimeToRun($cronTime)
    {
        $now = new \DateTime('NOW');
        if (!preg_match('/^((?:[1-9]?\d|\*)\s*(?:(?:[\/-][1-9]?\d)|(?:,[1-9]?\d)+)?\s*){5}$/', $cronTime)) {
            echo sprintf("La chaine de cron '%s' est foirée", $cronTime);
            return false;
        }
        return self::checkCronTime($cronTime, $now);
    }

    private static function checkCronTime($cronTime, $now)
    {
        list($minute, $hour, $dayOfMonth, $month, $dayOfWeek) = explode(' ', $cronTime);

        return self::checkMinute($minute, $now) &&
            self::checkHour($hour, $now) &&
            self::checkDayOfMonth($dayOfMonth, $now) &&
            self::checkMonth($month, $now) &&
            self::checkDayOfWeek($dayOfWeek, $now);
    }

    private static function checkMinute($minute, $now)
    {
        if ($minute == '*' || $minute == $now->format(self::FORMAT_MINUTE)) {
            return true;
        }
        return false;
    }

    private static function checkHour($hour, $now)
    {
        if ($hour == '*' || $hour == $now->format(self::FORMAT_HOUR)) {
            return true;
        }
        return false;
    }

    private static function checkDayOfMonth($dayOfMonth, $now)
    {
        if ($dayOfMonth == '*' || $dayOfMonth == $now->format(self::FORMAT_DAY_OF_MONTH)) {
            return true;
        }
        return false;
    }

    private static function checkMonth($month, $now)
    {
        if ($month == '*' || $month == $now->format(self::FORMAT_MONTH)) {
            return true;
        }
        return false;
    }

    private static function checkDayOfWeek($dayOfWeek, $now)
    {
        if ($dayOfWeek == '*' || $dayOfWeek == $now->format(self::FORMAT_DAY_OF_WEEK)) {
            return true;
        }
        return false;
    }

}