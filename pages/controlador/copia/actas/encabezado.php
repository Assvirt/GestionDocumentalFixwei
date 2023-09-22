<?php
require_once '../../conexion/bd.php';

if(isset($_POST['encabezadoCrear'])){
    $encabezado =utf8_decode($_POST['editor1']);
    $nombre=utf8_decode($_POST['nombre']);
    
    $validamosNombre=$mysqli->query("SELECT * FROM encabezado WHERE nombre='$nombre' ");
    $numRows = mysqli_num_rows($validamosNombre);
    
    if($numRows > 0){
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../crearEncabezadoLista" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
    }else{
        $mysqli->query("INSERT INTO encabezado (encabezado,nombre,principal)VALUES('$encabezado','$nombre','0')"); 
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../crearEncabezadoLista" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionAgregar" value="1">
            </form> 
        <?php
    }
}
if(isset($_POST['encabezado'])){
    
    $encabezado =utf8_decode($_POST['editor1']);
    $nombre=utf8_decode($_POST['nombre']);
    $id=$_POST['id'];
    
    $editar = true;
    $validamosNombre=$mysqli->query("SELECT * FROM encabezado WHERE nombre='$nombre' AND id != '$id' ");
    $numRows = mysqli_num_rows($validamosNombre);
    
    if($numRows > 0){
        $editar = false;
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../crearEncabezadoLista" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExiste" value="1">
            </form> 
        <?php
    }
    
    if($editar != false){
        $mysqli->query("UPDATE encabezado SET encabezado = '$encabezado', nombre='$nombre'  WHERE id ='$id' ");
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../crearEncabezadoLista" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form> 
        <?php
    }
    
    
        
    
}
if(isset($_POST['eliminar'])){
    $id=$_POST['id'];
    $mysqli->query("DELETE FROM encabezado  WHERE id='$id' ");
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../crearEncabezadoLista" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
}

if(isset($_POST['aplicar'])){
    $id=$_POST['id'];
    $mysqli->query("UPDATE encabezado SET principal='1'  WHERE id ='$id' ");
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../crearEncabezadoLista" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizarB" value="1">
            </form> 
        <?php
}
if(isset($_POST['desaplicar'])){
    $id=$_POST['id'];
    $mysqli->query("UPDATE encabezado SET principal='0' ");
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../crearEncabezadoLista" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizarC" value="1">
            </form> 
        <?php
}
