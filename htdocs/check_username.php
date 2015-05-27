<?php
mysql_connect('localhost', 'root', '');  
mysql_select_db('webtech');  
  
//get the username  
$username = mysql_real_escape_string($_POST['username']);  
  
//mysql query to select field username if it's equal to the username that we check '  
$result = mysql_query('select username from users where username = "'. $username .'"');  
  
//if number of rows fields is bigger them 0 that means it's NOT available '  
if(mysql_num_rows($result)>0){  
    echo 0;  
}else{  
    echo 1;  
}  
?>