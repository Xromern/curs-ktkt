<?php


$navigation= isset($_GET['navigation']) ?(trim($_GET['navigation'])):"";

$result=mysqli_query($link,"SELECT `title`,`span` FROM site_navigation where url='$navigation'") or die(mysqli_error($link)); 

list($title,$span)=mysqli_fetch_array($result);
?>
<div class="info-college">
    <?php echo $span;?>
</div>
<?php



?>