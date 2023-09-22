<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

///////// notificaciones para plataforma y correo
require_once 'conexion/bd.php';
$formulario = 'actas'; //Se cambia el nombre del formulario
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
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Cargar Acta</title>
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
  <!-- summernote -->
  <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.css">
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
            <h1>Cargar Acta</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Cargar Acta</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="actas"><font color="white"><i class="fas fa-list"></i> Listar Actas</font></a></button>
                        </div>
                        <div class="col-sm">
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
            <div class="col-12">
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3> 
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/actas/controller" method="POST" enctype="multipart/form-data" onsubmit="return checkSubmit();">
                  <!-- parametros para la activacion de correo y plataforma -->
                   
                          <input name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden" readonly>
                          <!--<label>Notificaciones por: </label>&nbsp;&nbsp;-->
                              <?php if($visibleP != 'none'){ ?>
                              
                              <!--  <label>Plataforma</label>-->
                                    <input style="border:0px;" name="plataforma" value="1" type="hidden" readonly>
                                <?php }else{  }
                          
                              if($visibleP != 'none' && $visibleC != 'none'){
                                  //echo '-';
                              }
                          
                                    if($visibleC != 'none'){ ?>
                                <!--<label>Correo</label>-->
                                    <input style="border:0px;" name="correo" value="1" type="hidden" readonly>
                                <?php }else{  } ?>
                        
                <!-- Fin parametros para la activacion de correo y plataforma -->
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                           <label for="">Nombre:</label>
                            <input type="text" class="form-control" value="<?php echo $_POST['nombre']; ?>" name="nombre" placeholder="Nombre acta" autocomplete="off" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46 || event.charCode == 44 )" required>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>Proceso:</label>
                            <select name="proceso" id="cbx_cedi" class="form-control" required>
                             <?php
                             $acentos = $mysqli->query("SET NAMES 'utf8'");
                            if($_POST['proceso'] != NULL){
                               $resultado = $mysqli->query("SELECT * FROM procesos WHERE id='".$_POST['proceso']."' ORDER BY id");
                                 while($row = $resultado->fetch_assoc()) { 
        				                if($row['estado'] == 'Eliminado'){
                                            continue;
                                        }
                                  ?>
                                  <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                  <?php 
                                 }  
                            }
                                 
                             
                            $resultado = $mysqli->query("SELECT * FROM procesos WHERE not id='".$_POST['proceso']."' ORDER BY id");
                            while($row = $resultado->fetch_assoc()) { 
        				           if($row['estado'] == 'Eliminado'){
                                       continue;
                                   }
                             ?>
                             <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                             <?php 
                            }
                             
    				        ?>
                            </select>
                        </div>
                        
                        
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Ubicación:</label>
                            <input type="text" class="form-control" value="<?php echo $_POST['ubicacion']; ?>" name="ubicacion" placeholder="Ubicación" autocomplete="off" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46 || event.charCode == 44 )" required>
                        </div>
                        
                        
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Fecha y hora de inicio:</label>
                            <!--
                            <input type="datetime-local" class="form-control" name="fechainicio" placeholder="">
                            <input type="date" class="form-control" name="fechainicio" placeholder="">
                            <input type="time" class="form-control" name="fechainicio" placeholder="">
                            -->
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="date" value="<?php echo $_POST['fechainicio']; ?>" class="form-control" max="3000-01-01" name="fechainicio" placeholder="" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                              <span class="input-group-text"><i class="far fa-clock"></i></span>
                                            </div>
                                            <input type="time" value="<?php echo $_POST['hora']; ?>" name="hora" class="form-control float-right" id="reservationtime">
                                    </div>
                                     <!--<select name="hora" class="form-control" required>
                                      <option value="">Hora</option>
                                      <option value="0">12:00 am</option>
                                      <option value="1">1:00 am</option>
                                      <option value="2">2:00 am</option>
                                      <option value="3">3:00 am</option>
                                      <option value="4">4:00 am</option>
                                      <option value="5">5:00 am</option>
                                      <option value="6">6:00 am</option>
                                      <option value="7">7:00 am</option>
                                      <option value="8">8:00 am</option>
                                      <option value="9">9:00 am</option>
                                      <option value="10">10:00 am</option>
                                      <option value="11">11:00 am</option>
                                      <option value="12">12:00 pm</option>
                                      <option value="13">1:00 pm</option>
                                      <option value="14">2:00 pm</option>
                                      <option value="15">3:00 pm</option>
                                      <option value="16">4:00 pm</option>
                                      <option value="17">5:00 pm</option>
                                      <option value="18">6:00 pm</option>
                                      <option value="19">7:00 pm</option>
                                      <option value="20">8:00 pm</option>
                                      <option value="21">9:00 pm</option>
                                      <option value="22">10:00 pm</option>
                                      <option value="23">11:00 pm</option>
                                    </select>-->
                                </div>
                                <!--
                                <div class="col-md-3">
                                    <select name="minuto" class="form-control" required>
                                        <option value="">Minuto</option>
                                        <?php
                                            $minuto = 0;
                                            for($i=0;$i <= 59;$i++){
                                                //echo "<option value='$i'>$i</option>";
                                            }
                                        ?>
                                    </select>
                                </div>-->
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <!--
                            <label for="exampleInputPassword1">Fecha y hora de cierre:</label>
                            <input type="datetime-local" class="form-control" name="fechafin" placeholder="">
                            Se comenta este campo por que ya nose require.
                            -->
                        </div>
                        <?php
                                $consultandoDatosTemporales=$mysqli->query("SELECt * FROM documentoDatosTemporalesActas WHERE usuario='$cc' ");
                                $extraerDatosConsultaTemporales=$consultandoDatosTemporales->fetch_array(MYSQLI_ASSOC);
                                $radioIndicador =  $extraerDatosConsultaTemporales['quienCita'];
                                if($_POST['alerta'] != NULL){
                                    if($radioIndicador == 'cargo'){
                                        $checkedC='checked';
                                    }
                                    if($radioIndicador == 'usuario'){
                                        $checkedU='checked';
                                    }
                                }
                        ?>
                        <div class="form-group col-md-6">
                            <label>Quién Cita: </label><br>
                            <input type="radio" id="rad_cargoE" name="radiobtn" value="cargo" <?php echo $checkedC; ?> >
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioE" name="radiobtn" value="usuario" <?php echo $checkedU; ?> >
                            <label for="usuarios">Usuarios</label>

                            
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoE[]" id="select_encargadoE" required>
                                <?php
                                if($_POST['alerta'] != NULL){
                                    if($radioIndicador == 'cargo'){
                                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                                        $cargoAsociados =  json_decode($extraerDatosConsultaTemporales['quienCitaId']);
                                        /// END
                                        $consultaCargos=$mysqli->query("SELECT * FROM cargos ORDER BY nombreCargos ");
                                        while ($columna = $consultaCargos->fetch_array()) { 
                                            
                                                    if(in_array($columna['id_cargos'],$cargoAsociados)){
                                                            $seleccionarCt = "selected";        
                                                        }else{
                                                            $seleccionarCt ="";
                                                        }
                                    ?>
                                    <option value="<?php echo $columna['id_cargos']; ?>" <?php echo $seleccionarCt; ?>  ><?php echo $columna['nombreCargos']; ?> </option>
                                    <?php 
                                        }
                                    }
                                    
                                    
                                    if($radioIndicador == 'usuario'){
                                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                                        $cargoAsociados =  json_decode($extraerDatosConsultaTemporales['quienCitaId']);
                                        /// END
                                        $consultaCargos=$mysqli->query("SELECT * FROM usuario ORDER BY id ");
                                        while ($columna = $consultaCargos->fetch_array()) { 
                                            
                                                    if(in_array($columna['id'],$cargoAsociados)){
                                                            $seleccionarCt = "selected";        
                                                        }else{
                                                            $seleccionarCt ="";
                                                        }
                                    ?>
                                    <option value="<?php echo $columna['id']; ?>" <?php echo $seleccionarCt; ?>  ><?php echo $columna['nombres'].' '.$columna['apellidos']; ?> </option>
                                    <?php 
                                        }
                                    }
                                    
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <?php
                                $radioIndicadorE =  $extraerDatosConsultaTemporales['quienElabora'];
                                if($_POST['alerta'] != NULL){
                                    if($radioIndicadorE == 'cargo'){
                                        $checkedCE='checked';
                                    }
                                    if($radioIndicadorE == 'usuario'){
                                        $checkedUE='checked';
                                    }
                                }
                            ?>
                            <label>Quién Elabora: </label><br>
                            <input type="radio" id="rad_cargoR" name="radiobtn2" value="cargo" <?php echo $checkedCE;?> >
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioR" name="radiobtn2" value="usuario" <?php echo $checkedUE; ?> >
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoR[]" id="select_encargadoR" required>
                                <?php
                                if($_POST['alerta'] != NULL){
                                    if($radioIndicadorE == 'cargo'){
                                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                                        $cargoAsociados =  json_decode($extraerDatosConsultaTemporales['quienElaboraId']);
                                        /// END
                                        $consultaCargos=$mysqli->query("SELECT * FROM cargos ORDER BY nombreCargos ");
                                        while ($columna = $consultaCargos->fetch_array()) { 
                                            
                                                    if(in_array($columna['id_cargos'],$cargoAsociados)){
                                                            $seleccionarCt = "selected";        
                                                        }else{
                                                            $seleccionarCt ="";
                                                        }
                                    ?>
                                    <option value="<?php echo $columna['id_cargos']; ?>" <?php echo $seleccionarCt; ?>  ><?php echo $columna['nombreCargos']; ?> </option>
                                    <?php 
                                        }
                                    }
                                    
                                    
                                    if($radioIndicadorE == 'usuario'){
                                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                                        $cargoAsociados =  json_decode($extraerDatosConsultaTemporales['quienElaboraId']);
                                        /// END
                                        $consultaCargos=$mysqli->query("SELECT * FROM usuario ORDER BY id ");
                                        while ($columna = $consultaCargos->fetch_array()) { 
                                            
                                                    if(in_array($columna['id'],$cargoAsociados)){
                                                            $seleccionarCt = "selected";        
                                                        }else{
                                                            $seleccionarCt ="";
                                                        }
                                    ?>
                                    <option value="<?php echo $columna['id']; ?>" <?php echo $seleccionarCt; ?>  ><?php echo $columna['nombres'].' '.$columna['apellidos']; ?> </option>
                                    <?php 
                                        }
                                    }
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                        
                        <!--<div class="form-group col-md-6">
                            <label>¿Los compromisos del acta requieren aprobación? : </label><br>
                            <input type="radio" id="rad_si" name="radiobtn3" value="si" required>
                            <label for="cargo">Si</label>
                            <input type="radio" id="rad_no" name="radiobtn3" value="no" required>
                            <label for="usuarios">No</label>
                            
                            <div id="aprovar_regitros" style="display:none;">
                                <input type="radio" id="rad_cargoA" name="radiobtn31" value="cargo">
                                <label for="cargo">Cargo</label>
                                <input type="radio" id="rad_usuarioA" name="radiobtn31" value="usuario">
                                <label for="usuarios">Usuarios</label>
    
                                
                                <div class="select2-blue">
                                    <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoAR[]" id="select_encargadoA"></select>
                                </div>
                            </div>
                        </div>-->
                        <?php
                        if($_POST['alerta'] != NULL){
                            if($extraerDatosConsultaTemporales['aprobacion'] == 'si'){
                                $aprobacionSi='checked';
                                $resltadoDisplayAprobacion='';
                                
                                
                                $quienAPrpobacion=$extraerDatosConsultaTemporales['quienAprobacion'];
                               
                                if($quienAPrpobacion == 'cargo'){
                                    $checkedCEQuienAprobacion='checked';
                                }
                                if($quienAPrpobacion == 'usuario'){
                                    $checkedUEQuienAprobacion='checked';
                                }
                                
                                
                            }else{
                                $aprobacionNo='checked';
                                $resltadoDisplayAprobacion='none';
                            }
                        }else{
                             $resltadoDisplayAprobacion='none';
                        }
                        ?>
                        <div class="form-group col-md-6">
                            <label>¿El acta necesita de aprobación?: </label><br>
                            <input type="radio" id="radActa_si" name="radiobtnActa" value="si" required <?php echo $aprobacionSi; ?> >
                            <label for="cargo">Si</label>
                            <input type="radio" id="radActa_no" name="radiobtnActa" value="no" required <?php echo $aprobacionNo; ?> >
                            <label for="usuarios">No</label>
                            
                            <div id="aprovar_regitros2A" style="display:<?php echo $resltadoDisplayAprobacion;?>;">
                                <input type="radio" id="rad_cargoAActa" name="rad_AActa" value="cargo" <?php echo $checkedCEQuienAprobacion; ?> >
                                <label for="cargo">Cargo</label>
                                <input type="radio" id="rad_usuarioAActa" name="rad_AActa" value="usuario" <?php echo $checkedUEQuienAprobacion; ?> >
                                <label for="usuarios">Usuarios</label>
    
                                
                                <div class="select2-blue">
                                    <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoAR2[]" id="select_encargadoAR2">
                                        <?php
                                    if($quienAPrpobacion == 'cargo'){
                                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                                        $cargoAsociados =  json_decode($extraerDatosConsultaTemporales['quienAprobacionId']);
                                        /// END
                                        $consultaCargos=$mysqli->query("SELECT * FROM cargos ORDER BY nombreCargos ");
                                        while ($columna = $consultaCargos->fetch_array()) { 
                                            
                                                    if(in_array($columna['id_cargos'],$cargoAsociados)){
                                                            $seleccionarCt = "selected";        
                                                        }else{
                                                            $seleccionarCt ="";
                                                        }
                                    ?>
                                    <option value="<?php echo $columna['id_cargos']; ?>" <?php echo $seleccionarCt; ?>  ><?php echo $columna['nombreCargos']; ?> </option>
                                    <?php 
                                        }
                                    }
                                    
                                    
                                    if($quienAPrpobacion == 'usuario'){
                                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                                        $cargoAsociados =  json_decode($extraerDatosConsultaTemporales['quienAprobacionId']);
                                        /// END
                                        $consultaCargos=$mysqli->query("SELECT * FROM usuario ORDER BY id ");
                                        while ($columna = $consultaCargos->fetch_array()) { 
                                            
                                                    if(in_array($columna['id'],$cargoAsociados)){
                                                            $seleccionarCt = "selected";        
                                                        }else{
                                                            $seleccionarCt ="";
                                                        }
                                    ?>
                                    <option value="<?php echo $columna['id']; ?>" <?php echo $seleccionarCt; ?>  ><?php echo $columna['nombres'].' '.$columna['apellidos']; ?> </option>
                                    <?php 
                                        }
                                    }
                                ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>¿Acta abierta a todo público? : </label><br>
                            <input type="radio" id="rad_si2" name="radiobtnP" value="si" required>
                            <label for="cargo">Si</label>
                            <input type="radio" id="rad_no2" name="radiobtnP" value="no" required>
                            <label for="usuarios">No</label>
                            
                            <div id="aprovar_regitros2" style="display:none;">
                                <input type="radio" id="rad_cargoA2" name="radiobtnP2" value="cargo">
                                <label for="cargo">Cargo</label>
                                <input type="radio" id="rad_usuarioA2" name="radiobtnP2" value="usuario">
                                <label for="usuarios">Usuarios</label>
                                <input type="radio" id="rad_grupo" name="radiobtnP2" value="grupo">
                                <label for="usuarios">Grupos</label>
    
                                
                                <div class="select2-blue">
                                    <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoA2[]" id="select_encargadoA2"></select>
                                </div>
                                
                            </div>
                        </div>
                        <!--
                        <div class="form-group col-md-6">
                            <label>Convocados: </label><br>
                            <input type="radio" id="rad_cargoC" name="radiobtnC" value="cargo">
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioC" name="radiobtnC" value="usuario">
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoC[]" id="select_encargadoC" required></select>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>Asistentes: </label><br>
                            <input type="radio" id="rad_cargoAsis" name="rad_Asis" value="cargo">
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioAsis" name="rad_Asis" value="usuario">
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoAsis[]" id="select_encargadoAsis" required></select>
                            </div>
                        </div>
                        
                        
                        -->
                        
                        
                        <div class="form-group col-md-6">
                            <label>Cargar Acta (Máx 10MB): </label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="archivo" id="miInput" <?php echo $activaUpload;?>  accept=".pdf," required>
                                        <label class="custom-file-label" >Subir Archivo</label>
                                </div>
                            </div>
                            <script>
                                $('input[name="archivo"]').on('change', function(){
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
                        
                        <div class="form-group col-md-12 text-center">
                                <br>
                                <label>¿Agregar compromisos?</label><br>
                                <label ><input type="radio" name="radiobtnCom" id="radiobtnComSi" value="si" required> Si</label>
                                <label ><input type="radio" name="radiobtnCom" id="radiobtnComNo" value="no" required> No</label>
                                
                                <div id="horaFin" name="horaFin" style="display:none;">
                                    <div class="row" >
                                        <label for="exampleInputPassword1">Fecha y hora de cierre:</label>
                                        <div class="col-md-4">
                                            <input type="date" max="3000-01-01" class="form-control" name="fechafin" placeholder="" >
                                        </div>
                                    
                                        <div class="col-md-4">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                  <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                </div>
                                                    <input type="time" name="horafin" class="form-control float-right" id="reservationtime">
                                            </div>
                                             <!--<select name="horafin" class="form-control" >
                                              <option value="">Hora</option>
                                              <option value="0">12:00 am</option>
                                              <option value="1">1:00 am</option>
                                              <option value="2">2:00 am</option>
                                              <option value="3">3:00 am</option>
                                              <option value="4">4:00 am</option>
                                              <option value="5">5:00 am</option>
                                              <option value="6">6:00 am</option>
                                              <option value="7">7:00 am</option>
                                              <option value="8">8:00 am</option>
                                              <option value="9">9:00 am</option>
                                              <option value="10">10:00 am</option>
                                              <option value="11">11:00 am</option>
                                              <option value="12">12:00 pm</option>
                                              <option value="13">1:00 pm</option>
                                              <option value="14">2:00 pm</option>
                                              <option value="15">3:00 pm</option>
                                              <option value="16">4:00 pm</option>
                                              <option value="17">5:00 pm</option>
                                              <option value="18">6:00 pm</option>
                                              <option value="19">7:00 pm</option>
                                              <option value="20">8:00 pm</option>
                                              <option value="21">9:00 pm</option>
                                              <option value="22">10:00 pm</option>
                                              <option value="23">11:00 pm</option>
                                            </select>-->
                                        </div>
                                        <!--
                                        <div class="col-md-3">
                                            <select name="minutofin" class="form-control" >
                                                <option value="">Minuto</option>
                                                <?php
                                                    $minuto = 0;
                                                    for($i=0;$i <= 60;$i++){
                                                        echo "<option value='$i'>$i</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        
                        
                </div>
                <!-- /.form-group -->
              
        
                  <!--
                  
                  ACA SE AGREGAN ELEMENTOS NUEVOS
                  
                  SE PUEDE EXTRAER DE: 
                  https://fixwei.com/plataforma/pages/forms/general.html
                  https://fixwei.com/plataforma/pages/forms/advanced.html
                  https://fixwei.com/plataforma/pages/forms/editors.html
                  
                  -->
                  
                  
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                    <?php
                    $queryEncabezado = $mysqli->query("SELECT * FROM encabezado WHERE principal = '1'");
                                $encabezado = $queryEncabezado->fetch_array(MYSQLI_ASSOC);
                                $enviarEncabezadoActivo=$encabezado['encabezado'];
                                $enviarIdEncabezadoActivo=$encabezado['id'];
                    ?>
                     <input name="idEncabezado" type="hidden" value="<?php echo $enviarIdEncabezadoActivo;?>" readonly required>
                    <button type="submit" name="cargarActa" class="btn btn-primary float-right">>> Siguiente</button>
                </div>
              
            </div>
            </div>    

        <div class="col">
        </div>
            </form>
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
            
<?php
if($_POST['alerta'] != NULL){
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
                                  <p>El nombre del archivo contiene caracteres inválidos, por favor digite el nombre completo del archivo e intente cargar.</p>
                                </div>
                                 <!-- END formulario para eliminar por el id -->
                              </div>
                            </div>
                        </div>
<?php
}
?>         
            
            
            
            
            
            
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
        $('#rad_si').click(function(){
            document.getElementById('aprovar_regitros').style.display = '';
        });
        $('#rad_no').click(function(){
            document.getElementById('aprovar_regitros').style.display = 'none';
        });
    });
</script>
<!--Select dinamico-->
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
<!--CONVOCADOS-->
<script>
    $(document).ready(function(){
        $('#rad_cargoC').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoC").html(data);
            }); 
        });
        $('#rad_usuarioC').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoC").html(data);
            }); 
        });
    });
