<?php

namespace Console\controllers;


class ValidateInput
{
    /**
     * @param string $startDateString
     * @return bool
     */
    public static function isValidStartDateString($startDateString)
    {
        if (empty($startDateString) || $startDateString === null) {
            return true;
        }

        return preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $startDateString, $m)
            ? checkdate(intval($m[2]), intval($m[3]), intval($m[1]))
            : false;

    }
}
