<?php
include_once (__DIR__ . '/OutputMyArrays.php');
class Process2
{

    private $show;
    private $row = 0;
    private $column = 0;

    private $demand = [];
    private $supply = [];

    private $inputDS = [];
    private $minDS = [];
    private $outputDS = [];
    private $output = [];

    private $positionZero = [];
    private $positionZeroTranspose = [];
    private $countZeroRow = 0;
    private $countZeroColumn = 0;

    private $zeroValueArray = [];

    private $positionMinZero = []; // row => 0, column => 0

    private $doNotThinkRow = []; // 1,3
    private $doNotThinkColumn = [];

    /**
     * Process constructor.
     * @param int $row
     * @param int $column
     * @param array $demand
     * @param array $supply
     * @param array $inputDS
     */
    public function __construct($row, $column, array $demand, array $supply, array $inputDS)
    {
        $this->row = $row;
        $this->column = $column;
        $this->demand = $demand;
        $this->supply = $supply;
        $this->inputDS = $inputDS;
        $this->minDS = $inputDS;
        $this->outputDS = $inputDS;

        for ($i = 0; $i < $row; $i++) {
            for ($j = 0; $j < $column; $j++) {
                $this->output[$i][$j] = 0;
            }
        }

        $this->show = new OutputMyArrays();
    }

    public static function transpose($arr){
        return array_map(null, ...$arr);
    }

    public function output() {

//        while (!$this->isDemandOrSupplyEqualZero()) {
        for ($i = 1; $i <= 7; $i++) {
            echo '<h2>'.$i.'</h2>';

            echo 'sum->demand :: '.array_sum($this->demand) . ' === 0  := ';
            echo array_sum($this->demand) === 0 ? 'true' : 'false';
            echo '<br>';
            echo 'sum->supply :: '.array_sum($this->supply) . ' === 0  := ';
            echo  array_sum($this->supply) === 0 ? 'true' : 'false';
            echo '<br>demand || supply := ';
            echo ( (array_sum($this->demand) === 0) || (array_sum($this->supply) === 0) ) ? 'true' : 'false';

            // clear value
            $this->clear();

            // show
            $this->show->show('input ', $this->minDS);
            $this->show->show('supply ', $this->supply);
            $this->show->show('demand ', $this->demand);

            // ฟังชั่น ลบข้อมูล จากการหาค่าน้อยสุดในแต่ละแถว และคอลัมน์
            $this->show->show('min row ', $this->minValueRow());
            $this->show->show('output delete row ', $this->deleteValueRow());
            $this->show->show('min column ', $this->minValueColumn());
            $this->show->show('output delete column ', $this->deleteValueColumn());


            // ตำแหน่งของ 0
            $this->positionZero = $this->findZero($this->outputDS);
            $this->positionZeroTranspose = $this->findZero(self::transpose($this->outputDS), true);
            $this->show->show('position zero', $this->positionZero);
            $this->show->show('position zero transpose', $this->positionZeroTranspose);

            // นับจำนวน 0 ใน แถว และคอลัมน์
            $this->countZeroRow();
            $this->countZeroColumn();
            $this->show->show('count zero row', $this->countZeroRow);
            $this->show->show('count zero column', $this->countZeroColumn);

            // รวมผล 0 จาก แถวและคอลัมน์
            $this->sumZero();
            $this->show->show('output sum count zero', $this->outputDS);

            // เช็คค่าที่บวกมีค่าที่ซ้ำหรือไม่
            if ($this->isZeroValueMinMoreFirst()) {
                // ถ้ามากกว่า 1 ตัวทำในฟังชั่นนี้
                echo '<h4>มีค่าซ้ำ</h4>';
                // เรียกฟังชั่นสำหรับคำนวณค่าที่ซ้ำกัน
                $this->processDuplicateValue();

                // คือค่าเพื่อลบ supply กับ demand
                $this->processPositionSelect();
            } else {
                echo '<h4># Not Duplicate Value</h4>';
                echo '[ '.$this->positionMinZero["row"]. ':'.$this->positionMinZero["column"].' ]';
                // ถ้ามีแค่ 1 ค่า ทำในนี้
                // คือค่าเพื่อลบ supply กับ demand
                $this->processPositionSelect();
            }

            echo '<hr>';
        }

        return $this;
//        return $this->outputDS;
    }

    private function isDemandOrSupplyEqualZero() {
        if ((array_sum($this->demand) === 0) || (array_sum($this->supply) === 0)) {
            return true;
        }
        return false;
    }

