<?php


class TheNewProcessASM
{
    private $row = 0;
    private $column = 0;

    private $inputDS = [];
    private $minDS = [];
    private $outputDS = [];
    private $output = [];
    private $show;

    private $block;
    private $DeAndSup;
    private $minDelete;
    private $sum;
    private $checkSum;
    private $firstDup;
    private $second;
    private $select;

    private $positionZero = [];
    private $positionZeroTranspose = [];

    private $zeroValueArray = [];

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

        $this->show = new OutputMyArrays();
        $this->block = new BlockRCClass([],[]);

        $this->DeAndSup = new DemandAndSupply($demand, $supply);
        $this->minDelete = new MinDelete($this->inputDS, $this->block);

        $this->find = new FindZero(null, null);
        $this->sum = new SumZero(null, null);
        $this->checkSum = new CheckSumValue(null, null);

        $this->firstDup = new FirstDuplicateValue(null, null, null, null);
        $this->second = new SecondDuplicateValue(null, null);

        $this->select = new ProcessPositionSelect(null, null, null);

        $this->output = Library::set($this->row, $this->column);
    }


    public function output() {


//        while (!$this->DeAndSup->isDemandOrSupplyEqualZero()) {
       for ($i = 1; $i <= 2; $i++) {
            echo '<h2>'.$i.'</h2>';

            echo 'sum->demand :: '.array_sum($this->DeAndSup->getDemand()) . ' === 0  := ';
            echo array_sum($this->DeAndSup->getDemand()) === 0 ? 'true' : 'false';
            echo '<br>';
            echo 'sum->supply :: '.array_sum($this->DeAndSup->getSupply()) . ' === 0  := ';
            echo  array_sum($this->DeAndSup->getSupply()) === 0 ? 'true' : 'false';
            echo '<br>demand || supply := ';
            echo ( (array_sum($this->DeAndSup->getDemand()) === 0) || (array_sum($this->DeAndSup->getSupply()) === 0) ) ? 'true' : 'false';


           // clear value
           $this->clear();

           // show
            $this->show->show('input ', $this->inputDS);
            $this->show->show('supply ', $this->DeAndSup->getSupply());
            $this->show->show('demand ', $this->DeAndSup->getDemand());


           // ฟังชั่น ลบข้อมูล จากการหาค่าน้อยสุดในแต่ละแถว และคอลัมน์
           $this->outputDS = $this->minDelete->getOutput();
           $this->show->show('output delete column ', $this->outputDS);

            // ตำแหน่งของ 0
           $this->find->setArr($this->outputDS);
           $this->find->setBlock($this->block);
           $this->show->show('position zero',$this->find->getPosition());
           $this->show->show('position transpose zero ',$this->find->getPositionTranspose());


            // นับจำนวน 0 ใน แถว และคอลัมน์
            $this->show->show('count zero : row ',$this->find->count('row'));
            $this->show->show('count zero : col ',$this->find->count('column'));


           // รวมผล 0 จาก แถวและคอลัมน์
           $this->show->show('count zero : col ',$this->outputDS);

           $this->sum->setArr($this->outputDS);
           $this->sum->setFindZero($this->find);
           $sumZero = $this->sum->getSumOutput();
           $this->show->show('sum zero : ',$sumZero);

           // check sum zero
           $this->checkSum->setSumZero($this->sum);
           $this->checkSum->setFindZero($this->find);

            // เช็คค่าที่บวกมีค่าที่ซ้ำหรือไม่
            if ($this->checkSum->isZeroValueMinMoreFirst()) {
                // ถ้ามากกว่า 1 ตัวทำในฟังชั่นนี้
                echo '<h4>มีค่าซ้ำ</h4>';

                // เรียกฟังชั่นสำหรับคำนวณค่าที่ซ้ำกัน
                $this->positionMinZero = $this->checkSum->getPositionMinZero();
                $this->show->show('min value for more first : ', $this->positionMinZero);

                echo '<h4>ถ้ามากกว่า 1 ตัวทำในฟังชั่นนี้</h4>';

                // First Duplicate Value
                $this->firstDup->setAsmFirst($this->outputDS);
                $this->firstDup->setBlock($this->block);
                $this->firstDup->setFindZero($this->find);
                $this->firstDup->setPositionZero($this->positionMinZero);
                $this->firstDup->process();

                $this->show->show('sum without : row ',$this->firstDup->getSumWithOutZeroRowArr());
                $this->show->show('sum without : column ',$this->firstDup->getSumWithOutZeroColumnArr());

                $this->show->show('new value min  : sum without zero ',$this->firstDup->getsumWithOutZero());


                // is check sum without zero
                $checkSumWithOut = new CheckSumWithOut($this->firstDup->getValueArr());

                if ($checkSumWithOut->isMaxValue()) {
                    // ไม่ซ้ำกันอีก
                    echo '<h4>ไม่ซ้ำกันแล้ว</h4>';

                    foreach ($this->positionMinZero as $value) {
                        if ($this->outputDS[$value['row']][$value['column']] === $checkSumWithOut->getMax()) {
                            $positionMinZero = $value;
                        }
                    }
                } else {

                    // ถ้าซ้ำกันอีก ให้กลับไปดูที่ค่ารับเข้าในแต่ละรอบ
                    echo '<h4>ซ้ำกันแล้ว</h4>';
                    $this->second->setFirstData($this->inputDS);
                    $this->second->setBlock($this->block);

                    $this->second->findMinValue($this->positionMinZero);


                    // ตรวจสอบว่าเหลือ 2 ค่าหรือไม่
                    if ($this->block->isTwoValue($this->row, $this->column)) {
                        echo '<h4>2x2</h4>';


                        $this->positionMinZero = $this->DeAndSup->process($this->positionMinZero, $this->second->getMin());

                    } else {
                        // ตรวจสอบค่ารับเข้าในแต่ละรอบซ้ำกันหรือไม่

                        $this->positionMinZero = $this->second->getPositionNotTwo($this->positionMinZero);
                    }
                }


                // คือค่าเพื่อลบ supply กับ demand
                $this->select->setPositionMinZero($this->positionMinZero);
                $this->select->setDm($this->DeAndSup);
                $this->select->setBlock($this->block);
                $this->output = $this->select->process($this->output);

                $this->show->show('output ', $this->output);
                $this->show->show('supply ', $this->DeAndSup->getSupply());
                $this->show->show('demand ', $this->DeAndSup->getDemand());
                $this->show->show('do not think row ', $this->block->getRowBlock());
                $this->show->show('do not think column ', $this->block->getColumnBlock());

            } else {
                echo '<h4># Not Duplicate Value</h4>';
                echo '[ '.$this->positionMinZero["row"]. ':'.$this->positionMinZero["column"].' ]';
                // ถ้ามีแค่ 1 ค่า ทำในนี้
                // คือค่าเพื่อลบ supply กับ demand
                $this->select->setPositionMinZero($this->positionMinZero);
                $this->select->setDm($this->DeAndSup);
                $this->select->setBlock($this->block);
                $this->output = $this->select->process($this->output);

                $this->show->show('output ', $this->output);
                $this->show->show('supply ', $this->DeAndSup->getSupply());
                $this->show->show('demand ', $this->DeAndSup->getDemand());
                $this->show->show('do not think row ', $this->block->getRowBlock());
                $this->show->show('do not think column ', $this->block->getColumnBlock());
            }

            echo '<hr>';
        }

//        return $this;
        return $this->output;
    }



    private function clear() {
        $this->outputDS = $this->minDS;
        $this->positionZero = [];
        $this->positionZeroTranspose = [];
        $this->countZeroRow = 0;
        $this->countZeroColumn = 0;
        $this->zeroValueArray = [];
        $this->positionMinZero = []; // row => 0, column => 0

    }


}