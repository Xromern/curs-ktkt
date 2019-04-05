 
function send_article(formData,url,check){
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            if(check=="add"){
            let datas = JSON.parse(data);
            if(datas['error']!=null){
                 notification("Сталася помилка.",'black',1,time=3000);
            }else{
            window.location.href=location.hostname;
            }
            
        }
            if (data == 'invalid file') {
                notification("Invalid File !",'black',1,time=3000);
            }else{
               window.location.reload();
            }
        },error:function(){
            notification("Сталася помилка.",'black',1,time=3000);
        }
    });
}

function change_block_news(){
$("#uploadImage").on("change", function () {
if (this.files[0]) {
var fr = new FileReader();
fr.addEventListener("load", function () {
    $(".container_img_news img").attr('src',fr.result)
}, false);

fr.readAsDataURL(this.files[0]);
}
});

$('.title').on('input',function(){
    $('.container-news h4>a').html($(this).val())
})

$('.description-text-area').on('input',function(){
    $('.blcok_news_text').html($(this).val())
})
}

