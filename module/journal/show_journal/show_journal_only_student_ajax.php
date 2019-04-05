<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';

if($login->A() || $login->T()  || $login->S()){   
    $journal= new journal($dbj);
    $journal_name = $journal->return_journal(check_get('predmet_id'));
       
}
?>