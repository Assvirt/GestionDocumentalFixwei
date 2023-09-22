<?php
require_once '../../conexion/bd.php';
mb_internal_encoding("UTF-8");


if(isset($_POST['Agregar'])){
    
$nombre = $_POST['nombre'];
$idProveedor= $_POST['idProveedor'];

$archivoNombre = $_FILES['soporte']['name'];
$guardado = $_FILES['soporte']['tmp_name'];





  if(!file_exists('../../archivos/documentoProveedor')){
      $ruta = 'archivos/documentoProveedor/'.$archivoNombre;
      
      /////// se valida el archivo antes de guardar para evitar reemplazar el actual o el nombre del archivo
                $validacion1 = $mysqli->query("SELECT * FROM proveedorDocumentos WHERE nombre = '$nombre' OR soporte= '$ruta' ");//consulta a base de datos si el nombre se repite
                    $numNom = mysqli_num_rows($validacion1);
                    if($numNom > 0){
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("El nombre o el archivo ya existen1");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../proveedorDocumetosInscripcion" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               <input type="hidden" name="validacionExiste" value="1">
                            </form>
                            
                        <?php
                    }else{/////////////// fin de la validacion
      
                        mkdir('../../archivos/documentoProveedor',0777,true);
                        if(file_exists('../../archivos/documentoProveedor')){
                            if(move_uploaded_file($guardado, '../../archivos/documentoProveedor/'.$archivoNombre)){
                                $ruta = 'archivos/documentoProveedor/'.$archivoNombre;
                                
                                
                                ///////// consultamos la tabla y extraemos el nombre
                		        $mysqli->query("INSERT INTO proveedorDocumentos (idProveedor, nombre, soporte) VALUES('$idProveedor','$nombre','$ruta') ")or die(mysqli_error($mysqli));
                        
                                ?>
                                    <script>
                                            window.onload=function(){
                                                alert("Datos almacenados con éxito");
                                                document.forms["miformulario"].submit();
                                                }
                                    </script>
                                    <form name="miformulario" action="../../proveedorDocumetosInscripcion" method="POST" onsubmit="procesar(this.action);" >
                                       <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                                       <input type="hidden" name="validacionAgregar" value="1">
                                    </form>
                                    
                                <?php
                                    }
                            }
                        }
        
    }else{
        
        $ruta = 'archivos/documentoProveedor/'.$archivoNombre;
        /////// se valida el archivo antes de guardar para evitar reemplazar el actual o el nombre del archivo
                $validacion1 = $mysqli->query("SELECT * FROM proveedorDocumentos WHERE nombre = '$nombre' OR soporte= '$ruta' ");//consulta a base de datos si el nombre se repite
                    $numNom = mysqli_num_rows($validacion1);
                    if($numNom > 0){
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("El nombre o el archivo ya existen");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../proveedorDocumetosInscripcion" method="POST" onsubmit="procesar(this.action);" >
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               <input type="hidden" name="validacionExiste" value="1">
                            </form>
                            
                        <?php
                    }else{/////////////// fin de la validacion
        
                        if(move_uploaded_file($guardado, '../../archivos/documentoProveedor/'.$archivoNombre)){
                                $ruta = 'archivos/documentoProveedor/'.$archivoNombre;
                                
                            
                                ///////// consultamos la tabla y extraemos el nombre
                		        $mysqli->query("INSERT INTO proveedorDocumentos (idProveedor, nombre, soporte) VALUES('$idProveedor','$nombre','$ruta') ")or die(mysqli_error($mysqli));
                        
                                ?>
                                    <script>
                                            window.onload=function(){
                                                //alert("Datos almacenados con éxito ");
                                                document.forms["miformulario"].submit();
                                                }
                                    </script>
                                    <form name="miformulario" action="../../proveedorDocumetosInscripcion" method="POST" onsubmit="procesar(this.action);" >
                                       <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                                       <input type="hidden" name="validacionAgregar" value="1">
                                    </form>
                                    
                                <?php
                                    }
                        }
        
    }
	////////////////////////////////////
 


    

}
?>