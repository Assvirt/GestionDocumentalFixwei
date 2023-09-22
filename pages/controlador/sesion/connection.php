<?php
require("constants.php");
$con = mysqli_connect($servidor, $usuario, "$contrasena") or die ("no se ha podido conectar a la BD");
$bd = mysqli_select_db($con,$basededatos) or die ("Base de datos no seleccionada");
	
	?>