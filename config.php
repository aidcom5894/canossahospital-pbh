<?php

	$hostname = 'localhost';
	$username = 'root';
	$password = 'Admin1234#@';
	$db_name = 'clinic';

	$conn = mysqli_connect($hostname,$username,$password,$db_name);

	//date_default_timezone_set('Aisa/Kolkata');

	$base_url = "http://localhost/clinic/";

	if(!$conn){
		die("Database Connection Failed: " . mysqli_connect_error());
	}
?>

