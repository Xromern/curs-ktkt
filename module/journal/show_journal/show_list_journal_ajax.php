<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/module/include.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';

$id_group = check_post('id_group');
$journal = new journal($dbj);

$query = "SELECT"
    . "`journal_teacher`.`name`as teacher,"
    . "`journal`.`predmet_name` as predmet,"
    . "`journal`.`id` as id_predmet FROM `journal` "
    . "INNER JOIN `journal_group` ON `journal_group`.`id`=`journal`.`group_name`"
    . "INNER JOIN `journal_teacher` ON `journal_teacher`.`id`=`journal`.`teacher`"
    . " WHERE `journal`.`group_name`=$id_group" ;

if($login->T()){
    if($journal->check_curator($login->get_IdTeacher(), $id_group)){
 
    }else{
      $query.=" AND `journal`.`teacher`='{$login->get_IdTeacher()}'";  
    }
}
$result = mysqli_query($dbj, $query)or die(mysqli_error($link));
while($row = mysqli_fetch_array($result)){
    $href = SITE."/group".$id_group.'/predmet/'.$row['id_predmet'];
 echo '<a href="'.$href.'" class="container_group">
                <div class="name_predmet">'.$row['predmet'].'</div>
                <div class="info_group"><div>Вчитель:</div> <div>'.$row['teacher'].' </div></div>
      </a>';
}

?>