</script>
<!--ASISTENTES-->
<script>
    $(document).ready(function(){
        $('#rad_cargoAsis').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoAsis").html(data);
            }); 
        });
        $('#rad_usuarioAsis').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoAsis").html(data);
            }); 
        });
    });
</script>
<!--RESPONSABLES-->
<script>
    $(document).ready(function(){
        
        
        $('#agregaCompromiso').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoRes").html(data);
            }); 
        });
        $('#rad_usuarioRes').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoRes").html(data);
            }); 
        });
    });
</script>
<!--RESPONSABLES-->

<!--ENTREGAR A -->
<script>
    /*$(document).ready(function(){
        usuario = "usuario";
        $.post("selectDocumentos2.php", { rad_usuario: usuario }, function(data){
                $("#select_encargadoEntrega").html(data);
        });
        
        $.post("selectDocumentos2.php", { rad_usuario: usuario }, function(data){
                $("#select_encargadoCom").html(data);
        });
        
        $('#agregaCompromiso').click(function(){
            alert("Dio click");
            usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: usuario }, function(data){
                $("#select_encargadoEntrega").html(data);
            });
            
            $.post("selectDocumentos2.php", { rad_usuario: usuario }, function(data){
                $("#select_encargadoCom").html(data);
            });
            
        });
    });*/
