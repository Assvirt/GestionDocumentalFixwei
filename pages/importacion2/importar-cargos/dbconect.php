<?php
// simple conexion a la base de datos
function connect(){
       require '../../conexion/bd.php';
	return $mysqli; //mysqli('localhost','fixwei_pageroot','l_9&e~Lu+SzX','fixwei_c9rp5r4t2v8');
}
$con = connect();
if (!$con->set_charset("utf8")) {//asignamos la codificación comprobando que no falle
       die("Error cargando el conjunto de caracteres utf8");
}
?>