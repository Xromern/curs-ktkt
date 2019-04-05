<?php
 if(!empty($login)) {
     unset($login);
 setcookie('username', '', time()-1, '/');
 setcookie('password', '', time()-1, '/');
     session_start();
     session_destroy();
   echo '<script>setTimeout(function(){location.replace("index.php");}, 0000)</script>';
 } else {
 echo '<script>setTimeout(function(){location.replace("index.php");}, 0000)</script>';
}