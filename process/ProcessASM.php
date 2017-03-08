<?php


class ProcessASM
{
    private $row = 0;
    private $column = 0;

    private $inputDS = [];
    private $outputDS = [];
    private $output = [];

    private $block;
    private $DeAndSup;
    private $checkZero;
    private $minDelete;
    private $sum;
    private $checkSum;
    private $firstDup;
    private $second;
    private $select;

    private $positionMinZero = []; // row => 0, column => 0



    /**
     * Process constructor.
     * @param int $row
     * @param int $column
     * @param array $demand
     * @param array $supply
     * @param array $inputDS
     */
    public function __construct($row, $column, array $demand, array $supply, array $inputDS)
    {
        $this->row = $row;
        $this->column = $column;

        $this->inputDS = $inputDS;
        $this->outputDS = $inputDS;

        $this->block = new BlockRCClass([],[]);

        $this->DeAndSup = new DemandAndSupply($demand, $supply);
        $this->minDelete = new MinDelete($this->outputDS, $this->block);

        $this->checkZero = new CheckZero(null, null);

        $this->find = new FindZero(null, null);
        $this->sum = new SumZero(null, null);
        $this->checkSum = new CheckSumValue(null, null);

        $this->firstDup = new FirstDuplicateValue(null, null, null, null);
        $this->second = new SecondDuplicateValue(null, null);

        $this->select = new ProcessPositionSelect(null, null, null);

        $this->output = Library::set($this->row, $this->column);
    }


    private function clear() {
        $this->positionMinZero = []; // row => 0, column => 0
    }

    public function output() {

        while (!$this->DeAndSup->isDemandOrSupplyEqualZero()) {

           // clear value
           $this->clear();

           // set value in CheckZero
           $this->checkZero->setArr($this->outputDS);
           $this->checkZero->setBlock($this->block);


           // check zero if not zero all
            if (!$this->checkZero->isCheck()) {

                // clear value
                $this->minDelete->setArr($this->inputDS);

                // ฟังชั่น ลบข้อมูล จากการหาค่าน้อยสุดในแต่ละแถว และคอลัมน์
                $this->outputDS = $this->minDelete->getOutput();
            }

            // ตำแหน่งของ 0
           $this->find->setArr($this->outputDS);
           $this->find->setBlock($this->block);


           // รวมผล 0 จาก แถวและคอลัมน์
           $this->sum->setArr($this->outputDS);
           $this->sum->setFindZero($this->find);


           // check sum zero
           $this->checkSum->setSumZero($this->sum);
           $this->checkSum->setFindZero($this->find);

           $checkValue = $this->checkSum->isZeroValueMinMoreFirst();
           $this->positionMinZero = $this->checkSum->getPositionMinZero();

            // เช็คค่าที่บวกมีค่าที่ซ้ำหรือไม่
            if ($checkValue) {
                // ถ้ามากกว่า 1 ตัวทำในฟังชั่นนี้

                // เรียกฟังชั่นสำหรับคำนวณค่าที่ซ้ำกัน
                $this->positionMinZero = $this->checkSum->getPositionMinZero();


                // First Duplicate Value
                $this->firstDup->setAsmFirst($this->outputDS);
                $this->firstDup->setBlock($this->block);
                $this->firstDup->setFindZero($this->find);
                $this->firstDup->setPositionZero($this->positionMinZero);
                $this->firstDup->process();

                // is check sum without zero
                $checkSumWithOut = new CheckSumWithOut($this->firstDup->getValueArr());

                if ($checkSumWithOut->isMaxValue()) {
                    // ไม่ซ้ำกันอีก
                    $this->positionMinZero = $this->firstDup->getPositionMaxValue($checkSumWithOut->getMax());

                } else {

                    // ถ้าซ้ำกันอีก ให้กลับไปดูที่ค่ารับเข้าในแต่ละรอบ

                    $this->second->setFirstData($this->inputDS);
                    $this->second->setBlock($this->block);
                    $this->second->findMinValue($this->positionMinZero);

                    // ตรวจสอบว่าเหลือ 2 ค่าหรือไม่
                    if ($this->block->isTwoValue($this->row, $this->column)) {

                        $this->positionMinZero = $this->DeAndSup->process($this->positionMinZero, $this->second->getMinIndex());

                    } else {

                        // ตรวจสอบค่ารับเข้าในแต่ละรอบซ้ำกันหรือไม่
                        $this->positionMinZero = $this->second->getPositionNotTwo($this->positionMinZero);

                    }
                }
            }

            // คือค่าเพื่อลบ supply กับ demand
            $this->supplyAndDemand();

        }

        return $this->output;
    }


    private function supplyAndDemand()
    {
        // ถ้ามีแค่ 1 ค่า ทำในนี้
        // คือค่าเพื่อลบ supply กับ demand
        $this->select->setPositionMinZero($this->positionMinZero);
        $this->select->setDm($this->DeAndSup);
        $this->select->setBlock($this->block);
        $this->output = $this->select->process($this->output);

    }

}