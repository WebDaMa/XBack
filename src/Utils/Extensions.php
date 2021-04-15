<?php


namespace App\Utils;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Extensions {

    public static function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();
        foreach( $array as $val ) {
            if ( ! in_array( $val[$key], $key_array ) ) {
                $key_array[$i] = $val[$key];
                $temp_array[] = $val; // <--- remove the $i
            }
            $i++;
        }
        return $temp_array;
    }

    public static function getDynamicSheetAsArray(Worksheet $sheet)
    {
        $rows = [];
        foreach ($sheet->getRowIterator() AS $row)
        {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // This loops through all cells,
            $cells = [];
            foreach ($cellIterator as $cell)
            {
                $code = $cell->getValue();
                if (strstr($code, '=') == true)
                {
                    $code = $cell->getOldCalculatedValue();
                }
                $cells[] = $code;
            }
            $rows[] = $cells;
        }

        return $rows;
    }
}