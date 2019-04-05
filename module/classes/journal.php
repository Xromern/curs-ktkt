<?php
include 'form6.php';
class journal extends form6{
    
    protected $db;
    
    
    function __construct() {
        $this->db = mysqli_connect("release","mysql","mysql","ktkt_journal")or die(mysqli_error());;
    }
    
    public function dbj(){
        return $this->db;
    }
    public function return_group($id,$flag = true){
        $query="SELECT "
            . "`journal_group`.`id` AS `id_group`,"
            . "`journal_group`.`group_name` AS `group_name`,"
            . "`journal_teacher`.`id` AS `id_curator`,"
            . "`journal_teacher`.`name` AS `curator_name` "
            . " FROM `journal_group` INNER JOIN `journal_teacher` ON `journal_group`.`curator` = `journal_teacher`.`id` ";
        if($flag){
        $result = mysqli_query($this->db,$query);
        return mysqli_fetch_array($result);
        }elseif($flag==false){
        $result = mysqli_query($this->db,$query."WHERE `journal_group`.`id` = '$id'")or die(mysqli_error($this->db));
        return mysqli_fetch_array($result);
        }
    }
    
    public function return_group_name($id){/*Возращение название группы.*/
        $query = "SELECT `group_name`FROM `journal_group` WHERE `id`='$id'";
        $result = mysqli_fetch_array(mysqli_query($this->db, $query))['group_name'];
        return $result;
        
    }
    
    public function return_teacher($id,$flag=true){/*Если true, то вивод информации о учителе по id,
                                                   если false, то вывод всех. */
        $sorting = " ORDER BY `name` ASC";
        $query="SELECT `ktkt_main`.`code`.`code` AS `code`, 
                `ktkt_main`.`code`.`_use` AS `_use`,
                 `ktkt_main`.`code`.`date_use` AS `date_use`,
                 `ktkt_main`.`code`.`date_add` AS `date_add`,
                `ktkt_main`.`code`.`id` AS `id_code`,
                `journal_teacher`.`name` AS `name_teacher`,
                 `journal_teacher`.`id` AS `id_teacher`  
                FROM
                 `journal_teacher` left JOIN `ktkt_main`.`code` ON `ktkt_main`.`code`.`id`=`journal_teacher`.`id_code`";
        if($flag){
        $result = mysqli_query($this->db,$query." WHERE `id_teacher` = '$id'".$sorting);
        return mysqli_fetch_array($result);
        }
        elseif($flag==false){
        $result = mysqli_query($this->db,$query.$sorting);    
        return $result;
        }
    }
    
    public function return_teacher_name($id){//получение имени учетеля 
        $query = "SELECT `name` FROM `journal_teacher` WHERE `id`='$id'";
        $result= mysqli_query($this->db, $query)or die(mysqli_error($this->db));
        return mysqli_fetch_array($result)['name'];
    }
    
    public function check_curator($id_teacher,$id_group){//проверка на куратора
        $query = "SELECT * FROM `journal_group` WHERE `id`='$id_group' and `curator`='$id_teacher'";
        $result = mysqli_num_rows(mysqli_query($this->db, $query))>0?true:false;
        return $result; 
    }
    
    public function access_curator($id_group,$id_teacher,$id_predmet){
        if($this->check_curator($id_teacher,$id_group)==true && $this->check_teacher($id_teacher,$id_predmet)==false){
            return false;
        }elseif($this->check_curator($id_teacher,$id_group)==true && $this->check_teacher($id_teacher,$id_predmet)==true){
            return true;
        }
    }
    
    public function check_teacher($id_teacher,$id_predmet){/*Проверка на учителя для журнала*/
        $query = "SELECT * FROM `journal` WHERE `id`='$id_predmet' and `teacher`='$id_teacher'";
        $result = mysqli_num_rows(mysqli_query($this->db, $query))>0?true:false;
        return $result; 
    }
    
