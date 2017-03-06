<?php


class SumZero
{

    private $arr;
    private $row;
    private $column;
    private $position;
    private $countZeroRowArr;
    private $countZeroColumnArr;
    private $zeroValueArray;
    private $output;



    public function __construct($arr = null, FindZero $findZero = null)
    {
        if ($arr !== null) {
            $this->setArr($arr);
        }

        if ($findZero !== null) {
            $this->setFindZero($findZero);
        }
    }

    /**
     * @param null $arr
     */
    public function setArr($arr)
    {
        $this->arr = $arr;
        $this->row = count($arr);
        $this->column = count($arr[0]);
        $this->output = Library::set($this->row, $this->column);
    }

    /**
     * @param FindZero $findZero
     * @internal param int $row
     */
    public function setFindZero(FindZero $findZero)
    {
        $this->position = $findZero->getPosition();
        $this->countZeroRowArr = $findZero->count('row');
        $this->countZeroColumnArr = $findZero->count('column');
    }



    public function getSumValueArr(){
        return $this->zeroValueArray;
    }

    public function getSumOutput() {
        $begin = 0;
        for ($i = 0; $i < $this->row; $i++)
        {
            for ($j = 0; $j < $this->column; $j++)
            {
                if($this->position[$begin]['row'] === $i && $this->position[$begin]['column'] === $j)
                {
                    $this->output[$i][$j] = $this->countZeroRowArr[$i] + $this->countZeroColumnArr[$j];
                    $this->zeroValueArray[] = $this->output[$i][$j];
                    if ($begin < count($this->position) - 1) {
                        $begin++;
                    }
                }
            }
        }

        return $this->output;
    }

}