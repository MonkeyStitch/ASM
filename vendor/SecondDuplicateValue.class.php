<?php


class SecondDuplicateValue
{

    private $minIndex;
    private $minValueArr;
    private $firstData;
    private $block;



    public function __construct($firstData = null, BlockRCClass $block = null)
    {
        $this->minIndex = 0;
        if ($firstData !== null) {
            $this->setFirstData($firstData);
        }

        if ($block !== null) {
            $this->setBlock($block);
        }
    }

    /**
     * @param null $firstData
     */
    public function setFirstData($firstData)
    {
        $this->firstData = $firstData;
    }

    /**
     * @param BlockRCClass $block
     */
    public function setBlock($block)
    {
        $this->block = $block;
    }




    public function findMinValue($positionDuplicate) {
        $minValueFirst = $this->firstData[$positionDuplicate[0]['row']][$positionDuplicate[0]['column']];
        $count = count($positionDuplicate);
        $mArr = array();
        for ($i = 1; $i < $count; $i++) {
            if ($minValueFirst > $this->firstData[$positionDuplicate[$i]['row']][$positionDuplicate[$i]['column']]){
                $minValueFirst = $this->firstData[$positionDuplicate[$i]['row']][$positionDuplicate[$i]['column']];
                $this->minIndex = $i;
            }
            $mArr[] = $this->firstData[$positionDuplicate[$i]['row']][$positionDuplicate[$i]['column']];
        }

        $this->minValueArr = $mArr;
    }

    public function getMin() {
        return @min($this->minValueArr);
    }

    public function getMinArr() {
        return $this->minValueArr;
    }


    public function getMinIndex() {
        return $this->minIndex;
    }



    public function getPositionNotTwo($positionMinZero) {
        echo '<h4>min first value : '.$this->getMin().'</h4>';

        if (array_count_values($this->getMinArr())[$this->getMin()] === 1) {
            // ไม่ซ้ำกัน
            echo '<h4>ไม่ซ้ำกันแล้ว</h4>';
            $positionMinZero = $positionMinZero[$this->getMinIndex()];

        } else {
            // ซ้ำกัน
            $positionMinZero = $positionMinZero[0];
//            echo '[ '.$positionMinZero["row"]. ':'.$positionMinZero["column"].' ]';
        }
        return $positionMinZero;
    }
}