</script>
<script>
    $(document).ready(function(){
        $('#rad_si2').click(function(){
            document.getElementById('aprovar_regitros2').style.display = 'none';
        });
        $('#rad_no2').click(function(){
            document.getElementById('aprovar_regitros2').style.display = '';
        });
    });
</script>
<!--Select dinamico-->
<script>
    $(document).ready(function(){
        $('#rad_cargoA2').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoA2").html(data);
            }); 
        });
        $('#rad_usuarioA2').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoA2").html(data);
            }); 
        });
        $('#rad_grupo').click(function(){
            rad_grupo = "grupo";
            $.post("selectDocumentos3.php", { rad_grupo: rad_grupo }, function(data){
                $("#select_encargadoA2").html(data);
            }); 
        });
    });
</script>
<!--Aprobacion del acta-->
<script>
    $(document).ready(function(){
        $('#radActa_si').click(function(){
            document.getElementById('aprovar_regitros2A').style.display = '';
        });
        $('#radActa_no').click(function(){
            document.getElementById('aprovar_regitros2A').style.display = 'none';
        });
    });
</script>
<!--Select dinamico-->
<script>
    $(document).ready(function(){
        $('#rad_cargoAActa').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoAR2").html(data);
            }); 
        });
        $('#rad_usuarioAActa').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoAR2").html(data);
            }); 
        });

    });
</script>


<!--ACTA finalizada-->
<script>
    $(document).ready(function(){
        $('#radiobtnComSi').click(function(){
            document.getElementById('horaFin').style.display = 'none';
        });
        $('#radiobtnComNo').click(function(){
            document.getElementById('horaFin').style.display = '';
        });
    });
</script>
<!--Select dinamico-->
<script>
    $(document).ready(function(){
        $('#rad_cargoAActa').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoAR2").html(data);
            }); 
        });
        $('#rad_usuarioAActa').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoAR2").html(data);
            }); 
        });

    });
</script>


<!--Ckeditor-->
<script>
    CKEDITOR.replace( 'editor1' );
</script>
<!-- Summernote -->
<script src="../plugins/summernote/summernote-bs4.min.js"></script>
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote()
  })
</script>

<!-- bs-custom-file-input -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
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