<?php
include "../include.php";

	$id_news = check_post('id_news');
	
  $username =  $login->get_IdUser(); 
  $text_comment = check_post('text_comment');
  if($text_comment==''){
      exit("error_empty");
  }

  mysqli_query($link,"INSERT INTO `comment` (`id_news`, `id_user`, `message`,`date`) VALUES('$id_news', '{$login->get_IdUser()}', '$text_comment',NOW())")or die(mysqli_error($link));// Добавляем комментарий в таблицу
?>