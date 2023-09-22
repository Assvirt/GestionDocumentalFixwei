<?php
require '../conexion/bd.php';


$id = $_GET['idCargos'];

$result = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$id'")or die(mysqli_error);



$customer = mysqli_fetch_object($result);
echo json_encode($customer);



?>