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
    private $sum;


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
        $show = new OutputMyArrays();

        $this->positionMin();

        $this->sumWithOutZeroRow();
        $show->show('sum without : row ',$this->getSumWithOutZeroRowArr());

        echo '<h4>---------------------------------------</h4>';
        $this->sumWithOutZeroColumn();
        $show->show('sum without : column ',$this->getSumWithOutZeroColumnArr());

        $show->show('new value min  : sum without zero ',$this->getsumWithOutZero());
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
        $this->hasRow = [];
        $this->hasColumn = [];

        foreach ($this->positionMinZero as $item => $value) {
            $this->hasRow[] = $value['row'];
            $this->hasColumn[] = $value['column'];
        }
    }


    private function sumWithOutZeroRow()
    {
        $begin = 0;
        $this->sumWithOutZeroRowArr = [];

        for ($i = 0; $i < $this->row; $i++)
        {
            $sum = 0;
            echo $i . ' : ';
            // block row || without has zero row
            if (in_array($i, $this->block->getRowBlock(), true) || !in_array($i, $this->hasRow, true)) {
                $this->sumWithOutZeroRowArr[] = 0;
            } else {
                for ($j = 0; $j < $this->column; $j++)
                {
                    // no block column && without has zero column
                    if (!in_array($j, $this->block->getColumnBlock(), true)) {

                        // position without zero
                        if ($this->positionZero[$begin]['row'] === $i && $this->positionZero[$begin]['column'] === $j)
                        {
                            printf('%4s', 'N ');
                            if ($begin < count($this->positionZero) - 1) {
                                $begin++;
                            }
                        }
                        else
                        {
                            if (in_array($j, $this->hasColumn, true)) {
                                printf('%4s', $this->asmFirst[$i][$j] . ' ');
                                $sum += $this->asmFirst[$i][$j];
                            }
                        }
                    } else {
                        printf('%4s', 'N ');
                    }
                }
                $this->sumWithOutZeroRowArr[] = $sum;
                printf('%4s', '=');
                printf('%4s', $sum);
            }
            echo '<br>';
        }

    }


    private function sumWithOutZeroColumn()
    {
        $begin = 0;
        $this->sumWithOutZeroColumnArr = [];
        for ($j = 0; $j < $this->column; $j++)
        {
            $sum = 0;
            echo $j .' : ';

            if (in_array($j, $this->block->getColumnBlock(), true) || !in_array($j, $this->hasColumn, true)) {
                $this->sumWithOutZeroColumnArr[] = 0;
            } else {
                for ($i = 0; $i < $this->row; $i++)
                {
                    if (!in_array($i, $this->block->getRowBlock(), true)) {
                        // has zero
                        if ($this->positionZeroTranspose[$begin]['row'] === $j && $this->positionZeroTranspose[$begin]['column'] === $i)
                        {
                            printf('%4s', 'N ');
                            if ($begin < count($this->positionZeroTranspose) - 1) {
                                $begin++;
                            }
                        }
                        else
                        {
                            if (in_array($i, $this->hasRow, true)) {
                                printf('%4s', $this->asmFirst[$i][$j] . ' ');
                                $sum += $this->asmFirst[$i][$j];
                            }
                        }
                    } else {
                        printf('%4s', 'N ');
                    }
                }
                $this->sumWithOutZeroColumnArr[] = $sum;
                printf('%4s', '=');
                printf('%4s', $sum);
            }
            echo '<br>';
        }
    }


    public function getsumWithOutZero() {
        $arr = Library::set($this->row, $this->column);
        $this->maxValueArr = [];
        $this->sum = [];
        // รวมผล และใส่ในตำแหน่งที่ค่าซ้ำกัน
        foreach ($this->positionMinZero as $value) {
            $arr[$value['row']][$value['column']] = $this->sumWithOutZeroRowArr[$value['row']] + $this->sumWithOutZeroColumnArr[$value['column']];
            $this->maxValueArr[] = $arr[$value['row']][$value['column']];
        }
        $this->sum = $arr;
        return $arr;
    }

    public function getValueArr() {
        return $this->maxValueArr;
    }


    public function getPositionMaxValue($max) {
        foreach ($this->positionMinZero as $value) {
            if ($this->sum[$value['row']][$value['column']] === $max) {
                return $value;
            }
        }
        return null;
    }
}