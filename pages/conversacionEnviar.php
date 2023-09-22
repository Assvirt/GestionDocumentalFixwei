<?php
session_start();
if(!isset($_SESSION["session_username"])){

}else{

include 'conexion/bd.php';
    

    //echo 'registraa';
   // recibimos todos los datos que se envian desde el ajax 
   $mensaje=$_REQUEST['mensaje'];
   //$archivo=$_REQUEST['mensajeArchivo'];
   date_default_timezone_set('America/Bogota');
   $fecha=date('Y-m-j h:i:s A');
   // end
   // a la pesona que le escribe
   $quienEscribo=$_REQUEST['mensajeQuienEscribo'];
   // end
   
   /// buscamos dentro del texto un caracter especifico para cambiarlo por una imagen
   $mensaje=str_replace(":@","<img src=\'iconos/enojado.png\'/>",$mensaje);
   $mensaje=str_replace(":)","<img src=\'iconos/feliz.png\'/>",$mensaje);
   $mensaje=str_replace(":p","<img src=\'iconos/lengua.png\'/>",$mensaje);
   $mensaje=str_replace(":'(","<img src=\'iconos/llorando.png\'/>",$mensaje);
   $mensaje=str_replace("::","<img src=\'iconos/ninja.png\'/>",$mensaje);
   $mensaje=str_replace(":o","<img src=\'iconos/sorprendido.png\'/>",$mensaje);
   $mensaje=str_replace(":D","<img src=\'iconos/sonrisa.png\'/>",$mensaje);
   $mensaje=str_replace(":(","<img src=\'iconos/triste.png\'/>",$mensaje);
   /// END
   
   //// validamos para que no entre datos vacios
   if($mensaje != NULL){ 
     $e = $mysqli->query("INSERT INTO mensajes (mensaje,user,fecha,para)VALUES('$mensaje', '".$_SESSION['session_username']."', '$fecha','$quienEscribo')"); //now())    
     
     //// actualizamos un campo de mensajes en la tabla de usuario para avisarnos que tenemos un mensaje pendiente
        $m = $mysqli->query("UPDATE usuario SET mensaje = mensaje+1 WHERE cedula='".$_SESSION['session_username']."' ");
     /// end
   }
   //// end
  

    


    
    
}
?>