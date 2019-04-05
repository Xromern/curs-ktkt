
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/module/register/form_login.php';?>
    <div class="header_top_container_logo"><img class="logo" width="220px" src="<?php echo SITE;?>/img/22.png"></div>
   <section class="header_top">
        <div class="info_user">
      <div class="menu_login">
          
         <?php
         
         if(!empty($login)){
            try_login($login->Flag());
         }
            ?>
       
      </div>
   </div>
   <script >
jQuery(document).ready(function($) {

    var $form_modal = $('.cd-user-modal'),
        $form_login = $form_modal.find('#cd-login'),
        $form_signup = $form_modal.find('#cd-signup'),
        $form_forgot_password = $form_modal.find('#cd-reset-password'),
        $form_modal_tab = $('.cd-switcher'),
        cd_user_modal_container = $('.cd-user-modal-container'),
        $tab_login = $form_modal_tab.children('li').eq(0).children('a'),
        $tab_signup = $form_modal_tab.children('li').eq(1).children('a'),
        $forgot_password_link = $form_login.find('.cd-form-bottom-message a'),
        $back_to_login_link = $form_forgot_password.find('.cd-form-bottom-message a'),
        select_form_login = $('.select-form-login'),
        select_style_none = $('.select-style-none'),
        form_login_code = $('.form-login-code'),
        $main_nav = $('.user0');
    var flag = true;
    $(".reg").click(function() {

        active_butttton(ajax_register);

    })
    $(".login_in").click(function() {

        active_butttton(ajax_login);


    })

    function active_butttton(func) {
        if (flag === true) {
        func();
            setTimeout(function() {
                $(".cd-user-modal .button_journal").removeClass('button-no-active');
                flag = true;
            }, 3000)
        }
        flag = false;
        $(".cd-user-modal .button_journal").addClass('button-no-active');
    }




    var ajax_login = function() {
        $.ajax({
            url: "<?php echo SITE;?>/module/register/login.php",
            type: "POST",
            data: ({
                "login": $("#signin-login").val(), 
                "password": $("#signin-password").val()                                                     
            }),
            success: function(data) { 
                var data = JSON.parse(data);
                if ($.trim(data['error']) == "true") {
                    notification(
                        '<div class="form-notification-content">Ви авторизувались!</div>', "#fff", 1);
                    setTimeout(function() {
                        location.reload()
                    }, 1000)
                } else {
                    notification('<div class="form-notification-content">' + data['error'] + '</div>', "#fff", 1);
                }
          }
        })

    }
    form_login_code.prop('disabled', true);
    select_form_login.change(function() {
        var val = select_form_login.val();
        if (val == 1) {
            select_style_none.addClass('select-style-none');
            form_login_code.val("");
            form_login_code.prop('disabled', true);
        } else if (val == 2) {
            form_login_code.val("");
            form_login_code.prop('disabled', false);
            select_style_none.removeClass('select-style-none');
        }
    })


    var ajax_register = function() {
        $.ajax({
            url: "<?php echo SITE;?>/module/register/register.php",
            type: "POST",
            data: ({
                "select":select_form_login.val(),
                "code": $(".form-login-code").val(),
                "login": $("#signup-username").val(),
                "email": $("#signup-email").val(),
                "password": $("#signup-password").val()

            }),
            success: function(data) {console.log(data)
                var data = JSON.parse(data);
                
                if ($.trim(data['flag']) == "true") {
                    notification('<div class="form-notification-content">'+data["string"] +'</div>', "#fff", 1);
                    setTimeout(function() {
                     location.reload()
                    }, 3000)
                } else if ($.trim(data['flag']) == "false") {
                    notification('<div class="form-notification-content">' + data['error'] + '</div>', "#fff", 1);
                }
            }
        })
    }



    $main_nav.on('click', function(event) { //если клик по .main-nav
        //показать форму
        $form_modal.addClass('is-visible');
        if ($(event.target).is('.signup')) {

            signup_selected();
            cd_user_modal_container.animate({
                top: "20px"
            }, 500);
        } else {
            login_selected();
            cd_user_modal_container.animate({
                top: "20px"
            }, 500);
        } //если клик по cd-signin показываю вкладку с регистрацией,     
        //а если нет, со входом.
    });

    //закрываю окно
    $('.cd-user-modal').on('click', function(event) {
        if ($(event.target).is($form_modal) || $(event.target).is('.cd-close-form')) { //если клик по пустому протранству или по крестику 
            $form_modal.removeClass('is-visible');
            cd_user_modal_container.css({
                "top": "-200px"
            });
        }
    });

    $(document).keyup(function(event) {
        if (event.which == '27') { //закрыть форму по кнопке "Esc"
            $form_modal.removeClass('is-visible');
        }
    });

    //переключение вкладок
    $form_modal_tab.on('click', function(event) { //если клик по cd-switcher
        ($(event.target).is($tab_login)) ? login_selected(): signup_selected(); //если кликнутый елемент является кнопкой "Войти" то показываю фому Войти, а если нет форму с регистрацией
    });


    $forgot_password_link.on('click', function(event) {
        forgot_password_selected(); //показать вкладку забыл пароль
    });


    $back_to_login_link.on('click', function(event) {
        login_selected(); // вернуться к форме логина из формы забытого пароля
    });

    function login_selected() { //если выбрана вкладка "Войти"
        $form_login.addClass('is-selected'); // показываю форму логина
        $form_signup.removeClass('is-selected'); // скрываю форму регистрации
        $form_forgot_password.removeClass('is-selected'); // скрываю форму забыл пароль
        $tab_login.addClass('selected'); //кнопку "Войти" заливаю серым цветом
        $tab_signup.removeClass('selected'); //кнопку "Регистрация" делаю белой под цвет формы
    }

    function signup_selected() { //если выбрана вкладка "Регистрация"
        $form_login.removeClass('is-selected'); // скрываю форму логина
        $form_signup.addClass('is-selected'); // показываю форму регистрации
        $form_forgot_password.removeClass('is-selected'); // скрываю форму забыл пароль
        $tab_login.removeClass('selected'); //кнопку "Войти" заливаю серой
        $tab_signup.addClass('selected'); //кнопку "Регистрация" делаю белой под цвет формы
    }

    function forgot_password_selected() { //если выбрана вкладка "Забыл пароль"
        $form_login.removeClass('is-selected'); // скрываю форму логина
        $form_signup.removeClass('is-selected'); // скрываю форму регистрации
        $form_forgot_password.addClass('is-selected'); // показываю форму регистрации забыл пароль
    }

});
    
