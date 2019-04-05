<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/module/include.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/journal/download/Classes/PHPExcel.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/journal/download/Classes/PHPExcel/Writer/Excel5.php';
$id_group = check_get('id_group');
$date = check_get('date');
$journal= new journal();
$xls = new PHPExcel();
$xls->setActiveSheetIndex(0);
$sheet = $xls->getActiveSheet();
 $check = check_get('id_student')?"one":"all";
 $name="";
switch($check){
    case "all":
    head_form6_excel($sheet, $date.'-('.journal::case_month($date).')');
    show_missed($dbj,$sheet,$id_group,$date);
    
    $name="form6_".journal::translit($journal->return_group_name($id_group)).'_'.$date.'-('.journal::translit(journal::case_month($date)).')';
    break;
    
    case "one":
   $id_student = check_get('id_student');
    $result = mysqli_query($dbj, journal::query_montm_form6($id_group));
    while($row = mysqli_fetch_array($result)){
        head_form6_excel($sheet,$row['date'].'-('.journal::case_month($row['date']).')');
        show_missed($dbj,$sheet,$id_group,$row['date'],$id_student);
    }
    $name = "form6_".journal::translit(mysqli_fetch_array($journal->return_stundent(false,$id_student))['name_student']);
    break;
}
function head_form6_excel($sheet,$name){
    $rows = $sheet->getHighestRow()==1?$sheet->getHighestRow():$sheet->getHighestRow()+2;
    
    $sheet->setCellValue("A".$rows, $name);
    $sheet->mergeCells('A'.$rows.':AF'.$rows);//Объединение  ячейки
    $sheet->getStyle('A'.$rows)->getAlignment()->setHorizontal(
            PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
    $rows++;
    $sheet->setCellValue("A".$rows, "П\П");
    $sheet->getColumnDimension('A')->setWidth(5);//Ширина для столбика с id.
    $sheet->getStyle("A".$rows)->getFont()->setBold(true);//Жирный шрифт.              
    $sheet->setCellValue("B".$rows, "Прізвище");
    $sheet->getColumnDimension('B')->setWidth(30);//Ширина для столбика с фамилией.
    $sheet->getStyle("B".$rows)->getFont()->setBold(true);//Жирный шрифт.
    $sheet->getStyle('B'.$rows)->getAlignment()->setHorizontal(
            PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    
    for($i=1;$i<=31;$i++){
        $sheet->setCellValueByColumnAndRow($i+1/*Стлбик*/, $rows/*Строка*/, $i/*Значение*/);//Выводй дней месяця.
        $colString = PHPExcel_Cell::stringFromColumnIndex($i+1);//Преобразование числового индекса в буквенный.
        $sheet->getColumnDimension($colString)->setWidth(3);//Ширина ячейки.
    }
    $sheet->setCellValueByColumnAndRow(32/*Столбик*/, $rows/*Строка*/, "Пропущено");
            $colString = PHPExcel_Cell::stringFromColumnIndex(32);//Преобразование числового индекса в буквенный.
        $sheet->getColumnDimension($colString)->setWidth(12);//Ширина ячейки.
}

function show_missed($dbj,$sheet,$group,$date,$id_student = false){
    $all_missed=0;
    $rows = $sheet->getHighestRow()+1;
    $query = "SELECT * FROM `journal_student` WHERE `group_name`='$group'";  
    if($id_student!=false){
          $query .= " AND `id`='$id_student' ";
    }elseif($id_student==false){
        $query .= " ORDER BY `name_student` ASC";
    }
    
    $result = mysqli_query($dbj, $query)or die(mysqli_error($dbj));
    for($i=1,$c=$rows;$row = mysqli_fetch_array($result);$i++,$c++){
        $missed=0;
        $id_student = $row['id'];
        $name = explode(" ",$row['name_student']);
        $sheet->setCellValue("A".$c, $i);
        $sheet->setCellValue("B".$c, $name[0].' '.$name[1]);
        for($j=1;$j<31;$j++){
            $date2 = ($j>=10)?$date.'-'.$j:$date.'-'.'0'.$j;
            $result2 = mysqli_query($dbj, journal::missed_query($date2, $id_student))or die(mysqli_error($dbj));          
            if(mysqli_num_rows($result2)>0){
            $number_of_hours = mysqli_num_rows($result2)*2;
            $styleArray = array(
            'font'  => array(       
            'color' => array('rgb' => colorCell_date($result2)),
            ));
            $sheet->setCellValueByColumnAndRow($j+1/*Столбик*/, $c/*Строка*/, $number_of_hours);
            $sheet->getCellByColumnAndRow($j+1/*Столбик*/, $c/*Строка*/)->getStyle()->applyFromArray($styleArray);
            $rows = $sheet->getHighestRow()+1;
            $all_missed+=$number_of_hours;  
            $missed += $number_of_hours;
            }       
        }            
        $sheet->setCellValue("AG".$c, $missed);
    }  
    if($id_student==false){
    $rows = $sheet->getHighestRow()+1;  
    $sheet->mergeCells('A'.$rows.':AC'.$rows);//Объединение  ячейки
    $sheet->mergeCells('AD'.$rows.':AF'.$rows);
    $sheet->setCellValue("AD".$rows, "Всього");
    $sheet->setCellValue("AG".$rows, $all_missed);
    }
}

    function colorCell_date($result){//Пропущенные предметы, цвет для ячейки, id 
        $flag=false;
        $color="";
        while($row2 = mysqli_fetch_array($result)){      
            if($row2['missed']==0){
                $color='#ff0000';
                $flag = true;
            }elseif($row2['missed']==1){
                if($flag==false) $color='#00ff3f';
            }
        }

        return $color;
    }
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$name.'.xls"');
header('Cache-Control: max-age=0');
// Выводим содержимое файла
$objWriter = new PHPExcel_Writer_Excel5($xls);
$objWriter->save('php://output');