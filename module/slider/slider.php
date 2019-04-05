   <section class="header_bottom" >
       
        <div class="slider_head">
            <div class="container_slider">
                 <div class="slide-wrap">
                  <div class="slide-item">
                 <img src="<?php echo SITE;?>/img/slide1.jpg">
                </div>
               <div class="slide-item">
                 <img src="<?php echo SITE;?>/img/slide3.jpg">
                </div>
                     <div class="slide-item">
                 <img src="<?php echo SITE;?>/img/slide4.jpg">
                </div>
                     <div class="slide-item">
                 <img src="<?php echo SITE;?>/img/slide5.jpg">
                </div>

		
    </div>
        </div>
            <div class="slide_prev"></div>
               <div class="slide_next"></div>
            </div>

       <script>
$("document").ready(function($) {
var slideWrap = $('.container_slider');
var slideWidth = $('.container_slider img').outerWidth();
var scrollSlider = slideWrap.position().left - slideWidth;

var timer =  setInterval(move_slide, 5000);
timer;
$(window).on('resize', function() {
    slideWidth = $('.container_slider img').outerWidth();
    scrollSlider = slideWrap.position().left - slideWidth;
});


$('.slide_next').click(function() {
    move_slide();
    clearTimeout(timer);
    timer =  setInterval(move_slide, 5000);
});
$('.slide_prev').click(function() {
    if (!slideWrap.is(':animated')) {
        slideWrap.find('.slide-item:last').attr('src',slideWrap.find('.slide-item:last').attr('data-src'))
        slideWrap
            .css({
                'left': scrollSlider
            })
            .find('.slide-item:last')
            .prependTo(slideWrap)
            .parent()
            .animate({
                left: 0
            }, 500);
    }

    clearTimeout(timer);
    timer =  setInterval(move_slide, 5000);
});

function move_slide() {
    if (!slideWrap.is(':animated')) {
        slideWrap.find('.slide-item:first').attr('src',slideWrap.find('.slide-item:first').attr('data-src'))
        slideWrap.animate({
            left: scrollSlider
        }, 500, function() {
            slideWrap
                .find('.slide-item:first')
                .appendTo(slideWrap)
                .parent()
                .css({
                    'left': 0
                });
        });
    }
}
   

}); 
       </script>
       
         <div class="big_btns" id="yacor">
         <a href="/gallery" class="big_btn">Галерея</a>
         <a href="/index.php?s=admin_panel"class="big_btn">Розклад</a>
         <?php
         
         if($login->A() || $login->T()){
             $href = "/group";
         }elseif($login->S()){
              $href = "/index.php?s=about_group";       
         }else{
             $href="#";
         }
            echo'<a href="'.$href.'" class="big_btn">Журнал</a>';
         ?>
         <a href="#"class="big_btn">Методичні матеріали</a>
      </div>
   </section>




