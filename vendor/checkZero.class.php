<?php


class CheckZero
{

    private $arr;
    private $rowArr = array(); // data type boolean
    private $colArr = array(); // data type boolean
    private $block;


    public function __construct(array $arr = array(),  BlockRCClass $blockRCClass)
    {
        $this->arr = $arr;
        $this->block = $blockRCClass;
    }

    public function get() {
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

        foreach($this->arr as $item => $value) {


            foreach ($value as $item2 => $value2) {

                if (!in_array($item, $this->block->getRowBlock(), true) && !in_array($item2, $this->block->getColumnBlock(), true)) {

                    if ($item2 === 0) {
                        // set default value : row
                        $this->rowArr[$item] = false;
                    }

                    if ($item === 0) {
                        // set default value : column
                        $this->colArr[$item2] = false;
                    }


                    // row
                    if (!$this->rowArr[$item]){
                        $this->rowArr[$item] = ($value2 === 0) ;
                    }

                    // col
                    if (!$this->colArr[$item2]) {
                        $this->colArr[$item2] = ($value2 === 0);
                    }
                }

            }

        }
    }

    private function isZeroAll() {
        return !in_array(false, $this->rowArr, true) && !in_array(false, $this->colArr, true);
    }

}