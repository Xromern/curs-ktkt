<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/module/include.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/journal/download/Classes/PHPExcel.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/journal/download/Classes/PHPExcel/Writer/Excel5.php';

if($login->S()){
    $check="one";
}else
$check = check_get('check');

// Создаем объект класса PHPExcel

$xls = new PHPExcel();
$journal = new journal();

$xls->setActiveSheetIndex(0);
// Получаем активный лист
$sheet = $xls->getActiveSheet();

switch ($check){
    
    case "all":
    $id_group =  check_get('id_group');
    $id_predmet =check_get('id_predmet');
    $name_group = mysqli_fetch_array(mysqli_query($dbj, "SELECT `group_name` FROM `journal_group`  WHERE `id`='$id_group'"))['group_name'];
    $name_predmet = mysqli_fetch_array(mysqli_query($dbj, "SELECT `predmet_name` FROM `journal`  WHERE `id`='$id_predmet'"))['predmet_name'];
    $name = journal::translit($name_group).'_'.journal::translit($name_predmet);
    $name = str_replace(' ','_',$name);
    $sheet->setTitle(journal::translit($name_group));
    $teacher = mysqli_fetch_array(mysqli_query($dbj, "SELECT `teacher` FROM `journal`  WHERE `id`='$id_predmet'"))['teacher'];
    $teacher_name = $journal->return_teacher_name($teacher);
    head($sheet,$name_predmet." ($teacher_name)");
    date_show($dbj,$id_predmet,$sheet);
    row_student($dbj,$id_predmet,$sheet);
    break;

    case "one":
        if($login->S()){
            $id_student=$login->get_IdStudent();
        }else
    $id_student = check_get('id_student');
    $name = journal::translit(mysqli_fetch_array($journal->return_stundent(false,$id_student))['name_student']); 
    $name = str_replace(' ','_',$name);
    $sheet->setTitle(journal::translit($name));

    $query = "SELECT DISTINCT`journal`.`id` AS `id`,`journal`.`teacher` as `teacher` "
    . "FROM `journal_marks` INNER JOIN `journal_student` "
    . "ON `journal_student`.`id` = `journal_marks`.`id_student` INNER JOIN `journal` "
    . "ON `journal`.`id`=`journal_marks`.`id_journal`WHERE `journal_marks`.`id_student` = '$id_student'";
    $result = mysqli_query($dbj, $query);
    for($i=0;$row = mysqli_fetch_array($result);$i++){
    $name_predmet = mysqli_fetch_array(mysqli_query($dbj, "SELECT `predmet_name` FROM `journal`  WHERE `id`='{$row['id']}'"))['predmet_name']; 
    $teacher_name = $journal->return_teacher_name($row['teacher']);
    head($sheet,$name_predmet." ($teacher_name)");
    date_show($dbj,$row['id'],$sheet,$i!=0?$sheet->getHighestRow()-2:0);
    row_student($dbj,$row['id'],$sheet,$i!=0?$sheet->getHighestRow()-3:0,$id_student);

    } 
    break;
}

function head($sheet,$name_predmet){
    $rows = $sheet->getHighestRow()==1?$sheet->getHighestRow():$sheet->getHighestRow()+1;
    
    $sheet->setCellValue("A".$rows, set_utf8($name_predmet));
    $sheet->mergeCells('A'.$rows.':AF'.$rows);//Объединение  ячейки
    c_setHorizontal($sheet, 'A'.$rows);
    $rows+=1;
    $sheet->setCellValue("A".$rows, set_utf8('id'));
    $row = ($rows==1)?$rows+2:$rows+1;
    $sheet->mergeCells('A'.$rows.':A'.$row);//Объяденение ячеек //HORIZONTAL_LEFT
    c_setHorizontal($sheet, 'A'.$rows);
    c_setVertical($sheet, 'A'.$rows);
    $sheet->getColumnDimension('A')->setWidth(3); //Ширина ячейки
    $sheet->getStyle("A".$rows)->getFont()->setBold(true);    //Шрифт жирным

    $sheet->setCellValue("B".$rows, set_utf8('Прізвище та ініціали'));
    $row = ($rows==1)?$rows+2:$rows+1;
    $sheet->mergeCells('B'.$rows.':B'.$row);//Объединение  ячейки
    c_setHorizontal($sheet, 'B'.$rows);
    c_setVertical($sheet, 'B'.$rows);
    $sheet->getColumnDimension('B')->setWidth(25);
    $sheet->getStyle("B".$rows)->getFont()->setBold(true);

    $sheet->setCellValue("C".$rows, set_utf8('Місяць, число'));
    $sheet->mergeCells('C'.$rows.':AF'.$rows);//Объединение  ячейки
    c_setHorizontal($sheet, 'C'.$rows);
    c_setVertical($sheet, 'C'.$rows);
    $sheet->getStyle("C".$rows)->getFont()->setBold(true);
}

