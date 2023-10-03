<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
//require_once 'inactividad.php';

    $celdulaUser = $_SESSION['session_username']; 
    $cargoID = $_SESSION['session_cargo']; 
    $idUsuario = $_SESSION['session_idUsuario'];
?>
<!DOCTYPE html>
<html>
    <title>Perfil</title>
<head><meta charset="gb18030">
  
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
  
  <!-- se agregan los estilos para la agenda -->
    <!-- fullCalendar -->
  <link rel="stylesheet" href="../plugins/fullcalendar/main.min.css">
  <link rel="stylesheet" href="../plugins/fullcalendar-interaction/main.min.css">
  <link rel="stylesheet" href="../plugins/fullcalendar-daygrid/main.min.css">
  <link rel="stylesheet" href="../plugins/fullcalendar-timegrid/main.min.css">
  <link rel="stylesheet" href="../plugins/fullcalendar-bootstrap/main.min.css">
  <!-- Fin se agregan los estilos para la agenda -->
</head>
<script>
   	
    function nobackbutton(){
    	
       window.location.hash="no-back-button";
    	
       window.location.hash="Again-No-back-button" //chrome
    	
       window.onhashchange=function(){window.location.hash="no-back-button";}
    	
    }
</script>
<body class="hold-transition sidebar-mini"  oncopy="return false" onpaste="return false" onload="nobackbutton();">
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
            <h1>Perfil</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <!--<li class="breadcrumb-item active">Mi Perfil</li>-->
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
           
            
            
            
            
            <!-- PENDIENTES -->
            <?php require_once'notificacionesVista.php'; ?>
            <!-- FIN PENDIENTES -->
                                
                                <!-- desde la notificacionVista enviamos la petición de mostrar el modal para carpetas de aprobación o rechazo -->
                                    <div class="modal fade" id="modal-dangerSolicitud">
                                        <div class="modal-dialog">
                                          <div class="modal-content bg-success">
                                            <div class="modal-header">
                                              <h4 class="modal-title">Alerta</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            
                                            <form action='controlador/repositorio/controllerRepositorio' method='POST'>
                                            <div class="modal-body">
                                              
                                              
                                               <textarea type="" name="nombreSolicitante" id="solicitar" style="background:transparent;color:white;border:0px;width:100%;height:100px;" required></textarea>
                                               <input type="hidden" id="idSolicitar" name="idSolicitar" value="" placeholder="id Solicitar" readonly required>
                                               <input type="hidden" name="idSolicitaSolicitante" id="idSolicitaSolicitante" placeholder="Solicitante" readonly required>
                                               <input type="hidden" name="idSolicitaSolicitanteUnico" id="idSolicitaSolicitanteUnico" placeholder="Solicitante" readonly required>
                                              
                                               <br><br>
                                               <textarea class="form-control" name="motivo" placeholder="Describa el motivo de su solicitud....." onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || event.charCode == 46 || event.charCode == 44)" required></textarea>
                                               <input type="radio" name="aprobacionSolicitud" value="Aprobado" required> Aprobado
                                               <input type="radio" name="aprobacionSolicitud" value="Rechazado" required> Rechazado
                                            </div>
                                             <!-- formulario para eliminar por el id -->
                                            <div class="modal-footer justify-content-between">
                                              
                                              <button type="submit" name='ejecutaSolicitud' class="btn btn-outline-light">Aceptar</button>
                                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
                                            </div>
                                             </form>
                                             <!-- END formulario para eliminar por el id -->
                                          </div>
                                        </div>
                                    </div>
                                    <!--  END desde la notificacionVista enviamos la petición de mostrar el modal para carpetas de aprobación o rechazo -->
                                    
                                    
                                    
                                    <!-- desde la notificacionVista enviamos la petición de mostrar el modal para archivos de aprobación o rechazo -->
                                    <div class="modal fade" id="modal-dangerSolicitudArchivos">
                                        <div class="modal-dialog">
                                          <div class="modal-content bg-success">
                                            <div class="modal-header">
                                              <h4 class="modal-title">Alerta</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            
                                            <form action='controlador/repositorio/controllerRepositorio' method='POST'>
                                            <div class="modal-body">
                                              
                                              
                                               <textarea type="" name="nombreSolicitante" id="solicitarS" style="background:transparent;color:white;border:0px;width:100%;height:100px;" required></textarea>
                                               <input type="hidden"  name="idSolicitar" id="idSolicitarS" value="" placeholder="id Solicitar" readonly required>
                                               <input type="hidden" name="idSolicitaSolicitante" id="idSolicitaSolicitanteS" placeholder="Solicitante" readonly required>
                                               <input type="hidden" name="idSolicitaSolicitanteUnico" id="idSolicitaSolicitanteUnicoA" placeholder="Solicitante" readonly required>
                                               
                                               <br><br>
                                               <textarea class="form-control" name="motivo" placeholder="Describa el motivo de su solicitud....." required></textarea>
                                               <input type="radio" name="aprobacionSolicitud" value="Aprobado" required> Aprobado
                                               <input type="radio" name="aprobacionSolicitud" value="Rechazado" required> Rechazado
                                            </div>
                                             <!-- formulario para eliminar por el id -->
                                            <div class="modal-footer justify-content-between">
                                              
                                              <button type="submit" name='ejecutaSolicitudCarpeta' class="btn btn-outline-light">Aceptar</button>
                                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
                                            </div>
                                             </form>
                                             <!-- END formulario para eliminar por el id -->
                                          </div>
                                        </div>
                                    </div>
                                    <!--  END desde la notificacionVista enviamos la petición de mostrar el modal para archvos de aprobación o rechazo -->
                                    
                                    
            <!-- gestion de actas -->
            
            <!-- fin de gestion de actas-->
            
            <?php
            
            //Validacion parasaber si tiene actividades pendiente.
            
            //$celdulaUser = $_SESSION['session_username']; 
            //$cargoID = $_SESSION['session_cargo']; 
            //$idUsuario = $_SESSION['session_idUsuario'];
            
            $conteoTotal = 0;
            
            $dataRegistros = $mysqli->query("SELECT * FROM registros WHERE aprobador !='' ")or die(mysqli_error());
            //echo "ACA EL NUMERO DE REGISTROS: ".mysqli_num_rows($dataRegistros);
            
            while($row = $dataRegistros->fetch_assoc()){
                
                $idRegistro = $row['id'];
                $aprobador = $row['aprobador'];
                $quienApruebaRId = json_decode($row['aprobadorID']);
                //var_dump($quienApruebaRId);
                if($aprobador == 'usuarios'){
                    //echo "usuario".$idUsuario;
                    
                    if(in_array($idUsuario,$quienApruebaRId)){
                        $conteoTotal++;
                        //echo "Debo aprobar por usuario";
                    }
                }
                
                if($aprobador== 'cargos'){
                    //echo "cARGO";
                    if(in_array($cargoID,$quienApruebaRId)){
                        $conteoTotal++;
                        //echo "Debo aprobar por cargo";
                    }
                            
                }

            }    
            
            $data = $mysqli->query("SELECT * FROM actas WHERE finalizada = 1 ORDER BY id ASC")or die(mysqli_error());
            
            while($row = $data->fetch_assoc()){
                
                $idActa = $row['id'];
                
                
                if($row['estado'] == 'Pendiente'){
                    
                    if($row['aprobarActa'] == 'si'){
                    
                        $quienApruebaId = json_decode($row['quienApruebaId']);
                        
                        if($row['quienAprueba'] == 'usuario'){
                            
                            if(in_array($idUsuario,$quienApruebaId)){
                                
                                $conteoTotal++;
                                    
                            }
                            
                        }
                        
                        
                        if($row['quienAprueba'] == 'cargo'){
                            
                            if(in_array($cargoID,$quienApruebaId)){
                                
                                $conteoTotal++;
    
                            }
                            
                        }
                    
                    }
                    
                }
                
                
                
                
                $queryCompromisos = $mysqli->query("SELECT id,responsableCompromiso, responsableID, entregarA, entregarAID FROM `compromisos` WHERE idActa = '$idActa' AND estado != 'Aprobado'");
                
                if(mysqli_num_rows($queryCompromisos) > 0 && $row['estado'] == "Aprobado"){
                    while($datoCompromiso = $queryCompromisos->fetch_assoc()){
                        $idCompromiso = $datoCompromiso['id'];
                        
                        $queryResponsablesIndi = $mysqli->query("SELECT estado FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso'");//con esta query validamos si algun compromiso individual esta pendiente y no se va a mostrar a menos que tenga un avance
                        $noMostrarCompromisos = FALSE;
                                        
                        $arrayEstados = array();
                                        
                        while($row = $queryResponsablesIndi->fetch_assoc()){
                            $estadoIndividualComp = $row['estado'];
                            
                            array_push($arrayEstados,$estadoIndividualComp);
                            
                        }
                                        
                        if(in_array('Avance',$arrayEstados) || in_array('Ejecutado',$arrayEstados)){
                            
                        }else{
                            continue;
                        }
                        
                        $responsableCompromiso = $datoCompromiso['responsableCompromiso']; 
                        $responsableID = json_decode($datoCompromiso['responsableID']);
                        $entregarA = $datoCompromiso['entregarA'];
                        $entregarAID = json_decode($datoCompromiso['entregarAID']);
                                
                        if($responsableCompromiso == "cargo"){
                            if(in_array($cargoID,$responsableID)){
                                $conteoTotal++;
                            }
                        }
                        
                        if($responsableCompromiso == "usuario"){
                            if(in_array($idUsuario,$responsableID)){
                                $conteoTotal++;
                            }
                        }
                        
                        if($entregarA == "cargo"){
                            if(in_array($cargoID,$entregarAID)){
                                $conteoTotal++;
                            }
                        }
                        
                        if($entregarA == "usuario"){
                            if(in_array($idUsuario,$entregarAID)){
                                $conteoTotal++;
                            }
                        }
                       
                                
                    }
                }
                
                        
                
                
                
            }
            
            
            
            /*Notificaciones revision documental*/
            
            $dataRevision = $mysqli->query("SELECT * FROM documento WHERE vigente = 1 AND revisado = 0 ORDER BY codificacion ASC")or die(mysqli_error());
                     
            while($row = $dataRevision->fetch_assoc()){
                $nombreDocumento = $row['nombres'];
                        
                        $idProceso2 = $row['proceso'];
                        
                        
                        $dataSol = $mysqli->query("SELECT duenoProceso FROM procesos WHERE id = '$idProceso2' ")or die(mysqli_error());
                        $datosSol = $dataSol->fetch_assoc();
                        $encargadoSolicitud = json_decode($datosSol['duenoProceso']);
                        
                        //print_r($encargadoSolicitud);
                        
                        if($encargadoSolicitud != NULL){
                          if(in_array($cargoID,$encargadoSolicitud)){
                              
                          }else{
                              continue;
                          }
                        }
                        
                        
                        $fechaActual2 = date('d-m-Y');
                        //echo "FECHA ACTUAL UNO: ".$fechaActual2; echo "<br>";
                        
                        $mesesRevision = $row['mesesRevision'];
                        
                        if($row['ultimaFechaRevision'] == NULL){
                            
                            $fechaAprobado = date("d-m-Y", strtotime($row['fechaAprobado']));
                            /*Calculo fecha de revision*/
                            $fechaRevisar = date("d-m-Y",strtotime($fechaAprobado."+ $mesesRevision month"));
                            
                        }else{
                            $fechaUltimaRevision = $row['ultimaFechaRevision'];
                            
                            $fechaRevisar = date("d-m-Y",strtotime($fechaUltimaRevision."+ $mesesRevision month"));
                            $fechaAprobado = date("d-m-Y", strtotime($row['fechaAprobado']));
                        }
                        
                        
                        //$fechaActual2 = "15-12-2020";

                        /*Pasos las fechas a un objeto tiempo*/
                        $datetime11 = new DateTime($fechaActual2);
                        $datetime22 = new DateTime($fechaRevisar);
                        
                        /*Diferendia entre las fechas*/
                        $interval2 = $datetime11->diff($datetime22);
                        
                        
                        /*
                            Formato para sacar los dias entre las dos fechas
                            
                            $interval2->format('%R%a dias'); con %R saco si es negativo o positivo
                        */
                        $diasFaltantes = $interval2->format('%a');
                        
                        
                        
                        //$diasFaltantes = 5;

                            
                        if($diasFaltantes <= "30"){
                        
                        $conteoTotal = 1;
                        
                            
                        }
                         
            }
            
            
            
            //////Otra actividades 
            
                                        ///////////// se trae el cargo del usuario
                                        $query = $mysqli->query("SELECT * FROM usuario WHERE cedula='$sesion'");
                                        $row = $query->fetch_array(MYSQLI_ASSOC);
                                        $cargoConteo= $row['cargo'];
                                        /////////// fin del proceso
                                        
                                        //////////conteo de solicitudes
                                        /*
                                        $conteoActividades=0;
                                        $sql= $mysqli->query("SELECT * FROM solicitudDocumentos WHERE encargadoAprobar='$cargoConteo' AND estado IS NULL ORDER BY id DESC");
    		                            while($row = $sql->fetch_assoc()){
                                        $conteoActividades++;
                          
    		                            } */
                
            //// cuando tenemos reunionesnuevas
            
                         $sql= $mysqli->query("SELECT * FROM agenda WHERE asunto='Crear reunion' OR asunto='Crear tarea' ORDER BY fecha DESC");
                                     $conteoActasAgenda = 0;
                                     $conteoActasAAgendaCargo = 0;
                		            while($row = $sql->fetch_assoc()){
                		               
                                    $tipoPersonalAgenda = $row['tipoPersonal'];
        		                    $personalIDAgenda =  json_decode($row['personal']);
                                    $longitudAgenda = count($personalIDAgenda);
                                
                                        if($tipoPersonalAgenda == 'usuario'){
                                            
                                            for($i=0; $i<$longitudAgenda; $i++){
                                                
                                                $nombreActasAgenda = $mysqli->query("SELECT nombres, apellidos,cedula FROM usuario WHERE id = '$personalIDAgenda[$i]' AND cedula='$sesion' ");
                                                $columnaValidandoAgenda = $nombreActasAgenda->fetch_array(MYSQLI_ASSOC);
                                                //echo $cedulaGuardaro=$columnaValidandoAgenda['cedula'];
                                                
                                                $cnAgenda = mysqli_num_rows($nombreActasAgenda);
                                                
                                                if($cnAgenda > 0){
                                                $conteoActasAgenda++;  
                                                
                                                }
                                                
                                            } //// cierre del for
                                        } //// cierre del if
                                        
                                        if($tipoPersonalAgenda == 'cargo'){
                                                    
                                                    for($i=0; $i<$longitudAgenda; $i++){
                                                        
                                                        $nombrecargoAgenda = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDAgenda[$i]' 
                                                        AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                                        $columna = $nombrecargoAgenda->fetch_array(MYSQLI_ASSOC);
                                                        //echo $columna['nombreCargos'];
                                                        
                                                        $cnAgenda = mysqli_num_rows($nombrecargoAgenda);
                                                        
                                                        if($cnAgenda > 0){
                                                        $conteoActasAAgendaCargo++;  
                                                        
                                                        }
                                                        
                                                    } //// cierre del for
                                        } //// cierre del if
                                  }
    		                
    		                //// sumamos los usuarios y cargos
    		                $totalReunionesAgenda=$conteoActasAgenda+$conteoActasAAgendaCargo;
                      
            /////
            
            
            
            //////// permisos para el manejo de la publicación
           
            $formulario = 'comunicaciones'; //Se cambia el nombre del formulario
           

                $documento = $_SESSION["session_username"];
                $queryGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario = '$documento'");
                
                while($row = $queryGrupos->fetch_assoc()){
                     'id:grupo: '.$idGrupo = $row['idGrupo'];
                    
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
                
                //if($permisoListar == FALSE){
                  //  echo '<script language="javascript">window.location.href="accesoDenegado"</script>';
                //}
                
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



            ////////// end
            
            
            
                    //// agregamos la notificacion de revision documental para visualizar el letrero rojo de actividades
                     $cargoIDValidacion = $_SESSION['session_cargo'];
    
                    // Obteniendo la fecha actual del sistema con PHP
    
  
                    $dataRevision = $mysqli->query("SELECT * FROM documento WHERE vigente = 1 AND revisado = 0 ORDER BY codificacion ASC")or die(mysqli_error());
                    $contadorAlumbrarRevision=0;
                    while($row = $dataRevision->fetch_assoc()){
                        
                        $nombreDocumento = $row['nombres'];
                        
                        $idProceso2 = $row['proceso'];
                        
                        
                        $dataSol = $mysqli->query("SELECT duenoProceso FROM procesos WHERE id = $idProceso2")or die(mysqli_error());
                        $datosSol = $dataSol->fetch_assoc();
                        $encargadoSolicitud = json_decode($datosSol['duenoProceso']);
                        
                        
                        /*Validacioon para saber si el cargo es lider del proceso al que se ato el documento*/
                        if(in_array($cargoIDValidacion,$encargadoSolicitud)){
                            
                        }else{
                            continue;
                        }
                        
                        
                        
                        $fechaActual2 = date('d-m-Y');
                        //echo "FECHA ACTUAL UNO: ".$fechaActual2; echo "<br>";
                        
                        $mesesRevision = $row['mesesRevision'];
                        
                        if($row['ultimaFechaRevision'] == NULL){
                            
                            $fechaAprobado = date("d-m-Y", strtotime($row['fechaAprobado']));
                            /*Calculo fecha de revision*/
                            $fechaRevisar = date("d-m-Y",strtotime($fechaAprobado."+ $mesesRevision month"));
                            
                        }else{
                            $fechaUltimaRevision = $row['ultimaFechaRevision'];
                            
                            $fechaRevisar = date("d-m-Y",strtotime($fechaUltimaRevision."+ $mesesRevision month"));
                            $fechaAprobado = date("d-m-Y", strtotime($row['fechaAprobado']));
                        }
                        
                        
                        //$fechaActual2 = "15-12-2020";

                        /*Pasos las fechas a un objeto tiempo*/
                        $datetime11 = new DateTime($fechaActual2);
                        $datetime22 = new DateTime($fechaRevisar);
                        
                        /*Diferendia entre las fechas*/
                        $interval2 = $datetime11->diff($datetime22);
                        
                        
                        
                           // Formato para sacar los dias entre las dos fechas
                            
                                 $interval2->format('%R%a dias'); //con %R saco si es negativo o positivo
                                 $validandoDias=$interval2->format('%R');
                        
                        $diasFaltantes = $interval2->format('%a');
                        
                        
                        
                        //$diasFaltantes = 5;

                            
                        if($diasFaltantes <= "30"){
                            $contadorAlumbrarRevision++;
                        } 
                        
                    } 
            
            
            
            ?>
            
            <!-- /.card -->

            <!-- About Me Box -->
            
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Configuraci&oacute;n</a></li>
                  <li class="nav-item"><a class="nav-link" href="#agenda" data-toggle="tab">Agenda</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Cronograma <?php if($totalReunionesAgenda > 0){ ?><span class="right badge badge-danger">Nuevo!</span><?php } ?> </a></li>
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Comunicaciones Internas</a></li>
                  <li class="nav-item">
                      <a class="nav-link" href="#actividades" data-toggle="tab">Actividades 
                          <?php //$conteoTotal > 0 || 
                            if( $totalesAprobacionComprimisos > 0 || $totalesGestionCompromisos > 0 || $totalesAprobacionActas > 0 || $conteoActividades > 0 || $contadorAlumbrarRevision > 0){ 
                          ?>
                          <span class="right badge badge-danger">Nuevo!</span>
                          <?php
                            }else{ } 
                          ?>
                      </a>
                  </li>
                  
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                    <?php
                        $sql= $mysqli->query("SELECT * FROM usuario WHERE cedula = '$sesion'");
    		            while($row = $sql->fetch_assoc()){
                		    $cc = $row['id'];
                		}
                	
                    ?>
                    <!-- input par agregar comentarios o archivos -->
                        <?php
                        if($visibleI == FALSE){
                        ?>
                            <form action="controlador/comunicacionInterna/controllerComunicacionInterna" method="POST" enctype="multipart/form-data">
                                <div class="input-group input-group-sm mb-0">
                                  <input  autocomplete="off" class="form-control form-control-sm" name="comentario" placeholder="Comunicación interna" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || event.charCode == 13)">
                                  <div class="input-group-append">
                                    <button type="submit" name="AddcomunicacionInterna" class="btn btn-danger">Publicar</button>
                                  </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-file">
                                      <input type="file" name="archivo" class="custom-file-input" id="customFile" accept=".jpg,.jpeg,.png,.gif,.jpeg,.bmp,.svg,.jfif,.PNG,.JPEG,.GIF,.JPG,.TIFF,.PPM,.PGM,.PBM,.PNM,.BPG,.PPM,.DRW,.ECW,.FITS,.FLIF,.XCF,.SVG">
                                      <!-- <input type="file" class="custom-file-input" id="miInput" name="foto" accept=".jpg,.jpeg,.png,.jfif" >-->
                                      <!-- Agregamos esta linea para validar que solo sea el documento pdf-->
                                      <script>
                                      $('input[name="archivo"]').on('change', function(){
                                          var ext = $( this ).val().split('.').pop();
                                          if ($( this ).val() != '') {
                                            if(ext == "jpg" || ext == "jpeg" || ext == "png" || ext == "gif" || ext == "jpe" || ext == "bmp" || ext =="svg"|| ext =="jfif" || ext == "PNG" || ext == "JPEG" || ext == "JPG" || ext == "TIFF" || ext =="PPM"|| ext =="PGM"|| ext =="PBM"|| ext =="PNM"|| ext =="BPG"|| ext =="PPM"|| ext =="DRW"|| ext =="ECW"|| ext =="FITS"|| ext =="FLIF"|| ext =="XCF"|| ext =="SVG"){
                                              
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
                                      <!-- END -->
                                      <label class="custom-file-label" for="customFile"><h7>Formatos Permitidos: PNG,JPG,JPEG,GIF</h7></label>
                                    </div>
                                </div>
                                <input name="idUsuario" value="<?php echo $cc; ?>" type="hidden">
                            </form>
                        <?php
                        }
                        ?>
                        
                    <!-- fin del proceso de los comentarios -->
                    <?php
                    //	$sql= $mysqli->query("SELECT * FROM comunicacionInterna WHERE idUsuario = '$cc'");
    		          //  while($row = $sql->fetch_assoc()){
                		//    $cc2 = $row['idUsuario'];
                	//	}
                          //  if($cc2 != NULL){
                        $sql= $mysqli->query("SELECT * FROM comunicacionInterna  order by id DESC");
    		            while($row = $sql->fetch_assoc()){
                		     $identificadorPC=$row['idUsuario'];
                		     $idEliminar=$row['id'];
                		     $acentos = $mysqli->query("SET NAMES 'utf8'");    
                             $queryJefeInmediato=$mysqli->query("SELECT * FROM usuario WHERE id='$identificadorPC' ");
        	                 $rowDatos=$queryJefeInmediato->fetch_array(MYSQLI_ASSOC);
        	                 $nombreP=$rowDatos['nombres'];
        	                 $apellidoP=$rowDatos['apellidos'];
                		     $fotoP=$rowDatos['foto'];
                    ?>
                    <div class="post">
                      <div class="user-block">
                        <?php if($fotoP != NULL){ ?>  
                        <img class="img-circle img-bordered-sm" src="data:image/jpg;base64, <?php echo base64_encode($fotoP); ?>" alt="user image">
                        <?php }else{ ?>
                        <img class="img-circle img-bordered-sm" src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSAFdnwsj9XmZPJzlH-h95QvIm7QjUsIlHkpQ&usqp=CAU" alt="user image">
                        <?php } ?>
                        <span class="username">
                          <a href="#"><?php echo $nombreP.' '.$apellidoP; ?></a>
                          <?php
                          
                        if($visibleD == FALSE){
                                /*
                                <a name="eliminar" onclick="window.location='controlador/comunicacionInterna/controllerComunicacionInterna?eliminar=<?php echo $idEliminar;?>'" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                */
                        ?>
                        <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $idEliminar;?>' >
                        <a onclick='funcionFormula<?php echo $contador1++;?>()' data-toggle='modal' data-target='#modal-danger' class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        
                        <script>
                            function funcionFormula<?php echo $contador2++;?>() {
                                /*alert("entre");*/
                              document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                            }
                       </script>
                        
                        
                           <div class="modal fade" id="modal-danger">
                                <div class="modal-dialog">
                                  <div class="modal-content bg-danger">
                                    <div class="modal-header">
                                      <h4 class="modal-title">Alerta</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <p>¿Est&aacute; seguro que desea eliminar?</p>
                                    </div>
                                     <!-- formulario para eliminar por el id -->
                                    <form action='controlador/comunicacionInterna/controllerComunicacionInterna' method='GET'>
                                    <div class="modal-footer justify-content-between">
                                      <input type="hidden" id="capturarFormula" name='ideliminar' readonly>
                                      <button type="submit" name='eliminar' class="btn btn-outline-light">Si</button>
                                      <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                                    </div>
                                     </form>
                                     <!-- END formulario para eliminar por el id -->
                                  </div>
                                </div>
                            </div>
                          
                          
                        <?php
                        }
                        ?>
                        </span>
                        <span class="description"><?php echo $fecha = $row['fecha']; ?></span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        <?php echo $comentario = $row['comentario']; ?>
                      </p>
                      <?php
                        if($archivo=$row['archivo'] != NULL){
                      ?>
                        <div class="timeline-body">
                            <img src="data:image/jpg;base64, <?php echo base64_encode($archivo=$row['archivo']); ?>" width="100%" height="100%" >
                        </div>
                        <?php
                            }else{
                                
                            }
                        ?>
                      <p>
                      <!--  <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>  -->
                        
                         <?php
                                     $queryJefeInmediato=$mysqli->query("SELECT * FROM comunicacionInterna WHERE id='$idEliminar' ");
                	                 $rowDatos=$queryJefeInmediato->fetch_array(MYSQLI_ASSOC);
                	                 $idJefeInmediato=$rowDatos['idUsuario'];
                	                 $idEntra=$rowDatos['id'];
                	                 
                               
                                
                                
                                 $queryJefeInmediato=$mysqli->query("SELECT * FROM usuario WHERE id='$idJefeInmediato' ");
            	                 $rowDatos=$queryJefeInmediato->fetch_array(MYSQLI_ASSOC);
            	                 
            	                 
            	                 
            	                 
                                    
                                     $queryJefeInmediato=$mysqli->query("SELECT * FROM comunicacionInternaVer WHERE idComunicacionInterna='$idEntra' order by id DESC limit 0,1 ");
                	                 $rowDatos=$queryJefeInmediato->fetch_array(MYSQLI_ASSOC);
                	                 $comentarioInternaVer=$rowDatos['comentario'];
                	                 $fechaInternaVer=$rowDatos['fecha'];
                	                 $idUsuarioValidar=$rowDatos['idUsuario'];
                	                 
                                    
                                     $queryJefeInmediato=$mysqli->query("SELECT * FROM usuario WHERE id='$idUsuarioValidar' ");
                	                 $rowDatos=$queryJefeInmediato->fetch_array(MYSQLI_ASSOC);
                	                 $usuarioCV=$rowDatos['nombres'];
                	                 $apellidoCV=$rowDatos['apellidos'];
                	                 $fotoCV=$rowDatos['foto'];
                	                 
                              ?>
                        <div class="card-footer card-comments">
                            <div class="card-comment">
                              <!-- User image -->
                              <?php
                                if($fotoCV != NULL){
                              ?>
                             <img class="img-circle img-sm" src="data:image/jpg;base64, <?php echo base64_encode($fotoCV); ?>" alt="User Image">
                             <?php }else{ 
                             ?>
                             <img class="img-circle img-sm" src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSAFdnwsj9XmZPJzlH-h95QvIm7QjUsIlHkpQ&usqp=CAU" alt="User Image">
                             <?php
                             } ?>
                                <div class="comment-text">
                                <span class="username">
                                  <?php 
                                    echo $usuarioCV.' '.$apellidoCV;
                                  ?>
                                  <span class="text-muted float-right"><?php echo $fechaInternaVer; ?></span>
                                </span><!-- /.username -->
                                <?php echo $comentarioInternaVer; ?>
                              </div>
                              <!-- /.comment-text -->
                            </div>
                            <!-- /.card-comment -->
                           
                        </div>
                        <?php
                       
                             if($visibleE == FALSE){
                        ?>
                                <span class="float-right">
                                  <a onclick="window.location='myperfilVer?enviar=<?php echo $idEntra;?>'" class="link-black text-sm">
                                    <i class="far fa-comments mr-1"></i> Comentarios
                                  </a>
                                </span>
                        <?php
                             }
                        
                        ?>
                        
                      </p>
                    <br><br>
                    <!-- <input class="form-control form-control-sm" type="text" placeholder="Comentar">  -->
                    </div>
                    <?php
    		            }
                        //    }else{
                                
                          //  }
                      ?>
                    <!-- /.post -->

                    

                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <div class="timeline timeline-inverse">
                      <!-- timeline time label -->
                     <!-- timeline time label $idparaChat -->
                                  <?php
                                
            
                                    $sql= $mysqli->query("SELECT * FROM agenda WHERE asunto='Crear reunion' OR asunto='Crear tarea' ORDER BY fecha ASC ");
                                     $conteoActasA = 0;
                		            while($row = $sql->fetch_assoc()){
                		               
                                        $idAgenda=$row['id'];
                                        $idCreacionUsuario = $row['idUsuario'];
                                  
                                  /// se trae el id para montar los colores -->
                                        $asuntoNombre=$row['asunto'];
                                        $idColorv=$row['color'];
                                        $query = $mysqli->query("SELECT * FROM agendaEtiqueta WHERE nombre='$asuntoNombre' AND idUsuario='$sesion'  ");
                                        $colorE = $query->fetch_array(MYSQLI_ASSOC);
                                        $colorEtiqueta= $colorE['etiqueta'];
                                        $colorTitulo= $colorE['titulo'];
                                        $colorSubtitulo= $colorE['subtitulo'];
                                        
                                  /// fin del proceso -->  
                                  
                                  
                                    $tipoPersonalValidando = $row['tipoPersonal'];
        		                    $personalIDValidando =  json_decode($row['personal']);
                                    $longitudValidando = count($personalIDValidando);
                                
                                        if($tipoPersonalValidando == 'usuario'){
                                            
                                            for($i=0; $i<$longitudValidando; $i++){
                                                
                                                $nombreActas = $mysqli->query("SELECT nombres, apellidos,cedula FROM usuario WHERE id = '$personalIDValidando[$i]' AND cedula='$sesion' ");
                                                $columnaValidando = $nombreActas->fetch_array(MYSQLI_ASSOC);
                                                //echo $cedulaGuardaro=$columnaValidando['cedula'];
                                                
                                                $cn = mysqli_num_rows($nombreActas);
                                                
                                                if($cn > 0){
                                                $conteoActasA++;  
                                                ?>
                                                <div class="time-label">
                                                    <span class="bg-danger">
                                                      <?php echo $fecha=$row['fecha'];  ?>
                                                    </span>
                                                    
                                                  </div>
                                                  
                                                  <div>
                                                    <i class="fas fa-envelope bg-primary"></i>
                            
                                                    <div class="timeline-item">
                                                      <span class="time" style="color:<?php echo $colorSubtitulo;?>;">
                                                          <i class="far fa-clock"></i> <?php echo $fecha=$row['hora'];?>
                                                      </span>
                                                        
                                                      <h3 class="timeline-header" style="background:<?php echo $colorEtiqueta;?>;color:<?php echo $colorSubtitulo;?>;"><a style="color:<?php echo $colorTitulo;?>;" href="#"><?php $asunto=$row['asunto']; if($asunto == 'Crear reunion'){ echo'Reunión programada'; }else{ echo 'Tarea programada'; }   ?></a> <?php echo $row['tematica'];?></h3>
                            
                                                      <div class="timeline-body">
                                                          Quién solicita,<br>
                                                            <?php 
                                                                    $solicitaUsuario= $row['idUsuario']; 
                                                                    $nombreuserSolicita = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$solicitaUsuario'");
                                                                    $columnaSolicita = $nombreuserSolicita->fetch_array(MYSQLI_ASSOC);
                                                                
                                                                    $cargoQuienSolicita=$columnaSolicita['cargo'];
                                                                    $cosultaCargoSolicitante=$mysqli->query("SELECT * FROM cargos WHERE id_cargos='$cargoQuienSolicita' ");
                                                                    $esxtraerCargoSolicitante=$cosultaCargoSolicitante->fetch_array(MYSQLI_ASSOC);
                                                                    echo $esxtraerCargoSolicitante['nombreCargos'].', ';
                                                                    echo $columnaSolicita['nombres']." ".$columnaSolicita['apellidos'];echo "<br>";
                                                            ?>
                                                          <br>
                                                       <?php echo 'Asunto: '.$tematica=$row['descripcion']; ?><br>
                                                       <?php echo 'Sitio: '.$row['sitio']; ?><br>
                                                       <br>Personal convocado:<br>
                                                       
                                                       <?php 
                                                        $tipoPersonal = $row['tipoPersonal'];
                                                        $personalID =  json_decode($row['personal']);
                                                        $longitud = count($personalID);
                                                            if($tipoPersonal == 'usuario'){
                                                                
                                                                for($i=0; $i<$longitud; $i++){
                                                                    
                                                                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalID[$i]'");
                                                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                
                                                                    echo $columna['nombres']." ".$columna['apellidos'];echo "<br>";
                                                                }
                                                           
                                                             
                                                            }
                                                            ?>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  
                                                  <div>
                                                    <i class="far fa-clock bg-gray"></i>
                                                  </div>
                                                <?php
                                                }
                                                
                                            } //// cierre del for
                                        } //// cierre del if
                                  
                                        if($tipoPersonalValidando == 'cargo'){
                                                    
                                                    for($i=0; $i<$longitudValidando; $i++){
                                                        
                                                        $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDValidando[$i]' 
                                                        AND usuario.cargo='$cargo' AND cargos.id_cargos=usuario.cargo ");
                                                        $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                        //echo $columna['nombreCargos'];
                                                        
                                                        $cn = mysqli_num_rows($nombrecargo);
                                                        
                                                        if($cn > 0){
                                                        $conteoActasA++;  
                                                        ?>
                                                        <div class="time-label">
                                                            <span class="bg-danger">
                                                              <?php echo $fecha=$row['fecha'];  ?>
                                                            </span>
                                                            
                                                          </div>
                                                          
                                                          <div>
                                                            <i class="fas fa-envelope bg-primary"></i>
                                    
                                                            <div class="timeline-item">
                                                              <span class="time" style="color:<?php echo $colorSubtitulo;?>;">
                                                                  <i class="far fa-clock"></i> <?php echo $fecha=$row['hora'];?>
                                                              </span>
                                    
                                                              <h3 class="timeline-header" style="background:<?php echo $colorEtiqueta;?>;color:<?php echo $colorSubtitulo;?>;"><a style="color:<?php echo $colorTitulo;?>;" href="#"><?php $asunto=$row['asunto']; if($asunto == 'Crear reunion'){ echo'Reunión programada'; }else{ echo 'Tarea programada'; }   ?></a> <?php echo $row['tematica'];?></h3>
                                    
                                                              <div class="timeline-body">
                                                                   Quién solicita,<br>
                                                                    <?php 
                                                                            $solicitaUsuario= $row['idUsuario']; 
                                                                            $nombreuserSolicita = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$solicitaUsuario'");
                                                                            $columnaSolicita = $nombreuserSolicita->fetch_array(MYSQLI_ASSOC);
                                                                        
                                                                            $cargoQuienSolicita=$columnaSolicita['cargo'];
                                                                            $cosultaCargoSolicitante=$mysqli->query("SELECT * FROM cargos WHERE id_cargos='$cargoQuienSolicita' ");
                                                                            $esxtraerCargoSolicitante=$cosultaCargoSolicitante->fetch_array(MYSQLI_ASSOC);
                                                                            echo $esxtraerCargoSolicitante['nombreCargos'].', ';
                                                                            echo $columnaSolicita['nombres']." ".$columnaSolicita['apellidos'];echo "<br>";
                                                                    ?>
                                                          
                                                                  <br>
                                                               <?php echo 'Asunto: '.$tematica=$row['descripcion']; ?><br>
                                                               <?php echo 'Sitio: '.$row['sitio']; ?><br>
                                                               <br>Personal convocado:<br>
                                                               
                                                               <?php 
                                                                $tipoPersonal = $row['tipoPersonal'];
                                                                $personalID =  json_decode($row['personal']);
                                                                $longitud = count($personalID);
                                                                    if($tipoPersonal == 'cargo'){
                                                                        
                                                                         for($i=0; $i<$longitud; $i++){
                                                                        $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$personalID[$i]'");
                                                                        $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                                        echo $columna['nombreCargos'];echo "<br>";
                                                                        }
                                                                   
                                                                     
                                                                    }
                                                                    /*
                                                                    else{
                                                                        
                                                                       
                                                                    }*/
                                                                    
                                                                    ?>
                                                              </div>
                                                            </div>
                                                          </div>
                                                          
                                                          <div>
                                                            <i class="far fa-clock bg-gray"></i>
                                                          </div>
                                                        <?php
                                                        }
                                                        
                                                    } //// cierre del for
                                                } //// cierre del if
                                 
                		            
                		            }
                                    ?>
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                  
                  
                  
                  
                  <!-- se agrega agendas -->
                  <div class="tab-pane" id="agenda">
                    
                    <section class="content-header">
                      <div class="container-fluid">
                        <div class="row mb-2">
                          <div class="col-sm-6">
                            <h1>Agenda</h1>
                          </div>
                        </div>
                      </div><!-- /.container-fluid -->
                    </section>
                    <section class="content">
                      <div class="container-fluid">
                        <div class="row">
                         
                         
                          <div class="col-9">
                                <div class="input-group">
                                    <form action="controlador/comunicacionInterna/controllerComunicacionInterna" method="POST">
                                        <table>
                                            <tr>
                                                <td>
                                                    <select id="new-event" type="text" name="solicitud" class="form-control" placeholder="Evento" required>
                                                        <option value=" ">Seleccionar..</option>
                                                        <option value="Crear reunion">Crear una reuni&oacute;n</option>
                                                        <option value="Crear tarea">Crear una tarea</option>
                                                        <option value="Reuniones programadas">Reuniones y tareas programadas</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="input-group-append">
                                                      <button id="add-new-event" type="submit" name="seleccionAgenda" class="btn btn-primary">Abrir</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                    
                                    <!-- /btn-group -->
                                </div>
                          
                          
                          
                          
                          
                          </div>
                          <!-- /.col -->
                        </div>
                        <!-- /.row -->
                      </div><!-- /.container-fluid -->
                    </section>
                  </div>
                  <!-- Fin se agrega agendas -->
                  
                  <!-- actividades -->
                   <div class="tab-pane" id="actividades">
                    <!-- The timeline -->
                    <h1>Actividades</h1>
                    <?php /* ?> se comenta las actividades perfil
                    <div class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      <!-- consultas para las atividades -->
                                    <?php
                                        ///////////// se trae el cargo del usuario
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $query = $mysqli->query("SELECT * FROM usuario WHERE cedula='$sesion'");
                                        $row = $query->fetch_array(MYSQLI_ASSOC);
                                        $cargoConteo= $row['cargo'];
                                        /////////// fin del proceso
                                        //////////conteo de solicitudes
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $sql= $mysqli->query("SELECT * FROM solicitudDocumentos WHERE encargadoAprobar='$cargoConteo' AND estado IS NULL ORDER BY id DESC");
    		                            while($row = $sql->fetch_assoc()){
                                        $fechaActividad= $row['fecha'];
                                        $nombreActividad= $row['nombreDocumento'];
                                        $solicitudActividad= $row['solicitud'];
                                        $estadoActividad= $row['estado'];
                                        $quienSolicitaActividad= $row['quienSolicita'];
                                        $dirigidoActividad= $row['encargadoAprobar'];
                                        ///////// fin del proceso
                                    ?>
                      <!--Fin proceso -->
                      <div class="time-label">
                        <span class="bg-danger">
                          <?php echo $fechaActividad; ?>
                        </span>
                      </div>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-envelope bg-primary"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> </span>

                          <h3 class="timeline-header"><a href="#"><?php echo $nombreActividad; ?></a> <?php echo $estadoActividad; ?></h3>

                          <div class="timeline-body">
                            <?php echo utf8_decode($solicitudActividad); ?>
                            <br><br><b>Qui&eacute;n realiza la solicitud:</b><br>
                            <?php       $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $query = $mysqli->query("SELECT * FROM usuario WHERE cedula='$quienSolicitaActividad'");
                                        $rowe = $query->fetch_array(MYSQLI_ASSOC);
                                        $nombreSolicitud= $rowe['nombres'];
                                        $apellidoSolicitud= $rowe['apellidos'];
                                        
                                        echo $nombreSolicitud.' '.$apellidoSolicitud;
                            ?>
                            <br><br><b>A Qui&eacute;n va dirigido:</b><br>
                            <?php       $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $query = $mysqli->query("SELECT * FROM cargos WHERE id_cargos='$dirigidoActividad'");
                                        $roww = $query->fetch_array(MYSQLI_ASSOC);
                                        echo $nombreDirigido= $roww['nombreCargos'];
                                        
                            ?>
                          </div>
                          <div class="timeline-footer">
                            <!--<a href="#" class="btn btn-primary btn-sm">Leer m&aacute;s</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a> -->
                                <form action="solicitudDocumentosSeguimiento" method="POST">
                                    <input type="hidden" readonly name="id" value="<?php echo $row['id'];?>">
                                    <button type="submit" class="btn btn-primary btn-sm">Leer m&aacute;s</button>
                                </form>
                          </div>
                        </div>
                      </div>
                      <!-- END timeline item -->
                      
                      <div>
                        <i class="far fa-clock bg-gray"></i>
                      </div>
                      <?php
    		                            }
                      ?>
                    </div>
                    <?php */ ?>
                    
                    
<!--COMPROMISOS INDIVIDUALES-->
                    
                    <div class="timeline timeline-inverse">
                        <?php
                        
                            $data = $mysqli->query("SELECT * FROM actas WHERE finalizada = 1 ORDER BY id ASC")or die(mysqli_error());
            
                            while($row = $data->fetch_assoc()){
                                
                                $idActa = $row['id'];
                                $nombreActa = $row['nombreActa'];
                                $estadoActa = $row['estado'];
                                $oculto = $row["estadoOculto"];
                                if($oculto == null){
                                    $oculto =  0;
                                }
                                
                                
                                if($estadoActa == 'Pendiente' ){
                                    
                                    if($row['aprobarActa'] == 'si' && $oculto == 0){
                                    
                                        $quienApruebaId = json_decode($row['quienApruebaId']);
                                              
                                      
                                            if(in_array($cargo,$quienApruebaId)){ //$cargoID
                                                
                                                
                                                
                                                ?>
                                                
                                                <div class="row">
                                                  <div class="col-md-12">
                                                    <!-- The time line -->
                                                    <div class="timeline">
                                                      <!-- timeline time label -->
                                                      <div class="time-label">
                                                        <span class="bg-red">Aprobar acta</span>
                                                      </div>
                                                      <!-- /.timeline-label -->
                                                      <!-- timeline item -->
                                                      <div>
                                                        <i class="fas fa-envelope bg-blue"></i>
                                                        <div class="timeline-item"><br>
                                                        <a name="ocultar" onclick="window.location='controlador/usuarios/controllerPerfil?ocultar=<?php echo $idActa;?>'" class="float-right btn-tool"><i class="fas fa-times"></i></a>

                                                          <h3 class="timeline-header"> </h3>
                                                          
                                        
                                                          <div class="timeline-body">
                                                              <b>Nombre del acta: </b><?php echo $nombreActa; ?><br>
                                                              <b>Estado del acta: </b><?php echo $estadoActa;?><br>
                                                     
                                                          </div>
                                                          <div class="timeline-footer">
                                                              <?php
                                                                  if($row['actaCargada'] == 1){
                                                                ?>
                                                                <form action="verActaC" method="POST">
                                                                    <input type="hidden" readonly name="idActa" value="<?php echo $idActa; ?>">
                                                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Ir al acta</button>
                                                                </form>
                                                                
                                                                <?php
                                                                      
                                                                  }else{
                                                                 
                                                                 ?>
                                                                 <form action="verActa" method="POST">
                                                                    <input type="hidden" readonly name="idActa" value="<?php echo $idActa; ?>">
                                                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Ir al acta</button>
                                                                </form>
                                                                 
                                                                 <?php
                                                                      
                                                                  }
                                                              
                                                              ?>
                                                            
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <!-- END timeline item -->
                                                     
                                                      <div>
                                                        <i class="fas fa-clock bg-gray"></i>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <!-- /.col -->
                                                </div>
                                                
                                                <?PHP
                                                    
                                            }
                                        
                                        
                                        if(in_array($idUsuario,$quienApruebaId)){ //$cargoID
                                                
                                                
                                                
                                                ?>
                                                
                                                <div class="row">
                                                  <div class="col-md-12">
                                                    <!-- The time line -->
                                                    <div class="timeline">
                                                      <!-- timeline time label -->
                                                      <div class="time-label">
                                                        <span class="bg-red">Aprobar acta</span>
                                                      </div>
                                                      <!-- /.timeline-label -->
                                                      <!-- timeline item -->
                                                      <div>
                                                        <i class="fas fa-envelope bg-blue"></i>
                                                        <div class="timeline-item"><br>
                                                        <a name="ocultar" onclick="window.location='controlador/usuarios/controllerPerfil?ocultar=<?php echo $idActa;?>'" class="float-right btn-tool"><i class="fas fa-times"></i></a>

                                                          <h3 class="timeline-header"> </h3>
                                                          
                                        
                                                          <div class="timeline-body">
                                                              <b>Nombre del acta: </b><?php echo $nombreActa; ?><br>
                                                              <b>Estado del acta: </b><?php echo $estadoActa;?><br>
                                                     
                                                          </div>
                                                          <div class="timeline-footer">
                                                              <?php
                                                                  if($row['actaCargada'] == 1){
                                                                ?>
                                                                <form action="verActaC" method="POST">
                                                                    <input type="hidden" readonly name="idActa" value="<?php echo $idActa; ?>">
                                                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Ir al acta</button>
                                                                </form>
                                                                
                                                                <?php
                                                                      
                                                                  }else{
                                                                 
                                                                 ?>
                                                                 <form action="verActa" method="POST">
                                                                    <input type="hidden" readonly name="idActa" value="<?php echo $idActa; ?>">
                                                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Ir al acta</button>
                                                                </form>
                                                                 
                                                                 <?php
                                                                      
                                                                  }
                                                              
                                                              ?>
                                                            
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <!-- END timeline item -->
                                                     
                                                      <div>
                                                        <i class="fas fa-clock bg-gray"></i>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <!-- /.col -->
                                                </div>
                                                
                                                <?PHP
                                                    
                                            }
                                    
                                    }
                                    
                                }
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $queryCompromisos = $mysqli->query("SELECT id, responsableCompromiso, responsableID, entregarA, entregarAID, estado, compromiso FROM `compromisos` WHERE idActa = '$idActa'");
                                
                                if(mysqli_num_rows($queryCompromisos) > 0 && $estadoActa == "Aprobado"){
                                    while($datoCompromiso = $queryCompromisos->fetch_assoc()){
                                        $responsableCompromiso = $datoCompromiso['responsableCompromiso']; 
                                        $responsableID = json_decode($datoCompromiso['responsableID']);
                                        $entregarA = $datoCompromiso['entregarA'];
                                        $entregarAID = json_decode($datoCompromiso['entregarAID']);
                                        $idCompromiso = $datoCompromiso['id'];
                                        $estadoGeneral = $datoCompromiso['estado'];
                                        $compromiso = $datoCompromiso['compromiso'];
                                        
                                        if($responsableCompromiso == "cargo"){
                                            if(in_array($cargoID,$responsableID)){
                                                $queryArhivo = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso' AND id_responsable = '$cargoID' ORDER BY id DESC");
                                                $datosArhivo = $queryArhivo->fetch_array(MYSQLI_ASSOC);
                                                $estadoCompromisoIndividual = $datosArhivo['estado'];
                                                
                                                if($estadoCompromisoIndividual == "Aprobado"){
                                                    continue;
                                                }
                                                
                                                ?>
                                                <div class="row">
                                                  <div class="col-md-12">
                                                    <!-- The time line -->
                                                    <div class="timeline">
                                                      <!-- timeline time label -->
                                                      <div class="time-label">
                                                        <span class="bg-red">ACTA: <?php echo $nombreActa;?></span>
                                                      </div>
                                                      <!-- /.timeline-label -->
                                                      <!-- timeline item -->
                                                      <div>
                                                        <i class="fas fa-envelope bg-blue"></i>
                                                        <div class="timeline-item">
                                                          
                                                          <h3 class="timeline-header">Realizar compromiso</h3>
                                        
                                                          <div class="timeline-body">
                                                              <b>Estado del Acta: </b><?php echo $estadoActa;?><br>
                                                              <b>Estado general del compromiso: </b><?php echo $estadoGeneral;?><br>
                                                              <b>Estado del compromiso individual: </b><?php echo $estadoCompromisoIndividual;?><br>
                                                              <b>Detalles del compromiso: </b><?php echo $compromiso;?><br>
                                                          </div>
                                                          <div class="timeline-footer">
                                                            <form action="seguimientoActas" method="POST">
                                                                <input name="nombreCompromiso" value="<?php echo $compromiso;?>" type="hidden">
                                                                <input type="hidden" readonly name="idActa" value="<?php echo $idActa; ?>">
                                                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Ir al compromiso</button>
                                                            </form>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <!-- END timeline item -->
                                                     
                                                      <div>
                                                        <i class="fas fa-clock bg-gray"></i>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <!-- /.col -->
                                                </div>
                                            
                                            
                                            <?php
                                                
                                                
                                                
                                            }
                                        }
                                        
                                        if($responsableCompromiso == "usuario"){
                                            if(in_array($idUsuario,$responsableID)){
                                                $queryArhivo3 = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso' AND id_responsable = '$idUsuario' ORDER BY id DESC");
                                                $datosArhivo3 = $queryArhivo3->fetch_array(MYSQLI_ASSOC);
                                                $estadoCompromisoIndividual3 = $datosArhivo3['estado'];
                                                
                                                if($estadoCompromisoIndividual3 == "Aprobado"){
                                                    continue;
                                                }
                                                
                                                ?>
                                                <div class="row">
                                                  <div class="col-md-12">
                                                    <!-- The time line -->
                                                    <div class="timeline">
                                                      <!-- timeline time label -->
                                                      <div class="time-label">
                                                        <span class="bg-red">ACTA: <?php echo $nombreActa;?></span>
                                                      </div>
                                                      <!-- /.timeline-label -->
                                                      <!-- timeline item -->
                                                      <div>
                                                        <i class="fas fa-envelope bg-blue"></i>
                                                        <div class="timeline-item">
                                                          
                                                          <h3 class="timeline-header">Realizar compromiso</h3>
                                        
                                                          <div class="timeline-body">
                                                              <b>Estado del Acta: </b><?php echo $estadoActa;?><br>
                                                              <b>Estado general del compromiso: </b><?php echo $estadoGeneral;?><br>
                                                              <b>Estado del compromiso individual: </b><?php echo $estadoCompromisoIndividual3;?><br>
                                                              <b>Detalles del compromiso: </b><?php echo $compromiso;?><br>
                                                          </div>
                                                          <div class="timeline-footer">
                                                            <form action="seguimientoActas" method="POST">
                                                                <input name="nombreCompromiso" value="<?php echo $compromiso;?>" type="hidden">
                                                                <input type="hidden" readonly name="idActa" value="<?php echo $idActa; ?>">
                                                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Ir al compromiso</button>
                                                            </form>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <!-- END timeline item -->
                                                     
                                                      <div>
                                                        <i class="fas fa-clock bg-gray"></i>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <!-- /.col -->
                                                </div>
                                            
                                            
                                            <?php
                                            }
                                        }
                                        
                                        ////Esta es la logica para el usuario que aprueba un compromiso. 
                                        
                                        
                                        $queryResponsablesIndi = $mysqli->query("SELECT estado FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso'");//con esta query validamos si algun compromiso individual esta pendiente y no se va a mostrar a menos que tenga un avance
                                        $noMostrarCompromisos = FALSE;
                                        
                                            $arrayEstados = array();
                                        
                                            while($row = $queryResponsablesIndi->fetch_assoc()){
                                                $estadoIndividualComp = $row['estado'];
                                                
                                                array_push($arrayEstados,$estadoIndividualComp);
                                                
                                            }
                                            
                                            //var_dump($arrayEstados);
                                        
                                        if(in_array('Avance',$arrayEstados) || in_array('Ejecutado',$arrayEstados)){
                                            
                                        }else{
                                            continue;
                                        }
                                        
                                        
                                        if($entregarA == "cargo"){
                                            if(in_array($cargoID,$entregarAID)){
                                                ?>
                                                <div class="row">
                                                  <div class="col-md-12">
                                                    <!-- The time line -->
                                                    <div class="timeline">
                                                      <!-- timeline time label -->
                                                      <div class="time-label">
                                                        <span class="bg-red">ACTA: <?php echo $nombreActa;?></span>
                                                      </div>
                                                      <!-- /.timeline-label -->
                                                      <!-- timeline item -->
                                                      <div>
                                                        <i class="fas fa-envelope bg-blue"></i>
                                                        <div class="timeline-item">
                                                          
                                                          <h3 class="timeline-header">Aprobar compromiso</h3>
                                        
                                                          <div class="timeline-body">
                                                              <b>Estado del Acta: </b><?php echo $estadoActa;?><br>
                                                              <b>Estado general del compromiso: </b><?php echo $estadoGeneral;?><br>
                                                              <b>Detalles del compromiso: </b><?php echo $compromiso;?><br><br>
                                                              <b>Gesti&oacute;n de compromiso:</b><br>
                                                              <?php
                                                                //query para trear todos los responsables que estan atados al compromiso. 
                                                               
                                                                $queryResponsablesIndi = $mysqli->query("SELECT * FROM `compromisos` WHERE id ='$idCompromiso'");
                                                                while($row = $queryResponsablesIndi->fetch_assoc()){
                                                                    $idreponsableTipo = $row['responsableCompromiso'];
                                                                    $idreponsable = json_decode($row['responsableID']);
                                                                    $longitudEntrega = count($idreponsable);
                                                                    if($idreponsableTipo == 'usuario'){
                                                                        for($i=0; $i<$longitudEntrega; $i++){ 
                                                                            $nombrecargo = $mysqli->query("SELECT * FROM usuario WHERE id ='$idreponsable[$i]'");
                                                                            $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                                            
                                                                            echo $columna['nombres'].' '.$columna['apellidos']; echo "<br>";        
                                                                            //echo "<b>Estado compromiso: </b>".$estadoIndividualComp;echo "<br><br>";
                                                                        }
                                                                    }
                                                                    if($idreponsableTipo == 'cargo'){
                                                                        for($i=0; $i<$longitudEntrega; $i++){ 
                                                                            $nombrecargo = $mysqli->query("SELECT nombreCargos,id_cargos FROM cargos WHERE id_cargos ='$idreponsable[$i]'");
                                                                            $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                                            
                                                                            echo $columna['nombreCargos'];echo"<br>";      
                                                                            //echo "<b>Estado compromiso: </b>".$estadoIndividualComp;echo "<br><br>";
                                                                        }    
                                                                    }
                                                                     
                                                                }
                                                               ?>
                                                               <br>
                                                               <b>Aprobación de compromiso:</b><br>
                                                               <?php
                                                                $queryentregaIndi = $mysqli->query("SELECT * FROM `compromisos` WHERE id ='$idCompromiso'");
                                                                while($row = $queryentregaIndi->fetch_assoc()){
                                                                    $idEntrega = json_decode($row['entregarAID']);
                                                                    $longitudEntrega = count($idEntrega);
                                                                    for($i=0; $i<$longitudEntrega; $i++){ 
                                                                        $nombrecargo = $mysqli->query("SELECT nombreCargos,id_cargos FROM cargos WHERE id_cargos ='$idEntrega[$i]'");
                                                                        $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                                        
                                                                        echo $columna['nombreCargos'];echo"<br>";      
                                                                        //echo "<b>Estado compromiso: </b>".$estadoIndividualComp;echo "<br><br>";
                                                                    } 
                                                                }
                                                              ?>
                                                              
                                                              
                                                              
                                                          </div>
                                                          <div class="timeline-footer">
                                                            <form action="seguimientoActasEntrega" method="POST">
                                                                <input name="nombreCompromiso" value="<?php echo $compromiso;?>" type="hidden">
                                                                <input type="hidden" readonly name="idActa" value="<?php echo $idActa; ?>">
                                                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Ir al compromiso</button>
                                                            </form>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <!-- END timeline item -->
                                                     
                                                      <div>
                                                        
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <!-- /.col -->
                                                </div>
                                                <?php
                                            }
                                        }
                                        
                                        if($entregarA == "usuario"){
                                            if(in_array($idUsuario,$entregarAID)){
                                                ?>
                                                <div class="row">
                                                  <div class="col-md-12">
                                                    <!-- The time line -->
                                                    <div class="timeline">
                                                      <!-- timeline time label -->
                                                      <div class="time-label">
                                                        <span class="bg-red">ACTA: <?php echo $nombreActa;?></span>
                                                      </div>
                                                      <!-- /.timeline-label -->
                                                      <!-- timeline item -->
                                                      <div>
                                                        <i class="fas fa-envelope bg-blue"></i>
                                                        <div class="timeline-item">
                                                          
                                                          <h3 class="timeline-header">Aprobar compromiso</h3>
                                        
                                                          <div class="timeline-body">
                                                              <b>Estado del Acta: </b><?php echo $estadoActa;?><br>
                                                              <b>Estado general del compromiso: </b><?php echo $estadoGeneral;?><br>
                                                              <b>Detalles del compromiso: </b><?php echo $compromiso;?><br><br>
                                                              <b>Gesti&oacute;n de compromiso:</b><br>
                                                              <?php
                                                                //query para trear todos los responsables que estan atados al compromiso. 
                                                                $queryResponsablesIndi = $mysqli->query("SELECT * FROM `compromisos` WHERE id ='$idCompromiso'");
                                                                while($row = $queryResponsablesIndi->fetch_assoc()){
                                                                     $idreponsableTipo = $row['responsableCompromiso'];
                                                                    $idResponsable = json_decode($row['responsableID']);
                                                                    if($idreponsableTipo == 'usuario'){
                                                                        $longitudEntrega = count($idResponsable);
                                                                        for($i=0; $i<$longitudEntrega; $i++){ 
                                                                        
                                                                            $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id ='$idResponsable[$i]' ");
                                                                            $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                           
                                                                            
                                                                           echo $columna['nombres'].' '.$columna['apellidos']; echo "<br>";  
                                                                            //echo "<b>Estado compromiso: </b>".$estadoIndividualComp;echo "<br><br>";
                                                                        }
                                                                    }
                                                                    if($idreponsableTipo == 'cargo'){
                                                                        $longitudEntrega = count($idResponsable);
                                                                        for($i=0; $i<$longitudEntrega; $i++){ 
                                                                        
                                                                        $nombrecargo = $mysqli->query("SELECT nombreCargos,id_cargos FROM cargos WHERE id_cargos ='$idResponsable[$i]'");
                                                                        $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                                        
                                                                            echo $columna['nombreCargos'];echo"<br>";        
                                                                            //echo "<b>Estado compromiso: </b>".$estadoIndividualComp;echo "<br><br>";
                                                                        }
                                                                    }
                                                                }
                                                               ?>
                                                               <br>
                                                               <b>Aprobación de compromiso:</b><br>
                                                               <?php
                                                                $queryREntregaIndi = $mysqli->query("SELECT * FROM `compromisos` WHERE id ='$idCompromiso'");
                                                                while($row = $queryREntregaIndi->fetch_assoc()){
                                                                    $idEntrega = json_decode($row['entregarAID']);
                                                                    $longitudEntrega = count($idEntrega);
                                                                    for($i=0; $i<$longitudEntrega; $i++){ 
                                                                    
                                                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id ='$idEntrega[$i]' ");
                                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                       
                                                                        
                                                                        $columna['nombres'].' '.$columna['apellidos']; echo "<br>";  
                                                                        //echo "<b>Estado compromiso: </b>".$estadoIndividualComp;echo "<br><br>";
                                                                    }
                                                                }
                                                              ?>
                                                              
                                                              
                                                              
                                                          </div>
                                                          <div class="timeline-footer">
                                                            <form action="seguimientoActasEntrega" method="POST">
                                                                <input name="nombreCompromiso" value="<?php echo $compromiso;?>" type="hidden">
                                                                <input type="hidden" readonly name="idActa" value="<?php echo $idActa; ?>">
                                                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Ir al compromiso</button>
                                                            </form>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <!-- END timeline item -->
                                                     
                                                      <div>
                                                        
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <!-- /.col -->
                                                </div>
                                            
                                            
                                            <?php
                                            }
                                        }
                                       
                                                
                                    }
                                }
                                
                            }
                            
                        ?>
                        <!--
                            <div class="row">
                              <div class="col-md-12">
                                <!-- The time line 
                                <div class="timeline">
                                  <!-- timeline time label
                                  <div class="time-label">
                                    <span class="bg-red">ACTA: <?php echo $nombreActa;?></span>
                                  </div>
                                  <!-- /.timeline-label 
                                  <!-- timeline item 
                                  <div>
                                    <i class="fas fa-envelope bg-blue"></i>
                                    <div class="timeline-item">
                                      
                                      <h3 class="timeline-header">Compromiso - Fecha de entrega: 10/06/2020 03:30 PM</h3>
                    
                                      <div class="timeline-body">
                                        <br>Estado general del compromiso: <b> A1<?php echo $row['estado'];?></b>
                                        <br>Estado del compromiso individual: <b> A2 <?php echo $estadoCompromisoIndividual;  ?></b>
                                        <br>Estado del Acta: <b> A3<?php echo $estadoActa;?></b> 
                                        <br>Detalles del compromiso:
                                      </div>
                                      <div class="timeline-footer">
                                        <a class="btn btn-primary btn-sm" >Read more</a>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- END timeline item 
                                 
                                  <div>
                                    <i class="fas fa-clock bg-gray"></i>
                                  </div>
                                </div>
                              </div>
                              <!-- /.col 
                            </div>
                        -->
                        
                    </div>
                    
                    
                    <!--COMPROMISOS INDIVIDUALES-->
                    
<!--APROBACION DE REGISTROS-->
                    
                    <div class="timeline timeline-inverse">
                        <?php
                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                            $dataRegistros = $mysqli->query("SELECT * FROM `registros` WHERE estado = 'Pendiente' OR estado = 'Rechazado' ")or die(mysqli_error());
                            //echo "ACA EL NUMERO DE REGISTROS: ".mysqli_num_rows($dataRegistros);
                            
                            while($row = $dataRegistros->fetch_assoc()){
                                
                                $idRegistro = $row['id'];
                                $responsable = $row['idResponsable'];
                                $estadoRegistro = $row['estado'];
                                $nombreRegistro = $row['nombre'];
                                $aprobador = $row['aprobador'];
                                $quienApruebaRId = json_decode($row['aprobadorID']);
                                $ruta = $row['carpeta'];
                                
                                if($responsable == $celdulaUser){
                                    ?>
                                    <div class="row">
                                                  <div class="col-md-12">
                                                    <!-- The time line -->
                                                    <div class="timeline">
                                                      <!-- timeline time label -->
                                                      <div class="time-label">
                                                        <span class="bg-red">Registro pendiente</span>
                                                      </div>
                                                      <!-- /.timeline-label -->
                                                      <!-- timeline item -->
                                                      <div>
                                                        <i class="fas fa-envelope bg-blue"></i>
                                                        <div class="timeline-item">
                                                          
                                                          <h3 class="timeline-header"> </h3>
                                        
                                                          <div class="timeline-body">
                                                              <b>Nombre del registro: </b><?php echo $nombreRegistro;?><br>
                                                              <b>Estado del registro: </b><?php echo $estadoRegistro;?><br>
                                                          </div>
                                                          <div class="timeline-footer">
                                                                <form action="editarRegistro" method="POST">
                                                                    <input type="hidden" readonly name="idRegistro" value="<?php echo $idRegistro; ?>">
                                                                    <input type="hidden" readonly name="ruta" value="<?php echo $ruta; ?>">
                                                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Ir al registro</button>
                                                                </form>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <!-- END timeline item -->
                                                     
                                                      <div>
                                                        <i class="fas fa-clock bg-gray"></i>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <!-- /.col -->
                                                </div>
                                    <?php
                                }
                                
                                
                                
                                if($aprobador == 'usuarios'){
                                    if(in_array($idUsuario,$quienApruebaRId)){
                                        if($estadoRegistro != "Aprobado"){
                                            ?>
                                            <div class="row">
                                                  <div class="col-md-12">
                                                    <!-- The time line -->
                                                    <div class="timeline">
                                                      <!-- timeline time label -->
                                                      <div class="time-label">
                                                        <span class="bg-red">Aprobar registro</span>
                                                      </div>
                                                      <!-- /.timeline-label -->
                                                      <!-- timeline item -->
                                                      <div>
                                                        <i class="fas fa-envelope bg-blue"></i>
                                                        <div class="timeline-item">
                                                          
                                                          <h3 class="timeline-header"> </h3>
                                        
                                                          <div class="timeline-body">
                                                              <b>Nombre del registro: </b><?php echo $nombreRegistro;?><br>
                                                              <b>Estado del registro: </b><?php echo $estadoRegistro;?><br>
                                                          </div>
                                                          <div class="timeline-footer">
                                                                <form action="verRegistro" method="POST">
                                                                    <input type="hidden" readonly name="idRegistro" value="<?php echo $idRegistro; ?>">
                                                                    <input type="hidden" readonly name="ruta" value="<?php echo $ruta; ?>">
                                                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Ir al registro</button>
                                                                </form>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <!-- END timeline item -->
                                                     
                                                      <div>
                                                        <i class="fas fa-clock bg-gray"></i>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <!-- /.col -->
                                                </div>
                                            <?php
                                        }
                                       
                                    }
                                }
                                
                                if($aprobador== 'cargos'){
                                    if(in_array($cargoID,$quienApruebaRId)){
                                        if($estadoRegistro != "Aprobado"){
                                            ?>
                                            <div class="row">
                                                  <div class="col-md-12">
                                                    <!-- The time line -->
                                                    <div class="timeline">
                                                      <!-- timeline time label -->
                                                      <div class="time-label">
                                                        <span class="bg-red">Aprobar registro</span>
                                                      </div>
                                                      <!-- /.timeline-label -->
                                                      <!-- timeline item -->
                                                      <div>
                                                        <i class="fas fa-envelope bg-blue"></i>
                                                        <div class="timeline-item">
                                                          
                                                          <h3 class="timeline-header"> </h3>
                                        
                                                          <div class="timeline-body">
                                                              <b>Nombre del registro: </b><?php echo $nombreRegistro;?><br>
                                                              <b>Estado del registro: </b><?php echo $estadoRegistro;?><br>
                                                          </div>
                                                          <div class="timeline-footer">
                                                                <form action="verRegistro" method="POST">
                                                                    <input type="hidden" readonly name="idRegistro" value="<?php echo $idRegistro; ?>">
                                                                    <input type="hidden" readonly name="ruta" value="<?php echo $ruta; ?>">
                                                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Ir al registro</button>
                                                                </form>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <!-- END timeline item -->
                                                     
                                                      <div>
                                                        <i class="fas fa-clock bg-gray"></i>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <!-- /.col -->
                                                </div>
                                            <?php
                                        }
                                    }
                                            
                                }
                
                            }  
                            
                        ?>
                        
                        
                    </div>
                    
                    
                    <!--APROBACION DE REGISTROS FIN-->
                    
                    
                    <!--Revision de documentos-->
                    
                    <?php
                    
                        include 'notificacionRevision.php';
                    ?>
                    
                    <!--Revision de documentos fin-->
                    
                    
                    
                    
                
                    
                     <div class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      <!-- consultas para las atividades -->
                                    <?php
                                        ///////////// se trae el cargo del usuario
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $query = $mysqli->query("SELECT * FROM usuario WHERE cedula='$sesion'");
                                        $row = $query->fetch_array(MYSQLI_ASSOC);
                                        $cargoConteo= $row['cargo'];
                                        /////////// fin del proceso
                                        //////////conteo de solicitudes
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $sql= $mysqli->query("SELECT * FROM `actividades` WHERE idUsuario='$sesion' ORDER BY id DESC ");
    		                            while($row = $sql->fetch_assoc()){
                                        $fechaActividadA= $row['fecha'];
                                        $idActividades= $row['id'];
                                        
                                        $tituloActividadA= $row['titulo'];
                                        $mensajeActividadA= $row['mensaje'];
                                        ///////// fin del proceso
                                        
                                        //////////// se trae el nombre del formulario
                                        $formularioActividadA=$row['iformulario'];
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $query = $mysqli->query("SELECT * FROM formularios WHERE idFormulario='$formularioActividadA'");
                                        $rowb = $query->fetch_array(MYSQLI_ASSOC);
                                        $nombreFormulario= $rowb['nombre'];
                                    ?>
                      <!--Fin proceso -->
                      <div class="time-label">
                        <span class="bg-danger">
                          <?php echo $fechaActividadA; ?>
                        </span>
                      </div>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-envelope bg-primary"></i>
                        <div class="timeline-item">
                            <br>
                        <a name="eliminar" onclick="window.location='controlador/usuarios/controllerPerfil?eliminar=<?php echo $idActividades;?>'" class="float-right btn-tool"><i class="fas fa-times"></i></a>

                          <h3 class="timeline-header"><a href="#"><?php echo $tituloActividadA; ?></a> M&oacute;dulo <b><?php echo $nombreFormulario; ?></b></h3>

                          <div class="timeline-body">
                            <?php echo $mensajeActividadA; ?>
                            
                          </div>
                          
                        </div>
                      </div>
                      <!-- END timeline item -->
                      <!--
                      <div>
                        <i class="far fa-clock bg-gray"></i>
                      </div>-->
                      <?php
    		                            }
                      ?>
                    </div>
                  </div>
                  <!-- Fin de actividads -->
                  
                 
                  
                  
                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal" action="controlador/usuarios/controllerPerfil" method="POST"><center><b>DATOS DEL PERFIL</b></center><br>
                      <input type="hidden" name="idPerfil" value="<?php echo $sesion; ?>" readonly>
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Nombre</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="nombre" value="<?php echo $nombres; ?>" id="inputName" placeholder="Nombre" readonly required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Apellidos</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="apellido" value="<?php echo $apellidos; ?>" id="inputName" placeholder="Apellido" readonly required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Correo</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" name="correo" value="<?php echo $correo; ?>" id="inputEmail" placeholder="Correo" readonly required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Contrase&ntilde;a</label>
                        <div class="col-sm-10">
                          <input  autocomplete="off" type="password" class="form-control" id="password" value="<?php echo $validacionClave; ?>"  placeholder="Contrase&ntilde;a" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || event.charCode == 13)" >
                          <br>
                          <span class="btn btn-success" onclick="mostrarContrasena()" >Mostrar contrase&ntilde;a</span>
                        </div>
                      </div>
                     <script>
                        function mostrarContrasena(){
                            var tipo = document.getElementById("password");
                            if(tipo.type == "password"){
                                tipo.type = "text";
                            }else{
                              tipo.type = "password";
                            }
                        }
                     </script>
                          <input type="hidden" class="form-control" name="pass1" value="<?php echo $validacionClave; ?>" id="inputName2" placeholder="Contrase&ntilde;a" required>
                        
                     <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Contrase&ntilde;a nueva</label>
                        <div class="col-sm-10">
                          <input autocomplete="off" type="password2" class="form-control" name="pass2" value="" id="inputName2" placeholder="Contrase&ntilde;a" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || event.charCode == 13)" >
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" name="ActualizarPerfil" class="btn btn-info">Actualizar</button>
                        </div>
                      </div>
                    </form>
                    
                     <form class="form-horizontal" action="controlador/usuarios/controllerPerfil" method="POST" enctype="multipart/form-data"><center><b>DATOS DEL USUARIO</b></center><br>
                      <input type="hidden" name="idPerfil" value="<?php echo $sesion; ?>" readonly>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Documento de identidad</label>
                        <div class="col-sm-10">
                          <input type="" class="form-control" readonly value="<?php echo $sesion; ?>" id="inputEmail" placeholder="Documento" disabled required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Teléfono</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" name="telefono" value="<?php echo $tel; ?>" id="inputName2" placeholder="teléfono" readonly required>
                        </div>
                      </div>
                       
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Cargo</label>
                        <?php
                            $query = $mysqli->query("SELECT * FROM cargos WHERE id_cargos='$cargo'");
                            //$row = $query->fetch_array(MYSQLI_ASSOC);
                        ?>
                        <div class="col-sm-10">
                          <select type="text" class="form-control" name="cargo" id="inputSkills" placeholder="Cargo" disabled required>
                            <?php 
                            while($row = $query->fetch_array()){
                            ?>
                            <option value="<?php echo $row['id_cargos'];?>"><?php echo $row['nombreCargos']; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                        <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Foto</label>
                        <div class="col-sm-10">
                          <?php
                          if($foto != NULL){
                          ?>  
                          <img class="profile-user-img img-fluid img-circle" src="data:image/jpg;base64, <?php echo base64_encode($foto); ?>" alt="User profile picture">
                          <?php
                          }else{
                          ?>
                          <img class="profile-user-img img-fluid img-circle" src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSAFdnwsj9XmZPJzlH-h95QvIm7QjUsIlHkpQ&usqp=CAU" alt="User profile picture">
                          <?php
                          }
                          ?>
                         <!-- <input type="file" name="foto" class="form-control" id="inputSkills">-->
                         <div class="form-group" >
                              <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="foto"  accept=".jpg,.jpeg,.png,.gif,.jpeg,.bmp,.svg,.jfif,.PNG,.JPEG,.GIF,.JPG,.TIFF,.PPM,.PGM,.PBM,.PNM,.BPG,.PPM,.DRW,.ECW,.FITS,.FLIF,.XCF,.SVG"> required>
                                    <!-- Agregamos esta linea para validar que solo sea el documento pdf-->
                                    <script>
                                    $('input[name="foto"]').on('change', function(){
                                        var ext = $( this ).val().split('.').pop();
                                        if ($( this ).val() != '') {
                                          if(ext == "jpg" || ext == "jpeg" || ext == "png" || ext == "gif" || ext == "jpe" || ext == "bmp" || ext =="svg"|| ext =="jfif" || ext == "PNG" || ext == "JPEG" || ext == "JPG" || ext == "TIFF" || ext =="PPM"|| ext =="PGM"|| ext =="PBM"|| ext =="PNM"|| ext =="BPG"|| ext =="PPM"|| ext =="DRW"|| ext =="ECW"|| ext =="FITS"|| ext =="FLIF"|| ext =="XCF"|| ext =="SVG"){
                                            
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
                                    <!-- END -->
                                    <label class="custom-file-label"></label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-text" id=""></span>
                                </div>
                             </div>
                             <label><h7>Formatos Permitidos: PNG,JPG,JPEG</h7></label>
                         </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" checked disabled required> Acepto términos y condiciones y autorizo a FIXWEI y RMS el tratamiento de mis datos. <span style="color:blue;">T&eacute;rminos y condiciones</span>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" name="ActualizarPerfil2" class="btn btn-info">Actualizar</button>
                        </div>
                      </div>
                    </form>
                    
                    <form action="controlador/comunicacionInterna/controllerComunicacionInterna" method="POST"><center><b>ETIQUETAS</b></center><br>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Nombre</label>
                        <div class="col-sm-10">
                          <select type="color" class="form-control" name="nombre" value="" id="inputEmail" placeholder="Documento"  required>
                             <option value="">Seleccionar..</option>
                             <option value="Crear reunion">Crear una reuni&oacute;n</option>
                             <option value="Crear tarea">Crear una tarea</option>
                           <!--  <option value="Reuniones programadas">Reuniones programadas</option>-->
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <table>
                                <thead>
                                <tr>
                                    <th>Color etiqueta</th>
                                    <th><font color="white">--</font></th>
                                    <th>Color t&iacute;tulo</th>
                                    <th><font color="white">--</font></th>
                                    <th>Color subt&iacute;tulo y hora</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input type="color" style="width:50px;" class="form-control" name="etiqueta" value="" id="inputEmail" placeholder="Documento"  required></td>
                                    <td><font color="white">--</font></td>
                                    <td><input type="color" style="width:50px;" class="form-control" name="titulo" value="" id="inputEmail" placeholder="Documento"  required></td>
                                    <td><font color="white">--</font></td>
                                    <td><input type="color" style="width:50px;" class="form-control" name="subtitulo" value="" id="inputEmail" placeholder="Documento"  required></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                      </div>
                      <!--
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Color t&iacute;tulo</label>
                        <div class="col-sm-10">
                          <input type="color" style="width:15%;" class="form-control" name="titulo" value="" id="inputEmail" placeholder="Documento"  required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Color subt&iacute;tulo y hora</label>
                        <div class="col-sm-10">
                          <input type="color" style="width:15%;" class="form-control" name="subtitulo" value="" id="inputEmail" placeholder="Documento"  required>
                        </div>
                      </div>
                      -->
                       
                      <input value="<?php echo $sesion; ?>" name="idUsuario" type="hidden">
                       <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" name="agendaEtiqueta" class="btn btn-success">Agregar</button>
                        </div>
                      </div>
                    </form>
                    
                    <h2>Vista previa</h2>
                    <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <div class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      <div class="time-label">
                      <?php
                        $sql= $mysqli->query("SELECT * FROM agendaEtiqueta WHERE idUsuario='$sesion' ");
    		            while($row = $sql->fetch_assoc()){
    		                
                      ?>
                      
                      
                        <span style="background:white;" class="">
                          Fecha
                        </span>
                        
                      </div>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <div>
                        <i class="fas fa-envelope bg-primary"></i>
                        <!-- se valida para mostrar bien el dato -->
                        <?php
                        $nombreEtiqueta=$row['nombre'];
                        if($nombreEtiqueta == 'Crear reunion'){
                            $nombreEtiquetaR='Crear reun&iacute;on';
                        }elseif($nombreEtiqueta == 'Crear tarea'){
                            $nombreEtiquetaR='Crear una tarea';
                        }elseif($nombreEtiqueta == 'Reuniones programadas'){
                            $nombreEtiquetaR='Reuniones programadas';
                        }
                        
                        ?>
                        <!-- fin del proceso-->
                        <div class="timeline-item">
                          <span class="time"style="color:<?php echo $row['subtitulo']; ?>;" ><i class="far fa-clock"></i> hora </span>

                          <h3 class="timeline-header" style="background:<?php echo $row['etiqueta']; ?>;color:<?php echo $row['subtitulo']; ?>;"><a  style="color:<?php echo $row['titulo']; ?>;" href="#">T&iacute;tulo</a> Subt&iacute;tulo</h3>
                          
                          <div class="timeline-body">
                            <?php echo $nombreEtiquetaR; ?><br><br>Personal convocado:<br>
                          
                           nombres
                           cargos
                           <br><br>
                           <form action="controlador/comunicacionInterna/controllerComunicacionInterna" method="POST">
                               <input value="<?php echo $row['id'];?>" name="eliminarEtiqueta" type="hidden" readonly>
                               <button type="submit" name="agendaEtiquetaEliminar" class="btn btn-danger">Eliminar</button>
                            </form>
                          </div>
                        </div>
                      <?php
    		            }
                        ?>
                      </div>
                      
                      <div>
                        <i class="far fa-clock bg-gray"></i>
                      </div>
                    </div>
                  </div>
                  
                      
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.0
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
 <?php
                    require 'controlador/usuarios/libreria/PHPMailerAutoload.php';
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $data = $mysqli->query("SELECT * FROM documento WHERE vigente = 1 AND pre IS NULL ORDER BY codificacion ASC")or die(mysqli_error());
                    //SELECT * FROM documento WHERE vigente = 1 AND revisado = 0 AND pre IS NULL ORDER BY codificacion ASC
                    while($row = $data->fetch_assoc()){
                        
                       /// validación para visualizar solo los documentos que necesito para pruebas
                       if($row['id'] == '19' || $row['id'] == '155' || $row['id'] == '154' ){
                           
                       }else{
                          // continue; //// 
                       }
                       // emd
                         
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
                        
                       
                        
                         "<tr>";    
                       
                         " <td style='text-align: justify;'>".$row['version']."</td>";
                         " <td style='text-align: justify;'>".$row['codificacion']."</td>";
                         " <td style='text-align: justify;'>".$row['nombres']."</td>";
                         $tipo = $row['tipo_documento'];
                         $acentos = $mysqli->query("SET NAMES 'utf8'");
                         $nombreTipoDocumento = $mysqli->query("SELECT * FROM tipoDocumento WHERE id ='$tipo'")or die(mysqli_error());
                         $colu = $nombreTipoDocumento->fetch_array(MYSQLI_ASSOC);
                         $nombreT = $colu['nombre'];
                         " <td style='text-align: justify;'>".$nombreT."</td>";
                         $proceso =  $row['proceso'];
                         $acentos = $mysqli->query("SET NAMES 'utf8'");
                         $nombreProceso = $mysqli->query("SELECT * FROM procesos WHERE id ='$proceso'")or die(mysqli_error());
                         $col3 = $nombreProceso->fetch_array(MYSQLI_ASSOC);
                         $nombreP = $col3['nombre'];
                         " <td style='text-align: justify;'>".$nombreP."</td>";
                         
                         " <td style='text-align: justify;'>".substr($row['fechaAprobado'],0,-8)."</td>"; //$row['fechaAprobado']
                         "<td style='text-align: justify;' >".$fechaRevisar."</td>"; //$mesesRevision    
                         "<td>";
                                "<form action='revisarDocumento' method='POST'>";
                                        "<input type='hidden' name='idDocumento' value='".$row['id']."'>";
                                        "<input type='hidden' name='idSolicitud' value='".$row['id_solicitud']."'>";
                                        "<button type='submit' class='btn btn-block btn-warning btn-sm'><i class='fas fa-eye'></i> Trazabilidad</button>";
                                    
                                "</form>";
                         "</td>";  
                          
                          
                          
                         //echo '<td>';
                            date_default_timezone_set("America/Bogota");
                            'Fecha inicial: '.$fechainicial = substr($row['fechaAprobado'],0,-8);
                            '<br>Fecha actual: '.$fechaactual = date("Y-m-d");
                            
                            
                            $preguntandoMeses=$row['mesesRevision'];
                            if($preguntandoMeses == 1){
                                 $tiempoRespuesta ='30';//$row['tiempoRespuesta'];
                            }else{
                                 $tiempoRespuesta =30*$row['mesesRevision'];//$row['tiempoRespuesta'];
                            }
                           
                            
                            '<br>Fecha validar: '.$fechaRestar = date("Y-m-d",strtotime($fechainicial."+ ".$tiempoRespuesta." days")); 
                            
                            $datetime1 = date_create($fechaRestar);
                            $datetime2 = date_create($fechaactual);
                            $contador = date_diff($datetime1, $datetime2);
                            $differenceFormat = '%a';
                            
                            
                             '<td>';
                              '<br>Contador: '.$contadorDíasNotificacion=$contador->format($differenceFormat);
                            $contadorDíasNotificacion=ABS($contadorDíasNotificacion-1);
                            //if($fechaRestar > $fechaactual){
                            
                            if($contadorDíasNotificacion > '30' ){
                                
                            //if($fechaRestar > $fechaactual){
                                 '<br>Sin avisar<br>';
                                //echo $contador->format($differenceFormat);
                            }else{
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
                                                          
                                                                      $mail->Subject=utf8_decode('Solicitud de documento (revisión documental)');
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
                                                                      Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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
                                                          
                                                                      $mail->Subject=utf8_decode('Solicitud de documento (revisión documental)');
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
                                                                      Se recomienda ingresar y verificar su solicitud.
                                                                      <br><br>
                                                                      Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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
                                                          
                                                                      $mail->Subject=utf8_decode('Solicitud de documento (revisión documental)');
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
                                                                      Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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
                                                          
                                                                      $mail->Subject=utf8_decode('Solicitud de documento (revisión documental)');
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
                                                                      Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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
                                                          
                                                                      $mail->Subject=utf8_decode('Solicitud de documento (revisión documental)');
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
                                                                      Este correo es informativo y por tanto, le pedimos no responda este mensaje.
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
                                           
                                }  
                            }
                             '</td>';
                            
                            
                            
                         
                        "</tr>";
                    }
                    

                    ?> 
<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jQuery UI -->
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>

<!-- se trae los script para que funcione el calendario -->
<!-- fullCalendar 2.2.5 -->
<script src="../plugins/moment/moment.min.js"></script>
<script src="../plugins/fullcalendar/main.min.js"></script>
<script src="../plugins/fullcalendar-daygrid/main.min.js"></script>
<script src="../plugins/fullcalendar-timegrid/main.min.js"></script>
<script src="../plugins/fullcalendar-interaction/main.min.js"></script>
<script src="../plugins/fullcalendar-bootstrap/main.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    ini_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()

    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendarInteraction.Draggable;

    var containerEl = document.getElementById('external-events');
    var checkbox = document.getElementById('drop-remove');
    var calendarEl = document.getElementById('calendar');

    // initialize the external events
    // -----------------------------------------------------------------

    new Draggable(containerEl, {
      itemSelector: '.external-event',
      eventData: function(eventEl) {
        console.log(eventEl);
        return {
          title: eventEl.innerText,
          backgroundColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          borderColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          textColor: window.getComputedStyle( eventEl ,null).getPropertyValue('color'),
        };
      }
    });

    var calendar = new Calendar(calendarEl, {
      plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid' ],
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      //Random default events
      events    : [
        {
          title          : 'All Day Event',
          start          : new Date(y, m, 1),
          backgroundColor: '#f56954', //red
          borderColor    : '#f56954' //red
        },
        {
          title          : 'Long Event',
          start          : new Date(y, m, d - 5),
          end            : new Date(y, m, d - 2),
          backgroundColor: '#f39c12', //yellow
          borderColor    : '#f39c12' //yellow
        },
        {
          title          : 'Meeting',
          start          : new Date(y, m, d, 10, 30),
          allDay         : false,
          backgroundColor: '#0073b7', //Blue
          borderColor    : '#0073b7' //Blue
        },
        {
          title          : 'Lunch',
          start          : new Date(y, m, d, 12, 0),
          end            : new Date(y, m, d, 14, 0),
          allDay         : false,
          backgroundColor: '#00c0ef', //Info (aqua)
          borderColor    : '#00c0ef' //Info (aqua)
        },
        {
          title          : 'Birthday Party',
          start          : new Date(y, m, d + 1, 19, 0),
          end            : new Date(y, m, d + 1, 22, 30),
          allDay         : false,
          backgroundColor: '#00a65a', //Success (green)
          borderColor    : '#00a65a' //Success (green)
        },
        {
          title          : 'Click for Google',
          start          : new Date(y, m, 28),
          end            : new Date(y, m, 29),
          url            : 'http://google.com/',
          backgroundColor: '#3c8dbc', //Primary (light-blue)
          borderColor    : '#3c8dbc' //Primary (light-blue)
        }
      ],
      editable  : true,
      droppable : true, // this allows things to be dropped onto the calendar !!!
      drop      : function(info) {
        // is the "remove after drop" checkbox checked?
        if (checkbox.checked) {
          // if so, remove the element from the "Draggable Events" list
          info.draggedEl.parentNode.removeChild(info.draggedEl);
        }
      }    
    });

    calendar.render();
    // $('#calendar').fullCalendar()

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#add-new-event').css({
        'background-color': currColor,
        'border-color'    : currColor
      })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      //Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.html(val)
      $('#external-events').prepend(event)

      //Add draggable funtionality
      ini_events(event)

      //Remove event from text input
      $('#new-event').val('')
    })
  })
</script>
<!-- para mostrar el archivo seleccionado en el file -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<!-- END -->
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<?php
/// validaciones de alertas
$validacionExiste=$_POST['validacionExiste'];
$validacionExisteB=$_POST['validacionExisteB'];
$validacionAgregar=$_POST['validacionAgregar'];
$validacionAgregarC=$_POST['validacionAgregarC'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];
$validacionEliminarB=$_POST['validacionEliminarB'];
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
            title: ' La contraseña no puede ser la misma que la actual.'
        })
    <?php
    }
    if($validacionExisteB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Los colores ya fueron asignados a la etiqueta.'
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
    if($validacionAgregarC == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: 'La solicitud de visualización fue aprobada.'
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
     if($validacionEliminarB == 1){
    ?>
        Toast.fire({
            type: 'error',
            title: 'La solicitud de visualización fue rechazada.'
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