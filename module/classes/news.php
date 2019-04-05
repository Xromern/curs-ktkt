<?php

class news
{
    protected $db;
    protected $_login;
    function __construct($login)
    {
            $this->db = mysqli_connect(HOST, USER, PASSWORD, "ktkt_main") or die(mysqli_error());
            $this->_login = $login;
    }

    public function upload_image()
    {
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); // valid extensions
        $path = 'img/news_img/'; // upload directory

        if (isset($_FILES['image'])) {
            $img = $_FILES['image']['name'];
            $tmp = $_FILES['image']['tmp_name'];
            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));//Расширение
            $final_image = rand(1000, 1000000) . $img;

            $path = $_SERVER['DOCUMENT_ROOT'] . '/img/news_img/' . $final_image;
            if (in_array($ext, $valid_extensions)) {
                    if (!move_uploaded_file($tmp, $path)) {
                            return "ktkt.png";
                    } else {
                            return $final_image;
                    }
            } else {
                    return "ktkt.png";
            }
        } else return "ktkt.png";
    }

    public function add_advertisement($caption, $text)
    {
            mysqli_query($this->db, "INSERT INTO `advertisement`(`caption`,`text`,`date`) VALUE('$caption','$text',now())") or die(mysqli_error($this->db));
    }

    public function show_advertisement()
    {
            return mysqli_query($this->db, "SELECT `id`,`caption`,`text`,`date` FROM `advertisement` ORDER BY `id` DESC");
    }

    public function change_advertisement($id, $caption, $text)
    {
            mysqli_query($this->db, "UPDATE `advertisement` SET `caption`= '$caption',`text`= '$text' WHERE `id`='$id'") or die(mysqli_error($this->db));
    }

    public function delete_advertisement($id)
    {
            mysqli_query($this->db, "DELETE FROM `advertisement` WHERE `id`='$id'");
    }

    public function add_news($title, $description, $textarea, $img)
    {
            mysqli_query(
                    $this->db,
                    "INSERT INTO `news`(caption,span,main_span,img,date_s,id_author)
VALUE('$title','$description','$textarea','$img',now(),'{$this->_login->get_IdUser()}')"
            ) or die(mysqli_error($this->db));
    }

    public function change_news($id, $title, $description, $textarea, $img)
    {
            if ($img != false) {
                    $url = ",`img`='$img' ";
            } else $url = "";
            mysqli_query(
                    $this->db,
                    "UPDATE `news` SET `caption`='$title',`span`='$description',"
                            . "`main_span`='$textarea' $url WHERE `id`='$id'"
            ) or die(mysqli_error($this->db));
    }

    public function delete_article($id)
    {
            $path_image = mysqli_fetch_array(mysqli_query($this->db, "SELECT `img` FROM `news` WHERE `id`='$id'"))['img'];
            if ($path_image != 'ktkt.png') unlink($_SERVER['DOCUMENT_ROOT'] . '/img/news_img/' . $path_image);
            $query_delete_article = "DELETE FROM `news` WHERE `id`='$id'";
            mysqli_query($this->db, $query_delete_article) or die(mysqli_error($this->db));

            $query_delete_comment = "DELETE FROM `comment` WHERE `id_news`='$id'";
            mysqli_query($this->db, $query_delete_comment) or die(mysqli_error($this->db));
    }

    public function check_article_teacher($id)
    {
            if ($this->_login->T()) {
                    if ($this->id_author($id,$this->_login->get_IdUser())) {
                            return true;
                    } else return false;
            } else {
                    return false;
            }
    }
    
    private function id_author($id_news,$id_author){
        $query = "SELECT * FROM `news` WHERE `id`='$id_news' AND `id_author`='$id_author'";
        $result =  mysqli_query($this->db, $query) or die(mysqli_error($this->db));
        return mysqli_num_rows($result)>0?true:false;
    }
    
    public function return_name_author($id)
    {
            $query = "SELECT"
                    . "`code`.`first_name` AS `first_name`,"
                    . "`code`.`middle_name` AS `middle_name`,"
                    . "`code`.`last_name` AS `last_name`"
                    . " FROM `code` inner JOIN `users_login` ON `code`.`id`=`users_login`.`id_code` "
                    . "WHERE `users_login`.`id`='$id'";
            $result = mysqli_query($this->db, $query);
            list($first_name, $middle_name, $last_name) = mysqli_fetch_array($result);
            return (mysqli_num_rows($result) > 0) ? "($first_name $last_name $middle_name)" : "";
    }

    public function pageation($page, $total, $url)
    {
            $pervpage = '';
            $nextpage = '';
            $page2left = '';
            $page1left = '';
            $page2right = '';
            $page1right = '';
            echo '<div class="pagenation">';
      // Проверяем нужны ли стрелки назад  
            if ($page != 1) $pervpage = ' <a class="pagenation_a prev-page" href=' . $url . '1><<</a>  
                                     <a class="pagenation_a" href=' . $url . '' . ($page - 1) . '><</a> ';  
      // Проверяем нужны ли стрелки вперед  
            if ($page != $total) $nextpage = ' <a class="pagenation_a"  href=' . $url . '' . ($page + 1) . '>></a>  
                                         <a class="pagenation_a next-page"  href=' . $url . '' . $total . '>>></a>';  
      // Находим две ближайшие станицы с обоих краев, если они есть  
            if ($page - 2 > 0) $page2left = ' <a class="pagenation_a"href=' . $url . '' . ($page - 2) . '>' . ($page - 2) . '</a>';
            if ($page - 1 > 0) $page1left = ' <a class="pagenation_a" href=' . $url . '' . ($page - 1) . '>' . ($page - 1) . '</a> ';
            if ($page + 2 <= $total) $page2right = ' <a class="pagenation_a" href=' . $url . '' . ($page + 2) . '>' . ($page + 2) . '</a>';
            if ($page + 1 <= $total) $page1right = '    <a class="pagenation_a" href=' . $url . '' . ($page + 1) . '>' . ($page + 1) . '</a>'; 

      // Вывод меню  
            echo $pervpage . $page2left . $page1left . '<div class="current">' . $page . '</div>' . $page1right . $page2right . $nextpage;
           echo '
      </div>
    </div>';
    }
    public function page_limit(&$start, &$num, &$page, &$total, $total_row)
    {
            $total = intval(($total_row - 1) / $num) + 1;  
    // Определяем начало сообщений для текущей страницы  
            $page = intval($page);  
    // Если значение $page меньше единицы или отрицательно  
    // переходим на первую страницу  
    // А если слишком большое, то переходим на последнюю  
            if (empty($page) or $page < 0) $page = 1;
            if ($page > $total) $page = $total;  
    // Вычисляем начиная к какого номера  
    // следует выводить сообщения  
            $start = $page * $num - $num;
    }
    
    public function comment($query){
        $result=mysqli_query($this->db,"SELECT "
        . "`comment`.`message` as `message`,"     
        . "`comment`.`date`as `date`,"
        . "`users_login`.`username`as`username`,"
        . "`users_login`.`privilege`as`privilege`,"
        . "`comment`.`id` as `id` FROM"
        . " `comment` INNER JOIN `users_login` ON `comment`.`id_user`=`users_login`.`id` "
        .$query) or die(mysqli_error($this->db));
        
        return $result;
    }  
    public function delete_comment($id){
        $query = "DELETE FROM `comment` WHERE `id`='$id'";
        mysqli_query($this->db, $query)or die(mysqli_error($this->db));
    }
    
}
