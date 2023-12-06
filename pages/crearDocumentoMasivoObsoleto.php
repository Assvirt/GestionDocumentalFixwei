<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
require_once 'conexion/bd.php';

$idSolicitud = $_POST['idSolicitud'];
$rol = $_POST['rol'];

$formulario = 'documentosObs'; //aqui se cambia el nombre del formulario
//require_once 'permisosPlataforma.php';
$documento = $_SESSION["session_username"];
$queryGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario = '$documento'");

while($row = $queryGrupos->fetch_assoc()){
    $idGrupo = $row['idGrupo'];
    
    $queryPermisos = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupo' AND formulario = '$formulario'");
    $permisos = $queryPermisos->fetch_array(MYSQLI_ASSOC);
    if($permisos['listar'] == TRUE){
        $permisoListar = $permisos['listar'];    
    }
    if($permisos['crear'] == TRUE){
        $permisoInsertar = $permisos['crear'];    
    }
    if($permisos['editar'] == TRUE){
        $permisoEditar = $permisos['editar'];    
    }
    if($permisos['eliminar'] == TRUE){
       $permisoEliminar = $permisos['eliminar'];    
    }
    
}

$root = $_SESSION['session_root'];

if($root == 1){
    $permisoListar = TRUE;
    $permisoInsertar = TRUE;
    $permisoEditar = TRUE;
    $permisoEliminar = TRUE;
}

if($permisoListar == FALSE){
    echo '<script language="javascript">window.location.href="accesoDenegado"</script>';
}

if($permisoInsertar == FALSE){
    $visibleI = 'none';
}else{
    $visibleI = '';
}

if($permisoEditar == FALSE){
    $visibleE = 'none';
}else{
    $visibleE = '';
}

if($permisoEliminar == FALSE){
    $visibleD = 'none';
}else{
    $visibleD = '';
}
//////////////////////PERMISOS////////////////////////





?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Crear documento obsoleto</title>
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
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!--CKeditor-->
  <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
</head>
<script>
   	
    function nobackbutton(){
    	
       window.location.hash="no-back-button";
    	
       window.location.hash="Again-No-back-button" //chrome
    	
       window.onhashchange=function(){window.location.hash="no-back-button";}
    	
    }
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
            <h1>Crear Documento Obsoleto</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Crear documento obsoleto</li>
            </ol>
          </div>
        </div>
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                <div class="row">
                    <div class="col-sm">
                       <!-- <button type="button" class="btn btn-block btn-success btn-sm"><a href="creacionDocumental"><font color="white"><i class="fas fa-chevron-left"></i> Regresar</font></a></button>
                    -->
                    <?php
                    if(isset($_POST['editarDocumentoMasivo'])){
                    ?>
                    <button type="button" class="btn btn-block btn-info btn-sm"><a href="crearDocumentoMasivoObsoleto"><font color="white"><i class="fas fa-list"></i> Listar </font></a></button>
                    <?php
                    }else{
                    ?>
                     <button type="button" class="btn btn-block btn-info btn-sm"><a href="documentosObsoletos"><font color="white"><i class="fas fa-list"></i> Listar </font></a></button>
                    <?php
                    }
                    ?>
                    </div>
                    <div class="col-sm">
                    </div>
                    <div class="col-sm">
                    </div>
                    <div class="col-sm">
                    </div>
                    <div class="col-sm">
                    </div>
                </div>
            </div>
            <div class="col">
            </div>   
        </div>
        
        
      </div><!-- /.container-fluid -->
    </section>
