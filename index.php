<?php include "module/include.php";?>
<!DOCTYPE html>
<html>
<head>
   
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo SITE;?>/css/style.css">
    <link rel="stylesheet" href="<?php echo SITE;?>/css/main_news.css">
    <link rel="stylesheet" href="<?php echo SITE;?>/css/header.css">
    <link rel="stylesheet" href="<?php echo SITE;?>/css/form_login.css">
    <link rel="stylesheet" href="<?php echo SITE;?>/css/admin_panel.css">
        <link rel="stylesheet" href="<?php echo SITE;?>/css/profile.css">
    

    <script src="<?php echo SITE;?>/javascript/add_news.js"></script>
    <script src="<?php echo SITE;?>/javascript/jquery-3.2.1.min.js"></script>   
    <script src="<?php echo SITE;?>/javascript/JavaScript.js"></script>
    <script src="<?php echo SITE;?>/editor/tinymce.min.js"></script>   

  
    <title>Document</title>
</head>
<body>

<?php

echo '<div class="form-notification"></div>';
$act = isset ($_GET['s']) ? (trim($_GET['s'])) : "";
switch ($act) {

//  default :echo    '<script src="'.SITE.'/javascript/JavaScript.js"></script>';

    case "":
        echo '<script src="' . SITE . '/javascript/header_menu.js"></script>';
        echo '<link rel="stylesheet" href="'.SITE.'/css/mediaQuery.css">';
        echo "<header>";
        include "module/header.php";
        include "module/slider/slider.php";
        echo "</header>";
        include "module/news/news_pagenation.php";

        break;

    case "exit":
        include "module/register/exit.php";
        break;

    case "profile":
        echo "<header>";
        include "module/header.php";
        echo "</header>";
        include "module/profile/profile.php";
        break;

    case "news":
        echo '<script src="' . SITE . '/javascript/header_menu.js"></script>';
        echo '<link rel="stylesheet" href="'.SITE.'/css/mediaQuery.css">';
        echo "<header>";
        include "module/header.php";
        include "module/slider/slider.php";
        echo "</header>";
        if (isset($_GET['id'])) {
                include "module/news/article.php";
        } else if (isset($_GET['page'])) {
                include "module/news/news_pagenation.php";
        }
        break;

    case "galery":
        echo '<script src="' . SITE . '/javascript/header_menu.js"></script>';
        echo '<link rel="stylesheet" href="' . SITE . '/css/galery.css">';
        echo '<link rel="stylesheet" href="'.SITE.'/css/mediaQuery.css">';
        echo "<header>";
        include "module/header.php";
        include "module/slider/slider.php";
        echo "</header>";

        if (isset($_GET['folder'])) {
                include "module/galery/galery_photo.php";
        } else {
                include "module/galery/galery_pagenation.php";
        }
        break;

    case "admin":
        include "module/admin_panel/admin_panel.php";
        break;

    case "chat":
        echo "<header>";
        include "module/header.php";
        echo "</header>";
        include "module/chat/chat.php";
        break;

    case "college":
        echo "<header>";
        include "module/header.php";
        echo "</header>";
        include "module/info_college.php";
        break;
    
    case "admin_panel":
        include "module/admin_panel/admin_panel.php";

        break;

    case "add_advertisement":
        include "module/admin_panel/admin_panel.php.php";

        break;
}
/*journal*/

switch ($act) {
    case "formS":
        echo '<link rel="stylesheet" href="' . SITE . '/css/journal.css">';
        echo "<header>";
        include "module/header.php";
        echo "</header>";
        if ($login->A() || $login->S() || $login->T()) {
                include "module/journal/form6/show_form6.php";
        } else {
                header("Location: " . SITE);
                exit();
        }
        break;

    case "show_group":
        echo '<link rel="stylesheet" href="' . SITE . '/css/journal.css">';
        echo "<header>";
        include "module/header.php";
        echo "</header>";
        if ($login->A() || $login->S() || $login->T()) {
                include "module/journal/show_group.php";
        } else {
                header("Location: " . SITE);
                exit();
        }
        break;

    case "about_group":
        echo '<link rel="stylesheet" href="' . SITE . '/css/journal.css">';
        echo "<header>";
        include "module/header.php";
        echo "</header>";
        if ($login->A() || $login->S() || $login->T()) {
                include "module/journal/about_group.php";
        } else {
                header("Location: " . SITE);
                exit();
        }
        break;

    case "show_student":
        echo '<link rel="stylesheet" href="' . SITE . '/css/journal.css">';
        echo "<header>";
        include "module/header.php";
        echo "</header>";
        if ($login->A() || $login->T()) {
                include "module/journal/show_student.php";
        } else {
                header("Location: " . SITE);
                exit();
        }
        break;

    case "show_teacher":
        echo '<link rel="stylesheet" href="' . SITE . '/css/journal.css">';
        echo "<header>";
        include "module/header.php";
        echo "</header>";
        if ($login->A() || $login->T()) {
                include "module/journal/show_teacher.php";
        } else {
                header("Location: " . SITE);
                exit();
        }
        break;

    case "journal_show":
        echo '<link rel="stylesheet" href="' . SITE . '/css/journal.css">';
        echo "<header>";
        include "module/header.php";
        echo "</header>";
        if ($login->A() || $login->T() || $login->S()) {
                include "module/journal/show_journal/show_journal.php";
        } else {
                header("Location: " . SITE);
                exit();
        }
        break;
}

?>

<?php
include_once "module/footer.php";

?>
</body>
</html>