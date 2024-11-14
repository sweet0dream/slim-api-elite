<?php

namespace App\Helper;

use DateTimeInterface;

class CommonHelper
{
    public static function formatDate(string $date): string
    {
        $termMonth = [
            '01' => 'января',
            '02' => 'февраля',
            '03' => 'марта',
            '04' => 'апреля',
            '05' => 'мая',
            '06' => 'июня',
            '07' => 'июля',
            '08' => 'августа',
            '09' => 'сентября',
            '10' => 'октября',
            '11' => 'ноября',
            '12' => 'декабря'
        ];

        $dateDay = explode(' ', $date)[0];
        $timeDay = explode(':', explode(' ', $date)[1])[0].':'.explode(':', explode(' ', $date)[1])[1];

        $day = explode('-', $dateDay)[2];
        $month = explode('-', $dateDay)[1];
        $year = explode('-', $dateDay)[0];

        $result = ltrim($day, 0).' '.$termMonth[$month];

        if (date('d') == $day && date('m') == $month && date('Y') == $year) {
            $result = 'сегодня';
        }
        if (date('d',time()-86400) == $day && date('m') == $month && date('Y') == $year) {
            $result = 'вчера';
        }

        if (date('Y') != $year) {
            $result .= ' '.$year.' года';
        }

        $result .= ' в '.$timeDay;

        return $result;
    }
}