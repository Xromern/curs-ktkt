<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';
if($login->A()){  
    
?>

<style>
    .button_journal{
        display: inline-block;
        width: 170px !important;
        box-shadow: none;
        border:1px solid #163c94;
    }
</style>
<div class="main_conainer">
    <div class="field_block_2">
        <div class="add-teacher"><input placeholder="П.І.П."><div style="float:right" class="button_journal add">Додати</div></div>
    </div>
    <div class="field_block_2">       
       <div class="preloader"> <img width="220px;" src="../../img/gg.gif"><div style="text-align:center;">Завантаження...</div></div> 
       <table class="list-teacher"></table>
    </div>
</div>
<script>
    show_teacher();
function show_teacher(){
    $.ajax({
        url: "module/journal/show_teacher_ajax.php",
        type: "POST",
        data:({'check':'one'}),
        beforeSend: function() {
        $('.preloader').show();
        },error:function(){show_teacher();},
        complete: function() {
            $('.preloader').hide();
        },success:function(data){
            $('.list-teacher').html(data);

        }
    })
}

change();
function change(){
    $('html').on('click','.tr-teacher-leavel-two',function(e){    
    var id_code = $(this).attr('data-id-code');
    var id_teacher = $(this).attr('data-id-teacher');
    var teacher =  $('[data-id-teacher='+id_teacher+'].tr-teacher-leavel-one').find('.show-teacher-name input').val();
    var code =  $('[data-id-code='+id_code+'].tr-teacher-leavel-one').find('.show-teacher-code input').val();
    if($(e.target).is('.change')){   
    send(id_teacher,id_code,teacher,code,'change');
 
    }else if($(e.target).is('.delete')){
        if(confirm("Ви дійсно хочете видалити - "+teacher+"?"))
    send(id_teacher,id_code,teacher,code,'delete');
    }
    })
}

function send(id_teacher,id_code,name,code,action){
    $.ajax({
        url:"/module/journal/change_teacher_ajax.php",
        type:"POST",
        data:({
            "id_teacher":id_teacher,
            "id_code":id_code,
            "name":name,
            "code":code,
            "action":action
        }),
        beforeSend: function() {
        $('.preloader').show();
         $('.list-teacher').html(" ");
        },
        complete: function() {
            $('.preloader').hide();
            show_teacher();       
        },
        error: function() {
            setTimeout(function () {
                error_prelodaer()
                    send(id_teacher,id_code,name,code,action);
                }, 1000)     
        }
        ,success:function(data){
            console.log(data);
        }
    })
}
function error_prelodaer(){
     $('.preloader div').html('Намагаюся з\'єднатися...');
}

$('html').on('click','.add',function(){
   var name =  $('.add-teacher input').val();
    if(name.replace(/^\s+|\s+$/g, '')){
        add();
    }else{
        alert("Поле пусте.");
    }              
})

/*function gen(name,id_teacher){
        $.ajax({
        url: "module/journal/temp.php",
        type: "POST",
        data:({
            'name':name,
            'id_teacher':id_teacher
        }),
        beforeSend: function() {
        $('.preloader').show();
        },
        complete: function() {
            $('.preloader').hide();
        },success:function(data){
            show_teacher();
        }
    })
}*/
    
function add(){
    $.ajax({
        url:"/module/journal/add_teacher_ajax.php",
        type:"POST",
        data:({
            "name_teacher":$('.add-teacher input').val()
        }),
        beforeSend:function(){
            $('.preloader').show();
        },
        complete:function(){
            $('.preloader').hide();
            show_teacher();
        },success:function(data){
            if($.trim(data) == 'error_format'){
                alert('Невірний формат.');
            }else
            $('.add-teacher input').val("");

        }
    })
}



</script>

<?php }else{
    header("Location: ".SITE); 
    exit();
}

?>

