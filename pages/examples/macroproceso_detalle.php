<?php
require '../conexion/bd.php';


$id = $_GET['idMacroproceso'];

$result = $mysqli->query("SELECT * FROM macroproceso WHERE id = '$id'")or die(mysqli_error);



$customer = mysqli_fetch_object($result);
echo json_encode($customer);



?>