<?php
if(isset($_POST['editarDocumentoMasivo'])){ }else{
?>
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                
            <div class="card card-primary">
            
              
             
                    <div class="card-body">
                        
                        <div class="card-body table-responsive p-0">    
                        <table class="table table-head-fixed text-center" id="example">
                            <thead>
                                <tr>
                                    <th>Versión</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Tipo de documento</th>
                                    <th>Proceso</th>
                                    <th style="display:<?php echo $visibleE;?>;" >Editar</th>
                                    <th>Vista previa</th>
                                    <th>Descargar editable</th>
                                    <th style="display:<?php echo $visibleE;?>;" >Ejecutar</th>
                                    <th style="display:<?php echo $visibleE;?>;" >Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $consultandoDocumentosMasivos=$mysqli->query("SELECT * FROM documento WHERE pre='si' AND obsoleto='1' AND vigente='0' ORDER BY id");
                                $conteo='1';
                                $verificarCantidades=1;
                                while($recorridoDocumentos=$consultandoDocumentosMasivos->fetch_array()){
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $recorridoDocumentos['versionTemporal'];?>
                                    </td>
                                    <td> <?php $conteo++; ?>
                                        <?php 
                                        //// armamos la codificación temporal
                                        
                                        /// consultamos el tipo de documento para traer el prefijo
                                        $consultaTipoDocumento=$mysqli->query("SELECT prefijo,id FROM tipoDocumento WHERE id='".$recorridoDocumentos['tipo_documento']."' ");
                                        $extraerNombreTipoDocumentoConsulDocum=$consultaTipoDocumento->fetch_array(MYSQLI_ASSOC);
                                        $prefijoTipo=$extraerNombreTipoDocumentoConsulDocum['prefijo'];
                                        //// consultamos el prefijo del proceso para traerlo
                                        $consultaProceso=$mysqli->query("SELECT id,prefijo FROM procesos WHERE id='".$recorridoDocumentos['proceso']."' ");
                                        $extraerNombreProcesoConsulDocum=$consultaProceso->fetch_array(MYSQLI_ASSOC);
                                        $prefijoProceso=$extraerNombreProcesoConsulDocum['prefijo'];
                                        
                                        /// traemos el consecutivo y version temporal para mostrar antes de ser verificado nuevamente
                                        $consecutivo=$recorridoDocumentos['consecutivoTemporal'];
                                        $version=$recorridoDocumentos['versionTemporal'];
                                        
                                        //echo $recorridoDocumentos['codificacion'];
                                        
                                        //CODIFICACION
                                            $codificacion = "";
                                            $dataCodificacion = $mysqli->query("SELECT * FROM codificacion ORDER BY id")or die(mysqli_error());
                                            while($rowC = $dataCodificacion->fetch_assoc()){
                                                                   
                                                $cod = $rowC['codificacion'];
                                                                        
                                                if($cod == "-"){
                                                    $codificacion =  $codificacion."-";
                                                }
                                                                    
                                                if($cod == "/"){
                                                    $codificacion =  $codificacion."/";
                                                }
                                                                        
                                                if($cod == " "){
                                                    $codificacion =  $codificacion." ";
                                                }
                                                                        
                                                if($cod == "Proceso"){
                                                    $codificacion =  $codificacion.$prefijoProceso;
                                                }
                                                                    
                                                if($cod == "Tipo de documento"){
                                                    $codificacion = $codificacion.$prefijoTipo;        
                                                }
                                                                        
                                                if($cod == "Consecutivo"){
                                                    $codificacion = $codificacion.$consecutivo;        
                                                }
                                                                        
                                                if($cod == "Versión"){
                                                    $codificacion = $codificacion.$version;        
                                                }
                                            }//Fin codificacion 
                                            
                                            /// traemos la simulación del consecutivo, que no ha sido tomado aún
                                            echo $codificacion;
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $recorridoDocumentos['nombres'];?>
                                    </td>
                                    <td>
                                        <?php
                                        $consultaTipoDocumento=$mysqli->query("SELECT * FROM tipoDocumento WHERE id='".$recorridoDocumentos['tipo_documento']."' ");
                                        $extraerNombreTipoDocumentoConsulDocum=$consultaTipoDocumento->fetch_array(MYSQLI_ASSOC);
                                        echo $extraerNombreTipoDocumentoConsulDocum['nombre'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $consultaProceso=$mysqli->query("SELECT * FROM procesos WHERE id='".$recorridoDocumentos['proceso']."' ");
                                        $extraerNombreProcesoConsulDocum=$consultaProceso->fetch_array(MYSQLI_ASSOC);
                                        echo $extraerNombreProcesoConsulDocum['nombre'];
                                        ?>
                                    </td>
                                    <td style="display:<?php echo $visibleE;?>;">
                                        <form action="" method="POST">
                                        <input name="enviarIdDocumento" value="<?php echo $recorridoDocumentos['id'];?>" type="hidden">
                                        <input name="enviarIdDocumentoControl" value="<?php echo $recorridoDocumentos['id_solicitud'];?>" type="hidden">
                                        <button type='submit' name="editarDocumentoMasivo" class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action='verDocumentoMasivo' method='POST'>
                                            <input type='hidden' name='idDocumento' value='<?php echo $recorridoDocumentos['id']; ?>' >
                                            <input type='hidden' name='idSolicitud' value='<?php echo $recorridoDocumentos['id_solicitud']; ?>' >
                                            <input name="obsoletooss" type="hidden" value="1">
                                            <button  type='submit' class='btn btn-block btn-warning btn-sm'><i class='fas fa-edit'></i> Vista previa</button>
                                        </form>
                                    </td>
                                    <td>
                                    <?php
                                    // validamos la existencia del documento    
                                        
                                    $preguntadoValidacion=$mysqli->query("SELECT * FROM documento WHERE  id='".$recorridoDocumentos['id']."' ");
                                    $extraerPreguntaValidacion=$preguntadoValidacion->fetch_array(MYSQLI_ASSOC);
                                         ' - '.$documentoExtraidoPdf=($extraerPreguntaValidacion['nombrePDF']);
                                         '<br> - '.$documentoExtraidoOtro=($extraerPreguntaValidacion['nombreOtro']);
                                                		    
                                      '<br>';
                                      '<br>';
        		                    $carpeta="archivos/documentos/";
                                    $ruta="/".$carpeta."/";
                                    $directorio=opendir($carpeta);
                                    //recoger los  datos
                                    $datos=array();
                                    $conteoArchivosB=0;
                                    $conteoArchivosB2=0;
                                    while ($archivo = readdir($directorio)) { 
                                      if(($archivo != '.')&&($archivo != '..')){
                                                             
                                        
                                        if($documentoExtraidoPdf == $datos[]=$archivo){
                                            $conteoArchivosB++;
                                             $datos[]=$archivo;  '<br>';
                                        }
                                        if($documentoExtraidoOtro == $datos[]=$archivo){
                                            $conteoArchivosB2++;
                                             $datos[]=$archivo;  '<br>';
                                        }
                                                             
                                                             
                                      } 
                                    }
                                    closedir($directorio);
                                                            
                                    if($conteoArchivosB2 > 0){
                                       $documentoHabilitado2='1'; 
                                    }else{
                                       $documentoHabilitado2='no coincide';
                                    }
                                     '<br>B: '.$documentoHabilitado2;
                                    ///// END
                                                        
                                                        
                                                        
                                                        
                                                        
                                    if($documentoHabilitado2 == 1){
                                        if($recorridoDocumentos['nombreOtro'] != NULL){
                                            $activarDisabledOtro='';
                                        ?>
                                         <button type='button'  class='btn btn-block btn-warning btn-sm' >
                                            <a style='color:black' href='archivos/documentos/<?php echo $recorridoDocumentos['nombreOtro']; ?>' target='_blank' ><i class='fas fa-download'></i> Descargar</a>
                                        </button>
                                        <?php
                                        }else{
                                            $activarDisabledOtro='disabled';
                                        ?>
                                        <button  disabled class='btn btn-block btn-warning btn-sm' >
                                            <a style='color:black' ><i class='fas fa-download'></i> Descargar</a>
                                        </button>
                                        <?php
                                        }
                                    }else{
                                        $verificarCantidades++; // se realiza un conteo de los archivos existente después de la validación de archivos malos
                                    ?>
                                    
                                    <a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:black;' data-toggle='modal' data-target='#modal-danger-alerta-BloqueoRecorrido' class='btn btn-block btn-warning btn-sm'><i class='fas fa-download'></i> Descargar</a>
                                   
                                    <?php
                                    }
                                    ?>
                                       
                                    </td>
                                    <td style="display:<?php echo $visibleE;?>;" >
                                        <?php
                                        if($conteoArchivosB > 0 && $conteoArchivosB2 >  0){
                                            // se analiza que la codificación todas estén libres para ejecutar todos, en caso de no ser así debe bloquearlos
                                            
                                            $Sub_consultamosExistenciaDocumento=$mysqli->query("SELECT * FROM documento WHERE proceso='".$recorridoDocumentos['proceso']."' AND tipo_documento='".$recorridoDocumentos['tipo_documento']."' AND version='".$recorridoDocumentos['versionTemporal']."' AND consecutivo='".$recorridoDocumentos['consecutivoTemporal']."' AND obsoleto='1' AND pre IS NULL ORDER BY id DESC "); //AND  vigente='1' id='$idDocumento' AND aprobado_aprueba='1'
                                            $Sub_extraemosExistenciaDocumento=$Sub_consultamosExistenciaDocumento->fetch_array(MYSQLI_ASSOC);
                                            
                                            $Sub_consultamosExistenciaDocumentoVigente=$mysqli->query("SELECT * FROM documento WHERE proceso='".$recorridoDocumentos['proceso']."' AND tipo_documento='".$recorridoDocumentos['tipo_documento']."' AND version='".$recorridoDocumentos['versionTemporal']."' AND consecutivo='".$recorridoDocumentos['consecutivoTemporal']."' AND vigente='1' AND pre IS NULL ORDER BY id DESC "); //AND  vigente='1' id='$idDocumento' AND aprobado_aprueba='1'
                                            $Sub_extraemosExistenciaDocumentoVigente=$Sub_consultamosExistenciaDocumentoVigente->fetch_array(MYSQLI_ASSOC);
                                            
                                            if($Sub_extraemosExistenciaDocumento['id'] != NULL){ 
                                                $contadorObsoletoVal=1;
                                                //echo '<br><font color="red">Botón bloqueado, obsoletos</font>';
                                            }else{
                                                $contadorObsoletoVal=0;
                                            }
                                            if($Sub_extraemosExistenciaDocumentoVigente['id'] != NULL){ 
                                                $contadorVigenteVal=1;
                                                //echo '<br><font color="red">Botón bloqueado, vigente</font>';
                                            }else{
                                                $contadorVigenteVal=0;
                                            }
                                            
                                            if($contadorVigenteVal == 1 || $contadorObsoletoVal == 1){
                                            ?>
                                            <button disabled class='btn btn-block btn-info btn-sm' >
                                                <i class='fas fa-check'></i> Ejecutar
                                            </button>
                                            <?php
                                            }else{
                                            ?>
                                            <form action="controlador/solicitudDocumentos/pruebaAlmacenamientoObsoleto" onsubmit="sendFormConsecutivo(); event.preventDefault(); " method="POST">
                                                <input name="idDocumento" value="<?php echo $recorridoDocumentos['id']; ?>" type="hidden">
                                                <input name="idSolicitudDocumento" value="<?php echo $recorridoDocumentos['id_solicitud']; ?>" type="hidden">
                                                <button type='submit' name="ejecutadorIndividual" class='btn btn-block btn-info btn-sm' >
                                                    <i class='fas fa-check'></i> Ejecutar
                                                </button>
                                            </form>
                                            <?php    
                                            }
                                        }else{
                                            if($conteoArchivosB == 0){
                                            echo '<font color=""><i>- Falta documento pdf</i></font>';
                                            }
                                            if($conteoArchivosB2 == 0 ){
                                                echo '<br><font color=""><i>- Falta documento editable</i></font>';
                                            }
                                            
                                            if($conteoArchivosB <> 0 && $conteoArchivosB2 <> 0){
                                        ?>
                                            <button disabled class='btn btn-block btn-info btn-sm' >
                                                <i class='fas fa-check'></i> Ejecutar
                                            </button>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td style="display:<?php echo $visibleE;?>;" >
                                    <?php
                                    if($conteoArchivosB > 0 && $conteoArchivosB2 >  0){
                                    ?>
                                   
                                        <button type="button" class='btn btn-block btn-danger btn-sm' data-toggle="modal"   data-target="#exampleModalCenter<?php echo $recorridoDocumentos['id'].''.$contador_modal++;?>">
                                            <i class='fas fa-trash-alt'></i> Eliminar 
                                        </button>
                                                                          
                                        <div class="modal fade" id="exampleModalCenter<?php echo $recorridoDocumentos['id'].''.$contador_modal_b++;?>" tabindex="-1" role="dialog"
                                                                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                                            <div class="modal-dialog" role="document">
                                                                              <div class="modal-content bg-danger" >
                                                                                <div class="modal-header"> 
                                                                                  <h4 class="modal-title">Alerta</h4>
                                                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                  </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <p>¿Est&aacute; seguro que desea cancelar el documento?</p>
                                                                                    
                                                                                </div>
                                                                                <!--
                                                                                 <form action="controlador/solicitudDocumentos/pruebaAlmacenamientoObsoleto" method="POST">
                                                                                    
                                                                                    <input name="idDocumento" value="<?php ///echo $recorridoDocumentos['id']; ?>" type="hidden">
                                                                                    <input name="idSolicitudDocumento" value="<?php ///echo $recorridoDocumentos['id_solicitud']; ?>" type="hidden">
                                                                                    
                                                                                    
                                                                                      <button type="submit" name="cancelar" class="btn btn-outline-light">Si</button>
                                                                                      <button type="button" class="btn btn-outline-light" onclick="window.location.href='crearDocumentoMasivoObsoleto'" >No</button> <!-- data-dismiss="modal" -->
                                                                                    
                                                                                
                                                                                <!--</form>
                                                                                -->
                                                                                    <div class="modal-footer justify-content-between">
                                                                                      <form action="controlador/solicitudDocumentos/pruebaAlmacenamientoObsoleto" method="POST">
                                                                                      <input name="idDocumento" value="<?php echo $recorridoDocumentos['id']; ?>" type="hidden">
                                                                                      <input name="idSolicitudDocumento" value="<?php echo $recorridoDocumentos['id_solicitud']; ?>" type="hidden">
                                                                                      <button type="submit" name="cancelar" class="btn btn-outline-light">Si</button>
                                                                                      </form>
                                                                                      <form action="" method="POST">
                                                                                      <input name="idDocumento" value="<?php echo $recorridoDocumentos['id']; ?>" type="hidden">   
                                                                                      <input name="cerrandoNo" type="hidden" value="1">
                                                                                      <button type="submit" class="btn btn-outline-light" >No</button> <!-- data-dismiss="modal" -->
                                                                                      </form>
                                                                                    </div> 
                                                                              </div>
                                                                            </div>
                                                                          </div>
                            
                                    <?php
                                    }else{
                                    ?>
                                        <button disabled  class="btn btn-block btn-danger btn-sm" >
                                            <i class="fas fa-trash-alt"></i> Eliminar 
                                        </button>
                                       
                                    <?php
                                    }
                                    ?>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        
                        
                    
                        <div class="modal fade" id="modal-danger-alerta-BloqueoRecorrido">
                            <div class="modal-dialog">
                              <div class="modal-content bg-danger">
                                <div class="modal-header">
                                  <h4 class="modal-title">Alerta</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>No existe el documento.</p>
                                </div>
                                 <!-- END formulario para eliminar por el id -->
                              </div>
                            </div>
                        </div>



                        
                        
                        </div>
                        <?php //echo $conteo;
                        if($conteo > 1){ /// se verifica que al menos exista 1 registro para mostrar el botón
                            /*
                            if($verificarCantidades > 1){ /// si no hay archivos, bloquemaos el botón
                        ?>
                        <div class="card-body" style="display:<?php echo $visibleE;?>;">
                            
                            <button disabled class='btn btn-info float-left'><i class="fas fa-tasks"></i> Ejecutar todo</button>
                            
                        </div>
                        <?php
                            }else{
                                
                                // se analiza que la codificación todas estén libres para ejecutar todos, en caso de no ser así debe bloquearlos
                                $consultamosExistenciaDocumento=$mysqli->query("SELECT * FROM documento  ORDER BY id DESC "); //AND  vigente='1' id='$idDocumento' AND aprobado_aprueba='1'
                                $contadorVigente=0;
                                $contadorObsoleto=0;
                                while($extraemosExistenciaDocumento=$consultamosExistenciaDocumento->fetch_array()){
                                
                                    $Sub_consultamosExistenciaDocumento=$mysqli->query("SELECT * FROM documento WHERE pre='si' ORDER BY id DESC "); //AND  vigente='1' id='$idDocumento' AND aprobado_aprueba='1'
                                    $Sub_extraemosExistenciaDocumento=$Sub_consultamosExistenciaDocumento->fetch_array(MYSQLI_ASSOC);
                                    
                                        if($extraemosExistenciaDocumento['proceso'] == $Sub_extraemosExistenciaDocumento['proceso']  && $extraemosExistenciaDocumento['tipo_documento'] == $Sub_extraemosExistenciaDocumento['tipo_documento'] && $extraemosExistenciaDocumento['consecutivo'] == $Sub_extraemosExistenciaDocumento['consecutivoTemporal'] && $extraemosExistenciaDocumento['version'] == $Sub_extraemosExistenciaDocumento['versionTemporal'] && $extraemosExistenciaDocumento['vigente'] == 1){
                                            'conteo vigente: '.$contadorVigente++;
                                        }
                                        
                                        if($extraemosExistenciaDocumento['proceso'] == $Sub_extraemosExistenciaDocumento['proceso']  && $extraemosExistenciaDocumento['tipo_documento'] == $Sub_extraemosExistenciaDocumento['tipo_documento'] && $extraemosExistenciaDocumento['consecutivo'] == $Sub_extraemosExistenciaDocumento['consecutivoTemporal'] && $extraemosExistenciaDocumento['version'] == $Sub_extraemosExistenciaDocumento['versionTemporal'] && $extraemosExistenciaDocumento['obsoleto'] == 1){
                                            'conteo obsole: '.$contadorObsoleto++;
                                        }
                                    
                                    
                                }
                                
                             
                                
                                if($contadorVigente > 0 || $contadorObsoleto > 0){ /// si existe un documento en vigente o obsoleto
                                    
                                    if($contadorVigente > 0){
                                        //echo '<br><font color="red">Botón bloqueado, existen documentos en el listado maestro</font>';
                                    }
                                    if($contadorObsoleto > 0){
                                        //echo '<br><font color="red">Botón bloqueado, existen documentos en obsoletos</font>';
                                    }
                                ?>
                                    <div class="card-body" style="display:<?php echo $visibleE;?>;">
                                        <button disabled class='btn btn-info float-left'><i class="fas fa-tasks"></i> Ejecutar todo</button>
                                    </div>
                                <?php
                                }else{
                                ?>
                                    <div class="card-body" style="display:<?php echo $visibleE;?>;">
                                        <form action="controlador/solicitudDocumentos/pruebaAlmacenamientoObsoleto" method="POST">
                                        <button type='submit' name="ejecutador" class='btn btn-info float-left'><i class="fas fa-tasks"></i> Ejecutar todo</button>
                                        </form>
                                    </div>    
                                <?php
                                }
                            }
                            */
                        }
                            $solicitud = $_POST['solicitud']; 
                        ?>
                        <p>
                            <?php 
                                echo $solicitud;
                            
                            $buscandoNombre=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                            $traerNombreSolicitud=$buscandoNombre->fetch_array(MYSQLI_ASSOC);
                            
                            ?>
                        </p>
                        
                            <br><br>
                        
                    </div>
            </div>
            </div>    
            <?php
            if($_POST['alertaConsecutivo'] != NULL){
?>
                        <script>
                            $(document).ready(function() {
                              // indicamos que se ejecuta la funcion a los 5 segundos de haberse
                              // cargado la pagina
                              setTimeout(clickbutton, 0000);
                            
                              function clickbutton() {
                                // simulamos el click del mouse en el boton del formulario
                                $("#action-button-bloqueado").click();
                                //alert("Aqui llega"); //Debugger
                              }
                              $('#action-button-bloqueado').on('click',function() {
                               // console.log('action');
                              });
                            });
                        </script> 
                       <button id="action-button-bloqueado" style="display:none;" data-toggle="modal" data-target='#modal-danger-alerta-Bloqueo'></button>
                    
                        <div class="modal fade" id="modal-danger-alerta-Bloqueo">
                            <div class="modal-dialog">
                              <div class="modal-content bg-danger">
                                <div class="modal-header">
                                  <h4 class="modal-title">Consecutivo no valido</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    <p>La siguiente codificación ya existe.</p>
                                    <?php
                                    $consulta_documento=$mysqli->query("SELECT * FROM documento WHERE obsoleto='1' AND pre='si' ");
                                    while($extraer_consulta_documento=$consulta_documento->fetch_array()){
                                    
                                    /// consultamos el tipo de documento para traer el prefijo
                                        $consultaTipoDocumento=$mysqli->query("SELECT prefijo,id FROM tipoDocumento WHERE id='".$extraer_consulta_documento['tipo_documento']."' ");
                                        $extraerNombreTipoDocumentoConsulDocum=$consultaTipoDocumento->fetch_array(MYSQLI_ASSOC);
                                        $prefijoTipo=$extraerNombreTipoDocumentoConsulDocum['prefijo'];
                                        //// consultamos el prefijo del proceso para traerlo
                                        $consultaProceso=$mysqli->query("SELECT id,prefijo FROM procesos WHERE id='".$extraer_consulta_documento['proceso']."' ");
                                        $extraerNombreProcesoConsulDocum=$consultaProceso->fetch_array(MYSQLI_ASSOC);
                                        $prefijoProceso=$extraerNombreProcesoConsulDocum['prefijo'];
                                        
                                        /// traemos el consecutivo y version temporal para mostrar antes de ser verificado nuevamente
                                        $consecutivo=$extraer_consulta_documento['consecutivoTemporal'];
                                        $version=$extraer_consulta_documento['versionTemporal'];
                                        
                                        //echo $recorridoDocumentos['codificacion'];
                                        
                                        //CODIFICACION
                                            $codificacion = "";
                                            $dataCodificacion = $mysqli->query("SELECT * FROM codificacion ORDER BY id")or die(mysqli_error());
                                            while($rowC = $dataCodificacion->fetch_assoc()){
                                                                   
                                                $cod = $rowC['codificacion'];
                                                                        
                                                if($cod == "-"){
                                                    $codificacion =  $codificacion."-";
                                                }
                                                                    
                                                if($cod == "/"){
                                                    $codificacion =  $codificacion."/";
                                                }
                                                                        
                                                if($cod == " "){
                                                    $codificacion =  $codificacion." ";
                                                }
                                                                        
                                                if($cod == "Proceso"){
                                                    $codificacion =  $codificacion.$prefijoProceso;
                                                }
                                                                    
                                                if($cod == "Tipo de documento"){
                                                    $codificacion = $codificacion.$prefijoTipo;        
                                                }
                                                                        
                                                if($cod == "Consecutivo"){
                                                    $codificacion = $codificacion.$consecutivo;        
                                                }
                                                                        
                                                if($cod == "Versión"){
                                                    $codificacion = $codificacion.$version;        
                                                }
                                            }//Fin codificacion 
                                            echo '- '.$codificacion.'<br>';
                                            /// traemos la simulación del consecutivo, que no ha sido tomado aún
                                    }    
                                    ?>
                                  
                                </div>
                                 <!-- END formulario para eliminar por el id -->
                              </div>
                            </div>
                        </div>

<?php    
            }
            ?>
            <div class="col">
            </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
<?php
}
if( $conteo >= 21){ 
?>
                                <center>
                                        
                                        <div class="modal-dialog">
                                          <div class="modal-content bg-danger">
                                            <div class="modal-header">
                                              <h4 class="modal-title">Alerta</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              <p>Ha llegado a su límite de registro.</p>
                                            </div>
                                           <div class="modal-footer justify-content-between">
                                           </div>
                                          </div>
                                        </div>
                                </center>
<?php
 }else{ 

    if(isset($_POST['editarDocumentoMasivo'])){ 
        //// traemos los datos de la primera faso lo que incluye 2 tablas
        /// se trae la tabla de solicitud de documentos y la tabla de documentos 
        'ID documento: '.$_POST['enviarIdDocumento'];
        $consultandoDatosDocumento=$mysqli->query("SELECT * FROM documento WHERE id='".$_POST['enviarIdDocumento']."' ");
        $extraerConsultaDatosDocumento=$consultandoDatosDocumento->fetch_array(MYSQLI_ASSOC);
        
        
        if($extraerConsultaDatosDocumento['obsoleto'] == '1' && $extraerConsultaDatosDocumento['pre'] == NULL){
        ?>
                        <script> 
                             window.onload=function(){
                               document.forms["miformularioAlerta"].submit();
                             }
                        </script>
                                                             
                        <form name="miformularioAlerta" action="crearDocumentoMasivoObsoleto" method="POST" onsubmit="procesar(this.action);" >
                            <input name="alertaConsecutivoGestionado" value="1" type="hidden">
                        </form> 
                    <?php 
        }
        
        
        
if($_POST['alertaDocumento'] != NULL){    
?><!--  return checkSubmit();-->
                        <script>
                            $(document).ready(function() {
                              // indicamos que se ejecuta la funcion a los 5 segundos de haberse
                              // cargado la pagina
                              setTimeout(clickbutton, 0000);
                            
                              function clickbutton() {
                                // simulamos el click del mouse en el boton del formulario
                                $("#action-button-bloqueado").click();
                                //alert("Aqui llega"); //Debugger
                              }
                              $('#action-button-bloqueado').on('click',function() {
                               // console.log('action');
                              });
                            });
                        </script> 
                       <button id="action-button-bloqueado" style="display:none;" data-toggle="modal" data-target='#modal-danger-alerta-Bloqueo'></button>
                    
                        <div class="modal fade" id="modal-danger-alerta-Bloqueo">
                            <div class="modal-dialog">
                              <div class="modal-content bg-danger">
                                <div class="modal-header">
                                  <h4 class="modal-title">Alerta</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>El nombre del archivo contiene caracteres inválidos, por favor digite el nombre completo del archivo e intente cargar.</p>
                                </div>
                                 <!-- END formulario para eliminar por el id -->
                              </div>
                            </div>
                        </div>

<?php
}




// alerta del consecutivo
if($_POST['alertaConsecutivo'] != NULL){
?><!--  return checkSubmit();-->
                        <script>
                            $(document).ready(function() {
                              // indicamos que se ejecuta la funcion a los 5 segundos de haberse
                              // cargado la pagina
                              setTimeout(clickbutton, 0000);
                            
                              function clickbutton() {
                                // simulamos el click del mouse en el boton del formulario
                                $("#action-button-bloqueado").click();
                                //alert("Aqui llega"); //Debugger
                              }
                              $('#action-button-bloqueado').on('click',function() {
                               // console.log('action');
                              });
                            });
                        </script> 
                       <button id="action-button-bloqueado" style="display:none;" data-toggle="modal" data-target='#modal-danger-alerta-Bloqueo'></button>
                    
                        <div class="modal fade" id="modal-danger-alerta-Bloqueo">
                            <div class="modal-dialog">
                              <div class="modal-content bg-danger">
                                <div class="modal-header">
                                  <h4 class="modal-title">Consecutivo no valido</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    $consulta_documento=$mysqli->query("SELECT * FROM documento WHERe id='".$_POST['enviarIdDocumento']."' ");
                                    $extraer_consulta_documento=$consulta_documento->fetch_array(MYSQLI_ASSOC);
                                    
                                    /// consultamos el tipo de documento para traer el prefijo
                                        $consultaTipoDocumento=$mysqli->query("SELECT prefijo,id FROM tipoDocumento WHERE id='".$extraer_consulta_documento['tipo_documento']."' ");
                                        $extraerNombreTipoDocumentoConsulDocum=$consultaTipoDocumento->fetch_array(MYSQLI_ASSOC);
                                        $prefijoTipo=$extraerNombreTipoDocumentoConsulDocum['prefijo'];
                                        //// consultamos el prefijo del proceso para traerlo
                                        $consultaProceso=$mysqli->query("SELECT id,prefijo FROM procesos WHERE id='".$extraer_consulta_documento['proceso']."' ");
                                        $extraerNombreProcesoConsulDocum=$consultaProceso->fetch_array(MYSQLI_ASSOC);
                                        $prefijoProceso=$extraerNombreProcesoConsulDocum['prefijo'];
                                        
                                        /// traemos el consecutivo y version temporal para mostrar antes de ser verificado nuevamente
                                        $consecutivo=$extraer_consulta_documento['consecutivoTemporal'];
                                        $version=$extraer_consulta_documento['versionTemporal'];
                                        
                                        //echo $recorridoDocumentos['codificacion'];
                                        
                                        //CODIFICACION
                                            $codificacion = "";
                                            $dataCodificacion = $mysqli->query("SELECT * FROM codificacion ORDER BY id")or die(mysqli_error());
                                            while($rowC = $dataCodificacion->fetch_assoc()){
                                                                   
                                                $cod = $rowC['codificacion'];
                                                                        
                                                if($cod == "-"){
                                                    $codificacion =  $codificacion."-";
                                                }
                                                                    
                                                if($cod == "/"){
                                                    $codificacion =  $codificacion."/";
                                                }
                                                                        
                                                if($cod == " "){
                                                    $codificacion =  $codificacion." ";
                                                }
                                                                        
                                                if($cod == "Proceso"){
                                                    $codificacion =  $codificacion.$prefijoProceso;
                                                }
                                                                    
                                                if($cod == "Tipo de documento"){
                                                    $codificacion = $codificacion.$prefijoTipo;        
                                                }
                                                                        
                                                if($cod == "Consecutivo"){
                                                    $codificacion = $codificacion.$consecutivo;        
                                                }
                                                                        
                                                if($cod == "Versión"){
                                                    $codificacion = $codificacion.$version;        
                                                }
                                            }//Fin codificacion 
                                            
                                            /// traemos la simulación del consecutivo, que no ha sido tomado aún
                                           
                                    ?>
                                  <p>La codificación <?php echo $codificacion.' versión '.$version;?> ya existe.</p>
                                </div>
                                 <!-- END formulario para eliminar por el id -->
                              </div>
                            </div>
                        </div>

<?php    
}
?>

 <form role="form" id="formCrearDoc" action="controlador/solicitudDocumentos/pruebaAlmacenamientoObsoleto" method="POST" onsubmit="sendForm(); event.preventDefault(); " enctype="multipart/form-data">
              
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
             
             
               <input type="hidden" id="idDocumento" name="idDocumento" value="<?php echo $_POST['enviarIdDocumento'] ;?>"> 
                <div class="card-body">

                    <div class="row">
                        <!-- tipo de solicitud-->    
                                <input type="hidden" value="1" name="tipo" required>
                        <!-- END --> 
                        <div class="form-group col-sm-6">
                            <!--<label>Encargado:</label>-->
                            <?php
                            // consultamos los datos de la segunda tabla para sacar la información de los encargados y validar el encargado
                            $activarSelectEncargado='none';
                            $activarTextoEncargado='none';
                            $consultamosTablaSolicitudEncargado=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='".$extraerConsultaDatosDocumento['id_solicitud']."' "); 
                            $extraerConsultaTablaSolicitudEncargado=$consultamosTablaSolicitudEncargado->fetch_array(MYSQLI_ASSOC);
                                    /// validar encargado
                                    if($extraerConsultaTablaSolicitudEncargado['encargadoAprobar'] == 0){
                                        $activarTextoEncargado='';
                                        $enviarInformacionEncargadoN=$extraerConsultaTablaSolicitudEncargado['nombreEncargado'];
                                        $activarRadioEliminado='checked';
                                    }else{
                                        $activarSelectEncargado='';
                                        $enviarInformacionEncargado=$extraerConsultaTablaSolicitudEncargado['encargadoAprobar'];
                                        $activarRadioActivo='checked';
                                    }
                            ?>
                            <!-- Activos 
                            <input type="radio" id="encargadoSelec" name="validandoEncargados" value="1" <?php //echo $activarRadioActivo; ?> required>
                            &nbsp;&nbsp;
                            -->
                            <!-- Eliminados-->
                            <input type="hidden" id="encargadoSelecB" name="validandoEncargados" value="2" checked required> <?php //echo $activarRadioEliminado; ?> 

                            <select name="encargado" class="form-control" style="display:<?php echo $activarSelectEncargado;?>;" id="mostrarSelectEncargado" >
                            <?php
                            $consultandoIdEncargado=$mysqli->query("SELECT * FROM cargos WHERE id_cargos='$enviarInformacionEncargado' ");
                            $extraerConnsultaIdEncargado=$consultandoIdEncargado->fetch_array(MYSQLI_ASSOC);
                            ?>
                            <option value="<?php echo $extraerConnsultaIdEncargado['id_cargos'];?>"><?php echo $extraerConnsultaIdEncargado['nombreCargos'];?></option>
                                <?php
                                require_once'conexion/bd.php';
                                $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                                $resultado2=$mysqli->query("SELECT * FROM cargos WHERE NOT id_cargos='$enviarInformacionEncargado' ORDER BY nombreCargos ASC");
                    
                                while ($columna = mysqli_fetch_array( $resultado2 )) { ?>
                                <option value="<?php echo $columna['id_cargos']; ?>"><?php echo $columna['nombreCargos']; ?> </option>
                                <?php }  ?>
                            </select>

                            <input name="encargadoT" id="mostrarTextEncargado" value="<?php echo 'Administrador';//$enviarInformacionEncargadoN; ?>" class="form-control" type="hidden" pattern="[A-Za-z0-9_- ]{1,90}" style="display:<?php echo $activarTextoEncargado;?>;">

                            <script> //// validación para cambiar de proceso
                                $(document).ready(function(){
                                    $('#encargadoSelec').click(function(){ 
                                        document.getElementById('mostrarSelectEncargado').style.display = '';
                                        document.getElementById('mostrarTextEncargado').style.display = 'none';
                                    });
                                    $('#encargadoSelecB').click(function(){ 
                                        document.getElementById('mostrarSelectEncargado').style.display = 'none';
                                        document.getElementById('mostrarTextEncargado').style.display = '';
                                    });
                                });
                            </script>
                            
                        </div>
                        <!--
                        <div class="form-group col-sm-6" >
                      
                            <label for="upload-photo">Archivo Máx 10MB:</label>
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" class="custom-file-input" id="miInputEncargado" name="archivo"  >
                                <label class="custom-file-label" >Subir Archivo</label>
                                
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Subir</span>
                                </div>
                            </div>
                        </div>
                        -->
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Nombre del documento: </label> <!--  este es el mismo nombre que se debe enviar el la solicitud de documento-->
                            <input type="text" class="form-control" name="nombreDocumento" placeholder="<?php echo $extraerConsultaDatosDocumento['nombres']; ?>" value="<?php echo $extraerConsultaDatosDocumento['nombres'];?>" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Proceso: </label>
                           
                            <?php
                                require_once'conexion/bd.php';
                               
                            ?>
                            <select type="text" class="form-control"  name="proceso" id="idproceso" placeholder="Proceso"  style="display:;" required> <!--  id="procesosActivosSelect" -->
                               <!-- <option value=''>Seleccionar proceso</option> id="idproceso" -->
                                <?php
                                $consultandoProcesoSeleccionado=$mysqli->query("SELECT * FROM procesos WHERE id='".$extraerConsultaDatosDocumento['proceso']."' ");
                                $extraerProcesosSeleccionado=$consultandoProcesoSeleccionado->fetch_array(MYSQLI_ASSOC);
                                ?>
                                <option value="<?php echo $extraerProcesosSeleccionado['id']; ?>"><?php echo $extraerProcesosSeleccionado['nombre']; ?></option>
                                <?php

                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT * FROM procesos WHERE NOT id='".$extraerConsultaDatosDocumento['proceso']."'  ORDER BY estado");  //id='".$traerNombreSolicitud['proceso']."'
                                while ($columna = mysqli_fetch_array( $resultado )) { 
                                    if($columna['estado'] == 'Eliminado'){
                                       // continue;
                                    }
                                
                                    if($columna['estado'] == 'Eliminado'){
                                    ?>
                                    <option value="<?php echo $columna['id']; ?>" style="color:red;"><?php echo $columna['nombre'].' -- '.$columna['estado']; ?></option>
                                    <?php
                                    }else{
                                    ?>
                                    <option value="<?php echo $columna['id']; ?>" style="color:green;"><?php echo $columna['nombre'].' -- Activos'; ?></option>
                                    <?php
                                    }
                                    ?>
                                <?php }  ?>
                            </select>
                          
                            
                            <script> //// validación para cambiar de proceso
                                $(document).ready(function(){
                                    $('#procesosEliminados').click(function(){ 
                                        document.getElementById('procesosActivosSelect').style.display = 'none';
                                        document.getElementById('procesosEliminadoSelect').style.display = '';
                                    });
                                    $('#procesosActivos').click(function(){ 
                                        document.getElementById('procesosActivosSelect').style.display = '';
                                        document.getElementById('procesosEliminadoSelect').style.display = 'none';
                                    });
                                });
                            </script>


                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <?php
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT * FROM normatividad");
                                $arrayNormas = json_decode($extraerConsultaDatosDocumento['norma']);
                            ?>
                            <label>Norma: </label>
                              <select class="duallistbox" name="norma[]" multiple>
                                <?php
                                    while ($columna = mysqli_fetch_array( $resultado )) {
                                        if($arrayNormas != NULL){
                                            if(in_array($columna['id'],$arrayNormas)){
                                                $seleccionarNorm = "selected";        
                                            }else{
                                                $seleccionarNorm ="";
                                            }
                                          } 
                                        
                                ?>
                                    <option value="<?php echo $columna['id']; ?>" <?php echo $seleccionarNorm; ?> ><?php echo $columna['nombre']; ?> </option>
                                <?php }  ?>
                              </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Método de creación: </label><br>
                            <div class="custom-control custom-radio">
                              <input class="custom-control-input" type="radio" id="customRadio1" name="rad_metodo" value="documento" checked required>
                              <label for="customRadio1" class="custom-control-label">Documento (PDF, WORD, EXCEL, AUTOCAD)</label>
                            </div>
                            <!--
                            <div class="custom-control custom-radio">
                              <input class="custom-control-input" type="radio" id="customRadio2" name="rad_metodo" value="html" required>
                              <label for="customRadio2" class="custom-control-label">Edición HTML</label>
                            </div>
                            -->
                            <div><br>
                                <label>Tipo documento:</label>
                                <?php
                                    require_once'conexion/bd.php';
                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $resultado=$mysqli->query("SELECT * FROM tipoDocumento WHERE NOT id='".$extraerConsultaTablaSolicitudEncargado['tipoDocumento']."' ORDER BY nombre"); //WHERE id='".$traerNombreSolicitud['tipoDocumento']."'
                                ?>
                                <select type="text" class="form-control" id="idtipoDoc" name="tipoDoc" placeholder="" required>
                                    <?php
                                    $consultaTipoDocumento=$mysqli->query("SELECT * FROM tipoDocumento WHERE id='".$extraerConsultaTablaSolicitudEncargado['tipoDocumento']."' ");
                                    $extraerTipoDocumento=$consultaTipoDocumento->fetch_array(MYSQLI_ASSOC);
                                    ?>
                                    <option value='<?php echo $extraerTipoDocumento['id'];?>'><?php echo $extraerTipoDocumento['nombre'];?></option>
                                    <?php
                                    while ($columna = mysqli_fetch_array( $resultado )) { ?>
                                    <option value="<?php echo $columna['id']; ?>"><?php echo $columna['nombre']; ?> </option>
                                    <?php }  ?>
                                </select>
                            </div>
                            
                            <div>
                                <br>
                                <label>Ubicación: </label>
                                <input type="text" class="form-control" value="<?php echo $extraerConsultaDatosDocumento['ubicacion'];?>" name="ubicacion" placeholder="Ubicación" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || event.charCode == 47)" required>
                            </div>
                        </div>

                    </div>
                    <label>Flujo usuarios:</label>&nbsp;&nbsp;
                    <?php
                     $quienElabora=json_decode($extraerConsultaDatosDocumento['elabora']);
                     // quién elabora
                     if($quienElabora[0] == 'cargos' || $quienElabora[0] == 'usuarios'){
                          $variableRadioUsuarioElaboraActivo='checked';
                          $ocultarVariableUsuariosRetirado='none';
                     }else{
                          $enviarQuienElabora=$extraerConsultaDatosDocumento['elabora'];
                          $variableRadioUsuarioElaboraRetirado='checked';
                          $ocultarVariableUsuariosActivo='none';
                     }
                     
                     // quién revisa
                     $quienRevisa=json_decode($extraerConsultaDatosDocumento['revisa']);
                     
                     if($quienRevisa[0] == 'cargos' || $quienRevisa[0] == 'usuarios'){
                            $variableRadioUsuarioRevisorActivo='checked';
                            $ocultarVariableUsuariosRetiradoRevisado='none';
                     }else{
                          $enviarQuienRevisa=$extraerConsultaDatosDocumento['revisa'];
                          $variableRadioUsuarioRevisaRetirado='checked';
                          $ocultarVariableUsuariosActivoRevisado='none';
                     }
                     
                     // quién aprueba
                     $quienAprueba=json_decode($extraerConsultaDatosDocumento['aprueba']);
                     
                     if($quienAprueba[0] == 'cargos' || $quienAprueba[0] == 'usuarios'){
                            $variableRadioUsuarioAprobadorActivo='checked';
                            $ocultarVariableUsuariosAprobadorRevisado='none';
                     }else{
                          $enviarQuienAprueba=$extraerConsultaDatosDocumento['aprueba'];
                          $variableRadioUsuarioAprobadoRetirado='checked';
                          $ocultarVariableUsuariosActivoAprobado='none';
                     }
                    ?>
                        Activos
                            <input type="radio" id="usuariosActivos" value="activosUsuarios" name="validandoUsuarios" <?php echo $variableRadioUsuarioElaboraActivo; ?> required>
                            &nbsp;&nbsp;
                        Retirados
                            <input type="radio" id="usuariosRetirados" value="retiradosUsuarios" name="validandoUsuarios" <?php echo $variableRadioUsuarioElaboraRetirado; ?> required>
                            <?php
                            $elabora = json_decode($extraerConsultaDatosDocumento['elabora']);
                            $revisa = json_decode($extraerConsultaDatosDocumento['revisa']);
                            $aprueba = json_decode($extraerConsultaDatosDocumento['aprueba']);
                            
                            if($elabora[0] == 'cargos'){
                                $checkedCElabora = "checked";            
                            }
                            
                            if($elabora[0] == 'usuarios'){
                                $checkedUElabora = "checked"; 
                            }
                            
                            if($revisa[0] == 'cargos'){
                                $checkedCRevisa = "checked";            
                            }
                            
                            if($revisa[0] == 'usuarios'){
                                $checkedURevisa = "checked"; 
                            }
                            
                            if($aprueba[0] == 'cargos'){
                                $checkedCAprueba = "checked";            
                            }
                            
                            if($aprueba[0] == 'usuarios'){
                                $checkedUAprueba = "checked"; 
                            }
                            
                            if($datosDoc['estadoActualiza'] != NULL){//si el estado es null quiere decir que no se ah asigando quien elabora, revisa, aprueba entonces puede asigar quien lo hace
                                $display = "none";
                            }else{
                                $display = "";
                            }
                            
                            ?>        
                   
                    <div class="row" >
                        <div class="form-group col-sm-6" id="mostrarRetirados"  style="display:<?php echo  $ocultarVariableUsuariosRetirado; ?>;">
                            <label>Quién elabora: </label><br>
                            <input type="hidden"  name="radiobtnE" value="cargos" required>
                            <div class="select2-blue">
                                <input align="left" id="retiradoTextoE" class="form-control" name="select_encargadoEE" value="<?php echo $enviarQuienElabora; ?>" type="text" pattern="[A-Za-z0-9_- ]{1,90}"  onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250  || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                            </div>
                        </div>
                         <div class="form-group col-sm-6" id="mostrarActivos"  style="display:<?php echo  $ocultarVariableUsuariosActivo; ?>;">
                            <label>Quién elabora: </label>
                            <input type="radio" id="rad_cargoE" name="radiobtnE" value="cargos" <?php echo $checkedCElabora; ?> >
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioE" name="radiobtnE" value="usuarios" <?php echo $checkedUElabora; ?> >
                            <label for="usuarios">Usuarios</label>

                            
                            <div class="select2-blue">
                            
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoE[]" id="select_encargadoE" ></select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Codificación:</label>
                            <!-- <label><input name="radCodificacion" id="rad_automatica" type='radio' value="automatico" required> Automática </label>
                            <br> -->
                            <label><input name="radCodificacion" id="rad_manual" type='radio' value="manual" checked required> Manual </label>
                        
                            <div id="codificacionManual" style="display:;"> <!-- none -->
                                    <table class="">
                                        <thead>
                                            <tr>
                                                <th>
                                                <label>Versión: </label>
                                                </th>
                                                <th>
                                                <input class="form-control" name="versionDeclarada" value="<?php echo $extraerConsultaDatosDocumento['versionTemporal']; ?>"  required  onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" type="number" min="0" id="id_version">
                                                </th>
                                                <th>
                                                <label>Consecutivo: </label>
                                                </th>
                                                <th>
                                                <input class="form-control" name="consecutivoDeclarado" value="<?php echo $extraerConsultaDatosDocumento['consecutivoTemporal']; ?>" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" type="number" min="0" id="consecutivo"> 
                                                <!-- value="<?php //echo $extraerConsultaDatosDocumento['consecutivo']; ?>" -->
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                            </div>
                        
                        </div> 
                        
                    </div>
                    <script> //// validación para elegir entre usuarios activos o usuarios retirados
                    
                    <?php
                    if($variableRadioUsuarioElaboraActivo == 'checked'){
                    ?>
                    document.getElementById("select_encargadoE").setAttribute("required","any");
                    document.getElementById("retiradoTextoE").removeAttribute("required","any");
                    <?php
                    }
                    if($variableRadioUsuarioElaboraRetirado == 'checked'){
                    ?>
                    document.getElementById("retiradoTextoE").setAttribute("required","any"); 
                    document.getElementById("select_encargadoE").removeAttribute("required","any");
                    <?php
                    }
                    ?>
                    
                            $(document).ready(function(){
                                $('#usuariosRetirados').click(function(){
                                    document.getElementById('mostrarRetirados').style.display = '';
                                    document.getElementById("retiradoTextoE").setAttribute("required","any"); 
                                    document.getElementById("select_encargadoE").removeAttribute("required","any");
                                    document.getElementById('mostrarActivos').style.display = 'none';
                                });
                                $('#usuariosActivos').click(function(){
                                    document.getElementById('mostrarRetirados').style.display = 'none';
                                    document.getElementById("retiradoTextoE").removeAttribute("required","any");
                                    document.getElementById("select_encargadoE").setAttribute("required","any");
                                    document.getElementById('mostrarActivos').style.display = '';
                                });
                            });
                        </script>
                    <br>
                    <label>Flujo usuarios:</label>&nbsp;&nbsp;
                    Activos
                            <input type="radio" id="usuariosActivosB" value="activosUsuariosB" name="validandoUsuariosB" <?php echo $variableRadioUsuarioRevisorActivo; ?> required>
                            &nbsp;&nbsp;
                        Retirados
                            <input type="radio" id="usuariosRetiradosB" value="retiradosUsuariosB" name="validandoUsuariosB" <?php echo $variableRadioUsuarioRevisaRetirado; ?> required>
                            
                    <div class="row" >
                       
                        <div class="form-group col-sm-6" id="mostrarRetiradosB" style="display:<?php echo $ocultarVariableUsuariosRetiradoRevisado; ?>;">
                            <label>Quién revisa: </label><br>
                            <!--<input type="hidden"  name="radiobtnR" value="cargos" required>-->
                            <div class="select2-blue">
                                <input class="form-control" id="retiradoTexto" name="select_encargadoRR" value="<?php echo $enviarQuienRevisa; ?>" type="text" pattern="[A-Za-z0-9_- ]{1,90}"  onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                            </div>
                        </div>
                        
                        <div class="form-group col-sm-6" id="mostrarActivosB" style="display:<?php echo $ocultarVariableUsuariosActivoRevisado;?>;">
                            <label>Quién revisa: </label>
                            <input type="radio" id="rad_cargoR" name="radiobtnR" <?php echo $checkedCRevisa; ?> value="cargos" >
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioR" name="radiobtnR" <?php echo $checkedURevisa; ?> value="usuarios" >
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                              
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoR[]" id="select_encargadoR" ></select>
                         
                            </div>
                        </div>
                        
                    </div>
                   <script> //// validación para elegir entre usuarios activos o usuarios retirados
                   
                   <?php
                   if($variableRadioUsuarioRevisorActivo == 'checked'){
                   ?>
                   document.getElementById("select_encargadoR").setAttribute("required","any");
                   document.getElementById("retiradoTexto").removeAttribute("required","any"); 
                   <?php
                   }
                   
                   if($variableRadioUsuarioRevisaRetirado == 'checked'){
                   ?>
                   document.getElementById("retiradoTexto").setAttribute("required","any");
                   document.getElementById("select_encargadoR").removeAttribute("required","any");
                   <?php
                   }
                   ?>
                   
                   
                            $(document).ready(function(){
                                $('#usuariosRetiradosB').click(function(){
                                    document.getElementById('mostrarRetiradosB').style.display = '';
                                    document.getElementById("retiradoTexto").setAttribute("required","any"); 
                                    document.getElementById("select_encargadoR").removeAttribute("required","any");
                                    document.getElementById('mostrarActivosB').style.display = 'none';
                                });
                                $('#usuariosActivosB').click(function(){
                                    document.getElementById('mostrarRetiradosB').style.display = 'none';
                                    document.getElementById("retiradoTexto").removeAttribute("required","any");
                                    document.getElementById("select_encargadoR").setAttribute("required","any");
                                    document.getElementById('mostrarActivosB').style.display = '';
                                });
                            });
                        </script>
                       
                    
                    
                     <br>
                    <label>Flujo usuarios:</label>&nbsp;&nbsp;
                    Activos
                            <input type="radio" id="usuariosActivosC" value="activosUsuariosC" name="validandoUsuariosC" <?php echo $variableRadioUsuarioAprobadorActivo; ?> required>
                            &nbsp;&nbsp;
                        Retirados
                            <input type="radio" id="usuariosRetiradosC" value="retiradosUsuariosC" name="validandoUsuariosC" <?php echo $variableRadioUsuarioAprobadoRetirado; ?> required>
                            
                    <div class="row">
                        
                        
                        <!-- tenemos los usuarios retirados--------------------------------------------------------------    -->
                        <div class="form-group col-sm-6" id="mostrarRetiradosC" style="display:<?php echo  $ocultarVariableUsuariosAprobadorRevisado; ?>;" >
                            <label>Quién aprueba: </label><br>
                            <input type="hidden" name="radiobtnA" value="cargos" required>
                            <div class="select2-blue">
                                <input class="form-control" id="retiradoTextoA" name="select_encargadoAA" value="<?php echo $enviarQuienAprueba; ?>" type="text" pattern="[A-Za-z0-9_- ]{1,90}" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                            </div>
                        </div>
                        <!-- tenemos los usuarios retirados--------------------------------------------------------------    -->
                        
                        <!-- tenemos los usuarios activos--------------------------------------------------------------    -->
                        <div class="form-group col-sm-6" id="mostrarActivosC" style="display:<?php echo  $ocultarVariableUsuariosActivoAprobado; ?>;" >
                            <label>Quién aprueba: </label><br>
                            <input type="radio" id="rad_cargoA" name="radiobtnA" value="cargos" <?php echo $checkedCAprueba; ?> >
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioA" name="radiobtnA" value="usuarios" <?php echo $checkedUAprueba; ?> >
                            <label for="usuarios">Usuarios</label>

                            
                            <div class="select2-blue">
                               <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoA[]" id="select_encargadoA" ></select>
                            </div>
                        </div>
                        <!-- tenemos los usuarios activos--------------------------------------------------------------    -->
                        
                    </div>
                        <script> //// validación para elegir entre usuarios activos o usuarios retirados
                        
                        
                        <?php
                        if($variableRadioUsuarioAprobadorActivo == 'checked'){
                        ?>
                        document.getElementById("select_encargadoA").setAttribute("required","any");
                        document.getElementById("retiradoTextoA").removeAttribute("required","any");
                        <?php
                        }
                        
                        if($variableRadioUsuarioAprobadoRetirado == 'checked'){
                        ?>
                        document.getElementById("retiradoTextoA").setAttribute("required","any");
                        document.getElementById("select_encargadoA").removeAttribute("required","any");
                        <?php
                        }
                        ?>
                        
                            $(document).ready(function(){
                                $('#usuariosRetiradosC').click(function(){
                                    document.getElementById('mostrarRetiradosC').style.display = '';
                                    document.getElementById("retiradoTextoA").setAttribute("required","any"); 
                                    document.getElementById("select_encargadoA").removeAttribute("required","any");
                                    document.getElementById('mostrarActivosC').style.display = 'none';
                                });
                                $('#usuariosActivosC').click(function(){
                                    document.getElementById('mostrarRetiradosC').style.display = 'none';
                                    document.getElementById("retiradoTextoA").removeAttribute("required","any");
                                    document.getElementById("select_encargadoA").setAttribute("required","any");
                                    document.getElementById('mostrarActivosC').style.display = '';
                                });
                            });
                        </script>
                 

                <!-- name="agregarDocB" id="mostrarBotonFinalizar" -->
                   
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                    <input type="hidden" name="idSolicitud" value="<?php echo $idSolicitud;?>">   
                    <input type="hidden" name="rol" value="<?php echo $rol;?>">   
                    <input type="hidden" name="usuario" value="<?php echo $_SESSION["session_username"];?>">
                </div>
             
            </div>
            </div>    

        <div class="col">
            </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
                <div class="card-body">
                    <div class="row">
                        
                       
                        
                        <?php
                            //if($metodo == "documento"){
                        ?>
                        <div class="form-group col-sm-6">
                            <label for="exampleInputFile">Importar documento PDF (Máx 10MB)</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <?php
                                if($_POST['alertaDocumento'] != NULL){
                                ?>
                                <input type="file" class="custom-file-input"  id="myInputPDF" name="archivopdf" accept=".pdf" required>
                                <?php
                                }else{
                                ?>
                                <input type="file" class="custom-file-input"  id="myInputPDF" name="archivopdf" accept=".pdf" >
                                <?php
                                }
                                ?>
                                <label class="custom-file-label" for="exampleInputFile">Seleccionar archivo</label>
                              </div>
                            </div>
                            
                            
                            <script>
                                $('input[name="archivopdf"]').on('change', function(){
                                    var ext = $( this ).val().split('.').pop();
                                    if ($( this ).val() != '') {
                                      if(ext == "pdf"){
                                        
                                      }
                                      else
                                      {
                                        $( this ).val('');
                                        //alert("Extensión no permitida: " + ext);
                                        const Toast = Swal.mixin({
                                          toast: true,
                                          position: 'top-end',
                                          showConfirmButton: false,
                                          timer: 3000
                                        });
                                    
                                    
                                        Toast.fire({
                                            type: 'warning',
                                            title: ` Extensión no permitida`
                                        })
                                      }
                                    }
                                  });
                                </script>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="exampleInputFile">Importar documento editable (.docx,.xlsx,.dwg,.pptx Máx 10MB)</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <?php
                                if($_POST['alertaDocumento'] != NULL){
                                ?>
                                <input type="file" class="custom-file-input" id="myInpuEditable" name="archivootro" accept=".xls,.xlsx,.docx,.doc,.dwg,.pptx,.ppt" required>
                                <?php
                                }else{
                                ?>
                                <input type="file" class="custom-file-input" id="myInpuEditable" name="archivootro" accept=".xls,.xlsx,.docx,.doc,.dwg,.pptx,.ppt" >
                                <?php
                                }
                                ?>
                                <label class="custom-file-label" for="exampleInputFile">Seleccionar archivo</label>
                              </div>
                            </div>
                            
                            <script>
                                $('input[name="archivootro"]').on('change', function(){
                                    var ext = $( this ).val().split('.').pop();
                                    if ($( this ).val() != '') {
                                      if(ext == "docx" || ext == "xls" || ext == "xlsx" || ext == "doc" || ext == "dwg" || ext == "pptx" || ext =="ppt" ){
                                        
                                      }
                                      else
                                      {
                                        $( this ).val('');
                                        //alert("Extensión no permitida: " + ext);
                                        const Toast = Swal.mixin({
                                          toast: true,
                                          position: 'top-end',
                                          showConfirmButton: false,
                                          timer: 3000
                                        });
                                    
                                    
                                        Toast.fire({
                                            type: 'warning',
                                            title: ` Extensión no permitida`
                                        })
                                      }
                                    }
                                  });
                                </script>
                        </div>
                        <?php
                        // }
                        ?>
                        
                        
                        
                        <div class="form-group col-sm-6">
                            <?php
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT id, nombre FROM documentoExterno");
                                $arrayDocE = json_decode($extraerConsultaDatosDocumento['documento_externo']);
                            ?>
                            <label>Documentos externos: </label>
                              <select class="duallistbox" name="documentos_externos[]" multiple >
                                <?php
                                    while ($columna = mysqli_fetch_array( $resultado )) {
                                        if($arrayDocE != NULL){  
                                            if(in_array($columna['id'],$arrayDocE)){
                                                $seleccionarDocE = "selected";        
                                            }else{
                                                $seleccionarDocE ="";
                                            }
                                          } 
                                          ?>
                                    <option value="<?php echo $columna['id']; ?>" <?php echo $seleccionarDocE; ?>><?php echo $columna['nombre']; ?> </option>
                                <?php }  ?>
                              </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <?php
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT id, nombre, nombreN FROM definicion ORDER by nombre, nombreN ASC");
                                $arrayDefiniciones = json_decode($extraerConsultaDatosDocumento['definiciones']);

                            ?>
                            <label>Definiciones: </label>
                              <select class="duallistbox" name="definiciones[]" multiple >
                                  
                                  
                                <?php
                                    while ($columna = mysqli_fetch_array( $resultado )) {
                                        $id = $columna['id'];
                                        $nombre = $columna['nombre'];
                                        $nombreN =$columna['nombreN'];
                                        if($arrayDefiniciones != NULL){ 
                                            if(in_array($columna['id'],$arrayDefiniciones)){
                                                $seleccionarDef = "selected";        
                                            }else{
                                                $seleccionarDef ="";
                                            }
                                          }
                                          /*
                                        if($nombre != NULL){
                                            echo "<option value='$id' > $nombre</option>";
                                        }
                                       */
                                     
                                    ?>
                                    <option value="<?php echo $columna['id']; ?>" <?php echo $seleccionarDef; ?>><?php echo $columna['nombre']; ?> </option>
                                       
                                <?php }  ?>
                              </select>
                        </div>


                        <div class="form-group col-sm-6">
                            <label>Archivo en gestión: </label>
                            <input type="text" class="form-control" name="archivo_gestion" placeholder="Archivo en gestión" value="<?php echo $extraerConsultaDatosDocumento['archivo_gestion']; ?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                                <br>
                            <label>Archivo central: </label>
                            <input type="text" class="form-control" name="archivo_central" placeholder="Archivo central" value="<?php echo $extraerConsultaDatosDocumento['archivo_central']; ?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                                <br>
                            <label>Archivo histórico: </label>
                            <input type="text" class="form-control" name="archivo_historico" placeholder="Archivo histórico" value="<?php echo $extraerConsultaDatosDocumento['archivo_historico']; ?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                            
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label>Disposición Documental: </label>
                            <textarea rows="3" class="form-control" name="diposicion_documental" placeholder="Disposición Documental" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required><?php echo $extraerConsultaDatosDocumento['disposicion_documental']; ?></textarea>
                            <br><br>
                            <label>Responsable de disposición: </label>
                            <?php 
                            
                            $responsableDisposicion=json_decode($extraerConsultaDatosDocumento['responsable_disposicion']);
                     // quién elabora
                            if($responsableDisposicion[0] == 'cargos' || $responsableDisposicion[0] == 'usuarios'){
                                if($responsableDisposicion[0] == 'cargos'){
                                    $responsableDisposicionCargo = 'checked';
                                }
                                if($responsableDisposicion[0] == 'usuarios'){
                                    $responsableDisposicionUsuario = 'checked';
                                }
                                 $variableRadioDisposicionActivos='checked';
                                 $ocultarVariableUsuariosRetiradoDisposicion='none';
                             }else{
                                 $enviarResponsableDisposicion=$extraerConsultaDatosDocumento['responsable_disposicion'];
                                 $variableRadioDisposicionRetirado='checked';
                                 $ocultarVariableUsuariosActivoDisposicion='none';
                            }
                            ?>
                            Activos
                                <input type="radio" id="usuariosActivosR" value="activosUsuariosResponsable" name="validandoUsuariosR" <?php echo $variableRadioDisposicionActivos; ?> required>
                                &nbsp;&nbsp;
                            Retirados
                                <input type="radio" id="usuariosRetiradosR" value="retiradosUsuariosResponsable" name="validandoUsuariosR" <?php echo $variableRadioDisposicionRetirado; ?> required>
                            <br>
                            
                            <div id="mostrarRetiradosR" style="display:<?php echo $ocultarVariableUsuariosRetiradoDisposicion; ?>;">
                               <!-- <input type="hidden" name="radiobtnD" value="cargos">-->
                                <div class="select2-blue" >
                                    <br>
                                    <input type="text" class="form-control" id="retiradoTextoEncargado" name="select_encargadoDD" value="<?php echo $enviarResponsableDisposicion; ?>" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                                </div>
                            </div>
                                
                            <div id="mostrarActivosR" style="display:<?php echo $ocultarVariableUsuariosActivoDisposicion; ?>;">
                                <input type="radio" id="rad_cargoD" name="radiobtnD" value="cargos" <?php echo $responsableDisposicionCargo; ?> >
                                <label for="cargo">Cargo</label>
                                <input type="radio" id="rad_usuarioD" name="radiobtnD" value="usuarios" <?php echo $responsableDisposicionUsuario; ?>>
                                <label for="usuarios">Usuarios</label>
    
                                <div class="select2-blue" >
                                    <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoD[]" id="select_encargadoD" ></select>
                                </div>
                                
                            </div>
                            
                                 <script> //// validación para elegir entre usuarios activos o usuarios retirados
                                 
                                 <?php
                                 if($variableRadioDisposicionActivos == 'checked'){
                                 ?>
                                 document.getElementById("select_encargadoD").setAttribute("required","any");
                                 document.getElementById("retiradoTextoEncargado").removeAttribute("required","any");
                                 <?php
                                 }
                                 
                                 if($variableRadioDisposicionRetirado == 'checked'){
                                 ?>
                                 document.getElementById("retiradoTextoEncargado").setAttribute("required","any");
                                 document.getElementById("select_encargadoD").removeAttribute("required","any");
                                 <?php
                                 }
                                 ?>
                                 
                                    $(document).ready(function(){
                                        $('#usuariosRetiradosR').click(function(){ 
                                            document.getElementById('mostrarRetiradosR').style.display = '';
                                            document.getElementById('mostrarActivosR').style.display = 'none';
                                            document.getElementById("retiradoTextoEncargado").setAttribute("required","any"); 
                                            document.getElementById("select_encargadoD").removeAttribute("required","any");
                                        });
                                        $('#usuariosActivosR').click(function(){ 
                                            document.getElementById('mostrarRetiradosR').style.display = 'none';
                                            document.getElementById('mostrarActivosR').style.display = '';
                                            document.getElementById("retiradoTextoEncargado").removeAttribute("required","any"); 
                                            document.getElementById("select_encargadoD").setAttribute("required","any");
                                        });
                                    });
                                </script>
                        </div>
                        
                        
                    </div>
                        
        
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                  
                    
                </div>
             
            </div>
            </div>    

        <div class="col">
            </div>
            
           
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

    <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
               <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Meses para próxima revisión </label>
                            <input name="enviarIdDocumentoControl" value="<?php echo $_POST['enviarIdDocumentoControl'];?>" type="hidden">
                            <input name="mesesRevision" type="number" min="1" max="24" value="<?php echo $extraerConsultaDatosDocumento['mesesRevision']; ?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                        </div>
                        <div class="col-sm-12">
                            <center>
                                    <br>
                                    <p><h4>Control de Cambios</h4></p>
                                </center>
                            <?php
                            // consulta de la tabla del control de cambios
                                $consultandoDocumento=$mysqli->query("SELECT * FROm documento WHERE id='".$_POST['enviarIdDocumento']."' ");
                                $extraerConsultaDocumento=$consultandoDocumento->fetch_array(MYSQLI_ASSOC);
                                $extraerIdSolicitud=$extraerConsultaDocumento['id_solicitud'];
                            
                            
                                $consultamosExistenciaComentario=$mysqli->query("SELECT * FROM controlCambiosFlujo WHERE idDocumento='".$_POST['enviarIdDocumento']."' ");
                                $extrarConsultaExistenciaComentario=$consultamosExistenciaComentario->fetch_array(MYSQLI_ASSOC);
                                if($extrarConsultaExistenciaComentario['idDocumento'] != NULL){
                                   
                                    $informacionDelTexto=$extrarConsultaExistenciaComentario['informacion'];
                                    
                                }else{
                                
                                    $consultaControlCambios=$mysqli->query("SELECT * FROM  controlCambiosParametrizacion ");
                                    $extraerControlCambios=$consultaControlCambios->fetch_array(MYSQLI_ASSOC);
                                    $informacionDelTexto=$extraerControlCambios['informacion'];
                                }
    
                           
                            // end
                            ?>
                            <input name="reservaIdSolicitud" value="<?php echo $extraerIdSolicitud; ?>" type="hidden">
                            <textarea name="editor1" required><?php echo $informacionDelTexto;?></textarea>
                        </div>
                        <?php 
                        
                        /// consultamos la tabla que contiene los controles de cambios con las fechas de aprobación, revisión y elaboración
                                $consultandoControlDeCambios=$mysqli->query("SELECT * FROM controlCambios WHERE idDocumento='".$_POST['enviarIdDocumentoControl']."' LIMIT 0,1 ");
                                $extraerDocumentosConsulta=$consultandoControlDeCambios->fetch_array(MYSQLI_ASSOC);
                                $enviarInformacionCcontrolCambios=$extraerDocumentosConsulta['comentario'];
                                $validarFechaA=substr($extraerDocumentosConsulta['fecha'],0,10);
                                $enviarfechacontrolCambios=$validarFechaA;
                                

                                $consultandoControlDeCambiosB=$mysqli->query("SELECT * FROM controlCambios WHERE idDocumento='".$_POST['enviarIdDocumentoControl']."' LIMIT 1,2 ");
                                $extraerDocumentosConsultaB=$consultandoControlDeCambiosB->fetch_array(MYSQLI_ASSOC);
                                $enviarInformacionCcontrolCambiosB=$extraerDocumentosConsultaB['comentario'];
                                $validarFechaAB=substr($extraerDocumentosConsultaB['fecha'],0,10);
                                $enviarfechacontrolCambiosB=$validarFechaAB;

                                $consultandoControlDeCambiosC=$mysqli->query("SELECT * FROM controlCambios WHERE idDocumento='".$_POST['enviarIdDocumentoControl']."' LIMIT 2,3 ");
                                $extraerDocumentosConsultaC=$consultandoControlDeCambiosC->fetch_array(MYSQLI_ASSOC);
                                $enviarInformacionCcontrolCambiosC=$extraerDocumentosConsultaC['comentario'];
                                $validarFechaAC=substr($extraerDocumentosConsultaC['fecha'],0,10);
                                $enviarfechacontrolCambiosC=$validarFechaAC;
                                
                                
                                //echo $enviarfechacontrolCambios;


                        /// END
                        
                        ?>        
                        <div class="form-group col-sm-12">
                            <label>Fecha de elaboración: </label> 
                            <div class="input-group" style="width:;">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                <input type="date" value="<?php echo $enviarfechacontrolCambios; ?>" id="primerafecha" name="fechaElaboracion" class="form-control float-right"  required> <!-- id="reservationtime" -->
                                <!-- este input es para mostrar la fecha sin dejarse modificar después de validar las fechas -->
                                    <input style="display:none;" type="date" id="mostrarPrimeraFecha"  class="form-control float-right" id=""  required>
                                <!-- END -->
                            </div>
                            
                            <input value="<?php echo $enviarInformacionCcontrolCambios; ?>" class="form-control" name="controlCambios" placeholder="Comentarios..." onkeypress="return (event.charCode == 58 || event.charCode == 59 || (event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                            <br>
                            <label>Fecha de revisión: </label>
                            <div class="input-group" style="width:;">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                <input type="date" value="<?php echo $enviarfechacontrolCambiosB; ?>" id="segundafecha" name="fechaRevision" class="form-control float-right"  required>
                                <!-- este input es para mostrar la fecha sin dejarse modificar después de validar las fechas -->
                                    <input style="display:none;" type="date" id="mostrarSegundaFecha"  class="form-control float-right"   required>
                                <!-- END -->
                            </div>
                            <input class="form-control" value="<?php echo $enviarInformacionCcontrolCambiosB;?>" name="comentarioRevision" placeholder="Comentarios..." onkeypress="return (event.charCode == 58 || event.charCode == 59 || (event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                            <br>
                            
                             
                            <label>Fecha de aprobación: </label>
                            <div class="input-group" style="width:;">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                    <input type="date" value="<?php echo $enviarfechacontrolCambiosC; ?>" id="terceraFecha" name="fechaAprobacion" class="form-control float-right"  required>
                                    <!-- este input es para mostrar la fecha sin dejarse modificar después de validar las fechas -->
                                        <input style="display:none;" type="date" id="mostrarSTercerFecha"  class="form-control float-right"   required>
                                    <!-- END -->
                            </div>
                            
                            <input class="form-control" value="<?php echo $enviarInformacionCcontrolCambiosC; ?>" name="comentarioAprobo" placeholder="Comentarios..." onkeypress="return (event.charCode == 58 || event.charCode == 59 || (event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                            <br>
                            <!--
                            <label>Control de cambios: </label>
                            <textarea rows="2" class="form-control" name="controlCambios" placeholder="Control de cambios" required></textarea>
                            <br>
                            -->
                            <!-- podemos enviar el tipo de flujo de usuarios para el almacenamiento -->
                            <?php
                                $verificandoUsuariosActivosRetirados=$_POST['almacenamientoArray'];
                            ?>
                            <input value="<?php echo $verificandoUsuariosActivosRetirados; ?>" name="almacenamientoArray" type="hidden">
                            <!-- END -->
                            <input name="nombreElaboro" value="<?php echo $elaboraUsuario; ?>" type="hidden"  >
                            <input name="nombreReviso" value="<?php echo $revisaUsuario; ?>" type="hidden"  >
                            <input name="nombreAprobo" value="<?php echo $apruebaUsuario; ?>" type="hidden"  >
                            
                            <input type="hidden" id="aprobado" name="radiobtnAprobado" value="aprobado"  required>
                            <!-- <label id="tituloAprobado"> Aprobado</label> -->
                            
                            <input style="display:none;" type="radio" id="rechazado" name="radiobtnAprobado" value="rechazado" >
                            <label style="display:none;" id="tituloRechazado"> Rechazado</label>
                        
                        </div>
                        
                    </div>
        
                 
                  
                  
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                <!--
                    <input type="hidden" name="radiobtnD" value="<?php //echo $radDispoDoc; ?>">
                    <button type="submit" name="actualiza" style="display:;" class="btn btn-info float-right">Actualizar >></button>
                    <input name="actualiza" value="<?php //echo $_POST['enviarIdDocumento'];?>" type="hidden">
                -->    
                    
                
                
               <?php
              /// preguntamos si el documento ya está en el listado maestro ara que no nos permita editar el documento
              $consultandoDocumentoPreguntaListadoMaestro=$mysqli->query("SELECT * FROM documento WHERE id='".$_POST['enviarIdDocumento']."' AND obsoleto='1' AND pre IS NULL ");
              $extraerConsultaDocumentoPreguntaListadoMaestro=$consultandoDocumentoPreguntaListadoMaestro->fetch_array(MYSQLI_ASSOC);
              
              if($extraerConsultaDocumentoPreguntaListadoMaestro['id'] != NULL){
              ?>
                        
                            <div class="modal-dialog">
                              <div class="modal-content bg-danger">
                                <div class="modal-body">
                                  <center>
                                    <p>El documento ya fue gestionado.</p>
                                  </center>
                                </div>
                                 <!-- END formulario para eliminar por el id -->
                              </div>
                            </div>
                    <span Onclick="window.location.href='crearDocumentoMasivoObsoleto'" class="btn btn-success float-left" >Cerrar</span>   
              <?php
              }else{
              ?>
                    <span Onclick="window.location.href='crearDocumentoMasivoObsoleto'" class="btn btn-success float-left" >Cerrar</span>
                    <span href="#" id="ocultarValidarFecha" class="btn btn-success float-right" onclick="funcionFormula()" >Validar fecha</span>
                    <div id="botonValidarCarga">
                    <button type="submit" name="actualiza" id="mostrarBotonFinalizar" style="display:none;" class="btn btn-info float-right ">Actualizar >></button>
                    </div>
                    
              <?php
              }
              ?>
                    <input name="actualiza" value="1" type="hidden">
                    
                    <style>
                                .preloader {
                                    width: 70px;
                                    height: 70px;
                                    border: 10px solid #eee;
                                    border-top: 10px solid #666;
                                    border-radius: 50%;
                                    animation-name: girar;
                                    animation-duration: 2s;
                                    animation-iteration-count: infinite;
                                    animation-timing-function: linear;
                                    }
                                    @keyframes girar {
                                    from {
                                        transform: rotate(0deg);
                                    }
                                    to {
                                        transform: rotate(360deg);
                                    }
                                    }
                            </style> 
                            <div id="cargando" class="preloader float-right" style="display:none;"></div>
                                <script>
                                   /// validamos si la fecha está bien digitada o no
                                    function funcionFormula(){ 
                                       //// capturamos las variables de las fechas
                                       fechaAprobacionPrimera = document.getElementById("primerafecha").value;
                                       fechaAprobacionSegunda = document.getElementById("segundafecha").value;
                                       fechaAprobacion = document.getElementById("terceraFecha").value;
                                       //// END
                                       
                                       /// validamos si la fecha de aprobación es menor que la fecha de elaboración y revisor
                                       if(fechaAprobacion < fechaAprobacionSegunda || fechaAprobacion < fechaAprobacionPrimera || fechaAprobacionSegunda < fechaAprobacionPrimera || fechaAprobacionPrimera == ''){
                                            if(fechaAprobacionSegunda < fechaAprobacionPrimera){
                                                //alert('La fecha de aprobación no puede ser menor a la fecha de revisión');
                                                 const Toast = Swal.mixin({
                                                  toast: true,
                                                  position: 'top-end',
                                                  showConfirmButton: false,
                                                  timer: 9000
                                                });
                                            
                                            
                                                Toast.fire({
                                                    type: 'warning',
                                                    title: ' La fecha de revisión no puede ser menor a la fecha de elaboración.'
                                                })
                                            }
                                            
                                            if(fechaAprobacion < fechaAprobacionPrimera){
                                                
                                                 const Toast = Swal.mixin({
                                                  toast: true,
                                                  position: 'top-end',
                                                  showConfirmButton: false,
                                                  timer: 9000
                                                });
                                            
                                            
                                                Toast.fire({
                                                    type: 'warning',
                                                    title: ' La fecha de aprobación no puede ser menor a la fecha de elaboración.'
                                                })
                                            }
                                            
                                            if(fechaAprobacion < fechaAprobacionSegunda){
                                                
                                                 const Toast = Swal.mixin({
                                                  toast: true,
                                                  position: 'top-end',
                                                  showConfirmButton: false,
                                                  timer: 9000
                                                });
                                            
                                            
                                                Toast.fire({
                                                    type: 'warning',
                                                    title: ' La fecha de aprobación no puede ser menor a la fecha de revisión.'
                                                })
                                            }
                                       }else{
                                            //// en caso que la fecha esté correcta nos ejecuta esta acción para activar el botón de manera automatica
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
                                            //// END
                                           
                                       }
                                       /// END
                                    }
                                    /// END  
                                </script>
                               
                                <!-- al momento que se ejecuta el script de manera automatica, acciona este botón para simular el click y poder habilitar el botón oculto -->
                                    <a href="#" id="action-button" style="display:none;" onclick="enviar()" >Mostrara botón</a>
                                <!-- END -->
                                
                                <!-- al momento de ejecutar la simulación del botón de las fechas esta función se ejecuta para mostrar el botón de finalizar -->
                                    <script>
                                        function enviar(){
                                            document.getElementById('mostrarBotonFinalizar').style.display = '';
                                            document.getElementById('ocultarValidarFecha').style.display = 'none';
                                            
                                            ///// montamos las fechas para que solo sean visuales y no nos deje modificarlas y habilitamos el input date 
                                            document.getElementById("mostrarPrimeraFecha").value = document.getElementById("primerafecha").value;
                                            document.getElementById('mostrarPrimeraFecha').style.display = '';
                                            
                                            document.getElementById("mostrarSegundaFecha").value = document.getElementById("segundafecha").value;
                                            document.getElementById('mostrarSegundaFecha').style.display = '';
                                            
                                            document.getElementById("mostrarSTercerFecha").value = document.getElementById("terceraFecha").value;
                                            document.getElementById('mostrarSTercerFecha').style.display = '';
                                            /// END
                                            
                                            ///// luego ocultamos la fecha original y enviamos los datos sin poder modificar 
                                            document.getElementById('primerafecha').style.display = 'none';
                                            document.getElementById('segundafecha').style.display = 'none';
                                            document.getElementById('terceraFecha').style.display = 'none';
                                            //// END
                                        }
                                    </script>
                                <!-- END -->
                </div>
             
            </div>
            </div>    

        <div class="col">
            </div>
            
           
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
<form>


<?php
    }else{ 
?>  <!--  -->
    <form  role="form" id="formCrearDoc" action="controlador/solicitudDocumentos/pruebaAlmacenamientoObsoleto" onsubmit="sendForm();  event.preventDefault(); " method="POST" enctype="multipart/form-data">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
               <!--<form role="form" action="controlador/documentos/controllerDocumentos" method="POST" enctype="multipart/form-data">
               controlador/solicitudDocumentos/controllerVigenteMasivo
               -->
               
                <div class="card-body">

                    <div class="row">
                        <!-- tipo de solicitud-->    
                                <input type="hidden" value="1" name="tipo" required>
                        <!-- END --> 
                        <div class="form-group col-sm-6">
                            <!--<label>Encargado:</label>
                            Activos
                            <input type="radio" id="encargadoSelec" name="validandoEncargados" required>
                            &nbsp;&nbsp;
                            Eliminados-->
                            <input type="hidden" id="encargadoSelecB" name="validandoEncargados" value="2" required> 
                            <!--
                            <select name="encargado" class="form-control" style="display:none;" id="mostrarSelectEncargado" >
                            <option value=""></option>
                                <?php /*
                                require_once'conexion/bd.php';
                                $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                                $resultado2=$mysqli->query("SELECT * FROM cargos ORDER BY nombreCargos ASC");
                    
                                while ($columna = mysqli_fetch_array( $resultado2 )) { ?>
                                <option value="<?php echo $columna['id_cargos']; ?>"><?php echo $columna['nombreCargos']; ?> </option>
                                <?php } */  ?>
                            </select>
                            -->

                            <input name="encargadoT" id="mostrarTextEncargado" value="Administrador" class="form-control" type="hidden" pattern="[A-Za-z0-9_- ]{1,90}" style="display:none;">

                            <script> //// validación para cambiar de proceso
                                $(document).ready(function(){
                                    $('#encargadoSelec').click(function(){ 
                                        document.getElementById('mostrarSelectEncargado').style.display = '';
                                        document.getElementById('mostrarTextEncargado').style.display = 'none';
                                    });
                                    $('#encargadoSelecB').click(function(){ 
                                        document.getElementById('mostrarSelectEncargado').style.display = 'none';
                                        document.getElementById('mostrarTextEncargado').style.display = '';
                                    });
                                });
                            </script>
                            
                        </div>
                        <!--
                        <div class="form-group col-sm-6" >
                      
                            <label for="upload-photo">Archivo Máx 10MB:</label>
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" class="custom-file-input" id="miInputEncargado" name="archivo"  >
                                <label class="custom-file-label" >Subir Archivo</label>
                                
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Subir</span>
                                </div>
                            </div>
                        </div>
                        -->
                    </div>


                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Nombre del documento: </label> <!--  este es el mismo nombre que se debe enviar el la solicitud de documento-->
                            <input type="text" class="form-control" name="nombreDocumento" placeholder="<?php echo $traerNombreSolicitud['nombreDocumento2'];?>" value="<?php echo $traerNombreSolicitud['nombreDocumento2'];?>" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250  || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Proceso: </label>
                            <!--
                            Activos
                            <input type="radio" id="procesosActivos" name="validandoProcesos" required>
                            &nbsp;&nbsp;
                            Eliminados
                            <input type="radio" id="procesosEliminados" name="validandoProcesos" required>

                            procesos activos -->
                            <?php
                                require_once'conexion/bd.php';
                               
                            ?>
                            <select type="text" class="form-control"  name="procesoA" id="idproceso" placeholder="Proceso"  style="display:;" required> <!--  id="procesosActivosSelect" -->
                               <!-- <option value=''>Seleccionar proceso</option> id="idproceso" -->
                                <option value=""></option>
                                <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT * FROM procesos  ORDER BY estado");  //id='".$traerNombreSolicitud['proceso']."'
                                while ($columna = mysqli_fetch_array( $resultado )) { 
                                    if($columna['estado'] == 'Eliminado'){
                                       // continue;
                                    }
                                
                                if($columna['estado'] == 'Eliminado'){
                                ?>
                                <option value="<?php echo $columna['id']; ?>" style="color:red;"><?php echo $columna['nombre'].' -- '.$columna['estado']; ?></option>
                                <?php
                                }else{
                                ?>
                                <option value="<?php echo $columna['id']; ?>" style="color:green;"><?php echo $columna['nombre'].' -- Activos'; ?></option>
                                <?php
                                }
                                    ?>
                                
                                
                                <?php }  ?>
                            </select>
                            <!--  procesos activos -->
                            <?php
                            /*
                            ?>
                            <select name="procesoB" class="form-control" style="display:none;" id="procesosEliminadoSelect">
                                <option value=""></option>
                                <?php
                               
                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $resultado=$mysqli->query("SELECT * FROM procesos WHERE estado='Eliminado' ORDER BY nombre ASC");
                                while ($columna = mysqli_fetch_array( $resultado )) { ?>
                                <option value="<?php echo $columna['id']; ?>"><?php echo $columna['nombre']; ?> </option>
                                <?php }  ?>
                            </select>
                            <?php
                            */
                            ?>
                            <!-- 
                                    Tener en cuenta el name= del proceso para validar el envio del dato del proceso para ver cual es el que ingresa
                            -->
                            <script> //// validación para cambiar de proceso
                                $(document).ready(function(){
                                    $('#procesosEliminados').click(function(){ 
                                        document.getElementById('procesosActivosSelect').style.display = 'none';
                                        document.getElementById('procesosEliminadoSelect').style.display = '';
                                    });
                                    $('#procesosActivos').click(function(){ 
                                        document.getElementById('procesosActivosSelect').style.display = '';
                                        document.getElementById('procesosEliminadoSelect').style.display = 'none';
                                    });
                                });
                            </script>


                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <?php
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT * FROM normatividad");
                            ?>
                            <label>Norma: </label>
                              <select class="duallistbox" name="norma[]" multiple>
                                <?php
                                    while ($columna = mysqli_fetch_array( $resultado )) { ?>
                                    <option value="<?php echo $columna['id']; ?>"><?php echo $columna['nombre']; ?> </option>
                                <?php }  ?>
                              </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Método de creación: </label><br>
                            <div class="custom-control custom-radio">
                              <input class="custom-control-input" type="radio" id="customRadio1" name="rad_metodo" value="documento" checked required>
                              <label for="customRadio1" class="custom-control-label">Documento (PDF, WORD, EXCEL, AUTOCAD)</label>
                            </div>
                            <!--
                            <div class="custom-control custom-radio">
                              <input class="custom-control-input" type="radio" id="customRadio2" name="rad_metodo" value="html" required>
                              <label for="customRadio2" class="custom-control-label">Edición HTML</label>
                            </div>
                            -->
                            <div><br>
                                <label>Tipo documento:</label>
                                <?php
                                    require_once'conexion/bd.php';
                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $resultado=$mysqli->query("SELECT * FROM tipoDocumento  ORDER BY nombre"); //WHERE id='".$traerNombreSolicitud['tipoDocumento']."'
                                ?>
                                <select type="text" class="form-control" id="idtipoDoc" name="tipoDoc" placeholder="" required>
                                   <!-- <option value=''>Seleccionar tipo documento</option> -->
                                    <?php
                                    while ($columna = mysqli_fetch_array( $resultado )) { ?>
                                    <option value="<?php echo $columna['id']; ?>"><?php echo $columna['nombre']; ?> </option>
                                    <?php }  ?>
                                </select>
                            </div>
                            
                            <div>
                                <br>
                                <label>Ubicación: </label>
                                <input type="text" class="form-control" name="ubicacion" value="Obsoleto" placeholder="Ubicación" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || event.charCode == 47)" required>
                            </div>
                        </div>

                    </div>
                    <label>Flujo usuarios</label>&nbsp;&nbsp;
                        
                            Retirados
                            <input type="radio" value="retiradosUsuarios" name="validandoUsuarios" id="usuariosRetirados" required >
                            &nbsp;&nbsp;
                            Activos
                            <input type="radio" value="activosUsuarios" name="validandoUsuarios" id="usuariosActivos"  required >
                            
                    <div class="row" >
                        <div class="form-group col-sm-6" id="activoElabora">
                           <label style="aling:left;">Quién elabora: </label>
                           
                            <input type="radio" id="rad_cargoE" name="radiobtnE" value="cargos" >
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioE" name="radiobtnE" value="usuarios" >
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoE[]" id="select_encargadoE" ></select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6" id="elaboraRetirado" style="display:none;">
                            <label style="aling:left;">Quién elabora: </label>
                            
                            <div class="select2-blue">
                                <input class="form-control" id="retiradoTextoE" placeholder="Ingrese elaborador..." name="select_encargadoEE" type="text" pattern="[A-Za-z0-9_- ]{1,90}"  onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                            </div>
                        </div>
                        <script> //// validación para elegir entre usuarios activos o usuarios retirados
                            $(document).ready(function(){
                                $('#usuariosRetirados').click(function(){
                                    document.getElementById('elaboraRetirado').style.display = '';
                                    document.getElementById("retiradoTextoE").setAttribute("required","any"); 
                                    document.getElementById("select_encargadoE").removeAttribute("required","any");
                                    document.getElementById('activoElabora').style.display = 'none';
                                });
                                $('#usuariosActivos').click(function(){
                                    document.getElementById('elaboraRetirado').style.display = 'none';
                                    document.getElementById("retiradoTextoE").removeAttribute("required","any");
                                    document.getElementById("select_encargadoE").setAttribute("required","any");
                                    document.getElementById('activoElabora').style.display = '';
                                });
                            });
                        </script>
                        <div class="form-group col-sm-6">
                            <label>Codificación:</label>
                            <!-- <label><input name="radCodificacion" id="rad_automatica" type='radio' value="automatico" required> Automática </label>
                            <br> -->
                            <label><input name="radCodificacion" id="rad_manual" type='radio' value="manual" checked required> Manual </label><br>
                        
                            <div id="codificacionManual" style="display:;"> <!-- none -->
                                
                                        <table class=""> 
                                            <thead>
                                                <tr>
                                                    <th>
                                                    <label>Versión: </label>
                                                    </th>
                                                    <th>
                                                    <input class="form-control"  name="versionDeclarada" id="id_version" type="number" min="1" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                                                    </th>
                                                    <th>
                                                    <label>Consecutivo: </label>
                                                    </th>
                                                    <th>
                                                    <input class="form-control"  name="consecutivoDeclarado" id="consecutivo" type="number" min="1" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                            
                                    
                            </div>
                        
                        </div>   
                    </div>
                    <br>
                    
                    
                    <label>Flujo usuarios</label>&nbsp;&nbsp;
                            Retirados
                            <input type="radio" value="retiradosUsuariosB" name="validandoUsuariosB"  id="usuariosRetiradosB"  required >
                            &nbsp;&nbsp;
                            Activos
                            <input type="radio" value="activosUsuariosB" name="validandoUsuariosB" id="usuariosActivosB"  required >
                    <div class="row">
                        <div class="form-group col-sm-6" id="revisaElabora">
                            <label>Quién revisa: </label>
                            
                            <input type="radio" id="rad_cargoR" name="radiobtnR" value="cargos" >
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioR" name="radiobtnR" value="usuarios" >
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoR[]" id="select_encargadoR" ></select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6" id="revisaRetirado" style="display:none;">
                            <label>Quién revisa: </label>
                            
                            
                            <div class="select2-blue">
                                <input class="form-control" id="retiradoTexto" placeholder="Ingrese revisor..."  name="select_encargadoRR" type="text" pattern="[A-Za-z0-9_- ]{1,90}" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250  || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" >
                            </div>
                        </div>
                        <script> //// validación para elegir entre usuarios activos o usuarios retirados
                            $(document).ready(function(){
                                $('#usuariosRetiradosB').click(function(){
                                    document.getElementById('revisaRetirado').style.display = '';
                                    document.getElementById("retiradoTexto").setAttribute("required","any"); 
                                    document.getElementById("select_encargadoR").removeAttribute("required","any");
                                    document.getElementById('revisaElabora').style.display = 'none';
                                });
                                $('#usuariosActivosB').click(function(){
                                    document.getElementById('revisaRetirado').style.display = 'none';
                                    document.getElementById("retiradoTexto").removeAttribute("required","any");
                                    document.getElementById("select_encargadoR").setAttribute("required","any");
                                    document.getElementById('revisaElabora').style.display = '';
                                });
                            });
                        </script>
                        
                    </div>
                    <br>
                    
                    <label>Flujo usuarios</label>&nbsp;&nbsp;
                            Retirados
                            <input type="radio" value="retiradosUsuariosC" name="validandoUsuariosC"  id="usuariosRetiradosC"  required >
                            &nbsp;&nbsp;
                            Activos
                            <input type="radio" value="activosUsuariosC" name="validandoUsuariosC"  id="usuariosActivosC"   required >
                    <div class="row">
                        <div class="form-group col-sm-6" id="apruebaActivo">
                            <label>Quién aprueba: </label>
                            
                           
                            <input type="radio" id="rad_cargoA" name="radiobtnA" value="cargos" >
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioA" name="radiobtnA" value="usuarios" >
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                               <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoA[]" id="select_encargadoA" ></select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6" id="apruebaRetirados" style="display:none;">
                            <label>Quién aprueba: </label>
                           
                            <div class="select2-blue">
                                <input class="form-control" id="retiradoTextoA" placeholder="Ingrese aprobador..." name="select_encargadoAA" type="text" pattern="[A-Za-z0-9_- ]{1,90}" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                            </div>
                        </div>
                        <script> //// validación para elegir entre usuarios activos o usuarios retirados
                            $(document).ready(function(){
                                $('#usuariosRetiradosC').click(function(){
                                    document.getElementById('apruebaRetirados').style.display = '';
                                    document.getElementById("retiradoTextoA").setAttribute("required","any"); 
                                    document.getElementById("select_encargadoA").removeAttribute("required","any");
                                    document.getElementById('apruebaActivo').style.display = 'none';
                                });
                                $('#usuariosActivosC').click(function(){
                                    document.getElementById('apruebaRetirados').style.display = 'none';
                                    document.getElementById("retiradoTextoA").removeAttribute("required","any");
                                    document.getElementById("select_encargadoA").setAttribute("required","any");
                                    document.getElementById('apruebaActivo').style.display = '';
                                });
                            });
                        </script>
                        
                        
                        
                         

                        
                    </div>

                 

                
                
              
        
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                    <input type="hidden" name="idSolicitud" value="<?php echo $idSolicitud;?>">   
                    <input type="hidden" name="rol" value="<?php echo $rol;?>">   
                    <input type="hidden" name="usuario" value="<?php echo $_SESSION["session_username"];?>">
                </div>
             
            </div>
            </div>    

        <div class="col">
            </div>
            
           
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
                      
  

    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
                <div class="card-body">
                    <div class="row">
                        
                       
                        
                        <?php
                            //if($metodo == "documento"){
                        ?>
                        <div class="form-group col-sm-6">
                            <label for="exampleInputFile">Importar documento PDF Máx 10MB</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="myInputPDF" name="archivopdf" accept=".pdf" required>
                                <label class="custom-file-label" for="exampleInputFile">Seleccionar archivo</label>
                              </div>
                            </div>
                            <script>
                                $('input[name="archivopdf"]').on('change', function(){
                                    var ext = $( this ).val().split('.').pop();
                                    if ($( this ).val() != '') {
                                      if(ext == "pdf"){
                                        
                                      }
                                      else
                                      {
                                        $( this ).val('');
                                        //alert("Extensión no permitida: " + ext);
                                        const Toast = Swal.mixin({
                                          toast: true,
                                          position: 'top-end',
                                          showConfirmButton: false,
                                          timer: 3000
                                        });
                                    
                                    
                                        Toast.fire({
                                            type: 'warning',
                                            title: ` Extensión no permitida`
                                        })
                                      }
                                    }
                                  });
                                </script>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="exampleInputFile">Importar documento editable (.docx,.xlsx,.dwg,.pptx Máx 10MB)</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="myInpuEditable" name="archivootro" accept=".xls,.xlsx,.docx,.doc,.dwg,.pptx" required>
                                <label class="custom-file-label" for="exampleInputFile">Seleccionar archivo</label>
                              </div>
                            </div>
                            <script>
                                $('input[name="archivootro"]').on('change', function(){
                                    var ext = $( this ).val().split('.').pop();
                                    if ($( this ).val() != '') {
                                      if(ext == "docx" || ext == "xls" || ext == "xlsx" || ext == "doc" || ext == "dwg" || ext == "pptx" ){
                                        
                                      }
                                      else
                                      {
                                        $( this ).val('');
                                        //alert("Extensión no permitida: " + ext);
                                        const Toast = Swal.mixin({
                                          toast: true,
                                          position: 'top-end',
                                          showConfirmButton: false,
                                          timer: 3000
                                        });
                                    
                                    
                                        Toast.fire({
                                            type: 'warning',
                                            title: ` Extensión no permitida`
                                        })
                                      }
                                    }
                                  });
                                </script>
                        </div>
                        <?php
                        // }
                        ?>
                        
                        
                        
                        <div class="form-group col-sm-6">
                            <?php
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT id, nombre FROM documentoExterno");
                            ?>
                            <label>Documentos externos: </label>
                              <select class="duallistbox" name="documentos_externos[]" multiple >
                                <?php
                                    while ($columna = mysqli_fetch_array( $resultado )) { ?>
                                    <option value="<?php echo $columna['id']; ?>"><?php echo $columna['nombre']; ?> </option>
                                <?php }  ?>
                              </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <?php
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT id, nombre, nombreN FROM definicion ORDER by nombre, nombreN ASC");
                            ?>
                            <label>Definiciones: </label>
                              <select class="duallistbox" name="definiciones[]" multiple >
                                  
                                  
                                <?php
                                    while ($columna = mysqli_fetch_array( $resultado )) {
                                        $id = $columna['id'];
                                        $nombre = $columna['nombre'];
                                        $nombreN =$columna['nombreN'];
                                       
                                        if($nombre != NULL){
                                            echo "<option value='$id' > $nombre</option>";
                                        }
                                                                           
                                    
                                    ?>
                                        
                                <?php }  ?>
                              </select>
                        </div>


                        <div class="form-group col-sm-6">
                            <label>Archivo en gestión: </label>
                            <input type="text" class="form-control" name="archivo_gestion" placeholder="Archivo en gestión" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                                <br>
                            <label>Archivo central: </label>
                            <input type="text" class="form-control" name="archivo_central" placeholder="Archivo central" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                                <br>
                            <label>Archivo histórico: </label>
                            <input type="text" class="form-control" name="archivo_historico" placeholder="Archivo histórico" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                            
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label>Disposición Documental: </label>
                            <textarea rows="3" class="form-control" name="diposicion_documental" placeholder="Disposición Documental" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required></textarea>
                            <br><br>
                            <label>Responsable de disposición: </label>
                            Activos
                                <input type="radio" id="usuariosActivosR" value="activosUsuariosResponsable" name="validandoUsuariosR"  required>
                                &nbsp;&nbsp;
                            Retirados
                                <input type="radio" id="usuariosRetiradosR" value="retiradosUsuariosResponsable" name="validandoUsuariosR" required>
                            <br>
                            
                            <div id="mostrarRetiradosR" style="display:none;">
                                <!--<input type="hidden" name="radiobtnD" value="cargos">-->
                                <div class="select2-blue" >
                                    <br>
                                    <input multiple="multiple" id="retiradoTextoEncargado" class="form-control" style="width: 100%;" name="select_encargadoD" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" >
                                </div>
                            </div>
                                
                            <div id="mostrarActivosR">
                                <input type="radio" id="rad_cargoD" name="radiobtnD" value="cargos">
                                <label for="cargo">Cargo</label>
                                <input type="radio" id="rad_usuarioD" name="radiobtnD" value="usuarios">
                                <label for="usuarios">Usuarios</label>
    
                                <div class="select2-blue" >
                                    <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoD[]" id="select_encargadoD" ></select>
                                </div>
                                
                            </div>
                            
                                 <script> //// validación para elegir entre usuarios activos o usuarios retirados
                                    $(document).ready(function(){
                                        $('#usuariosRetiradosR').click(function(){ 
                                            document.getElementById('mostrarRetiradosR').style.display = '';
                                            document.getElementById("retiradoTextoEncargado").setAttribute("required","any"); 
                                            document.getElementById("select_encargadoD").removeAttribute("required","any");
                                            document.getElementById('mostrarActivosR').style.display = 'none';
                                        });
                                        $('#usuariosActivosR').click(function(){ 
                                            document.getElementById('mostrarRetiradosR').style.display = 'none';
                                            document.getElementById("retiradoTextoEncargado").removeAttribute("required","any"); 
                                            document.getElementById("select_encargadoD").setAttribute("required","any");
                                            document.getElementById('mostrarActivosR').style.display = '';
                                        });
                                    });
                                </script>
                        </div>
                        
                        
                    </div>
                        
        
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                  
                    
                </div>
             
            </div>
            </div>    

        <div class="col">
            </div>
            
           
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
   
                   

    
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
               <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Meses para próxima revisión</label>
                            <input name="mesesRevision" type="number" min="1" max="24" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                        </div>
                         <div class="col-sm-12">
                               <center>
                                    <br>
                                    <p><h4>Control de Cambios</h4></p>
                                </center>
                             <?php
                           
                          
                                // ahora sacamos la información del último control de cambio realiado
                                $consultaControlCambios=$mysqli->query("SELECT * FROM  controlCambiosParametrizacion ");
                                $extraerControlCambios=$consultaControlCambios->fetch_array(MYSQLI_ASSOC);
                                $informacionDelTexto=$extraerControlCambios['informacion'];
                                
    
                           
                            // end
                            ?>
                            <input name="idAnteriorControlCambios" value="<?php echo $extraerIdSolicitud;?>" type="hidden">
                            <textarea name="editor1" required><?php echo $informacionDelTexto;?></textarea>
                        </div>              
                        <div class="form-group col-sm-12">
                            <label>Fecha de elaboración: </label>
                            <div class="input-group" style="width:;">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                <input type="date" id="primerafecha" name="fechaElaboracion" class="form-control float-right"  max="9999-12-31" required> 
                                <!-- este input es para mostrar la fecha sin dejarse modificar después de validar las fechas -->
                                    <input style="display:none;" type="date" id="mostrarPrimeraFecha"  class="form-control float-right"  required>
                                <!-- END -->
                            </div>
                            
                            <input class="form-control" name="controlCambios" placeholder="Comentario del elaborador..." onkeypress="return (event.charCode == 58 || event.charCode == 59 || (event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" >
                            <br>
                            <label>Fecha de revisión: </label>
                             
                            <div class="input-group" style="width:;">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                <input type="date" id="segundafecha" name="fechaRevision" class="form-control float-right" max="9999-12-31" required>
                                <!-- este input es para mostrar la fecha sin dejarse modificar después de validar las fechas -->
                                    <input style="display:none;" type="date" id="mostrarSegundaFecha"  class="form-control float-right"  max="9999-12-31"  required>
                                <!-- END -->
                            </div>
                            <input class="form-control" name="comentarioRevision" placeholder="Comentario del revisor..." onkeypress="return (event.charCode == 58 || event.charCode == 59 || (event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" >
                            <br>
                            
                             
                             <label>Fecha de aprobación: </label>
                            <div class="input-group" style="width:;">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                    <input type="date" id="terceraFecha" name="fechaAprobacion" class="form-control float-right" max="9999-12-31"required>
                                    <!-- este input es para mostrar la fecha sin dejarse modificar después de validar las fechas -->
                                        <input style="display:none;" type="date" id="mostrarSTercerFecha"  class="form-control float-right"  max="9999-12-31"  required>
                                    <!-- END -->
                            </div>
                            
                            <input class="form-control" name="comentarioAprobo" placeholder="Comentario del aprobador..." onkeypress="return ( event.charCode == 58 || event.charCode == 59 || (event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" >
                            <br>
                            <!--
                            <label>Control de cambios: </label>
                            <textarea rows="2" class="form-control" name="controlCambios" placeholder="Control de cambios" required></textarea>
                            <br>
                            -->
                            <!-- podemos enviar el tipo de flujo de usuarios para el almacenamiento -->
                            <?php
                                $verificandoUsuariosActivosRetirados=$_POST['almacenamientoArray'];
                            ?>
                            <input value="<?php echo $verificandoUsuariosActivosRetirados; ?>" name="almacenamientoArray" type="hidden">
                            <!-- END -->
                            <input name="nombreElaboro" value="<?php echo $elaboraUsuario; ?>" type="hidden" readonly >
                            <input name="nombreReviso" value="<?php echo $revisaUsuario; ?>" type="hidden" readonly >
                            <input name="nombreAprobo" value="<?php echo $apruebaUsuario; ?>" type="hidden" readonly >
                            
                            <input type="hidden" id="aprobado" name="radiobtnAprobado" value="aprobado" checked required>
                            <!-- <label id="tituloAprobado"> Aprobado</label> -->
                            
                            <input style="display:none;" type="radio" id="rechazado" name="radiobtnAprobado" value="rechazado" >
                            <label style="display:none;" id="tituloRechazado"> Rechazado</label>
                        
                        </div>
                        
                    </div>
        
                 
                  
                  
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                <!--
                    <input type="hidden" name="radiobtnD" value="<?php //echo $radDispoDoc; ?>">
                -->    
                    <span href="#" id="ocultarValidarFecha" class="btn btn-success float-right" onclick="funcionFormula()" >Validar fecha</span>
                    <div id="botonValidarCarga">
                        <button type="submit" name="agregarDocB" id="mostrarBotonFinalizar" style="display:none;" class="btn btn-success float-right ">Finalizar >></button>
                    </div>
                    <style>
                                .preloader {
                                    width: 70px;
                                    height: 70px;
                                    border: 10px solid #eee;
                                    border-top: 10px solid #666;
                                    border-radius: 50%;
                                    animation-name: girar;
                                    animation-duration: 2s;
                                    animation-iteration-count: infinite;
                                    animation-timing-function: linear;
                                    }
                                    @keyframes girar {
                                    from {
                                        transform: rotate(0deg);
                                    }
                                    to {
                                        transform: rotate(360deg);
                                    }
                                    }
                            </style> 
                            <div id="cargando" class="preloader float-right" style="display:none;"></div>
                            <!--
                            <script>
                                $(document).ready(function(){
                                    $('.validandoBtn').click(function(){
                                        document.getElementById('cargando').style.display = '';
                                        document.getElementById('mostrarBotonFinalizar').style.display = 'none';
                                    });
                                });
                            </script>
                            -->
                    <input name="agregarDocB" value="1" type="hidden">
                               
                                <script>
                                   /// validamos si la fecha está bien digitada o no
                                    function funcionFormula(){ 
                                       //// capturamos las variables de las fechas
                                       fechaAprobacionPrimera = document.getElementById("primerafecha").value;
                                       fechaAprobacionSegunda = document.getElementById("segundafecha").value;
                                       fechaAprobacion = document.getElementById("terceraFecha").value;
                                       //// END
                                       
                                       /// validamos si la fecha de aprobación es menor que la fecha de elaboración y revisor
                                       if(fechaAprobacion < fechaAprobacionSegunda || fechaAprobacion < fechaAprobacionPrimera || fechaAprobacionSegunda < fechaAprobacionPrimera || fechaAprobacionPrimera == ''){
                                            if(fechaAprobacionSegunda < fechaAprobacionPrimera){
                                                //alert('La fecha de aprobación no puede ser menor a la fecha de revisión');
                                                 const Toast = Swal.mixin({
                                                  toast: true,
                                                  position: 'top-end',
                                                  showConfirmButton: false,
                                                  timer: 9000
                                                });
                                            
                                            
                                                Toast.fire({
                                                    type: 'warning',
                                                    title: ' La fecha de revisión no puede ser menor a la fecha de elaboración.'
                                                })
                                            }
                                            
                                            if(fechaAprobacion < fechaAprobacionPrimera){
                                                
                                                 const Toast = Swal.mixin({
                                                  toast: true,
                                                  position: 'top-end',
                                                  showConfirmButton: false,
                                                  timer: 9000
                                                });
                                            
                                            
                                                Toast.fire({
                                                    type: 'warning',
                                                    title: ' La fecha de aprobación no puede ser menor a la fecha de elaboración.'
                                                })
                                            }
                                            
                                            if(fechaAprobacion < fechaAprobacionSegunda){
                                                
                                                 const Toast = Swal.mixin({
                                                  toast: true,
                                                  position: 'top-end',
                                                  showConfirmButton: false,
                                                  timer: 9000
                                                });
                                            
                                            
                                                Toast.fire({
                                                    type: 'warning',
                                                    title: ' La fecha de aprobación no puede ser menor a la fecha de revisión.'
                                                })
                                            }
                                       }else{
                                            //// en caso que la fecha esté correcta nos ejecuta esta acción para activar el botón de manera automatica
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
                                            //// END
                                           
                                       }
                                       /// END
                                    }
                                    /// END  
                                </script>
                               
                                <!-- al momento que se ejecuta el script de manera automatica, acciona este botón para simular el click y poder habilitar el botón oculto -->
                                    <a href="#" id="action-button" style="display:none;" onclick="enviar()" >Mostrara botón</a>
                                <!-- END -->
                                
                                <!-- al momento de ejecutar la simulación del botón de las fechas esta función se ejecuta para mostrar el botón de finalizar -->
                                    <script>
                                        function enviar(){
                                            document.getElementById('mostrarBotonFinalizar').style.display = '';
                                            document.getElementById('ocultarValidarFecha').style.display = 'none';
                                            
                                            ///// montamos las fechas para que solo sean visuales y no nos deje modificarlas y habilitamos el input date 
                                            document.getElementById("mostrarPrimeraFecha").value = document.getElementById("primerafecha").value;
                                            document.getElementById('mostrarPrimeraFecha').style.display = '';
                                            
                                            document.getElementById("mostrarSegundaFecha").value = document.getElementById("segundafecha").value;
                                            document.getElementById('mostrarSegundaFecha').style.display = '';
                                            
                                            document.getElementById("mostrarSTercerFecha").value = document.getElementById("terceraFecha").value;
                                            document.getElementById('mostrarSTercerFecha').style.display = '';
                                            /// END
                                            
                                            ///// luego ocultamos la fecha original y enviamos los datos sin poder modificar 
                                            document.getElementById('primerafecha').style.display = 'none';
                                            document.getElementById('segundafecha').style.display = 'none';
                                            document.getElementById('terceraFecha').style.display = 'none';
                                            //// END
                                        }
                                    </script>
                                <!-- END -->
                </div>
             
            </div>
            </div>    

        <div class="col">
            </div>
            
           
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    
     
    
    </form>

<?php
    }
}
?>    
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
<!--Ckeditor-->
<script src="ckeditor5/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'editor1' );
</script>
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>

<script>
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
</script>
<!-- Select2 -->
<script src="../plugins/select2/js/select2.full.min.js"></script>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>
<!--Select dinamico-->
<script>
    $(document).ready(function(){
        $('#rad_cargoE').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoE").html(data);
            }); 
        });
        $('#rad_usuarioE').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoE").html(data);
            }); 
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoR').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoR").html(data);
            }); 
        });
        $('#rad_usuarioR').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoR").html(data);
            }); 
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoA').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoA").html(data);
            }); 
        });
        $('#rad_usuarioA').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoA").html(data);
            }); 
        });
    });
