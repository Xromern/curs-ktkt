<?php
include "include.php";
require_once 'simple_html_dom.php';
header('Content-Type: text/html; charset=utf-8');
set_time_limit(0);
mysqli_query($link, "set character_set_client='utf8'"); // установка кодировки ( возможно у вас cp1251)
mysqli_query($link, "set character_set_results='utf8'");
mysqli_query($link, "set collation_connection='utf8_general_ci'");
function convert_f($str)
{
	return mb_convert_encoding($str, "utf-8", "windows-1251");
}
$ur = 'img/ktkt.png';
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

function probel($text)
{
	$text = preg_replace('| +|', ' ', $text);
	return $text;
}
$res = mysqli_query($link, "select date_s from news where date_s =(select max(date_s) from news)") or die(mysqli_error($link));
$rows = mysqli_fetch_array($res);

for ($i = 100; $i > +1; $i--) {
	$html = cur_get('http://ktkt.stu.cn.ua/page/' . $i . '/');
	echo "str num" . $i . '<br>';
	if (!($html->find('.shortstory .dpad'))) {
		continue;
	}

    foreach ($html->find('.shortstory .dpad') as $htm) {
        $html_new = '';
        $caption = $htm->children(0)->firstChild()->plaintext;
        $href = $htm->children(0)->firstChild()->href;
        $html_news = cur_get($href);

        $html_newss = $html_news->find('.dpad .maincont');
        foreach ($html_newss as $htmll) {
                $html_new = $html_new . $htmll;
        }
        $str = str_split($str);
        for ($j = 0; $j < count($str); $j++) {
                if (($str[$j] == "0")) {
                        $str[$j] = "";
                        break;
                }
        }

        $ff = str_replace(',', '', $htm->children(1)->LastChild()->innertext);
        $dt = explode(" ", str_replace(',', '', $htm->children(1)->LastChild()->innertext));

        $fff = str_split($ff);
        if (count($fff) != 16) {
                $ff = '0' . $ff;
        }
        echo $ff . '<br>';
        $date = explode("-", $dt[0]);
        $time = explode(":", $dt[1]);

        $timestamp = $date['2'] . '-' . $date['1'] . '-' . $date['0'] . ' ' . $time['0'] . ':' . $time['1'];
        if ($rows[0] >= $timestamp) {
                echo mb_convert_encoding('Пропуск__', "windows-1251", "UTF-8") . $caption . '__' . $title_href . '<br>';
                goto go_to;
        }
        $str = probel(($htm->children(2)->plaintext)) . '<br><br>';
        $str = str_split($str);
        for ($j = 0; $j < count($str); $j++) {
                if (($str[$j] == "0")) {
                        $str[$j] = "";
                        break;
                }
        }
        for ($j = 0; $j < count($str); $j++) {
                if (($str[$j] == " ")) {
                        $str[$j] = "";
                } else {
                        break;
                }
        }
        $str = implode($str);

        echo $caption . '<br>';
        $html_new = str_replace("'", "\'", $html_new);
        $html_new = str_replace('"', '\"', $html_new);
        $html_new = str_replace('<b>0</b>', '', $html_new);
        $str = str_replace("'", "\'", $str);
        $str = str_replace('"', '\"', $str);
        $caption = str_replace("'", "\'", $caption);
        $caption = str_replace('"', '\"', $caption);

        $html_new = str_replace('src=\"', 'src=\"http://ktkt.stu.cn.ua', $html_new);
        echo '<div style="color:red;">' . $timestamp . '</div><br>';
        echo $str . '<br>';
        echo print_r($html_new) . '<br>';
        mysqli_query(
                $link,
                "INSERT INTO `site`.`news` (`id`, `caption`, `span`, `main_span`, `img`, `date_s`)
                          VALUES (NULL, '" . $caption . "', '" . $str . "','" . $html_new . "', '$ur', '$timestamp');"
        ) or die(mysqli_error($link));
        go_to:
    }

    echo '<br>';
}

