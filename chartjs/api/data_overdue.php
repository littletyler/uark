<?php

header('Content-Type: application/json');

/**
 * filename: data2.php
 * description: this will return the score of the teams.
 */

//setting header to json

session_start();
$host="localhost"; // Host name 
$username="tylerguy_tyler"; // Mysql username 
$password="tylerguy!!!"; // Mysql password 
$db_name="tylerguy_uark"; // Database name 
$tbl_name="rental"; // Table name 

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

$query="Select * From Rental Where (Date_Returned is null) AND (Date_Due < CURDATE())";

//execute query
$result = mysql_query($query);

 $rows = array();
   while($r = mysql_fetch_assoc($result)) {
     $rows[] = $r;
   }

 print json_encode($rows);

?>