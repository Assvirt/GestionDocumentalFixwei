<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{

require_once 'conexion/bd.php';

//////////////////////PERMISOS////////////////////////

$formulario = 'listadoMaestro'; //aqui se cambia el nombre del formulario

require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////


?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Listado maestro</title>
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
<body class="hold-transition sidebar-mini" onload="nobackbutton();">
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
            <h1>Listado Maestro</h1>
            <h6>Consulte la última versión de los documentos controlados.</h6><br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Listado Maestro</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <?php
               
                    /// VALIDAMOS LA CODIFICACIÓN, QUE EXISTA TODOS LOS CAMPOS AGREGAMOS EXCEPTO VERSIÓN
                    $verificamosCodificacion=$mysqli->query("SELECT * FROM codificacion WHERe codificacion='Proceso' ");
                    $extraerVerificamosCodificacion=$verificamosCodificacion->fetch_array(MYSQLI_ASSOC);
                    
                    if($extraerVerificamosCodificacion['codificacion'] == 'Proceso'){
                        $proceso_activado='1';
                    }else{
                        $proceso_activado='0';
                    }
                    
                    $verificamosCodificacion=$mysqli->query("SELECT * FROM codificacion WHERe codificacion='Tipo de documento' ");
                    $extraerVerificamosCodificacion=$verificamosCodificacion->fetch_array(MYSQLI_ASSOC);
                    
                    if($extraerVerificamosCodificacion['codificacion'] == 'Tipo de documento'){
                        $tipo_documento_activado='1';
                    }else{
                        $tipo_documento_activado='0';
                    }
                    
                    $verificamosCodificacion=$mysqli->query("SELECT * FROM codificacion WHERe codificacion='Consecutivo' ");
                    $extraerVerificamosCodificacion=$verificamosCodificacion->fetch_array(MYSQLI_ASSOC);
                    
                    if($extraerVerificamosCodificacion['codificacion'] == 'Consecutivo'){
                        $consecutivo_activado='1';
                    }else{
                        $consecutivo_activado='0';
                    }
                /// END
              
                //// VALIDAMOS CUALES SON LOS DATOS FALTANTES EN LA CONFIGURACIÓN
                    if($proceso_activado == '0'){
                        $nombre_proceso='proceso<br>';
                    }
                    if($tipo_documento_activado == '0'){
                        $nombre_tipo_documento='tipo de documento<br>';
                    }
                    if($consecutivo_activado == '0'){
                        $nombre_consecutivo='consecutivo<br>';
                    }
                    
                    
                    $enviarMensajeAlerta=$nombre_proceso.''.$nombre_tipo_documento.''.$nombre_consecutivo;
                //// END
                    
                    
                    if($proceso_activado == 1 && $tipo_documento_activado == 1 && $consecutivo_activado == 1){
                        if($root == 1){
                
                        }else{
                ?>
                <div class="col-sm" style="display:<?php echo $visibleI;?>;">
                    <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarSolicitud"><font color="white"><i class="fas fa-plus-square"></i> Nueva solicitud</font></a></button>
                </div>
                
                <?php
                        }
                    }else{
                    ?>
                                            <div class="form-group col-md-12">
                                                <center>
                                                    
                                                        <div class="modal-dialog">
                                                        <div class="modal-content bg-danger">
                                                            <div class="modal-header">
                                                            <h4 class="modal-title">Alerta</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            </button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <p>Defina la codificación, falta registrar los siguientes datos:<br> <?php echo $enviarMensajeAlerta; ?></p>
                                                            </div>
                                                        <div class="modal-footer justify-content-between">
                                                        </div>
                                                        </div>
                                                        </div>
                                                </center>
                                            </div>
                    <?php
                    }
            
               
                ?>
                <div class="col-sm">
                    <form action="exportacion/listadoMaestro" method="POST" enctype="multipart/form-data">
                        <input name="idProceso" value="<?php echo $idProcesoUsuario;?>" type="hidden" readonly required>
                        <input name="visibleE" value="<?php echo $visibleE;?>" type="hidden" readonly required>
                    <button type="submit" class="btn btn-block btn-warning btn-sm" ><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
                    </form>
                    
                     
                </div>
                <div class="col-sm">
                    <?php
                    // validamos que el listado maestro esté vacio para no mostrar el botón de descargar
                    $validnadoMaestro=$mysqli->query("SELECT count(*) FROM documento WHERE vigente='1' AND pre IS NULL ");
                    while($extraervalidacionMaestro=$validnadoMaestro->fetch_array()){
                        $contadorMaetro=$extraervalidacionMaestro['count(*)'];
                    }
                    /*
                    if($contadorMaetro > 0){
                        if($permisoEditar == 1){
                                function agregar_zip($dir, $zip) {
                                    if (is_dir($dir)) {
                                        if ($da = opendir($dir)) {
                                            while (($archivo = readdir($da)) !== false) {
                                                if (is_dir($dir . $archivo) && $archivo != "." && $archivo != "..") {
                                                    "<strong>Creando directorio: $dir$archivo</strong><br/>";
                                                    agregar_zip($dir . $archivo . "/", $zip);
                                                } elseif (is_file($dir . $archivo) && $archivo != "." && $archivo != "..") {
                                                    "Agregando archivo: $dir$archivo <br/>";
                                                    $zip->addFile($dir . $archivo, $dir . $archivo);
                                                }
                                            }
                                            closedir($da);
                                        }
                                    }
                                }
                                 
                                ini_set("memory_limit","91256M");
                                $zip = new ZipArchive();
                                $dir = 'archivos/documentos/';
                                $rutaFinal = "archivos";
                                $archivoZip = "DocumentosListadoMaestro.zip";
                                 
                                if ($zip->open('archivos/'.$archivoZip, ZIPARCHIVE::CREATE) === true) {
                                    agregar_zip($dir, $zip);
                                    $zip->close();
                                    if (file_exists($rutaFinal."/".$archivoZip)) { // 
                                        //echo "Proceso Finalizado!! <br/><br/>";
                                        //echo "Descargar: <a href='$rutaFinal/$archivoZip'>$archivoZip</a>";
                                        
                                        echo "<button type='button'  class='btn btn-block btn-warning btn-sm' >
                                                    <a style='color:white' href='$rutaFinal/$archivoZip'><i class='fas fa-download'></i> Descargar documentos</a>
                                                </button>";
                                        
                                    } else {
                                        echo "<font color='red'>Error, archivo zip no ha sido creado!!</font>";
                                    }
                                }
                        }
                    }else{ } */
                    if($contadorMaetro > 0){
                        if($permisoEditar == 1){
                            unlink('archivos/listadoMaestro.zip');
                            
                            $zip = new ZipArchive();
                            $archivo="archivos/listadoMaestro.zip";
                            
                            if($zip->open($archivo,ZIPARCHIVE::CREATE)==true){
                                $validnadoMaestro=$mysqli->query("SELECT * FROM documento WHERE vigente='1' AND pre IS NULL ");
                                while($extraervalidacionMaestro=$validnadoMaestro->fetch_array()){
                                    if($extraervalidacionMaestro['nombreOtro'] != NULL){
                                        $zip->addFile("archivos/documentos/".$extraervalidacionMaestro['nombreOtro']."");
                                    }
                                    if($extraervalidacionMaestro['nombrePDF'] != NULL){
                                        $zip->addFile("archivos/documentos/".$extraervalidacionMaestro['nombrePDF']."");
                                    }
                                }
                                
                                $zip->close();
                                //echo 'Agregado '.$archivo;
                                echo "<button type='button'  class='btn btn-block btn-warning btn-sm' >
                                                        <a style='color:white' href='archivos/listadoMaestro.zip'><i class='fas fa-download'></i> Descargar documentos</a>
                                                    </button>";
                            }else{
                                echo 'Ups ! algo salío mal, ponerse  en contacto con los programadores.';
                            } 
                        }
                    }
                    // END
                    ?>
                </div>
                
                <div class="col-sm"></div>
                <div class="col-sm"></div>
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
                 <? ?>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>Versión</th>
                      <th>Código</th>
                      <th>Nombre</th>
                      <th>Tipo</th>
                      <th>Proceso</th>
                      <th style="width: 20px;">Ubicación</th>
                      <th>Implementación</th>
                      <th>Ver más</th>
                      <th>Descargar editable</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     $consultaBuscar=$_POST['buscar'];
                     $consultaBuscar2=$_POST['buscar2'];
                     $consultaBuscar3=$_POST['buscar3'];
                     $consultaBuscar4=$_POST['buscar4'];
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                     if($consultaBuscar != NULL || $consultaBuscar2 != NULL || $consultaBuscar3 != NULL || $consultaBuscar4 != NULL){
                         
                         if($consultaBuscar2 != NULL){
                         ///// se trae la consulta de la 3
                         $queryConsultaDocumento=$mysqli->query("SELECT * FROM tipoDocumento WHERE nombre LIKE  '%$consultaBuscar2%' ");
    	                 $rowConsulta=$queryConsultaDocumento->fetch_array(MYSQLI_ASSOC);
    	                 $nombreDocumento=$rowConsulta['id'];
    	                 ///////// fin
                         }
                         
                         if($consultaBuscar3 != NULL){
                         ///// se trae la consulta de la 3
                         $queryConsultaProceso=$mysqli->query("SELECT * FROM procesos WHERE nombre LIKE  '%$consultaBuscar3%' ");
    	                 $rowConsultaP=$queryConsultaProceso->fetch_array(MYSQLI_ASSOC);
    	                  $nombreroceso=$rowConsultaP['id'];
    	                 ///////// fin
                         }
                        
                         
                        $data = $mysqli->query("SELECT * FROM documento WHERE vigente = 1 AND nombres LIKE '%$consultaBuscar%' 
                        AND tipo_documento LIKE '%$nombreDocumento%'  AND ubicacion LIKE '%$consultaBuscar4%' ")or die(mysqli_error());
                        
                        
                        
                        if($consultaBuscar3 != NULL){
                        $data = $mysqli->query("SELECT * FROM documento WHERE proceso LIKE '%$nombreroceso%'  AND vigente = 1 ")or die(mysqli_error());
                        }
                        
                        if($consultaBuscar2 != NULL){
                        $data = $mysqli->query("SELECT * FROM documento WHERE tipo_documento LIKE '%$nombreDocumento%'  AND vigente = 1 ")or die(mysqli_error());
                        }
                        
                     }else{
                        $data = $mysqli->query("SELECT * FROM documento WHERE vigente = 1 ORDER BY codificacion ASC")or die(mysqli_error());
                     }
                     while($row = $data->fetch_assoc()){
                    
                        /*if($row['obsoleto'] == 1){
                            continue;
                        }*/
                        if($row['pre'] == 'si'){
                          continue;
                        }
                 
                    echo"<tr>";
                     
                     echo" <td style='text-align: justify;'>".$row['version']."</td>";
                     echo" <td style='text-align: justify;'>".$row['codificacion']."</td>";
                     echo" <td style='text-align:justify;'>".$row['nombres']."</td>";
                     $tipo = $row['tipo_documento'];
                     $nombreTipoDocumento = $mysqli->query("SELECT * FROM tipoDocumento WHERE id ='$tipo'")or die(mysqli_error());
                     $colu = $nombreTipoDocumento->fetch_array(MYSQLI_ASSOC);
                     $nombreT = $colu['nombre'];
                     ////$ruta = $colu['ruta'];
                     $ruta=$row['nombreOtro'];
                     echo" <td style='text-align: justify;'>".$nombreT."</td>";
                     $proceso =  $row['proceso'];
                        // $nombreProceso = $mysqli->query("SELECT * FROM procesos WHERE id ='$proceso'")or die(mysqli_error());
                        // $col3 = $nombreProceso->fetch_array(MYSQLI_ASSOC);
                        // $nombreP = $col3['nombre'];
                     echo" <td style='text-align: justify;'>".$row['nombreProceso']."</td>";
                     
                     if($row['ubicacion'] != NULL){
                        echo" <td style='text-align: justify;width: 20px;'>".$row['ubicacion']."</td>";
                     }else{
                         echo "<td style='text-align: justify;'>" . '<strong>No aplica</strong>'."</td>";
                     }
                     
                     
                     echo" <td style='text-align: justify;'>".substr($row['fechaAprobado'],0,-8)."</td>";
                        echo"<form action='verDocumento' method='POST' target='_blank'>";
                            echo"<td>";
                                echo"<input type='hidden' name='idDocumento' value='".$row['id']."'>";
                                echo"<input type='hidden' name='idSolicitud' value='".$row['id_solicitud']."'>";
                                echo"<button type='submit' class='btn btn-block btn-primary btn-sm'><i class='fas fa-eye'></i> Ver más</button>";
                                
                            echo"</td>";
                        echo"</form>";
                        
                        $ruta=$row['nombreOtro'];
                        
                        if($ruta == "Nohayfoto" || $ruta == NULL){
                             echo"
                             <td>
                              <button onclick='showAlert()' type='button'   class='btn btn-block btn-warning btn-sm' disabled>
                                <i class='fas fa-download'></i>
                                No hay documento
                              </button>
                            </td>";
                        }else{
                         
                            //// validamos con el grupo de distribución poder visualizar la columna
                            echo"<td>";
                               
                               /// ahora validamos que solo la de calidad pueda vdescargar el documento
                                   
                                    $nombreProceso = $mysqli->query("SELECT * FROM procesos WHERE id ='$proceso'")or die(mysqli_error());
                                    $col3 = $nombreProceso->fetch_array(MYSQLI_ASSOC);
                                    $permisoDescargarDueno = json_decode($col3['duenoProceso']);
                                    //var_dump($permisoDescargarDueno);
                                    if($permisoDescargarDueno == NULL){
                                        
                                    }else{
                                        
                                        $habilitaPermisoProceso=FALSE;
                                         '<br>'.$cargo;
                                        if(in_array($cargo,$permisoDescargarDueno)){
                                            $habilitaPermisoProceso= TRUE;
                                        }
                                        
                                        if($habilitaPermisoProceso == FALSE){
                                            $habilitarDescargarArchivo = "";
                                        }else{
                                             '<br>'.$habilitarDescargarArchivo = "permiso";
                                        }
                                        
                                    }
                                    
                               /// END
                            
                            if($habilitarDescargarArchivo == 'permiso' || $permisoEditar == 1){ //
                                echo "<button type='button'  class='btn btn-block btn-warning btn-sm' >
                                        <a style='color:black' href='archivos/documentos/".$row['nombreOtro']."' target='_blank' ><i class='fas fa-download'></i> Descargar</a>
                                    </button>";
                                
                            }else{
                                echo "<button onclick='showAlert()' type='button'   class='btn btn-block btn-warning btn-sm' disabled>
                                <i class='fas fa-download'></i>
                                Descargar
                              </button>";
                            }
                            
                            echo "</td>";                        

                         
                        }
                        
                      
                    echo"</tr>";
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

<!-- archivos para el filtro de busqueda y lista de información -->

    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>
    <script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
<!-- END -->
</body>
</html>
<?php
}
?>