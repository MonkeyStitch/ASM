<?php


class CheckZero
{

    private $arr;
    private $rowArr = array(); // data type boolean
    private $colArr = array(); // data type boolean
    private $block;


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
        $this->process();
        return $this->isZeroAll();
    }



    /**
     * @return array
     */
    public function getRow($index = null)
    {
        if ($index === null) {
            return $this->rowArr;
        }
        return $this->rowArr[$index];
    }

    /**
     * @return array
     */
    public function getColumn($index = null)
    {
        if ($index === null) {
            return $this->colArr;
        }
        return $this->colArr[$index];
    }



    // true is 0
    private function process() {
        $this->rowArr = array();
        $this->colArr = array();

        foreach ($this->arr as $item => $value) {
            if (@min($value) === 0) {
                $this->rowArr[$item] = true;
            } else {
                $this->rowArr[$item] = false;
            }
        }
        unset($item, $value);


        foreach (Transpose::transpose($this->arr) as $item => $value) {
            if (@min($value) === 0) {
                $this->colArr[$item] = true;
            } else {
                $this->colArr[$item] = false;

            }
        }
        unset($item, $value);
    }

    private function isZeroAll() {
        return !(in_array(false, $this->rowArr, true) && in_array(false, $this->colArr, true));
    }

}