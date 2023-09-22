<?php
error_reporting(E_ERROR); 
session_start();
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
//require_once 'inactividad.php';
require_once 'conexion/bd.php';

$celdulaUser = $_SESSION['session_username']; 
$cargoID = $_SESSION['session_cargo']; 
$idUsuario = $_SESSION['session_idUsuario'];

//////////////////////PERMISOS////////////////////////

$formulario = 'creacionDoc'; //aqui se cambia el nombre del formulario

require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Creación documental</title>
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
            <h1>Creación documental</h1>
            <h6>Gestione las solicitudes documentales aprobadas.</h6><br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Creación documental</li>
            </ol>
          </div>
        </div>
        <div>
            <?php 
            //si tiene permiso de insertar , se muestran los botones de agregar, importar y demas
                if($visibleI != TRUE){
            ?>
            <div class="row">
            <!--
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="crearDocumentoSolicitudDocumentos"><font color="white"><i class="fas fa-plus-square"></i> Documento vigente</font></a></button>
            </div>
            -->
            
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
            <div class="col-sm"> <!--  -->
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="crearDocumentoMasivo"><font color="white"><i class="fas fa-plus-square"></i> Documentos vigentes</font></a></button>
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
                <?php
                 if($root == 1){
                ?>
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="controlCambiosParametrizacion"><font color="white"><i class="fas fa-plus-square"></i> Control de Cambios</font></a></button>
                <?php
                 }
                ?>
            </div>
            <div class="col-sm">
                <?php
                 if($root == 1){
                ?>
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="creacionDocumentalAsignacion"><font color="white"><i class="fas fa-clipboard-check"></i> Asignaciones</font></a></button>
                <?php
                 }
                ?>
            </div>
            <div class="col-sm">
            </div>
            <div class="col-sm">
            </div>
            </div>
            <?php }else{?> 
            <div class="row">
                <div class="col-sm">
                </div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
            </div>
            <?php }//si no, solo el de exportar?>
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
                <div class="card-tools">
                    
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 800px;">
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>Versión</th>
                      <th>Código</th>
                      <th>Nombre documento</th>
                      <th>Tipo documento</th>
                      <th>Proceso</th>
                      <th>Estado</th>
                      <th style="display:<?php echo$visibleE;?>;">Seguimiento</th><!--Si tiene permiso de editar se muestra la columna editar -->
                      <th>Plantilla</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                     $data = $mysqli->query("SELECT * FROM solicitudDocumentos WHERE estado = 'Aprobado'")or die(mysqli_error());
                     
                     $listarSolicitud = FALSE; //si no es el encargado de la solicitud continua. 
                     $listarDocumento = FALSE; //si no puede ver el documento por que no es elaborador, revisor o aprobador no lo lista.
                     
                     
                     while($row = $data->fetch_assoc()){
                        
                        /*
                        * Validamos el tipo de soliticitud 
                        * 1 = Documento nuevo
                        * 2 = Actualizar documento
                        * 3 = Eliminar documento
                        */ 
                        
                        if($row['estado'] == "Ejecutado"){//Los documentos ejecutados ya estan en el listado maestro, esta linea hace que no se muestren 
                            continue;
                        }
                        
                        
                        ///Codigo para saltar los documentos que no debe gestionar el usuario segun su cargo y el cargo encargado de la solicitud. 
                        $encargadoSolicitud = $row['encargadoAprobar'];

                        
                        if($row['tipoSolicitud'] == 1){
                            $idSol = $row['id'];
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $queryDoc = $mysqli->query("SELECT * FROM documento WHERE id_solicitud = $idSol")or die(mysqli_error($mysqli));
                            $datosDoc = $queryDoc->fetch_assoc();
                            $tipoDocumento = $datosDoc['tipo_documento'];
                            $proceso = $datosDoc['proceso'];
                            
                            if($datosDoc['estado'] != NULL){
                                if($datosDoc['estado'] == "Pendiente"){
                                
                                    $quienElabora = json_decode($datosDoc['elabora']);
                                    
                                    if($quienElabora[0] == 'usuarios'){
                                        if(in_array($idUsuario,$quienElabora)){
                                            
                                        }else{
                                            continue;
                                        }
                                    }
                                    
                                    if($quienElabora[0] == 'cargos'){
                                        if(in_array($cargo,$quienElabora)){ ///$cargoID
                                            
                                        }else{
                                            continue;
                                        }
                                    }
                                    
                                }
                                
                                if($datosDoc['estado'] == "Elaborado"){
                                    $quienRevisa= json_decode($datosDoc['revisa']);
                                    
                                    if($quienRevisa[0] == 'usuarios'){
                                        if(in_array($idUsuario,$quienRevisa)){
                                           
                                        }else{
                                            continue;
                                        }
                                    }
                                    
                                    if($quienRevisa[0] == 'cargos'){
                                        if(in_array($cargo,$quienRevisa)){ //$cargoID
                                            
                                        }else{
                                            continue;
                                        }
                                    }
                                    
                                }
                                
                                if($datosDoc['estado'] == "Revisado"){
                                    $quienAprueba= json_decode($datosDoc['aprueba']);
                                    
                                    if($quienAprueba[0] == 'usuarios'){
                                        if(in_array($idUsuario,$quienAprueba)){
                                           
                                        }else{
                                            continue;
                                        }
                                    }
                                    
                                    if($quienAprueba[0] == 'cargos'){
                                        if(in_array($cargo,$quienAprueba)){ ///$cargoID
                                            
                                        }else{
                                            continue;
                                        }
                                    }
                                    
                                }
                                
                            }else{
                                if($encargadoSolicitud != $cargo){ ///$cargoID
                                    continue;
                                }
                            }
                            
                        }
                        
                        
                        if($row['tipoSolicitud'] == 2){
                            
                            $idDoc = $row['nombreDocumento'];
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $queryDoc2 = $mysqli->query("SELECT * FROM documento WHERE id = $idDoc")or die(mysqli_error($mysqli));
                            $datosDoc2 = $queryDoc2->fetch_assoc();
                            $tipoDocumento = $datosDoc2['tipo_documento'];
                            $proceso = $datosDoc2['proceso'];
                            
                            
                            if($datosDoc2['estadoActualiza'] != NULL){
                           
                                if($datosDoc2['estadoActualiza'] == "Pendiente"){
                                
                                    $quienElabora = json_decode($datosDoc2['elaboraActualizar']);
                                    
                                    if($quienElabora[0] == 'usuarios'){
                                        if(in_array($idUsuario,$quienElabora)){
                                            
                                        }else{
                                            continue;
                                        }
                                    }
                                    
                                    if($quienElabora[0] == 'cargos'){
                                        if(in_array($cargo,$quienElabora)){ ///$cargoID
                                            
                                        }else{
                                            continue;
                                        }
                                    }
                                    
                                }
                                
                                if($datosDoc2['estadoActualiza'] == "Elaborado"){
                                    $quienRevisa= json_decode($datosDoc2['revisaActualizar']);
                                    
                                    if($quienRevisa[0] == 'usuarios'){
                                        if(in_array($idUsuario,$quienRevisa)){
                                            
                                        }else{
                                            continue;
                                        }
                                    }
                                    
                                    if($quienRevisa[0] == 'cargos'){
                                        if(in_array($cargo,$quienRevisa)){ ///$cargoID
                                            
                                        }else{
                                            continue;
                                        }
                                    }
                                    
                                }
                                
                                if($datosDoc2['estadoActualiza'] == "Revisado"){
                                    $quienAprueba= json_decode($datosDoc2['apruebaActualizar']);
                                    
                                    if($quienAprueba[0] == 'usuarios'){
                                        if(in_array($idUsuario,$quienAprueba)){
                                            
                                        }else{
                                            continue;
                                        }
                                    }
                                    
                                    if($quienAprueba[0] == 'cargos'){
                                        if(in_array($cargo,$quienAprueba)){ //$cargoID
                                            
                                        }else{
                                            continue;
                                        }
                                    }
                                    
                                }
                                
                            }else{
                                if($encargadoSolicitud != $cargo){ ///$cargoID
                                    continue;
                                }
                            }
                            
                        }
                        
                        
                        
                        if($row['tipoSolicitud'] == 3){
                            
                            $idDoc = $row['nombreDocumento'];
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $queryDoc3 = $mysqli->query("SELECT * FROM documento WHERE id = $idDoc")or die(mysqli_error($mysqli));
                            $datosDoc3 = $queryDoc3->fetch_assoc();
                            $tipoDocumento = $datosDoc3['tipo_documento'];
                            $proceso = $datosDoc3['proceso'];
                            
                            if($datosDoc3['estadoElimina'] != NULL){
                            
                                if($datosDoc3['estadoElimina'] == "Pendiente"){
                                
                                    $quienElabora = json_decode($datosDoc3['elaboraElimanar']);
                                    
                                    if($quienElabora[0] == 'usuarios'){
                                        if(in_array($idUsuario,$quienElabora)){
                                            
                                        }else{
                                            continue;
                                        }
                                    }
                                    
                                    if($quienElabora[0] == 'cargos'){
                                        if(in_array($cargo,$quienElabora)){ //$cargoID
                                            
                                        }else{
                                            continue;
                                        }
                                    }
                                    
                                }
                                
                                if($datosDoc3['estadoElimina'] == "Elaborado"){
                                    $quienRevisa= json_decode($datosDoc3['revisaElimanar']);
                                    
                                    if($quienRevisa[0] == 'usuarios'){
                                        if(in_array($idUsuario,$quienRevisa)){
                                            
                                        }else{
                                            continue;
                                        }
                                    }
                                    
                                    if($quienRevisa[0] == 'cargos'){
                                        if(in_array($cargo,$quienRevisa)){ //$cargoID
                                            
                                        }else{
                                            continue;
                                        }
                                    }
                                    
                                }
                                
                                if($datosDoc3['estadoElimina'] == "Revisado"){
                                    $quienAprueba= json_decode($datosDoc3['apruebaElimanar']);
                                    
                                    if($quienAprueba[0] == 'usuarios'){
                                        if(in_array($idUsuario,$quienAprueba)){
                                            
                                        }else{
                                            continue;
                                        }
                                    }
                                    
                                    if($quienAprueba[0] == 'cargos'){
                                        if(in_array($cargo,$quienAprueba)){ //$cargoID
                                            
                                        }else{
                                            continue;
                                        }
                                    }
                                    
                                }
                                
                            }else{
                                if($encargadoSolicitud != $cargo){ ///$cargoID
                                    continue;
                                }
                            }
                            
                        }
                        

                        
                        //Datos segun el tipo de solicitud
                        if($row['tipoSolicitud'] == 1){
                             
                            if($datosDoc['estado'] == "Pendiente" || !$datosDoc['estado']){
                                $codigo = "<strong>Sin definir</strong>";
                                $version = "<strong>Sin definir</strong>";
                                $nombre = $row['nombreDocumento'];
                                $estado = "<font color='red'>Pendiente</font>";
                                
                            }
                            
                            if($datosDoc['estado'] != NULL){
                                $codigo = "<strong>".$datosDoc['codificacion']."</strong>";
                                $version = "<strong>".$datosDoc['version']."</strong>";
                                $nombre = $datosDoc['nombres'];
                                $estado = "<font color='red'>".$datosDoc['estado']."</font>";
                                
                            }
                            
                        }
                        
                        
                        
                        if($row['tipoSolicitud'] == 2){
                            $codigo = "<strong>".$datosDoc2['codificacion']."</strong>";
                            $version = "<strong>".$datosDoc2['version']."</strong>";
                            $nombre = $datosDoc2['nombres'];
                            if($datosDoc2['estadoActualiza'] == NULL){
                                $estado = "<font color='red'>Pendiente</font>";
                            }else{
                                $estado = "<font color='red'>".$datosDoc2['estadoActualiza']."</font>";
                            }
                           
                        }
                        
                        if($row['tipoSolicitud'] == 3){
                            $codigo = "<strong>".$datosDoc3['codificacion']."</strong>";
                            $version = "<strong>".$datosDoc3['version']."</strong>";
                            $nombre = $datosDoc3['nombres'];
                            if($datosDoc3['estadoElimina'] == NULL){
                                $estado = "<font color='red'>Pendiente</font>";    
                            }else{
                                $estado = "<font color='red'>".$datosDoc3['estadoElimina']."</font>";
                            }
                            
                        }
                        
                        //Traigo datos de variables proceso y tipo de documento
                        
                        //PROCESO
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $queryDocumentos = $mysqli->query("SELECT nombre, prefijo, ruta from tipoDocumento WHERE id = '".$tipoDocumento."' ");
                        $datosDocumento = $queryDocumentos->fetch_array(MYSQLI_ASSOC);
                        $tipoDocumento = $datosDocumento['nombre'];
                        $prefijoTipo = $datosDocumento['prefijo']; 
                        $ruta = utf8_decode($datosDocumento['ruta']);
                        
                        //TIPO DE DOCUMENTO
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $queryProcesos = $mysqli->query("SELECT nombre,prefijo from procesos WHERE id = '".$proceso."' ");
                        $datosProceso = $queryProcesos->fetch_array(MYSQLI_ASSOC);
                        $nomProceso = $datosProceso['nombre'];
                        $prefijoProceso = $datosProceso['prefijo']; 
                 
                     echo"<tr>";
                     echo" <td style='text-align: justify;' >".$version."</td>";
                     echo" <td style='text-align: justify;' >".$codigo."</td>";
                     echo" <td style='text-align: justify;' >".$nombre."</td>";
                     echo" <td style='text-align: justify;' >".$tipoDocumento."</td>";
                     echo" <td style='text-align: justify;' >".$nomProceso."</td>";
                     echo" <td style='text-align: justify;' >".$estado."</td>";
                     
                     if($row['tipoSolicitud'] == 1){
                         
                        if($datosDoc['estado'] == NULL){
                            if($row['docVigente'] == 1){
                                echo"<form action='crearDocumentoB' method='POST'>";
                                echo"<td style='display:$visibleE;'>";
                                    echo"<input type='hidden' name='idSolicitud' value='".$row['id']."'>";
                                    echo"<input type='hidden' name='solicitud' value='".$row['nombreDocumento2']."'>";
                                    echo"<button   type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-eye'></i> Seguimiento</button>";
                                echo"</td>"; 
                                echo"</form>";
                            }else{
                                echo"<form action='crearDocumento' method='POST'>";
                                echo"<td style='display:$visibleE;'>";
                                    echo"<input type='hidden' name='idSolicitud' value='".$row['id']."'>";
                                    echo"<input type='hidden' name='solicitud' value='".$row['solicitud']."'>";
                                    echo"<button   type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-eye'></i> Seguimiento</button>";
                                echo"</td>"; 
                                echo"</form>";
                            }
                            
                        }
                        
                        if($datosDoc['estado'] == 'Aprobado'){
                            //echo"<form action='crearDocumento' method='POST'>";
                                echo"<td style='display:$visibleE;'>";
                                echo"<button   disabled class='btn btn-block btn-success btn-sm'><i class='fas fa-eye'></i> Seguimiento</button>";
                                echo"</td>"; 
                          
                        }
                         
                        
                        if($datosDoc['estado'] == 'Pendiente' || $datosDoc['estado'] == 'Elaborado' || $datosDoc['estado'] == 'Revisado'){ //revisaDoc
                            echo"<form action='revisaDocRoles' method='POST'>";
                                echo"<td style='display:$visibleE;'>";
                                    echo"<input type='hidden' name='idDocumento' value='".$datosDoc['id']."'>";
                                    echo"<input type='hidden' name='solicitud' value='".$row['solicitud']."'>";
                                    echo"<button   type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-eye'></i> Seguimiento</button>";
                                echo"</td>"; 
                            echo"</form>";
                        }
                     }
                     
                     if($row['tipoSolicitud'] == 2){ //actualizarDoc
                        echo"<form action='actualizarDocRoles' method='POST'>";
                            echo"<td style='display:$visibleE;'>";
                                echo"<input type='hidden' name='idSolicitud' value='".$row['id']."'>";
                                echo"<input type='hidden' name='idDoc' value='".$row['nombreDocumento']."'>";
                                echo"<input type='hidden' name='solicitud' value='".$row['solicitud']."'>";
                                echo"<button  type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-eye'></i> Seguimiento</button>";
                            echo"</td>"; 
                        echo"</form>";
                     }
                     
                     if($row['tipoSolicitud'] == 3){ //eliminarDoc
                        echo"<form action='eliminarDocRoles' method='POST'>";
                            echo"<td style='display:$visibleE;'>";
                                echo"<input type='hidden' name='idSolicitud' value='".$row['id']."'>";
                                echo"<input type='hidden' name='idDocumento' value='".$datosDoc3['id']."'>";
                                echo"<input type='hidden' name='solicitud' value='".$row['solicitud']."'>";
                                echo"<button type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-eye'></i> Seguimiento</button>";
                            echo"</td>"; 
                        echo"</form>";
                     }
                     
                     $ruta = $row['documento']; 
                     
                     if($ruta == "Nohayfoto" || $ruta == NULL || $ruta == 'sin datos'){
                         echo"
                         <td>
                          <button onclick='showAlert()' type='button'  class='btn btn-block btn-warning btn-sm'>
                            <i class='fas fa-download'></i>
                            Descargar
                          </button>
                        </td>";
                     }else{
                         echo"
                         <td>
                            <button type='button'  class='btn btn-block btn-warning btn-sm'>
                                <i class='fas fa-download'></i>
                                <a style='color:black' href='$ruta' download='' target='_blank'> Descargar</a>
                            </button>
                        </td>";
                         
                         
                     }
                     
                      
                     //echo"<td><button type='button' class='btn btn-block btn-warning btn-sm'><i class='fas fa-download'></i> Descargar</button></td>";
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
<!-- archivos para el filtro de busqueda y lista de informaci��n -->

    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>
<!-- END -->
 <script>
  function showAlert() {
       const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
        Toast.fire({
                type: 'warning',
                title: ' El documento no tiene plantilla.'
            })
    //var myText = "El documento no tiene plantilla.";
    //alert (myText);
  }
  </script>
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<?php
/// validaciones de alertas
$validacionExiste=$_POST['validacionExiste'];
$validacionAgregar=$_POST['validacionAgregar'];
$validacionAgregarB=$_POST['validacionAgregarB'];
$validacionAgregarC=$_POST['validacionAgregarC'];
$validacionAgregarD=$_POST['validacionAgregarD'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];
$validacionAgregarCargado=$_POST['validacionAgregarCargado'];
$validacionUsuario=$_POST['validacionUsuario'];
$validacionUsuario2=$_POST['validacionUsuario2'];
$validacionCerrado=$_POST['validacionCerrado'];
$validacionRegreso=$_POST['validacionRegreso'];
?>
<script type="text/javascript">
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 9000
    });
    
    
    <?php 
    if($validacionRegreso == 1){
       ?>
        Toast.fire({
            type: 'success',
            title: ' Documento listo para asignar.'
        })
    <?php  
    }
    
     if($validacionCerrado == 1){
       ?>
        Toast.fire({
            type: 'error',
            title: ' Documento rechazado.'
        })
    <?php  
    }
    
    if($validacionUsuario == 1){
        
        $documentoAsignado=$_POST['documentoAsignado'];
        $consultando_documento=$mysqli->query("SELECT * FROM documento WHERE id='".$_POST['documentoAsignado']."' ");
        $extraer_documento=$consultando_documento->fetch_array(MYSQLI_ASSOC);
        $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraer_documento['asumeFlujo']."' ");
        $extraer_usuario=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
        $usuarioGestionando=$extraer_usuario['nombres'].' '.$extraer_usuario['apellidos'];
      ?>
        Toast.fire({
            type: 'warning',
            title: " El usuario <?php echo $usuarioGestionando;?> ya se encargo de la solicitud."
        })
    <?php  
    }
    
    if($validacionUsuario2 == 1){
        
        $documentoAsignado=$_POST['documentoAsignado'];
        $consultando_documento=$mysqli->query("SELECT * FROM documento WHERE id='".$_POST['documentoAsignado']."' ");
        $extraer_documento=$consultando_documento->fetch_array(MYSQLI_ASSOC);
        $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraer_documento['asumeFlujo']."' ");
        $extraer_usuario=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
        $usuarioGestionando=$extraer_usuario['nombres'].' '.$extraer_usuario['apellidos'];
      ?>
        Toast.fire({
            type: 'warning',
            title: " Elija su rol en la gestión."
        })
    <?php  
    }
    
    if($_POST['alertaSinMensaje'] != NULL){
        
      ?>
        Toast.fire({
            type: 'warning',
            title: " No ha sido asignado para gestionar este documento."
        })
    <?php  
    }
    
    
    if($validacionExisteB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El nivel o la prioridad ya existe.'
        })
    <?php
    }
    
    
    if($validacionAgregarB == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: ' Documento listo para revisión.'
        })
    <?php
    }
    if($validacionAgregarCargado == 1){ 
    ?>
        Toast.fire({
            type: 'success',
            title: ' Documento cargado.'
        })
    <?php
    }
    if($validacionAgregarC == 1){ 
    ?>
        Toast.fire({
            type: 'success',
            title: ' Documento listo para aprobación.'
        })
    <?php
    }
    if($validacionAgregarD == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: ' Documento aprobado.'
        })
    <?php
    }
    
    if($validacionAgregar == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: 'Documento listo para elaboracion.'
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
            title: 'Documento rechazado.'
        })
    
    <?php
    }
    if($_POST['listadoMaestro'] == 1){
    ?>
        Toast.fire({
            type: 'error',
            title: 'El documento ya fue gestionado.'
        })
    
    <?php
    }
    
    if($_POST['validacionUsuarioNoExiste'] == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: 'El documento que intenta gestionar no existe.'
        })
    
    <?php
    }
    
    
    ?>
    
  });

</script>
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
</body>
</html>
<?php
}
?>