<?php   
    include '../include.php';
if (!isset($login)) {
   
    exit();
}
   
if (empty($_POST['login']) AND empty($_POST['password'])) {
        $jsonData = array(
            "error" => "Заповніть всі поля."
     );
        exit(json_encode($jsonData));
}
    $login       = mysqli_real_escape_string($link, htmlspecialchars($_POST['login']));
    $password    = mysqli_real_escape_string($link, htmlspecialchars($_POST['password']));
    $search_user = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(*) FROM `users_login` WHERE `username` = '" . $login . "' AND `password` = '" . md5($password) . "'"))[0];
    if ($search_user == 0) {
    $jsonData = array(
            "error" => "Пароль або логін невірний."
     );
        exit(json_encode($jsonData));
    } else {
        $time = 60 * 60 * 96;
        setcookie('username', $login, time() + $time, '/');
        setcookie('password', md5($password), time() + $time, '/');
            $jsonData = array(
            "error" => true
        );
 
        exit(json_encode($jsonData));
    }


?>
