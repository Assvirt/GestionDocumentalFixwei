<?php
require_once '../conexion/bd.php';

if(isset($_POST['addPermisosConfig'])){

    //modulo usuarios
    $idGrupo = $_POST['idGrupo'];
    
    $permisos = $_POST['permisos'];

    
    $queryForms = $mysqli->query("SELECT idFormulario, orden FROM formularios WHERE modulo ='config' ORDER BY orden");

    while($row = $queryForms->fetch_assoc()){
        
        $formR = $row['idFormulario']."-plataforma";
        $formC = $row['idFormulario']."-correo";
        
        $formPeriso = $row['idFormulario'];
        
        $separar = preg_split("/[-]+/","$formPeriso");
        $formulario = $separar[0];
        //$permisoF = $separar[1];
        
        
        if(isset($_POST[$formR])){
            $mysqli->query("UPDATE permisosNotificaciones SET plataforma = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");    
        }else{
            $mysqli->query("UPDATE permisosNotificaciones SET plataforma = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formC])){
            $mysqli->query("UPDATE permisosNotificaciones SET correo = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisosNotificaciones SET correo = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
       
    }
        
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../notificacion.php" method="POST" onsubmit="procesar(this.action);" >
                <input style="visibility:hidden" type="text" name="idGrupo" value="<?php echo $idGrupo; ?>">
            </form> 
        <?php 
        
}


if(isset($_POST['addPermisosGestion'])){
    

    //modulo usuarios
    $idGrupo = $_POST['idGrupo'];
    
    $queryForms = $mysqli->query("SELECT idFormulario, orden FROM formularios WHERE modulo ='gestionDoc' ORDER BY orden");


    while($row = $queryForms->fetch_assoc()){
        
        $formR = $row['idFormulario']."-plataforma";
        $formC = $row['idFormulario']."-correo";
        
        
        $formPeriso = $row['idFormulario'];
        
        $separar = preg_split("/[-]+/","$formPeriso");
        $formulario = $separar[0];
        //$permisoF = $separar[1];
        
        
        if(isset($_POST[$formR])){
            $mysqli->query("UPDATE permisosNotificaciones SET plataforma = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");    
        }else{
            $mysqli->query("UPDATE permisosNotificaciones SET plataforma = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formC])){
            $mysqli->query("UPDATE permisosNotificaciones SET correo = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisosNotificaciones SET correo = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        
    }
    
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../notificacion.php" method="POST" onsubmit="procesar(this.action);" >
                <input style="visibility:hidden" type="text" name="idGrupo" value="<?php echo $idGrupo; ?>">
            </form> 
        <?php 
    
}



if(isset($_POST['addPermisosIndicadores'])){
    

    //modulo usuarios
    $idGrupo = $_POST['idGrupo'];
    
    $queryForms = $mysqli->query("SELECT idFormulario, orden FROM formularios WHERE modulo ='indi' ORDER BY orden");


    while($row = $queryForms->fetch_assoc()){
        
        $formR = $row['idFormulario']."-plataforma";
        $formC = $row['idFormulario']."-correo";
        
        
        $formPeriso = $row['idFormulario'];
        
        $separar = preg_split("/[-]+/","$formPeriso");
        $formulario = $separar[0];
        //$permisoF = $separar[1];
        
        
        if(isset($_POST[$formR])){
            $mysqli->query("UPDATE permisosNotificaciones SET plataforma = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");    
        }else{
            $mysqli->query("UPDATE permisosNotificaciones SET plataforma = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formC])){
            $mysqli->query("UPDATE permisosNotificaciones SET correo = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisosNotificaciones SET correo = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        
    }
    
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../notificacion.php" method="POST" onsubmit="procesar(this.action);" >
                <input style="visibility:hidden" type="text" name="idGrupo" value="<?php echo $idGrupo; ?>">
            </form> 
        <?php 
    
}


if(isset($_POST['addPermisosActas'])){
    

    //modulo usuarios
    $idGrupo = $_POST['idGrupo'];
    
    $queryForms = $mysqli->query("SELECT idFormulario, orden FROM formularios WHERE modulo ='actas' ORDER BY orden");


    while($row = $queryForms->fetch_assoc()){
        
        $formR = $row['idFormulario']."-plataforma";
        $formC = $row['idFormulario']."-correo";
        
        
        $formPeriso = $row['idFormulario'];
        
        $separar = preg_split("/[-]+/","$formPeriso");
        $formulario = $separar[0];
        //$permisoF = $separar[1];
        
        
        if(isset($_POST[$formR])){
            $mysqli->query("UPDATE permisosNotificaciones SET plataforma = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");    
        }else{
            $mysqli->query("UPDATE permisosNotificaciones SET plataforma = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formC])){
            $mysqli->query("UPDATE permisosNotificaciones SET correo = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisosNotificaciones SET correo = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        
    }
    
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../notificacion.php" method="POST" onsubmit="procesar(this.action);" >
                <input style="visibility:hidden" type="text" name="idGrupo" value="<?php echo $idGrupo; ?>">
            </form> 
        <?php 
    
}




if(isset($_POST['addPermisosCompras'])){
    

    //modulo usuarios
    $idGrupo = $_POST['idGrupo'];
    
    $queryForms = $mysqli->query("SELECT idFormulario, orden FROM formularios WHERE modulo ='compras' ORDER BY orden");


    while($row = $queryForms->fetch_assoc()){
        
        $formR = $row['idFormulario']."-plataforma";
        $formC = $row['idFormulario']."-correo";
        
        
        $formPeriso = $row['idFormulario'];
        
        $separar = preg_split("/[-]+/","$formPeriso");
        $formulario = $separar[0];
        //$permisoF = $separar[1];
        
        
        if(isset($_POST[$formR])){
            $mysqli->query("UPDATE permisosNotificaciones SET plataforma = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");    
        }else{
            $mysqli->query("UPDATE permisosNotificaciones SET plataforma = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formC])){
            $mysqli->query("UPDATE permisosNotificaciones SET correo = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisosNotificaciones SET correo = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        
    }
    
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../notificacion.php" method="POST" onsubmit="procesar(this.action);" >
                <input style="visibility:hidden" type="text" name="idGrupo" value="<?php echo $idGrupo; ?>">
            </form> 
        <?php 
    
}




?>