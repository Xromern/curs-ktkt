<?php
include $_SERVER['DOCUMENT_ROOT'].'/module/include.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';
$journal = new journal($dbj);
$id_marks = check_post('id');
echo $id_marks;
$journal->change_missed($id_marks);
?>