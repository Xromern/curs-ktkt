<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';
if($login->A() || $login->T()){ 
    
?>



<div class="main_conainer show-student">
    <div class="field_block_2">
        <div class="add-student"><input placeholder="П.І.П."><div style="float:right" class="button_journal add">Додати</div></div>
    </div>
    <div class="field_block_2">       
       <div class="preloader"> <img width="220px;" src="../../img/gg.gif"><div style="text-align:center;">Завантаження...</div></div> 
       <table class="list-student"></table>
    </div>
</div>
<script>
    show_student();
function show_student(){
    $.ajax({
        url: "<?php echo SITE;?>/module/journal/show_student_ajax.php",
        type: "POST",
        data:({
           "id_group":<?php  echo check_get('id_group');?>,
           "check":"one"
        }),
        beforeSend: function() {
        $('.preloader').show();
        $('.list-student').html('');
        },
        complete: function() {
            $('.preloader').hide();
        },
        error: function() {
            setTimeout(function () {                
                $('.preloader').show();             
                error_prelodaer()
                    show_student()                   
                },0)     
        },success:function(data){
            console.log(data);
            $('.list-student').html(data);

        }
    })
}

change();
function change(){
    $('html').on('click','.tr-student-leavel-two',function(e){    
    var id_code = $(this).attr('data-id-code');
    var id_student = $(this).attr('data-id-student');
    var student =  $('[data-id-student='+id_student+'].tr-student-leavel-one').find('.show-student-name input').val();
    var code =  $('[data-id-code='+id_code+'].tr-student-leavel-one').find('.show-student-code input').val();
    if($(e.target).is('.change')){  
          $('.list-student').html('');
    send(id_student,id_code,student,code,'change');
    
    }else if($(e.target).is('.delete')){

        if(confirm("Ви дійсно хочете видалити - "+student+"?")){
        send(id_student,id_code,student,code,'delete');    

        show_student();
    }
    }
    })
}

function send(id_student,id_code,name,code,action){
    $.ajax({
        url:"<?php echo SITE;?>/module/journal/change_student_ajax.php",
        type:"POST",
        data:({
            "id_student":id_student,
            "id_code":id_code,
            "name":name,
            "code":code,
            "action":action
        }),
        beforeSend: function() {
        $('.preloader').show();
        },
        complete: function() {
            $('.preloader').hide();
            show_student();
        },success:function(data){
            console.log(data);
        }
    })
}

function error_prelodaer(){
     $('.preloader div').html('Намагаюся з\'єднатися...');
}

$('html').on('click','.add',function(){
   var name =  $('.add-student input').val();
    if(name.replace(/^\s+|\s+$/g, '')){
        add();
    }else{
        alert("Поле пусте.");
    }              
})

function add(){
    $.ajax({
        url:"<?php echo SITE;?>/module/journal/add_student_ajax.php",
        type:"POST",
        data:({
            "id_group":<?php echo check_get('id_group')?>,
            "name_student":$('.add-student input').val()
        }),
        beforeSend:function(){
            $('.preloader').show();
        },
        complete:function(){
            $('.preloader').hide();
            show_student();
        },success:function(data){
            if($.trim(data) == 'error_format'){
                alert('Невірний формат.');
            }else
            $('.add-student input').val("");
        }
    })
}
</script>
<?php }else{
    header("Location: ".SITE); 
    exit();
} 
?>

