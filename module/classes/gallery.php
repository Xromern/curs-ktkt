<?php

class gallery
{
    protected $db_gallery;

    function __construct()
    {
            $this->db_gallery = mysqli_connect(HOST, USER, PASSWORD, "ktkt_gallery") or die(mysqli_error());
    }

    public function info_folder($id, &$info)
    {//Получение иноформации о папке
            $query = "SELECT `caption`,`description`,`id` FROM `folder` WHERE `id`='$id'";   //Запрос на название и описание
            $result_info = mysqli_query($this->db_gallery, $query) or die(mysqli_error($this->db_gallery));
            list($info['caption'], $info['description'],$info['id']) = mysqli_fetch_array($result_info);
            $id_last_down_folder = 0;
            $info['total_image'] = 0;
            if ($this->check_folder($id, $result_down_folder)) { //Проверка есть ли в папке подпапки                                           //если есть
                    while (list($id_down_folder) = mysqli_fetch_array($result_down_folder)) {//Прохожусь по всем подпапкам
                            $this->return_total_image($id_down_folder, $info);//Плюсую фотографии со всех папок
                            $id_last_down_folder = $id_down_folder;
                    }
                    $this->return_image($id_last_down_folder, $info);  //Получаю фото с первой подпапки
            } else {// если нету подпапок
                    $this->return_image($id, $info);//Получаю изображения
                    $info['total_image'] = 0;
                    $this->return_total_image($id, $info);//Получаю количество фото
            }

            $query_total_folder = "SELECT COUNT(*) FROM `folder` WHERE `id_parent`='$id'";
            $info['total_folder'] = mysqli_fetch_array(mysqli_query($this->db_gallery, $query_total_folder))[0];//Получаю количество подпапок

    }

    private function check_folder($id, &$result_down_folder)
    {//Проверяю есть ли подпапки
            $query = "SELECT `id` FROM `folder` WHERE `id_parent`='$id'";
            $result_down_folder = mysqli_query($this->db_gallery, $query) or die(mysqli_error($this->db_gallery));
            $check = mysqli_num_rows($result_down_folder) > 0 ? true : false;
            return $check;
    }

    private function return_total_image($id, &$info)
    {//Получаю количетсво фотографий папки

            $query_total_img = "SELECT COUNT(*) FROM `image` WHERE `id_folder`='$id'";
            $info['total_image'] += (int)mysqli_fetch_array(mysqli_query($this->db_gallery, $query_total_img))[0];
    }

    private function return_image($id, &$info)
    {//Получаю изображения папки

        $query_big_image = "SELECT `big_image` FROM `image` WHERE `id_folder`='$id' LIMIT 3";
        $result_big_image = mysqli_query($this->db_gallery, $query_big_image) or die(mysqli_error($this->db_gallery));
        $info['big_image'] = [];
        while ($row = mysqli_fetch_array($result_big_image)) {
                array_push($info['big_image'], $row['big_image']);
        }

        $query_small_image = "SELECT `small_image` FROM `image`  WHERE `id_folder`='$id' LIMIT 12";
        $result_small_image = mysqli_query($this->db_gallery, $query_small_image) or die(mysqli_error($this->db_gallery));
        $info['small_image'] = [];
        while ($row = mysqli_fetch_array($result_small_image)) {
                array_push($info['small_image'], $row['small_image']);
        }
    }
    
    public function show_folder($id,$info){
        echo '
        <a href="'.SITE.'/galery/folder/'.$info['id'].'" class="container_folder"  onmouseover="delayPics('.$id.');">
        <div class="flipper">
        <div class="front">
           <div class="containder_images">
              <div class="image"> 
                  <img class="pagenation_img" data-src="'.@$info['big_image'][0].'" >
                 <img class="pagenation_img" data-src="'.@$info['big_image'][1].'">
                 <img src="'.@$info['big_image'][2].'">
              </div>
              <div class="description_folder">

                 <div class="info_folder">'."Папок : ".$info['total_folder']."Фото: ".$info['total_image'].'</div><br>
                 <div class="folder_title">'.$info['caption'].'</div>
                 <div class="folder_text">'.$info['description'].'</div>
              </div>
           </div>       
          </div><div class="back back_galey">';

          for ($i = 0; $i < count($info['small_image']);$i++) {
              echo '<div class="mini_url"><div><img class="mini_url_hover_'.$id.'" data-src="'.$info['small_image'][$i].'"></div></div>';
          }  
        echo  '</div></div></a>';
    }
}
