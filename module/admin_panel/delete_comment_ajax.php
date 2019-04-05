<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/module/include.php';

if($login->A() || $login->T()){
$id = check_post('id');
$_news->delete_comment($id);
}

?>