<?php
include "../include.php";

$group =isset($_POST['group'])?$_POST['group']:"";

$result = mysqli_query($link, "SELECT * FROM `chat` where `group` = '$group' ")or die(mysqli_error($link)); 

while($row = mysqli_fetch_array($result)){
	$id=$row['id_student']; 
        $data_id=$row['id'];
	$user_name = mysqli_query($link, "select `username`,`id_code` from users_login where `id` = '$id'  ")or die(mysqli_error($link));
         $id_code = mysqli_fetch_array($user_name)['id_code'];
         $user_name = mysqli_query($link, "select `username`,`id_code` from users_login where `id` = '$id'  ")or die(mysqli_error($link));
        $user_name = mysqli_fetch_array($user_name)['username'];
       
        
        $ava = mysqli_fetch_array(mysqli_query($link, "select last_name,first_name from `code` where `id` = '$id_code' limit 1"));
        $first_letter= mb_substr($ava['first_name'], 0, 1,'UTF8');
        $last_letter= mb_substr($ava['last_name'], 0, 1,'UTF8');
	echo '	<div class="message_chat" data-id='.$data_id.'>
                <div class="img_message">'.$last_letter.$first_letter.'</div>
		<div class="container_message">
			<div class="message_name">'.$user_name.'</div>
			
			<div class="message_data">'.$row['data'].'</div>
			
			<div class="message">'.$row['text'].'
			</div>
		</div>
		
		</div>';
}


?>