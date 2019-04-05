<?php

class form6
{
    static public function show_head_form6()
    {
        /*Вывод шапаки для формы 6*/

        echo '<tr><th class="table_id">п/п</th><th class="form6_table_name">Прізвище</th>';

        for ($i = 1; $i < 31; $i++) {
                echo '<th  data-column="column' . $i . '" class="column column' . $i . ' form6_day">' . $i . '</th>';
        }
        echo "<th class='all_missed'>Пропущено</th>";
        echo '</tr>';
    }

    static public function case_month($date)
    {
        $date = explode('-', $date);

        switch ($date[1]) {
            case "01":
                    return "Січень";

            case "02":
                    return "Лютий";

            case "03":
                    return "Березень";

            case "04":
                    return "Квітень";

            case "05":
                    return "Травень";

            case "06":
                    return "Червень";

            case "07":
                    return "Липень";

            case "08":
                    return "Серпень";

            case "09":
                    return "Вересень";

            case "10":
                    return "Жовтень";

            case "11":
                    return "Листопад";

            case "12":
                    return "Грудень";
        }
    }

    static public function query_montm_form6($group)
    {
        $query = "select DISTINCT date_format(`date`, '%Y-%m') as date from journal_date "
                . "INNER JOIN `journal` ON `journal`.`id`= `journal_date`.`id_journal`"
                . "WHERE `date`!='null' and `journal`.`group_name`='$group' order by date desc";
        return $query;
    }

    public function show_month($group)
    {
        /*Вывод месяцев для формы 6*/
        $result = mysqli_query($this->db, self::query_montm_form6($group)) or die(mysqli_error($this->db));
        while ($row = mysqli_fetch_array($result)) {
                $date = $row['date'];
                echo '<option value="' . $group . '">' . $date . '-(' . self::case_month($date) . ')</option>';
        }
    }
    static public function missed_query($date, $id_student)
    {
        $query = "SELECT `journal`.`predmet_name` as predmet,"
                . "`journal_marks`.`missed` as `missed`,"
                . "`journal_marks`.`id` as `id_date`"
                . " FROM `journal_marks` "
                . "INNER JOIN `journal_date` "
                . "on `journal_date`.`id`=`journal_marks`.`id_date` "
                . "INNER JOIN `journal`"
                . " on `journal`.`id`=`journal_marks`.`id_journal`"
                . "WHERE `journal_date`.`date`='$date' "
                . "and `journal_marks`.`id_student`='$id_student' "
                . "and `journal_marks`.`mark`='Н'";

        return $query;
    }

    public function show_missed($date, $group, $id_student_ = false) /*Вывод пропущенных часов*/
    {      
        $all_missed = 0;
        $query = "SELECT * FROM `journal_student` WHERE `group_name`='$group'";
        if ($id_student_ != false) {
                $query .= " AND `id`='$id_student_' ";
        } elseif ($id_student_ == false) { $query .= " ORDER BY `name_student` ASC";}
        $result = mysqli_query($this->db, $query) or die(mysqli_error($this->db));
        $this->show_missed_row_student($date,$all_missed,$result);
        if ($id_student_ == false) {
                echo '<tr><td colspan="28"></td><td colspan="4">Всього</td><td>' . $all_missed . '</td></tr>';
        }
    }
    private function show_missed_row_student($date,&$all_missed,$result){
        for ($i = 1; $row = mysqli_fetch_array($result); $i++) {
            $missed = 0;
            $id_student = $row['id'];
            $name = explode(" ", $row['name_student']);
            $href = SITE . "/formS/student/$id_student";
            echo '<tr class="row"><td>' . $i . '</td><td class="form6_name"><a href="' . $href . '">' . $name[0] . ' ' . $name[1] . '</a></td>';            
            $this->show_missed_row($date,$missed,$all_missed,$id_student);           
            echo '<td class="cell">' . $missed . '</td>';
        }
    }
    
    function show_missed_row($date,&$missed,&$all_missed,$id_student){
        for ($j = 1; $j < 31; $j++) {
            $temp = explode('-', $date);
            $result2 = mysqli_query($this->db, self::missed_query($this->format_date($temp,$j), $id_student)) or die(mysqli_error($this->db));
            if (mysqli_num_rows($result2) > 0) {
                    $res = $this->colorCell_date($result2);
                    $number_of_hours = mysqli_num_rows($result2) * 2;
                    $all_missed += $number_of_hours;
                    $missed += $number_of_hours;
                    echo '<td  data-column="column' . $j . '" data-id-date="' . ($res['id_date']) . '" ' . ($res['color']) . ' '
                            . 'class="column column' . $j . ' cell td_progul" title="' . ($res['predmet']) . '">' . $number_of_hours . '</td>';
            } else {
                echo '<td data-column="column' . $j . '" class="column column' . $j . ' cell"></td>';
            }
        }
    }
     
    private function format_date($temp,$j){
        
        return ($j >= 10) ? $temp[0] . '-' . $temp[1] . '-' . $j : $temp[0] . '-' . $temp[1] . '-' . '0' . $j;
    }
    
    private function colorCell_date($result)
    {//Пропущенные предметы, цвет для ячейки, id 
        $predmet = "";
        $flag = false;
        $id_date = "";
        $color = "";
        while ($row2 = mysqli_fetch_array($result)) {
            $predmet .= $row2[0] . "&#013";
            if ($row2['missed'] == 1) {
                    $color = 'style="color:red;"';
                    $flag = true;
            } elseif ($row2['missed'] == 0) {
                    if ($flag == false) $color = 'style="color:green;"';
            }
            $id_date .= $row2['id_date'] . "-";
        }
        $res['color'] = $color;
        $res['id_date'] = substr($id_date, 0, -1);
        $res['predmet'] = $predmet;
        return $res;
    }

    public function change_missed($id_marks)
    {
        $check = strpos($id_marks, '-');
        if ($check === false) {
                $this->change_query_missed($id_marks);
        } else {
                $id = explode('-', $id_marks);
                foreach ($id as $key) {
                        $this->change_query_missed($key);
                }
        }
    }
    private function change_query_missed($id)
    {
        $query = "SELECT `missed` FROM `journal_marks` WHERE `id`='$id'";
        $result = mysqli_query($this->db, $query) or die(mysqli_error($this->db));

        $check = mysqli_fetch_assoc($result)['missed'];
        $check = ($check == 0) ? 1 : 0;
        $query = "UPDATE `journal_marks` SET `missed`='$check' WHERE `id`='$id'";
        mysqli_query($this->db, $query) or die(mysqli_error($this->db));
    }
}
