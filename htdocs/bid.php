<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
			$('#signin-link').click(function () {
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
				<a href="user_home.php"><br />
				My Portfolio</a>				
				</li>
				<li>
				<a href="user_upload.php">
				Upload New</a>
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
		<div class="right_div">
	<?php
		error_reporting(1); 
		require_once("connect.php");
		$dbc = new Connect();
		$conn = $dbc->get_conn();
		//$conn = new mysqli('localhost','root','','webtech');
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$username = $_SESSION['username'];
		$id = $_SESSION['id'];
		$bid = $_POST['bid'];
		$min_bid = $_SESSION['min_bid'];
		/*
		echo $username;
		echo $id;
		echo $bid;
		echo $min_bid;
		*/
		if($bid <= $min_bid)
		{
			echo "<h1> Your bid of $bid is less than the current bid of $min_bid";
//			sleep(5);
//			header("location:image.php?id=".$id);			
		}
		$query0 = "SELECT * FROM bids where username='$username' AND id = '$id' ORDER BY bid DESC";
		$result0 = $conn->query($query0);
		
		
		if($result0->num_rows>0){
			$row = $result0->fetch_assoc();
			$old_bid = $row['bid'];
			if($bid<$old_bid){
				echo "<br> <h2>You have already bid higher than this!</h2>";
//				echo "<br><br>Redirecting...";
//				sleep(5);
//				header("location:image.php?id=".$id);	
			}
		}

		// pevent user to bid on his own painting
		if($bid > $min_bid && $_SESSION['image_username'] != $_SESSION['username']){

				//remove earlier bid
				$query = "DELETE * from bids where username='".$_SESSION['username']."' AND id='".$id."'";
				$result = $conn->query($query);
				//insert new bid
				$query = "INSERT INTO bids (id,bid,username,date) VALUES ('$id','$bid','".$_SESSION['username']."','".date()."')";
				$result = $conn->query($query);
				if($result)
					echo "<h1> Bid successful! </h1>";				
		}
	?>
		</div>
	</div>
	<div id="main">
			
	<ul class="gallery">
				
					
				</ul>

				<br class="clear" />
				
			</div>
		</div>
		<!-- ****************************************************************************************************************** -->			
		<script type="text/javascript">
			$('#nav').dropotron();
		</script>	
		
			<script type="text/javascript">
				$('.gallery').poptrox({
					overlayColor: '#222222',
					overlayOpacity: 0.75,
					popupCloserText: 'Close',
					usePopupCaption: true,
					usePopupDefaultStyling: false
				});
			</script>
	</body>
</html>
