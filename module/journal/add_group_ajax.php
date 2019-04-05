<?php

include "../include.php";
include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';

$group_name = check_post('group_name');
$id_crurator = check_post('id_teacher');

$query = "SELECT * FROM `journal_group` WHERE `group_name`='$group_name'";
$check = mysqli_query($dbj, $query);
if(mysqli_num_rows($check)>0){
    exit("error_08dc4");
}

if($login->A()){
  $journal = new journal($dbj);  
  $journal->add_gruop($id_teacher, $group_name);
}



?>