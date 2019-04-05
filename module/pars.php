<?php
include "include.php";
include 'simple_html_dom.php';
header('Content-Type: text/html; charset=windows-1251');
set_time_limit(0);
function convert_f($str){
  return  mb_convert_encoding($str, "UTF-8", "windows-1251");
}
echo "pars";
function cur_get($html)
{
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $html);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
    $result = curl_exec($curl_handle);
    return str_get_html($result);
    curl_close($curl_handle);
}
  function get_url(&$html,&$url_img_mini,&$url_img){
      $html="";$url_img_mini="";$url_img="";
        if (method_exists($html,"find")) {
                if ($html->find('html')) {
                    foreach ($html->find('.preview_list_large li a') as $element) {
                        $url_img_mini = $url_img_mini . $element->children(0)->src . " ";
                        $string = cur_get($site. $element->href);
                        if (method_exists($string, "find")) {
                            if ($string->find('html')) {
                                foreach ($string->find('.viewer_image img') as $elements) {
                                    $url_img = $url_img . $elements->src . ' ';
                                }
                            }
                        }
                    }
                }
            }   
    }    
$site = 'http://photo.i.ua';
$html = cur_get('http://photo.i.ua/user/1645626/');
$res  = mysqli_query($link," select user_id from photo where user_id=(select max(user_id) from photo) ") or die(mysqli_error($link));
$row  = mysqli_fetch_array($res);
foreach (array_reverse($html->find('.folder_advanced') )as $cont) {
    $title_href = $cont->children(1)->first_child()->href;
    $title_href_id = str_replace('/', '', str_replace('/user/1645626/', '', $title_href));
    $title_caption = str_replace("'", "", $cont->children(1)->first_child()->innertext);

    if ((int)$row[0] >= (int)$title_href_id) {
        echo mb_convert_encoding('Пропуск__', "windows-1251", "UTF-8") . $title_caption . '__' . $title_href . '<br>';
        goto go_to;
    }

    $info = str_replace("'", "", $cont->last_child()->innertext);
    $html = cur_get($site . $title_href);
    echo $title_href . '<br>' . $title_caption . '<br>' . $info . '<br><br>';
    if (method_exists($html,"find")) 
    {
        if ($html->find('html')) 
                {
        if (!($html->find('.preview_list_large li a img'))) {
            echo mb_convert_encoding('<br><div>Начало папки</div><br>', "windows-1251", "UTF-8");
            foreach ($html->find('.folder_advanced') as $cont) {
                $folder_title_href = $cont->children(1)->first_child()->href;
                $folder_title_id = str_replace('/', '', str_replace("/user/1645626/", "", $folder_title_href));
                $folder_title_caption = str_replace("'", "", $cont->children(1)->first_child()->innertext);
                $folder_info = str_replace("'", "", $cont->last_child()->innertext);
                $folder_url_img = '';
                $url_img_mini = "";
                for ($i = 0; $i < 100; $i++) 
                {
                    $html = cur_get($site . $folder_title_href . '?p=' . $i);
                    if (method_exists($html, "find")) {
                        if ($html->find('html')) {
                            if (!($html->find('.preview_list_large li a'))) {
                                break;
                            }
                        }
                    }
    get_url($html,$url_img_mini,$folder_url_img);

                flush();
                echo '/\= ' . $url_img_mini . "<br>";
                echo '/\-- ' . $folder_url_img . "<br>";flush();
                mysqli_query($link, "INSERT INTO `site`.`photo_folder` (`id_photo`, `caption_main_photo`, `caption`,`id_folder`, `url_mini`, `url`, `info`) 
                                      VALUES ('" . convert_f($title_href_id) . "',
                                      '" . convert_f($title_caption) . "',
                                      '" . convert_f($folder_title_caption) . "',
                                      '" . convert_f($folder_title_id) . "',
                                      '" . convert_f($url_img_mini) . "',
                                      '" . convert_f($folder_url_img) . "' ,
                                      '" . convert_f($folder_info) . "')") or die(mysqli_error($db));
            }

            echo mb_convert_encoding('<br><div>Конец папки</div>' . $title_caption . '<br>', "windows-1251", "UTF-8");
        
                            }
    }
}
    $url_img = '';
    $url_img_mini = "";
    for ($i = 0; $i < 100; $i++) {
        $html = cur_get($site . $title_href . '?p=' . $i);
        if (method_exists($html, "find")) {
            if ($html->find('html')) {

        if (!($html->find('.preview_list_large li a'))) {
            break;
        }
    }
}    
   get_url($html,$url_img_mini,$url_img);

    }flush();
    echo '/\= '.$url_img_mini."<br>";
    echo '/\-- '.$url_img . '<br><br>';
flush();
    mysqli_query($link, "INSERT INTO photo (id,caption,user_id,url_mini,url,id_holder,info) 
                                  VALUES (null,
                                 '".convert_f($title_caption)."',
                                 '".convert_f($title_href_id)."',
                                  '".convert_f($url_img_mini)."',
                                 '".convert_f($url_img)."',
                                 '".convert_f($folder_title_id)."',
                                 '".convert_f($info)."')") or die(mysqli_error($link));
    $title_href_id=0;
    $folder_title_id=0;
    flush();
    go_to:flush();
}

print_r(error_get_last());
} 
?>