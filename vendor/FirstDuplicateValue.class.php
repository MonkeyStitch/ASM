<?php


class FirstDuplicateValue
{

    private $asmFirst;
    private $row;
    private $column;
    private $block;
    private $positionMinZero;
    private $positionZero;
    private $positionZeroTranspose;
    private $hasRow;
    private $hasColumn;
    private $sumWithOutZeroRowArr;
    private $sumWithOutZeroColumnArr;
    private $maxValueArr;


    public function __construct($asmFirst = null, FindZero $findZero = null, $positionMinZero = null, BlockRCClass $blockRCClass = null)
    {
        if($asmFirst !== null) {
            $this->setAsmFirst($asmFirst);
        }
        if($findZero !== null) {
            $this->setFindZero($findZero);
        }
        if($positionMinZero !== null) {
            $this->setPositionZero($positionMinZero);
        }
        if($blockRCClass !== null) {
            $this->setBlock($blockRCClass);
        }

    }

    /**
     * @param null $asmFirst
     */
    public function setAsmFirst($asmFirst)
    {
        $this->asmFirst = $asmFirst;
        $this->row = count($asmFirst);
        $this->column = count($asmFirst[0]);
    }

    /**
     * @param $findZero
     * @internal param int $row
     */
    public function setFindZero(FindZero $findZero)
    {
        $this->positionZero = $findZero->getPosition();
        $this->positionZeroTranspose = $findZero->getPositionTranspose();
    }

    /**
     * @param BlockRCClass $block
     */
    public function setBlock(BlockRCClass $block)
    {
        $this->block = $block;
    }

    /**
     * @param mixed $positionZero
     */
    public function setPositionZero($positionZero)
    {
        $this->positionMinZero = $positionZero;
    }

    public function process() {
        $this->positionMin();
        $this->sumWithOutZeroRow();
        $this->sumWithOutZeroColumn();
    }



    /**
     * @return mixed
     */
    public function getSumWithOutZeroRowArr()
    {
        return $this->sumWithOutZeroRowArr;
    }

    /**
     * @return mixed
     */
    public function getSumWithOutZeroColumnArr()
    {
        return $this->sumWithOutZeroColumnArr;
    }

    private function positionMin() {
        foreach ($this->positionMinZero as $item => $value) {
            $this->hasRow[] = $value['row'];
            $this->hasColumn[] = $value['column'];
        }
    }


    private function sumWithOutZeroRow()
    {
        $begin = 0;
        for ($i = 0; $i < $this->row; $i++)
        {
            $sum = 0;
            // block row || without has zero row
            if (in_array($i, $this->block->getRowBlock(), true) || !in_array($i, $this->hasRow, true)) {
                $this->sumWithOutZeroRowArr[] = 0;
            } else {

                for ($j = 0; $j < $this->column; $j++)
                {
                    // no block column && without has zero column
                    if (!in_array($j, $this->block->getColumnBlock(), true) && !in_array($j, $this->hasColumn, true)) {

                        // position without zero
                        if ($this->positionZero[$begin]['row'] === $i && $this->positionZero[$begin]['column'] === $j)
                        {
                            if ($begin < count($this->positionZero) - 1) {
                                $begin++;
                            }
                        }
                        else
                        {
                            $sum += $this->asmFirst[$i][$j];
                        }
                    }
                }
                $this->sumWithOutZeroRowArr[] = $sum;
            }
        }
    }


    private function sumWithOutZeroColumn()
    {
        $begin = 0;
        for ($j = 0; $j < $this->column; $j++)
        {

            $sum = 0;
            if (in_array($j, $this->block->getColumnBlock(), true) || !in_array($j, $this->hasColumn, true)) {
                $this->sumWithOutZeroColumnArr[] = 0;
            } else {
                for ($i = 0; $i < $this->row; $i++)
                {
                    if (!in_array($i, $this->block->getRowBlock(), true) && !in_array($i, $this->hasRow, true)) {
                        // has zero
                        if ($this->positionZeroTranspose[$begin]['row'] === $j && $this->positionZeroTranspose[$begin]['column'] === $i)
                        {
                            if ($begin < count($this->positionZeroTranspose) - 1) {
                                $begin++;
                            }
                        }
                        else
                        {
                            $sum += $this->asmFirst[$i][$j];
                        }
                    }
                }
                $this->sumWithOutZeroColumnArr[] = $sum;
            }
        }
    }


    public function getsumWithOutZero() {
        $arr = Library::set($this->row, $this->column);
        // รวมผล และใส่ในตำแหน่งที่ค่าซ้ำกัน
        foreach ($this->positionMinZero as $value) {
            $arr[$value['row']][$value['column']] = $this->sumWithOutZeroRowArr[$value['row']] + $this->sumWithOutZeroColumnArr[$value['column']];
            $this->maxValueArr[] = $arr[$value['row']][$value['column']];
        }
        return $arr;
    }

    public function getValueArr() {
        return $this->maxValueArr;
    }
}