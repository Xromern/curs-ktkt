<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';
$journal = new journal($dbj);
$group_name = $journal->return_group_name(check_get('id_group'));

if($login->A() || $login->T() || $login->S()){   
?>


<div class="main_conainer about_group">
    <?php if($login->A()){ ?>
    <div class="button_journal show_add_journal">Додати журнал</div>
     <div class="button_journal hidden_add_journal">Список груп</div>
<div class="add_journal">
            <div class="field_block_2">
                <div class="field_block_1">
                    Вчитель:<select class="select_teacher"></select>
                </div>
                <div class="field_block_1">
                    Назва:<input type="text" class="input_predmet_name">
                </div>
            </div>
       
        <div class="button_journal_add button_journal">Додати журнал</div><br>
        <div class="field_block_2 student_select">
             <div class="preloader one"> <img width="220px;" src="../../img/gg.gif"><div style="text-align:center;">Завантаження...</div></div> 
            <table class="student_ student_yes">

            </table>
             <table class="student_ student_no">

            </table>
            
        </div>
   </div>  

<?php } if($login->A()){?>
     
     <div class="container_prdmet group_name">
                <div class="field_block_1">
           Куратор:<select class="select_teacher"></select>
       </div>
       <div class="field_block_1">
           Група:<input value="<?php echo $group_name;?>"style="margin-left:35px;"type="text" class="input_group_name">
       </div><br>
         <div class="button_change button_journal">Змінити</div><div class="button_delete button_journal">Видалити групу</div><br><br>
     </div>
     
<?php }?>
    <div class="container_prdmet">
      <?php if($login->A() || $login->T()){?>
        <a href="<?php echo SITE."/group_student/".$_GET['id_group'];?>" class="container_group">
                        <div class="student">Студенты</div>
         </a>
      <a href="<?php echo SITE."/formS/".check_get('id_group');?>" class="container_group">
                        <div class="student">Форма 6</div>
            </a>
      <?php }?>
    
      <?php if($login->S()){?>
                      <a href="<?php echo SITE."/journal"?>" class="container_group">
                        <div class="student">Журнали</div>
            </a>
        <a href="<?php echo SITE."/formS";?>" class="container_group">
                        <div class="student">Форма 6</div>
            </a>
          <?php }?>

    </div>
      <div class="preloader two"> <img width="220px;" style="margin: 0 auto;" src="../../img/gg.gif"><div style="text-align:center;">Завантаження...</div></div> 
    <div class="container_prdmet list">
    
    </div>
  </div> 
<script>
    $('html').on('click','.button_change',function(e){
        change_group();
        
    })
    
    function change_group(){
        $.ajax({
            url:"<?php echo SITE;?>/module/journal/change_group_ajax.php",
            type:"POST",
            data:({
                "check":"change",
                "id_teacher":$('.container_prdmet.group_name .select_teacher').val(),
                "group_name":$('.input_group_name').val(),
                "id_group":"<?php echo check_get('id_group');?>"
            }),complete:function(){
                setTimeout(function(){location.reload()},200);
            },error:function(){
                alert('Упс...');
            }
        })
    }
    
   show_teacher();
    function show_teacher(){
        $.ajax({
            url:"<?php echo SITE;?>/module/journal/show_teacher_ajax.php",
            type:"POST",
            data:({
                'check':'two',
                'id_group':"<?php echo check_get('id_group');?>"
            }),
            success:function(data){
                $('.select_teacher').html(data);
            }
        })
    }
    show_list_jounral()
    function show_list_jounral(){
        $.ajax({
            url:"<?php echo SITE;?>/module/journal/show_journal/show_list_journal_ajax.php",
            type:"POST",
            data:({'id_group':"<?php echo check_get('id_group');?>"}),
            beforeSend: function() {
            $('.preloader.two').show();
            $('.container_prdmet.list').html("");
            },
            complete: function() {
                $('.preloader.two').hide();
            },
            error: function() {
                setTimeout(function () {                
                    $('.preloader.two').show();             
                    error_prelodaer();
                         show_list_jounral();                  
                    },0);     
            },
            success:function(data){
                $('.container_prdmet.list').html(data);
            }
        });
    }


    function overload(){
        show_student();
        show_teacher();
        show_list_jounral(); 
        $('.container_prdmet').show();;
        $('.add_journal').hide();
        $('.hidden_add_journal').hide();
        $('.show_add_journal').show();
        $('.input_predmet_name').val("");
    }
    
    $('html').on('click','.button_journal_add',function(e){
        if($('.input_predmet_name').val()!=""){
        add_journal();
        setTimeout(overload,200);
        }else{
        alert("Поле пусте.")
        }
    });
        
    function add_journal(){
    $.ajax({
        url:"<?php echo SITE;?>/module/journal/show_journal/add_journal_ajax.php",
        type:"POST",
        data:({
            'id_group':"<?php echo check_get('id_group');?>",
            'id_teacher':$('.select_teacher').val(),
            'journal_name':$('.input_predmet_name').val(),
            'string_id': create_journal()
        }),success:function(data){
            show_teacher();
        }
    })
    }
    
    function create_journal(){
        var length =  $('.student_yes tr').length;   
        var array = [];
        for(var i = 1;i<=length;i++){
            array.push($('.student_yes tr:nth-child('+[i]+')').attr('data-id-student'));          
        }
        return array.join('*%%*');       
    }
    
    remove_student();
    function remove_student(){
        $('html').on('click','.student_yes tr',function(e){    
            
            $(this).prependTo($('.student_no'));
            calculation_height();
            set('.student_no','+');
        });
    }
    
    function set(table,symbol){
         calculation_height();
        $(table+' td:nth-child(3)').html(symbol);
    }

    add_student();
    function add_student(){
        $('html').on('click','.student_no tr',function(e){
            $(this).prependTo($('.student_yes'));
            set('.student_yes','X');
        });
    }
    
    show_student();
    function show_student(){
        $.ajax({
            url:"<?php echo SITE;?>/module/journal/show_student_ajax.php",
            type:"POST",
            data:({
                "id_group":"<?php echo check_get('id_group')?>",
                "check":"two"
            }),
        beforeSend: function() {
        $('.preloader.one').show();
        $('.student_').html("");
        },
        complete: function() {
            $('.preloader.one').hide();
        },
        error: function() {
            setTimeout(function () {                
                $('.preloader.one').show();             
                error_prelodaer();
                    show_student();                  
                },0);     
        },success:function(data){
                $('.student_yes').html(data);
            }
        });
    }

    
    function calculation_height(){
        var length = $('.student_no tr').length;
        var min_height = length*35.3;
        $('.student_select').css('min-height',min_height+'px');
        
    }
    
    $('html').on('click','.show_add_journal',function(e){
        $('.container_prdmet').hide();
        $('.add_journal').show();
        $(this).hide();
        $('.hidden_add_journal').show();

    });

    $('html').on('click','.hidden_add_journal',function(e){
       $('.container_prdmet').show();;
       $('.add_journal').hide();
       $(this).hide();
       $('.show_add_journal').show();
   });
   
    $('html').on('click','.button_delete',function(e){
        if(confirm("Ви дісно хочете видалити групу?"))
    delete_group();

    })
   
   function delete_group(){
       $.ajax({
           url:"<?php echo SITE;?>/module/journal/change_group_ajax.php",
           type:"POST",
           data:({
               "check":"delete",
               "id_group":"<?php echo check_get('id_group'); ?>"
           }),complete: function() {
            window.location.href="<?php echo SITE;?>"+"/index.php?s=show_group";
            }
           ,success:function(data){
               console.log(data);
           }
       })
   }
</script>
<?php
}else{
    header("Location: ".SITE); 
    exit();
}
?>
