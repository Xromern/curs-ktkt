<?php
include "../include.php";
include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';



$flag = check_post('flag');
$id_teacher = check_post('id_teacher');

$query_admin = "SELECT `journal_group`.`id` AS `id_group`,"/*Вывод групп для админа*/
        . "`journal_group`.`group_name` as `group_name`  FROM `journal_group` ORDER BY `journal_group`.`group_name` ASC";

function query_curator($id_teacher){
    $query_curator = "SELECT `journal_group`.`id` AS `id_group`,"/*Вывод групы для куратора*/
        . "`journal_group`.`group_name` as `group_name`  FROM `journal_group` WHERE `journal_group`.`curator`='$id_teacher' ORDER BY `journal_group`.`group_name` ASC";
    return $query_curator;
}


    function query_teacher($id_teacher){/*Вывод групп для учителя*/
        $query_teacher = "SELECT DISTINCT "
    . "`journal_group`.`id` AS `id_group`,"
    . "`journal_group`.`group_name` AS `group_name` "
    . "FROM `journal_group` "
    . "INNER JOIN `journal` ON `journal_group`.`id`=`journal`.`group_name` "
    . "INNER JOIN `journal_teacher` ON `journal_teacher`.`id` = `journal`.`teacher` "
    . "WHERE `journal_teacher`.`id`='{$id_teacher}' ORDER BY `journal_group`.`group_name` ASC";

    return $query_teacher;
    }
        

if($login->A()){
show_group($dbj,$query_admin);
}elseif($login->T()){

    group_curator($dbj,$login);
   
    show_group($dbj,query_teacher($login->get_IdTeacher()));
}

function group_curator($dbj,$login){
    
   $journal = new journal($dbj);
   $result = mysqli_query($dbj, query_curator($login->get_IdTeacher()))or die(mysqli_error($dbj));
   if(mysqli_num_rows($result)>0){
       $temp=0;
       $row = mysqli_fetch_array($result);
                   $href = SITE.'/group/'.$row['id_group'];
              if($temp!=mb_substr($row['group_name'], 0, 2) && $i!=0){
                  $br='<div class="abr_group">'.mb_substr($row['group_name'], 0, 2).'</div><br>';
              }else $br = "";

               echo $br.'<a href="'.$href.'" class="container_group">
                       <div class="logo_group">'.$row['group_name'].'</div>
                       <div class="info_group"><div>Куратор:</div> <div>'.$journal->return_teacher_name($login->get_IdTeacher()).' </div></div>
                    </a>';
              $temp = mb_substr($row['group_name'], 0, 2);
   }
}

function show_group($link,$query){    
    $journal = new journal($link);
    if(mysqli_num_rows(mysqli_query($link, $query))>0){
        $result = mysqli_query($link, $query)or die(mysqli_error($link));
        $temp=0;               
        $first = mysqli_fetch_assoc($result);
                  $href = SITE.'/group/'.$first['id_group'];
        $br = mb_substr($first['group_name'], 0, 2);
        $br= '<div class="abr_group">'.mb_substr($first['group_name'], 0, 2).'</div><br>';
        echo $br.'<a href="'.$href.'" class="container_group">
                       <div class="logo_group">'.$first['group_name'].'</div>
                       <div class="info_group"><div>Куратор:</div> <div>'.$journal->return_group($first['id_group'],false)['curator_name'].' </div></div>
                    </a>';

        for($i=0;$row = mysqli_fetch_array($result);$i++){
                  $href = SITE.'/group/'.$row['id_group'];
              if($temp!=mb_substr($row['group_name'], 0, 2) && $i!=0){
                  $br='<div class="abr_group">'.mb_substr($row['group_name'], 0, 2).'</div><br>';
              }else $br = "";

               echo $br.'<a href="'.$href.'" class="container_group">
                       <div class="logo_group">'.$row['group_name'].'</div>
                       <div class="info_group"><div>Куратор:</div> <div>'.$journal->return_group($row['id_group'],false)['curator_name'].' </div></div>
                    </a>';
              $temp = mb_substr($row['group_name'], 0, 2);
        }
    }
}

?>
