<?php


class Library
{


    public function __construct()
    {
    }

    public static function set($row, $column = null) {
        $arr = array();
        for ($i = 0; $i < $row; $i++) {

            if ($column === null) {
                $arr[$i] = 0;
            } else {
                for ($j = 0; $j < $column; $j++) {
                    $arr[$i][$j] = 0;
                }
            }

        }
        return $arr;
    }


    public static function processSubArr($arr, BlockRCClass $blockRCClass)
    {
        $process = [];
        foreach ($arr as $item => $value) {

            if (!in_array($item, $blockRCClass->getRowBlock(), true)) {
                $process[$item] = [];
                foreach ($value as $item2 => $value2) {
                    if (!in_array($item2, $blockRCClass->getColumnBlock(), true)) {
                        $process[$item][$item2] = $value2;
                    }
                }
            }
        }
        return $process;
    }

}