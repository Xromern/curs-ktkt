<?php
include $_SERVER['DOCUMENT_ROOT'] . '/module/include.php';
if($login->A() || $login->T()){

$caption = check_post('title');
$text = check_post('text');

if ($caption == "" || $text == "") {
	$jsonData = array(
		"error" => true,
		"text" => "Заповніть всі поля"
	);
	exit(json_encode($jsonData));
}

$_news->add_advertisement($caption, $text);

$jsonData = array(
	"error" => false,
	"text" => "Оголошення додано."
);
exit(json_encode($jsonData));
}