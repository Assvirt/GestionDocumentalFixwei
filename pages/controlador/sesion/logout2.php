<?php 
session_start();

require_once 'constants.php';

$con = mysqli_connect($servidor, $usuario, $contrasena) or die ("no se ha podido conectar a la BD");
$bd = mysqli_select_db($con,$basededatos) or die ("Base de datos no seleccionada");
	 'U:'.$_SESSION['session_username'];
		date_default_timezone_set('America/Bogota');
		$ultimaCon=date('j/m/Y h:i:s A');
		$logoutB= "UPDATE usuario SET estadoUsuario='desconectado', contadorSesion='0' WHERE cedula='".$_SESSION['session_username']."'";
		$execute=mysqli_query($con,$logoutB);
		$logout= "UPDATE users SET status='Offline now' WHERE email='".$_SESSION['session_username']."'";
		$execute=mysqli_query($con,$logout);
		
		//$logout= "UPDATE login SET estado='no' WHERE cc='".$_SESSION['session_username']."'";
		//$logoutC= "UPDATE chat_users SET online='0' WHERE password='".$_SESSION['session_username']."'";
		//$execute=mysqli_query($con,$logoutC);

   
   //echo 'destruye la sesión';
   unset($_SESSION['session_username']);
   session_destroy();
   header("location: ../../examples/login");  


	
?>