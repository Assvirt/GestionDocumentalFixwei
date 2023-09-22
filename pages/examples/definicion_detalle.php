<?php
require '../conexion/bd.php';


$id = $_GET['idDefinicion'];

$result = $mysqli->query("SELECT * FROM definicion WHERE id = '$id'")or die(mysqli_error);



$customer = mysqli_fetch_object($result);
echo json_encode($customer);



?>