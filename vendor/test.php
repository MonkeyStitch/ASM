<?php
/*
$arr = [
    [9, 12, 9, 6, 9, 10],
    [7, 3, 7, 7, 5, 5],
    [6,5,9,11,3,11],
    [6,8,11,2,2,10]
];

$demand = [4,4,6,2,4,2];
$supply = [5,6,2,9];
*/
$arr = [
    [3, 6, 6, 15],
    [9, 15, 6, 12],
    [12, 3, 9, 9],

];
$demand = [120, 60, 150, 90];
$supply = [150, 90, 180];

$row = count($arr);
$column = count($arr[0]);

include_once (__DIR__.'/auto_load.php');

echo '<pre>';
$process = new ProcessASM($row, $column, $demand, $supply, $arr);

$process->output();

exit;
$out = new OutputMyArrays();
$row = count($arr);
$column = count($arr[0]);
$out->show('input',$arr);

// block
$block = new BlockRCClass([],[]);
$DeAndSup = new DemandAndSupply($demand, $supply);
// min delete
$output = new MinDelete($arr, $block);
$md = $output->getOutput();
$out->show('delete',$md);

// find zero
$find = new FindZero($md, $block);

$out->show('position zero',$find->getPosition());
$out->show('position transpose zero ',$find->getPositionTranspose());
$out->show('count zero : row ',$find->count('row'));
$out->show('count zero : col ',$find->count('column'));


// sum zero
$sum = new SumZero($md, $find);
$sumZero = $sum->getSumOutput();
$out->show('sum zero : ',$sumZero);

// check sum zero
$checkSum = new CheckSumValue($sum, $find);



echo '<h4>is check</h4>';
if ($checkSum->isZeroValueMinMoreFirst()) {
    $positionMinZero = $checkSum->getPositionMinZero();
    $out->show('min value for more first : ', $positionMinZero);

    echo '<h4>ถ้ามากกว่า 1 ตัวทำในฟังชั่นนี้</h4>';

    // First Duplicate Value
    $firstDup = new FirstDuplicateValue($md, $find, $positionMinZero, $block);

    $out->show('sum without : row ',$firstDup->getSumWithOutZeroRowArr());
    $out->show('sum without : column ',$firstDup->getSumWithOutZeroColumnArr());

    $out->show('new value min  : sum without zero ',$firstDup->getsumWithOutZero());

    // is check sum without zero
    $checkSumWithOut = new CheckSumWithOut($firstDup->getValueArr());

    if ($checkSumWithOut->isMaxValue()) {
        // ไม่ซ้ำกันอีก
        echo '<h4>ไม่ซ้ำกันแล้ว</h4>';

        foreach ($positionMinZero as $value) {
            if ($md[$value['row']][$value['column']] === $checkSumWithOut->getMax()) {
                $positionMinZero = $value;
            }
        }
    } else {

        // ถ้าซ้ำกันอีก ให้กลับไปดูที่ค่ารับเข้าในแต่ละรอบ
        echo '<h4>ซ้ำกันแล้ว</h4>';
        $second = new SecondDuplicateValue($arr, $block);

        $second->findMinValue($positionMinZero);



        // ตรวจสอบว่าเหลือ 2 ค่าหรือไม่
        if ($block->isTwoValue($row, $column)) {
            echo '<h4>2x2</h4>';


            $positionMinZero = $DeAndSup->process($positionMinZero, $second->getMin());

        } else {
            // ตรวจสอบค่ารับเข้าในแต่ละรอบซ้ำกันหรือไม่

            $positionMinZero = $second->getPositionNotTwo($positionMinZero);
        }
    }


    // คือค่าเพื่อลบ supply กับ demand
    $select = new ProcessPositionSelect($positionMinZero, $DeAndSup, $block);
    $md = $select->process($md);


} else {
    echo '<h4># Not Duplicate Value</h4>';
    echo '[ '.$this->positionMinZero["row"]. ':'.$this->positionMinZero["column"].' ]';
    // ถ้ามีแค่ 1 ค่า ทำในนี้
    // คือค่าเพื่อลบ supply กับ demand
    $this->processPositionSelect();
}

