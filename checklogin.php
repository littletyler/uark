<?php
session_start();
$host="localhost"; // Host name 
$username="tylerguy_tyler"; // Mysql username 
$password="tylerguy!!!"; // Mysql password 
$db_name="tylerguy_uark"; // Database name 
$tbl_name="users"; // Table name 

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

// username and password sent from form 
$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword']; 


// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);

$sql="SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'";
$sql2="SELECT * FROM Online WHERE username='$myusername' and password='$mypassword'";
$result=mysql_query($sql);
$result2=mysql_query($sql2);



// Mysql_num_row is counting table row
$count=mysql_num_rows($result);
$count2=mysql_num_rows($result2);

if($count2==1){
$result2=mysql_fetch_array($result2);
$role = $result2['Account_Type'];
$role1 = $result2['username'];
$role2 = $result2['Customer_ID'];
if($role =='Administrator'){
 $link = '/uark/reports.php';
 }
elseif($role == 'Employee'){
 $link = '/uark/inventory.php';
 }
else{
    $link = '/uark/public_home.php';
}
 
// session Register $myusername, $mypassword and redirect to file "login_success.php"
$_SESSION['firstMessage'] = $role1;
$_session["myusername"] = $myusername;
$_session["mypassword"] = $mypassword;
$_SESSION["role"] = $role;
$_SESSION["id"] = $role2;
header("Location: ".$link."");
}

else {



// If result matched $myusername and $mypassword, table row must be 1 row


if($count==1){
$result=mysql_fetch_array($result);
$role = $result['role'];
$role1 = $result['username'];


//page link on the basis of user role you can add more  condition on the basis of ur roles in db
if($role =='Administrator'){
 $link = '/uark/reports.php';
 }
elseif($role == 'Employee'){
 $link = '/uark/inventory.php';
 }
else{
    $link = '/uark/public_home.php';
}
 
// session Register $myusername, $mypassword and redirect to file "login_success.php"
$_SESSION['firstMessage'] = $role1;
$_session["myusername"] = $myusername;
$_session["mypassword"] = $mypassword;
$_SESSION["role"] = $role;
header("Location: ".$link."");
}

else {
echo "Wrong Username or Password";
}
}
?>