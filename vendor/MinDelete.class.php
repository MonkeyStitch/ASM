<?php


class MinDelete
{
    private $arr;
    private $row;
    private $column;
    private $block;
    private $minRowArr;
    private $minColumnArr;

    public function __construct($arr, BlockRCClass $blockRCClass)
    {
        $this->arr = $arr;
        $this->row = count($arr);
        $this->column = count($arr[0]);
        $this->block = $blockRCClass;
    }


    public function getOutput() {
        // process

        // row
        $this->minValueRow();
        $this->deleteValue($this->minRowArr);

        // column
        $this->minValueColumn();
        $this->deleteValue($this->minColumnArr, false);

        return $this->arr;
    }


    private function minValueRow() {

        for ($i = 0; $i < $this->row; $i++) {
            $a1 = array();

            for ($j = 0; $j < $this->column ; $j++) {
                if (!in_array($j, $this->block->getColumnBlock(), true) && !in_array($i, $this->block->getRowBlock(), true)) {

                    $a1[] = $this->arr[$i][$j];

                }
            }

            if (!in_array($j, $this->block->getColumnBlock(), true) && !in_array($i, $this->block->getRowBlock(), true)) {
                $this->minRowArr[] = @min($a1);
            } else {
                $this->minRowArr[] = 0;
            }

        }
    }



    private function minValueColumn()
    {
        $outTranspose = Transpose::transpose($this->arr);
        for ($j = 0; $j < $this->column; $j++) {
            $a1 = array();
            for ($i = 0; $i < $this->row ; $i++) {
                if (!in_array($i, $this->block->getRowBlock(), true) && !in_array($j, $this->block->getColumnBlock(), true)) {
                    $a1[] = $outTranspose[$j][$i];
                }
            }
            if (!in_array($i, $this->block->getRowBlock(), true) && !in_array($j, $this->block->getColumnBlock(), true)) {
                $this->minColumnArr[] = @min($a1);
            } else {
                $this->minColumnArr[] = 0;
            }
        }
        unset($outTranspose);
    }



    private function deleteValue($arrInput, $Deleterow = true) {

        for ($i = 0; $i < $this->row; $i++)
        {
            for ($j = 0; $j < $this->column; $j++)
            {
                if (!in_array($j, $this->block->getColumnBlock(), true) && !in_array($i, $this->block->getRowBlock(), true)) {
                    if ($Deleterow) {
                        $this->arr[$i][$j] -= $arrInput[$i];
                    } else {
                        $this->arr[$i][$j] -= $arrInput[$j];
                    }
                }
            }
        }

    }
}