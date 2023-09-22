<?php
require '../conexion/bd.php';


$id = $_GET['idCentrodetrabajo'];

$result = $mysqli->query("SELECT * FROM centrodetrabajo WHERE id_centrodetrabajo = '$id'")or die(mysqli_error);



$customer = mysqli_fetch_object($result);
echo json_encode($customer);



?>