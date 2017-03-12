<?php


class Lang
{

    private $path;
    private $lang;
    private $value;


    public function __construct($lang = null, $path = null)
    {
        if ($this->lang !== null) {
            $this->lang = 'en';
        } else {
            $this->lang = $lang;
        }
        $this->setPath($path);
    }

    /**
     * @@param mixed $path
     */
    public function setPath($path)
    {
        if ($path !== null || $path !== '') {
            $this->path = $path;
        } else {
            $this->path = '';
        }


        $this->setValue();

    }

    /**
     * @return mixed
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param mixed $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
        $this->setValue();
    }

    public function setLangThai()
    {
        $this->lang = 'th';
        $this->setValue();
    }

    public function setLangEng()
    {
        $this->lang = 'en';
        $this->setValue();
    }


    public function getValue($index)
    {
        $this->setValue();
        return $this->value[$index];
    }

    public function getValues()
    {
        $this->setValue();
        return $this->value;
    }

    public function makeSession()
    {
        $_SESSION['lang'] = $this->lang;
        $this->setValue();
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path . '/'. $this->lang . '/textarray.php';
    }


    private function setValue()
    {
        if (isset($_SESSION['lang'])) {
            $this->value = include($this->path . '/'. $_SESSION['lang'] . '/textarray.php');
        } else {
            $this->value = include($this->path . '/'. $this->lang . '/textarray.php');
        }
    }


}