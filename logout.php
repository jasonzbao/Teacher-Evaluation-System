<?php
unset($_COOKIE['eusername']);
unset($_COOKIE['epassword']);
setcookie('eusername', "", time()-100);
setcookie('epassword', "", time()-100);
unset($_COOKIE['ausername']);
unset($_COOKIE['apassword']);
setcookie('ausername', "", time()-100);
setcookie('apassword', "", time()-100);
header('Location:home.php');

?>