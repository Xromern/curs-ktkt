<?php
include "../include.php";
include_once $_SERVER['DOCUMENT_ROOT'].'/module/journal/journal.php';

$privilage=0;
$email = check_post('email');
$password = check_post('password');
$login = check_post('login');
$select = check_post('select');
$code = check_post('code');

$first_name         = "";
$last_name          ="";
$middle_name        = "";

if($email=="" || $password=="" || $login=="" || ($select==2 && $code=="")){
            $jsonData = array(
            "error" => "Заповніть всі поля",
                            "flag"=>false
            
        );
                    exit(json_encode($jsonData));
}

    if (mysqli_result(mysqli_query($link, "SELECT COUNT(*) FROM `users_login` WHERE `username` = '" . $login . "' LIMIT 1;"), 0) != 0) {
        $jsonData = array(
            "error" => "Выбранный логин уже зарегистрирован!",
                        "flag"=>false
        );
        echo json_encode($jsonData);
        exit();
    }
    if (mysqli_result(mysqli_query($link, "SELECT COUNT(*) FROM `users_login` WHERE `email` = '" . $email . "' LIMIT 1;"), 0) != 0) {
        $jsonData = array(
            "error" => "Выбранный Email уже зарегистрирован!",
            "flag"=>false
            
        );
        echo json_encode($jsonData);
        exit();
    }
    
if ($select==2) {
    $code = mysqli_real_escape_string($link, htmlspecialchars($_POST['code']));
    if (mysqli_result(mysqli_query($link, "SELECT COUNT(*) FROM `code` WHERE `code` = '" . $code . "' and _use='Ні' LIMIT 1;"))) {
        $result = mysqli_query($link, "SELECT * FROM `code` WHERE `code` = '" . $code . "' and _use='Ні' LIMIT 1;");
        
        $row                = mysqli_fetch_array($result);
        $first_name         = $row['first_name'];
        $last_name          = $row['last_name'];
        $middle_name        = $row['middle_name'];
        $id_group         = $row['group_id'];
        $id_code=$row['id'];
        $privilage = $row['privilege'];
        $journal = new journal();
        $group_name = $journal->return_group_name($id_group);
        mysqli_query($link, "UPDATE code SET `_use`='Так', `date_use`=NOW() WHERE `code`='$code'");
        mysqli_query($link, "INSERT INTO `users_info` (`last_name`,`first_name`) VALUES('$last_name','$first_name')") or die(mysqli_error($link));
        $id = mysqli_insert_id($link);
        mysqli_query($link, "INSERT INTO `users_login` (`username`,`id_code`,`email`,`password`,privilege,`id_info`) VALUES ('$login','$id_code', '$email','" . md5($password) . "','$privilage','$id')")
                or die(mysqli_error($link));
           $jsonData = array(
        "flag" => true,
        "string"=>nofication($privilage,$first_name." ".$last_name." ".$middle_name,$group_name)
    );

    } else {
        $jsonData = array(
            "error" => "Введений код не вірний",
                        "flag"=>false
            
        );

        exit(json_encode($jsonData));
    }
} else {
mysqli_query($link, "INSERT INTO `users_info` (`first_name`) VALUES('')") or die(mysqli_error($link));
$id = mysqli_insert_id($link);
mysqli_query($link, "set foreign_key_checks=0; ");
mysqli_query($link, "INSERT INTO `users_login` (`username`,`id_code`,`email`,`password`,`privilege`,`id_info`) VALUES ('$login','0', '$email','" . md5($password) . "','0','$id');") or die(mysqli_error($link));
mysqli_query($link, "set foreign_key_checks=1; ");
$jsonData = array(
    "flag" => true,
    "string"=>nofication($privilage,"","")
);

}

    $time = 60 * 60 * 24; // сколько времени хранить данные в куках
    setcookie('username', $login, time() + $time, '/');
    setcookie('password', md5($password), time() + $time, '/');

    exit(json_encode($jsonData));

function nofication($privilage,$name,$group){
    switch($privilage){
        case 0:
            $string = "<div>Вітаємо! Ви зареєструвались!</div>";
        break;
    
        case 1:
            $string = "<div>Студента: $name,<br>Група: $group</div>";
        break;
    
        case 2:
            $string = "<div>Вчитель: $name</div>";
        break;
    }
    return $string;
}
?>