</script>
<!--Select dinamico-->
<script>
    $(document).ready(function(){
        $('#rad_cargoD').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoD").html(data);
            }); 
        });
        $('#rad_usuarioD').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoD").html(data);
            }); 
        });
    });
</script>
<!--Oculta div versionamiento-->
<script>
    $(document).ready(function(){
        $('#rad_manual').click(function(){
            document.getElementById('codificacionManual').style.display = '';
            document.getElementById("id_version").setAttribute("required","any");
            document.getElementById("consecutivo").setAttribute("required","any");
            document.getElementById("idDocumento").setAttribute("required","any");
        });
        $('#rad_automatica').click(function(){
            document.getElementById('codificacionManual').style.display = 'none';
            document.getElementById("id_version").removeAttribute("required","any");
            document.getElementById("consecutivo").removeAttribute("required","any");
            document.getElementById("idDocumento").removeAttribute("required","any");
        });
    });
</script>
<!-- script que valida version y consecutivo -->
<script>
         enviando = false; //Obligaremos a entrar el if en el primer submit
    
        function checkSubmit() {
            if (!enviando) {
        		enviando= true;
        		return true;
            } else {
                //Si llega hasta aca significa que pulsaron 2 veces el boton submit
                alert("El formulario ya se esta enviando");
                return false;
            }
        }
