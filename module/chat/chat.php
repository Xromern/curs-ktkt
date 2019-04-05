<div class="chat_main">
<?php
if($login->S()){

?>	


    <div class="container_chat" >
	<div class="container_chat_two">
   
		<div class="chat" id="chat">


	</div>
			<textarea class="text_area_chat" id="text_area_chat"> </textarea>
		<div id="message_send_chat" class="message_send_chat">Відправити</div>
</div>
</div>

<?php	
}
?>
</div>
<style>

.chat_main{
	min-height:600px;
	box-sizing:border-box;

	margin-top:-20px    ;
	width:100%;
}
.container_chat_two{

}
.container_chat{
		width:600px;
	margin:0 auto;
}
.message_send_chat{
	width:200px;
	max-height:40px;
	background-color:#163C94;
	opacity:0.8;
        cursor: pointer;
	
}
.message_send_chat:hover{
	opacity:1;
        color:#ffffff;
	
}
.chat{
	width:600px;
	height:400px;
	background-color:#ffffff;
	border:2px solid #000000;
	overflow:auto;
}
.message_chat{

    min-height: 80px;
}
.text_area_chat{
	margin:10px 0;
	
	width:600px;
	height:80px;

}
.container_message{

        width:500px;
	display:inline-block;
}
.message_name{
	font-weight:bold;
	color:red;
	display:inline-block;

}
.message_data{
	float:right;
}
.img_message{
	display:inline-block;
	float:left;
	margin-right:15px;
	margin-left:10px;
        width:60px;
        height: 60px;
        background-color: brown;
        border-radius: 60px;
        text-align: center;
      line-height: 55px;
      font-size: 30px;


}

.message{
    width:400px;
    word-wrap: break-word ;
}
.footer{
	display:none;
}
.header_midle{
    position: absolute;
    top:0;
}
.menu_login_header{
    margin-top: 60px;;
}
html{
    overflow: hidden;
}
.message_data{
    color:#C9C9C9;
}
</style>

<script>
jQuery("document").ready(function($){      
user_name = "<?php echo $student['username'];?>";
group_name = "<?php echo $student['group_name'];?>";
id_student = "<?php echo id_student($link);?>";
group = "<?php echo group_student($link);?>"
console.log(user_name, group_name)

function send_message_click(){
     if($("#text_area_chat").val()!="" && $("#text_area_chat").val()!=" " && $("#text_area_chat").val()!="  "){
    get_message();
    send_message();
    $("#text_area_chat").val(" ");
    }
}
$('#message_send_chat').click(function() {
   send_message_click();
})

$(window).keydown(function(event) {
if(event.ctrlKey  && event.keyCode == 13){
     send_message_click();
  }
})

function scroll_message() {
    $("#chat").scrollTop($("#chat").prop('scrollHeight'));

}

function send_message() {
    $.ajax({
        url: "module/chat/ajax_char.php",
        type: "POST",
        data: ({
            "message": $("#text_area_chat").val(),
            "user_name": user_name,
            "group_name": group_name,
            "id_student": id_student

        }),
        success: function(data) {   
get_message();
   setTimeout(scroll_message, 100);
        }

    })
}
get_message();
function get_message() {
    $.ajax({
        url: "module/chat/get_message_ajax.php",
        type: "POST",
        data: ({
            "group": group

        }),
        success: function(data) {
            try_bottom_scroll();
            $('#chat').html(data);

        }

    })

}
function try_bottom_scroll(){ 
    var scrollHeights = document.getElementById("chat").scrollHeight;
    if  ($('#chat').scrollTop() >= scrollHeights- $('#chat').height() )
     {
       
        setTimeout(scroll_message, 100);
      }
 }

//setInterval(try_bottom_scroll, 600);
setInterval(get_message, 2000);
setTimeout(scroll_message, 100);
$('.container_chat').click(function(){
    
   try_bottom_scroll();
})
})
</script>