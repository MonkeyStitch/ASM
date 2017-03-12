<?php

include(__DIR__ . '/process/Lang.php');
//print_r($_SESSION['lang']);echo '<br>';

$lang = new Lang('th', 'lang');

if (isset($_GET['language']) && $_GET['language'] !== '') {
//echo '1';
    // get value
    $val = $_GET['language'];

    if ($val == 'th') {
        $lang->setLangThai();
    }

    if ($val == 'en') {
        $lang->setLangEng();
    }

    $lang->makeSession();
} else if (isset($_SESSION['lang'])) {
//    echo '2';

    if ($_SESSION['lang'] == 'th') {
        $lang->setLangThai();
    }

    if ($_SESSION['lang'] == 'en') {
        $lang->setLangEng();
    }
    $lang->makeSession();
} else {
//    echo '3';

    $lang->setLangEng();
    $lang->makeSession();
}




//echo '<pre>';
//print_r($_POST);
//print_r($_SESSION['lang']);echo '<br>';
//print_r($lang->getLang());echo '<br>';
//print_r($lang->getPath());echo '<br>';
//print_r($lang->getValues());
//print_r($lang->getPath());
