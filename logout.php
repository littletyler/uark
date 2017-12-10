<?php
session_start();
unset($_SESSION);
session_destroy();
session_write_close();
header('Location: /uark/public_login.html');
die;
?>