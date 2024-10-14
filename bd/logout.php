<?php
session_start();
session_unset();
session_destroy();

header('Location:  ./html/login2.html');
exit;

?>