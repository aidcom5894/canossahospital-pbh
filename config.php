<?php

	$hostname = 'localhost';
	$username = 'u445536153_leenaCanossa';
	$password = 'E9s#|rd*5Iv3:n4O8Z>QEb*pN|l';
	$db_name = 'u445536153_canossa_pbh';

	$conn = mysqli_connect($hostname,$username,$password,$db_name);

	//date_default_timezone_set('Aisa/Kolkata');

	$base_url = "https://canossahospitalpbh.in/";

	if(!$conn){
		die("Database Connection Failed: " . mysqli_connect_error());
	}
?>

