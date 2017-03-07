<?php



class BlockRCClass implements BlockRC
{

    private $rowBlock;
    private $columnBlock;

    public function __construct($row, $column)
    {
        $this->rowBlock = $row;
        $this->columnBlock = $column;
    }

    public function addRow($id) {
        $this->rowBlock[] = $id;
    }

    public function addColumn($id) {
        $this->columnBlock[] = $id;
    }

    public function setRowBlock(array $rowArr)
    {
        $this->rowBlock = $rowArr;
    }


    public function findRow($id)
    {
        return in_array($id, $this->rowBlock, true);
    }

    public function findColumn($id)
    {
        return in_array($id, $this->columnBlock, true);
    }

    public function getRowBlock($index = null)
    {
        if (null === $index) {
            return $this->rowBlock;
        }
        return $this->rowBlock[$index];
    }

    public function setColumnBlock(array $columnArr)
    {
        $this->columnBlock = $columnArr;
    }

    public function getColumnBlock($index = null)
    {
        if (null === $index) {
            return $this->columnBlock;
        }
        return $this->columnBlock[$index];
    }

    public function isTwoValue($row, $column) {
        return ($row - count($this->rowBlock) === 2) && ($column - count($this->columnBlock) === 1);
    }
}