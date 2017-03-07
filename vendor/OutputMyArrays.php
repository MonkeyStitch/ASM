<?php

class OutputMyArrays
{

    private $arr;


    public function __construct($array = array())
    {
        $this->arr = $array;
    }


    public function get($id = null)
    {
        if ($id === null) {
            return $this->arr;
        }

        return $this->arr[$id];
    }

    public function transpose(){
        $this->arr = array_map(null, ...$this->arr);
        return $this;
    }

    public function show($text ='', $arr = null)
    {
        if ($arr !== null) {
            $this->arr = $arr;
        }

        if (is_array($arr)) {
            echo '<h4>'.$text.'</h4>';
        }


        if (!is_array($arr)) {
            echo '<h4>'.$text.' : '. $arr .'</h4>';
        } else if (is_array($this->arr) && count($this->arr) && is_array($this->arr[0])) {
            foreach ($this->arr as $value) {
                if (is_array($value)) {
                    echo '[ ';
                    foreach ($value as $value2) {
                        printf('%5s' ,$value2 . ' ');
                    }
                    echo ' ] <br>';
                } else {
                    echo $value . ' ';
                }
            }
        } else if (count($this->arr) === 0) {
            echo '[]';

        } else {
            echo '[ ';
            foreach ($this->arr as $value) {
                printf('%4s' ,$value . ' ');
            }
            echo ' ]';
        }


    }

}