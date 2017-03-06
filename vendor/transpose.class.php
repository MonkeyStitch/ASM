<?php


class Transpose
{


    public function __construct()
    {

    }


    public static function transpose($arr){
        return array_map(null, ...$arr);
    }

}