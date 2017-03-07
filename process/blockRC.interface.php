<?php


interface BlockRC
{

    public function setRowBlock(array $rowArr);
    public function getRowBlock($index);


    public function setColumnBlock(array $columnArr);
    public function getColumnBlock($index);

}