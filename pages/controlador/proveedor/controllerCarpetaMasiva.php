<?php
error_reporting(E_ERROR);
require_once '../../conexion/bd.php';


if(isset($_POST['AgregarCarpeta'])){
   
    $nombre = $_POST['nombre'];
    $idProveedor = $_POST['idProveedor'];
    
    // funcion para quitar espacios
        function Quitar_Espacios($nombre)
        {
            $array = explode(' ',$nombre);  // convierte en array separa por espacios;
            $nombre ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $nombre.= ' ' . $array[$i];
                }
            }
          return  trim($nombre);
        }
        /// END
       
        $nombre = Quitar_Espacios($nombre);
        
    ///////// consultamos la tabla y extraemos el nombre
    $validacion = $mysqli->query("SELECT * FROM proveedordocumentosCarpetas WHERE nombre = '$nombre' AND idProveedor='$idProveedor' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
        //echo 'funciona';
        //echo '<script language="javascript">alert("El grupo ya existe");
        //window.location.href="../../agregarProveedoresGrupos"</script>';
        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("El nombre o el archivo ya existen1");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                           <form name="miformulario" action="../../subirDocumentoMasivo" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               <input type="hidden" name="validacionExiste" value="1">
                            </form>
                            
                        <?php
    }else{
    
        $mysqli->query("INSERT INTO proveedordocumentosCarpetas(nombre,idProveedor,estado)VALUES('$nombre','$idProveedor','aprobado') ")or die(mysqli_error($mysqli));
    
?>
                            <script>
                                    window.onload=function(){
                                        //alert("El nombre o el archivo ya existen1");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../subirDocumentoMasivo" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               <input type="hidden" name="validacionAgregar" value="1">
                            </form>
                            
<?php
    }
}

if(isset($_POST['EditarCarpeta'])){
    $idProveedor = $_POST['idProveedor'];
    $id=$_POST['idCarpeta'];
    $nombre=$_POST['nombre'];
    
    // funcion para quitar espacios
        function Quitar_Espacios($nombre)
        {
            $array = explode(' ',$nombre);  // convierte en array separa por espacios;
            $nombre ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $nombre.= ' ' . $array[$i];
                }
            }
          return  trim($nombre);
        }
        /// END
       
        $nombre = Quitar_Espacios($nombre);
    ///////// consultamos la tabla y extraemos el nombre
    $validacion = $mysqli->query("SELECT * FROM proveedordocumentosCarpetas WHERE nombre = '$nombre' AND idProveedor='$idProveedor' AND id != '$id' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
        //echo 'funciona';
        //echo '<script language="javascript">alert("El grupo ya existe");
        //window.location.href="../../agregarProveedoresGrupos"</script>';
        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("El nombre o el archivo ya existen1");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                           <form name="miformulario" action="../../subirDocumentoMasivo" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               <input type="hidden" name="validacionExiste" value="1">
                            </form>
                            
                        <?php
    }else{
        
        
    $Eliminarcarpeta=$mysqli->query("SELECT * FROM proveedordocumentosCarpetas WHERE id='$id' ");
    $ConsultarEliminacionCarpeta=$Eliminarcarpeta->fetch_array(MYSQLI_ASSOC);
    $nombreCarpeta=$ConsultarEliminacionCarpeta['nombre'];   
    unlink('../../archivos/documentoProveedor/'.$nombreCarpeta.'.zip');    
        
     $mysqli->query("UPDATE proveedordocumentosCarpetas SET nombre='$nombre' WHERE idProveedor='$idProveedor' AND id='$id'  ")or die(mysqli_error($mysqli));
    
    ?>
                            <script>
                                    window.onload=function(){
                                        //alert("El nombre o el archivo ya existen1");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../subirDocumentoMasivo" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               <input type="hidden" name="validacionActualizar" value="1">
                            </form>
                            
<?php
    }
}
?>