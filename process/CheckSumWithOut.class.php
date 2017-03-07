<?php


class CheckSumWithOut
{
    private $maxValue;
    private $value;


    public function __construct($value)
    {
        $this->value = $value;
        $this->maxValue = @max($value); // max sum value without zero
    }



    public function isMaxValue() {
        return array_count_values($this->value)[$this->maxValue] === 1;
    }


    public function getMax() {
        return $this->maxValue;
    }
}