<?php


include "../include.php";
include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';


$check= check_post('check');
$journal = new journal($dbj);
switch ($check){
    
    case "change":
    $group_name = check_post('group_name');
        
    $id_group = check_post('id_group');
    
    $id_teacher = check_post('id_teacher');
    
    $journal->change_group($group_name, $id_teacher, $id_group);
    break;
    
    case "delete":
    $id_group = check_post('id_group');
        
    $journal->delete_group($link,$id_group); 
    break;
        
}
?>