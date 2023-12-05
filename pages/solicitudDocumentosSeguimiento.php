<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
//require_once 'inactividad.php';
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Seguimiento solicitud documentos</title>
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
            <h1>Seguimiento</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Seguimiento</li>
            </ol>
          </div>
        </div>
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                <div class="row">
                    <div class="col-sm">
                        <?php
                        if($_POST['cerrado'] == '1'){
                        ?>
                        <button type="button" class="btn btn-block btn-info btn-sm"><a href="solicitudDocumentosCerradas"><font color="white"><i class="fas fa-list "></i> Listar solicitudes</font></a></button>  
                        <?php
                        }else{
                        ?>
                        <button type="button" class="btn btn-block btn-info btn-sm"><a href="solicitudDocumentos"><font color="white"><i class="fas fa-list "></i> Listar solicitudes</font></a></button>  
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

    $tipoSolicitud = $_POST['tipoSolicitud'];
    
    $id = $_POST['id'];
    
    
    require 'conexion/bd.php';
    $acentos = $mysqli->query("SET NAMES 'utf8'");
    $data = $mysqli->query("SELECT * FROM solicitudDocumentos WHERE id = '$id'")or die(mysqli_error());
    while($row = $data->fetch_assoc()){
        $envio_asignado=$row['asignacion'];
        $enviarDatosId=$row['id'];
        $solicitud = $row['tipoSolicitud'];
        $enviarTipoSolicitud = $row['tipoSolicitud'];
        $solicitudTipo = $row['tipoSolicitud'];
        
        if($solicitud != 1){
            $nomb = $row['nombreDocumento'];
            $query2 = $mysqli->query("SELECT * FROM documento WHERE id ='$nomb'");
            $col2 = $query2->fetch_array(MYSQLI_ASSOC);
            
            if($col2['nombres'] != null){
                $nombre = $col2['nombres'];   
            }else{
                $nombre = $row['nombreDocumento2'];
            }
        }else{
            $nombre = $row['nombreDocumento2'];
        }
        $tipo =$row['tipoDocumento'];//variable para traer el tipo doc
        $query = $mysqli->query("SELECT * FROM tipoDocumento WHERE id = '$tipo'");
        $col = $query->fetch_array(MYSQLI_ASSOC);
        
        if($col['nombre'] != NULL){
            $tipoDoc = $col['nombre'];
        }else{
            $tipoDoc = $row['tpdG'];
        }
        $enviarEliminar = $row['nombreDocumento'];
        $solicitud = $row['solicitud'];
        $ruta = $row['documento'];
        $devuelto = $row['regresa'];
        $estado = $row['estado'];
        
        $quienAprueba = $row['QuienAprueba'];
        $idDocumentoActualizar = $row['nombreDocumento'];
        $quienSolicita = $row['encargadoAprobar']; 
        $cambioCargo = $row['cambioCargo'];
        $asignacion = $row['asignacion'];
        
                   
        }
?>    
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
              
                <div class="card-body">
                  <div class="form-group">
                    <h6 class="description-header"><b>Tipo Documento:</b></h6>
                    <span class=""><?php echo $tipoDoc;?></span>
                  </div>
                  <div class="form-group">
                    <h6 class="description-header"><b>Nombre:</b></h6>
                    <span class=""><?php echo $nombre;?></span>
                  </div>
                  <div class="form-group">
                    <h6 class="description-header"><b>Descripción de la solicitud:</b></h6>
                    <span class=""><?php echo $solicitud;?></span>
                  </div>
                  <!-- si el sistema detecta un registro de persona autorizada para visualizar el documento, se activa esta vista-->
                  <?php
                  $consulta_revision=$mysqli->query("SELECT * FROM `comnetariosRevision` WHERE idDocumento='".$col2['id']."' AND notificar is NOT null ");
                  $extraer_consulta=$consulta_revision->fetch_array(MYSQLI_ASSOC);
                  if($extraer_consulta['id'] != NULL){
                  ?>
                  <div class="form-group">
                    <h6 class="description-header"><b>Notificado para la visualización de revisión documental:</b></h6>
                    <span class="">
                    <?php 
                        '<br>Notificar a: '.$notificarEnviar=$extraer_consulta['notificar'];
                        '<br>Notificar Quien: '.$notificarQuienEnviar=$extraer_consulta['notificarQuien'];
                        '<br>';
                        if($notificarEnviar == 'usuarios'){
                            $arrayNotificar = json_decode($notificarQuienEnviar);
                            $longitudNotificar = count($arrayNotificar);
                            for($i=0; $i<$longitudNotificar; $i++){  '<br>Entra: '.$arrayNotificar[$i];
                                $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE id ='$arrayNotificar[$i]'  ")or die(mysqli_error()); //AND cedula='$cc'
                                while($usuariosCargo = $extraerUsuarios->fetch_array()){
                                echo '-'.$nombredelUsuario=($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']).'<br>';
                                }
                            }
                        }
                        
                        if($notificarEnviar == 'cargos'){
                            $arrayNotificar = json_decode($notificarQuienEnviar);
                            $longitudNotificar = count($arrayNotificar);
                            for($i=0; $i<$longitudNotificar; $i++){  '<br>Entra: '.$arrayNotificar[$i];
                                $queryNombres = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$arrayNotificar[$i]' ");
                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                $extraerUsuarios = $mysqli->query("SELECT * FROM usuario WHERE cargo ='".$arrayNotificar[$i]."'  ")or die(mysqli_error());
                                while($usuariosCargo = $extraerUsuarios->fetch_array()){
                                echo '-'.$nombredelUsuario=($usuariosCargo['nombres'].' '.$usuariosCargo['apellidos']).'<br>';
                                }
                            }
                        }
                    ?>
                    </span>
                  </div>
                  <?php
                  }
                  
                  if($_POST['revisionDocumental'] == '1'){ }else{
                    if($estado != NULL || $devuelto == '1'){
                  ?>
                      <div class="form-group">
                        <h6 class="description-header"><b>Estado:</b></h6>
                        <span class="">
                            <?php 
                            
                                if($devuelto == '1'){
                                    echo 'Regresado'; 
                                    
                                }else{ 
                                    echo $estado; 
                                } 
                            
                            ?>
                            
                        </span>
                      </div>
                  
                  <?php
                    }else{
                        /// si no viene ningun dao en estado no muestre nada
                    }
                   } 
                        $datos = $mysqli->query("SELECT * FROM comentarioSolicitud WHERE idSolicitud = '$id'");
                        'numeros: '.$rows =  mysqli_num_rows($datos);
                      
                        
                            
                            if($rows == 0){ 
                                $display = 'none';
                            }else{ 
                                $display = '';
                            }
                        
                        
                         
                  if($_POST['revisionDocumental'] == '1'){ }else{
                      
                  ?>
                  <div class="form-group" style="display:<?php echo $display;?>;">
                    <h6 class="description-header"><b>Comentarios Anteriores:</b></h6>
                    <?php
                    while($columnas = $datos->fetch_assoc()){
                        $comentarios = $columnas['comentario'];
                    ?>
                    <table><tr><td><span class=""><?php echo $comentarios;?></span></td></tr></table>
                    <?php 
                        
                    }
                    ?>
                  </div>
                 <?php
                 
                 
                  }
                 ?>
                  <div class="card-header">
                  <div class="card-title">
                    <?php
                    $ruta;
                    
                    
                    if($ruta == 'sin datos' || $ruta == NULL ){
                        /*
                    ?>  
                    <button type="button" disabled class="btn btn-block btn-warning btn-sm">
                        <i class="fas fa-download"></i>
                        Descargar 
                    </button>
                    <?php*/
                    }else{
                    ?>
                    <button type="button"  class="btn btn-block btn-warning btn-sm">
                        <i class="fas fa-download"></i>
                        <a style="color:black" href="<?php echo $ruta;?>" download="<?php echo $ruta;?>">Descargar</a>
                    </button>
                    <?php
                    }
                    ?>
                  </div>
                      
                   </div> 
                   
                  <form role="form" action="controlador/solicitudDocumentos/controller" method="post">
                      <input name="quienElabora" readonly value="<?php echo $sesion;?>" type="hidden">
                  <?php
                  
                          if($estado == 'Ejecutado'){
                              if($_POST['revisionDocumental'] == '1'){ }else{
                                echo '<br><font color="gray"><b>El documento se encuentra Ejecutado</b></font>';  
                              }
                          }
                          
                          if($estado == 'Aprobado'){
                              if($_POST['revisionDocumental'] == '1'){ }else{
                              echo '<br><font color="green"><b>El documento se encuentra Aprobado</b></font>';
                              }
                              ?>
                              
                              <?php
                          }
                          
                          
                          
                          
                    if($estado == 'Rechazado'){ 
                        if($devuelto == '1'){
                         ?>
                                <div class="form-group">
                                    <label>Acciones:</label>
                                    <select name="accion" id="optionSelect" class="form-control" onchange="ShowSelectedOption();" required>
                                      <option value="">Seleccione Opción</option>
                                     
                                      <option value="Rechazado">Rechazado</option>
                                      <option value="Aprobado">Aprobado</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label >Comentarios</label>
                                    <input autocomplete="off" type="text" class="form-control" id="comentarios" placeholder="" onkeypress="return ( (event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 46 ||  event.charCode == 44 || event.charCode == 58 || event.charCode == 59 || event.charCode == 13 || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || event.charCode == 46 ||  event.charCode == 44 || event.charCode == 58 || event.charCode == 59 || event.charCode == 13)" required>
                                </div>
                               
                         
                         <?php
                        }else{
                            if($_POST['revisionDocumental'] == '1'){
                                
                            }else{
                                echo '<br><font color="red"><b>El documento se encuentra Rechazado</b></font>';
                            }
                        }
                       //// se actualiza el campo para quitar la notificación de rechazo en las notificaciones
                            if(isset($_POST['rechazoAplicar'])){ 
                                $rechazo=$_POST['rechazoAplicar']; 
                                
                                $rechazoDocumento= $mysqli->query("UPDATE solicitudDocumentos SET rechazoSolicitud='$rechazo' WHERE id='$id'  ");
                                if($solicitud == 1){
                                
                                }else{
                                     'Tipo solicitud: : '.$enviarTipoSolicitud;
                                     '<br>Id solicitud: '.$nomb;
                                    if($enviarTipoSolicitud == '3'){
                                        $retirarEstado= $mysqli->query("UPDATE documento SET estadoElimina= NULL WHERE id='$nomb'  ");
                                    }
                                }
                            }
                       /// END
                    }else{  
                          
                         
                    if( $quienSolicita == $cargo || $cambioCargo == $cargo || $asignacion == $idparaChat){
                              
                            if($estado == 'Aprobado'){ }else{  
                    
                    /// agregamos esta validación, en caso que venga de una revisión documental como notificar a alguien diferente al encargador y diferente al lider, bloquea las acciones
                    if($_POST['revisionDocumental'] == '1'){}else{
                  ?>
                                <div class="form-group">
                                    <label>Acciones:</label>
                                    <select name="accion" id="select_acciones" class="form-control" onchange="ShowSelected();" required>
                                      <option value="">Seleccione Opción</option>
                                      <!-- <option value="Pendiente">Pendiente</option> -->
                                      <option value="Rechazado">Rechazado</option>
                                      <option value="Aprobado">Aprobado</option>
                                    </select>
                                </div>
                                <div class="form-group" id="diasDiv" style="display:none;">
                                    <label>Días Elaboración</label>
                                    <input type="number" id="diasNumeracion" class="form-control" name="dias" min="1" >
                                </div>
                                
                                <div class="form-group">
                                    <label >Comentarios</label>
                                    <input autocomplete="off" type="text" class="form-control" name="comentarios" placeholder="" onkeypress="return ( (event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 46 ||  event.charCode == 44 || event.charCode == 58 || event.charCode == 59 || event.charCode == 13 || event.charCode == 46 ||  event.charCode == 44 || event.charCode == 58 || event.charCode == 59 || event.charCode == 13 || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                                </div>
                  <?php
                    }
                    /// END
                            }
                         
                        }else{ //echo 'dato entrante revision documental: '.$_POST['revisionDocumental'];
                            if($_POST['revisionDocumental'] == '1'){
                                
                            }else{ //echo 'dato entrante revision documental: '.$_POST['revisionDocumental'];
                            echo '<br><font color="orange"><b>No tiene permisos para cambiar el estado de la solicitud</b></font>';
                            }
                        }
                    }
                  ?>
                 
                 <div class="col-sm-12">
                            <div class=""> <!-- card -->
                                <center>
                                    <br>
                                    <!--<p><h4>Control de cambios</h4></p>-->
                                </center>
                                <?php
                                if($_POST['revisionDocumental'] == '1'){ }else{
                                ?>
                                    <div style="padding: 20px;" class="tab-pane" id="timeline">
                                        <!-- The timeline -->
                                        <div class="timeline timeline-inverse">
                                          <!-- timeline time label -->
                                          <?php 
                                            $idSol = $datosDoc['id_solicitud'];
                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                            $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '$id' ")or die(mysqli_error($mysqli));
                                            
                                            while($row = $queryControl->fetch_assoc()){
                                                $idUser = $row['idUsuario'];
                                                $rol = $row['rol'];
                                                $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$idUser' ")or die(mysqli_error($mysqli));
                                                $datosUser = $queryUser->fetch_assoc();

                                                $nombreUsuario = $datosUser['nombres']." ".$datosUser['apellidos'];
                                          ?>
                                          
                                          <div class="time-label">
                                            <span class="bg-danger">
                                              <?php echo substr($row['fecha'],0,-8);?>
                                            </span>
                                          </div>

                                          <div>
                                            <i class="fas fa-user bg-info"></i>
                    
                                            <div class="timeline-item">
                                              
                                              <h3 class="timeline-header border-0"><b><?php echo $rol?></b> - <a href="#"><?php echo $nombreUsuario?></a> <?php echo nl2br($row['comentario']);?>
                                              </h3>
                                            </div>
                                          </div>
                                        <?php }?>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                 
                 
                </div>
                <!-- /.card-body -->
                
                <div class="card-footer" >
                    <?php
                  if($estado == 'Ejecutado'){
                      
                  }else{      
                  ?>
                    
                    <input type="hidden" name="id" value="<?php echo $id?>">
                    <input type="hidden" name="idDocumento" value="<?php echo $idDocumentoActualizar?>">
                    <input type='hidden' name='tipoSolicitud' value="<?php echo $tipoSolicitud;?>">
                    <input type='hidden' name='solicitud' value="<?php echo $solicitud;?>">
                     
                          <?php
                    if($cambioCargo == $cargo || $asignacion == $idparaChat){
                        if($estado == 'Aprobado' || $quienSolicita <> $cargo || $estado == 'Rechazado'){
                              
                        }else{
                    ?>
                    <button type="submit" name="seguimiento" class="btn btn-primary float-right">Enviar </button>
                    <?php
                        }
                    }else{
                          if($estado == 'Aprobado' || $quienSolicita <> $cargo || $estado == 'Rechazado'){
                              
                          }else{
                               /// agregamos esta validación, en caso que venga de una revisión documental como notificar a alguien diferente al encargador y diferente al lider, bloquea las acciones
                              if($_POST['revisionDocumental'] == '1'){}else{
                          ?>
                                <button type="submit" name="seguimiento" class="btn btn-primary float-right">Enviar </button>
               <?php
                              } // END
                         }
                    }
                  }
               ?>
                </div>
                <input name="idValidandoasignacion" type="hidden" value="<?php echo $id;?>">
              </form>
               <div class="card-footer" >
                   
                   
                   
                   
              <?php
                   
              
              if($estado == 'Aprobado' || $estado == 'Rechazado' || $quienSolicita <> $cargo){
             
                if($cambioCargo == $cargo || $asignacion == $idparaChat){ }else{
              ?>
              
              
                    <button onclick="window.location='solicitudDocumentos'"  class="btn btn-primary float-right">Cerrar</button>
                    
                      <button class="btn btn-primary float-right" style="background:transparent;border:0px;"><font color="white">----</font></button>
               
              <?php
                }
              }
              
              
               /// unicamente cuando fue rechazado desde el elaborador
                 if(isset($_POST['documentoRegresa'])){ //rechazoAplicar
                     $sqlDocumento=$mysqli->query("SELECT * FROM documento WHERe id_solicitud='$id' ");
                     $extraerSqlDocumento=$sqlDocumento->fetch_array(MYSQLI_ASSOC);
                     $variableIdDocumento=$extraerSqlDocumento['id'];
                     
                ?>   
                <form style="display:none;" id="formularioAsignar" name="miformulario" action="solicitudRechazadaDocRoles" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="idSolicitud" value="<?php echo $id; ?>">
                    <input type='hidden' name='idDoc' value='<?php echo $variableIdDocumento;?>'>
                    <input type="hidden" name="solicitud" value="<?php echo $solicitud; ?>">
                    <input type="hidden" placeholder="Comentarios a" class="form-control" id="comentarios2"  name="comentarios" >
                    <button type="submit" name="seguimiento" class="btn btn-success float-right">Asignar </button>
                </form> 
                 <form style="display:none;" id="formularioAsignarRechazo" name="miformulario" action="controlador/documentos/controllerRechazado" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="idSolicitud" value="<?php echo $id; ?>">
                    <input type="hidden" name='idDoc' value='<?php echo $variableIdDocumento;?>'>
                    <input type="hidden" name="solicitud" value="<?php echo $solicitud; ?>">
                    <input name="idUsuario" value="<?php echo $cc; ?>" type="hidden">
                    <input type="hidden" placeholder="Comentarios b" class="form-control" id="comentarios3"  name="comentarios" >
                    <button type="submit" name="cerrarDocumento" class="btn btn-success float-right">Cerrar solicitud</button>
                </form> 
                <script>
                                    $(document).ready(function () {
                                        $("#comentarios").keyup(function () {
                                                var value = $(this).val();
                                                $("#comentarios2").val(value);
                                        });
                                    });
                                    $(document).ready(function () {
                                        $("#comentarios").keyup(function () {
                                                var value = $(this).val();
                                                $("#comentarios3").val(value);
                                        });
                                    });
                </script>
               <?php    
               
                 }   // END
              
              
              
              if($quienAprueba == $sesion){
                  
                  if($solicitudTipo == 1){ 
                    // validamos que el documento ya ha sido aprobado y evitamos volver a llenar datos que ya existen
                    $consultandoDocumentos=$mysqli->query("SELECT * FROM documento WHERE id_solicitud='$enviarDatosId' ");
                    $extraerDocumentoEstado=$consultandoDocumentos->fetch_array(MYSQLI_ASSOC);
                    $extraerDoEstadoDocumento=$extraerDocumentoEstado['estado'];
                    // end

                    if($extraerDoEstadoDocumento == 'Aprobado' || $extraerDoEstadoDocumento == 'Pendiente' || $extraerDoEstadoDocumento == 'Elaborado' || $extraerDoEstadoDocumento == 'Revisado'){ }else{ 
                        if($estado == 'Rechazado'){ }else{
                    ?>
                    <form name="miformulario" action="crearDocumento" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="idSolicitud" value="<?php echo $id; ?>">
                        <input type="hidden" name="solicitud" value="<?php echo $solicitud; ?>">
                        <button type="submit" name="seguimiento" class="btn btn-success float-right">Asignar </button>
                    </form>
                    <?php
                        }
                    }
                  }
                  
                  if($solicitudTipo == 2){ //echo 'id solicitud: '.$enviarDatosId;
                  
                  // validamos que el documento ya ha sido aprobado y evitamos volver a llenar datos que ya existen
                    $consultandoDocumentos=$mysqli->query("SELECT * FROM documento WHERE id_solicitud='$enviarDatosId' ");
                    $extraerDocumentoEstado=$consultandoDocumentos->fetch_array(MYSQLI_ASSOC);
                    $extraerDoEstadoDocumento=$extraerDocumentoEstado['estadoActualiza'];
                    // end
                  
                  if($extraerDoEstadoDocumento == 'Aprobado' || $extraerDoEstadoDocumento == 'Pendiente' || $extraerDoEstadoDocumento == 'Elaborado' || $extraerDoEstadoDocumento == 'Revisado'){ }else{
                    if($estado == 'Rechazado'){ }else{
              ?>
                <form name="miformulario" action="actualizarDocRoles" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="idSolicitud" value="<?php echo $id; ?>">
                    <input type='hidden' name='idDoc' value='<?php echo $nomb;?>'>
                    <input type="hidden" name="solicitud" value="<?php echo $solicitud; ?>">
                    <button type="submit" name="seguimiento" class="btn btn-success float-right">Asignar </button>
                </form>
                <?php
                    }
                  }
                    
                  }
                  
                  if($solicitudTipo == 3){
                       if(isset($_POST['rechazoAplicar'])){ }else{
                           if(isset($_POST['documentoRegresa'])){ }else{
                               
                            'id elimi: '.$enviarEliminar;
                               
                            // validamos que el documento ya ha sido aprobado y evitamos volver a llenar datos que ya existen
                            $consultandoDocumentos=$mysqli->query("SELECT * FROM documento WHERE id='$enviarEliminar' ");
                            $extraerDocumentoEstado=$consultandoDocumentos->fetch_array(MYSQLI_ASSOC);
                            '<br>'.$extraerDoEstadoDocumento=$extraerDocumentoEstado['estadoElimina'];
                            // end
                 if($extraerDoEstadoDocumento == 'Aprobado' || $extraerDoEstadoDocumento == 'Pendiente' || $extraerDoEstadoDocumento == 'Elaborado' || $extraerDoEstadoDocumento == 'Revisado'){ }else{
                                
              ?>
                <form name="miformulario" action="eliminarDoc" method="POST" onsubmit="procesar(this.action);" >
                    <input type="hidden" name="idSolicitud" value="<?php echo $id; ?>">
                    <input type='hidden' name='idDocumento' value='<?php echo $nomb; ?>'>
                    <input type="hidden" name="solicitud" value="<?php echo $solicitud; ?>">
                    <button type="submit" name="seguimiento" class="btn btn-success float-right">Asignar </button>
                </form>
                <?php
                 }
                           }
                       }
                  }
              }
                
                ?>
              </div>
            </div>
            </div>    

        <div class="col">
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

<!--Select dinamico-->
<script type="text/javascript">
function ShowSelected(){
/* Para obtener el valor */
    var cod = document.getElementById("select_acciones").value;
    
    if(cod == "Aprobado"){
        document.getElementById('diasDiv').style.display = '';
        document.getElementById("diasNumeracion").setAttribute("required","any");
    }
     if(cod == "Rechazado"){
        document.getElementById('diasDiv').style.display = 'none';
        document.getElementById("diasNumeracion").removeAttribute("required","any");
    }
    


}

/// opciones para aprobar y rechazar la solicitud

function ShowSelectedOption(){
/* Para obtener el valor */
    var cod = document.getElementById("optionSelect").value;
    
    if(cod == "Aprobado"){  
        document.getElementById('formularioAsignar').style.display = '';
        document.getElementById('formularioAsignarRechazo').style.display = 'none';
    }
     if(cod == "Rechazado"){  
        document.getElementById('formularioAsignarRechazo').style.display = '';
        document.getElementById('formularioAsignar').style.display = 'none';
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
            title: ' El nivel o la prioridad ya existe.'
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
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
</body>
</html>
<?php
}
?>