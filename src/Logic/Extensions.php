<?php


namespace App\Logic;


class Extensions {

    public static function unique_multidim_array($array) {
        return array_map("unserialize", array_unique(array_map("serialize", $array)));
    }
}