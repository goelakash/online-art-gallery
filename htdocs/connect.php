  <?php
  require_once('connect_param.php');

  // Connect to the database 
  class Connect{
  public
  function get_conn(){
  	$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
//	if($dbc) echo "Got it";
//	else "didnt connect";
	if($conn->connect_error) die("Connection failed: " . $conn->connect_error);
	return $conn;
	
  } 
  };
  
  function email_filter($a){
  return filter_var($a,FILTER_SANITIZE_EMAIL);
  }
 	
  ?>