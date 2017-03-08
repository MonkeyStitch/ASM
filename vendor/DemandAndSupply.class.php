<?php


class DemandAndSupply
{
    private $demand;
    private $supply;
    private $sumDemand;
    private $position;

    public function __construct($demand, $supply)
    {
        $this->demand = $demand;
        $this->supply = $supply;
        $this->sumDemand();
    }

    /**
     * @return mixed
     */
    public function getDemand($index = null)
    {
        if ($index === null) {
            return $this->demand;
        }
        return $this->demand[$index];
    }

    /**
     * @return mixed
     */
    public function getSupply($index = null)
    {
        if ($index === null) {
            return $this->supply;
        }
        return $this->supply[$index];
    }

    public function findRow($value)
    {
        foreach ($this->supply as $sup) {
            if ($value === $sup) {
                return true;
            }
        }
        return false;
    }

    public function findColumn($value)
    {
        foreach ($this->demand as $de) {
            if ($value === $de) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param mixed $demand
     */
    public function setDemand($index, $demand)
    {
        $this->demand[$index] = $demand;
    }

    /**
     * @param mixed $supply
     */
    public function setSupply($index, $supply)
    {
        $this->supply[$index] = $supply;
    }



    private function sumDemand() {
        $this->sumDemand = array_sum($this->demand);
    }


    private function checkSupplyMoreDemand() {
        // supply > demand ทั้ง 2 ค่าเลยหรือไม่
        $bool = true;

        foreach ($this->supply as $item => $value) {
            $bool &= $value > $this->sumDemand;
            if ($value > $this->sumDemand) {
                $this->position = $item;
            }
        }
        return $bool;
    }

    public function isDemandOrSupplyEqualZero() {
        if ((array_sum($this->demand) === 0) || (array_sum($this->supply) === 0)) {
            return true;
        }
        return false;
    }

    public function process($positionMinZero, $min) {
        $this->sumDemand();

        if ($this->checkSupplyMoreDemand()) {
            // yes จะดูที่ค่า input แรก
            $positionMinZero = $positionMinZero[$min];
        } else {
            // no เลือกตำแหน่งที่ supply > demand
            foreach ($positionMinZero as $item => $value) {
                if ($value['row'] === $this->position) {
                    $positionMinZero = $positionMinZero[$item];
                }
            }
        }

        return $positionMinZero;
    }
}