<?php
include $_SERVER['DOCUMENT_ROOT'].'/module/include.php';

$img = $_news->upload_image();
$title = check_post('title');
$description = check_post('description');
$textarea= mysqli_real_escape_string($link,check_post('text'));
$id= check_post('id');
$_news->change_news($id,$title,$description,$textarea,$img);

?>