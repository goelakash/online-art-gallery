<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
session_start();
if(!isset($_SESSION['status'])||$_SESSION['status']!='authorized'){
	$_SESSION['status']='unauth';
	$_SESSION['username']='Guest';
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
			}
			);     
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
	<?php
		if($_SESSION['username']!='Guest'||$_SESSION['status']!='unauth'){
		echo '
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

			';
			}
	?>	
			</ul>
	
		</div>
	<div class="right_div" align="justify">
<!--		<div class="center-left" align="justify" style="width:300px">  
-->	
			<?php
			require_once("connect.php");
			$user = $_SESSION['username'];
			$dbc = new Connect();
			$conn = $dbc->get_conn();
			//$conn = new mysqli('localhost','root','','webtech');
			if ($conn->connect_error) 
			{
				die("Connection failed: " . $conn->connect_error);
			}
			$id = $_GET['id'];
			$query = "SELECT * FROM images WHERE id = '$id'";
			$result = $conn->query($query);
			
			if(!$result)
			echo "Not an object";

			if ($result->num_rows > 0)
			{
				$row = $result->fetch_assoc(); 
				$image_username = $row['username'] ;
				$highest_bidder = $image_username;
				$min_bid = $row['min_bid'];
				$sold = $row['sold'];
					
				echo "<br><h1 align='center' >".$row['title']."</h1><br>
				<img align='middle' class='top' src='".$row['path']."' alt='alt_text' style='max-width:800px'/>
				<h4> Artist: ".$row['artist']."</h4>
				<h4> Uploaded by: ".$row['username']."</h4>";

				$query_2 = "SELECT * FROM bids WHERE id = '$id' ORDER BY bid DESC";		
				$result_2 = $conn->query($query_2);
				
				//check previous bids 	
				
				if($sold==0)
				{
					if($result_2->num_rows>0)
					{
						$row_2 = $result_2->fetch_assoc();
						
						if($min_bid<$row_2['bid'])
						{
						$min_bid = $row_2['bid'];
						$highest_bidder = $row_2['username'];
						}
					}
					if($highest_bidder == $image_username)
					{
					echo "<h4> No bids yet.</h4>";
					echo "<h3 style='color:#00B800' >Starting bid at :  Rs. ".$min_bid."</h3>";
					}
					else
					{
					echo "<h3 style='color:#0000FF' >Current bid at :  Rs. ".$min_bid."</h3>";
					echo "<h4> Current bidder: ".$highest_bidder."</h4>";		
					}
					
					if($_SESSION['username']=="Guest"||$_SESSION['status']!='authorized')
					{
								echo "<h3> Login to bid now!</h3>";
					}
									
					
					else if($highest_bidder==$_SESSION['username']&&$_SESSION['username']!=$image_username)
					{
						echo "<br> <h4>Congratulations! You are the highest bidder on this item</h4>";
					}
			
					// get earlier bid of a user
					else if($highest_bidder!=$_SESSION['username'])
					{
						$query_3 = "SELECT * FROM bids where id = '$id' AND username='".$_SESSION['username']."'";
						$result_3 = $conn->query($query_3);
						
						while($result_3->num_rows>0)
						{
							$row_3 = $result_3->fetch_assoc();
								if($row_3['username'] == $_SESSION['username'])
								{
									echo "<h3> Your earlier bid: ".$row_3['bid']."</h3>";
									break;
								}
						}											
					
						if($image_username!=$_SESSION['username'])
						{		
								$_SESSION['min_bid']=$min_bid;
								$_SESSION['id'] = $id;
								$_SESSION['image_username'] = $row['username'];
								
								echo '
								<form id="bid_form" name="bid_form" method="post" action="bid.php" target="_blank">
								<label for="bid" class="upload_span">
								<span><h2>New Bid: </h2></span> 	
								</label>
								<input type="number" id="bid" name="bid" class="upload_span" />
								<br />
								<input type="submit" id="bid_button" value="Bid Now!" />
								</form>
								';
						}
					}					
					else if($image_username!=$_SESSION['username'])
						echo "<h3> No bids on this item yet! <br> </h3> <h4> Be the first one </h4>";
				}
				else
				{
					echo "<h3 style='color:#ff5511'> Sold at Rs. $min_bid </h3>";
				}
				if($image_username==$_SESSION['username'])
				{
					echo "You created this.";	
				}
			}
			else
				echo "An error occured!";
			
			?>
				
	</div>				
	<br class="clear" />
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
