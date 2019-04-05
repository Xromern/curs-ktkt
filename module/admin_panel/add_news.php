<form id="form-add-news" action="ajaxupload.php" method="post" enctype="multipart/form-data">
    <div class="container_block block-preview" style="">
        <div>
        <label>Назва</label><br><br><input type="text" class="title" name="title"><br>
        <label>Коротркий опис</label><br><textarea class="description-text-area" name="description"></textarea> <br>
        <label>Зображення</label><br> <input id="uploadImage" type="file" accept="image/*" name="image" /><br><br>
        </div>
        <div href="#"class="container-news">
          <div class="block_news">
             <div class="container_img_news">
                <a href="#">
                <img ></a>
             </div>
             <div class="content_news">
                <div class="date_id">
                   <div class="id">#</div>
                   <div class="date"><?php echo date('Y-m-d H:i:s');?></div>
                </div>
                <h4><a href="#">&nbsp</a></h4>
                <div class="blcok_news_text">&nbsp
                   <a href="#"></a>
                </div>
             </div>
    </div>
    </div>
    </div>

    <div class="container_block">
        <label>Текст</label><br><textarea class="editor" id="texteditor" name="textarea"></textarea>
    </div>
    <input id="button" class="button_journal" type="submit" value="Запостити">
    

</form>

<script>

editor1();
function editor1() {
    $('.editor').html("");
    tinymce.init({
        selector: '.editor',
        language: "uk",
        theme: "modern",
        plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern',
        toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat'
    });
}
 
change_block_news();

$('#form-add-news').on('submit', (function(e) {
  e.preventDefault();
  let formData =  new FormData(this);
  formData.append("textarea", tinyMCE.get('texteditor').getContent());  
  send_article(formData,"module/admin_panel/add_news_ajax.php",'add');
  
}));
        
</script>
