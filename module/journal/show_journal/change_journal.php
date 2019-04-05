<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/module/include.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';

$journal = new journal($dbj);
$check = check_post('check');
$id_student=[];
switch ($check){
    
    case "mark":

        $journal->change_mark(check_post('mark'), check_post('id_mark'));
    break;

    case "date":
        $id_date = check_post('id_date');
        $date = check_post('date');
        if($journal->check_date($date, $id_date)){
        $journal->change_date(check_post('decription'),$date, $id_date);
        }else{
            echo "ERROR_DATE";
        }
    break;
    
    case "student_delete":
          $id_journal= check_post('id_journal');
          $id_student[0]= check_post('id_student');
        $journal->delete_marks($id_journal,$id_student[0]);
    break;

    case "student_add":
          $id_journal= check_post('id_journal');
          $id_student[0] = check_post('id_student');
          $journal->generate_marks($id_journal,$id_student);
    break;

    case "change_journal":
        $journal_name = check_post('journal_name');
        $id_teacher = check_post('id_teacher');
        $id_journal = check_post('id_journal');
        
        mysqli_query($dbj, "UPDATE `journal` SET `predmet_name`='$journal_name',`teacher`='$id_teacher' WHERE `id`='$id_journal' ")or die(mysqli_error($dbj));
        
    break;

    case "delete_journal":
    $id_journal = check_post('id_journal');   
    $journal->delete_jounral($id_journal);
    break;
}

?>
