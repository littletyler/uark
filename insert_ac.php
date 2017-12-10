<?php

$host="localhost"; // Host name 
$username="tylerguy_tyler"; // Mysql username 
$password="tylerguy!!!"; // Mysql password 
$db_name="tylerguy_uark"; // Database name 
$tbl_name=$_POST['table']; // Table name 

// Connect to server and select database.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

// Get values from form 
$name=$_POST['name'];
$lastname=$_POST['lastname'];
$ActorID=$_POST['ActorID'];

// Insert data into mysql 
$sql="INSERT INTO $tbl_name(firstname, lastname)VALUES('$name', '$lastname')";
$result=mysql_query($sql);

// if successfully insert data into database, displays message "Successful". 
if($result){
echo "Successful";
echo "<BR>";
echo "<a href='sql2.php'>Back to main page</a>";
header('Location: template.php');
}

else {
echo "ERROR";
}
?> 

<?php 
// close connection 
mysql_close();

header('Location: template.php');

?>