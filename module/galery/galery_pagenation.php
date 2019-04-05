<div class="galery_container">
<div class="galery">
<?php
    $num = 40;
    $start = 0;
    $page = check_get('n') ? check_get('n') : 0;
    $total = 0;
    $total_row = mysqli_fetch_array(mysqli_query($db_galery, "SELECT COUNT(*) FROM `folder` WHERE `level`='0' "))[0];
    $_news->page_limit($start, $num, $page, $total, $total_row);
    $info = [];
    $result = mysqli_query($db_galery, "SELECT `id` FROM `folder`  WHERE `level`='0' order by id asc LIMIT $start, $num") or die(mysqli_error($link));
    for ($j = 0; $row = mysqli_fetch_array($result); $j++) {
            $_gallery->info_folder($row['id'], $info);
          $_gallery->show_folder($j,$info);
}
echo '</div>';
echo'<div class="pagenation_container">';
 $_news->pageation($page,$total,SITE.'/gallery/page/');
echo'</div>';
?>
