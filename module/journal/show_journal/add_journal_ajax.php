<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/module/include.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';

$string_student = check_post('string_id');

$predmet_name = check_post('journal_name');

$id_teacher = check_post('id_teacher');

$id_group = check_post('id_group');

$journal = new journal($dbj);

$student = explode('*%%*', $string_student);
var_dump($student);
$journal->generate_journal($id_teacher,$predmet_name,$id_group,$student);


?>
