<?php

include $_SERVER['DOCUMENT_ROOT'] . '/module/include.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';
$journal = new journal($dbj);

if ($login->S()) {
	$id_student = $login->get_IdStudent();
	$id_group = $login->get_Group_Id();
	$check = "one";
} else {
	$_date = check_post('date');
	$date1 = explode('-', $_date);
	$id_group = check_post('group');
	$id_student = check_post('id_student');
	$check = $id_student != false ? "one" : "all";
}

switch ($check) {
    case "all":
        if (!mysqli_num_rows(mysqli_query($dbj, journal::query_montm_form6($id_group))) > 0) {
                exit;
        }
        $date = $date1[0] . '-' . $date1[1];
        all_student(
                $journal,
                $id_group,
                $date,
                SITE . "/module/journal/download/form6_generate_excel.php?check=all&id_group=$id_group&date=$date",
                false
        );

        break;

    case "one":
        $id_group = mysqli_fetch_array($journal->return_stundent(false, $id_student))['id_group'];

        $result = mysqli_query($dbj, journal::query_montm_form6($id_group));
        while ($row = mysqli_fetch_array($result)) {
                all_student($journal, $id_group, $row['date'], false, $id_student);
                echo '<hr>';
        }
        $href = SITE . "/module/journal/download/form6_generate_excel.php?id_group=$id_group&id_student=$id_student";
        echo "<div class='button_journal download'><a target='_blank' href=" . $href . ">Скачать</a></div>";
        break;
}

function all_student($journal, $id_group, $date, $href, $id_student = false)
{
    echo '<table id="table"><caption>' . $date . '-(' . journal::case_month($date) . ')' . '</caption>';
    journal::show_head_form6();

    $journal->show_missed($date, $id_group, $id_student);
    echo '</table>';
    if ($id_student == false) {
            echo "<div class='button_journal download'><a target='_blank' href=" . $href . ">Скачать</a></div>";
    }
}
