<div class="container-advertisement">
<div>
<label>Назва</label><br><br><input type="text" class="title" name="title"><br>
<label>Коротркий опис</label><br><textarea class="description" name="description"></textarea><br>
<div class="button_journal button-advertisement">Додати</div>
</div>
    <div>
        <div class="rgiht-news-block-news"><div class="news_aside"><h4></h4><hr><div><span></span></div></div></div>
    </div>
</div>

<div class="container-advertisement-blocks">

        <table>
          
        </table>

</div>

<script>

$('.title').on('input',function(){
    $('.news_aside h4').html($(this).val())
})

$('.description').on('input',function(){
    $('.news_aside span').html($(this).val())
}) 

$('html').on('click','.button-advertisement',function(){
    add_advertisement();
})   

function add_advertisement(){   
    $.ajax({
        url:"<?php echo SITE;?>/module/admin_panel/add_advertisement_ajax.php",
        type:"POST",
        data:({
            "title":$('.title').val(),
            "text":$('.description').val()
        }),success:function(data){
            $('.title').val(""),
            $('.description').val("")
             var data = JSON.parse(data);
            if(data['error']===true){
                 notification(data['text'],'#fff',1,3000)
            }else{
                notification(data['text'],'#fff',1,3000)
            }show_advertisement()
        }
    })
}
show_advertisement();
function show_advertisement(){
        $.ajax({
        url:"<?php echo SITE;?>/module/admin_panel/advertisement_show_ajax.php",
        type:"POST",
        success:function(data){
            $('.container-advertisement-blocks table').html(data);
        }
    })
}

function change_advertisement(caption,text,id,flag){
        $.ajax({
        url:"<?php echo SITE;?>/module/admin_panel/advertisement_change_ajax.php",
        type:"POST",
        data:({
            "caption":caption,
            "text":text,
            "id":id,
            "flag":flag
        }),
        success:function(data){
            show_advertisement()
            console.log(data)
        }
    })
}

$('html').on('click','.advertisement-tr',function(e){
    let caption = $(this).find('.container-advertisement-blocks-caption').val();
    let text = $(this).find('.container-advertisement-blocks-text').val();
    let id = $(this).attr('data-id');
    
    if($(e.target).is('.change-advertisement')){
        change_advertisement(caption,text,id,'change');
    }else if(($(e.target).is('.remove-advertisement'))){
        change_advertisement(caption,text,id,'delete');
        
    }
})
</script>