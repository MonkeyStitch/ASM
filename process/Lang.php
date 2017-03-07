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
        $this->path = $path;
//        var_dump($this->lang);
        $this->value = include($this->path . '/'. $this->lang . '/textarray.php');
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
    }

    public function setLangThai()
    {
        $this->lang = 'th';
    }

    public function setLangEng()
    {
        $this->lang = 'en';
    }


    public function getValue($index)
    {
        return $this->value[$index];
    }

    public function getValues()
    {
        return $this->value;
    }
}