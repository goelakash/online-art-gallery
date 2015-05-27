<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>


<?php
echo "redirecting <br/>";

session_start();

require_once("connect.php");
require_once("connect_param.php");
$dbc = new Connect();
$conn = $dbc->get_conn();
//$conn = new mysqli('localhost','root','','webtech');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
else{
	echo "Conection done!!<br>";
}
//sanitize
$user = email_filter($_POST['username']);
$pass = $_POST['password'];
//$pass = (md5(sanitize($_POST['password'])));
$table = "users";

$query = "SELECT * FROM $table WHERE username = '$user' AND password = '$pass' ";
//echo $query;
//$query = 'SELECT * FROM users';

$result = $conn->query($query);
if ($result->num_rows > 0){
    // output data of each row
    $row = $result->fetch_assoc() ;
        echo "<br> Hello " . $row["username"]. "! " ;
		$_SESSION['status']='authorized';
		$_SESSION['username']=$user;
    
} else{
    echo "0 results";
}
$conn->close();
header('Location: user_home.php'); 
/*$stmt = $conn->prepare($query);
$stmt = $conn->bind_param("sss",$table,$user,$pass);
$stmt->execute();
while($row = $stmt->fetch()){
	print_r("Hello ".$row['username']."! <br/> Welcome to the site! ");
}
*/
?>