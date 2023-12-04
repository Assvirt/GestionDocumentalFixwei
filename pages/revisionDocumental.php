<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
//require_once 'inactividad.php';
require_once 'conexion/bd.php';
$cargoID = $_SESSION['session_cargo'];

//////////////////////PERMISOS////////////////////////

$formulario = 'revisionDoc'; //aqui se cambia el nombre del formulario

require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////

error_reporting(E_ERROR);
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Revisión documental</title>
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
            <h1>Revisión documental</h1>
            <h6>Gestione la revisión de los documentos controlados.</h6><br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Revisión documental</li>
            </ol>
          </div>
        </div>
        <div>
            <?php
            //si tiene permiso de insertar , se muestran los botones de agregar, importar y demas
                if($visibleI == TRUE){
            ?>
            <div class="row">
            <!--
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="solicitudDocumentos"><font color="white"><i class="fas fa-plus-square"></i> Nueva Versión</font></a></button>
            </div>
            
               
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/listadoMaestro'"><font color="white"><i class="fas fa-download"></i> Exportar</font></button>
            </div>
            -->
            <div class="col-sm">
                
            </div> 
            <div class="col-sm">
                
            </div>

            <div class="col-sm">
                
            </div>
            <div class="col-sm">
                
            </div>
            </div>
            <?php }else{?> 
            <div class="row">
                <div class="col-sm">
                    <form action="exportacion/revisionDocumental" method="POST" enctype="multipart/form-data">
                        <input name="idCargo" type="hidden" value="<?php echo $cargo;?>" readonly required>
                    <button type="submit" class="btn btn-block btn-warning btn-sm" ><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
                    </form>
                </div>
               
                <?php
                    $preguntandoParametroCorreo=$mysqli->query("SELECT * FROM documentoRevision ");
                    $extrerPreguntaParametroCorreo=$preguntandoParametroCorreo->fetch_array(MYSQLI_ASSOC);
                if($root == 1){
                ?> 
                <div class="col-sm">
                <button style="display:none;" type="button" class="btn btn-block btn-info btn-sm" data-toggle="modal" data-target="#modal-carpeta"><font color="white"><i class="fas fa-plus-square"></i> Notificación</font></button>
                 <!--Modals-->
                <div class="modal fade" id="modal-carpeta">
                    <div class="modal-dialog">
                      <div class="modal-content">
                          <form action="controlador/revisionDocumental/notificacion" method="POST">
                            <div class="modal-header">
                              <h4 class="modal-title"></h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            
                            <div class="modal-body">
                              <div class="form-group ">
                                <label>Autorizados para notificación: </label><br>
                                    <?php
                                    /// validamos si existe un cargo, usuario o grupo seleccionado
                                    if($extrerPreguntaParametroCorreo['quien'] == 'cargo'){
                                        $displayCargo='';
                                        $checkedCargo='checked';
                                    }else{
                                        $displayCargo='none';
                                        $checkedCargo='';
                                    }
                                    if($extrerPreguntaParametroCorreo['quien'] == 'usuario'){
                                        $displayUsuario='';
                                        $checkedUsuario='checked';
                                    }else{
                                        $displayUsuario='none';
                                        $checkedUsuario='';
                                    }
                                    if($extrerPreguntaParametroCorreo['quien'] == 'grupo'){
                                        $displayGrupo='';
                                        $checkedGrupo='checked';
                                    }else{
                                        $displayGrupo='none';
                                        $checkedGrupo='';
                                    }
                                    
                                    ?>
                                    <input type="radio" id="rad_cargoAut" name="radiobtnAut" value="cargo" <?php echo $checkedCargo;?> required>
                                    <label for="cargo">Cargo</label>&nbsp;&nbsp;
                                    <input type="radio" id="rad_usuarioAut" name="radiobtnAut" value="usuario" <?php echo $checkedUsuario;?> required>
                                    <label for="usuarios">Usuarios</label>&nbsp;&nbsp;
                                    <input type="radio" id="rad_grupoAut" name="radiobtnAut" value="grupo" <?php echo $checkedGrupo;?> required>
                                    <label for="grupos">Grupos</label>
                                    
                                    <div class="select2-blue" id="listarCargos" required style="display:<?php echo $displayCargo;?>;" >
                                        
                                        <label></label>
                                        
                                        <?php
                                        $idVisualValidandoCargos = json_decode($extrerPreguntaParametroCorreo["responsable"]);
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $consultaCargos=$mysqli->query("SELECT * FROM cargos order by nombreCargos ASC");
                                        ?>
                                        <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar..." style="width: 100%;" name="select_encargadoAut[]"  >
                                            <?php
                                            while($extraerCargos=$consultaCargos->fetch_array()){
                                                if($extrerPreguntaParametroCorreo['quien'] == 'cargo'){
                                                    if(in_array($extraerCargos['id_cargos'],$idVisualValidandoCargos)){
                                                        $selectCargos = "selected";
                                                    }else{
                                                        $selectCargos = '';
                                                    }
                                                }
                                            ?>
                                            <option value="<?php echo $extraerCargos['id_cargos']; ?>" <?php echo $selectCargos; ?> ><?php echo $extraerCargos['nombreCargos']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="select2-blue" id="listarUsuarios" style="display:<?php echo $displayUsuario;?>;">
                                        
                                        <label></label>
                                       
                                        <?php
                                        $idVisualValidandoUsuarios = json_decode($extrerPreguntaParametroCorreo["responsable"]);
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $consultaCargos=$mysqli->query("SELECT * FROM usuario Order by nombres ASC");
                                        ?>
                                        <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar..." style="width: 100%;" name="select_encargadoAutB[]"  >
                                            <?php
                                            while($extraerCargos=$consultaCargos->fetch_array()){
                                                if($extrerPreguntaParametroCorreo['quien'] == 'usuario'){
                                                    if(in_array($extraerCargos['id'],$idVisualValidandoUsuarios)){
                                                        $selectUsuario = "selected";
                                                    }else{
                                                        $selectUsuario = '';
                                                    }
                                                }
                                                
                                            ?>
                                            <option value="<?php echo $extraerCargos['id']; ?>" <?php echo $selectUsuario; ?> ><?php echo $extraerCargos['nombres'].' '.$extraerCargos['apellidos']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="select2-blue" id="listarGrupos" style="display:<?php echo $displayGrupo;?>;">
                                        
                                        <label></label>
                                        
                                        <?php
                                        $idVisualValidandoGrupos = json_decode($extrerPreguntaParametroCorreo["responsable"]);
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $consultaGrupo=$mysqli->query("SELECT * FROM grupo Order by nombre ASC");
                                        ?>
                                        <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar..." style="width: 100%;" name="select_encargadoAutC[]"  >
                                            <?php
                                            while($extraerGrupo=$consultaGrupo->fetch_array()){
                                                if($extrerPreguntaParametroCorreo['quien'] == 'grupo'){
                                                    if(in_array($extraerGrupo['id'],$idVisualValidandoGrupos)){
                                                        $selectGrupo = "selected";
                                                    }else{
                                                        $selectGrupo = '';
                                                    }
                                                }
                                            ?>
                                            <option value="<?php echo $extraerGrupo['id']; ?>" <?php echo $selectGrupo; ?> ><?php echo $extraerGrupo['nombre']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                              </div>
        
                            </div>
                           
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                              <button type="submit" name="crearSubCarpeta" class="btn btn-primary">Guardar</button>
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
                }
                
                // preguntamos si ya existe un parametro
                if($extrerPreguntaParametroCorreo['quien'] != NULL){
                    
                    if($root == 1){
                    ?>
                    <div class="col-sm"></div>
                    <?php
                    }else{
                    ?>
                    <div class="col-sm"></div>
                    <div class="col-sm"></div>
                    <?php
                    }
                
                }else{
                ?>
                <div class="col-sm">
                    <div class="form-group col-md" style="z-index: 10;position: absolute;top: -150px;left: 2px;"> <!-- z-index: 10;top:-190px;margin-left:5%; -->
                    <center>
                        <div class="modal-dialog">
                            <div class="modal-content bg-danger">
                                <div class="modal-header">
                                    <h4 class="modal-title">Alerta</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Contacte al administrador para <br> definir la notificación.</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                </div>
                            </div>
                        </div>
                    </center>
                    </div>
                </div>
                <?php
                }
                ?>
                <div class="col-sm"></div>
                
            </div>
            <?php }//si no, solo el de exportar?>
        </div>
      </div><!-- /.container-fluid -->
    </section>

            <!-- parametrizar el envio de correo de calidad-->
            
               
             
            <!-- -->


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>Versión</th>
                      <th>Código</th>
                      <th>Nombre</th>
                      <th>Tipo</th>
                      <th>Proceso</th>
                      <th>Implementación</th>
                      <th>Próxima fecha revisión</th>
                      <th>Meses</th>
                      <th>Estado</th>
                      <th>Trazabilidad</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    require 'controlador/usuarios/libreria/PHPMailerAutoload.php';
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $data = $mysqli->query("SELECT * FROM documento WHERE vigente = 1 AND pre IS NULL ORDER BY codificacion ASC")or die(mysqli_error());
                    //SELECT * FROM documento WHERE vigente = 1 AND revisado = 0 AND pre IS NULL ORDER BY codificacion ASC
                    while($row = $data->fetch_assoc()){
                        
                        /// parametro de prueba de correo
                        //if($row['id'] == '157'){
                            
                        //}else{
                        //    continue;
                        //}
                        
                         
                        $idProceso2 = $row['proceso'];
                        
                        
                        $dataSol = $mysqli->query("SELECT * FROM procesos WHERE id = '$idProceso2'")or die(mysqli_error());
                        $datosSol = $dataSol->fetch_assoc();
                        $encargadoSolicitud = json_decode($datosSol['duenoProceso']);
                        $longitud = count($encargadoSolicitud);
                        
                         if($datosSol['importacion'] == 1){
                            for($i=0; $i<$longitud; $i++){ 
                                //saco el valor de cada elemento
                                $queryNombres = $mysqli->query("SELECT * FROM cargos WHERE nombreCargos LIKE '%$encargadoSolicitud[$i]%' ");
                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                
                                $encargadoSolicitud=$nombres['id_cargos'];
                                // echo '<td>S'.$encargadoSolicitud.'</td>';
                            
                            }
                         }else{
                            for($i=0; $i<$longitud; $i++){ 
                                //saco el valor de cada elemento
                                $queryNombres = $mysqli->query("SELECT * FROM cargos WHERE id_cargos LIKE '%$encargadoSolicitud[$i]%' ");
                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                
                                $encargadoSolicitud=$nombres['id_cargos'];
                                // echo '<td>N'.$encargadoSolicitud.'</td>';
                            
                            } 
                         }
                        //print_r($encargadoSolicitud);
                        
                        
                        
                        if($cargo == $encargadoSolicitud){ 
                           
                        }else{
                            //continue;
                        }
                       
                        
                        $mesesRevision = $row['mesesRevision'];
                        
                        if($row['ultimaFechaRevision'] == NULL){
                            
                            $fechaAprobado = date("d-m-Y", strtotime($row['fechaAprobado']));
                            /*Calculo fecha de revision*/
                            $fechaRevisar = date("d-m-Y",strtotime($fechaAprobado."+ $mesesRevision month"));
                            
                        }else{
                            $fechaUltimaRevision = $row['ultimaFechaRevision'];
                            
                            $fechaRevisar = date("d-m-Y",strtotime($fechaUltimaRevision."+ $mesesRevision month"));
                        }
                        
                       
                        
                         echo"<tr>";    
                       
                         echo" <td style='text-align: justify;'>".$row['version']."</td>";
                         echo" <td style='text-align: justify;'>".$row['codificacion']."</td>";
                         echo" <td style='text-align: justify;'>".$row['nombres']."</td>";
                         $tipo = $row['tipo_documento'];
                         $acentos = $mysqli->query("SET NAMES 'utf8'");
                         $nombreTipoDocumento = $mysqli->query("SELECT * FROM tipoDocumento WHERE id ='$tipo'")or die(mysqli_error());
                         $colu = $nombreTipoDocumento->fetch_array(MYSQLI_ASSOC);
                         $nombreT = $colu['nombre'];
                         echo" <td style='text-align: justify;'>".$nombreT."</td>";
                         $proceso =  $row['proceso'];
                         $acentos = $mysqli->query("SET NAMES 'utf8'");
                         $nombreProceso = $mysqli->query("SELECT * FROM procesos WHERE id ='$proceso'")or die(mysqli_error());
                         $col3 = $nombreProceso->fetch_array(MYSQLI_ASSOC);
                         $nombreP = $col3['nombre'];
                         echo" <td style='text-align: justify;'>".$nombreP."</td>";
                         
                         echo" <td style='text-align: justify;'>".substr($row['fechaAprobado'],0,-8)."</td>"; //$row['fechaAprobado']
                          
                          date_default_timezone_set("America/Bogota");
                             'Fecha inicial: '.$fechainicial = substr($row['fechaAprobado'],0,-8);
                             '<br>Fecha actual: '.$fechaactual = date("Y-m-d");
                            
                                           
                                          
                             '<br>Meses: '.$preguntandoMeses=$row['mesesRevision'];
                            if($preguntandoMeses == 1){
                                 $tiempoRespuesta ='30';//$row['tiempoRespuesta'];
                            }else{
                                 $tiempoRespuesta =30*$row['mesesRevision'];//$row['tiempoRespuesta'];
                            }
                           
                             '<br>Cantidad días: '.$tiempoRespuesta;
                            
                              '<br>Fecha validar: '.$fechaRestar = date("Y-m-d",strtotime($fechainicial."+ ".$tiempoRespuesta." days")); 
                            
                         echo"<td style='text-align: justify;' >".$fechaRestar."</td>"; // $fechaRevisar --$mesesRevision    
                         
                        $idDocumento=$row['id'];
                        $validarActualizacion=$mysqli->query("SELECT * FROM `solicitudDocumentos` WHERE tipoSolicitud=2 AND proceso='$idProceso2' AND tipoDocumento='$tipo' AND nombreDocumento='$idDocumento' AND estado IS NULL");
                        $extraer_validarActualizacion=$validarActualizacion->fetch_array(MYSQLI_ASSOC);
                        
                        echo "<td style='text-align: justify;' >";
                        
                            echo $preguntandoMeses; //.'<br>Cantidad de días '.$tiempoRespuesta;
                        
                        echo "</td>";
                        
                        if($extraer_validarActualizacion['id'] != NULL){
                            echo"<td style='text-align: justify;' >En revisión</td>";
                        }else{
                            
                            $preguntaDocumento=$mysqli->query("SELECT id,vigente,revisado FROM documento WHERE id='$idDocumento' ");
                            $respuestaDocumento=$preguntaDocumento->fetch_array(MYSQLI_ASSOC);
                            '<br>vigente: '.$respuestaDocumento['vigente'];
                            '<br>revisado: '.$respuestaDocumento['revisado'];
                            if($respuestaDocumento['vigente'] == '1' && $respuestaDocumento['revisado'] == '1'){
                                echo"<td style='text-align: justify;' >En revisión</td>";
                            }else{
                                echo"<td style='text-align: justify;' ></td>";
                            }
                            
                        }
                         
                         
                         echo"<td>";
                                echo"<form action='revisarDocumento' method='POST'>";
                                        echo"<input type='hidden' name='idDocumento' value='".$row['id']."'>";
                                        echo"<input type='hidden' name='idSolicitud' value='".$row['id_solicitud']."'>";
                                        echo"<button type='submit' class='btn btn-block btn-warning btn-sm'><i class='fas fa-eye'></i> Trazabilidad</button>";
                                    
                                echo"</form>";
                         echo"</td>";  
                          
                          
                          
                         echo '<td>';
                           
                            // se traslada la validación un poco más arriba para llevar la fecha correcta
                            
                                        /// atrapamos el filtro de la fecha, desde hasta
                                           $datetime1 = new DateTime($fechainicial);
                                           $datetime2 = new DateTime($fechaRestar); //$indicadorHasta
                                           // END
                                           
                                           // sacamos el intervalo para la diferencia entre meses
                                           $interval = date_diff($datetime1, $datetime2);
                                            '<br>Diferencia entre meses: '.$enviarIntervalo=$interval->format('%m months');
                                           
                                          
                            
                            
                            $datetime1 = date_create($fechaRestar);
                            $datetime2 = date_create($fechaactual);
                            $contador = date_diff($datetime1, $datetime2);
                            $differenceFormat = '%a';
                            
                            
                             '<br>Contador: '.$contadorDíasNotificacion=$contador->format($differenceFormat);
                            $contadorDíasNotificacion=ABS($contadorDíasNotificacion-1);
                            //if($fechaRestar > $fechaactual){
                            
                            if($contadorDíasNotificacion > '30' ){
                                 '<br>Sin avisar<br>';
                                //echo $contador->format($differenceFormat);
                            }else{   '<br>Avisar';
                                 $row['id'];
                                
                                //// preguntamos si debe enviar correo o no
                                $preguntandoCorreo=$mysqli->query("SELECT * FROM documento WHERE id='".$row['id']."' ");
                                $traerPreguntaCorreo=$preguntandoCorreo->fetch_array(MYSQLI_ASSOC);
                                
                                if($traerPreguntaCorreo['revisionDocumentalCorreo'] == 1){
                                    
                                }else{
                                    ///// bloqueamos el envio de correo despues del primer aviso
                                    $mysqli->query("UPDATE documento SET revisionDocumentalCorreo='1' WHERE id ='".$row['id']."' ");
                                    //// end
                                         '<br>Debe avisar<br>';
                                    $consultamosSolicitud=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='".$row['id_solicitud']."' ");
                                    $extraerSolicitudConsultaConsultamosSolicitud=$consultamosSolicitud->fetch_array(MYSQLI_ASSOC);
                                    $tipoSolicitud=$extraerSolicitudConsultaConsultamosSolicitud['tipoSolicitud'];
                                      
                                    /// consultamos el proceso para sacar los lideres de procesos y notificarlos
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $consultamosProceso=$mysqli->query("SELECT * FROM procesos WHERE id='$proceso' ");
                                        $extraerConsultaProceso=$consultamosProceso->fetch_array(MYSQLI_ASSOC);
                                            //// vamos a imprimir el dueño de proceso
                                            $array = json_decode(($extraerConsultaProceso['duenoProceso']));
                                            //var_dump($array);
                                            $longitud = count($array);
                                           
                                            if($extraerConsultaProceso['importacion'] == 1 ){ 
                                                 'entra al A';
                                                for($i=0; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                         'Dato: '.$array[$i];  '<br>';
                                                           
                                                        $queryNombresCargos = $mysqli->query("SELECT * FROM cargos WHERE nombreCargos = '$array[$i]' ");
                                                        $nombresCargos = $queryNombresCargos->fetch_array(MYSQLI_ASSOC); 
                                                            
                                                        "*".$nombresCargos['id_cargos']."<br><br>";
                                                        	
                                                        if($nombresCargos['id_cargos'] != NULL){
                                                        	   '<br>Debe avisar A';
                                                        	
                                                        	$extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cargo ='".$nombresCargos['id_cargos']."' ")or die(mysqli_error());
                                                            while($usuariosCargo = $extraerUsuarios->fetch_array()){
                                                            '<br>EL USUARIO: <b>'.$nombredelUsuario=($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
                                                            '<br> tiene el id cargo: '.$usuariosCargo['cargo'].'</b>';
                                                            $consultaCedula=$usuariosCargo['cedula'];
                                                             '<br>A:'.$correoNotificar=$usuariosCargo['correo'];
                                                            
                                                
    
                                                                      $mail = new PHPMailer();
                                                                      $mail->IsSMTP();
                                                                      
                                                                     
                                                                      require 'correoEnviar/contenido.php';
                                                                     
                                                                      //Agregar destinatario
                                                                      $mail->isHTML(true);
                                                                      $mail->AddAddress($correoNotificar);
                                                                       '-Enviar: '.$correoNotificar;
                                                                      /// end
                                                                  
                                                                      $nombreDocumentoEnviarCorreo=$row['nombres'];//$_POST['nombreDocumento'];
                                                                      
                                                          
                                                                      if($tipoSolicitud == '1'){
                                                                          $tipoSolicitudNombre='creación';
                                                                      }
                                                                      if($tipoSolicitud == '2'){
                                                                          $tipoSolicitudNombre='actualización';
                                                                      }
                                                                      if($tipoSolicitud == '3'){
                                                                          $tipoSolicitudNombre='eliminación';
                                                                      }
                                                          
                                                                      $mail->Subject=utf8_decode('Revisión documental - dueño de proceso'); // - autorizado para visualizarDueño de proceso - revisión documental
                                                                      $mail->Body = utf8_decode('
                                                                      <html>
                                                                      <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                                                      <title>HTML</title>
                                                                      </head>
                                                                      <body>
                                                                      <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                                                      
                                                                      <p>Estimado (a). <b><em>'.$nombredelUsuario.'</em></b>.
                                                                      <br>
                                                                      <p><b>El documento '.$nombreDocumentoEnviarCorreo.' se encuentra dentro del periodo de revisión</b></p>
                                                                      
                                                                     
                                                                      <br><br>
                                                                      Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                                                      </p>
                                                                      </body>
                                                                      </html>
                                                                      ');
                                                                 
                                                                      if ($mail->Send()) {
                                                                          //echo'<script type="text/javascript">
                                                                          //    alert("Enviado Correctamente");
                                                                          //    </script>';
                                                                          
                                                                      } else {
                                                                          //echo'<script type="text/javascript">
                                                                          //    alert("NO ENVIADO, intentar de nuevo");
                                                                          //    </script>';
                                                                      }
                                                                      $mail->ClearAddresses();  
                                                                      
                                                                      //// end        
                                                            }
                                                        }
                                                                    
                                                                     
                                                                    
                                                            
                                                }
                                            }else{
                                                 
                                                 'entra al A';
                                                for($i=0; $i<$longitud; $i++){
                                                        //saco el valor de cada elemento
                                                         'Dato: '.$array[$i];  '<br>';
                                                           
                                                        $queryNombresCargos = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$array[$i]' ");
                                                        $nombresCargos = $queryNombresCargos->fetch_array(MYSQLI_ASSOC); 
                                                            
                                                        "*".$nombresCargos['id_cargos']."<br><br>";
                                                        	
                                                        if($nombresCargos['id_cargos'] != NULL){
                                                        	   '<br>Debe avisar B';
                                                        	
                                                        	$extraerUsuariosSinImportacion = $mysqli->query("SELECT * FROM usuario WHERE cargo ='".$nombresCargos['id_cargos']."' ")or die(mysqli_error());
                                                            while($usuariosCargoSinImporacion = $extraerUsuariosSinImportacion->fetch_array()){
                                                            '<br>EL USUARIO: <b>'.$nombredelUsuarioSinImportacion=($usuariosCargoSinImporacion['nombres'].' '.$usuariosCargoSinImporacion['apellidos']);
                                                            '<br> tiene el id cargo: '.$usuariosCargoSinImporacion['cargo'].'</b>';
                                                            $consultaCedula=$usuariosCargoSinImporacion['cedula'];
                                                             '<br>B: '.$correoNotificarSinImportacion=$usuariosCargoSinImporacion['correo'];
                                                            
                                                
    
                                                                      $mail = new PHPMailer();
                                                                      $mail->IsSMTP();
                                                                      
                                                                     
                                                                      require 'correoEnviar/contenido.php';
                                                                     
                                                                      //Agregar destinatario
                                                                      $mail->isHTML(true);
                                                                      $mail->AddAddress($correoNotificarSinImportacion);
                                                                       '-Enviar: '.$correoNotificar;
                                                                      /// end
                                                                  
                                                                      $nombreDocumentoEnviarCorreo=$row['nombres'];//$_POST['nombreDocumento'];
                                                                      
                                                          
                                                                      if($tipoSolicitud == '1'){
                                                                          $tipoSolicitudNombre='creación';
                                                                      }
                                                                      if($tipoSolicitud == '2'){
                                                                          $tipoSolicitudNombre='actualización';
                                                                      }
                                                                      if($tipoSolicitud == '3'){
                                                                          $tipoSolicitudNombre='eliminación';
                                                                      }
                                                          
                                                                      $mail->Subject=utf8_decode('Revisión documental - dueño de proceso '); //- autorizado para visualizar
                                                                      $mail->Body = utf8_decode('
                                                                      <html>
                                                                      <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                                                      <title>HTML</title>
                                                                      </head>
                                                                      <body>
                                                                      <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                                                      
                                                                      <p>Estimado (a). <b><em>'.$nombredelUsuarioSinImportacion.'</em></b>.
                                                                      <br>
                                                                      <p><b>El documento '.$nombreDocumentoEnviarCorreo.' se encuentra dentro del periodo de revisión</b></p>
                                                                      
                                                                     
                                                                      <br><br>
                                                                      Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                                                      </p>
                                                                      </body>
                                                                      </html>
                                                                      ');
                                                                 
                                                                      if ($mail->Send()) {
                                                                          //echo'<script type="text/javascript">
                                                                          //    alert("Enviado Correctamente");
                                                                          //    </script>';
                                                                          
                                                                      } else {
                                                                          //echo'<script type="text/javascript">
                                                                          //    alert("NO ENVIADO, intentar de nuevo");
                                                                          //    </script>';
                                                                      }
                                                                      $mail->ClearAddresses();  
                                                                      
                                                                      //// end     
                                                            }
                                                  
                                                        }
                                                                    
                                                                     
                                                                    
                                                            
                                                }
                                            
                                            }
                                            
                                            
                                        /*    
                                        /// luego del envio de correo para los lideres de procesos, ahora vamos a enviar correo a un segundo resposable
                                        $preguntandoParametroCorreo=$mysqli->query("SELECT * FROM documentoRevision ");
                                        $extrerPreguntaParametroCorreo=$preguntandoParametroCorreo->fetch_array(MYSQLI_ASSOC);
                                        
                                        $arrayResponsable = json_decode(($extrerPreguntaParametroCorreo['responsable']));
                                        $longitudResponsable = count($arrayResponsable);
                                        
                                        if($extrerPreguntaParametroCorreo['quien'] == 'usuario'){
                                            for($i=0; $i<$longitudResponsable; $i++){
                                                            '<br>Entra usuario';    
                                                            $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE id ='$arrayResponsable[$i]' ")or die(mysqli_error());
                                                            $usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
                                                            '<br>EL USUARIO: <b>'.$nombredelUsuario=($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
                                                            '<br> tiene el id cargo: '.$usuariosCargo['cargo'].'</b>';
                                                            $consultaCedula=$usuariosCargo['cedula'];
                                                             '<br>'.$correoNotificar=$usuariosCargo['correo'];
                                                            
                                                
    
                                                                      $mail = new PHPMailer();
                                                                      $mail->IsSMTP();
                                                                      
                                                                     
                                                                      require 'correoEnviar/contenido.php';
                                                                     
                                                                      //Agregar destinatario
                                                                      $mail->isHTML(true);
                                                                      $mail->AddAddress($correoNotificar);
                                                                       '-Enviar: '.$correoNotificar;
                                                                      /// end
                                                                  
                                                                      $nombreDocumentoEnviarCorreo=$row['nombres'];//$_POST['nombreDocumento'];
                                                                      
                                                          
                                                                      if($tipoSolicitud == '1'){
                                                                          $tipoSolicitudNombre='creación';
                                                                      }
                                                                      if($tipoSolicitud == '2'){
                                                                          $tipoSolicitudNombre='actualización';
                                                                      }
                                                                      if($tipoSolicitud == '3'){
                                                                          $tipoSolicitudNombre='eliminación';
                                                                      }
                                                          
                                                                      $mail->Subject=utf8_decode('Revisión documental');
                                                                      $mail->Body = utf8_decode('
                                                                      <html>
                                                                      <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                                                      <title>HTML</title>
                                                                      </head>
                                                                      <body>
                                                                      <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                                                      
                                                                      <p>Estimado (a). <b><em>'.$nombredelUsuario.'</em></b>.
                                                                      <br>
                                                                      <p><b>El documento '.$nombreDocumentoEnviarCorreo.' se encuentra dentro del periodo de revisión</b></p>
                                                                      
                                                                      <br><br>
                                                                      Se recomienda ingresar y verificar su solicitud.
                                                                      <br><br>
                                                                      Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                                                      </p>
                                                                      </body>
                                                                      </html>
                                                                      ');
                                                                 
                                                                      if ($mail->Send()) {
                                                                          //echo'<script type="text/javascript">
                                                                          //    alert("Enviado Correctamente");
                                                                          //    </script>';
                                                                          
                                                                      } else {
                                                                          //echo'<script type="text/javascript">
                                                                          //    alert("NO ENVIADO, intentar de nuevo");
                                                                          //    </script>';
                                                                      }
                                                                      $mail->ClearAddresses();  
                                                                      
                                            }  
                                        }elseif($extrerPreguntaParametroCorreo['quien'] == 'cargo'){
                                             '<br>Entra al cargo'; 
                                            for($i=0; $i<$longitudResponsable; $i++){
                                                            '<br>Entra usuario';    
                                                            $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cargo ='$arrayResponsable[$i]' ")or die(mysqli_error());
                                                            $usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
                                                            '<br>EL USUARIO: <b>'.$nombredelUsuario=($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
                                                            '<br> tiene el id cargo: '.$usuariosCargo['cargo'].'</b>';
                                                            $consultaCedula=$usuariosCargo['cedula'];
                                                             '<br>'.$correoNotificar=$usuariosCargo['correo'];
                                                            
                                                
    
                                                                      $mail = new PHPMailer();
                                                                      $mail->IsSMTP();
                                                                      
                                                                     
                                                                      require 'correoEnviar/contenido.php';
                                                                     
                                                                      //Agregar destinatario
                                                                      $mail->isHTML(true);
                                                                      $mail->AddAddress($correoNotificar);
                                                                       '-Enviar: '.$correoNotificar;
                                                                      /// end
                                                                  
                                                                      $nombreDocumentoEnviarCorreo=$row['nombres'];//$_POST['nombreDocumento'];
                                                                      
                                                          
                                                                      if($tipoSolicitud == '1'){
                                                                          $tipoSolicitudNombre='creación';
                                                                      }
                                                                      if($tipoSolicitud == '2'){
                                                                          $tipoSolicitudNombre='actualización';
                                                                      }
                                                                      if($tipoSolicitud == '3'){
                                                                          $tipoSolicitudNombre='eliminación';
                                                                      }
                                                          
                                                                      $mail->Subject=utf8_decode('Revisión documental');
                                                                      $mail->Body = utf8_decode('
                                                                      <html>
                                                                      <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                                                      <title>HTML</title>
                                                                      </head>
                                                                      <body>
                                                                      <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                                                      
                                                                      <p>Estimado (a). <b><em>'.$nombredelUsuario.'</em></b>.
                                                                      <br>
                                                                      <p><b>El documento '.$nombreDocumentoEnviarCorreo.' se encuentra dentro del periodo de revisión</b></p>
                                                                      
                                                                      <br><br>
                                                                      Se recomienda ingresar y verificar su solicitud.
                                                                      <br><br>
                                                                      Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                                                      </p>
                                                                      </body>
                                                                      </html>
                                                                      ');
                                                                 
                                                                      if ($mail->Send()) {
                                                                          //echo'<script type="text/javascript">
                                                                          //    alert("Enviado Correctamente");
                                                                          //    </script>';
                                                                          
                                                                      } else {
                                                                          //echo'<script type="text/javascript">
                                                                          //    alert("NO ENVIADO, intentar de nuevo");
                                                                          //    </script>';
                                                                      }
                                                                      $mail->ClearAddresses();  
                                                                      
                                            }
                                        }elseif($extrerPreguntaParametroCorreo['quien'] == 'grupo'){
                                             '<br>Entra grupo'; 
                                             for($i=0; $i<$longitudResponsable; $i++){
                                                        $centrosT = $mysqli->query("SELECT * FROM grupoUusuario WHERE idGrupo = '$arrayResponsable[$i]' ");
                                                        while($rows = $centrosT->fetch_assoc()){
                                                            
                                                            $idUsuario = $rows['idUsuario'];
                                                            $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cedula ='$idUsuario' ")or die(mysqli_error());
                                                            $usuariosCargo = $extraerUsuarios->fetch_array(MYSQLI_ASSOC);
                                                            '<br>EL USUARIO: <b>'.$nombredelUsuario=($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']);
                                                            '<br> tiene el id cargo: '.$usuariosCargo['cargo'].'</b>';
                                                            $consultaCedula=$usuariosCargo['cedula'];
                                                             '<br>'.$correoNotificar=$usuariosCargo['correo'];
                                                            
                                                
                                                                      
                                                                      $mail = new PHPMailer();
                                                                      $mail->IsSMTP();
                                                                      
                                                                     
                                                                      require 'correoEnviar/contenido.php';
                                                                     
                                                                      //Agregar destinatario
                                                                      $mail->isHTML(true);
                                                                      $mail->AddAddress($correoNotificar);
                                                                       '-Enviar: '.$correoNotificar;
                                                                      /// end
                                                                  
                                                                      $nombreDocumentoEnviarCorreo=$row['nombres'];//$_POST['nombreDocumento'];
                                                                      
                                                          
                                                                      if($tipoSolicitud == '1'){
                                                                          $tipoSolicitudNombre='creación';
                                                                      }
                                                                      if($tipoSolicitud == '2'){
                                                                          $tipoSolicitudNombre='actualización';
                                                                      }
                                                                      if($tipoSolicitud == '3'){
                                                                          $tipoSolicitudNombre='eliminación';
                                                                      }
                                                          
                                                                      $mail->Subject=utf8_decode('Revisión documental');
                                                                      $mail->Body = utf8_decode('
                                                                      <html>
                                                                      <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                                                      <title>HTML</title>
                                                                      </head>
                                                                      <body>
                                                                      <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                                                      
                                                                      <p>Estimado (a). <b><em>'.$nombredelUsuario.'</em></b>.
                                                                      <br>
                                                                      <p><b>El documento '.$nombreDocumentoEnviarCorreo.' se encuentra dentro del periodo de revisión</b></p>
                                                                      
                                                                      <br><br>
                                                                      Se recomienda ingresar y verificar su solicitud.
                                                                      <br><br>
                                                                      Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                                                      </p>
                                                                      </body>
                                                                      </html>
                                                                      ');
                                                                 
                                                                      if ($mail->Send()) {
                                                                          //echo'<script type="text/javascript">
                                                                          //    alert("Enviado Correctamente");
                                                                          //    </script>';
                                                                          
                                                                      } else {
                                                                          //echo'<script type="text/javascript">
                                                                          //    alert("NO ENVIADO, intentar de nuevo");
                                                                          //    </script>';
                                                                      }
                                                                      $mail->ClearAddresses();  
                                                                      
                                                        } 
                                            }
                                        }
                                        */
                                            
                                }  
                            }
                            echo '</td>';
                            
                            
                            
                         
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
<!-- Bootstrap4 Duallistbox -->
<script src="../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<script>
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
</script>



<!-- archivos para el filtro de busqueda y lista de información -->

    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>
<!-- END -->
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<?php
/// validaciones de alertas
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
      timer: 3000
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
<script>
    $(document).ready(function(){
        $('#rad_cargoAut').click(function(){
            rad_cargo = "cargo";
                document.getElementById('listarCargos').style.display = '';
                document.getElementById('listarUsuarios').style.display = 'none';
                document.getElementById('listarGrupos').style.display = 'none';
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoAut").html(data).required = true;
            }); 
        });
        $('#rad_usuarioAut').click(function(){
            rad_usuario = "usuario";
                document.getElementById('listarCargos').style.display = 'none';
                document.getElementById('listarUsuarios').style.display = '';
                document.getElementById('listarGrupos').style.display = 'none';
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoAut").html(data).required = true;
            }); 
        });
        $('#rad_grupoAut').click(function(){
            rad_grupo = "grupo";
                document.getElementById('listarCargos').style.display = 'none';
                document.getElementById('listarUsuarios').style.display = 'none';
                document.getElementById('listarGrupos').style.display = '';
            $.post("selectDocumentos2.php", { rad_grupo: rad_grupo }, function(data){
                $("#select_encargadoAut").html(data).required = true;
            }); 
        });
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