    private function clear() {
        $this->outputDS = $this->minDS;
        $this->positionZero = [];
        $this->positionZeroTranspose = [];
        $this->countZeroRow = 0;
        $this->countZeroColumn = 0;
        $this->zeroValueArray = [];
        $this->positionMinZero = []; // row => 0, column => 0

    }


    // ------------ delete step 1 -------------
    private function minValueRow()
    {
        $arr = array();
        for ($i = 0; $i < $this->row; $i++) {
            $a1 = array();
            for ($j = 0; $j < $this->column ; $j++) {
                if (!in_array($j, $this->doNotThinkColumn, true) && !in_array($i, $this->doNotThinkRow, true)) {
                    $a1[] = $this->outputDS[$i][$j];
                }
            }
            if (!in_array($j, $this->doNotThinkColumn, true) && !in_array($i, $this->doNotThinkRow, true)) {
                $arr[] = @min($a1);
            } else {
                $arr[] = 0;
            }
        }
        return $arr;
    }

    private function deleteValueRow()
    {
        $output = $this->outputDS;
        for ($i = 0; $i < $this->row; $i++)
        {
            for ($j = 0; $j < $this->column; $j++)
            {
                if (!in_array($j, $this->doNotThinkColumn, true) && !in_array($i, $this->doNotThinkRow, true)) {
                    $output[$i][$j] -= $this->minValueRow()[$i];
                }
            }
        }
        $this->outputDS = $output;
        return $this->outputDS;
    }

    private function minValueColumn()
    {
        $arr = array(); $outTranspose = self::transpose($this->outputDS);
        for ($j = 0; $j < $this->column; $j++) {
            $a1 = array();
            for ($i = 0; $i < $this->row ; $i++) {
                if (!in_array($i, $this->doNotThinkRow, true) && !in_array($j, $this->doNotThinkColumn, true)) {
                    $a1[] = $outTranspose[$j][$i];
                }
            }
            if (!in_array($i, $this->doNotThinkRow, true) && !in_array($j, $this->doNotThinkColumn, true)) {
                $arr[] = @min($a1);
            } else {
                $arr[] = 0;
            }
        }
        return $arr;
    }

    private function deleteValueColumn()
    {
        $output = $this->outputDS;
        for ($i = 0; $i < $this->row; $i++)
        {
            for ($j = 0; $j < $this->column; $j++)
            {
                if (!in_array($j, $this->doNotThinkColumn, true) && !in_array($i, $this->doNotThinkRow, true)) {
                    $output[$i][$j] -= $this->minValueColumn()[$j];
                }
            }
        }
        $this->outputDS = $output;
        $this->minDS = $this->outputDS;
        return $this->outputDS;
    }

    private function findZero($arr, $transpose = false) {
        $output = array();
        foreach ($arr as $item => $value) {
            foreach ($value as $item2 => $value2) {
                if ($value2 === 0) {

                    if ($transpose) {
                        if (!in_array($item2, $this->doNotThinkRow, true) && !in_array($item, $this->doNotThinkColumn, true)) {
                            $output[] = ['row' => $item, 'column' => $item2];
                        }
                    } else {
                        if (!in_array($item2, $this->doNotThinkColumn, true) && !in_array($item, $this->doNotThinkRow, true)) {
                            $output[] = ['row' => $item, 'column' => $item2];
                        }
                    }
                }
            }
        }
        return $output;
    }
    // ------------ end step 1 ------------


    // ------------ count zero step 2 -------------
    private function countZeroRow()
    {
        $arr = array();
        for ($i = 0; $i < $this->row; $i++) {
            $a1 = array();
            for ($j = 0; $j < $this->column ; $j++) {
                if (!in_array($j, $this->doNotThinkColumn, true) && !in_array($i, $this->doNotThinkRow, true)) {
                    $a1[] = $this->outputDS[$i][$j];
                }
            }
            if (!in_array($j, $this->doNotThinkColumn, true) && !in_array($i, $this->doNotThinkRow, true)) {
                $arr[] =array_count_values($a1)[0];
            } else {
                $arr[] = 0;
            }
        }

        $this->countZeroRow = $arr;
    }

    private function countZeroColumn()
    {
        $arr = array(); $outTranspose = self::transpose($this->outputDS);
        for ($j = 0; $j < $this->column; $j++) {
            $a1 = array();
            for ($i = 0; $i < $this->row ; $i++) {
                if (!in_array($j, $this->doNotThinkColumn, true) && !in_array($i, $this->doNotThinkRow, true)) {
                    $a1[] = $outTranspose[$j][$i];
                }
            }

            if (!in_array($j, $this->doNotThinkColumn, true) && !in_array($i, $this->doNotThinkRow, true)) {
                $arr[] = array_count_values($a1)[0];
            } else {
                $arr[] = 0;
            }
        }

        $this->countZeroColumn = $arr;
    }