    function show_teacher_for_change($result){/*Вывод всех учителей*/
    for($i=1;$row = mysqli_fetch_array($result);$i++){

        echo '<tr class="tr-teacher-leavel-one" data-id-code="'.$row['id_code'].'" data-id-teacher="'.$row['id_teacher'].'">';
        echo '<td class="show-teacher-name"><input value="'.$row['name_teacher'].'"></td>';
        echo '<th style="text-align:right;">Код: </th><td class="show-teacher-code"><input value="'.$row['code'].'"></td>';
        echo "</tr>";

        echo '<tr class="tr-teacher-leavel-two" data-id-code="'.$row['id_code'].'" data-id-teacher="'.$row['id_teacher'].'">';
        echo '<td><br><div class="button_journal change" >Змінити</div><div class="button_journal delete" style="margin-left:10px;">Видалити</div></td>';
        echo '<td class="show-teacher-use" colspan="2">Дата реєестрації: '.(($row['date_use'])!=null?$row['date_use']:"-").'</td>';  
        echo '</tr>';

        echo '<tr><td colspan="3"><br><hr style="border:1px solid #999"><br></td></tr>';
        }
    }

    public function show_curator_for_group($dbj,$result,$id_group=0){/**/
        $query= "SELECT `curator` FROM `journal_group` WHERE `id`='$id_group'";
        $id_teacher = mysqli_fetch_assoc(mysqli_query($dbj, $query))['curator'];
        $this->selected_tecaher($result,$id_teacher);  
    }

    public function show_teacher_for_group($dbj,$result,$id_journal){/**/
        $query= "SELECT `teacher` FROM `journal` WHERE `id`='$id_journal'";
        $id_teacher = mysqli_fetch_assoc(mysqli_query($dbj, $query))['teacher'];
        $this->selected_tecaher($result,$id_teacher);  
    }

    public function selected_tecaher($result,$id_teacher){
           while($row = mysqli_fetch_array($result)){
           if($row['id_teacher']==$id_teacher)
           echo '<option selected value="'.$row['id_teacher'].'">'.$row['name_teacher'].'</option>';
           else
           echo '<option value="'.$row['id_teacher'].'">'.$row['name_teacher'].'</option>';
       } 
    }
    public function return_journal($id_journal){/*Возращение название жрунала*/
        $query  = "SELECT `predmet_name` FROM `journal` WHERE `id`='$id_journal'";
        $result = mysqli_query($this->db, $query)or die(mysqli_error($this->db));
        return mysqli_fetch_assoc($result)['predmet_name'];
    }
    
