<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';
if($login->A() || $login->T()  || $login->S()){   
    $id_group = check_get('id_group');
    $id_predmet = check_get('id_predmet');
    $id_student = check_get('id_student');
    $href_download = ($id_student)?
    SITE."/module/journal/download/journal_generate_excel.php?check=one&id_student=$id_student":
    SITE."/module/journal/download/journal_generate_excel.php?check=all&id_group=$id_group&id_predmet=$id_predmet";
    $journal= new journal();
    $journal_name = $journal->return_journal(check_get('id_predmet'));   
?>
<div class="main_conainer journal">
     <div class="preloader"> <img width="220px;" src="../../img/gg.gif"><div style="text-align:center;">Завантаження...</div></div> 
    <div class="table ver">

    </div>
     <div class="button_journal download"><a target="_blank" href="<?php echo $href_download;?>">Скачать</a></div>
     <?php if(!isset($_GET['id_student']) && !$login->S()){?>
    <div class="form_date_journal">
        <div class="form_date_journal_container">
            <input type="date" class="date_journal_date">
            <textarea class="textarea_jounal_date"></textarea>
            <div class="button_journal">Зберегти</div>
        </div>
    </div> 
     <?php if($login->A()){?>
    <div class="editor">
        <div class="field_block_2">
             <div class="field_block_2">
            <div class="field_block_2">
                Нзава передмету: <input  value="<?php echo $journal_name;?>" type="text" class="predmer_name">
            </div>    
            <div class="field_block_2">
                Вчитель: <select style="margin-left:70px;"class="seletc_teacher"></select>
            </div>
                 <div class="button_journal change">Зміинити</div>
            </div>
            <div class="field_block_2 list-student">
            <table class="student_ student_yes">

            </table>
             <table class="student_ student_no">

            </table>
            </div>                   
        </div>     
         <div class="button_journal delete">Видалити</div>
    </div>
     <?php }}?>
</div>
<script>
    show_journal();
  
    function show_journal() {
        $.ajax({
            url: "<?php echo SITE;?>/module/journal/show_journal/show_journal_ajax.php",
            type: "POST",
            data: ({
                "predmet_id": "<?php echo check_get('id_predmet');?>",
                "id_student": "<?php echo check_get('id_student');?>",
                "check":"<?php echo (!check_get('id_student'))?"one_jounral":"all_journal";?>"
            }),error:function(){
                $('.table').html("");
                    notification('<div class="form-notification-content"><img src="<?php echo SITE;?>/img/ss.gif"></div>', "#fff", 1,300000);
                show_journal();
            },
            success: function(data) {
                $('.table').html(data);
            }
        })
    }
     <?php if(($login->A() || $journal->check_teacher($login->get_IdTeacher(),check_get('id_predmet')) || (!isset($_GET['id_student']) && $journal->access_curator($id_group,$login->get_IdTeacher(),check_get('id_predmet'))))){
           
     ?>
    change_journale();

    function change_journale() {
        var id_mark;
        $('body').on('click', 'td.journal-table-marks', function(e) {

            var t = e.target || e.srcElement;
            $(this).css('border-color', 'red', 'background-color', 'red');
            $(this).css('padding', '0px');
            var td = $(this);
            var elm_name = t.tagName.toLowerCase();
            if (elm_name == 'input') {
                return false;
            }
            var val = $(this).html();
            var code = '<input type="text" maxlength="1"id="edit" value="' + val + '" />';

            $(this).empty().append(code);
            $('#edit').focus();
            $('#edit')[0].setSelectionRange(val.length, val.length);

            onlyNumbers('#edit');

            id_mark = $.trim($(this).attr("data-marks-id"));

            $('#edit').blur(function() {
                var val = $(this).val();
                $(this).parent().empty().html(val);
                td.css('border-color', 'black');
                change_marks(val, id_mark);
                setTimeout(show_journal, 200);
            });
        });
    }

    function change_marks(ocenka, id_ocenka) {
        $.ajax({
            url: "<?php echo SITE;?>/module/journal/show_journal/change_journal.php",
            type: "POST",
            data: ({
                "mark": ocenka,
                "id_mark": id_ocenka,
                "check": "mark"

            }),
            success: function(data) {
                console.log(data)
            }
        });
    }

    $(window).keydown(function(event) {
        if (event.keyCode == 13) {
            $('#edit').blur();
        }
    });

    function onlyNumbers(el) {

        $(el).on("change keyup input click", function() {
            if (!this.value.match(/[^0-9]/g)) {
                this.value = this.value.replace(/[^0-9][Н]/g, "");
            } else {
                this.value = 'Н';
            }
        });

        return false;
    };

    var $form_date = $('.form_date_journal');
    var id_date = $(this).attr("data-date-id");
    $('html').on('click', '.journal-table-date', function(e) { //показать окно с вводом даты, описания data-date_description
        var date = $(this).attr("data-date");
        id_date = $(this).attr("data-date-id");
        $(".textarea_jounal_date").val($(this).attr("data-date_description"));
        $(".date_journal_date").val(date);
        $form_date.addClass('is-visible');


    })

    $form_date.on('click', function(event) { //скрыть окно
        if ($(event.target).is($form_date)) {
            $form_date.removeClass('is-visible');
        }
    });
    $(document).keydown(function(e) {
        if (e.keyCode === 27) {
            $form_date.removeClass('is-visible');
        }
    })

    $form_date.on('click', function(event) {
        if ($(event.target).is($('.form_date_journal .button_journal'))) { //изменить описание на дату
            change_journale_date(id_date);
            setTimeout(show_journal, 200);
            $form_date.removeClass('is-visible');
        }
    });

    function change_journale_date(id_date) {
        $.ajax({
            url: "<?php echo SITE;?>/module/journal/show_journal/change_journal.php",
            type: "POST",
            data: ({
                "check": 'date',
                "id_date":id_date,
                "date": $('.date_journal_date').val(),
                "description": $('.textarea_jounal_date').val()
            }),
            success: function(data) {
                if($.trim(data) =="ERROR_DATE"){
                    alert('Неможливо поставити меншу дату.')
                }
                console.log(data);
            }
        })
    }
    <?php if($login->A()){?>
    show_teacher();
    function show_teacher(){
        $.ajax({
            url: "<?php echo SITE;?>/module/journal/show_teacher_ajax.php",
            type: "POST",
            data: ({
                "id_journal": "<?php echo check_get('id_predmet');?>",
                "check":"three"
                
            }),error:function(){ 
                show_teacher();},
            success: function(data) {
                $('.seletc_teacher').html(data);
            }
        })  
    }
    remove_student();
    function remove_student(){
        $('html').on('click','.student_yes tr',function(e){    
              if(confirm('Ви дійсно хочете видалити студента '+$(this).find('td:nth-child(2)').html()+'?')){
            $(this).prependTo($('.student_yes'));
            $(this).prependTo($('.student_no'));
            calculation_height();
            set('.student_no','+');
            change_student("student_delete",$(this).attr('data-id-student'));
        }
        });
    }
    
    function set(table,symbol){
         calculation_height();
        $(table+' td:nth-child(3)').html(symbol);
    }

    add_student();
    function add_student(){
        $('html').on('click','.student_no tr',function(e){
            if(confirm('Ви дійсно хочете додати студента '+$(this).find('td:nth-child(2)').html()+'?')){
            $(this).prependTo($('.student_yes'));
            set('.student_yes','X');
            change_student("student_add",$(this).attr('data-id-student'));
        }
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
        $('.field_block_2 .student_').css('min-height',min_height+'px');
        
    }
     setTimeout(show_selected_student,700);
    function show_selected_student(){
        $.ajax({
            url:"<?php echo SITE;?>/module/journal/show_student_ajax.php",
            type:"POST",
            data:({
                "id_journal":$('th.journal-table-date').attr('data-date-id-journal'),
                "id_group":"<?php echo $id_group;?>",
                "check":"three"
            }),error:function(){
                 setTimeout(show_selected_student,200);
            },
            success:function(data){
                $('.list-student').html(data);
                 setTimeout(calculation_height,200);
            }
        })
    }
    
    function change_student(check,id_student){
        $.ajax({
            url:"<?php echo SITE;?>/module/journal/show_journal/change_journal.php",
            type:"POST",
            data:({
                "id_journal":$('th.journal-table-date').attr('data-date-id-journal'),
                "check":check,
                "id_student":id_student
            }),success:function(data){
                console.log(data)
                setTimeout(show_journal,200);
                setTimeout(show_selected_student,200);
            }
        })        
    }
    $('html').on('click','.button_journal.change',function(e){
        change_journal();
        //window.location.reload();
    });
    
    function change_journal(){
        $.ajax({
            url:"<?php echo SITE;?>/module/journal/show_journal/change_journal.php",
            type:"POST",
            data:({
                'journal_name':$('.predmer_name').val(),
                'id_teacher':$('.seletc_teacher').val(),
                'id_journal':"<?php echo check_get('id_predmet');?>",
                'check':'change_journal'
            }),error:function(){
                alert('Упс..');
            },complete:function(){
                window.location.reload();
            }
        })
    }
    
    $('html').on('click','.button_journal.delete',function(e){
        delete_journal();
        
    });
    
    function delete_journal(){
            $.ajax({
        url:"<?php echo SITE;?>/module/journal/show_journal/change_journal.php",
        type:"POST",
        data:({
            'id_journal':"<?php echo check_get('id_predmet');?>",
            'check':'delete_journal'
        }),
        beforeSend: function() {
        $('.editor').html("");
        $('.form_date_journal').html("");
        $('.table').html("");
        $('.preloader').show();
        },
        complete: function() {
          window.location.href = "<?php echo SITE."/index.php?s=about_group&id_group=".check_get('id_group');?>";
        },
        error: function() {
            setTimeout(function () {                
               delete_journal()           
                error_prelodaer();
                    show_student();                  
                },0);     
        },success:function(data){
                console.log(data)
            }
        })
    }
    <?php }}?>
    function error_prelodaer(){
     $('.preloader div').html('Намагаюся з\'єднатися...');
}
</script>
    <?php }else{
    header("Location: ".SITE); 
    exit();
}?>