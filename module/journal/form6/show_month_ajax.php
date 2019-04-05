<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';
include $_SERVER['DOCUMENT_ROOT'].'/module/include.php';
$journal = new journal($dbj);

$id_group = check_post('id_group');

$journal->show_month($id_group);

?>