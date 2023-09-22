<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'politicas'; //Se cambia el nombre del formulario

require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////

if(isset($_POST['abrirCarpeta'])){
?>
<!DOCTYPE html>
<html>
    <title>Proveedores Carpetas</title>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<script>
   	
    function nobackbutton(){
    	
       window.location.hash="no-back-button";
    	
       window.location.hash="Again-No-back-button" //chrome
    	
       window.onhashchange=function(){window.location.hash="no-back-button";}
    	
    }
</script>
<script type="text/javascript">
$(document).ready(function () {
   
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
   
    $("body").on("contextmenu",function(e){
        return false;
    });
});
</script>
<body class="hold-transition sidebar-mini" onload="nobackbutton();" oncopy="return false" onpaste="return false">
<div class="wrapper">


  <!-- Main Sidebar Container -->
  <?php echo require_once'menu.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
              <?php
                    $idProveedor=$_POST['idProveedor'];
                    $query = $mysqli->query("SELECT * FROM proveedores WHERE id= '$idProveedor'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $idEnviarProveedor = $row['id'];
                    $nit = $row['nit'];
                    $proveedor = $row['razonSocial'];
                    $proveedorEstado = $row['estado'];
                    $realizador = $row['realizador'];
                    $bloqueoCarpeta = $row['bloqueoCarpeta'];
              
              $consultaNmbreCarpeta=$mysqli->query("SELECT * FROM carpeta WHERE id='".$_POST['carpetaAbrir']."' ");
              $extraerNombreCarpeta=$consultaNmbreCarpeta->fetch_array(MYSQLI_ASSOC);
              
              //// extraemos la fila de la carpeta
              $filaCarpeta=$extraerNombreCarpeta['fila'];
              ?>
            <h1>Carpetas del proveedor <?php echo $proveedor; ?></h1>
            <h3 class="page-header"><i class="fa fa-table"></i> Archivos de la carpeta <b><?php echo $extraerNombreCarpeta['nombre'];?></b></h3>
            <?php
            /// reeemplazamos el documento de la carpeta por el nombre de la carpeta principal
            $consultaNmbreCarpetaPrimeraCaperta=$mysqli->query("SELECT * FROM carpeta WHERE rol='$idProveedor' AND fila='1' ");
            $extraerNombreCarpetaPrimeraCaperta=$consultaNmbreCarpetaPrimeraCaperta->fetch_array(MYSQLI_ASSOC);
            echo '<b>Ruta: '.str_replace("$idProveedor",$extraerNombreCarpetaPrimeraCaperta['nombre'],$extraerNombreCarpeta['ruta']).'</b>';
            ?>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Proveedores Carpetas</li>
            </ol>
          </div>
        </div>
        <div>
            
            <div class="row">
            <?php
            if($visibleI == FALSE){
            ?>
            
           
                <?php
                /*if($bloqueoCarpeta == 1){
                    
                }else{*/
                ?>
                <div class="col-sm">
                    <button type="button" class="btn btn-block btn-info btn-sm" data-toggle="modal" data-target="#modal-carpeta"><font color="white"><i class="fas fa-plus-square"></i> Nueva carpeta</font></button>
            
                    <!--Modals-->
                    <div class="modal fade" id="modal-carpeta">
                        <div class="modal-dialog">
                          <div class="modal-content">
                              <form action="controlador/proveedor/controllerCarpetasB" method="POST">
                                 <input name="masivoEnviar" type="hidden" value="1">
                                 
                                <div class="modal-header">
                                  <h4 class="modal-title">Crear carpeta</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                            
                                  <label>Nombre carpeta:</label><br>
                                  <input type="text" name="nombre" placeholder="Nombre carpeta" class="form-control" required pattern="[a-zA-Z0-9á-úñ-áéíóúÁÉÍÓÚ ]{1,205}" title="No utilice caracteres especiales"onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" />
                                </div>
                              
                                <div class="modal-footer justify-content-between">
                                 
                                  <input name="primera" value="<?php echo $filaCarpeta+1;?>" type="hidden" readonly>
                          
                                  <input name="carpetaAbrir" value="<?php echo $_POST['carpetaAbrir'];?>" type="hidden" readonly>
                                  <input name="rolUsuario" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                                  <input name="documentoUsuario" value="<?php echo $idProveedor; ?>"  type="hidden">
                                  <input name="idProveedor" value="<?php echo $idProveedor; ?>"  type="hidden">
                                   
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                  <button type="submit" name="carpetaAgregar" class="btn btn-primary">Crear carpeta</button>
                                </div>
                            </form>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
            
           
            </div>
            <?php
                //}
            ?>
            <div class="col-sm">
                 <form action="agregarProveedorDocumentoMasivo" method="post">
                 <input name="masivoEnviar" type="hidden" value="1">
                 <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden">
                 <input name="filaCarpeta" value="<?php echo $filaCarpeta; ?>" type="hidden">
                 <input value="<?php echo $_POST['carpetaAbrir'];?>" name="carpetaAbrir" type="hidden">
                 <input name="abrirCarpeta" value="1" type="hidden">
                 <button type="submit" name="" class="btn btn-block btn-info btn-sm" ><font color="white"><i class="fas fa-plus-square"></i> Subir documentos</font></button>
                 </form>
            </div>
            <?php
            }else{ }
            ?>
           
           
            <?php 
            if($realizador == $idparaChat){
                
                ///// validación para evitar la notificación del encargado de aprobación de documentos
                $validandoDocumento=$mysqli->query("SELECT * FROM carpeta WHERE rol='".$_POST['idProveedor']."' AND fila='1' ORDER BY nombre ASC")or die(mysqli_error());
                $extraerValidaciónDocumentos=$validandoDocumento->fetch_array(MYSQLI_ASSOC);
                
                ///// validamos la existencia de un archivo
                $validandoDocumentoArchivos=$mysqli->query("SELECT * FROM uploadsP WHERE idCarpeta='".$extraerValidaciónDocumentos['id']."' ")or die(mysqli_error());
                $extraerValidaciónDocumentosArchivos=$validandoDocumentoArchivos->fetch_array(MYSQLI_ASSOC);
                if($extraerValidaciónDocumentosArchivos['id'] != NULL){
                    /*
            ?>
            <div class="col-sm">
                <form action="controlador/proveedor/controllerProveedor" method="post">
                 <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                 <input name="filaCarpeta" value="<?php echo $filaCarpeta; ?>" type="hidden">
                 <input value="<?php echo $_POST['carpetaAbrir'];?>" name="carpetaAbrir" type="hidden">
                 <input name="abrirCarpeta" value="1" type="hidden">
                 <?php
                     /// validamos el nombre de la carpeta principal
                     if($extraerNombreCarpeta['nombre'] && $extraerNombreCarpeta['fila'] == 1){
                         $nombreCarpetaEnviar=$extraerNombreCarpeta['nombre'];
                     }
                 ?>
                 <input name="nombreCarpetaPrincial" value="<?php echo $nombreCarpetaEnviar;?>" type="hidden">
                <button type="submit" class="btn btn-block btn-warning btn-sm" name="notificarAprobador"><a href="#"><font color="white"><i class="fas fa-bell"></i> Notificar aprobador</font></a></button>
                </form>
            </div>
            <?php
            */
                }
            }
            ?>
            
            <?php
            if($proveedorEstado == 'Aprobado'){
                /// verificamos si está dentro de la primera carpeta o dentro de las subcarpetas
                 if($filaCarpeta == '1'){
                 ?>
                 <div class="col-sm"><!-- Vista PPAL -->
                 <form action="" method="post">
                     <input name="idProveedor" value="<?php echo $_POST['idProveedor'];?>" type="hidden">
                    <button type="submit" class="btn btn-block btn-success btn-sm"><font color="white"><i class="fas fa-list"></i> Regresar</font></button>
                 </form>
                </div>
                 <?php    
                 }else{
                ?>
                <div class="col-sm"><!-- Vista PPAL -->
                 <form action="" method="post">
                     <input name="filaCarpeta" value="<?php echo ABS($filaCarpeta-1); ?>" type="hidden">
                     <input name="masivoEnviar" type="hidden" value="1">
                     <input type="hidden" value="<?php echo $extraerNombreCarpeta['idsubcarpeta'];?>" name="carpetaAbrir" >
                      <button  class="btn btn-block btn-success btn-sm" type="submit" name="abrirCarpeta" ><span class="fas fa-list"></span> Regresar</button>
                 </form>
                 </div>
                <?php
                 }
                
            }else{
                 /// verificamos si está dentro de la primera carpeta o dentro de las subcarpetas
                 if($filaCarpeta == '1'){
                 ?>
                 <div class="col-sm"><!-- Vista PPAL -->
                 <form action="" method="post">
                    <input name="masivoEnviar" type="hidden" value="1">
                    <input name="idProveedor" value="<?php echo $_POST['idProveedor'];?>" type="hidden">
                    <button type="submit" class="btn btn-block btn-success btn-sm"><font color="white"><i class="fas fa-list"></i> Regresar</font></button>
                 </form>
                </div>
                 <?php    
                 }else{
                ?>
                <div class="col-sm"><!-- Vista PPAL -->
                 <form action="" method="post">
                     <input name="masivoEnviar" type="hidden" value="1">
                     <input name="idProveedor" value="<?php echo $_POST['idProveedor']?>" type="hidden">
                     <input name="filaCarpeta" value="<?php echo ABS($filaCarpeta-1); ?>" type="hidden">
                     <input type="hidden" value="<?php echo $extraerNombreCarpeta['idsubcarpeta'];?>" name="carpetaAbrir" >
                     <button  class="btn btn-block btn-success btn-sm" type="submit" name="abrirCarpeta" ><span class="fas fa-list"></span> Regresar</button>
                 </form>
                 </div>
                <?php
                 }
            }
            
            ?>
            
            <div class="col-sm">
                <!--Creamos algoritmo para descargar las carpetas contenedoras-->
                <?php
                if($filaCarpeta == '1'){
                    
                    //// colocamos un botón únicamente para habilitar el botón de descargar, con eso evitamos la sobre carga del zip cada vez que entremos a los documentos
                    if(isset($_POST['generarZip'])){}else{ //// recibimos el name del botón de comprimir documentos para ocultarlo
                    ?>
                        <form action="" method="post">
                            <input name="masivoEnviar" type="hidden" value="1">
                            <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly>
                            <input name="filaCarpeta" value="<?php echo $filaCarpeta;?>" type="hidden">
                            <input name="carpetaAbrir" value="<?php echo $_POST['carpetaAbrir'];?>" type="hidden">
                            <input name="abrirCarpeta" value="1" type="hidden">
                            <button type='submit' name="generarZip" style="color:white;" class='btn btn-block btn-warning btn-sm' >
                                <i class='fas fa-download'></i> Comprimir documentos</a>
                            </button>
                        </form>
                    <?php
                    }
                    if(isset($_POST['generarZip'])){ //// recibimos el name de generarZip para generar el .zip
                        
                    
                        //// realizamos una consulta del contenido de la carpeta para descargar todo
                        $consultaNmbreCarpetaDescargar=$mysqli->query("SELECT * FROM carpeta WHERE id='".$_POST['carpetaAbrir']."' ");
                        $extraerNombreCarpetaDescargar=$consultaNmbreCarpetaDescargar->fetch_array(MYSQLI_ASSOC);
                        $extraerNombreCarpetaDescargar['nombre'];
                            ///// escribimos la codificación para descargar el contenido completo del proveedor
                            $zip = new ZipArchive();
                            // Ruta absoluta
                            $nombreArchivoZip = __DIR__ . "/archivos/documentoProveedor/".$_POST['idProveedor'].'/'.$extraerNombreCarpetaDescargar['nombre'].".zip";
                            $rutaDelDirectorio = __DIR__ . "/archivos/documentoProveedor/".$_POST['idProveedor'];
                            
                            if (!$zip->open($nombreArchivoZip, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
                                exit("Error abriendo ZIP en $nombreArchivoZip");
                            }
                            // Si no hubo problemas, continuamos
                            
                            // Crear un iterador recursivo que tendrá un iterador recursivo del directorio
                            $archivos = new RecursiveIteratorIterator(
                                new RecursiveDirectoryIterator($rutaDelDirectorio),
                                RecursiveIteratorIterator::LEAVES_ONLY
                            );
                            
                            foreach ($archivos as $archivo) {
                                // No queremos agregar los directorios, pues los nombres
                                // de estos se agregarán cuando se agreguen los archivos
                                if ($archivo->isDir()) {
                                    continue;
                                }
                            
                                $rutaAbsoluta = $archivo->getRealPath();
                                // Cortamos para que, suponiendo que la ruta base es: C:\imágenes ...
                                // [C:\imágenes\perro.png] se convierta en [perro.png]
                                // Y no, no es el basename porque:
                                // [C:\imágenes\vacaciones\familia.png] se convierte en [vacaciones\familia.png]
                                $nombreArchivo = substr($rutaAbsoluta, strlen($rutaDelDirectorio) + 1);
                                $zip->addFile($rutaAbsoluta, $nombreArchivo);
                            }
                            // No olvides cerrar el archivo
                            $resultado = $zip->close();
                            if ($resultado) {
                                //echo "Archivo creado";
                                 echo "<button type='button'  class='btn btn-block btn-warning btn-sm' >
                                                        <a style='color:white' href='archivos/documentoProveedor/".$_POST['idProveedor'].'/'.$extraerNombreCarpetaDescargar['nombre'].".zip'><i class='fas fa-download'></i> Descargar documentos</a>
                                                    </button>";
                            } else {
                                echo "<font color='red'>Error creando archivo</font>";
                            }
                    }
                }
                ?>
            </div>
            <div class="col-sm">
            </div>
            
            
    
            
            </div>
           
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"></h3>
                <div class="card-body table-responsive p-1 card-tools">
                           
                           
              </div>
            </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed text-center">
                     <thead>
                      <tr>
                        <th>Carpeta</th>
                        <th></th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                      </tr>
                    </thead>
                     <tbody>
                <?php ///// agregamos el while de las carpetas ---------------------------------------------------
                    //// enviamos la variable de la fila que se encuentra la carpeta
                    $contandoFilaCarpeta=$filaCarpeta+1;
                    //// end
                    //$validandoUsuario=$mysqli->query("SELECT * FROM usuarios WHERE id='$idUsuario' ");
                    //$extraerValidarUsuario=$validandoUsuario->fetch_array(MYSQLI_ASSOC);
                    
                    $datosDestino = $mysqli->query("SELECT * FROM carpeta WHERE rol='$idProveedor' AND fila='$contandoFilaCarpeta' ");  
                    while($rowDestino = $datosDestino->fetch_assoc()){
                        
                        if($extraerValidarUsuario['rol'] == 1){
                            if($rowDestino['rol'] == 1){
                                
                            }else{
                                //continue;
                            }
                        }
                        
                        
                        if($_POST['carpetaAbrir'] == $rowDestino['idsubcarpeta']){
                            
                        }else{
                            continue;
                        }
                        
                  ?>
                  
                  <tr>
                    <td style="text-align: left;" >
                        <form action="" method="post">
                            <input name="masivoEnviar" type="hidden" value="1">
                            <input name="idProveedor" value="<?php echo $_POST['idProveedor']?>" type="hidden">
                            <input name="carpetaAbrir" value="<?php echo $rowDestino['id']; ?>"type="hidden">
                            <!--<button style="background:transparent;border:0px;" type="submit" name="abrirCarpeta"><img src="img/carpeta2.png" width="100" height=""></button>-->
                            <button type="submit" style="border:0px;background:transparent;" name="abrirCarpeta">
                            <?php
                                echo"<span style=' color:#293B7D;' ><i class='fa fa-folder fa-2x' ></i></span><font color='white'>--</font>".($rowDestino['nombre'])." ";
                            ?>
                            </button>
                        </form>
                    </td>
                    <td>
                        <?php
                        //// colocamos un botón únicamente para habilitar el botón de descargar, con eso evitamos la sobre carga del zip cada vez que entremos a los documentos
                        if($_POST['generarZipOpcion'] == $rowDestino['id']){}else{ //// recibimos el name del botón de comprimir documentos para ocultarlo
                        ?>
                            <form action="" method="post">
                                <input name="masivoEnviar" type="hidden" value="1">
                                <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly>
                                <input name="filaCarpeta" value="<?php echo $filaCarpeta;?>" type="hidden">
                                <input name="carpetaAbrir" value="<?php echo $_POST['carpetaAbrir'];?>" type="hidden">
                                <input name="abrirCarpeta" value="1" type="hidden">
                                <input name="generarZipOpcion" value="<?php echo $rowDestino['id'];?>" type="hidden">
                                <button type='submit'  style="color:white;" class='btn btn-block btn-warning btn-sm' >
                                    <i class='fas fa-download'></i> Comprimir documentos</a>
                                </button>
                            </form>
                        <?php
                        }
                        if($_POST['generarZipOpcion'] == $rowDestino['id']){ 
                         //// recibimos el name de generarZip para generar el .zip
                            
                        
                            //// realizamos una consulta del contenido de la carpeta para descargar todo
                            $consultaNmbreCarpetaDescargar=$mysqli->query("SELECT * FROM carpeta WHERE id='".$_POST['carpetaAbrir']."' ");
                            $extraerNombreCarpetaDescargar=$consultaNmbreCarpetaDescargar->fetch_array(MYSQLI_ASSOC);
                            $extraerNombreCarpetaDescargar['nombre'];
                                ///// escribimos la codificación para descargar el contenido completo del proveedor
                                $zip = new ZipArchive();
                                // Ruta absoluta
                                $nombreArchivoZip = __DIR__ . "/archivos/documentoProveedor/".$_POST['idProveedor'].'/'.$rowDestino['nombre'].".zip";
                                $rutaDelDirectorio = __DIR__ . "/archivos/documentoProveedor/".$rowDestino['ruta'];
                                
                                if (!$zip->open($nombreArchivoZip, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
                                    exit("Error abriendo ZIP en $nombreArchivoZip");
                                }
                                // Si no hubo problemas, continuamos
                                
                                // Crear un iterador recursivo que tendrá un iterador recursivo del directorio
                                $archivos = new RecursiveIteratorIterator(
                                    new RecursiveDirectoryIterator($rutaDelDirectorio),
                                    RecursiveIteratorIterator::LEAVES_ONLY
                                );
                                
                                foreach ($archivos as $archivo) {
                                    // No queremos agregar los directorios, pues los nombres
                                    // de estos se agregarán cuando se agreguen los archivos
                                    if ($archivo->isDir()) {
                                        continue;
                                    }
                                
                                    $rutaAbsoluta = $archivo->getRealPath();
                                    // Cortamos para que, suponiendo que la ruta base es: C:\imágenes ...
                                    // [C:\imágenes\perro.png] se convierta en [perro.png]
                                    // Y no, no es el basename porque:
                                    // [C:\imágenes\vacaciones\familia.png] se convierte en [vacaciones\familia.png]
                                    $nombreArchivo = substr($rutaAbsoluta, strlen($rutaDelDirectorio) + 1);
                                    $zip->addFile($rutaAbsoluta, $nombreArchivo);
                                }
                                // No olvides cerrar el archivo
                                $resultado = $zip->close();
                                if ($resultado) {
                                    //echo "Archivo creado";
                                     echo "<button type='button'  class='btn btn-block btn-warning btn-sm' >
                                                            <a style='color:white' href='archivos/documentoProveedor/".$_POST['idProveedor'].'/'.$rowDestino['nombre'].".zip'><i class='fas fa-download'></i> Descargar documentos</a>
                                                        </button>";
                                } else {
                                    echo "<font color='red'>Error creando archivo</font>";
                                }
                        }
                        ?>
                    </td>
                   
                        <?php
                        /// traemos el conteo de la cantidad de archivos existentes dentro de la carpeta
                        $contandoArchivos=$mysqli->query("SELECT count(*) FROM uploadsP WHERE idCarpeta='".$rowDestino['id']."' ");
                        $extraerContandoArchivos=$contandoArchivos->fetch_array(MYSQLI_ASSOC);
                        if($extraerContandoArchivos['count(*)'] == 1){
                         //   echo $extraerContandoArchivos['count(*)'].' archivo';    
                        }else{
                         //   echo $extraerContandoArchivos['count(*)'].' archivos';
                        }
                        ?>
                   
                    <td>
                     
                        <form action="" method="POST">
                            <input name="masivoEnviar" type="hidden" value="1">
                            <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly>
                            <input name="idDestino" value="<?php echo $rowDestino['id']; ?>" type="hidden" readonly>
                            <input name="filaCarpeta" value="<?php echo $rowDestino['fila'];?>" type="hidden">
                            <input name="carpetaAbrir" value="<?php echo $_POST['carpetaAbrir'];?>" type="hidden">
                            <input name="abrirCarpeta" value="1" type="hidden">
                             <button type="submit" name="Update" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button>
                        </form>
                       
                    </td>    
                    <td>
                        <?php
                        /// verificamos la existencia de un archivo para no eliminar la carpeta
                        $consultandoRutas=$mysqli->query("SELECT * FROM uploadsP WHERE idCarpeta='".$rowDestino['id']."'  ");
                        $extraerRuta=$consultandoRutas->fetch_array(MYSQLI_ASSOC);
                        
                        /// verificamos la existencia de una carpeta para no eliminar la carpeta
                        $consultandoRutasCarpeta=$mysqli->query("SELECT * FROM carpeta WHERE idsubcarpeta='".$rowDestino['id']."'  ");
                        $extraerRutaCarpeta=$consultandoRutasCarpeta->fetch_array(MYSQLI_ASSOC);
                        
                        if($extraerRuta['id'] != NULL || $extraerRutaCarpeta['id'] != NULL){
                        ?>
                        <button disabled style='color:white;'  class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button>
                        <?php
                        }else{
                            /// validación de script y funcion de eliminacion
                        ?>
                        <!--
                        <form action="../config/controller" method="POST">
                            <input name="idDestino" value="<?php //echo $rowDestino['id']; ?>" type="hidden" readonly>
                            <input name="filaCarpeta" value="<?php //echo $rowDestino['fila'];?>" type="hidden">
                            <input type="hidden" value="<?php //echo $_POST['carpetaAbrir'];?>" name="carpetaAbrir" >
                            <button type="submit" name="carpetaBorrar" onclick='return ConfirmDelete()' class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></button>
                        </form>
                        -->
                        <input name="idDestino" id="idDestino<?php echo $idDestino1++;?>" value="<?php echo $rowDestino['id']; ?>" type="hidden">
                        <input name="filaCarpeta" id="filaCarpeta<?php echo $filaCarpeta1++;?>" value="<?php echo $rowDestino['fila'];?>" type="hidden">
                        <input type='hidden' id='capturaVariableCarpeta<?php echo $contador++;?>'  value= '<?php echo $rowDestino['id'];?>' >
                        <a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-dangerCarpeta' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a>
                        <script>
                            function funcionFormula<?php echo $contador2++;?>() {
                                /*alert("entre");*/
                              document.getElementById("capturarFormulaCarpeta").value = document.getElementById("capturaVariableCarpeta<?php echo $contador3++;?>").value;
                              document.getElementById("capturarFormulaidDestino").value = document.getElementById("idDestino<?php echo $idDestino2++;?>").value;
                              document.getElementById("capturarFormulafilaCarpeta").value = document.getElementById("filaCarpeta<?php echo $filaCarpeta2++;?>").value;
                            }
                        </script>
                        <?php
                        /// END
                        
                       
                        }
                       ?>
                       
                    </td>
                  </tr>
                  <?php
                    }
                  ?>
                
                
                  <?php
                 
                    $datosDestino = $mysqli->query("SELECT * FROM uploadsP WHERE idCarpeta='".$_POST['carpetaAbrir']."' ORDER BY file_name ");
                    $contandoCantidadArchivos=0;
                    while($rowDestino = $datosDestino->fetch_array()){
                        $contandoCantidadArchivos++;
                  ?>
                  
                  <tr>
                    
                    <td style="text-align: left;" ><?php echo $rowDestino['file_name'];//substr($rowDestino['file_name'], 1); ?></td>
                    <td></td>
                    <td>
                        <?php
                        $preguntaCarpeta=$mysqli->query("SELECT * FROM carpeta WHERE  id='".$rowDestino['idCarpeta']."' ")or die("database error:". mysqli_error($mysqli));
                        $extraerpreguntaCarpeta=$preguntaCarpeta->fetch_array(MYSQLI_ASSOC);
                        $extraerpreguntaCarpeta['ruta'].'/'.$rowDestino['file_name'];
                        
                        /// Dentro del nombre del archivo buscamos la extensión .csv
                        
                        $cadena_de_texto = $rowDestino['file_name'];
                        $cadena_buscada   = '.csv';
                        $posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
                        
                        echo"
                        <button type='button'  class='btn btn-block btn-warning btn-sm'>
                            <i class='fas fa-download'></i>
                            <a style='color:black' href='archivos/documentoProveedor/".$extraerpreguntaCarpeta['ruta'].'/'.$rowDestino['file_name']."' download='".$rowDestino['file_name']."' target='_blank'>Descargar</a>
                        </button>
                        ";
                        
                       ?>
                           
                        
                    </td>
                    
                    <td style='text-align:justify;'>
                        <input name="idDestino" id="idDestinoArchivo<?php echo $idDestino1++;?>" value="<?php echo $rowDestino['id']; ?>" type="hidden">
                        <input name="filaCarpeta" id="filaArchivo<?php echo $filaCarpeta1++;?>" value="<?php echo $rowDestino['fila'];?>" type="hidden">
                        <input type='hidden' id='capturaVariableArchivo<?php echo $contador++;?>'  value= '<?php echo $rowDestino['id'];?>' >
                        <a onclick='funcionFormulaSolicitudArchivo<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-dangerArchivos' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a>
                        <script>
                            function funcionFormulaSolicitudArchivo<?php echo $contador2++;?>() {
                                /*alert("entre");*/
                              document.getElementById("capturarFormulaArchivo").value = document.getElementById("capturaVariableArchivo<?php echo $contador3++;?>").value;
                              document.getElementById("archivoFormulaidDestino").value = document.getElementById("idDestinoArchivo<?php echo $idDestino2++;?>").value;
                              document.getElementById("archivoFormulafilaCarpeta").value = document.getElementById("filaArchivo<?php echo $filaCarpeta2++;?>").value;
                            }
                        </script>
                    </td>  
                  </tr>
                  <?php
                    }
                  ?>
                    </tbody>
                </table>
                
                <?php
                /////// recuperamos el id que ingresa para editar con funciones del modal
                if(isset($_POST['Update'])){
                   
                   
                   $consultaCarpeta=$mysqli->query("SELECT * FROM carpeta WHERE id='".$_POST['idDestino']."' ");
                   $extraerConsultaCarpeta=$consultaCarpeta->fetch_array(MYSQLI_ASSOC);
                   $nombreCarpetaEditar=$extraerConsultaCarpeta['nombre'];
                ?>
                
                      <button style="display:none;" type="button" id="action-button" data-toggle="modal" data-target="#modal-carpetaEditar">ssss</button>
                
                        <!--Modals-->
                        <div class="modal fade" id="modal-carpetaEditar">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                  <form action="controlador/proveedor/controllerCarpetasB" method="POST">
                                    <input name="masivoEnviar" type="hidden" value="1">
                                    <div class="modal-header">
                                      <h4 class="modal-title">Editar carpeta</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                
                                      <label>Nombre carpeta:</label><br>
                                      <input type="text" name="nombre" placeholder="Nombre carpeta" value="<?php echo $nombreCarpetaEditar;?>" class="form-control" required pattern="[a-zA-Z0-9á-úñ-áéíóúÁÉÍÓÚ ]{1,205}" title="No utilice caracteres especiales" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)"/>
                                    </div>
                                  
                                    <div class="modal-footer justify-content-between">
                                     
                                      <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly> 
                                      <input name="idDestino" value="<?php echo $extraerConsultaCarpeta['id'];?>" type="hidden">
                                      <input name="nombreAnterior" value="<?php echo $extraerConsultaCarpeta['nombre']; ?>" type="hidden">
                                      <input name="abrirCarpeta" value="1" type="hidden">
                                      <input name="carpetaAbrir" value="<?php echo $_POST['carpetaAbrir'];?>"  type="hidden">
                                       
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                      <button type="submit" name="carpetaEditar" class="btn btn-primary">Actualizar</button>
                                    </div>
                                </form>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                            <script>
                                $(document).ready(function() {
                                  // indicamos que se ejecuta la funcion a los 5 segundos de haberse
                                  // cargado la pagina
                                  setTimeout(clickbutton, 0000);
                                
                                  function clickbutton() {
                                    // simulamos el click del mouse en el boton del formulario
                                    $("#action-button").click();
                                    //alert("Aqui llega"); //Debugger
                                  }
                                  $('#action-button').on('click',function() {
                                   // console.log('action');
                                  });
                                });
                           </script> 
                           <button id="action-button" style="display:none;" data-toggle="modal" data-target="#modal-sm"></button>
                <?php
                }
                  /// end
                ?>
                
                <!-- acá colocamos la alerta de la eliminación de carpeta-->
                <div class="modal fade" id="modal-dangerCarpeta">
                        <div class="modal-dialog">
                          <div class="modal-content bg-danger">
                            <div class="modal-header">
                              <h4 class="modal-title">Alerta</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>¿Est&aacute; seguro que desea eliminar la carpeta?</p>
                            </div>
                             <!-- formulario para eliminar por el id  -->
                            <form action='controlador/proveedor/controllerCarpetasB' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input name="masivoEnviar" type="hidden" value="1">
                              <input name="idProveedor" value="<?php echo $_POST['idProveedor'];?>" type="hidden">
                              <input type="hidden" id="capturarFormulaCarpeta" name='idTipo' >
                              <input name="idDestino" id="capturarFormulaidDestino"  type="hidden" >
                              <input name="filaCarpeta" id="capturarFormulafilaCarpeta" type="hidden">
                              <input name="carpetaAbrir" value="<?php echo $_POST['carpetaAbrir'];?>" type="hidden">
                              <input name="abrirCarpeta" value="1" type="hidden">
                              
                              <button type="submit" name='carpetaBorrar' class="btn btn-outline-light">Si</button>
                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                            </div>
                             </form>
                             <!-- END formulario para eliminar por el id -->
                          </div>
                        </div>
                </div>
                
                
                <!-- acá colocamos la alerta de la eliminación de archivos-->
                <div class="modal fade" id="modal-dangerArchivos">
                        <div class="modal-dialog">
                          <div class="modal-content bg-danger">
                            <div class="modal-header">
                              <h4 class="modal-title">Alerta</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>¿Est&aacute; seguro que desea eliminar el archivo?</p>
                            </div>
                             <!-- formulario para eliminar por el id  controllerCarpetasB-->
                            <form action='controlador/proveedor/controllerCarpetasB' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input name="masivoEnviar" type="hidden" value="1">
                              <input name="idProveedor" value="<?php echo $_POST['idProveedor'];?>" type="hidden">
                              <input type="hidden" id="capturarFormulaArchivo" name='idTipo' >
                              <input name="idDestino" id="archivoFormulaidDestino"  type="hidden" >
                              <input name="filaCarpeta" id="archivoFormulafilaCarpeta" type="hidden">
                              <input name="carpetaAbrir" value="<?php echo $_POST['carpetaAbrir'];?>" type="hidden">
                              <input name="abrirCarpeta" value="1" type="hidden">
                              
                              <button type="submit" name='archivoBorrar' class="btn btn-outline-light">Si</button>
                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                            </div>
                             </form>
                             <!-- END formulario para eliminar por el id -->
                          </div>
                        </div>
                </div>
                
                
                
                   <?php
               
                       $validandoAprobador=$mysqli->query("SELECT * FROM proveedores WHERE id='$idProveedor' ");
                       while($extraerValidacionAProbdor=$validandoAprobador->fetch_array()){
                       //// mandamos la variable si el siguiente paso está activado o no
                       $enviamosSiguienteOPaso=$extraerValidacionAProbdor['notificacion'];
                       
                        $quienElaboraConteoV = $extraerValidacionAProbdor['radio']; 
                        $quienElaboraIDconteoV = json_decode($extraerValidacionAProbdor['aprobador']);
                        
                        if($quienElaboraConteoV == "cargo"){
                            if(in_array($cargo,$quienElaboraIDconteoV)){
                                $habilitarAprbacion='1';
                            }
                        }
                        
                        if($quienElaboraConteoV == "usuario"){
                            if(in_array($idparaChat,$quienElaboraIDconteoV)){
                                $habilitarAprbacion='1';
                            }
                        }
                       }
                
              
              
              
            ?>  <br><br>
             <div class="col-sm-12">
                            <div class="card">
                               
                                    <div style="padding: 20px;" class="tab-pane" id="timeline">
                                        <!-- The timeline -->
                                        <div class="timeline timeline-inverse">
                                          <!-- timeline time label -->
                                          <?php 
                                           
                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                            $queryControl = $mysqli->query("SELECT * FROM proveedoresControlCambio WHERE idProveedor = '$idProveedor' ")or die(mysqli_error($mysqli));
                                            
                                            while($row = $queryControl->fetch_assoc()){
                                                $idUser = $row['Usuario'];
                                                $rol = $row['rol'];
                                                $queryUser = $mysqli->query("SELECT * FROM usuario WHERE id = '$idUser' ")or die(mysqli_error($mysqli));
                                                $datosUser = $queryUser->fetch_assoc();

                                                $nombreUsuario = $datosUser['nombres']." ".$datosUser['apellidos'];
                                          
                                          ?>
                                          
                                          <div class="time-label">
                                            <span class="bg-danger">
                                              <?php echo $row['fecha'];?>
                                            </span>
                                          </div>

                                          <div>
                                            <i class="fas fa-user bg-info"></i>
                    
                                            <div class="timeline-item">
                                              <h3 class="timeline-header border-0"><b><?php echo $row['rol'];?></b> - <a href="#"><?php echo $nombreUsuario;?></a> <?php  if('1' != NULL){ echo utf8_decode($row['comentario']); }else{ echo 'N/A';} ?>
                                              </h3>
                                            </div>
                                          </div>
                                        <?php }?>
                                        </div>
                                     </div>
                            </div>
                        </div>   
                 
              <?php      
              /*
                if($habilitarAprbacion == 1 && $enviamosSiguienteOPaso == 'Pendiente'){
              ?>
                <form action="controlador/proveedor/controllerDocumento" method="post"> <!---->
                
                    <input name="rol" value="Aprobador" type="hidden">
                    <input name='idProveedor' value= '<?php echo $idProveedor;?>' type='hidden' >
                    <input name="filaCarpeta" value="<?php echo $filaCarpeta; ?>" type="hidden">
                    <input value="<?php echo $_POST['carpetaAbrir'];?>" name="carpetaAbrir" type="hidden">
                    <input name="abrirCarpeta" value="1" type="hidden">
                    <input name="usuario" value="<?php echo $idparaChat;?>" type="hidden">
                  
                      <div class="card-header">
                        <?php
                        if($habilitarAprbacion == 1){
                        ?>
                        
                            <label>Especifique el Motivo de decisión</label>
                            <textarea name="comentario" class="form-control" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)"><?php //echo utf8_decode($extarer['comentario']);?></textarea>
                            
                        <?php
                        }else{
                        ?>
                            
                            <label>Comentario</label>
                            <textarea name="comentario" class="form-control" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)"><?php //echo utf8_decode($extarer['comentario']);?></textarea>
                            
                        <?php
                        }
                        ?>
                        <br>
                        
                        Aprobar
                        <input type="radio" name="aprobadorDocumento" id="desactivarInput" value="aprobado" required>&nbsp;
                        Rechazar
                        <input type="radio" name="aprobadorDocumento" id="activarInput" value="rechazado"  required>
                        <br><br>
                        <button type="submit" id="validadarNotificacion" <?php echo $disabledEstadoComentado;?> class="btn btn-primary float-left" name="aprobador">Agregar</button>

                      </div>
               </form>
                                  
                                 
                <?php
                }else{
                ?>
                
                <div class="card-header">
                    <form action="controlador/proveedor/controllerDocumento" method="post"> 
                        <input name='idProveedor' value= '<?php echo $idProveedor;?>' type='hidden' >
                        <input name="rol" value="Solicitante" type="hidden">
                        <input name="filaCarpeta" value="<?php echo $filaCarpeta; ?>" type="hidden">
                        <input value="<?php echo $_POST['carpetaAbrir'];?>" name="carpetaAbrir" type="hidden">
                        <input name="abrirCarpeta" value="1" type="hidden">
                        <input name="usuario" value="<?php echo $idparaChat;?>" type="hidden">
                        
                        <?php
                      
                        
                        'Quién hizo la solicitud: '.$realizador;
                        '<br>Mi id: '.$idparaChat;
                        if($realizador == $idparaChat){
                            //// validamos la existencia de un documento para enviar algún tipo de comentario
                             ///// validación para evitar la notificación del encargado de aprobación de documentos
                            $validandoDocumentoValidando=$mysqli->query("SELECT * FROM carpeta WHERE rol='".$_POST['idProveedor']."' AND fila='1' ORDER BY nombre ASC")or die(mysqli_error());
                            $extraerValidaciónDocumentosValidando=$validandoDocumentoValidando->fetch_array(MYSQLI_ASSOC);
                            
                            ///// validamos la existencia de un archivo
                            $validandoDocumentoArchivosValidando=$mysqli->query("SELECT * FROM uploadsP WHERE idCarpeta='".$extraerValidaciónDocumentos['id']."' ")or die(mysqli_error());
                            $extraerValidaciónDocumentosArchivosValidando=$validandoDocumentoArchivosValidando->fetch_array(MYSQLI_ASSOC);
                            if($extraerValidaciónDocumentosArchivosValidando['id'] != NULL){
                        ?>            
                                <div class="card-header">
                                    <label>Comentario</label>
                                    <textarea  name="comentario" class="form-control" required></textarea>
                                    <br>
                                    <button style="display:<?php?>;" type="submit"  class="btn btn-primary float-left" name="comentarioAgregar">Agregar</button>
                                </div>
                        <?php
                            }
                            //// end
                        }
                        ?>
                    </form>
                </div>
                
                
                
                <?php
                }
              */
              ?>
                
                
                
                
                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php echo require_once'footer.php'; ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- Script advertencia eliminar -->
<script type="text/javascript">
	function ConfirmDelete(){
		var answer = confirm("¿Esta seguro de eliminar?");

		if(answer == true){
			return true;
		}else{
			return false;
		}
	}
</script>
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<?php
/// validaciones de alertas
$validacionExiste=$_POST['validacionExiste'];
$validacionExisteB=$_POST['validacionExisteB'];
$validacionExisteC=$_POST['validacionExisteC'];
$validacionExisteD=$_POST['validacionExisteD'];
$validacionExisteE=$_POST['validacionExisteE'];
$validacionAgregar=$_POST['validacionAgregar'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];
$validacionComentario=$_POST['validacionComentario'];

//// validaciones de importacion
$validacionExisteImportacion=$_POST['validacionExisteImportacion'];
$validacionExisteImportacionB=$_POST['validacionExisteImportacionB'];
$validacionExisteImportacionC=$_POST['validacionExisteImportacionC'];
$validacionExisteImportacionD=$_POST['validacionExisteImportacionD'];
$validacionExisteImportacionE=$_POST['validacionExisteImportacionE'];
$validacionExisteImportacionF=$_POST['validacionExisteImportacionF'];
$validacionExisteImportacionH=$_POST['validacionExisteImportacionG'];
$validacionExisteImportacionExito=$_POST['validacionExisteImportacionExito'];
/// END

?>
<script type="text/javascript">
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
    
    
    <?php 
    if($validacionComentario == 1){
     ?>
        Toast.fire({
            type: 'success',
            title: ' Comentario agregado.'
        })
    <?php   
    }
     if($validacionExisteImportacionExito == 1){
     ?>
        Toast.fire({
            type: 'success',
            title: ' Excel importado correctamente.'
        })
    <?php   
    }
    if($validacionExisteImportacion == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El archivo no se pudo eliminar.'
        })
    <?php
    }
    if($validacionExisteImportacionB == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: ' El aprobador fue notificado.'
        })
    <?php
    }
    if($validacionExisteImportacionC == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos prefijos están repetidos en el documento.'
        })
    <?php
    }
    if($validacionExisteImportacionD == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos nombres están repetidos.'
        })
    <?php
    }
    if($validacionExisteImportacionE == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos dueños de procesos no existen.'
        })
    <?php
    }
    if($validacionExisteImportacionF == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos prefijos están repetidos.'
        })
    <?php
    }
    if($validacionExisteImportacionG == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos macroproceso no existen.'
        })
    <?php
    }
    if($validacionExisteImportacionH == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos elementos no existen o estan repetidos.'
        })
    <?php
    }
    
    
    
    
    if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' La carpeta ya existe.'
        })
    <?php
    }
    if($validacionExisteB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Error al crear la carpeta.'
        })
    <?php
    }
    if($validacionExisteC == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El nombre del proceso ya existe.'
        })
    <?php
    }
    if($validacionExisteD == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El prefijo del proceso ya existe.'
        })
    <?php
    }
    if($validacionExisteE == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El proceso se encuentra en uso, no se puede eliminar.'
        })
    <?php
    }
    
    if($validacionAgregar == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: 'Registro agregado.'
        })
    <?php
    }
    
    if($validacionActualizar == 1){
    ?>
        Toast.fire({
            type: 'info',
            title: 'Registro actualizado.'
        })
    <?php
    }
    
    if($validacionEliminar == 1){
    ?>
        Toast.fire({
            type: 'error',
            title: 'Registro eliminado.'
        })
    
    <?php
    }
    ?>
    
  });