    private function sumZero()
    {
        $output = $this->outputDS; $begin = 0;
        for ($i = 0; $i < $this->row; $i++)
        {
            for ($j = 0; $j < $this->column; $j++)
            {
                if($this->positionZero[$begin]['row'] === $i && $this->positionZero[$begin]['column'] === $j)
                {
                    $output[$i][$j] = $this->countZeroRow[$i] + $this->countZeroColumn[$j];
                    $this->zeroValueArray[] = $output[$i][$j];
                    if ($begin < count($this->positionZero) - 1) {
                        $begin++;
                    }
                }
            }
        }
        $this->outputDS = $output;
    }

    // ------------ end count zero step 2 -------------

    // ------------ without zero value step 3 -------------
    private function sumWithOutZeroRow($r, $c)
    {
        $arr = array(); $begin = 0;
        for ($i = 0; $i < $this->row; $i++)
        {
            $sum = 0;
            if (in_array($i, $this->doNotThinkRow, true)) {
                $arr[] = 0;
            } else {
                for ($j = 0; $j < $this->column; $j++)
                {
                    if (!in_array($j, $this->doNotThinkColumn, true)) {
                        // 0 :: row, 1 :: column
                        if ($this->positionZero[$begin]['row'] === $i && $this->positionZero[$begin]['column'] === $j)
                        {
                            if ($begin < count($this->positionZero) - 1) {
                                $begin++;
                            }
                        }
                        else
                        {
                            // เฉพาะแถว หรือ คอลัมน์ที่มี
                            if (in_array($i, $r, true) && in_array($j, $c, true)) {
                                $sum += $this->outputDS[$i][$j];
                            }
                        }
                    }
                }
                $arr[] = $sum;
            }
        }
        return $arr;
    }

    private function sumWithOutZeroColumn($r, $c)
    {
        $arr = array(); $begin = 0; $sum = 0;
        for ($j = 0; $j < $this->column; $j++)
        {
            $sum = 0;
            if (in_array($j, $this->doNotThinkColumn, true)) {
                $arr[] = 0;
            } else {
                for ($i = 0; $i < $this->row; $i++)
                {
                    if (!in_array($i, $this->doNotThinkRow, true)) {
                        // has zero
                        if ($this->positionZeroTranspose[$begin]['row'] === $j && $this->positionZeroTranspose[$begin]['column'] === $i)
                        {
                            if ($begin < count($this->positionZeroTranspose) - 1) {
                                $begin++;
                            }
                        }
                        else
                        {
                            // เฉพาะแถว หรือ คอลัมน์ที่มี
                            if (in_array($i, $r, true) && in_array($j, $c, true)) {
                                $sum += $this->outputDS[$i][$j];
                            }
                        }
                    }
                }
                $arr[] = $sum;
            }
        }
        return $arr;
    }

