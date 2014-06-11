<?php 
    $host = 'localhost';
	$user = 'newsanalysis';
	$pass = 'EaqquT9qQuNqCCVe';
	$dbname = 'newsanalysis';
	
	$con = mysql_connect($host, $user, $pass) or die("Invalid Username or Password.".mysql_error());
	
	mysql_select_db($dbname);
	
?>