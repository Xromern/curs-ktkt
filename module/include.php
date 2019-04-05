<?php
define('HOST', '192.168.0.101');
define('USER', 'mysql');
define('PASSWORD', 'mysql');

$link=mysqli_connect(HOST,USER,PASSWORD,"ktkt_main")or die(mysqli_error());
$dbj=mysqli_connect(HOST,USER,PASSWORD,"ktkt_journal")or die(mysqli_error());
$db_galery=mysqli_connect(HOST,USER,PASSWORD,"ktkt_gallery")or die(mysqli_error());

define('SITE', 'http://192.168.0.101');
include_once "register/handler.php";
include_once "classes/news.php";
include_once "classes/gallery.php";
$login = new login($link,$dbj); 
$_news = new news($login); 
$_gallery = new gallery($link); 

function strip_data($text)
{
    /*$quotes = array ("\x27", "\x22", "\x60", "\t", "\n", "\r", "*", "%", "<", ">", "?", "!" );
    $goodquotes = array ("-", "+", "#" );
    $repquotes = array ("\-", "\+", "\#" );
    $text = trim( strip_tags( $text ) );
    $text = str_replace( $quotes, '', $text );
    $text = str_replace( $goodquotes, $repquotes, $text );
    $text = htmlspecialchars($text);
    $text = mysql_escape_string($text); */
    
    return $text;
}

function inj($text){
/*$deny_words = array("union","char","select","update","group","order","benchmark");
        
str_replace($deny_words, "", strtolower($text), $count); 
        
    if ($count > 0) {
        exit('SQL - inj');
    }*/
 return $text;
}  

function check_post($post){
    if(!isset($_POST[$post])){
        return false;
    }
    $post = inj(strip_data($_POST[$post]));       
    return $post;
}

function check_get($get){    
    if(!isset($_GET[$get])){
        return false;
    }
    $get = inj(strip_data($_GET[$get]));       
    return $get;
}


function try_login($flag){
     if($flag) {
        // выводим информацию для пользователя
        echo '
            <div class="user1">
          <a class="button_journal"  style="margin-top:3px;margin-bottom: 4px;"href="'.SITE.'/index.php?s=profile#yacor">Профіль</a>
        <a class="button_journal" href="/index.php?s=exit">Вийти</a>
        </div>
        ';
        } else {
        // выводим информацию для гостя
        echo '<div class="user0">
        <a class="button_journal"  style="margin-top:3px;margin-bottom: 3px; cursor:pointer; ">Авторизація</a>
        <a class="button_journal signup">Реестрація</a>
        </div>
        ';
        }   
}