function date_show($dbj,$id_predmet,$sheet,$row=0){
    $query = "SELECT * FROM `journal_date` WHERE `id_journal` = '$id_predmet'";

    $result_date_journal = mysqli_query($dbj, $query) or die(mysqli_error($dbj));

    for ($i = 2; $row_date_journal = mysqli_fetch_array($result_date_journal); $i++) {// date

            $colString = PHPExcel_Cell::stringFromColumnIndex($i);

            $sheet->setCellValueByColumnAndRow($i, 3+$row/*Рядок*/, journal::convert_date($row_date_journal['date']));

            $sheet->mergeCells($colString . (1) . ":" . $colString . (2));
            $sheet->getColumnDimension($colString)->setWidth(3); 
      //  $sheet->getColumnDimension($colString)->getAlignment()->setVertical(
       // PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }
}

 
function row_student($dbj,$id_predmet,$sheet,$row=0,$id_students=false){
    $query = "SELECT DISTINCT journal_marks.id_student,journal_student.name_student FROM"
    . " `journal_marks` INNER JOIN `journal_student` on journal_student.id = journal_marks.id_student"
    . " WHERE journal_marks.id_journal = '$id_predmet' ";

    if($id_students!=false){
        $query.=" AND `journal_marks`.`id_student`='$id_students'";
    }elseif($id_students==false) {
        $query.=" ORDER BY `journal_student`.`name_student` ASC";
    }  
    $result_student = mysqli_query($dbj, $query) or die(mysqli_error($dbj));
    for ($i = 4; $row_result_student = mysqli_fetch_array($result_student); $i++) {// Студенты
            $id_student = $row_result_student['id_student'];
            $name_student = $row_result_student['name_student'];
            $sheet->setCellValueByColumnAndRow(0, $i+$row/*Рядок*/, $i - 3);
            $sheet->setCellValueByColumnAndRow(1, $i+$row/*Рядок*/, journal::split_name($name_student));
            $query_marks = "SELECT  * FROM `journal_marks` WHERE `id_journal`='$id_predmet' and `id_student` = '$id_student' ";

            $result_marks = mysqli_query($dbj, $query_marks);

            for ($j = 2; $row_marks = mysqli_fetch_array($result_marks); $j++) {
                    $mark = $row_marks['mark'];
                    $sheet->setCellValueByColumnAndRow($j, $i+$row, $mark/*.$sheet->getHighestRow()*/);
                     c_setHorizontal($sheet, $i+$row);
            }
    }

}

$sheet->getDefaultStyle()->getAlignment()->setWrapText(true);

function c_setHorizontal($sheet, $coordinates)
{
    $sheet->getStyle($coordinates)->getAlignment()->setHorizontal(
            PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    );
}

function c_setVertical($sheet, $coordinates)
{
    $sheet->getStyle($coordinates)->getAlignment()->setVertical(
            PHPExcel_Style_Alignment::VERTICAL_CENTER
    );
}

function set_utf8($string)
{
    return /*iconv('windows-1251', 'utf-8', $string)*/$string;
}
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="journal-'.$name.'.xls"');
header('Cache-Control: max-age=0');
// Выводим содержимое файла
$objWriter = new PHPExcel_Writer_Excel5($xls);
$objWriter->save('php://output');
