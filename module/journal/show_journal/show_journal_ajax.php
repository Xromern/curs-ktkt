<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/module/include.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';


$id_journal = check_post('predmet_id');

$check = check_post('check');

$journal = new journal($dbj);

if($login->S()){
    all_journal_for_student($login->get_IdStudent(),$journal);
    exit;
}

switch ($check){
    case "one_jounral":
        echo '<table>';
        echo '<caption>'.$journal->return_journal($id_journal).'</caption>';
        $journal->show_head_journal($id_journal);
        $journal->show_row($id_journal);
        echo '</table>';
    break;

    case "all_journal":
        $id_student = check_post('id_student');
        all_journal_for_student($id_student,$journal);
    break;
}

function all_journal_for_student($id_student,$journal){
    
    $query = "SELECT DISTINCT `id_student`,`id_journal` FROM `journal_marks` WHERE `id_student`='$id_student'";
    $result = mysqli_query($journal->dbj(), $query);
    while($id = mysqli_fetch_array($result)){
        echo '<table>';
        echo '<caption>'.$journal->return_journal($id['id_journal']).'</caption>';
        $journal->show_head_journal($id['id_journal']);
        $journal->show_row($id['id_journal'],$id_student);
        echo '</table>';
        echo '<hr>';
    }
}

?>
