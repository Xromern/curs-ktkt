<link rel="stylesheet" href="<?php echo SITE;?>/css/main_news.css">

<div class='main-news'>             
<div class="left-news">
    

<?php 
$num=9;
$start=0;
$page = check_get('page')?check_get('page'):0;
$total=0;
$total_row = mysqli_fetch_array(mysqli_query($link,"SELECT COUNT(*) FROM news"))[0]; 
$_news->page_limit($start,$num,$page,$total,$total_row);
$result=mysqli_query($link,"SELECT `id`,`caption`,`span`,`date_s`,`img` FROM `news` ORDER BY `id` DESC LIMIT $start, $num")or die(mysqli_error($link));
$img =''; 
    while(list($id,$caption,$span,$date_s,$img)=mysqli_fetch_array($result)){
              $img =(strpos($img, '/'))?SITE.'/'.$img:SITE.'/img/news_img/'.$img;
       
    echo'
<div href="#"class="container-news">
          <div class="block_news">
             <div class="container_img_news">
                <a href="'.SITE.'/news/id/'.$id.'#yacor">
                <img src='.$img.'></a>
             </div>
             <div class="content_news">
                <div class="date_id">
                   <div class="id">'.$id.'</div>
                   <div class="date">'.$date_s.'</div>
                </div>
                <h4><a href="'.SITE.'/news/id/'.$id.'#yacor">'.$caption.'</a></h4>
                <div  class="blcok_news_text">
                   <a href="'.SITE.'/news/id/'.$id.'#yacor">'.$span.'</a>
                </div>
             </div>
    </div>
    </div>';
    
    }
     $_news->pageation($page,$total,SITE.'/news/page/');
    ?> 

<?php
include 'aside.php';
?>     

</div>

</div>