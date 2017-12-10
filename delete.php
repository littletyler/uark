<?php
    if(!isset($_COOKIE['testsqlcookiez'])) {
        header("location:../../sql2.php");
    }

    mysql_connect('localhost','tylerguy_tyler','tylerguy!!!');

    mysql_select_db('tylerguy_uark');
    
    $id = (int)$_GET["del"];

    mysql_query("DELETE FROM Actor WHERE ActorID = ".$_GET['del']."");

    echo "actor is deleted";

    header('Location: template.php');
?>
