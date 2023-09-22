<?php
require_once'../../conexion/bd.php';
error_reporting(E_ERROR);

if(isset($_POST['ActualizarPerfil'])){
    $idPerfil=$_POST['idPerfil'];
    $nombre=utf8_decode($_POST['nombre']);
    $apellido=utf8_decode($_POST['apellido']);
    $correo=$_POST['correo'];
    $pass1=$_POST['pass1'];
    $pass2=$_POST['pass2'];
    
    if($pass1 == $pass2){
        //echo '<script language="javascript">confirm("La contraseña no puede ser la misma que la actual");
        //window.location.href="../../myperfil"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../myperfil" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
        
    }else{
            $mysqli->query("UPDATE usuario SET clave='$pass2' WHERE cedula='$idPerfil' ");
        
        
        //echo '<script language="javascript">confirm("Datos actualizados");
        //window.location.href="../../myperfil"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../myperfil" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form> 
        <?php
    }
    
    header ('location: ../../myperfil');
}elseif(isset($_POST['ActualizarPerfil2'])){
    $idPerfil=$_POST['idPerfil'];
    $telefono=$_POST['telefono'];
    $cargo=$_POST['cargo'];
    $foto= Addslashes(file_get_contents($_FILES['foto']['tmp_name']));
    
    $mysqli->query("UPDATE usuario SET  foto='$foto' WHERE cedula='$idPerfil' ");
    
    //echo '<script lenguage="javascript">confirm("Datos actualizados");
    //    window.location.href="../../myperfil"</script>';
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../myperfil" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form> 
        <?php
}
////elimina el registro de la vista y de la base de datos
if(isset($_GET['eliminar'])){
    $id = $_GET["eliminar"];
    $mysqli->query("DELETE FROM actividades WHERE id = $id ");
    //echo '<script lenguage="javascript">confirm("Eliminado");
    //    window.location.href="../../myperfil"</script>';
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../myperfil" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
}
///oculta el acta de la vista pero no de la base de datos

if(isset($_GET['ocultar'])){
    $id = $_GET["ocultar"];
    $mysqli->query("UPDATE actas set estadoOculto = true WHERE id = $id ");
    //echo '<script lenguage="javascript">confirm("Eliminado");
    //    window.location.href="../../myperfil"</script>';
    ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../myperfil" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
}


?>