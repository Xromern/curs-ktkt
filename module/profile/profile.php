<style> main div{margin: 0 auto;}</style>

    <div class="container-profile">
<?php
if($login->Flag()) {
?>
        <div class="container-prfile-block">
            <div class="menu">
                <a href="#">Головна</a>
                <a href="#">Повідомлення</a>
                <a href="#">Форма 6</a>
                <a href="#">Журнал</a>
                <?php if($login->T() || $login->A()){?>
                <a href="#">Додати новину</a>
                <?php }?>
            </div>
            
            <div class="content">

                <div class="content-container">
                    <div class="content-container-title">
                        Логін
                    </div>
                    <div class="content-container-content">
                         <?php echo $login->get_Username();?>
                    </div>
                </div>
                      
            <hr>
                <div class="content-container">
                    <div class="content-container-title">
                        Група
                    </div>
                    <div class="content-container-content">
                        <?php echo $login->get_Group_Name();?>
                    </div>
                </div>
            
                <div class="content-container">
                    <div class="content-container-title">
                        Email
                    </div>
                    <div class="content-container-content">
                        <?php echo $login->get_Email();?>
                    </div>
                </div>
            <hr>
        </div>
        
<?php             
} 
?>
        </div>
