<?php

class FindZero
{

    private $arr;
    private $arrTranspose;

    private $row;
    private $column;

    private $block;

    private $countRowArr;
    private $countColumnArr;




    public function __construct($arr = null, BlockRCClass $blockRCClass = null)
    {
        if ($arr !== null ) {
            $this->setArr($arr);
        }

        if ($blockRCClass !== null) {
            $this->setBlock($blockRCClass);
        }
    }

    /**
     * @param mixed $arr
     */
    public function setArr($arr)
    {
        $this->arr = $arr;
        $this->arrTranspose = Transpose::transpose($arr);

        if ($this->row === null || $this->column === null) {
            $this->row = count($arr);
            $this->column = count($arr[0]);
        }
    }

    /**
     * @param BlockRCClass $block
     */
    public function setBlock($block)
    {
        $this->block = $block;
    }


    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->findZero($this->arr);
    }

    /**
     * @return mixed
     */
    public function getPositionTranspose()
    {
        return $this->findZero($this->arrTranspose, true);
    }


    public function count($str = 'row') {
        $this->countZero();
        if ($str === 'row') {
            return $this->countRowArr;
        }
        return $this->countColumnArr;
    }



    private function findZero($arr, $transpose = false) {
        $output = array();
        foreach ($arr as $item => $value) {
            foreach ($value as $item2 => $value2) {
                if ($value2 === 0) {
                    if ($transpose) {
                        if (!in_array($item2, $this->block->getRowBlock(), true) && !in_array($item, $this->block->getColumnBlock(), true)) {
                            $output[] = ['row' => $item, 'column' => $item2];
                        }
                    } else {
                        if (!in_array($item2, $this->block->getColumnBlock(), true) && !in_array($item, $this->block->getRowBlock(), true)) {
                            $output[] = ['row' => $item, 'column' => $item2];
                        }
                    }
                }
            }
        }
        return $output;
    }


    private function countZero()
    {

        for ($i = 0; $i < $this->row; $i++) {

            for ($j = 0; $j < $this->column ; $j++) {

                if ($j === 0) {
                    // set default value : row
                    $this->countRowArr[$i] = 0;
                }

                if ($i === 0) {
                    // set default value : column
                    $this->countColumnArr[$j] = 0;
                }


                if (!in_array($j, $this->block->getColumnBlock(), true) && !in_array($i, $this->block->getRowBlock(), true)) {
                    if ($this->arr[$i][$j] === 0) {
                        $this->countRowArr[$i] += 1;
                        $this->countColumnArr[$j] += 1;
                    }
                }
            }
        }
    }
}