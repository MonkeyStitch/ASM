<?php


class CheckZero
{

    private $arr;
    private $block;
    private $process;


    public function __construct(array $arr = null,  BlockRCClass $blockRCClass = null)
    {
        if ($arr !== null) {
            $this->arr = $arr;
        }
        if ($blockRCClass !== null) {
            $this->block = $blockRCClass;
        }
    }

    /**
     * @param array $arr
     */
    public function setArr($arr)
    {
        $this->arr = $arr;
    }

    /**
     * @param BlockRCClass $block
     */
    public function setBlock($block)
    {
        $this->block = $block;
    }



    public function isCheck() {
        $this->process = Library::processSubArr($this->arr, $this->block);


        return $this->isZeroAll();
    }


    private function PRow()
    {
        $arr = $this->process;
        $bool = true;
        foreach ($arr as $item => $value) {
            $min = @min($value);
            $bool &= ($min === 0);
        }
        return $bool;
    }

    private function PColumn()
    {
        $arr = Transpose::transpose($this->process);
        $bool = true;
        foreach ($arr as $item => $value) {
            $min = @min($value);
            $bool &= ($min === 0);
        }
        return $bool;
    }

    private function isZeroAll() {

        return $this->PRow() && $this->PColumn();
    }



}