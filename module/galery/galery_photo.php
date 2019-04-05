<script>
    if (document.body.clientWidth > '800') {
  $(document).ready(function() {
    var count = $('.container_photos').length - 1;
    var set = $('.container_photos img');
    $('.container_photos').on('click', 'img', function() {
        var n = set.index(this);
        var m = $(".container_photos:eq(" + n + ")").find("img").attr('src');
        $('.galery').append('<div class="fixed">' +
            '<div class="close_slider"><img  onmousedown="return false;" onclick="return true;" src="../img/galery_slider/close-browser.png"></div>' +
            '<div class="prev_next"><img onmousedown="return false;" onclick="return true;" src="../img/galery_slider/left-arrow.png"></div>' +
            '<div class="slider"><img onmousedown="return false;" onclick="return true;" class="slider_glery" src=' + m + '></div>' +
            '<div class="next"><img onmousedown="return false;" onclick="return true;"src="../img/galery_slider/right-arrow.png"></div></div>'+
            '<a href=' + m + ' class="button_slider1">Відкрити зображення.</a>');
        $("html,body").css("overflow", "hidden");
        $(".fixed").css("background-color", "rgba(51, 44, 44, 0.7)");
        if (n == count) {
            $(".next").hide();
        } else {
            $(".next").show();
        }
        if (n == 0) {
            $(".prev_next").hide();
        } else {
            $(".prev_next").show();
        }

        $('.fixed').on('click', '.close_slider', function() {
            $("html,body").css("overflow", "auto");
            $(".fixed").remove();
            $(".button_slider1").remove();
            $(".button_slider2").remove();
        });

        $('.fixed').on('click', '.next', function() {
            $(".slider_glery").remove();
            if (n == count - 1) {
                $(".next").hide();
            }
            n += 1;
            var m = $(".container_photos:eq(" + n + ")").find("img").attr('src');  
            $('.button_slider1').remove();
            $('.slider').append('<img onmousedown="return false;" onclick="return true;" class="slider_glery" src=' + m + '><a href=' + m + ' class="button_slider1">Відкрити зображення.</a>');
            $(".prev_next").show();
        });

        $('.fixed').on('click', '.prev_next', function() {
            $(".slider_glery").remove();
            if (n == 1) {
                $(".prev_next").hide();
            }
            n -= 1;
            var m = $(".container_photos:eq(" + n + ")").find("img").attr('src');
            $('.button_slider1').remove();
            $('.slider').append('<img onmousedown="return false;" onclick="return true;" class="slider_glery" src=' + m + '><a href=' + m + ' class="button_slider1">Відкрити зображення.</a>');
            $(".next").show();
        });

    });
});
}
</script>
<!--<div class="caption_news">
               <div>Галерея</div>
            </div>-->

<div class="galery">
<?php
$id = $_GET['folder'];
if (isset($_GET['folder'])) {
    
    $result = mysqli_query($db_galery, "SELECT `big_image` FROM `image` WHERE `id_folder`='$id'");
    if(mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result)) {
            echo '<div class="container_photos">
            <img src="'.$row['big_image'] . '">
            </div>';
        }
    }else{  
        $result = mysqli_query($db_galery, "SELECT `id` FROM `folder`  WHERE `id_parent`='$id'") or die(mysqli_error($link));
        for ($j = 0; $row = mysqli_fetch_array($result); $j++) {
              $_gallery->info_folder($row['id'], $info);
              $_gallery->show_folder($j,$info);

        }
    }
}



?>
</div>