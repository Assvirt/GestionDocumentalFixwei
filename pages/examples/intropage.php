<?php 
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:.login");
} else {

header('location:../controlador/sesion/logout3');
?>

<?php
}
?>