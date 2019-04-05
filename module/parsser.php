<?php
include "include.php";;
include 'simple_html_dom.php';
header('Content-Type: text/html; charset=windows-1251');
set_time_limit(0);
function convert_f($str){
  return  mb_convert_encoding($str, "UTF-8", "windows-1251");
}

function cur_get($html)
{
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $html);
    // таймаут соединения 2 секунд
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    // curl_exec вернёт результат
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
    $result = curl_exec($curl_handle);
    return str_get_html($result);
    curl_close($curl_handle);
}



$html = cur_get('http://photo.i.ua/user/1645626/');
$url_folder=[];

function pars_folder_advanced($html,$url_folder)
{
    foreach (array_reverse($html->find('.folder_advanced'))as $cont) {

       array_push($url_folder,$cont->children(1)->first_child()->href);
       array_push($url_folder,$cont->children(2)->children(1)->innertext);
       array_push($url_folder,$cont->children(5)->innertext);
    }
    return $url_folder;
}
foreach(pars_folder_advanced($html,$url_folder) as $key){
echo $key."<br>";
echo $key."<br>";
echo $key."<br><br>";
}


?>