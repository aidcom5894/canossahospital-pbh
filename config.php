<?php

	$hostname = 'localhost';
	$username = 'u445536153_leenaCanossa';
	$password = '3*TQyGeD@eOj*6A97~&JoCtr;s3e>&3D';
	$db_name = 'u445536153_canossa_pbh';

	$conn = mysqli_connect($hostname,$username,$password,$db_name);

	//date_default_timezone_set('Aisa/Kolkata');

	$base_url = "https://canossahospitalpbh.in/";

	if(!$conn){
		die("Database Connection Failed: " . mysqli_connect_error());
	}
?>

