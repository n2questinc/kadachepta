<?php
	//Sample Database Connection Syntax for PHP and MySQL.
	
	//Connect To Database
	
	$hostname="localhost";
	$username="cpses_ajzmgmjzUo";
	$password="cUh1FL0SQ1jSkYDV";
	$dbname="kadachepta";
	$usertable="keys";
	$yourfield = "key";
	        
	mysql_connect($hostname,$username, $password) or die ("<html><body>Unable to connect to database! Please try again later</body></html>");
	mysql_select_db($dbname);

	# Check If Record Exists
	
	$query = "SELECT * FROM `$usertable`";
	
	$result = mysql_query($query);


	if($result){
		while($row = mysql_fetch_array($result)){
			$name = $row["$yourfield"];
			echo "Name: ".$name."<br/>";
		}
	}
?>