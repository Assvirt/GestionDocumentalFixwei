<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    //header("login");
    require_once'cierreSesion.php';
}else{
//require_once 'inactividad.php';

$usuario = $_SESSION["session_username"];


///////// notificaciones para plataforma y correo
require_once 'conexion/bd.php';
$formulario = 'solicitudDocumentos'; //Se cambia el nombre del formulario
$documento = $_SESSION["session_username"];
$queryGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario = '$documento'");

while($row = $queryGrupos->fetch_assoc()){
    $idGrupo = $row['idGrupo'];
    
    $queryPermisos = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo = '$idGrupo' AND formulario = '$formulario'");
    
    $permisos = $queryPermisos->fetch_array(MYSQLI_ASSOC);
    if($permisos['plataforma'] == TRUE){
        $permisoPlataforma = $permisos['plataforma'];    
    }
    if($permisos['correo'] == TRUE){
        $permisoCorreo = $permisos['correo'];    
    }
    
}

if($permisoPlataforma == FALSE){
    $visibleP = 'none';
}else{
    $visibleP = '';
}

if($permisoCorreo == FALSE){
    $visibleC = 'none';
}else{
    $visibleC = '';
}

//////// fin notificaciones correo plataforma
?>
<!DOCTYPE html>
<html>
<head><meta charset="gb18030">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Solicitud documentos</title>
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
            <h1>Nueva Solicitud</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Nueva Solicitud</li>
            </ol>
          </div>
        </div>
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                <div class="row">
                    <div class="col-sm">
                        <button type="button" class="btn btn-block btn-info btn-sm"><a href="solicitudDocumentos"><font color="white"><i class="fas fa-list "></i> Listar solicitudes</font></a></button>    
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
    
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                
                <div class="card card-primary">
                <?php
                    $tipo = $_POST['tipo'];
                    
                    if($tipo == 1){
                        $selectCrear = "selected";    
                    }else{
                        $selectCrear = "";
                    }
                    
                    if($tipo == 3){
                        $selectEliminar = "selected";    
                    }else{
                        $selectEliminar = "";
                    }
                    
                    if($tipo == 2){
                        $selectActualizar = "selected";    
                    }else{
                        $selectActualizar = "";
                    }
                    
                ?>
              <!-- /.card-header -->
              <!-- form start -->
              
              
              
              
            <?php
            if($_POST['retorno'] != NULL){ /// cuando se devuelve porque el documento está mal
                 'id: '.$idRetorno=$_POST['idRetorno'];
                $consultandoSolicitud=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idRetorno' ");
                $extraerConsultaSolicitud=$consultandoSolicitud->fetch_array(MYSQLI_ASSOC);
            
                if($extraerConsultaSolicitud['tipoSolicitud'] == '1'){ // cuando es creación
            ?>
            <div class="card-body"> 
              <form action="controlador/solicitudDocumentos/controller" method="post" enctype="multipart/form-data" onsubmit="return checkSubmit();">
                  
                 
                    <label>Documento:</label>
                    <input autocomplete="off" class="form-control" type="text" value="<?php echo $extraerConsultaSolicitud['nombreDocumento'];?>" name="nombre" required>    
                    
                    <div class="form-group"><br>
                        <label>Procesos:</label>
                        <select name="proceso" class="form-control" required>
                        <?php
                         $consultaProceso=$mysqli->query("SELECT * FROM procesos WHERE id='".$extraerConsultaSolicitud['proceso']."' ");
                         $extraerConsultaProceso=$consultaProceso->fetch_array(MYSQLI_ASSOC);
                        ?>
                        <option value="<?php echo $extraerConsultaProceso['id'];?>"><?php echo $extraerConsultaProceso['nombre'];?></option>
                        <?php
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $resultado=$mysqli->query("SELECT * FROM procesos WHERE not id='".$extraerConsultaSolicitud['proceso']."'  ORDER BY nombre ASC");
                        while ($columna = mysqli_fetch_array( $resultado )) {
                        if($columna['estado'] == 'Eliminado'){
                                continue;
                            }
                        ?>
                        <option value="<?php echo $columna['id']; ?>"><?php echo $columna['nombre']; ?> </option>
                        <?php }  ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Tipo de documento:</label>
                        <select name="tipoDoc" class="form-control" required>
                        <?php
                        $consultaTD=$mysqli->query("SELECT * FROM tipoDocumento WHERE id='".$extraerConsultaSolicitud['tipoDocumento']."' ");
                        $extraerConsultaTD=$consultaTD->fetch_array(MYSQLI_ASSOC);
                        ?>
                        <option value="<?php echo $extraerConsultaTD['id'];?>"><?php echo $extraerConsultaTD['nombre'];?></option>
                        <?php
                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                        $resultados=$mysqli->query("SELECT * FROM tipoDocumento WHERE not id='".$extraerConsultaSolicitud['tipoDocumento']."' ORDER BY nombre ASC");
                        while ($columnas = mysqli_fetch_array( $resultados )) { ?>
                        
                        <option value="<?php echo $columnas['id']; ?>"><?php echo $columnas['nombre']; ?> </option>
                           <?php }  ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Encargado:</label>
                        <select name="encargado" class="form-control" required>
                        <?php
                        $consultaEncargado=$mysqli->query("SELECT * FROM cargos WHERE id_cargos='".$extraerConsultaSolicitud['encargadoAprobar']."' ");
                        $extraerConsultaEncargado=$consultaEncargado->fetch_array(MYSQLI_ASSOC);
                        ?>   
                        <option value="<?php echo $extraerConsultaEncargado['id_cargos'];?>"><?php echo $extraerConsultaEncargado['nombreCargos'];?></option>
                        <?php
                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                        $resultado2=$mysqli->query("SELECT * FROM cargos WHERE not id_cargos='".$extraerConsultaSolicitud['encargadoAprobar']."' ORDER BY nombreCargos ASC");
                        while ($columna = mysqli_fetch_array( $resultado2 )) { 
                        
                        /// solo muestre los cargos asignados en los usuarios
                        $validar_cargos_asignados=$mysqli->query("SELECT * FROM usuario WHERE cargo='".$columna['id_cargos']."' ");
                        $extraer_validar_cargos=$validar_cargos_asignados->fetch_array(MYSQLI_ASSOC);
                            if($extraer_validar_cargos['id'] != NULL){
                                
                            }else{
                                continue;
                            }
                        
                        ?>
                        <option value="<?php echo $columna['id_cargos']; ?>"><?php echo $columna['nombreCargos']; ?> </option>
                           <?php }  ?>
                        </select>
                    </div>
                    
                  <div class="form-group">
                    <label for="exampleInputPassword1">Descripción de la Solicitud:</label>
                    <textarea autocomplete="off" type="text" name="solicitud" class="form-control" value="" placeholder="" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || event.charCode == 46 ||  event.charCode == 44 || event.charCode == 58 || event.charCode == 59 || event.charCode == 13)" required><?php echo $extraerConsultaSolicitud['solicitud'];?></textarea>
                  </div>
                  
                  
                  <div class="form-group" >
                      
                      <label for="upload-photo">Archivo (Máx 10MB):</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input autocomplete="off" type="file" class="custom-file-input" id="miInput" name="archivo" >
                          <label class="custom-file-label" >Subir Archivo</label>
                          
                        </div>
                          <div class="input-group-append">
                            <span class="input-group-text" id="miInput">Subir</span>
                          </div>
                     </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                    <input autocomplete="off" type="hidden" name="usuario" value="<?php echo $usuario;?>">
                    <input autocomplete="off" type="hidden" name="solicitudID" value="<?php echo $extraerConsultaSolicitud['id'];?>">
                    <input autocomplete="off" type="hidden" name="Tiposolicitud" value="1">
                  <button  name="ActualizarAgregarSolicitud" type="submit" class="btn btn-primary float-right">Guardar</button>
                           
                </div>
              </form>
            <?php
                }else{
                
                
                
                
                
                    if($tipo != NULL){
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                    	$resultado = $mysqli->query("SELECT distinct(proceso) FROM documento WHERE vigente = '1' AND pre IS NULL ORDER BY estado ASC");
                    }else{
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $resultado = $mysqli->query("SELECT nombre, id AS proceso FROM procesos ORDER BY nombre");
                    }
                    
                    ?>
                    <div class="card-body">
                    <form action="controlador/solicitudDocumentos/controller" method="post" enctype="multipart/form-data" onsubmit="return checkSubmit();">
                    
                  
                   <input autocomplete="off" type="hidden" value="<?php echo $extraerConsultaSolicitud['nombreDocumento2'];?>" name="nombre" required> 
                    
                    <div class="form-group">
                        <label>Proceso:</label>
                        <select name="proceso" id="cbx_cedi" class="form-control" required>
                            
                        <?php
                         $consultaProceso=$mysqli->query("SELECT * FROM procesos WHERE id='".$extraerConsultaSolicitud['proceso']."' ");
                         $extraerConsultaProceso=$consultaProceso->fetch_array(MYSQLI_ASSOC);
                        ?>
                        <option value="<?php echo $extraerConsultaProceso['id'];?>"><?php echo $extraerConsultaProceso['nombre'];?></option>
                        
                         
                         <?php
                        while($row = $resultado->fetch_assoc()) { 
                            
				        $resultado2=$mysqli->query("SELECT * FROM procesos where id = '".$row['proceso']."' ORDER BY estado ASC");
				        $col = $resultado2->fetch_array(MYSQLI_ASSOC);
				        $nombreP = $col['nombre'];
    				        if($col['estado'] == 'Eliminado'){ 
    				        ?>
    				        <option value="<?php echo $row['proceso']; ?>" style="color:red;"><?php echo $nombreP.'-- '.$col['estado']; ?></option>
    				        <?php
        				        }else{
                              ?>
                              <option value="<?php echo $row['proceso']; ?>" style="color:green;"><?php echo $nombreP.' -- Activos'; ?></option>
                              <?php 
    				            
    				        } 
                        }
				            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Tipo de documento:</label>
                         <option value=""></option>
                        <div>
                            <select class="form-control" name="tipoDoc" id="cbx_bodega" required>
                            <?php
                            $consultaTD=$mysqli->query("SELECT * FROM tipoDocumento WHERE id='".$extraerConsultaSolicitud['tipoDocumento']."' ");
                            $extraerConsultaTD=$consultaTD->fetch_array(MYSQLI_ASSOC);
                            ?>
                            <option value="<?php echo $extraerConsultaTD['id'];?>"><?php echo $extraerConsultaTD['nombre'];?></option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Documentos:</label>
                        <div>
                            <select class="form-control" name="idDocumento" id="cbx_posicion" required>
                            <?php
                            if($extraerConsultaSolicitud['tipoSolicitud'] == '1'){
                                
                            }else{
                                $consultandoDocumento=$mysqli->query("SELECT * FROM documento WHERE  id='".$extraerConsultaSolicitud['nombreDocumento']."' ");
                                $extraerDocumentosConsulta=$consultandoDocumento->fetch_array(MYSQLI_ASSOC);
                            ?>
                            <option value="<?php echo $extraerDocumentosConsulta['id'];?>"><?php echo $extraerDocumentosConsulta['nombres'];?></option>
                            <?php
                            }
                            ?>
                            
                                
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Encargado:</label>
                        <select name="encargado" class="form-control" required>
                        <?php
                        $consultaEncargado=$mysqli->query("SELECT * FROM cargos WHERE id_cargos='".$extraerConsultaSolicitud['encargadoAprobar']."' ");
                        $extraerConsultaEncargado=$consultaEncargado->fetch_array(MYSQLI_ASSOC);
                        ?>   
                        <option value="<?php echo $extraerConsultaEncargado['id_cargos'];?>"><?php echo $extraerConsultaEncargado['nombreCargos'];?></option>
                        
                        <?php
                        require_once'conexion/bd.php';
                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                        $resultado2=$mysqli->query("SELECT * FROM cargos WHERE not id_cargos='".$extraerConsultaSolicitud['encargadoAprobar']."' ORDER BY nombreCargos ASC");
                        while ($columna = mysqli_fetch_array( $resultado2 )) {
                        
                            /// solo muestre los cargos asignados en los usuarios
                            $validar_cargos_asignados=$mysqli->query("SELECT * FROM usuario WHERE cargo='".$columna['id_cargos']."' ");
                            $extraer_validar_cargos=$validar_cargos_asignados->fetch_array(MYSQLI_ASSOC);
                            if($extraer_validar_cargos['id'] != NULL){
                                
                            }else{
                                continue;
                            }
                        
                        ?>
                        <option value="<?php echo $columna['id_cargos']; ?>"><?php echo $columna['nombreCargos']; ?> </option>
                           <?php }  ?>
                        </select>
                    </div>
                    
                      <div class="form-group">
                        <label for="exampleInputPassword1">Descripción de la Solicitud:</label>
                        <textarea autocomplete="off" name="solicitud" type="text" class="form-control" id="exampleInputPassword1" value="" placeholder="" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || event.charCode == 46 ||  event.charCode == 44 || event.charCode == 58 || event.charCode == 59 || event.charCode == 13)" required><?php echo $extraerConsultaSolicitud['solicitud'];?></textarea>
                      </div>
                  
                  
                      <div class="form-group" >
                          
                          <label for="upload-photo">Archivo (Máx 10MB):</label>
                          <div class="input-group">
                            <div class="custom-file">
                            <input autocomplete="off" type="file" class="custom-file-input" id="miInput" name="archivo"  >
                            <label class="custom-file-label" >Subir Archivo</label>
                            
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text" id="">Subir</span>
                          </div>
                         </div>
                      </div>


                  
                  
                        </div>
                        <!-- /.card-body -->
        
                        <div class="card-footer" >
                            <input autocomplete="off" type="hidden" name="usuario" value="<?php echo $usuario;?>">
                            <input autocomplete="off" type="hidden" name="solicitudID" value="<?php echo $extraerConsultaSolicitud['id'];?>">
                            <!--<input autocomplete="off" type="hidden" name="tipoSolicitud" value="<?php //echo $extraerConsultaSolicitud['tipoSolicitud'];?>">-->
                             <input autocomplete="off" type="hidden" name="Tiposolicitud" value="<?php echo $extraerConsultaSolicitud['tipoSolicitud'];?>">
                            <button  name="ActualizarAgregarSolicitud" type="submit" class="btn btn-primary float-right">Guardar</button>
                          
                                   
                        </div>
                      </form>
              
                
                
                <?php
                }
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
                                  <h4 class="modal-title">Alerta</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>El nombre del archivo contiene un caracteres inválidos, por favor digite el nombre completo del archivo e intente cargar.</p>
                                </div>
                                 <!-- END formulario para eliminar por el id -->
                              </div>
                            </div>
                        </div>
            <?php    
            }else{
            ?>
                <form role="form" action="" method="POST">
                <div class="card-body">
                   

                  <div class="form-group">
                        <label>Tipo Solicitud:</label>
                        <select class="form-control" name="tipo" onchange = "this.form.submit()" required>
                          <option value="">Seleccione</option>
                          <option value="1" <?php echo $selectCrear?> >Crear</option>
                          <option value="2" <?php echo $selectActualizar?> >Actualizar</option>
                          <option value="3" <?php echo $selectEliminar?> >Eliminar</option>
                        </select>
                    </div>
                </form>    
                    
                <?php 
                $tipo = $_POST['tipo'];
                if($tipo != 1){
                            
                        
                    ?> 
                    <?php
                    	require ('conexion/bd.php');
                    if($tipo != NULL){
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                    	$resultado = $mysqli->query("SELECT distinct(proceso) FROM documento WHERE vigente = '1' AND pre IS NULL ORDER BY estado ASC");
                    }else{
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $resultado = $mysqli->query("SELECT nombre, id AS proceso FROM procesos ORDER BY nombre");
                    }
                    
                    ?>
                    <form action="controlador/solicitudDocumentos/controller" method="post" enctype="multipart/form-data" onsubmit="return checkSubmit();">
                    
                   
                <!-- parametros para la activacion de correo y plataforma -->
                    <div class="row"> 
                        <div class="form-group col-sm-6">
                          <input autocomplete="off" name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden" readonly>
                          <!--<label>Notificaciones por: </label>&nbsp;&nbsp;-->
                              <?php if($visibleP != 'none'){ ?>
                              
                                <!--<label>Plataforma</label>-->
                                    <input autocomplete="off" style="border:0px;" name="plataforma" value="1" type="hidden" readonly>
                                <?php }else{  }
                          
                              if($visibleP != 'none' && $visibleC != 'none'){
                                   '-';
                              }
                          
                                    if($visibleC != 'none'){ ?>
                                <!--<label>Correo</label>-->
                                    <input autocomplete="off" style="border:0px;" name="correo" value="1" type="hidden" readonly>
                                <?php }else{  } ?>
                        </div>
                    </div>
                <!-- Fin parametros para la activacion de correo y plataforma -->
                    
                    <div class="form-group">
                        <label>Proceso:</label>
                        <select name="proceso" id="cbx_cedi" class="form-control" required>
                        <option value=""></option> 
                         <?php
                        while($row = $resultado->fetch_assoc()) { 
                            
				        $resultado2=$mysqli->query("SELECT * FROM procesos where id = '".$row['proceso']."' ORDER BY estado ASC");
				        $col = $resultado2->fetch_array(MYSQLI_ASSOC);
				        $nombreP = $col['nombre'];
    				        if($col['estado'] == 'Eliminado'){ 
    				        ?>
    				        <option value="<?php echo $row['proceso']; ?>" style="color:red;"><?php echo $nombreP.'-- '.$col['estado']; ?></option>
    				        <?php
        				        }else{
                              ?>
                              <option value="<?php echo $row['proceso']; ?>" style="color:green;"><?php echo $nombreP.' -- Activos'; ?></option>
                              <?php 
    				            
    				        } 
                        }
				            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Tipo de documento:</label>
                         <option value=""></option>
                        <div><select class="form-control" name="tipoDoc" id="cbx_bodega" required></select></div>
                    </div>
                    
                    <div class="form-group">
                        <label>Documentos:</label>
                        <div><select class="form-control" name="idDocumento" id="cbx_posicion" required></select></div>
                    </div>
                    <?php
                            require_once'conexion/bd.php';
                            $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                            $resultado2=$mysqli->query("SELECT * FROM cargos ORDER BY nombreCargos ASC");
                    ?>
                    <div class="form-group">
                        <label>Encargado:</label>
                        <select name="encargado" class="form-control" required>
                           <?php
                            ?>
                        <option value=""></option>
                        <?php
                        while ($columna = mysqli_fetch_array( $resultado2 )) {
                            /// solo muestre los cargos asignados en los usuarios
                            $validar_cargos_asignados=$mysqli->query("SELECT * FROM usuario WHERE cargo='".$columna['id_cargos']."' ");
                            $extraer_validar_cargos=$validar_cargos_asignados->fetch_array(MYSQLI_ASSOC);
                            if($extraer_validar_cargos['id'] != NULL){
                                
                            }else{
                                continue;
                            }
                        ?>
                        <option value="<?php echo $columna['id_cargos']; ?>"><?php echo $columna['nombreCargos']; ?> </option>
                           <?php }  ?>
                        </select>
                    </div>
                    
                  <div class="form-group">
                    <label for="exampleInputPassword1">Descripción de la Solicitud:</label>
                    <textarea autocomplete="off" name="solicitud" type="text" class="form-control" id="exampleInputPassword1" placeholder="" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || event.charCode == 46 ||  event.charCode == 44 || event.charCode == 58 || event.charCode == 59 || event.charCode == 13)" required></textarea>
                  </div>
                  <?php
                  
                    if($tipo == 3){
                        $visibleSubir = "none";
                       
                    }else{
                        $visibleSubir = "";
                    }
           
                  ?>
                  
                  <div class="form-group" style="display:<?php echo $visibleSubir;?>">
                      
                      <label for="upload-photo">Archivo (Máx 10MB):</label>
                      <div class="input-group">
                        <div class="custom-file">
                        <input autocomplete="off" type="file" class="custom-file-input" id="miInput" name="archivo"  >
                        <label class="custom-file-label" >Subir Archivo</label>
                        
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Subir</span>
                      </div>
                     </div>
                  </div>


                  
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                    <input autocomplete="off" type="hidden" name="usuario" value="<?php echo $usuario;?>">
                    <input autocomplete="off" type="hidden" name="tipoSolicitud" value="<?php echo $tipo;?>">
                  <button id="validarOcultarB" name="agregarSolicitud2" type="submit" class="btn btn-primary float-right">Guardar</button>
                            <!--
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
                            <div id="cargandoB" class="preloader float-right" style="display:none;"></div>
                            <script>
                                $(document).ready(function(){
                                    $('#validarOcultarB').click(function(){
                                        document.getElementById('cargandoB').style.display = '';
                                        document.getElementById('validarOcultarB').style.display = 'none';
                                    });
                                });
                            </script>
                            -->
                </div>
              </form>
              <?php
                }else{
              ?>
              <form action="controlador/solicitudDocumentos/controller" method="post" enctype="multipart/form-data" onsubmit="return checkSubmit();">
                  
                  <!-- parametros para la activacion de correo y plataforma -->
                    <div class="row"> 
                        <div class="form-group col-sm-6">
                          <input autocomplete="off" name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden" readonly>
                          <!--<label>Notificaciones por: </label>&nbsp;&nbsp;-->
                              <?php if($visibleP != 'none'){ ?>
                              
                                <!--<label>Plataforma</label>-->
                                    <input autocomplete="off" style="border:0px;" name="plataforma" value="1" type="hidden" readonly>
                                <?php }else{  }
                          
                              if($visibleP != 'none' && $visibleC != 'none'){
                                   '-';
                              }
                          
                                    if($visibleC != 'none'){ ?>
                                <!--<label>Correo</label>-->
                                    <input autocomplete="off" style="border:0px;" name="correo" value="1" type="hidden" readonly>
                                <?php }else{  } ?>
                        </div>
                    </div>
                <!-- Fin parametros para la activacion de correo y plataforma -->
                  
                  
                    <label>Documento:</label>
                    <input autocomplete="off" class="form-control" type="text"  name="nombre" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>    
                    <?php
                            require_once'conexion/bd.php';
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $resultado=$mysqli->query("SELECT * FROM procesos ORDER BY nombre ASC");
                    ?>
                    <div class="form-group"><br>
                        <label>Procesos:</label>
                        <select name="proceso" class="form-control" required>
                        <option value=""></option>
                         <?php
                        while ($columna = mysqli_fetch_array( $resultado )) {
                        if($columna['estado'] == 'Eliminado'){
                                continue;
                            }
                        ?>
                        <option value="<?php echo $columna['id']; ?>"><?php echo $columna['nombre']; ?> </option>
                        <?php }  ?>
                        </select>
                    </div>
                    <?php
                            require_once'conexion/bd.php';
                            $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                            $resultados=$mysqli->query("SELECT * FROM tipoDocumento ORDER BY nombre ASC");
                    ?>
                    <div class="form-group">
                        <label>Tipo de documento:</label>
                        <select name="tipoDoc" class="form-control" required>
                          <?php
                          ?>
                        <option value=""></option>
                        <?php
                        while ($columnas = mysqli_fetch_array( $resultados )) { ?>
                        
                        <option value="<?php echo $columnas['id']; ?>"><?php echo $columnas['nombre']; ?> </option>
                           <?php }  ?>
                        </select>
                    </div>
                    <?php
                            require_once'conexion/bd.php';
                            $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                            $resultado2=$mysqli->query("SELECT * FROM cargos ORDER BY nombreCargos ASC");
                    ?>
                    <div class="form-group">
                        <label>Encargado:</label>
                        <select name="encargado" class="form-control" required>
                            
                           <?php ?>
                        <option value=""></option>
                        <?php
                        while ($columna = mysqli_fetch_array( $resultado2 )) {
                            
                            /// solo muestre los cargos asignados en los usuarios
                            $validar_cargos_asignados=$mysqli->query("SELECT * FROM usuario WHERE cargo='".$columna['id_cargos']."' ");
                            $extraer_validar_cargos=$validar_cargos_asignados->fetch_array(MYSQLI_ASSOC);
                            if($extraer_validar_cargos['id'] != NULL){
                                
                            }else{
                                continue;
                            }
                        ?>
                        <option value="<?php echo $columna['id_cargos']; ?>"><?php echo $columna['nombreCargos']; ?> </option>
                           <?php }  ?>
                        </select>
                    </div>
                    
                  <div class="form-group">
                    <label for="exampleInputPassword1">Descripción de la Solicitud:</label>
                    <textarea autocomplete="off" type="text" name="solicitud" class="form-control" id="" placeholder="" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || event.charCode == 46 ||  event.charCode == 44 || event.charCode == 58 || event.charCode == 59 || event.charCode == 13)" required></textarea>
                  </div>
                  
                  
                  <div class="form-group" >
                      
                      <label for="upload-photo">Archivo (Máx 10MB):</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input autocomplete="off" type="file" class="custom-file-input" id="miInput" name="archivo" >
                          <label class="custom-file-label" >Subir Archivo</label>
                          
                        </div>
                          <div class="input-group-append">
                            <span class="input-group-text" id="miInput">Subir</span>
                          </div>
                     </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                    <input autocomplete="off" type="hidden" name="usuario" value="<?php echo $usuario;?>">
                    <input autocomplete="off" type="hidden" name="tipoSolicitud" value="<?php echo $tipo;?>">
                  <button id="validarOcultar" name="agregarSolicitud" type="submit" class="btn btn-primary float-right">Guardar</button>
                            <!--
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
                                $(document).ready(function(){
                                    $('#validarOcultar').click(function(){
                                        document.getElementById('cargando').style.display = '';
                                        document.getElementById('validarOcultar').style.display = 'none';
                                    });
                                });
                            </script>
                            -->
                </div>
              </form>
              <?php }
            }
                ?>
            
            
            
            <?php
            // activamos esta alerta solo para el documento que está en obsoleto emitido por una actualización
            if($_POST['alertaDocumentoActuliza'] != NULL){
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
                                  <h4 class="modal-title">Alerta</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    $documento_consulta_obsoleto = $mysqli->query("SELECT * FROM documento WHERE id ='".$_POST['idDocumentoAlerta']."' ")or die(mysqli_error());
                                    $nombdocumento_consulta_obsoleto = $documento_consulta_obsoleto->fetch_array(MYSQLI_ASSOC);
                                    ?>
                                  <p>El documento <?php echo $nombdocumento_consulta_obsoleto['nombres'];?> con la codificación <?php echo $nombdocumento_consulta_obsoleto['codificacion'].' versión '.$nombdocumento_consulta_obsoleto['version']; ?> ya se encuentra en obsoleto.</p>
                                </div>
                                 <!-- END formulario para eliminar por el id -->
                              </div>
                            </div>
                        </div>
            <?php
            }
            ?>
              
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
<script>
         enviando = false; //Obligaremos a entrar el if en el primer submit
    
        function checkSubmit() {
            if (!enviando) {
        		enviando= true;
        		return true;
            } else {
                //Si llega hasta aca significa que pulsaron 2 veces el boton submit
                //alert("El formulario ya se esta enviando");
                return false;
            }
        }
</script>
<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- bs-custom-file-input -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
    const MAXIMO_TAMANIO_BYTES = 11000000; // 1MB = 1 millón de bytes

// Obtener referencia al elemento
const $miInput = document.querySelector("#miInput");

$miInput.addEventListener("change", function () {
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
		$miInput.value = "";
	} else {
		// Validación asada. Envía el formulario o haz lo que tengas que hacer
	}
});
</script>

<script language="javascript">
			$(document).ready(function(){
				$("#cbx_cedi").change(function () {

					$('#cbx_posicion').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
					
					$("#cbx_cedi option:selected").each(function () {
						id_cedi = $(this).val();
						$.post("selectDinamico2.php", { id_cedi: id_cedi }, function(data){
							$("#cbx_bodega").html(data);
						});            
					});
				})
			});
			
			$(document).ready(function(){
				$("#cbx_bodega").change(function () {
					$("#cbx_bodega option:selected").each(function () {
						id_bodega = $(this).val();
						$.post("selectDinamico3.php", { id_bodega: id_bodega, id_cedi: id_cedi }, function(data){
							$("#cbx_posicion").html(data);
						});           
					});
				})
			});
</script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>

<script type="text/javascript">
  $(function() {
    
    
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