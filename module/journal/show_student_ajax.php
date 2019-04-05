<?php

include "../include.php";
include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';

$id_group = check_post('id_group');
$check = check_post('check');
$journal = new journal($dbj);
$result = $journal->return_stundent($id_group, false)?$journal->return_stundent($id_group, false):exit("Сталася помилка");

switch ($check){
    case "one":
        $journal->show_student_for_change($result);
    break;

    case "two":
        $journal->show_student_for_add_journal($id_group);
    break;

    case "three":
    $id_journal  = check_post('id_journal');
    $journal->show_student_for_journal($dbj,$id_journal,$journal,$id_group);
    break;
}

?>