</script>
    
<script>
// validación consecutivo
function sendForm(){
    //alert("formulario");
    
    var idProceso = $('#idproceso').val();
    var idTipoDocumento = $('#idtipoDoc').val();
    var consecutivo = $('#consecutivo').val();
    var idDocumento = $('#idDocumento').val();
    var id_version = $('#id_version').val();
    var valido = '';
    
    //alert(idProceso);
    //alert(idTipoDocumento);
    //alert(consecutivo);
    //alert(idDocumento);
    //alert(id_version);
    
    $.post("validaVersionamientoC.php", { consecutivo: consecutivo, idProceso: idProceso, idTipoDocumento: idTipoDocumento, idDocumento : idDocumento, id_version : id_version }, function(data){
        valido = data;
        //alert("ENTRO A LA FUNCION"+valido);
        if(valido == "si"){
            //alert("Consecutivo no valido.");
            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000
            });
            Toast.fire({
            type: 'warning',
            title: ' Consecutivo no valido.'
            })
        	return false;
        }else{ //alert("registra");
            
            document.getElementById("formCrearDoc").submit(); 
            
                                $(document).ready(function(){ //alert("Validando");
                                    //$('mostrarBotonFinalizar').click(function(){ alert("ValidandoB");
                                        document.getElementById('cargando').style.display = '';
                                        document.getElementById('botonValidarCarga').style.display = 'none';
                                        //alert("Saliendo validando");
                                    //});
                                }); 
        }
        
    }); 

}
    
