<?php


class CheckSumValue
{

    private $asmArr;
    private $zeroValueArray;
    private $position;
    private $positionMinZero;



    public function __construct(SumZero $sumZero = null, FindZero $findZero = null)
    {
        if ($sumZero !== null) {
            $this->setSumZero($sumZero);
        }

        if ($sumZero !== null) {
            $this->setFindZero($findZero);
        }

    }

    public function setSumZero(SumZero $sumZero) {
        $this->asmArr = $sumZero->getSumOutput();
        $this->zeroValueArray = $sumZero->getSumValueArr();
    }

    public function setFindZero(FindZero $findZero) {
        $this->position = $findZero->getPosition();
    }

    public function isZeroValueMinMoreFirst() {
        $min = @min($this->zeroValueArray);
        $countValue = array_count_values($this->zeroValueArray);

        // หาตำแหนงที่น้อยที่สุดจากตำแหน่งที่มี 0 และ เก็บค่าตำแหน่งไว้
        foreach ($this->position as $item => $value) {
            if($this->asmArr[$value['row']][$value['column']] === $min) {
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

    public function getPositionMinZero() {
        return $this->positionMinZero;
    }
}