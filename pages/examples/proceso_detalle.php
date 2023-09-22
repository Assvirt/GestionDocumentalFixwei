<?php
require '../conexion/bd.php';


$id = $_GET['idProceso'];

$result = $mysqli->query("SELECT * FROM procesos WHERE id = '$id'")or die(mysqli_error);



$customer = mysqli_fetch_object($result);
echo json_encode($customer);



?>