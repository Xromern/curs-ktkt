<?php
include "../include.php";
if($login->A() || $login->T()){
$img = $_news->upload_image();
$title = check_post('title');
$description = check_post('description');
$textarea = mysqli_real_escape_string($link, check_post('textarea'));

$_news->add_news($title, $description, $textarea, $img);

$id = mysqli_insert_id($link);
$href = SITE . '/news/id/' . $id . '#yacor';
$jsonData = array(
	"url" => $href,
	"error" => error_get_last()

);
exit(json_encode($jsonData));
}