</script>
   </section>
  
   <div class="stacik_header_midle"></div>
   <section class="header_midle">
      <nav class="dws-menu">
        <input type="checkbox" name="toggle" id="menu" class="toggleMenu">
        <label for="menu" class="toggleMenu"><i class="fa fa-bars"></i>Меню</label>
        <ul class="menu_ul">
           <div class="logo_menu"></div>
            <li><a href="<?php echo SITE;?>"><i class="fa fa-home"></i>Головна</a></li>
            <li>
                <input type="checkbox" name="toggle" class="toggleSubmenu" id="sub_m1">
                <a href="#"><i class="fa fa-shopping-cart"></i>Про коледж</a>
                <label for="sub_m1" class="toggleSubmenu"><i class="fa"></i></label>
                <ul>
                    <li><a href="/index.php?s=college&navigation=procollege">Історія коледжу</a></li>
                        <li><a href="/index.php?s=college&navigation=navchalna_baza">Навчальна база</a></li>
           
                    <li><a href="/index.php?s=college&navigation=kontakti">Контакти</a></li>
                    <li><a href="/index.php?s=college&navigation=simvolika">Символіка</a></li>
                    <li><a href="/gallery">Галерея</a></li>
                </ul>
            </li>
            <li>
                <input type="checkbox" name="toggle" class="toggleSubmenu" id="sub_m2">
                <a href="#"><i class="fa fa-cogs"></i>Вступникам</a>
                <label for="sub_m2" class="toggleSubmenu"><i class="fa"></i></label>
                <ul>
                    <li><a href="/index.php?s=college&navigation=vstupnikam">Інформація</a></li>
                    <li><a href="/index.php?s=college&navigation=pingotovchi_kyrsi">Підготовчі курси</a></li>

                </ul>
            </li>
              <li>
                <input type="checkbox" name="toggle" class="toggleSubmenu" id="sub_m1">
                <a href="#"><i class="fa fa-shopping-cart"></i>Студентство</a>
                <label for="sub_m1" class="toggleSubmenu"><i class="fa"></i></label>
                <ul>
                    <li><a href="/index.php?s=college&navigation=studrada">Студентське самоврядування</a></li>

                </ul>
            </li>
                <li><a href="#"><i class="fa fa-envelope-open"></i>Викладачам</a></li>
                 <li><a href="#"><i class="fa fa-home"></i>Навчання</a></li>
        </ul>
    </nav>
   </section>

