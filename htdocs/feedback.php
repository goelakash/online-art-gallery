
<?php
session_start();
if(!isset($_SESSION['status'])||$_SESSION['status']!='authorized'){
	$_SESSION['status']='unauth';
	$_SESSION['username']='Guest';
	header('Location:index.php');
}
	
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<title>artists.net</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.dropotron-1.0.js"></script>	
		<script type="text/javascript" src="js/jquery.slidertron-1.0.js"></script>
		<script type="text/javascript" src="js/jquery.poptrox-1.0.js"></script>
		<script type="text/javascript">
			$(document).ready(function () {
			$('#session').click(function () {
					if ($('#signin-dropdown').is(":visible")) {
						$('#signin-dropdown').hide()
						$('#session').removeClass('active');
					} else {
						$('#signin-dropdown').show()
						$('#session').addClass('active');
					}
					return false;
				});
				$('#signin-dropdown').click(function(e) {
					e.stopPropagation();
				});
			$(document).click(function() {
					$('#signin-dropdown').hide();
					$('#session').removeClass('active');
				});
			});     
		</script>
		    <style type="text/css">
			.upload_span{
			width:200px;
			display:inline-block;
			}
			
			</style>

	</head>
	<body>
		
	<div id="outer">
		
			<div id="logo">
				<h1><a href="index.php">artists<span>.net</span></a></h1>
			</div>
		
				
			<ul id="nav">
				<li>
					<a href="index.php" id="item">Home</a>
				</li>
				<li>
					<a href="browse.php" id="item">Browse</a>
				</li>				
				<li>
					<a href="about.php" id="item">About</a>
				</li>
				<?php
				if($_SESSION['username']!='Guest'){
				echo'
				<li>
					<a href="logout.php" id="item">Logout</a>
				</li>					
				<li class="user_name">
					 Hello '.$_SESSION['username'].'! 
				</li>
				<li style="float:right" class="first active">
					<a href="user_home.php">Home<a>
				</li>
				';
				}
				else{
				
				echo 
				'<li class="active-links">
      				<div id="session">
						<a id="signin-link" href="#">Login</a>
					</div>
				  <div id="login-content">
	        		  <div id="signin-dropdown">
							  <form method="post" class="signin" action="login.php">
								<fieldset class="textbox">
								<label class="username">
								<span>Username or email</span>
								<input id="username" name="username" value="" type="text" autocomplete="on">
								</label>
								
								<label class="password">
								<span>Password</span>
								<input id="password" name="password" value="" type="password">
								</label>
								</fieldset>
								
								<fieldset class="remb">
								<label class="remember">
								<input type="checkbox" value="1" name="remember_me" />
								<span>Remember me</span>								</label>
								<button class="submit button" type="submit">Sign in</button>
								</fieldset>
								<p>
								<a class="forgot" href="#">Forgot your password</a>
								<br>
								<a class="register" href="register.php">Don\'t have an account? Register!</a>								</p>
							  </form>
					  </div>
       			  </div>                     
    			
				</li>';	
				}
			
				?>
			</ul>


		<!-- ****************************************************************************************************************** -->

	<div class="container-div">
		<div class="user_tabs">
			<ul>
				<li>
				<a href="user_home.php"><br />My Portfolio</a>				
				</li>
				<li>
				<a href="user_upload.php">Upload New</a>
				</li>
				<li>
				<a href="user_bids.php">My Bids</a>
				</li>
				<li>
				<a href="received_bids.php">Received bids</a>
				</li>
				<li>
				<a href="feedback.php"> Give feedback</a>
				</li>
			</ul>
		
		</div>
		<div class="right_div" style="text-align:left">
			<h1>Find us helpful?</h1>
			<p>
				We would like to hear your suggestions.	
			</p>
			<form method="post" name="feedback_form">			
			 <fieldset class="textbox">
			   <h2>
				<label for="heading" >
				<span>*Heading:</span> 
				</label>
				<br />
				<textarea id="heading" name="heading" cols="100">
				</textarea>
				<br />
				<label for="body" >
				<span>*Details:</span> 
				</label>	
				<br />
				<textarea id="body" name="body" rows="10" cols="100">
				</textarea>
				<br/>
				<br />
				</h2>
				<input type="submit" value="Submit" name="submit" />
			</fieldset>
			</form>	
			
		</div>			
	<?php
	require_once('connect.php');
	require_once('connect_param.php');
	
	$dbc = new Connect();
	$conn = $dbc->get_conn();
	if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
	} 
		
	if (isset($_POST['submit'])) {
		$username = $_SESSION['username'];
		$query = "SELECT * FROM users where username='$username'";
		$result = $conn->query($query);
		$row = $result->fetch_assoc();
		$fname = $row['first_name'];
		$lname = $row['last_name'];
		$heading = $_POST['heading'];
		$body = $_POST['body'];
		
		if(strlen(trim($_POST['heading']))&&strlen(trim($_POST['body'])))
		{	
		$query = "INSERT INTO feedback (username,first_name,last_name,heading,body) VALUES ('$username','$fname','$lname','$heading','$body')";
		$conn->query($query);
 		}
		else
		echo "Please fill all the fields";
	}
	?>
		</div>
	</div>
	
		<!-- ****************************************************************************************************************** -->			
			
	</body>
</html>
