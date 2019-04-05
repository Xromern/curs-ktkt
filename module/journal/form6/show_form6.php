<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/module/classes/journal.php';
if($login->A() || $login->T()  || $login->S()){   
    $journal= new journal($dbj);
    $id_group = check_get('id_group');
    $id_student = check_get('id_student');
  
?>    
<div class="main_conainer form6">
    <?php if(($login->A() || $login->T()) && !$id_student){?>
    <select class="month">
        
           <?php $journal->show_month($id_group); ?>
    </select>
    <?php }?>
    <div class="table ver">

    </div>

</div>    
<script>
setTimeout(show_form6, 200);
        $('.month').change(function () {
            $('.table').html("");
            setTimeout(show_form6, 100);
            
        });            
function show_form6(){
    var  date =  $('.month :selected').text();
      $.ajax({
          url: "<?php echo SITE;?>/module/journal/form6/show_form6_ajax.php",
          type: "POST",
          data: ({
              "group": "<?php echo check_get('id_group');?>",
              "date": date,
              "id_student":"<?php echo check_get('id_student');?>"

          }),error:function(){show_form6();},
          success: function (data) {
              $('.table').html(data);       
          }
      });
}
<?php if($journal->check_curator($login->get_IdTeacher(), $id_group) || $login->A()){?>
$('html').on('click','.td_progul',function(e){

    change_missed($(this).attr('data-id-date'));
});

function change_missed(id){
    $.ajax({
        url:"<?php echo SITE;?>/module/journal/form6/change_form6_ajax.php",
        type:"POST",
        data:({
            id:id
        }),success:function(data){
            console.log(data)
            show_form6();
        }
    })
}

<?php }?>
</script>    
 
<?php }?>