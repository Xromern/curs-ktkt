<?php

include "../include.php";
include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';

$journal = new journal($dbj);
$result = $journal->return_teacher(0, false)?$journal->return_teacher(0, false):('Пусто');
$check = check_post('check');
switch($check){
    case 'one':
        $journal->show_teacher_for_change($result);
    break;

    case 'two':
        $id_group = check_post('id_group');
         $journal->show_curator_for_group($dbj,$result,$id_group);
    break;

    case 'three':
        $id_journal = check_post('id_journal');
        $journal->show_teacher_for_group($dbj,$result,$id_journal);
}


?>
