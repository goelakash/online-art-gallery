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
		<div class="user_tabs" style="float:left">
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
		
		<div class="right_div" style="font-weigtht:2000">				
			
	<?php
		require_once("connect.php");
		$username = $_SESSION['username'];
		$dbc = new Connect();
		$conn = $dbc->get_conn();
		//$conn = new mysqli('localhost','root','','webtech');
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		$query = "SELECT * FROM images WHERE username = '$username'";
		$result_images = $conn->query($query);

		if($result_images->num_rows>0){
		// start table
		echo "<table style='border:solid 3px grey;width:900px;'>
		
		<tr style='text-decoration:underline'>
			<th>
				Image Id:
			</th>
			<th>
				Bidder:
			</th>
			<th>
				Bid amount:
			</th>
		</tr>";
		}
		
		while($image_row = $result_images->fetch_assoc()){
			// get single image
			$id = $image_row['id'];
			$owner_name = $image_row['username'];
			$query_bids = "SELECT * FROM bids WHERE id= '$id' ORDER BY bid DESC";
			$image_bids = $conn->query($query_bids);
			
			if(!$image_bids){
				echo "No bids found";
				break;
				}
				
			while($row = $image_bids->fetch_assoc()){	

					$id = $row['id'];
					$username = $row['username'];
					$bid = $row['bid'];
					$date = $row['date'];
					$url = "sell.php?id=".$id."&buyer=".$username."&bid=".$bid;					
					echo '
					<tr>
						<td> 
							<a href="image.php?id='.$id.'"> '.$id.' </a>
						</td> 
						<td>
							'.$username.'
						</td>
						<td>
							'.$bid.'
						</td>
						<td>
						<button id="sell" class="sell" name="sell" onclick=" parent.location=\'' .$url. '\' " >Sell to this buyer</>
						</td>
					</tr>
					';
			}
		}					
	?>
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
	</div>
	</body>
</html>
