<div class="comment-block"></div>
<script>
    show_comment();
 function show_comment() {
 
     $.ajax({
         url: "<?php echo SITE;?>/module/news/comment_show_ajax.php",
         type: "POST",
         data: ({
             "last_100": true
         }),
         success: function(data) {
             $('.comment-block').html(data);

         }
     })
 }
 
 $('html').on('click','.delete-comment',function(){
    let id = $(this).attr('data-id');
    if(confirm("Ви дійсно хочете видали коментар?")){
    delete_comment(id);
    }
 })
 function delete_comment(id){
    $.ajax({
        url:"<?php echo SITE;?>/module/admin_panel/delete_comment_ajax.php",
        type:"POST",
        data:({"id":id}),
        error:function(){
            notification("Сталася помилка","000",1,3000);
        },success:function(){
                show_comment();
        }
    })
 }
</script>