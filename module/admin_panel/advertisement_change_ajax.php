<?php
include $_SERVER['DOCUMENT_ROOT'] . '/module/include.php';
if($login->A() || $login->T()){
$text = check_post('text');
$caption = check_post('caption');
$id = check_post('id');
$flag = check_post('flag');

echo $text, $caption, $id, $flag;
switch ($flag) {
    case "change":
            $_news->change_advertisement($id, $caption, $text);
            break;

    case "delete":
            $_news->delete_advertisement($id);
            break;
}
}