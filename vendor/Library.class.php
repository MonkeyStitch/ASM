<?php


class Library
{


    public function __construct()
    {
    }

    public static function set($row, $column) {
        $arr = array();
        for ($i = 0; $i < $row; $i++) {
            for ($j = 0; $j < $column; $j++) {
                $arr[$i][$j] = 0;
            }
        }
        return $arr;
    }


}