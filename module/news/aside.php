<div class="right-news"> 
<div class="rgiht-news-caption"><h4>Оголошення</h4></div>
<?php
    $result = mysqli_query($link,"SELECT * FROM advertisement ORDER BY id LIMIT 5");
    while($row=mysqli_fetch_array($result)){
    echo "<div class=\"rgiht-news-block-news\"><div class=\"news_aside\"><h4>".$row['caption']."</h4><hr><div><span>".$row['text']."</span></div></div></div>";
    }
?>
</div>