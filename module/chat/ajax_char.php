<?php

include "../include.php";


$message="";
$group_name="";
$id_student="";
$user_name = (isset($_POST['user_name']))?$_POST['user_name']:"";

$group_name = (isset($_POST['group_name']))?$_POST['group_name']:"";

$message = (isset($_POST['message']))?$_POST['message']:"";

$id_student=(isset($_POST['id_student']))?$_POST['id_student']:"";
$id_student=(int)$id_student;
  mysqli_query($link, "INSERT INTO `chat` (`id`, `group`, `id_student`, `text`, `data`) VALUES (NULL, '$group_name', '$id_student', '$message', now());") or die(mysqli_error($link));


?>