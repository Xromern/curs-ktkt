
$('html').on('mouseover', '.column', function() {

    var table2 = $(this).parent().parent();
    var column = $(this).data('column') + "";
    $(table2).find("." + column).addClass('hov-column');

});

$('html').on('mouseout', '.column', function() {

    var table2 = $(this).parent().parent();
    var column = $(this).data('column') + "";
    $(table2).find("." + column).removeClass('hov-column');

});


 function notification(content,color,opacity,time=3000){
     var form = $('.form-notification');
     if(!form.hasClass('true')){
        form.css({'background-color':color,'opacity':opacity});
        form.html(content);
        form.addClass('true');
        form.animate({top: "10px"}, 1000);
     }else{
         hide_notification();
        form.css({'background-color':color,'opacity':opacity});
        form.html(content);
        form.addClass('true');
        form.animate({top: "10px"}, 1000);
     }
     
      setTimeout(function(){
        hide_notification();
      },time)
      
 }
 
  function hide_notification(){
           var form = $('.form-notification');
       $('.form-notification').animate({top: "-200px"}, 1000);
       form.removeClass('true');
       
  }
  function delayPics (picsArray) {
    picsArray = document.getElementsByClassName("mini_url_hover_"+picsArray);
            for (var i = 0; i < picsArray.length; i +=1) {
                picsArray[i].src = picsArray[i].getAttribute("data-src");
            }  
    
}
function delayPics_2(picsArray) {
    /* Это событие происходит каждый раз 
        при изменении onreadystatechange */
    document.onreadystatechange = function(e) {
        /* Когда документ загрузился - начинаем 
            загрузку изображений: */
        if ("complete" === document.readyState) {
            for (var i = 0; i < picsArray.length; i +=1) {
                /* Просто переписываем путь к изображению из 
                    одного атрибута в другой: */
                picsArray[i].src = picsArray[i].dataset.src;
            }
        }
    };
}
delayPics_2(document.getElementsByClassName("pagenation_img"));