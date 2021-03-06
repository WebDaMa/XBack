<?php


namespace App\Utils;

use PhpOffice\PhpSpreadsheet\Shared\Date;

class Calculations {

    public static function generatePeriodFromDate(string $date): string
    {
        $date = new \DateTime($date);
        $year = $date->format('y');
        $weekNumber = $date->format('W');
        $dayNumber = $date->format('N');

        if($dayNumber > 5) {
            $weekNumber += 1;
        }

        return $year . $weekNumber;
    }

    public static function getCurrentPeriodId(): string
    {
        $date = date('Y-m-d H:i:s');

        return self::generatePeriodFromDate($date);
    }

    public static function getLastSaturdayFromDate(string $date) : string
    {
        $dateTime = new \DateTime($date);
        $dayNumber = $dateTime->format('N');

        if ($dayNumber != 6)
        {
            return date('Y/m/d', strtotime('last Saturday', strtotime($date)));
        }

        return $date;

    }

    public static function getLastFridayFromDate(string $date) : string
    {
        $dateTime = new \DateTime($date);
        $dayNumber = $dateTime->format('N');

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

    public static function getWednesdayThisWeekFromDate(string $date) : string
    {
        $dateTime = new \DateTime($date);
        $dayNumber = $dateTime->format('N');
        $format = 'Y-m-d';

        if ($dayNumber == 3)
        {
            return date($format, strtotime($date));
        } elseif ($dayNumber < 3) {
            return date($format, strtotime('next Wednesday', strtotime($date)));
        } elseif ($dayNumber > 3) {
            return date($format, strtotime('last Wednesday', strtotime($date)));
        }
    }

    public static function getDateOrNull($date, $format = 'j/n/Y')
    {
        $date = \DateTime::createFromFormat($format, $date);

        return $date ? $date : null;
    }

    public static function convertExcelDateToDateTime($dateValue)
    {
        if ($dateValue < 1.0) {
            return null;
        }
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

    public static function nullToBooleanFalse($var)
    {
        if (is_null($var))
        {
            $var = false;
        }
        return (boolean) $var;
    }
}