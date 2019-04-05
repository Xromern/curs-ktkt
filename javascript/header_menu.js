jQuery("document").ready(function($){
 function add_remove_class(){
  var array = [$('.logo'),$('.header_midle'),$('.topmenu'),$('.menu_ul'),$('.stacik_header_midle'),$('.logo_menu')];
  var new_class=["nlogo",'nheader_midle','ntopmenu','nmenu_ul','nstacik_header_midle','nlogo_menu'];
   $(window).scroll(function () {
       if ($(this).scrollTop() > 60) {
        if (document.body.clientWidth >'800') {
        for(var i=0;i<array.length;i++){
            array[i].addClass(new_class[i]);
        }
        }
       } else {
        for(var i=0;i<array.length;i++){
            array[i].removeClass(new_class[i]);
        }
       }
       
   });
      $(window).on('resize', function(){
        if (document.body.clientWidth <'800') {
          for(var i=0;i<array.length;i++) array[i].removeClass(new_class[i]);
               
        }else{
            
          //  for(var i=0;i<array.length;i++) array[i].addClass(new_class[i]);
        
        }
    });
  }
add_remove_class()

});