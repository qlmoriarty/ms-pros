<?php

namespace App\Constant;


class UniversalConstant
{
    const TRUE = 'true';
    const FALSE = 'false';

    const TITLE_YES = 'Yes';
    const TITLE_NO = 'No';

    protected static $active_list = [
        self::TRUE => self::TITLE_YES,
        self::FALSE => self::TITLE_NO
    ];

    /**
     * @return array
     */
    public static function getActiveList()
    {
        return self::$active_list;
    }


}