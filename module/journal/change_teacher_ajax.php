<?php

include "../include.php";
include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';

$id_teacher = check_post('id_teacher');
$id_code = check_post('id_code');
$name = check_post('name');
$code = check_post('code');
$action = check_post('action');
$journal = new journal($dbj, $link);
if($login->A()){
    switch ($action){
        case 'delete':
            $journal->delete_teacher($link, $id_teacher, $id_code);
        break;
    
        case 'change':
            $journal->change_teacher($link, $id_code, $id_teacher, $name, $code);
        break;
    }
  
}




?>
