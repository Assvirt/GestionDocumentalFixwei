<?php
	$mysqli = new mysqli('localhost','fixwei_pageroot','l_9&e~Lu+SzX','fixwei_c9rp5r4t2v8')or die(mysqli_error($mysqli));
	//$mysqli = new mysqli("localhost","u171921029_inse","u7lHOhkyoRBy","u171921029_inser"); //servidor, usuario de base de datos, contraseña del usuario, nombre de base de datos
	
	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}
	
?>