</script>
<!-- Traer los Json de elaborador, revisor y aprobador cuando se edita el documento-->
<script>
    $(document).ready(function(){
        $('#rad_cargoE').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentosActualizar.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoE").html(data);
            }); 
        });
        $('#rad_usuarioE').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentosActualizar.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoE").html(data);
            }); 
        });
        

        var radios = document.getElementsByName('radiobtnE');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idDocumento").value;
            var grupo = radios[i].value;
            var radElaborador = "radElaborador";
            
            //alert(rad_post);
            
            $.post("selectDocumentosActualizar.php", { rad_post: rad_post, grupo: grupo, radElaborador: radElaborador}, function(data){
                $("#select_encargadoE").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
       
        
    });
    $(document).ready(function(){
        $('#rad_cargoR').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentosActualizar.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoR").html(data);
            }); 
        });
        $('#rad_usuarioR').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentosActualizar.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoR").html(data);
            }); 
        });
        

        var radios = document.getElementsByName('radiobtnR');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idDocumento").value;
            var grupo = radios[i].value;
            var radRevisor = "radRevisor";
            
            //alert(rad_post);
            
            $.post("selectDocumentosActualizar.php", { rad_post: rad_post, grupo: grupo, radRevisor: radRevisor}, function(data){
                $("#select_encargadoR").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
       
        
    });
    $(document).ready(function(){
        $('#rad_cargoA').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentosActualizar.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoA").html(data);
            }); 
        });
        $('#rad_usuarioA').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentosActualizar.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoA").html(data);
            }); 
        });
        

        var radios = document.getElementsByName('radiobtnA');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idDocumento").value;
            var grupo = radios[i].value;
            var radAprobador = "radAprobador";
            
            //alert(rad_post);
            //alert(grupo);
            //alert(radAprobador);
            $.post("selectDocumentosActualizar.php", { rad_post: rad_post, grupo: grupo, radAprobador: radAprobador}, function(data){
                $("#select_encargadoA").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
       
        
    });
    $(document).ready(function(){
        $('#rad_cargoD').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentosActualizar.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoD").html(data);
            }); 
        });
        $('#rad_usuarioD').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentosActualizar.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoD").html(data);
            }); 
        });
        

        var radios = document.getElementsByName('radiobtnD');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idDocumento").value;
            var grupo = radios[i].value;
            var responsableDisposicion = "responsableDisposicion";
            
            //alert(rad_post);
            
            $.post("selectDocumentosActualizar.php", { rad_post: rad_post, grupo: grupo, responsableDisposicion: responsableDisposicion}, function(data){
                $("#select_encargadoD").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
       
        
    });
