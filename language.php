<?php

include(__DIR__ . '/process/Lang.php');

$lang = new Lang('th', 'lang');

if (isset($_GET['language']) && $_GET['language'] != '') {

    // get value
    $val = $_GET['language'];

    if ($val == 'th') {
        $lang->setLangThai();
    }

    if ($val == 'en') {
        $lang->setLangEng();
    }
}
