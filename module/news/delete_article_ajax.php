<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/module/include.php';
$id = check_post('id');   
echo $id;
if($login->A() || check_article_teacher($id)){    
    $_news->delete_article($id);
}else exit;

?>