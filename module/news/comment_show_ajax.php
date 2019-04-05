<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/module/include.php';
$id_news = check_post('id_news');
$result = $_news->comment(" WHERE `id_news`='$id_news' ORDER BY `comment`.`id` DESC");
if(check_post('last_100')){
$result = $_news->comment(" ORDER BY `comment`.`id` DESC LIMIT 100");
}

while($comment = mysqli_fetch_array($result)){
    list($message,$date,$username,$privilege,$id) = $comment;
    
?>

<div class="comment-conatiner">
    <div class="comment">
        <img class="comment-img" src="<?php echo SITE?>/img/user4.png">
        <div class="comment-content">
        <div class="comment-name-user">
            <div class="name-comment"><?php echo login::set_color($privilege,$username);?></div><div class="delete-comment" data-id="<?php echo $id;?>">✘ Видалити</div>
        </div><div class="comment-date"><?php echo $date;?></div>
            <div class="comment-text">
                 <?php echo $message;?>
            </div>           
         </div>
    </div>
</div>
<?php
}
?>