    public function return_marks($id_student,$id_journal){/*Возращение оценок, по id студента и id журнада*/
        
        $result = mysqli_query($this->db,"SELECT 
        `journal_marks`.`mark` AS `mark`,
        `journal_marks`.`date_change` AS `date_change`,
        `journal_date`.`number` AS `number`,
        `journal_date`.`date` AS `date`,
        `journal_date`.`description` AS `description`
        FROM       
        `journal_marks` INNER JOIN `journal_date` ON `journal_marks`.`id_date`=`journal_date`.`id`
        WHERE `journal_marks`.`id_student` = '$id_student' AND `journal_marks`.`id_journal`='$id_journal'");
    
    return mysqli_fetch_array($result);
    
    }
    
    public function return_stundent($id_group,$id_student){/*Если $id_group != false, то вывод всех студентов для группы, 
                                                            Если $id_student != false, то вывод студента.*/
        $sorting = " ORDER BY `name_student` ASC ";
        $query = "SELECT `ktkt_main`.`code`.`code`AS `code`, "
        . "`ktkt_main`.`code`.`_use` AS `_use`,"
        . " `ktkt_main`.`code`.`date_use` AS `date_use`,"
        . " `ktkt_main`.`code`.`date_add` AS `date_add`,"
        . "`ktkt_main`.`code`.`id` AS `id_code`,"
        . " `journal_student`.`name_student` AS `name_student`,"
        . " `journal_student`.`id` AS `id_student`,  "
        . " `journal_student`.`group_name` AS `id_group`  "
        . "FROM"
        . " `journal_student` LEFT JOIN `ktkt_main`.`code` ON `ktkt_main`.`code`.`id`=`journal_student`.`id_code`";
        
        if($id_group!=false){
        return  mysqli_query($this->db,$query." WHERE `journal_student`.`group_name`='$id_group' ".$sorting);
        }
        elseif(false !=$id_student){
        return  mysqli_query($this->db,$query." WHERE `journal_student`.`id`='$id_student' ".$sorting);
        }      
    }
    
    public function show_student_for_change($result){
        if(mysqli_num_rows($result)==0){
            exit("В даній грпуі студентів ще немає.");
        }
        for($i=1;$row = mysqli_fetch_array($result);$i++){
        echo '<tr class="tr-student-leavel-one" data-id-code="'.$row['id_code'].'" data-id-student="'.$row['id_student'].'">';
        echo '<td class="show-student-name"><input value="'.$row['name_student'].'"></td>';
        echo '<th style="text-align:right;">Код: </th><td class="show-student-code"><input value="'.$row['code'].'"></td>';
        echo "</tr>";

        echo '<tr class="tr-student-leavel-two" data-id-code="'.$row['id_code'].'" data-id-student="'.$row['id_student'].'">';
        echo '<td><br><div class="button_journal change" >Змінити</div><div class="button_journal delete" style="margin-left:10px;">Видалити</div></td>';
        echo '<td class="show-student-use" colspan="2" rowspan="2">Дата реєестрації: '.(($row['date_use'])!=null?$row['date_use']:"-").'</td>';  
        echo '</tr>';
        echo '<tr>';
        $form6 = SITE."/formS/student/{$row['id_student']}";
        $journal = SITE."/journal/student/{$row['id_student']}";
        echo '<td><br><div class="button_journal" ><a href='.$form6.'>Форма 6</a></div><div class="button_journal" style="margin-left:10px;"><a href='.$journal.'>Журнали</a></div></td>';
        echo '</tr>';
        echo '<tr><td colspan="3"><br><hr style="border:1px solid #999"><br></td></tr>';
        }
    }

    public function show_student_for_add_journal($id_group){
        $result = $this->return_stundent($id_group, false);
        for($i=1;$row = mysqli_fetch_array($result);$i++){
            echo '<tr data-id-student="'.$row['id_student'].'">';
            echo '<td style="padding:0px; text-align:center;">'.$i.'</td>';
            echo '<td>'.$row['name_student'].'</td>';
            echo '<td class="rewmove-student">Х</td>';
            echo '</tr>';
        }
    }

    public function show_student_for_journal($dbj,$id_journal,$journal,$id_group){
        $query = "SELECT  DISTINCT"
            . " `journal_student`.`id` as `id_student`, "
            . " `journal_student`.`name_student` as `name_student`, "
            . " `journal_student`.`group_name` as `id_group`, "    
            . "`journal_marks`.`id_journal` as `id_journal`"
            . "FROM `journal_marks` right JOIN `journal_student` ON"
            . " `journal_marks`.`id_student`=`journal_student`.`id` WHERE `id_journal`='$id_journal' ORDER BY `name_student` ASC";
        $array =[];
        $it = 0;
        $result = mysqli_query($this->db, $query);
        $this->show_student_for_journa_yes($result,$array,$it);

        $result = $this->return_stundent($id_group, false);
        $this->show_student_for_journal_no($result,$array,$it);
    }
    public function show_student_for_journa_yes($result,&$array,&$it){
        echo ' <table class="student_ student_yes">';
        for($i=1;$row = mysqli_fetch_array($result);$i++){
            echo '<tr data-id-student="'.$row['id_student'].'">';
            echo '<td style="padding:0px; text-align:center;">'.$i.'</td>';
            echo '<td>'.$row['name_student'].'</td>';
            echo '<td class="rewmove-student">Х</td>';
            echo '</tr>';
            array_push($array, $row['id_student']);
            $it=$i;
        }
        $it++;
        echo '</table>';
    }   
    public function show_student_for_journal_no($result,$array,$it){
        echo ' <table class="student_ student_no">';
        $flag = true;
            for($i=1,$j=$it;$row = mysqli_fetch_array($result);$i++,$j++){
                for($i=0;$i<count($array);$i++){
                    if($array[$i]==$row['id_student']){
                        $flag = false;break;      
                    }      
                }
                if($flag == false)$j--;
                if($flag == true){
                echo '<tr data-id-student="'.$row['id_student'].'">';
                echo '<td style="padding:0px; text-align:center;">'.$j.'</td>';
                echo '<td>'.$row['name_student'].'</td>';
                echo '<td class="rewmove-student">Х</td>';
                echo '</tr>';
                }
                $flag = true;

            }
        echo '</table>';
    }
    
    public function delete_student($link,$id_student,$id_code=0){/*Удаление студента*/

        $result = mysqli_query($this->db, "SELECT `id_code` FROM `journal_student` WHERE `id`='$id_student'")or die(mysqli_error($this->db));
        
        $id_code = mysqli_fetch_assoc($result)['id_code'];
        
        $query_delete_marks = "DELETE FROM `journal_marks` WHERE `id_student`='$id_student'";

        $query_delete_student = "DELETE FROM `journal_student` WHERE `id`='$id_student'";

        $query_delete_code = "DELETE FROM `code` WHERE `id`='$id_code'";
        
        $quey_update_privilege = "UPDATE `users_login` SET `privilege`='0' WHERE `id_code`='$id_code'";
        
        mysqli_query($link, $quey_update_privilege)or die(mysqli_error($link));
        
        mysqli_query($link, $query_delete_code)or die(mysqli_error($link));

        mysqli_query($this->db, $query_delete_marks)or die(mysqli_error($this->db));

        mysqli_query($this->db, $query_delete_student)or die(mysqli_error($this->db)); 
    }
    
    public function delete_teacher($link,$id_teacher,$id_code){/*Удаление учителя*/
        $query_delete_code = "DELETE FROM `code` WHERE `id`='$id_code'";
        mysqli_query($link, $query_delete_code)or die(mysqli_error($link));
        
        $delete_teacher = "DELETE FROM `journal_teacher` WHERE `id`='$id_teacher'";
        mysqli_query($this->db, $delete_teacher)or die(mysqli_error($this->db));
        
        $remove_group = "UPDATE `journal` SET `teacher`='null' WHERE `teacher`='$id_teacher'";
        mysqli_query($this->db, $remove_group)or die(mysqli_error($this->db));
        
        $remove_curator = "UPDATE `journal_group` SET `curator`='null' WHERE `curator`='$id_teacher'";
        mysqli_query($this->db, $remove_curator)or die(mysqli_error($this->db));
        
        $quey_update_privilege = "UPDATE `users_login` SET `privilege`='0' WHERE `id_code`='$id_code'";        
        mysqli_query($link, $quey_update_privilege)or die(mysqli_error($link));
    }
    
    public function add_gruop($id_teacher,$group_name){/*Добавление группы*/
        $query = "INSERT INTO `journal_group`(`group_name`,`curator`) VALUE('$group_name','$id_teacher')";
        mysqli_query($this->db, $query)or die(mysqli_error($this->db));
    }
    
    public function change_student($link,$id_code,$id_student,$name,$code){/*Изминение студента*/
        
        mysqli_query($link, "UPDATE `code` SET `code`='$code' WHERE `id`='$id_code'")or die(mysqli_error($link));

        mysqli_query($this->db, "UPDATE `journal_student` SET `name_student`='$name' WHERE `id`='$id_student'")or die(mysqli_error($this->db));
    }
    
    public function change_teacher($link,$id_code,$id_teacher,$name,$code){/*Изминение учителя*/
    
        mysqli_query($link, "UPDATE `code` SET `code`='$code' WHERE `id`='$id_code'")or die(mysqli_error($link));

        mysqli_query($this->db, "UPDATE `journal_teacher` SET `name`='$name' WHERE `id`='$id_teacher'")or die(mysqli_error($this->db));
    }


    static public function translit($str){//Перевод кирилицы в латинцу
        
        $alphavit = array(
        /*--*/
        "а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d","е"=>"e",
        "ё"=>"yo","ж"=>"j","з"=>"z","и"=>"i","й"=>"i","к"=>"k","л"=>"l", "м"=>"m",
        "н"=>"n","о"=>"o","п"=>"p","р"=>"r","с"=>"s","т"=>"t",
        "у"=>"y","ф"=>"f","х"=>"h","ц"=>"c","ч"=>"ch", "ш"=>"sh","щ"=>"sh",
        "ы"=>"i","э"=>"e","ю"=>"u","я"=>"ya"," "=>"_",
        /*--*/
        "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D","Е"=>"E", "Ё"=>"Yo",
        "Ж"=>"J","З"=>"Z","И"=>"I","Й"=>"I","К"=>"K", "Л"=>"L","М"=>"M",
        "Н"=>"N","О"=>"O","П"=>"P", "Р"=>"R","С"=>"S","Т"=>"T","У"=>"Y",
        "Ф"=>"F", "Х"=>"H","Ц"=>"C","Ч"=>"Ch","Ш"=>"Sh","Щ"=>"Sh",
        "Ы"=>"I","Э"=>"E","Ю"=>"U","Я"=>"Ya",
        "ь"=>"","Ь"=>"","ъ"=>"","Ъ"=>"","І"=>"I","і"=>"i","Є"=>"E","є"=>"e","Ї"=>"I","ї"=>"i"
        );
    return strtr($str, $alphavit);
    }
    
    public function generateRandomString($length = 20) {//Генарция ключа
        
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
    
    }
    
    /*Журнал*/
    
    public function show_head_journal($predmet_id){ // Вывод шапки журнала
     echo '<tbody>';
    $query = "SELECT * FROM `journal_date` WHERE `id_journal` = '$predmet_id'";
    
    $result = mysqli_query($this->db, $query)or die(mysqli_error($this->db));
   
    echo '<tr><th rowspan="2">id</th><th class="name-student" rowspan="2">Прізвище та ініціали</th><th colspan="31">Місяць, число</th><th rowspan=2 width="20px;">с/б</th></tr>';
  
    echo '<tr>';
    
    for($i=3;$row = mysqli_fetch_array($result);$i++){//& #013
        
        echo '<th  data-column="column'.$i.'" class="journal-table-date column'.$i.' column" data-date="'.$row['date'].'" title="'.$row['date'].'&#013'.$row['description'].'" '
                
        .'data-date-description="'.$row['description'].'" data-date-id='.$row['id'].' data-date-id-journal="'.$row['id_journal'].'"'
        
        .'data-date-number='.$row['number'].'>'. self::convert_date($row['date']).'&#160</th>';           
        
    }
    
    echo '</tr>';

    }
    
    static public function split_name($name_student){  //Преобразование имени ПППП ПППП ПППП В ПППП П.П.
     
    $name = explode(" ", $name_student);
    
    return $name[0]." ".mb_substr($name[1], 0, 1,'UTF8').". ".mb_substr($name[2], 0, 1,'UTF8').".";
    
    }
    
    static public function convert_date($date){// Преобразование даты с 0000-00-00 в 00 00 

    $date_array = explode("-", $date);
    
    return @$date_array[1]."\n".@$date_array[2];
    }
    
    function show_mark_journal($id_journal,$id_student){//Вывод оценок
    
    $query_marks = "SELECT  * FROM `journal_marks` WHERE `id_journal`='$id_journal' and `id_student` = '$id_student' ";
        
    $result_marks = mysqli_query($this->db, $query_marks);
    $sum = 0;
    $count = 0;
    $mark = 0;
    $last = 0;
    for($i=3;$row_marks = mysqli_fetch_array($result_marks);$i++){
        $mark = $row_marks['mark'];
            if(preg_match("/(12)|(1*\d{1,2})/", $mark)){
                $sum+= $mark;

                $count++;
            }
            echo '<td data-column="column'.$i.'" class="column journal-table-marks column'.$i.'" title="Дата изменения: '.$row_marks['date_change'].'"data-marks-id="'.$row_marks['id'].'" data-marks-id-student="'.$row_marks['id_student'].'"'
                    . ' data-marks_id_journal="'.$row_marks['id_journal'].'" data-marks-mark="'.$row_marks['mark'].'" data-marks-date="'.$row_marks['id_date'].'">'.$row_marks['mark'].'</td>';
            $last = $i;
        }
       echo '<td class="column">'. $this->average($sum,$count).'</td>';
    }
    
    private function average($sum,$count){//Вычисление среднего бала
    
    return ($count!=0 && $sum!=0)?round($sum/$count,1):"";
    
    }
    
    public function show_row($id_journal=false,$id_student=false){//Вывод имени и оценок для журнала.
        $query = "SELECT DISTINCT"
        . " `journal_student`.`name_student`,"
        . "`journal_student`.`id` as `id_student` "
        . " FROM "
        . "`journal_student` RIGHT JOIN `journal_marks` ON `journal_marks`.`id_student` =`journal_student`.`id`";
      
        if($id_student==false){
            $query.=" WHERE `journal_marks`.`id_journal`='$id_journal' ORDER BY `name_student` ASC";
        }elseif($id_student!=false){
            $query.=" WHERE `journal_marks`.`id_student`='$id_student'";
        }
        $result = mysqli_query($this->db, $query)or die(mysqli_error($this->db));
       
        for($i=1;$row = mysqli_fetch_array($result);$i++){
            echo '<tr class="row">';
            echo '<td class="column">'.$i.'</td>';
            echo '<td class="column" data-id-studet="'.$row['id_student'].'" data-column="column2">'
           . '<a href="'.SITE.'/journal/student/'.($row['id_student']).'">'. self::split_name($row['name_student']).'</a></td>';
            $this->show_mark_journal($id_journal, $row['id_student']);
            echo '</tr>';
        }
        echo '</tbody>';
    }
    
    public function change_mark($mark,$id_mark){/*Изминение оценок*/
       if($mark!='Н'){
       mysqli_query($this->db,"UPDATE `journal_marks` SET mark = '$mark', `date_change`=NOW()  WHERE `id` = '$id_mark'")or die(mysqli_error($this->db));
       }else{
       mysqli_query($this->db,"UPDATE `journal_marks` SET mark = '$mark',`missed`='1', `date_change`=NOW()  WHERE `id` = '$id_mark'")or die(mysqli_error($this->db));
   
       }
    }
    
    public function change_date($decription,$date,$id_date){/*Изминение даты*/

        if(trim($date) == '0000-00-00' || trim($date) == ''){
            
        mysqli_query($this->db, "UPDATE `journal_date` SET `description`='$decription',`date`=NULL   WHERE `id`='$id_date' ")or die(mysqli_error($this->db));   
        
        }else{
            
        mysqli_query($this->db, "UPDATE `journal_date` SET `description`='$decription',`date`='$date'   WHERE `id`='$id_date' ")or die(mysqli_error($this->db));
        }
    }
    
    public function check_date($date,$id_date){/*Проверка на коректность даты*/
        
        $result_date = mysqli_fetch_assoc(mysqli_query($this->db, "SELECT * FROM `journal_date` WHERE `id`='$id_date'"));
        $id_journal = $result_date['id_journal'];
        $check_date = ($result_date['date']==$date)?true:false;
        $result = mysqli_query($this->db, "SELECT * FROM `journal_date` WHERE `id_journal`='$id_journal'")or die(mysqli_error($this->db));
        $number = mysqli_fetch_assoc(mysqli_query($this->db, "SELECT * FROM `journal_date` WHERE `id`='$id_date'"))['number'];
        if($check_date){
            return true;
        }
        while($row = mysqli_fetch_array($result)){
            if($row['date']>=$date && $date!=''){
            return false;
        }
        }
        return true;
        
    }
    
    public function generate_marks($id_journal,$id_student){   //заполнеие таблицы journal_ocenki

        foreach ($id_student as $key){

            $id_date_result = mysqli_query($this->db, "SELECT `id` FROM `journal_date` WHERE `id_journal` = '$id_journal'")or die(mysqli_error($this->db));

            while($row_date = mysqli_fetch_array($id_date_result)){

                $id_date = $row_date['id'];
                mysqli_query($this->db, "INSERT INTO `journal_marks`(`id_student`,`id_journal`,`id_date`) "
                . " VALUE('$key',$id_journal,'$id_date')")or die(mysqli_error($this->db));
            }
        } 
    
    }
    
    public function delete_marks($id_journal,$id_student){/*Удаление оценок для студента по журналу*/
        
        $query_delete_from_marks = "DELETE FROM `journal_marks` WHERE `id_student`='$id_student' and `id_journal`='$id_journal'";
    
        mysqli_query($this->db, $query_delete_from_marks)or die(mysqli_error($this->db));
    }
    
    private function generate_date($id_journal){   //создание даты для жунала
    
        for($numbr_i=1;$numbr_i<=31;$numbr_i++){

            mysqli_query($this->db, "INSERT INTO `journal_date`(`id_journal`,`number`)  VALUE('$id_journal',$numbr_i)")or die(mysqli_error($this->db));

        }
    }
    
    function add_list($id_group,$id_teacher,$predmet_name){/*Добавлеие журнала*/
    $query = "INSERT INTO `journal`(`teacher`,`predmet_name`,`group_name`) VALUE('$id_teacher','$predmet_name','$id_group')";
    mysqli_query($this->db, $query) or die(mysqli_error($this->db));
    }

    

    public function generate_journal($id_teacher,$predmet_name,$id_group,$student){ //очистка и заполнение таблицы journal_ocenki    
        
        $this->add_list($id_group,$id_teacher,$predmet_name);
        
        $id_journal = mysqli_insert_id($this->db);
                
        $this->generate_date($id_journal);

        $this->generate_marks($id_journal,$student,$id_group);
    }
    
    public function delete_jounral($id_journal){/*Удаление журнала*/
        
        $query_delete_date= "DELETE FROM `journal_date` WHERE `id_journal`='$id_journal'";
        mysqli_query($this->db, $query_delete_date)or die(mysqli_error($this->db));
        
        $query_delete_marks = "DELETE FROM `journal_marks` WHERE `id_journal`='$id_journal'";
        mysqli_query($this->db, $query_delete_marks)or die(mysqli_error($this->db));
        
        $query_delete_flist = "DELETE FROM `journal` WHERE `id`='$id_journal'";
        mysqli_query($this->db, $query_delete_flist)or die(mysqli_error($this->db));

    }
    
    public  function change_group($group_name,$id_teacher,$id_group){/* Изменение группы*/
        
        $query =  "UPDATE `journal_group` SET `group_name`='$group_name', `curator`='$id_teacher' WHERE `id`='$id_group'";
        mysqli_query($this->db,$query)or die(mysqli_error($this->db));
        
    }


    public function delete_group($link,$id_group){/*Удаление группы*/
        
        $query = "SELECT * FROM `journal` WHERE `group_name`='$id_group'";
    
        $result= mysqli_query($this->db, $query)or die(mysqli_error($this->db));
        
        while($row = mysqli_fetch_array($result)){
            $id_journal = $row['id'];
            
           $this->delete_jounral($id_journal);
                                
        }
        
        $query_student = "SELECT `id` FROM `journal_student` WHERE `group_name`='$id_group'";
        
        $result_student = mysqli_query($this->db, $query_student)or die(mysqli_error($this->db)); 
        
        $query_group = "DELETE FROM `journal_group` WHERE `id`='$id_group'";
        
        mysqli_query($this->db, $query_group)or die(mysqli_error($this->db)); 
        
        while($row = mysqli_fetch_array($result_student)){
            
           $this->delete_student($link,$row['id']); 
           
        }       
    }
      
}


?>