</script>
</body>
</html>


<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
<?php
}else{
?>

<!DOCTYPE html>
<html>
    <title>Proveedores Carpetas</title>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">


  <!-- Main Sidebar Container -->
  <?php echo require_once'menu.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
              <?php
                $idProveedor=$_POST['idProveedor'];
                $validarCarpetaPrincipal = $mysqli->query("SELECT * FROM carpeta  WHERE rol='$idProveedor' AND fila='1' ");
                $extraerValidarCarpetaPrincipal=$validarCarpetaPrincipal->fetch_array(MYSQLI_ASSOC);
                
                /// traemos el nombre del proveedor
                $validarNombreProveedor = $mysqli->query("SELECT * FROM proveedores  WHERE id='$idProveedor' ");
                $extraerValidarNombreProveedor=$validarNombreProveedor->fetch_array(MYSQLI_ASSOC);
              ?>
            <h1>Carpetas del proveedor <b><?php echo ($extraerValidarNombreProveedor['razonSocial']); ?></b></h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Proveedores Carpetas</li>
            </ol>
          </div>
        </div>
        <div>
            
            <div class="row">
            <?php
            if($visibleI == FALSE){
            ?>
            
           
                <?php
                if($extraerValidarCarpetaPrincipal['id'] != NULL){ 
                    
                }else{
                ?>
                <div class="col-sm">
                <form action="agregarCarpetaMasiva" method="POST">
                    <input name="masivoEnviar" type="hidden" value="1">
                    <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                    <button type="submit" class="btn btn-block btn-info btn-sm"><a href="#"><font color="white"><i class="fas fa-plus-square"></i> Nueva Carpeta</font></a></button>
                </form>
                
                </div>
            <?php
                }
            ?>
            
            <?php
            }else{ }
            ?>
           
            
            <?php
            if($proveedorEstado == 'Aprobado'){
            ?>
            <div class="col-sm"><!-- Vista PPAL -->
                <button type="button" class="btn btn-block btn-success btn-sm"><a href="proveedores"><font color="white"><i class="fas fa-list"></i> Regresar</font></a></button>
            </div>
            <?php
                
            }elseif($_POST['masivoEnviar'] != NULL){
            ?>
            <div class="col-sm"><!-- Vista PPAL -->
                <button type="button" class="btn btn-block btn-success btn-sm"><a href="proveedorVigente"><font color="white"><i class="fas fa-list"></i> Regresar</font></a></button>
            </div>
            <?php
            }else{
             ?>
            <div class="col-sm"><!-- Vista PPAL -->
                <button type="button" class="btn btn-block btn-success btn-sm"><a href="proveedoresInscripcion"><font color="white"><i class="fas fa-list"></i> Regresar3</font></a></button>
            </div>
            <?php   
            }
            
            ?>
            <!--
            <div class="col-sm">
                  <a href="pruebas.php">
   <button type="button" class="btn btn-block btn-warning btn-sm"><a href="pruebas.php"><font color="white"><i class="fas fa-list"></i> Pruebas</font></a></button>
</a>
            </div>-->
            <div class="col-sm">
            </div>
            <div class="col-sm">
            </div>
            
            
    
            
            </div>
           
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"></h3>
                <div class="card-body table-responsive p-1 card-tools">
                           
                           
              </div>
            </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed ">
                     <thead>
                      <tr>
                        <th>Carpeta</th>
                        <th>Editar</th>
                        <!--<th>Eliminar</th>-->
                      </tr>
                    </thead>
                    <tbody>
                  <?php
                    /// validamos el rol del usuario
                    $validandoUsuario=$mysqli->query("SELECT * FROM usuarios WHERE id='$idUsuario' ");
                    $extraerValidarUsuario=$validandoUsuario->fetch_array(MYSQLI_ASSOC);
                    
                    
                    $datosDestino = $mysqli->query("SELECT * FROM carpeta WHERE rol='".$_POST['idProveedor']."' AND fila='1' ");   
                    while($rowDestino = $datosDestino->fetch_assoc()){
                        if($extraerValidarUsuario['rol'] == 1){
                            if($rowDestino['rol'] == 1){
                                
                            }else{
                                continue;
                            }
                        }
                  ?>
                  
                  <tr>
                    <td>
                        <form action="" method="post">
                            <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly>
                            <input name="carpetaAbrir" value="<?php echo $rowDestino['id']; ?>"type="hidden">
                            <button style="background:transparent;border:0px;" type="submit" name="abrirCarpeta">
                            <?php
                                echo"<span style=' color:#293B7D;' ><i class='fa fa-folder fa-2x' ></i></span><font color='white'>--</font>".($rowDestino['nombre'])." ";
                            ?>
                            </button>
                        </form>
                    </td>
                    <td>
                            <form action="agregarCarpetaEditarMasivo" method="POST">
                                <input name="idProveedor" value="<?php echo $_POST['idProveedor']; ?>" type="hidden" readonly>
                                <input name="idDestino" value="<?php echo $rowDestino['id']; ?>" type="hidden" readonly>
                                 <button type="submit" name="Update" class="btn btn-block btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button>
                            </form>
                        
                    </td>
                    <!--
                    <td>
                            <?php
                            /// no nos puede dejar eliminar un conductor si ya tiene rutas
                            $consultandoRutas=$mysqli->query("SELECT * FROM uploadsP WHERE idCarpeta='".$rowDestino['id']."'  ");
                            $extraerRuta=$consultandoRutas->fetch_array(MYSQLI_ASSOC);
                            
                            /// verificamos la existencia de una carpeta para no eliminar la carpeta
                            $consultandoRutasCarpeta=$mysqli->query("SELECT * FROM carpeta WHERE idsubcarpeta='".$rowDestino['id']."'  ");
                            $extraerRutaCarpeta=$consultandoRutasCarpeta->fetch_array(MYSQLI_ASSOC);
                            
                            if($extraerRuta['id'] != NULL || $extraerRutaCarpeta['id'] != NULL){
                            ?>
                                <button disabled class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></button>
                            
                            <?php
                            }else{
                            ?>
                            <form action="../config/controller" method="POST">
                                <input name="idDestino" value="<?php //echo $rowDestino['id']; ?>" type="hidden" readonly>
                                <input name="filaCarpeta" value="<?php //echo $rowDestino['fila'];?>" type="hidden">
                                 <input name="primera" value="1" type="hidden" readonly>
                                <button type="submit" name="carpetaBorrar" onclick='return ConfirmDelete()' class="btn btn-danger" href="#"><i class="icon_close_alt2"></i></button>
                            </form>
                           <?php
                            }
                           ?>
                         
                    </td>
                    -->
                  </tr>
                  <?php
                    }
                  ?>
                </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php echo require_once'footer.php'; ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- Script advertencia eliminar -->
<script type="text/javascript">
	function ConfirmDelete(){
		var answer = confirm("¿Esta seguro de eliminar?");

		if(answer == true){
			return true;
		}else{
			return false;
		}
	}
</script>
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<?php
/// validaciones de alertas
$validacionExiste=$_POST['validacionExiste'];
$validacionExisteB=$_POST['validacionExisteB'];
$validacionExisteC=$_POST['validacionExisteC'];
$validacionExisteD=$_POST['validacionExisteD'];
$validacionExisteE=$_POST['validacionExisteE'];
$validacionAgregar=$_POST['validacionAgregar'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];
$validacionComentario=$_POST['validacionComentario'];

//// validaciones de importacion
$validacionExisteImportacion=$_POST['validacionExisteImportacion'];
$validacionExisteImportacionB=$_POST['validacionExisteImportacionB'];
$validacionExisteImportacionC=$_POST['validacionExisteImportacionC'];
$validacionExisteImportacionD=$_POST['validacionExisteImportacionD'];
$validacionExisteImportacionE=$_POST['validacionExisteImportacionE'];
$validacionExisteImportacionF=$_POST['validacionExisteImportacionF'];
$validacionExisteImportacionH=$_POST['validacionExisteImportacionG'];
$validacionExisteImportacionExito=$_POST['validacionExisteImportacionExito'];
/// END

?>
<script type="text/javascript">
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
    
    
    <?php 
    if($validacionComentario == 1){
     ?>
        Toast.fire({
            type: 'success',
            title: ' Comentario agregado.'
        })
    <?php   
    }
     if($validacionExisteImportacionExito == 1){
     ?>
        Toast.fire({
            type: 'success',
            title: ' Excel importado correctamente.'
        })
    <?php   
    }
    if($validacionExisteImportacion == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Está intentando subir un archivo diferente.'
        })
    <?php
    }
    if($validacionExisteImportacionB == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: ' El aprobador fue notificado.'
        })
    <?php
    }
    if($validacionExisteImportacionC == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos prefijos están repetidos en el documento.'
        })
    <?php
    }
    if($validacionExisteImportacionD == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos nombres están repetidos.'
        })
    <?php
    }
    if($validacionExisteImportacionE == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos dueños de procesos no existen.'
        })
    <?php
    }
    if($validacionExisteImportacionF == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos prefijos están repetidos.'
        })
    <?php
    }
    if($validacionExisteImportacionG == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos macroproceso no existen.'
        })
    <?php
    }
    if($validacionExisteImportacionH == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos elementos no existen o estan repetidos.'
        })
    <?php
    }
    
    
    
    
    if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' La carpeta ya existe.'
        })
    <?php
    }
    if($validacionExisteB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El prefijo ya existe.'
        })
    <?php
    }
    if($validacionExisteC == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El nombre del proceso ya existe.'
        })
    <?php
    }
    if($validacionExisteD == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El prefijo del proceso ya existe.'
        })
    <?php
    }
    if($validacionExisteE == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El proceso se encuentra en uso, no se puede eliminar.'
        })
    <?php
    }
    
    if($validacionAgregar == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: 'Registro agregado.'
        })
    <?php
    }
    
    if($validacionActualizar == 1){
    ?>
        Toast.fire({
            type: 'info',
            title: 'Registro actualizado.'
        })
    <?php
    }
    
    if($validacionEliminar == 1){
    ?>
        Toast.fire({
            type: 'error',
            title: 'Registro eliminado.'
        })
    
    <?php
    }
    ?>
    
  });

</script>
</body>
</html>


<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
<?php
}

}
?>