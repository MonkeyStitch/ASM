<?php
echo '<pre>';

$arr = array(
    1 => array(0 => 11, 1 => 15),
    2 => array(0 => 30, 1 => 48),
    3 => array(0 => 35, 1 => 35),
);

/*
print_r($arr);


function plus_array($a1, $a2)
{
    return $a1 + $a2;
}

echo 'result<br>';

$result = array_map('plus_array', $arr[1], $arr[2]);

print_r($result);


$func = function($value, $val2, $val3) {
    echo $value . ' ' . $val2 . ' '. $val3. '<br>';

    return $value[0] * 2;
};

print_r(array_map($func, $arr[1], $arr[2], $arr[3]));

//print_r(range(1, 5));
*/
$row = 3;
$col = 2;

$array[0] = 0;
$array[2] = 0;
$array[4] = 0;
$array[6] = 0;

var_dump(isset($arr));
print_r($array);

function val($value) {
    return  array_sum($value) ;
}

print_r(array_map('val', $arr));