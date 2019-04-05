<?php


include "../include.php";
include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';


$name = check_post('name_teacher');

$journal = new journal($dbj);
    

$names=explode(' ',$name);

if(count($names)<3){
   exit("error_format");
}
//mysql_insert_id 
$first_name=$names[0];
$last_name = $names[1];
$middle_name = $names[2];

$code = journal::generateRandomString().journal::translit('_'.$first_name.'_'.mb_substr($last_name,0,1).'_'.mb_substr($middle_name,0,1));

$query_code = "INSERT INTO `code`(`code`,`first_name`,`middle_name`,`last_name`,`group_id`,`date_add`,`privilege`,`student_or_teacher`)"
        . "VALUE('$code','$first_name','$middle_name','$last_name','null',now(),'2','Вчитель')";
mysqli_query($link, $query_code)or die(mysqli_error($link));

$id_code=mysqli_insert_id($link);

$query = "INSERT INTO `journal_teacher`(`name`,`id_code`) VALUE('$name','$id_code')";
mysqli_query($dbj, $query)or die(mysqli_error($dbj));
?>

