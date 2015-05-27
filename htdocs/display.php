	<?php
		session_start();
		require_once("connect.php");
		$user = $_SESSION['username'];
		$dbc = new Connect();
		$conn = $dbc->get_conn();
		//$conn = new mysqli('localhost','root','','webtech');
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$def_sort_choice = "title";
		$sort = $_GET['sort'];
		if($sort=='price')
			$def_sort_choice = "min_bid";
		else
			$def_sort_choice = "title";
	
		$query = "SELECT * FROM images ORDER BY ".$def_sort_choice;
		$result = $conn->query($query);
		if(!$result)
		echo "Not an object";
		
		while($row= $result->fetch_assoc()){
			echo 
				"<li>
				<a href='".$row['path']."'><img class='top' src='".$row['path']."' width='260' height='200' title='
				<a href=\"image.php?id=".$row['id']."\">".$row['title']."</a>
				' alt='alt_text' /></a>
				<h3 style=\"font-size:18px;background-color: #00ff00;\">".$row['title']."</h3>
				</li>";		
			}
					
	?>		