</script>
<!-- END -->
<!-- SweetAlert2 -->
<link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<script>
    const MAXIMO_TAMANIO_BYTES = 11000000; // 1MB = 1 millón de bytes



    // Obtener referencia al elemento
    const $myInputPDF = document.querySelector("#myInputPDF");

    $myInputPDF.addEventListener("change", function () {
        // si no hay archivos, regresamos
        if (this.files.length <= 0) return;

        // Validamos el primer archivo únicamente
        const archivo = this.files[0];
        if (archivo.size > MAXIMO_TAMANIO_BYTES) {
            const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
            //alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
            });
        
        
            Toast.fire({
                type: 'warning',
                title: ` El tamaño máximo del archivo es de 10 MB`
            })
            // Limpiar
            $myInputPDF.value = "";
        } else {
            //alert(`alerta`);
            // Validación asada. Envía el formulario o haz lo que tengas que hacer
        }
    });


// myInpuEditable

   // Obtener referencia al elemento
   const $myInpuEditable = document.querySelector("#myInpuEditable");

$myInpuEditable.addEventListener("change", function () {
    // si no hay archivos, regresamos
    if (this.files.length <= 0) return;

    // Validamos el primer archivo únicamente
    const archivo = this.files[0];
    if (archivo.size > MAXIMO_TAMANIO_BYTES) {
        const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
        //alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
        const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
        });
    
    
        Toast.fire({
            type: 'warning',
            title: ` El tamaño máximo del archivo es de 10 MB`
        })
        // Limpiar
        $myInpuEditable.value = "";
    } else {
        // Validación asada. Envía el formulario o haz lo que tengas que hacer
    }
});
</script>
<?php
/// validaciones de alertas
$validacionAgregarD=$_POST['validacionAgregarD'];
$validacionExiste=$_POST['validacionExiste'];
$validacionAgregar=$_POST['validacionAgregar'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];
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
    if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' No se pudo cargar el archivo con Exito.'
        })
    <?php
    }
    
    if($validacionAgregar == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: 'Proceda a asignar elaborador, revisor y aprobador.'
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
    
    if($validacionAgregarD == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: ' Documento registrado en el módulo de obsoleto.'
        })
    <?php
    }
    
    if($_POST['alertaConsecutivoGestionado'] == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El documento ya fue gestionado.'
        })
    <?php
    }
    
    
    if(isset($_POST['cerrandoNo'])){
        $preguntaVigentePreNull=$mysqli->query("SELECT * FROM documento WHERE id='".$_POST['idDocumento']."' AND obsoleto='1' AND pre IS NULL ");
        $respuestaPreguntaVigente=$preguntaVigentePreNull->fetch_array(MYSQLI_ASSOC);
    
        if($respuestaPreguntaVigente['id'] != NULL){
            ?>
                Toast.fire({
                    type: 'warning',
                    title: ' El documento ya fue gestionado.'
                })
            <?php
        }
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