    private function processDuplicateValue() {
        $this->show->show('zero value', $this->zeroValueArray);
        $this->show->show('position min value', $this->positionMinZero);

        $r = array(); $c = array();
        foreach ($this->positionMinZero as $item => $value) {
            $r[] = $value['row'];
            $c[] = $value['column'];
        }
        // หาตำแน่งที่มีค่าซ้ำกันเพื่อบวกในแต่ละแถว แต่ละคอลัมน์ โดยไม่นับตำแน่งที่ 0
        $sumRowArr = $this->sumWithOutZeroRow($r, $c);
        $sumColumnArr = $this->sumWithOutZeroColumn($r, $c);
        unset($r, $c);

        //$this->show->show('-- output --', $this->outputDS);
        $this->show->show('-- sum row without zero --', $sumRowArr);
        $this->show->show('-- sum column without zero --', $sumColumnArr);


        $minValueArr = array();
        // รวมผล และใส่ในตำแหน่งที่ค่าซ้ำกัน
        foreach ($this->positionMinZero as $value) {
            $this->outputDS[$value['row']][$value['column']] = $sumRowArr[$value['row']] + $sumColumnArr[$value['column']];
            $minValueArr[] = $this->outputDS[$value['row']][$value['column']];
        }
        $this->show->show('-- min sum value without zero --', $minValueArr);

        // ตรวจสอบค่าว่าซ้ำกันอีกหรือไม่
        $max = @max($minValueArr);
        if (array_count_values($minValueArr)[$max] === 1) {
            // ไม่ซ้ำกันอีก
            echo '<h4>ไม่ซ้ำกันแล้ว</h4>';
            foreach ($this->positionMinZero as $value) {
                if ($this->outputDS[$value['row']][$value['column']] === $max) {
                    $this->positionMinZero = $value;
                }
            }

            echo '[ '.$this->positionMinZero["row"]. ':'.$this->positionMinZero["column"].' ]';

        } else {
            // ถ้าซ้ำกันอีก ให้กลับไปดูที่ค่ารับเข้าในแต่ละรอบ
            echo '<h4>ซ้ำกันแล้ว</h4>';
            $minValueFirst = $this->inputDS[$this->positionMinZero[0]['row']][$this->positionMinZero[0]['column']];
            $count = count($this->positionMinZero);
            $min = 0;$mArr = array();
            for ($i = 1; $i < $count; $i++) {
                if ($minValueFirst > $this->inputDS[$this->positionMinZero[$i]['row']][$this->positionMinZero[$i]['column']]){
                    $minValueFirst = $this->inputDS[$this->positionMinZero[$i]['row']][$this->positionMinZero[$i]['column']];
                    $min = $i;
                }
                $mArr[] = $this->inputDS[$this->positionMinZero[$i]['row']][$this->positionMinZero[$i]['column']];
            }

            unset($minValueFirst, $count);

            // ตรวจสอบค่ารับเข้าในแต่ละรอบซ้ำกันหรือไม่
            $m = @min($mArr);
            echo '<h4>'.$m.'</h4>';
            if (array_count_values($mArr)[$m] === 1) {
                // ไม่ซ้ำกัน
                echo '<h4>ไม่ซ้ำกันแล้ว</h4>';
                $this->positionMinZero = $this->positionMinZero[$min];
                echo '[ '.$this->positionMinZero["row"]. ':'.$this->positionMinZero["column"].' ]';

            } else {
                // ซ้ำกัน
                $this->positionMinZero = $this->positionMinZero[0];
                echo '[ '.$this->positionMinZero["row"]. ':'.$this->positionMinZero["column"].' ]';
            }
        }


    }
    // ------------ min value step final -------------
    private function isZeroValueMinMoreFirst() {
        $min = @min($this->zeroValueArray);
        $countValue = array_count_values($this->zeroValueArray);

        // หาตำแหนงที่น้อยที่สุดจากตำแหน่งที่มี 0 และ เก็บค่าตำแหน่งไว้
        foreach ($this->positionZero as $item => $value) {
            if($this->outputDS[$value['row']][$value['column']] === $min) {
                if($countValue[$min] === 1) {
                    $this->positionMinZero = $value;
                    return false;
                } else {
                    $this->positionMinZero[] = $value;
                }
            }
        }
        return true;
    }

    private function isSupplyOverDemand() {
        return $this->supply[$this->positionMinZero['row']] > $this->demand[$this->positionMinZero['column']];
    }

    private function processPositionSelect() {
        $r = $this->positionMinZero['row'];
        $c = $this->positionMinZero['column'];

        echo '<h4>supply over demand</h4>';
        echo $this->supply[$this->positionMinZero['row']] . ' > ' . $this->demand[$this->positionMinZero['column']];
        // เช็คค่า supply กับ demand ตรงที่ตำแหน่งค่าที่น้อยที่สุดอยู่
        if ($this->isSupplyOverDemand()) {
            // supply > demand
            echo ' : true';
            // เอาค่า supply มาใส่ตรงที่ค่าน้อยจากตำแหน่งผลบวกของ 0
            $this->output[$r][$c] = $this->demand[$c];
            // ลบค่า
            $this->supply[$r] -= $this->demand[$c];
            $this->demand[$c] = 0;

            // แถว หรือ คอลัมน์ ใดที่เป็น 0 จะไม่นำมาคิดต่อไป
            $this->doNotThinkColumn[] = $c;
        } else {
            // demand > supply
            echo ' : false';
            // เอาค่า supply มาใส่ตรงที่ค่าน้อยจากตำแหน่งผลบวกของ 0
            $this->output[$r][$c] = $this->supply[$r];
            // ลบค่า
            $this->demand[$c] -= $this->supply[$r];
            $this->supply[$r] = 0;

            // แถว หรือ คอลัมน์ ใดที่เป็น 0 จะไม่นำมาคิดต่อไป
            $this->doNotThinkRow[] = $r;
        }

        $this->show->show('output ', $this->output);
        $this->show->show('supply ', $this->supply);
        $this->show->show('demand ', $this->demand);
        $this->show->show('do not think row ', $this->doNotThinkRow);
        $this->show->show('do not think column ', $this->doNotThinkColumn);
    }
}