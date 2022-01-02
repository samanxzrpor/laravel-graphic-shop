<?php
namespace App\Utilities;

// use sallar\jdatetime\jDateTime;

class Language 
{

    public static function numberToPersion( $number)
    {
        $en = ['1','2','3','4','5','6','7','8','9','0'];

        $fa = ['‍۱','۲','۳','۴','۵','۶','۷','۸','۹','۰'];

        return str_replace($en , $fa , $number);
    }

    // public static function persionDate(string $time)
    // {
    //     $date = new jDateTime(true, true, 'Asia/Tehran');

    //     return $date->date(" j F Y", $time);
    // }

}