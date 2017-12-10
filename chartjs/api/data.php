<?php

header('Content-Type: application/json');

/**
 * filename: data.php
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

$query="SELECT Date_Rented, COUNT(DISTINCT(Rental_ID)) as rentals, Unit_ID FROM Rental where Date_Rented != '0000-00-00' GROUP BY Date_Rented";

//execute query
$result = mysql_query($query);

 $rows = array();
   while($r = mysql_fetch_assoc($result)) {
     $rows[] = $r;
   }

 print json_encode($rows);

?>