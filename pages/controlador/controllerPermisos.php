<?php error_reporting(E_ERROR);
require_once '../conexion/bd.php';

if(isset($_POST['addPermisosConfig'])){

    //modulo usuarios
    $idGrupo = $_POST['idGrupo'];
    
    $permisos = $_POST['permisos'];

    
    $queryForms = $mysqli->query("SELECT idFormulario, orden FROM formularios WHERE modulo ='config' ORDER BY orden");

    while($row = $queryForms->fetch_assoc()){
        
        $formR = $row['idFormulario']."-listar";
        $formC = $row['idFormulario']."-crear";
        $formE = $row['idFormulario']."-editar";
        $formD = $row['idFormulario']."-eliminar";
        
        $formPeriso = $row['idFormulario'];
        
        $separar = preg_split("/[-]+/","$formPeriso");
        $formulario = $separar[0];
        //$permisoF = $separar[1];
        
        
        if(isset($_POST[$formR])){
            $mysqli->query("UPDATE permisos SET listar = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");    
        }else{
            $mysqli->query("UPDATE permisos SET listar = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formC])){
            $mysqli->query("UPDATE permisos SET crear = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisos SET crear = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formE])){
            $mysqli->query("UPDATE permisos SET editar = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisos SET editar = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formD])){
            $mysqli->query("UPDATE permisos SET eliminar = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisos SET eliminar = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
    }
        
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../permisos" method="POST" onsubmit="procesar(this.action);" >
                <input style="visibility:hidden" type="text" name="idGrupo" value="<?php echo $idGrupo; ?>">
            </form> 
        <?php 
        
}


if(isset($_POST['addPermisosGestion'])){
    

    //modulo usuarios
    $idGrupo = $_POST['idGrupo'];
    
    $queryForms = $mysqli->query("SELECT idFormulario, orden FROM formularios WHERE modulo ='gestionDoc' ORDER BY orden");


    while($row = $queryForms->fetch_assoc()){
        
        $formR = $row['idFormulario']."-listar";
        $formC = $row['idFormulario']."-crear";
        $formE = $row['idFormulario']."-editar";
        $formD = $row['idFormulario']."-eliminar";
        
        $formPeriso = $row['idFormulario'];
        
        $separar = preg_split("/[-]+/","$formPeriso");
        $formulario = $separar[0];
        //$permisoF = $separar[1];
        
        
        if(isset($_POST[$formR])){
            $mysqli->query("UPDATE permisos SET listar = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");    
        }else{
            $mysqli->query("UPDATE permisos SET listar = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formC])){
            $mysqli->query("UPDATE permisos SET crear = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisos SET crear = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formE])){
           $mysqli->query("UPDATE permisos SET editar = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisos SET editar = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formD])){
            $mysqli->query("UPDATE permisos SET eliminar = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisos SET eliminar = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
    }
    
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../permisos" method="POST" onsubmit="procesar(this.action);" >
                <input style="visibility:hidden" type="text" name="idGrupo" value="<?php echo $idGrupo; ?>">
            </form> 
        <?php 
    
}

if(isset($_POST['addPermisosRepositorio'])){
    
    

    //modulo usuarios
    $idGrupo = $_POST['idGrupo'];
    
    $queryForms = $mysqli->query("SELECT idFormulario, orden FROM formularios WHERE modulo ='Repositorio' ORDER BY orden");


    while($row = $queryForms->fetch_assoc()){
        
        $formR = $row['idFormulario']."-listar";
        $formC = $row['idFormulario']."-crear";
        $formE = $row['idFormulario']."-editar";
        $formD = $row['idFormulario']."-eliminar";
        
        $formPeriso = $row['idFormulario'];
        
        $separar = preg_split("/[-]+/","$formPeriso");
        $formulario = $separar[0];
        //$permisoF = $separar[1];
        
        
        if(isset($_POST[$formR])){
            $mysqli->query("UPDATE permisos SET listar = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");    
        }else{
            $mysqli->query("UPDATE permisos SET listar = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formC])){
            $mysqli->query("UPDATE permisos SET crear = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisos SET crear = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formE])){
           $mysqli->query("UPDATE permisos SET editar = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisos SET editar = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formD])){
            $mysqli->query("UPDATE permisos SET eliminar = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisos SET eliminar = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
    }
    
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../permisos" method="POST" onsubmit="procesar(this.action);" >
                <input style="visibility:hidden" type="text" name="idGrupo" value="<?php echo $idGrupo; ?>">
            </form> 
        <?php 
    

}

if(isset($_POST['addPermisosIndicador'])){
    

    //modulo usuarios
    $idGrupo = $_POST['idGrupo'];
    
    $queryForms = $mysqli->query("SELECT idFormulario, orden FROM formularios WHERE modulo ='indi' ORDER BY orden");


    while($row = $queryForms->fetch_assoc()){
        
        $formR = $row['idFormulario']."-listar";
        $formC = $row['idFormulario']."-crear";
        $formE = $row['idFormulario']."-editar";
        $formD = $row['idFormulario']."-eliminar";
        
        $formPeriso = $row['idFormulario'];
        
        $separar = preg_split("/[-]+/","$formPeriso");
        $formulario = $separar[0];
        //$permisoF = $separar[1];
        
        
        if(isset($_POST[$formR])){
            $mysqli->query("UPDATE permisos SET listar = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");    
        }else{
            $mysqli->query("UPDATE permisos SET listar = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formC])){
            $mysqli->query("UPDATE permisos SET crear = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisos SET crear = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formE])){
           $mysqli->query("UPDATE permisos SET editar = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisos SET editar = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formD])){
            $mysqli->query("UPDATE permisos SET eliminar = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisos SET eliminar = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
    }
    
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../permisos" method="POST" onsubmit="procesar(this.action);" >
                <input style="visibility:hidden" type="text" name="idGrupo" value="<?php echo $idGrupo; ?>">
            </form> 
        <?php 
    
}


if(isset($_POST['addPermisosActas'])){
    

    //modulo usuarios
    $idGrupo = $_POST['idGrupo'];
    
    $queryForms = $mysqli->query("SELECT idFormulario, orden FROM formularios WHERE modulo ='actas' ORDER BY orden");


    while($row = $queryForms->fetch_assoc()){
        
        $formR = $row['idFormulario']."-listar";
        $formC = $row['idFormulario']."-crear";
        $formE = $row['idFormulario']."-editar";
        $formD = $row['idFormulario']."-eliminar";
        
        $formPeriso = $row['idFormulario'];
        
        $separar = preg_split("/[-]+/","$formPeriso");
        $formulario = $separar[0];
        //$permisoF = $separar[1];
        
        
        if(isset($_POST[$formR])){
            $mysqli->query("UPDATE permisos SET listar = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");    
        }else{
            $mysqli->query("UPDATE permisos SET listar = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formC])){
            $mysqli->query("UPDATE permisos SET crear = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisos SET crear = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formE])){
           $mysqli->query("UPDATE permisos SET editar = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisos SET editar = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formD])){
            $mysqli->query("UPDATE permisos SET eliminar = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisos SET eliminar = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
    }
    
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../permisos" method="POST" onsubmit="procesar(this.action);" >
                <input style="visibility:hidden" type="text" name="idGrupo" value="<?php echo $idGrupo; ?>">
            </form> 
        <?php 
    
}





if(isset($_POST['addPermisosCompras'])){
    

    //modulo usuarios
    $idGrupo = $_POST['idGrupo'];
    
    $queryForms = $mysqli->query("SELECT idFormulario, orden FROM formularios WHERE modulo ='compras' ORDER BY orden");


    while($row = $queryForms->fetch_assoc()){
        
        $formR = $row['idFormulario']."-listar";
        $formC = $row['idFormulario']."-crear";
        $formE = $row['idFormulario']."-editar";
        $formD = $row['idFormulario']."-eliminar";
        
        $formPeriso = $row['idFormulario'];
        
        $separar = preg_split("/[-]+/","$formPeriso");
        $formulario = $separar[0];
        //$permisoF = $separar[1];
        
        
        if(isset($_POST[$formR])){
            $mysqli->query("UPDATE permisos SET listar = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");    
        }else{
            $mysqli->query("UPDATE permisos SET listar = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formC])){
            $mysqli->query("UPDATE permisos SET crear = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisos SET crear = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formE])){
           $mysqli->query("UPDATE permisos SET editar = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisos SET editar = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
        if(isset($_POST[$formD])){
            $mysqli->query("UPDATE permisos SET eliminar = TRUE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }else{
            $mysqli->query("UPDATE permisos SET eliminar = FALSE WHERE idGrupo = '$idGrupo' AND formulario='$formulario'");
        }
        
    }
    
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../permisos" method="POST" onsubmit="procesar(this.action);" >
                <input style="visibility:hidden" type="text" name="idGrupo" value="<?php echo $idGrupo; ?>">
            </form> 
        <?php 
    
}






?>