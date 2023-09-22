<?php
require_once 'conexion/bd.php';


//// vamos a traer el recorrido de la definición
$definicion=$mysqli->query("SELECT * FROM definicion ORDER BY id ");
$recorridoNombreDefinicion=0;
while($recorridoDefinicion=$definicion->fetch_array()){
    echo 'Nombre: '.$nombreDefinicion=$recorridoDefinicion['nombre'];
    echo '<br>';
   
            $array = explode(' ',$nombreDefinicion);  // convierte en array separa por espacios;
            $nombreDefinicion ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $nombreDefinicion.= ' ' . $array[$i];
                }
            }
            
          $nombreDefinicion=trim($nombreDefinicion);
        /// END
        
        $updateDefinicion=$mysqli->query("UPDATE definicion SET nombre='$nombreDefinicion' WHERE id='".$recorridoDefinicion['id']."' ");
}


?>