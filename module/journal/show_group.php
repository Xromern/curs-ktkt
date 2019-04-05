<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';
if($login->A() || $login->T()){   
?>
<div class="main_conainer">
    <?php if($login->A()){?>

            <div class="field_block_2">
                <div class="field_block_1">
                    <div class="journal_id"></div>Група:<input class="field_input_group_name" type="text" placeholder="Група">

                </div>
  
                <div class="field_block_1">
                    Куратор:<select class="select_teacher select_teacher_add">
                        <option value="0">Куратор</option>
                        <?php
                        $journal = new journal($dbj);
                        $result = $journal->return_teacher(0, false);
                        while($row = mysqli_fetch_array($result)){
                            echo '<option value='.$row['id_teacher'].'>'.$row['name_teacher'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="add button_journal">Додати групу</div>
            </div>
                
                 <div class="field_block_1">
                     
                <a href="<?php echo SITE."/teacher";?>" class="container_group">
                        <div class="student">Вчителя</div>
              </a>

                </div>
    <?php }?>
        <div class="list_group"> 
 <div class="preloader"> <img width="220px;" src="../../img/gg.gif"><div style="text-align:center;">Завантаження...</div></div> 
        </div>
</div>
<script>
    show_list_group();
function show_list_group(){
    $.ajax({
        url:"<?php echo SITE?>/module/journal/show_group_ajax.php",
        type:"POST",
                beforeSend: function() {
        $('.preloader').show();
         $('.list-teacher').html(" ");
        },
        complete: function() {
            $('.preloader').hide();      
        },
        error: function() {
            setTimeout(function () {
                error_prelodaer()
                    show_list_group();
                }, 1000)     
        },
        success:function(data){
            $('.list_group').html(data);
            console.log(data)

        }
    })
}
function error_prelodaer(){
     $('.preloader div').html('Намагаюся з\'єднатися...');
}


$('html').on('click','.add',function(){
    $('.list-teacher').html(" ");
    add_group();
})
function add_group(){
    $.ajax({
        url:"module/journal/add_group_ajax.php",
        type:"POST",
        data:({
            "id_teacher":$('.select_teacher').val(),
            "group_name":$('.field_input_group_name').val()
        }),
        success:function(data){
            show_list_group();
            if($.trim(data)=="error_08dc4"){
                alert("Така група вже існує.");
            }
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
