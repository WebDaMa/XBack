<?php


namespace App\Logic;

use PhpOffice\PhpSpreadsheet\Shared\Date;

class Calculations {

    public static function generatePeriodFromDate(string $date): string
    {
        $date = new \DateTime($date);
        $year = $date->format('y');
        $weekNumber = $date->format('W');
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

    public static function getLastFridayFromDate(string $date) : string
    {
        $dateTime = new \DateTime($date);
        $dayNumber = $dateTime->format("N");

        if ($dayNumber != 5)
        {
            return date('Y/m/d', strtotime('last Friday', strtotime($date)));
        }

        return $date;

    }

    public static function getNextSaturdayFromDate(string $date) : string
    {
        return date('Y/m/d', strtotime('next Saturday', strtotime($date)));
    }

    public static function getNextSundayFromDate(string $date) : string
    {
        return date('Y/m/d', strtotime('next Sunday', strtotime($date)));
    }

    public static function getDateOrNull($date, $format = 'j/n/Y')
    {
        $date = \DateTime::createFromFormat($format, $date);

        return $date ? $date : null;
    }

    public static function convertExcelDateToDateTime($dateValue)
    {
        return Date::excelToDateTimeObject($dateValue, new \DateTimeZone('Europe/Amsterdam'));
    }

    public static function getStringBool($value)
    {
        if (is_string($value))
        {
            $value = strtolower($value);

            return $value === 'true';
        } else
        {
            return $value;
        }

    }
}