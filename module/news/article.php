
<div class='main-news item'>
              
<div class="left-news item">
<div class="article">
<?php
$id_news= check_get('id');

$result=mysqli_query($link,"SELECT `id`,`id_author`,`caption`,`span`,`main_span`,`img`,`date_s` FROM `news` WHERE `id`=$id_news") or die(mysqli_error($link)); 
$row=mysqli_fetch_array($result);
list($id,$id_author,$caption,$span,$main_span,$img,$date_s)=$row;
$author = $_news->return_name_author($id_author);
echo "<div class='container-artiicle'><div class='caption-item'>$caption</div><div class='caption-item author'><i><a href='#'>$author</i></a></div>";
echo "<div class='conataier-article'>$main_span</div></div>";
if($login->A() || $_news->check_article_teacher($id_news)){
echo "<form id='container-texteditor-article' action='ajaxupload.php' method='post' enctype='multipart/form-data'>";
?>
        <div class="container_block block-preview editor-news" style="">
        <div>
        <label>Назва</label><br><br><input type="text" class="title" value='<?php echo $caption;?>' name="title"><br>
        <label>Коротркий опис</label><br><textarea class="description-text-area" name="description"><?php echo $span;?></textarea> <br>
        <label>Зображення</label><br> <input id="uploadImage" type="file" accept="image/*" name="image" /><br><br>
        </div>
        <div href="#"class="container-news">
          <div class="block_news">
             <div class="container_img_news">
                <a href="#">
                    <img src='<?php echo SITE.'/img/news_img/'.$img;?>'</a>
             </div>
             <div class="content_news">
                <div class="date_id">
                   <div class="id">#</div>
                   <div class="date"><?php echo date('Y-m-d H:i:s');?></div>
                </div>
                <h4><a href="#"><?php echo $caption;?></a></h4>
                <div class="blcok_news_text"><?php echo $span;?>
                   <a href="#"></a>
                </div>
             </div>
    </div>
    </div>
    </div>
<?php

echo "<textarea id='editor_article' name='editor_article'>$main_span</textarea><input type='submit' class='button_journal save-article' value='Зберегти'></form>";

        echo '<div class="button_journal close-editor">Закрити редактор</div><div class="button_journal delete-article">Видалити</div><div class="button_journal change-article">Відкрити редактор</div>';
}
 if(!$login->Flag()){
   echo '<div class="form_login_news_one">';
   try_login($login->Flag());
   echo '</div>';
}else{
?>
    <div class="containet-comment-editor">       
        <textarea id="editor_comment"></textarea>
        <div class="button_journal comment-send">Відправити</div>
    </div>
<?php }?> 
<div class="comment-block"></div>

</div>

</div>
    <div class="right-news">
   
<?php
include 'aside.php';
?>     

</div>
    </div>

<script>
    
    var editor_comment = $('#editor_comment');
    var editor_article = $('#editor_article');
    var containet_comment_editor = $('.containet-comment-editor');
    var comment_block = $('.comment-block');
    var button_change = $('.change-article');
    var button_close = $('.close-editor');
    var container_artiicle=$('.container-artiicle');
    var container_texteditor_article = $('#container-texteditor-article');
    var delete_editor = $('.delete_editor');
  function redactor_comments(){
     tinymce.init({
         selector: '#editor_comment',
         height: 200,
         language: "uk",
         theme: "modern",
         menubar: false,
         plugins: 'link',
         toolbar1: 'bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat'
     });
 }

redactor_comments();
 show_comment();

 function show_comment() {
     comment_block.html("");
     $.ajax({
         url: "<?php echo SITE;?>/module/news/comment_show_ajax.php",
         type: "POST",
         data: ({
             "id_news": "<?php echo $id_news;?>"
         }),
         success: function(data) {
             $('.comment-block').html(data);

         }
     })
 }
 $('html').on('click', '.comment-send', function() {
     send_comment();
 })

 function send_comment() {
     $.ajax({
         url: "<?php echo SITE;?>/module/news/comment_send_ajax.php",
         type: "POST",
         data: ({
             "id_news": "<?php echo $id_news;?>",
             "text_comment": tinymce.get("editor_comment").getContent()
         }),
         success: function() {
             tinymce.activeEditor.setContent('');
             show_comment();
         }
     })
 }
<?php if($login->A() || $_news->check_article_teacher($id_news)){?>
 function editor_arcticle() {
    tinymce.init({
        selector: '#editor_article',
        height:"700px",
        language: "uk",
        theme: "modern",
        plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media codesample charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker',
        toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat'
    });
 }
 
 $('html').on('click','.delete-article',function(){
     if(confirm('Ви дійсно хочете видалити новину?')){
     delete_article();
     location.href='<?php echo SITE;?>';
    }
 })
 
 function delete_article(){
    $.ajax({
        url:"<?php echo SITE;?>/module/news/delete_article_ajax.php",
        type:"POST",
        data:({"id":'<?php echo $id_news;?>'}),
        success:function(data){
            
        }
    })
 }
 
 $('html').on('click', '.change-article', function() {
    button_change.hide();
    container_artiicle.hide();
    button_close.show();
    tinymce.execCommand('mceRemoveControl',true,'editor_id');
    containet_comment_editor.hide();
    editor_arcticle();
    container_texteditor_article.show();
 });

  $('html').on('click', '.close-editor', function() {
    button_change.show();
    container_artiicle.show();
    button_close.hide();
    containet_comment_editor.show();
    container_texteditor_article.hide();
 });
 
 
container_texteditor_article.on('submit', (function(e) {
  e.preventDefault();
  let formData =  new FormData(this);
  formData.append("id", <?php echo $id;?>);
  formData.append("text", tinyMCE.get('editor_article').getContent());  
  send_article(formData,'<?php echo SITE;?>/module/news/article_change.php');
}));
change_block_news();
<?php }?>
</script>
