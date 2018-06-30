<?php


namespace App\Logic;


class Calculations {

    public static function generatePeriodFromDate(string $date): string
    {
        $date = new \DateTime($date);
        $year = $date->format('y');
        $weekNumber = $date->format('W') - 1;
        $dayNumber = $date->format("N");

        if($dayNumber > 5) {
            $weekNumber += 1;
        }

        return $year . $weekNumber;
    }

    public static function getLastSaturdayFromDate(string $date) : string
    {
        $dateTime = new \DateTime($date);
        $dayNumber = $dateTime->format("N");

        if ($dayNumber != 6)
        {
            return date('Y/m/d', strtotime('last Saturday', strtotime($date)));
        }

        return $date;

    }
}