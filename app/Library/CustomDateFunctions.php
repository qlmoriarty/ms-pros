<?php
/**
 * Created by PhpStorm.
 * User: dex
 * Date: 06.11.2016
 * Time: 12:38
 */

namespace App\Library;


class CustomDateFunctions
{
    public function getMyDate($date)
    {
        $newDate = date("Y-m-d H:i:s ",strtotime($d->DateAdd));
        return $newDate;
    }
//    public function getDate()
//    {
//        return ['SDF'];
//    }


}