<?php
if(true){
?>
<style>footer{display: none;}</style>
<div class="conainer_admin_panel">
    <div class="aside_admin_panel">
        <div class="head_aside"></div>
        <div class="menu_list">
             <div class="menu_list_item"><a href="<?php echo SITE;?>/">Головна</a></div>
            <div class="menu_list_item"><a href="<?php echo SITE;?>/index.php?s=admin_panel&panel=add_news">Додати новину</a></div>
            <div class="menu_list_item"><a href="<?php echo SITE;?>/index.php?s=admin_panel&panel=add_advertisement">Додати оголошення</a></div>
            <div class="menu_list_item"><a href="<?php echo SITE;?>/index.php?s=admin_panel&panel=last_comment">Останні коментарі</a></div>

        </div>

    </div>
    <div class="container_panel_content">
        <div class="head_content"></div>
        <div class="admin_panel_conent">

           <?php 
           switch (check_get('panel')){
                case "add_news":
                    include "add_news.php";
                break;

                case "add_advertisement":
                   include "add_advertisement.php";
                break;
                
                case "last_comment":
                   include "last_comment.php";
                break;
           }
           ?>
        </div>

    </div>
</div>


<?php }
  

else
{
    

  //echo '<script>setTimeout(function(){location.replace("index.php");}, 0000)</script>';

}


?>