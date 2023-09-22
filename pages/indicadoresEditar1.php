<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

///////// notificaciones para plataforma y correo
require_once 'conexion/bd.php';
$formulario = 'usuarios'; //Se cambia el nombre del formulario
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
  <title>FIXWEI - Editar Indicador</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
</head>
<script>
   	
    function nobackbutton(){
    	
       window.location.hash="no-back-button";
    	
       window.location.hash="Again-No-back-button" //chrome
    	
       window.onhashchange=function(){window.location.hash="no-back-button";}
    	
    }
</script>
<body class="hold-transition sidebar-mini" onload="nobackbutton();" oncopy="return false" onpaste="return false" >
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
            <h1>Editar Indicadores</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Editar indicadores</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="indicadores"><font color="white"><i class="fas fa-list"></i> Listar indicadores</font></a></button>
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
            <div class="col-9">
                <?php
                $recibeID=$_POST['id'];
                $consultaVerIndicador = $mysqli->query("SELECT * FROM `indicadores` WHERE id='$recibeID' ");
                $verIndicador = $consultaVerIndicador->fetch_array(MYSQLI_ASSOC);
                $quienCrea=$verIndicador['quienCrea'];
                
                ?>
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Editar <b><?php echo $verIndicador['nombre']; ?></b></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
                 
                <div class="card-body">
                    
                <!-- parametros para la activacion de correo y plataforma -->
                    <div class="row"> 
                        <div class="form-group col-sm-6">
                          <input name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden" readonly>
                          <label><!-- Notificaciones por: --> </label>&nbsp;&nbsp;
                              <?php if($visibleP != 'none'){ ?>
                              
                                <label><!-- Plataforma --></label>
                                    <input style="border:0px;" name="plataforma" value="1" type="hidden" readonly>
                                <?php }else{  }
                          
                              if($visibleP != 'none' && $visibleC != 'none'){
                                  //echo '-';
                              }
                          
                                    if($visibleC != 'none'){ ?>
                                <label><!-- Correo --></label>
                                    <input style="border:0px;" name="correo" value="1" type="hidden" readonly>
                                <?php }else{  } ?>
                        </div>
                    </div>
                <!-- Fin parametros para la activacion de correo y plataforma -->
                
                 
                 
                 <?php
                                                        if(isset($_POST['botonValidarEditar'])){
                                                            $id=$_POST['idEditarVariable'];
                                                      ?>
                                                           
                                                        <div class="card card-primary">
                                                          <div class="card-header">
                                                            <h3 class="card-title">Editar variable</h3>
                                                          </div>
                                                          <!-- /.card-header -->
                                                          <!-- form start -->
                                                          <?php 
                                                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                                $query = $mysqli->query("SELECT * FROM indicadoresVariables WHERE id = '$id' ");
                                                                $row = $query->fetch_array(MYSQLI_ASSOC);
                                                                $nombreVariable = $row['nombreVariable'];
                                                                $simbolo = $row['simbolo'];
                                                                $idDatos = $row['id'];
                                                                
                                                            ?>
                                                          <form role="form" action="controlador/indicadores/controllerM" method="POST">
                                                            <div class="card-body">
                                                              <div class="form-group">
                                                                <label>Nombre:</label>
                                                                <input type="text" class="form-control"  name="nombre2" value="<?php echo $nombreVariable; ?>" placeholder="Tipo" required>
                                                                <br>
                                                                <label>Variable:</label>
                                                                <input type="text" class="form-control"  name="simbolo" value="<?php echo $simbolo; ?>" placeholder="Variable" required>
                                                                <input type="hidden" name="id" value="<?php echo $idDatos; ?>">
                                                                <input type="hidden" name='variablesIdPrincipal' value="<?php echo $recibeID; ?>" >
                                                                <!-- para mantener la vista de variables habilitada -->
                                                                <input type="hidden" name="idEditarVariable" value="mantenerEditar">
                                                                <!-- END -->
                                                              </div>
                                                            
                                                            </div>
                                                            <!-- /.card-body -->
                                            
                                                            <div class="card-footer" >
                                                              <button type="submit" class="btn btn-primary float-right" name="AgregarVariablesActualizarEditar">Actualizar</button>
                                                            </div>
                                                          </form>
                                                         
                                                        </div>
                                                        <?php
                                                            }
                                                        ?>
                <?php 
                    if(isset($_POST['botonValidarAgregar'])){
                ?> 
                
                
                                            
                                                   
                    <?php } 
                    
                $siguiente=$_POST['siguiente'];
                 
                 if($siguiente != NULL ){
                    $ocultarVistaPrincipal='none';
                    
                 }else{
                    $ocultarVistaPrincipal='';
                    
                 }
                 
                if($siguiente != NULL){
                    $ocultarVistaSecundaria='none';
                }else{ 
                     if($_POST['botonValidarAgregar'] || $_POST['idEditarVariable']){
                        $ocultarVistaPrincipal='none';
                        $ocultarVistaSecundaria='';
                     }else{
                        $ocultarVistaPrincipal='';
                        $ocultarVistaSecundaria='none';
                     }
                } 
                 ?>
            <form name="formulario" action="controlador/indicadores/controller" method="POST" enctype="multipart/form-data">
                <input name="idIndicador" value="<?php echo $recibeID;?>" type="hidden" readonly>
                <div id="primeraVista" style="display:<?php echo $ocultarVistaPrincipal;?>;">
                    <div class="row">
                        <div class="form-group col-sm-6">
                           
                            <label>Nombre:</label>
                           
                            <input type="text" class="form-control" value="<?php echo $verIndicador['nombre'];?>" name="nombre" placeholder="Nombre" autocomplete="off" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46 || event.charCode == 44 )" required>
                            <br>
                            <label>Descripción:</label>
                            <textarea type="text" class="form-control" name="descripcion" placeholder="Descripción" autocomplete="off" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46 || event.charCode == 44 )" required><?php echo $verIndicador['descripcion']; ?></textarea>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Tipo de indicador:</label>
                            <?php
                                $tipoIndicador=$verIndicador['tipoIndicador'];
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultadoTipoId=$mysqli->query("SELECT * FROM indicadoresTipo WHERE id='$tipoIndicador' ORDER BY tipo");
                                $extraeIdTipoIndicador=$resultadoTipoId->fetch_array(MYSQLI_ASSOC);
                            ?>
                            <select type="text" class="form-control" name="tipoIndicador" required>
                                <option value="<?php echo $extraeIdTipoIndicador['id']; ?>"><?php echo $extraeIdTipoIndicador['tipo']; ?></option>
                                <?php
                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $resultadoTipo=$mysqli->query("SELECT * FROM indicadoresTipo ORDER BY tipo");
                                    while ($columnaTipo = mysqli_fetch_array( $resultadoTipo )) { ?>
                                    <option value="<?php echo $columnaTipo['id']; ?>"><?php echo $columnaTipo['tipo']; ?> </option>
                                <?php }  ?>
                            </select>
                            <br>
                            <label>Responsable Indicador: </label><br>
                            <?php 
                                $radioIndicador =  $verIndicador['radioIndicador'];
                                if($radioIndicador == 'cargo'){
                                    $checkedC='checked';
                                }
                                if($radioIndicador == 'usuario'){
                                    $checkedU='checked';
                                }
                            ?>
                            <input type="radio" id="rad_cargoRI" name="radiobtn" value="cargo" <?php echo $checkedC; ?> required>
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioRI" name="radiobtn" value="usuario" <?php echo $checkedU; ?> required>
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoRI[]" id="select_encargadoRI" <?php echo $seleccionarCt; ?> required>
                                <?php
                                    if($radioIndicador == 'cargo'){
                                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                                        $cargoAsociados =  json_decode($verIndicador['resposableIndicador']);
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
                                        $cargoAsociados =  json_decode($verIndicador['resposableIndicador']);
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
                    
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Desde:</label>
                            <input type="date" class="form-control" value="<?php echo $verIndicador['desdeMostrar']; ?>" name="desde" required>
                            <br>
                            <label>Hasta:</label>
                            <input type="date" class="form-control" value="<?php echo $verIndicador['hasta']; ?>" name="hasta" required>
                        
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Sentido:</label>
                            <select type="text" class="form-control"  name="sentido"  required>
                                <option value="<?php echo $verIndicador['sentido']; ?>"><?php echo $verIndicador['sentido']; ?></option>
                                <?php
                                if($verIndicador['sentido'] == 'Positivo'){
                                
                                }else{
                                ?>
                                <option value="Positivo">Positivo</option>
                                <?php
                                }
                                if($verIndicador['sentido'] == 'Negativo'){
                                
                                    
                                }else{
                                ?>
                                <option value="Negativo">Negativo</option>
                                <?php
                                }
                                ?>
                            </select>
                            <br>
                            <label>Proceso:</label>
                            <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $idProceso=$verIndicador['proceso'];
                                $resultadoProcesoId=$mysqli->query("SELECT * FROM procesos WHERE id='$idProceso' ");
                                $idExtraeProceso=$resultadoProcesoId->fetch_array(MYSQLI_ASSOC);
                            ?>
                            <select type="text" class="form-control"  name="proceso"  required>
                                <option value="<?php echo $idExtraeProceso['id']; ?>"><?php echo $idExtraeProceso['nombre']; ?></option>
                                <?php
                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $resultadoProceso=$mysqli->query("SELECT * FROM procesos ORDER BY nombre");
                                    while ($columnaProceso = mysqli_fetch_array( $resultadoProceso )) { ?>
                                    <option value="<?php echo $columnaProceso['id']; ?>"><?php echo $columnaProceso['nombre']; ?> </option>
                                <?php }  ?>
                            </select>
                        </div>                        
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-sm-6">
                        <label>Autorizados para Visualizar: </label><br>
                        <?php
                        $opcionVisualizar=$verIndicador['radioVisualizar'];
                        if($opcionVisualizar == 'cargo'){
                            $checkedCV='checked';
                            $ocularUsuario='none';
                        }
                        if($opcionVisualizar == 'usuario'){
                            $checkedUV='checked';
                            $ocularCargo='none';
                        }
                        ?>
                            <input type="radio" id="rad_cargoAut" name="radiobtnAut" value="cargo" <?php echo $checkedCV; ?> required>
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioAut" name="radiobtnAut" value="usuario" <?php echo $checkedUV; ?> required>
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue" id="listarCargos" style="display:<? echo $ocularCargo;?>;">
                                <label></label>
                                    <?php
                                    $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                                    $consultaCargosV=$mysqli->query("SELECT * FROM cargos ORDER BY nombreCargos ");
                                    $cargoAsociadosVisualizar =  json_decode($verIndicador['autorizadoVisualizar']);
                                    
                                    //$consultaCargos=$mysqli->query("SELECT * FROM cargos");
                                    ?>
                                <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoAut[]" >
                                    <?php
                                        
                                        while ($columnaV = $consultaCargosV->fetch_array()) { 
                                            
                                                    if(in_array($columnaV['id_cargos'],$cargoAsociadosVisualizar)){
                                                            $seleccionarCtV = "selected";        
                                                        }else{
                                                            $seleccionarCtV ="";
                                                        }
                                    ?>
                                    <option value="<?php echo $columnaV['id_cargos']; ?>" <?php echo $seleccionarCtV; ?>  ><?php echo $columnaV['nombreCargos']; ?> </option>
                                    <?php 
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="select2-blue" id="listarUsuarios" style="display:<? echo $ocularUsuario;?>;">
                                <label></label>
                               
                                    <?php
                                    $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                                     $consultaNorma=$mysqli->query("SELECT * FROM usuario ");
                                    $jsonNormavisualizar =  json_decode($verIndicador['autorizadoVisualizar']);
                                    /// END
                                    ?>
                                <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoAutU[]"  >
                                <?php
                                while ($columnaNormaVisualizar = $consultaNorma->fetch_array()) { 
                                    
                                            if(in_array($columnaNormaVisualizar['id'],$jsonNormavisualizar)){
                                                    $seleccionarNormaVisualizar = "selected";        
                                                }else{
                                                    $seleccionarNormaVisualizar ="";
                                                }
                                ?>
                                 <option value="<?php echo $columnaNormaVisualizar['id']; ?>" <?php echo $seleccionarNormaVisualizar; ?>><?php echo $columnaNormaVisualizar['nombres'].' '.$columnaNormaVisualizar['apellidos']; ?> </option>
                                <?php
                                }
                                    ?>
                                
                                </select>
                            </div>
                      </div>
                       <div class="form-group col-sm-6">
                            <label>Frecuencia de cálculo:</label>
                            <select type="text" class="form-control"  name="frecuencia"  required>
                                <option value="<?php echo $verIndicador['frecuencia']; ?>"><?php echo $verIndicador['frecuencia']; ?></option>
                                <option value="Mensual">Mensual</option>
                                <option value="Bimensual">Bimensual</option>
                                <option value="Trimestral">Trimestral</option>
                                <option value="Semestral">Semestral</option>
                                <option value="Anual">Anual</option>
                            </select>
                            <br>
                            <label>Restringir la alimentación o análisis para fechas futuras ?:</label><br>
                            <?php 
                                $restrincion=$verIndicador['restrincion']; 
                                
                                if($restrincion == 'Si'){
                                    $checkSi='checked';
                                }
                                
                                if($restrincion == 'No'){
                                    $checkNo='checked';
                                }
                            ?>
                            Si
                            <input type="radio" class=""  name="restrincion" value="Si" <?php echo $checkSi; ?> required>
                            No
                            <input type="radio" class=""  name="restrincion" value="No" <?php echo $checkNo; ?> required>
                            <br><br>
                            <label>Clasificación:</label><br>
                             <?php 
                                $clasificacion=$verIndicador['clasificacion']; 
                                
                                if($clasificacion == 'Estrategico'){
                                    $checkE='checked';
                                }
                                
                                if($clasificacion == 'Operativo'){
                                    $checkO='checked';
                                }
                            ?>
                            Estratégico
                            <input type="radio" class=""  name="clasificacion" value="Estrategico" <?php echo $checkE; ?> required>
                            Operativo
                            <input type="radio" class=""  name="clasificacion" value="Operativo" <?php echo $checkO; ?> required>
                        </div> 
                    </div>
                  
                    <div class="row">
                      <div class="form-group col-sm-6">
                     <label>Autorizados para editar: </label><br>
                            <?php 
                                $radioEditar =  $verIndicador['radioEditar'];
                                if($radioEditar == 'cargo'){
                                    $checkedEditar='checked';
                                }
                                if($radioEditar == 'usuario'){
                                    $checkedUEditar='checked';
                                }
                            ?>
                            <input type="radio" id="rad_cargoEd" name="radiobtnEd" value="cargo" <?php echo $checkedEditar; ?> required>
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioEd" name="radiobtnEd" value="usuario" <?php echo $checkedUEditar; ?> required>
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoEd[]" id="select_encargadoEd" required="">
                                     <?php
                                    if($radioEditar == 'cargo'){
                                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                                        $cargoAsociadosEditar =  json_decode($verIndicador['autorizadoEditar']);
                                        /// END
                                        $consultaCargosEditar=$mysqli->query("SELECT * FROM cargos ORDER BY nombreCargos ");
                                        while ($columnaEditar = $consultaCargosEditar->fetch_array()) { 
                                            
                                                    if(in_array($columnaEditar['id_cargos'],$cargoAsociadosEditar)){
                                                            $seleccionarCteditar = "selected";        
                                                        }else{
                                                            $seleccionarCteditar ="";
                                                        }
                                    ?>
                                    <option value="<?php echo $columnaEditar['id_cargos']; ?>" <?php echo $seleccionarCteditar; ?>  ><?php echo $columnaEditar['nombreCargos']; ?> </option>
                                    <?php 
                                        }
                                    }
                                    
                                    
                                     if($radioEditar == 'usuario'){
                                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                                        $usuarioAsociadosEditar =  json_decode($verIndicador['autorizadoEditar']);
                                        /// END
                                        $consultaUsuarioEditar=$mysqli->query("SELECT * FROM usuario ORDER BY id ");
                                        while ($columnaUsuarioEditar = $consultaUsuarioEditar->fetch_array()) { 
                                            
                                                    if(in_array($columnaUsuarioEditar['id'],$usuarioAsociadosEditar)){
                                                            $seleccionarUtEditar = "selected";        
                                                        }else{
                                                            $seleccionarUtEditar ="";
                                                        }
                                    ?>
                                    <option value="<?php echo $columnaUsuarioEditar['id']; ?>" <?php echo $seleccionarUtEditar; ?>  ><?php echo $columnaUsuarioEditar['nombres'].' '.$columnaUsuarioEditar['apellidos']; ?> </option>
                                    <?php 
                                        }
                                    }
                                ?>
                                </select>
                            </div>
                      </div>
                      <div class="form-group col-sm-6">
                          <?php 
                                $radioCalculo =  $verIndicador['radioCalculo'];
                                if($radioCalculo == 'cargo'){
                                    $checkedCalculo='checked';
                                }
                                if($radioCalculo == 'usuario'){
                                    $checkedUCalculo='checked';
                                }
                            ?>
                        <label>Responsable del Cálculo: </label><br>
                            <input type="radio" id="rad_cargoC" name="radiobtnC" value="cargo" <?php echo $checkedCalculo; ?> required>
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioC" name="radiobtnC" value="usuario" <?php echo $checkedUCalculo; ?> required>
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoC[]" id="select_encargadoC" required>
                                    <?php
                                    if($radioCalculo == 'cargo'){
                                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                                        $cargoAsociadosCalculo =  json_decode($verIndicador['responsableCalculo']);
                                        /// END
                                        $consultaCargosCalculo=$mysqli->query("SELECT * FROM cargos ORDER BY nombreCargos ");
                                        while ($columnacalculo = $consultaCargosCalculo->fetch_array()) { 
                                            
                                                    if(in_array($columnacalculo['id_cargos'],$cargoAsociadosCalculo)){
                                                            $seleccionarCtCalculo = "selected";        
                                                        }else{
                                                            $seleccionarCtCalculo ="";
                                                        }
                                    ?>
                                    <option value="<?php echo $columnacalculo['id_cargos']; ?>" <?php echo $seleccionarCtCalculo; ?>  ><?php echo $columnacalculo['nombreCargos']; ?> </option>
                                    <?php 
                                        }
                                    }
                                    
                                    
                                     if($radioCalculo == 'usuario'){
                                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                                        $usuarioAsociadoscalculo =  json_decode($verIndicador['responsableCalculo']);
                                        /// END
                                        $consultaUsuarioCalculo=$mysqli->query("SELECT * FROM usuario ORDER BY id ");
                                        while ($columnaUsuarioCalculo = $consultaUsuarioCalculo->fetch_array()) { 
                                            
                                                    if(in_array($columnaUsuarioCalculo['id'],$usuarioAsociadoscalculo)){
                                                            $seleccionarUtCalculo = "selected";        
                                                        }else{
                                                            $seleccionarUtCalculo ="";
                                                        }
                                    ?>
                                    <option value="<?php echo $columnaUsuarioCalculo['id']; ?>" <?php echo $seleccionarUtCalculo; ?>  ><?php echo $columnaUsuarioCalculo['nombres'].' '.$columnaUsuarioCalculo['apellidos']; ?> </option>
                                    <?php 
                                        }
                                    }
                                ?>
                                </select>
                            </div>
                      </div>
                    </div>
                    
                     <div class="row">
                      <div class="form-group col-sm-6">
                          
                            <!--<label>Seleccione el tipo de variable a usar en el indicador.</label><br>-->
                            <?
                            /// vlidamos que tipo de variable es
                            $tipoVariable=$verIndicador['terminar2'];
                            if($tipoVariable == 'Pendiente2.2'){
                                $checkedSU='checked';
                            }
                            if($tipoVariable == 'Pendiente2'){
                                $checkedM='checked';
                            }
                            ?>
                                    <!--
                                    Serie única
                                    <input type="radio" class=""  name="variables" value="Serie única" <? echo $checkedSU; ?> required>
                                    Multiserie -->
                                    <input type="hidden" name="variables" value="Multiserie"  required>
                      </div>
                      <div class="form-group col-sm-6">
                       
                            <br><br>
                             <table>
                                <tr>
                                    <td>
                                        <a href="#" style="color:white;" class="btn btn-warning float-right" id="siguienteA">Siguiente</a>
                                    </td>
                                </tr>
                             </table>
                      </div>
                      
                  </div>
                    
                    
                    
                </div>
                
                <div id="segundaVista" style="display:<? echo $ocultarVistaSecundaria; ?>;">
                    <section class="content">
                        <?
                        //if(isset($_POST['botonValidarAgregar'])){
                      //$id=$_POST['idAgregarVariable'];
                        ?>
                                
                                
                                                    <a href="#" style="color:white;display:none;" class="btn btn-info float-left" id="mostrarVariablesAbrir">Variables</a>
                                                        <div id="mostrarVariables" style="display:none;"> 
                                                            <a href="#" style="color:white;" class="btn btn-success float-left" id="mostrarVariablesCerrar">Cerrar variable</a>
                                                            <!-- tabla variables -->
                                                            <br><br>
                                                           
                                                        <a href="#" class="btn btn-info float-left" id="solicitarAbrirAgregar" name="botonValidarAgregar">Agregar nuevo<a>
                                                        <a href="#" style="display:none;" class="btn btn-success float-left" id="solicitarCerrarAgregar" >Cerrar<a>
                                                        <?php
                                                        $consultandoVariables=$mysqli->query("SELECT COUNT(*) FROM indicadoresVariables ");
                                                        $exxtraerConsultaVariablesConteo=$consultandoVariables->fetch_array(MYSQLI_ASSOC);
                                                        if($exxtraerConsultaVariablesConteo['COUNT(*)'] == '30'){
                                                            echo '<br><br><font color="red">Llegó al límite de registros permitidos que son 30 variables</font>';
                                                        }else{
                                                        ?>   
                                                        <div class="card card-primary" id="abrirAgregarVariable" style="display:none;">
                                                          <div class="card-header">
                                                            <h3 class="card-title">Agregar variable</h3>
                                                          </div>
                                                          
                                                          <form role="form" action="controlador/indicadores/controller" method="POST" enctype="multipart/form-data">
                                                              
                                                               <?
                                                                /// vlidamos que tipo de variable es
                                                                $tipoVariable=$verIndicador['terminar2'];
                                                                if($tipoVariable == 'Pendiente2.2'){
                                                                    $checkedSU='checked';
                                                                }
                                                                if($tipoVariable == 'Pendiente2'){
                                                                    $checkedM='checked';
                                                                }
                                                                ?>
                                                                
                                                            <input type="radio" style="visibility:hidden;"  name="variables" value="Serie única" <? echo $checkedSU; ?> required>
                                                                
                                                            <input type="radio" style="visibility:hidden;"  name="variables" value="Multiserie" <? echo $checkedM; ?> required>
                                                            <input name="id" value="<?php echo $recibeID;?>" type="hidden" readonly>
                                                            
                                                            <div class="row">
                                                              <div class="form-group col-sm-6">
                                                                <label>Nombre:</label>
                                                                <input type="text" class="form-control" name="nombre2" placeholder="Nombre" >
                                                                <br>
                                                                <label>Descripción:</label>
                                                                <textarea type="text" class="form-control" name="descripcion2" placeholder="Descripción" ></textarea>
                                                              </div>
                                                              <div class="form-group col-sm-6">
                                                                <label>Variable:</label>
                                                                        <input type="text" class="form-control" name="simbolo" placeholder="Variable" >
                                                                        <br>
                                                                        <label>Unidad de medida:</label>
                                                                         <select type="text" class="form-control" name="unidad" placeholder="Unidad de medida" >
                                                                             <option value="">Seleccionar unidad...</option>
                                                                             <?php
                                                                             $unidadMedida=$mysqli->query("SELECT * FROM indicadoresUnidad ORDER BY unidad");
                                                                             while($datoUnidad=$unidadMedida->fetch_array()){
                                                                             ?>
                                                                             <option value="<?php echo $datoUnidad['unidad']; ?>"><?php echo $datoUnidad['unidad']; ?></option>
                                                                            <?php
                                                                             }
                                                                            ?>
                                                                         </select>
                                                              </div>
                                                            </div>
                                                            <!-- /.card-body -->
                                                            <!-- para mantener la vista de variables habilitada -->
                                                            <input type="hidden" name="idEditarVariable" value="mantenerEditar">
                                                            <!-- END -->
                                                            <div class="card-footer" >
                                                               <button type="submit" style="color:white;" class="btn btn-info float-right" name="AgregarVariablesEditar">Guardar</button>
                                                            </div>
                                                          </form>
                                                         
                                                        </div>
                                                        <?php
                                                        }
                                                        ?>
                                                         <script>
                                                            $(document).ready(function(){
                                                                $('#solicitarAbrirAgregar').click(function(){
                                                                    document.getElementById('abrirAgregarVariable').style.display = '';
                                                                    document.getElementById('solicitarCerrarAgregar').style.display = '';
                                                                    document.getElementById('solicitarAbrirAgregar').style.display = 'none';
                                                                });
                                                                $('#solicitarCerrarAgregar').click(function(){
                                                                     document.getElementById('abrirAgregarVariable').style.display = 'none';
                                                                    document.getElementById('solicitarCerrarAgregar').style.display = 'none';
                                                                    document.getElementById('solicitarAbrirAgregar').style.display = '';
                                                                });
                                                            });
                                                        </script>
                                                            <br><br>
                                                            
                                                           <table class="table table-head-fixed text-center" id="example">
                                                                  <thead>
                                                                    <tr>
                                                                      <th>N°</th>
                                                                      <th>Nombre</th>
                                                                      <th>Editar</th>
                                                                      <th>Eliminar</th>
                                                                      <th>Aplicar variable</th>
                                                                    </tr> 
                                                                  </thead>
                                                                  <tbody>
                                                                     <?php
                                                                     require 'conexion/bd.php';
                                                                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                                     $data = $mysqli->query("SELECT * FROM indicadoresVariables ORDER BY nombreVariable")or die(mysqli_error());
                                                                     $conteo=1;
                                                                     $conteoEnviar=1;
                                                                     while($row = $data->fetch_assoc()){
                                                                 
                                                                    echo"<tr>";
                                                                    echo" <td>".$conteo++."</td>";
                                                                    $enviarSimbolo=$row['simbolo'];
                                                                    echo" <td>".$row['nombreVariable']."</td>";
                                                                    $id=$row['id'];
                                                                    echo"<form action='indicadoresEditar1' method='POST'>";
                                                                     echo"<input type='hidden' name='idEditarVariable' value= '$id' >";
                                                                    echo"<input type='hidden' name='id' value= '$recibeID' >";
                                                                    echo" <td><button type='submit' name='botonValidarEditar' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                                                                    echo"</form>";
                                                                    ?>
                                                                    
                                                                    <input type='hidden' id='capturaVariableEliminacion<?php echo $contadoEliminacionr++;?>'  value= '<?php echo $id;?>' >
                                                                    <td><a onclick='funcionFormula<?php echo $contadorEliminacion1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                                                                    <script>
                                                                        function funcionFormula<?php echo $contadorEliminacion2++;?>() {
                                                                            /*alert("entre");*/
                                                                          document.getElementById("capturarFormulaEliminacion").value = document.getElementById("capturaVariableEliminacion<?php echo $contadorEliminacion3++;?>").value;
                                                                        }
                                                                   </script>
                                                                    <?php
                                                                    /*
                                                                    echo"<form action='controlador/indicadores/controllerM' method='POST'>";
                                                                    echo '<input type="hidden" name="idEditarVariable" value="mantenerEditar">';
                                                                    echo"<input type='hidden' name='id' value= '$id' >";
                                                                    echo"<input type='hidden' name='variablesIdPrincipal' value= '$recibeID' >";
                                                                    echo" <td><button  onclick='return ConfirmDelete()' type='submit' name='AgregarVariablesEliminarEditar' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                                                                    echo"</form>";
                                                                    */
                                                                   
                                                                    ?>
                                                                    <td><a   id='enviarVariable<? echo $conteoEnviar++;?>' style='color:white;' class='btn btn-block btn-warning btn-sm'><? echo $enviarSimbolo;?></a></td>
                                                                    <?
                                                                    echo"</tr>";
                                                                    }
                                                                    ?> 
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
                                                                            <form action='controlador/indicadores/controller' method='POST'>
                                                                                <input type='hidden' name='quienCrea' value= '<?php echo $quienCrea; ?>' >
                                                                                <input type='hidden' name='calculadoraMostrar' value= 'TRUE' >
                                                                                <input type='hidden' name='variablesIdPrincipal' value= '<?php echo $ultimoIndicadorSale; ?>' >
                                                                            <div class="modal-footer justify-content-between">
                                                                              <input type="hidden" id="capturarFormulaEliminacion" name='id' readonly>
                                                                              <button type="submit" name='AgregarVariablesEliminar' class="btn btn-outline-light">Si</button>
                                                                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                                                                            </div>
                                                                             </form>
                                                                             <!-- END formulario para eliminar por el id -->
                                                                          </div>
                                                                        </div>
                                                                    </div>
                                                                  </tbody>
                                                                </table>
                                                         </div>
                                                                          
                    </section>
                    <br>
                    <section>   
                           <!-- Calculadora -->
                                
                                <div class="contenidoCalculadora">
                                    <div class="pantalla">
                                        <div id="resultado"></div>
                                        <div>
                                            <?php
                                            
                                            ?>
                                                <!-- enviamos por javascript al input por el boton aceptar o submit-->
                                                <input style="background:#666;color:white;padding:9px;width:100%;" type="hidden" readonly size="36px" id="capturaVariable" name="ecuacion"><br>
                                                <!-- si se elimina esta etiqueta, el diseño se corre -->
                                                <a style="background:white;color:white;border-color:black;"></a>
                                            <?php
                                            
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                    /*
                                    ?>
                                    <div class="teclas">
                                       
                                            
                                       
                                        <div class="numeros">
                                            <div>
                                                <a class="numeros" id="n1">1</a>
                                                <a class="numeros" id="n2">2</a>
                                                <a class="numeros" id="n3">3</a>
                                                <a class="numeros" id="nCa">^</a>
                                                
                                            </div>
                                            <br><br>
                                            <div>
                                                <a class="numeros" id="n4">4</a>
                                                <a class="numeros" id="n5">5</a>
                                                <a class="numeros" id="n6">6</a>
                                                <a class="numeros" id="nP1">(</a>
                                                
                                            </div>
                                            <br><br>
                                            <div>
                                                <a class="numeros" id="n7">7</a>
                                                <a class="numeros" id="n8">8</a>
                                                <a class="numeros" id="n9">9</a>
                                                <a class="numeros" id="nP2">)</a>
                                            </div>
                                            <br><br>
                                            <div>
                                                <a class="numeros" id="nC">,</a>
                                                <a class="numeros" id="n0">0</a>
                                                <a class="numeros" id="nP">.</a>
                                                <a class="numeros" id="nMYMN">+/-</a>
                                            </div>
                                            
                                        </div>
                                        <div class="operaciones">
                                            <a class="operaciones" id="s" style="color:white;">+</a>
                                            <a class="operaciones" id="r" style="color:white;">-</a>
                                            <a class="operaciones" id="d" style="color:white;">/</a>
                                            <a class="operaciones" id="m" style="color:white;">x</a>
                                            <a class="operaciones" id="BT" style="color:white;">C</a>
                                        </div>
                                    </div>
                                    <div class="sr">
                                            <a class="sr" id="sr"></a>
                                    </div>
                                    <div class="variables">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v1" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v2" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v3" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v4" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v5" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                         
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v6" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v7" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v8" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v9" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v10" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v11" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v12" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v13" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v14" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v15" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                   
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v16" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v17" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v18" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v19" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v20" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v21" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v22" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v23" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v24" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v25" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v26" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v27" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v28" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v29" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v30" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <?php
                                    */
                                    ?>
                                </div>
                            
                                <script>
                                 /*función para retroceso*/
                                    document.getElementById("BT").addEventListener("click",borradoTotal);
                                 
                                    function borradoTotal() {
                                     document.getElementById("resultado").value= resultado.innerHTML=0; //poner pantalla a 0
                                     document.getElementById("capturaVariable").value= resultado.innerHTML=''; //poner pantalla a 0
                                    }
                                
                                
                                 /*Operaciones*/
                                    document.getElementById("s").addEventListener("click",operaciones1);
                                    document.getElementById("r").addEventListener("click",operaciones2);
                                    document.getElementById("d").addEventListener("click",operaciones3);
                                    document.getElementById("m").addEventListener("click",operaciones4);
                                    document.getElementById("sr").addEventListener("click",showResult);
                                   
                                    function operaciones1(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("s").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function operaciones2(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("r").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual +  sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function operaciones3(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("d").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual +  sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function operaciones4(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("m").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual +  sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function showResult(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let suma = actual.indexOf("+");
                                        let resta = actual.indexOf("-");
                                        let div = actual.indexOf("/");
                                        let mult = actual.indexOf("x");
                                        if(suma !== -1){
                                            arr = actual.split("+",2);
                                            res = parseInt(arr[0]) + parseInt(arr[1]);
                                            document.getElementById("resultado").innerHTML = res;
                                            /* enviamos al input donde capturamos la variable de la función*/
                                            document.getElementById("capturaVariable").value = res;
                                        }else if (resta !== -1){
                                            arr = actual.split("-",2);
                                            res = arr[0] - arr[1];
                                            document.getElementById("resultado").innerHTML = res;/* enviamos al input donde capturamos la variable de la función*/
                                            document.getElementById("capturaVariable").value = res;
                                        }else if (div !== -1){
                                            arr = actual.split("/",2);
                                            res = arr[0] / arr[1];
                                            document.getElementById("resultado").innerHTML = res;/* enviamos al input donde capturamos la variable de la función*/
                                            document.getElementById("capturaVariable").value = res;
                                        }else if (mult !== -1){
                                            arr = actual.split("x",2);
                                            res = arr[0] * arr[1];
                                            document.getElementById("resultado").innerHTML = res;/* enviamos al input donde capturamos la variable de la función*/
                                            document.getElementById("capturaVariable").value = res;
                                        }
                                    }
                                    
                                
                                
                                /* script para los numeros*/
                                    document.getElementById("n1").addEventListener("click",n1);
                                    document.getElementById("n2").addEventListener("click",n2);
                                    document.getElementById("n3").addEventListener("click",n3);
                                    document.getElementById("n4").addEventListener("click",n4);
                                    document.getElementById("n5").addEventListener("click",n5);
                                    document.getElementById("n6").addEventListener("click",n6);
                                    document.getElementById("n7").addEventListener("click",n7);
                                    document.getElementById("n8").addEventListener("click",n8);
                                    document.getElementById("n9").addEventListener("click",n9);
                                    document.getElementById("n0").addEventListener("click",n0);
                                    document.getElementById("n0").addEventListener("click",n0);
                                    document.getElementById("nP1").addEventListener("click",nP1);
                                    document.getElementById("nP2").addEventListener("click",nP2);
                                    document.getElementById("nCa").addEventListener("click",nCa);
                                    document.getElementById("nMYMN").addEventListener("click",nMYMN);
                                    
                                    
                                    
                                    
                                    function n1(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n1").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n2(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n2").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n3(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n3").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n4(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n4").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n5(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n5").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n6(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n6").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n7(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n7").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n8(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n8").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n9(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n9").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n0(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n0").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function nP1(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nP1").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function nP2(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nP2").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function nCa(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nCa").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function nMYMN(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nMYMN").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    /*script para el (.) y la (,)*/
                                    
                                    document.getElementById("nC").addEventListener("click",nC);
                                    document.getElementById("nP").addEventListener("click",nP);
                                    function nC(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nC").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function nP(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nP").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    
                                    /*script para las variables que se elistan al costado izquierda de la calculadora*/
                                    
                                    document.getElementById("v1").addEventListener("click",v1);
                                    document.getElementById("v2").addEventListener("click",v2);
                                    document.getElementById("v3").addEventListener("click",v3);
                                    document.getElementById("v4").addEventListener("click",v4);
                                    document.getElementById("v5").addEventListener("click",v5);
                                    document.getElementById("v6").addEventListener("click",v6);
                                    document.getElementById("v7").addEventListener("click",v7);
                                    document.getElementById("v8").addEventListener("click",v8);
                                    document.getElementById("v9").addEventListener("click",v9);
                                    document.getElementById("v10").addEventListener("click",v10);
                                    
                                     document.getElementById("v11").addEventListener("click",v11);
                                    document.getElementById("v12").addEventListener("click",v12);
                                    document.getElementById("v13").addEventListener("click",v13);
                                    document.getElementById("v14").addEventListener("click",v14);
                                    document.getElementById("v15").addEventListener("click",v15);
                                    document.getElementById("v16").addEventListener("click",v16);
                                    document.getElementById("v17").addEventListener("click",v17);
                                    document.getElementById("v18").addEventListener("click",v18);
                                    document.getElementById("v19").addEventListener("click",v19);
                                    document.getElementById("v20").addEventListener("click",v20);
                                    
                                    document.getElementById("v21").addEventListener("click",v21);
                                    document.getElementById("v22").addEventListener("click",v22);
                                    document.getElementById("v23").addEventListener("click",v23);
                                    document.getElementById("v24").addEventListener("click",v24);
                                    document.getElementById("v25").addEventListener("click",v25);
                                    document.getElementById("v26").addEventListener("click",v26);
                                    document.getElementById("v27").addEventListener("click",v27);
                                    document.getElementById("v28").addEventListener("click",v28);
                                    document.getElementById("v29").addEventListener("click",v29);
                                    document.getElementById("v30").addEventListener("click",v30);
                                     
                                     function v1(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v1").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v2(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v2").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v3(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v3").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v4(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v4").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v5(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v5").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v6(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v6").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v7(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v7").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v8(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v8").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v9(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v9").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v10(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v10").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    function v11(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v11").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    function v12(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v12").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v13(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v13").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v14(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v14").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v15(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v15").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v16(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v16").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v17(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v17").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v18(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v18").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v19(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v19").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v20(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v20").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    function v21(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v21").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    function v22(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v22").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v23(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v23").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v24(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v24").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v25(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v25").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v26(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v26").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v27(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v27").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v28(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v28").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v29(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v29").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v30(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v30").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    
                                    /* envia los simbolos creados para aplicarlos en la calculadora*/
                                     document.getElementById("enviarVariable1").addEventListener("click",enviarVariable1);
                                     document.getElementById("enviarVariable2").addEventListener("click",enviarVariable2);
                                     document.getElementById("enviarVariable3").addEventListener("click",enviarVariable3);
                                     document.getElementById("enviarVariable4").addEventListener("click",enviarVariable4);
                                     document.getElementById("enviarVariable5").addEventListener("click",enviarVariable5);
                                     document.getElementById("enviarVariable6").addEventListener("click",enviarVariable6);
                                     document.getElementById("enviarVariable7").addEventListener("click",enviarVariable7);
                                     document.getElementById("enviarVariable8").addEventListener("click",enviarVariable8);
                                     document.getElementById("enviarVariable9").addEventListener("click",enviarVariable9);
                                     document.getElementById("enviarVariable10").addEventListener("click",enviarVariable10);
                                    
                                     document.getElementById("enviarVariable11").addEventListener("click",enviarVariable11);
                                     document.getElementById("enviarVariable12").addEventListener("click",enviarVariable12);
                                     document.getElementById("enviarVariable13").addEventListener("click",enviarVariable13);
                                     document.getElementById("enviarVariable14").addEventListener("click",enviarVariable14);
                                     document.getElementById("enviarVariable15").addEventListener("click",enviarVariable15);
                                     document.getElementById("enviarVariable16").addEventListener("click",enviarVariable16);
                                     document.getElementById("enviarVariable17").addEventListener("click",enviarVariable17);
                                     document.getElementById("enviarVariable18").addEventListener("click",enviarVariable18);
                                     document.getElementById("enviarVariable19").addEventListener("click",enviarVariable19);
                                     document.getElementById("enviarVariable20").addEventListener("click",enviarVariable20);
                                     
                                     document.getElementById("enviarVariable21").addEventListener("click",enviarVariable21);
                                     document.getElementById("enviarVariable22").addEventListener("click",enviarVariable22);
                                     document.getElementById("enviarVariable23").addEventListener("click",enviarVariable23);
                                     document.getElementById("enviarVariable24").addEventListener("click",enviarVariable24);
                                     document.getElementById("enviarVariable25").addEventListener("click",enviarVariable25);
                                     document.getElementById("enviarVariable26").addEventListener("click",enviarVariable26);
                                     document.getElementById("enviarVariable27").addEventListener("click",enviarVariable27);
                                     document.getElementById("enviarVariable28").addEventListener("click",enviarVariable28);
                                     document.getElementById("enviarVariable29").addEventListener("click",enviarVariable29);
                                     document.getElementById("enviarVariable30").addEventListener("click",enviarVariable30);
                                     
                                     
                                    function enviarVariable1(){
                                        
                                        let enviar = document.getElementById("enviarVariable1").innerHTML;
                                        document.getElementById('v1').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable2(){
                                        
                                        let enviar = document.getElementById("enviarVariable2").innerHTML;
                                        document.getElementById('v2').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable3(){
                                        
                                        let enviar = document.getElementById("enviarVariable3").innerHTML;
                                        document.getElementById('v3').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable4(){
                                        
                                        let enviar = document.getElementById("enviarVariable4").innerHTML;
                                        document.getElementById('v4').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable5(){
                                        
                                        let enviar = document.getElementById("enviarVariable5").innerHTML;
                                        document.getElementById('v5').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable6(){
                                        
                                        let enviar = document.getElementById("enviarVariable6").innerHTML;
                                        document.getElementById('v6').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable7(){
                                        
                                        let enviar = document.getElementById("enviarVariable7").innerHTML;
                                        document.getElementById('v7').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable8(){
                                        
                                        let enviar = document.getElementById("enviarVariable8").innerHTML;
                                        document.getElementById('v8').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable9(){
                                        
                                        let enviar = document.getElementById("enviarVariable9").innerHTML;
                                        document.getElementById('v9').innerHTML = enviar
                                        
                                    }
                                     
                                    function enviarVariable10(){
                                        
                                        let enviar = document.getElementById("enviarVariable10").innerHTML;
                                        document.getElementById('v10').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable11(){
                                        
                                        let enviar = document.getElementById("enviarVariable11").innerHTML;
                                        document.getElementById('v11').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable12(){
                                        
                                        let enviar = document.getElementById("enviarVariable12").innerHTML;
                                        document.getElementById('v12').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable13(){
                                        
                                        let enviar = document.getElementById("enviarVariable13").innerHTML;
                                        document.getElementById('v13').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable14(){
                                        
                                        let enviar = document.getElementById("enviarVariable14").innerHTML;
                                        document.getElementById('v14').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable15(){
                                        
                                        let enviar = document.getElementById("enviarVariable15").innerHTML;
                                        document.getElementById('v15').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable16(){
                                        
                                        let enviar = document.getElementById("enviarVariable16").innerHTML;
                                        document.getElementById('v16').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable17(){
                                        
                                        let enviar = document.getElementById("enviarVariable17").innerHTML;
                                        document.getElementById('v17').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable18(){
                                        
                                        let enviar = document.getElementById("enviarVariable18").innerHTML;
                                        document.getElementById('v18').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable19(){
                                        
                                        let enviar = document.getElementById("enviarVariable19").innerHTML;
                                        document.getElementById('v19').innerHTML = enviar
                                        
                                    }
                                     
                                    function enviarVariable20(){
                                        
                                        let enviar = document.getElementById("enviarVariable20").innerHTML;
                                        document.getElementById('v20').innerHTML = enviar
                                        
                                    }
                                    
                                    function enviarVariable21(){
                                        
                                        let enviar = document.getElementById("enviarVariable21").innerHTML;
                                        document.getElementById('v21').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable22(){
                                        
                                        let enviar = document.getElementById("enviarVariable22").innerHTML;
                                        document.getElementById('v22').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable23(){
                                        
                                        let enviar = document.getElementById("enviarVariable23").innerHTML;
                                        document.getElementById('v23').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable24(){
                                        
                                        let enviar = document.getElementById("enviarVariable24").innerHTML;
                                        document.getElementById('v24').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable25(){
                                        
                                        let enviar = document.getElementById("enviarVariable25").innerHTML;
                                        document.getElementById('v25').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable26(){
                                        
                                        let enviar = document.getElementById("enviarVariable26").innerHTML;
                                        document.getElementById('v26').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable27(){
                                        
                                        let enviar = document.getElementById("enviarVariable27").innerHTML;
                                        document.getElementById('v27').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable28(){
                                        
                                        let enviar = document.getElementById("enviarVariable28").innerHTML;
                                        document.getElementById('v28').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable29(){
                                        
                                        let enviar = document.getElementById("enviarVariable29").innerHTML;
                                        document.getElementById('v29').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable30(){
                                        
                                        let enviar = document.getElementById("enviarVariable30").innerHTML;
                                        document.getElementById('v30').innerHTML = enviar
                                        
                                    }
                                    
                                    /* end envia los simbolos creados para aplicarlos en la calculadora*/
                                    
                                    
                                /* 303 líneas de código para la calculadora, atrapar la variable al aplicar y desaplicar y eviarla a una variable*/
                                </script>
                            <!-- END calculadora -->
                            <!-- se usa esta función para el resultado de la calculadora y capturarlo en el input de formula -->
                            <script>
                                function funcionFormula() {
                                    /*alert("entre");*/
                                  document.getElementById("capturarFormula").value = document.getElementById("capturaVariable").value;
                                }
                            </script>
                            <!-- END -->
                            <br>
                                                       
                            <br><br>
                             <input style="background:#666;color:white;padding:9px;width:30%;color:white;" name="formula" id="capturarFormula" type="" value="<?php echo $verIndicador['formula']; ?>"  size="36px" required>
                             
                            <div class="row">
                                <div class="form-group col-sm-6">
                                
                                       
                                </div>
                                <div class="form-group col-sm-6">
                       
                                    <br><br>
                                      <table>
                                    <tr>
                                        <td>
                                           
                                        </td>
                                        <td>
                                            <font color="white">espacio</font>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-success float-right" id="regresarA">Regresar</a>    
                                        </td>
                                        <td>
                                            <font color="white">espacio</font>
                                        </td>
                                        <td> <!--<input  value="1" type="hidden">-->
                                            <button name="actualizar" type="submit" style="color:white;" class="btn btn-warning float-right" >Siguiente</button>
                                            <!--<input type="button" Value="Siguiente" name="actualizar" onclick="document.formulario.action='controlador/indicadores/controller'; document.formulario.submit()";>
                                            onclick="document.formulario.action='controlador/indicadores/controller'; document.formulario.submit()";
                                            -->
                                        </td>
                                    </tr>
                                 </table>
                              </div>
                            </div>
                    </section>
                </div>
            </form>
                 <? 
                 $siguiente=$_POST['siguiente'];
                 
                 if($siguiente != NULL){
                    $ocultarVista='';
                 }else{
                    $ocultarVista='none'; 
                 }
                 ?>
                <div id="tercerVista" style="display:<?php echo $ocultarVista;?>;">
                    <form role="form" action="controlador/indicadores/controller" method="POST" enctype="multipart/form-data">
                    <input name="idIndicador" value="<?php echo $recibeID;?>" readonly type="hidden">
                    <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $ultimoIndicado=$mysqli->query("SELECT * FROM `indicadores` WHERE id='$recibeID'  ");
                                $extraeDatoIndicador= $ultimoIndicado->fetch_array(MYSQLI_ASSOC);
                                $ultimoIndicadorSale=$extraeDatoIndicador['id'];
                                $ultimoIndicadorSaleQuienCrea=$extraeDatoIndicador['quienCrea'];
                                $nombreIndicador=$extraeDatoIndicador['nombre'];
                                $sentido=$extraeDatoIndicador['sentido'];
                                
                    
                                     $metaMedida=$mysqli->query("SELECT * FROM indicadoresMetas WHERE idIndicador='$recibeID' ");
                                     $datoMeta=$metaMedida->fetch_array(MYSQLI_ASSOC);
                                     $actualizarMetaPrincipal=$datoMeta['id'];
                                     $metaActualValidar=$datoMeta['metaActual'];
                                     $unidadValidar=$datoMeta['unidad'];
                                     $desdeValidar=$datoMeta['desde'];
                                     $hastaValidar=$datoMeta['hasta'];
                                     $zp=$datoMeta['zp'];
                                     $za=$datoMeta['za'];
                                     $zc=$datoMeta['zc'];
                                     $ze=$datoMeta['ze'];
                                     
                                     /// con esta variable bloqueamos el indicador si viene sin meta
                                      $metasHabilitadas=$datoMeta['metas'];
                                     /// END
                                     
                                     if($metasHabilitadas == 'No'){
                                        echo '<h6>El indicador se creo sin metas</h6><br><br>';
                                     }else{
                                     ?>
                                     <input name="metaPrincipal" value="<?php echo $actualizarMetaPrincipal; ?>" type="hidden">
                                    <div class="row">
                                                <div class="form-group col-sm-6">
                                                    <label>Unidad de medida:</label>
                                                    <!-- <input type="text" class="form-control" name="unidad" value="<?php //echo $unidadValidar; ?>" placeholder="Unidad de medida" required>-->
                                                    <select type="text" class="form-control" name="unidad" placeholder="Unidad de medida" required>
                                                        
                                                                 <?php
                                                                 $unidadMedida=$mysqli->query("SELECT * FROM indicadoresUnidad WHERE unidad='$unidadValidar' ORDER BY unidad");
                                                                 while($datoUnidad=$unidadMedida->fetch_array()){
                                                                 ?>
                                                                 <option value="<?php echo $datoUnidad['unidad']; ?>"><?php echo $datoUnidad['unidad']; ?></option>
                                                                <?php
                                                                 }
                                                                ?>
                                                                 <?php
                                                                 $unidadMedidaS=$mysqli->query("SELECT * FROM indicadoresUnidad ORDER BY unidad");
                                                                 while($datoUnidadS=$unidadMedidaS->fetch_array()){
                                                                 ?>
                                                                 <option value="<?php echo $datoUnidadS['unidad']; ?>"><?php echo $datoUnidadS['unidad']; ?></option>
                                                                <?php
                                                                 }
                                                                ?>
                                                    </select>
                                                    <br><br>
                                                    <label>Desde:</label>
                                                    <input type="date" class="form-control" name="desde" placeholder="Desde" value="<?php echo $desdeValidar; ?>" required>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label>Meta actual:</label>
                                                    <input type="number" min="1" class="form-control" name="metaActual" value="<?php echo $metaActualValidar; ?>" placeholder="Meta actual" required>
                                                    <br><br>
                                                    <label>Hasta:</label>
                                                    <input type="date" class="form-control" name="hasta" placeholder="Hasta" value="<?php echo $hastaValidar; ?>" required>
                                                </div>
                                                
                                                <div class="form-group col-sm-12">
                                                    <style>
                                                        .bindicador::placeholder{
                                                            color: white;
                                                            font-size:12px;
                                                        }
                                                        .nindicador::placeholder{
                                                            color: black;
                                                            font-size:12px;
                                                        }
                                                  </style>
                                                <label>Llenar las siguientes zonas identificadas por cada color</label><br>
                                                
                                                <?php
                                                ///// si el indicador viene positivo tiene este orden
                                                if($sentido == 'Positivo'){
                                                     $unidadValidar;
                                                        $max=$metaActualValidar-1;
                                                        $max2=$metaActualValidar+1;
                                                    ?>
                                                    <script></script>
                                                        <input name="zp" class="bindicador" value="<?php echo $zp; ?>" placeholder="Zona de Peligro" style="text-align:center;border-color:red;background:red;color:white;border:0px;width: 20%;" type="number" min="1"  required> <!-- max="<?php //echo $max; ?>" -->
                                                        <input name="za" class="nindicador" value="<?php echo $za; ?>" placeholder="Zona de alerta" style="text-align:center;border-color:yellow;background:yellow;color:black;border:0px;width: 20%;" type="number" min="1"  required> <!-- max="<?php //echo $max; ?>" -->
                                                        <input name="zc" class="nindicador" value="<?php echo $metaActualValidar; ?>" placeholder="Zona de Cumplimiento" style="text-align:center;border-color:green;background:green;color:white;border:0px;width: 20%;" type="number" required> <!-- min="<?php //echo $metaActualValidar; ?>" max="<?php //echo $metaActualValidar; ?>" -->
                                                        <input name="ze" class="bindicador" value="<?php echo $ze; ?>" placeholder="Zona de Exceso" style="text-align:center;border-color:blue;background:blue;color:white;border:0px;width: 20%;" type="number"  required> <!-- min="<?php //echo $max2; ?>" -->
                                                    <?php
                                                }
                                                
                                                
                                                
                                                ////// si el indicador viene negativo tiene este orden
                                                if($sentido == 'Negativo'){
                                                $min=$metaActualValidar+1;
                                                $min2=$metaActualValidar-1;
                                                ?>
                                                <input name="ze" class="bindicador" value="<?php echo $ze; ?>" placeholder="Zona de Exceso" style="text-align:center;border-color:blue;background:blue;color:white;border:0px;width: 20%;" type="number" min="-100"  required> <!-- max="<?php //echo $min2; ?>" -->
                                                <input name="zc" class="nindicador" value="<?php echo $metaActualValidar; ?>" placeholder="Zona de Cumplimiento" style="text-align:center;border-color:green;background:green;color:white;border:0px;width: 20%;" type="number"  required> <!-- min="<?php //echo $metaActualValidar; ?>" max="<?php //echo $metaActualValidar; ?>" -->
                                                <input name="za" class="nindicador" value="<?php echo $za; ?>" placeholder="Zona de alerta" style="text-align:center;border-color:yellow;background:yellow;color:black;border:0px;width: 20%;" type="number"  required> <!-- min="<?php //echo $min; ?>" -->
                                                <input name="zp" class="bindicador" value="<?php echo $zp; ?>" placeholder="Zona de Peligro" style="text-align:center;border-color:red;background:red;color:white;border:0px;width: 20%;" type="number"  required> <!-- min="<?php //echo $min; ?>" -->
                                                <?php
                                                }
                                                ?>
                                                </div>
                                               
                                          </div>
                                    <?php
                                     }
                                    ?>
                    <div class="row">
                        
                        <div class="form-group col-sm-6">
                                 <table>
                                    <tr>
                                        <?php
                                        if($metasHabilitadas == 'No'){ }else{
                                        ?>
                                        <td>
                                            <!-- form start -->
                                                <input type="button" style="color:white;" class="btn btn-warning" id="abrirAgregarMEta" value="Nuevo" >
                                                <input type="button" style="color:white;display:none;" class="btn btn-success" id="cerrarAgregarMEta" value="Cerrar" >
                                                <!-- Agregar más metas -->
                                        </td>
                                        <td>
                                            <font color="white">espacio</font>
                                        </td>
                                        <td>
                                            <div name="ocultarMostrar" id="ocultarMostrar">
                                                    <input type="button" class="btn btn-primary" value="Ver historial de metas" id="rad_mostrar" name="radiobtn" value="mostrar">
                                            </div>
                                            <div name="ocultar" id="ocultar" style="display:none;">
                                                    <input type="button" class="btn btn-success" value="Ocultar historial de metas" id="rad_ocultar" name="radiobtn" value="ocultar">
                                            </div>
                                        </td>
                                        <td>
                                            <font color="white">espacio</font>
                                        </td>
                                        <?php
                                        }
                                        ?>
                                        <td>
                                            <a href="#" class="btn btn-success float-left" id="regresarB">Regresar</a>    
                                        </td>
                                        <td>
                                            <font color="white">espacio</font>
                                        </td>
                                        <td>
                                            <button type="submit" style="color:white;" class="btn btn-warning float-left" name="actualizarMeta">Guardar</button>
                                        </td>
                                    </tr>
                                 </table>
                                       
                        </div>
                    </div>
                    </form>
                    <?  ?>
                 
                    <br><br>             
                    
                    
                    <!-- Agregar más metas-->
                    <div id="agregarMeta" style="display:none;">
                        <form action="controlador/indicadores/controller" method="POST">
                        <div class="row">
                                          
                                            
                                                <div class="form-group col-sm-6">
                                                    <label>Unidad de medida:</label>
                                                    <input type="hidden" class="form-control" name="idIndicador" value="<?php echo $recibeID; ?>" readonly  required>
                                                    <input type="hidden" class="form-control" name="quienCrea" value="<?php echo $quienCrea; ?>" readonly  required>
                                                    <select type="text" class="form-control" name="unidad" placeholder="Unidad de medida" required>
                                                      
                                                                 <?php
                                                                 $unidadMedidaS=$mysqli->query("SELECT * FROM indicadoresUnidad ORDER BY unidad");
                                                                 while($datoUnidadS=$unidadMedidaS->fetch_array()){
                                                                 ?>
                                                                 <option value="<?php echo $datoUnidadS['unidad']; ?>"><?php echo $datoUnidadS['unidad']; ?></option>
                                                                <?php
                                                                 }
                                                                ?>
                                                    </select>
                                                    <br><br>
                                                    <label>Desde:</label>
                                                    <input type="date" class="form-control" name="desde" placeholder="Desde"  required>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label>Meta actual:</label>
                                                    <input type="number" min="1" class="form-control" name="metaActual"  placeholder="Meta actual" required>
                                                    <br><br>
                                                    <label>Hasta:</label>
                                                    <input type="date" class="form-control" name="hasta" placeholder="Hasta"  required>
                                                </div>
                                                
                                                <div class="form-group col-sm-12">
                                                    <style>
                                                        .bindicador::placeholder{
                                                            color: white;
                                                            font-size:12px;
                                                        }
                                                        .nindicador::placeholder{
                                                            color: black;
                                                            font-size:12px;
                                                        }
                                                  </style>
                                                <label>Llenar las siguientes zonas identificadas por cada color</label><br>
                                                
                                                <?php
                                                ///// si el indicador viene positivo tiene este orden
                                                if($sentido == 'Positivo'){
                                                    $max=$metaActualValidar-1;
                                                    $max2=$metaActualValidar+1;
                                                ?>
                                                    <input name="zp" class="bindicador" placeholder="Zona de Peligro" style="text-align:center;border-color:red;background:red;color:white;border:0px;width: 20%;" type="number" min="1" max="" required>
                                                    <input name="za" class="nindicador" placeholder="Zona de alerta" style="text-align:center;border-color:yellow;background:yellow;color:black;border:0px;width: 20%;" type="number" min="1" max="" required>
                                                    <input name="zc" class="nindicador" placeholder="Zona de Cumplimiento" style="text-align:center;border-color:green;background:green;color:white;border:0px;width: 20%;" type="number" min="1" max="" required>
                                                    <input name="ze" class="bindicador" placeholder="Zona de Exceso" style="text-align:center;border-color:blue;background:blue;color:white;border:0px;width: 20%;" type="number" min="1" required>
                                                <?php
                                                }
                                                
                                                
                                                ////// si el indicador viene negativo tiene este orden
                                                if($sentido == 'Negativo'){
                                                $min=$metaActualValidar+1;
                                                $min2=$metaActualValidar-1;
                                                ?>
                                                <input name="ze" class="bindicador" placeholder="Zona de Exceso" style="text-align:center;border-color:blue;background:blue;color:white;border:0px;width: 20%;" type="number" min="-100" max="" required>
                                                <input name="zc" class="nindicador" placeholder="Zona de Cumplimiento" style="text-align:center;border-color:green;background:green;color:white;border:0px;width: 20%;" type="number" min="1" max="" required>
                                                <input name="za" class="nindicador" placeholder="Zona de alerta" style="text-align:center;border-color:yellow;background:yellow;color:black;border:0px;width: 20%;" type="number" min="1" required>
                                                <input name="zp" class="bindicador" placeholder="Zona de Peligro" style="text-align:center;border-color:red;background:red;color:white;border:0px;width: 20%;" type="number" min="1" required>
                                                <?php
                                                }
                                                ?>
                                                </div>
                                           
                                            <button type="submit" style="color:white;" class="btn btn-warning float-left" name="agregarNuevaMeta">Guardar</button>
                                        </div>
                                        </form>
                    </div>
                    <!-- END Agregar más metas-->               
                    
                    
                    <!-- muestra el historial con el script  -->               
                    <div name="mostrar" id="mostrar" style="display:none;"> 
                               
                                  
                                    <br><br>
                                 
                                            <?php
                                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                $ultimoIndicadoMetas=$mysqli->query("SELECT * FROM `indicadoresMetas` WHERE idIndicador='$ultimoIndicadorSale' AND quienCrea='$quienCrea' ORDER BY id  ");
                                                ///$extraeDatoIndicador= $ultimoIndicado->fetch_array(MYSQLI_ASSOC);
                                                while($extraeDatoIndicadorMetas= $ultimoIndicadoMetas->fetch_array()){
                                            ?>   
                                     
                                    <div class="card-body">
                                          <div class="row">
                                              <div class="form-group col-sm-6">
                                                    <label>¿Desea manejar un indicador sin metas?</label><br>
                                                    <?php
                                                    if($extraeDatoIndicadorMetas['metas'] == 'Si'){
                                                        echo 'Si';
                                                    }else{
                                                        echo 'No';
                                                    }
                                                    ?>
                                                    <br><br>
                                                    
                                                    <label>Unidad de medida:</label>
                                                    <input class="form-control"  value="<?php echo $extraeDatoIndicadorMetas['unidad']; ?>" readonly>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label><font color="white">------</font></label><br>
                                                    <input type="radio" style="visibility:hidden;" >
                                                    <input type="radio" style="visibility:hidden;" >
                                                     <br><br>
                                                    
                                                    <label>Meta actual:</label>
                                                    <input class="form-control" value="<?php if($extraeDatoIndicadorMetas['unidad'] == '$'){ echo '$'.number_format($extraeDatoIndicadorMetas['metaActual'],0,'.',','); }else{ echo $extraeDatoIndicadorMetas['metaActual']; } ?>" readonly>
                                                    </div>
                                                <div class="form-group col-sm-6">
                                                    <label>Desde:</label>
                                                    <input class="form-control" value="<?php echo $extraeDatoIndicadorMetas['desde']; ?>" readonly>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label>Hasta:</label>
                                                    <input class="form-control" value="<?php echo $extraeDatoIndicadorMetas['hasta']; ?>" readonly>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <img src="../dist/img/metas.png" width="150%">
                                                </div>
                                                <div class="form-group col-sm-12">
                                                    <style>
                                                        #bindicador::placeholder{
                                                            color: white;
                                                            font-size:12px;
                                                        }
                                                        #nindicador::placeholder{
                                                            color: black;
                                                            font-size:12px;
                                                        }
                                                  </style>
                                                  <?php
                                                  if($extraeDatoIndicadorMetas['unidad'] == '$'){
                                                  ?>
                                                    <input name="zp" value="$<?php echo number_format($extraeDatoIndicadorMetas['zp'],0,'.',','); ?>" readonly id="bindicador" style="text-align:center;border-color:red;background:red;color:white;border:0px;width: 20%;">
                                                    <input name="za" value="$<?php echo number_format($extraeDatoIndicadorMetas['za'],0,'.',','); ?>" readonly id="nindicador" style="text-align:center;border-color:yellow;background:yellow;color:black;border:0px;width: 20%;">
                                                    <input name="zc" value="$<?php echo number_format($extraeDatoIndicadorMetas['zc'],0,'.',','); ?>" readonly id="nindicador" style="text-align:center;border-color:green;background:green;color:white;border:0px;width: 20%;">
                                                    <input name="ze" value="$<?php echo number_format($extraeDatoIndicadorMetas['ze'],0,'.',','); ?>" readonly id="bindicador" style="text-align:center;border-color:blue;background:blue;color:white;border:0px;width: 20%;">
                                                <?php
                                                  }else{
                                                ?>
                                                    <input name="zp" value="<?php echo $extraeDatoIndicadorMetas['zp']; ?>" readonly id="bindicador" style="text-align:center;border-color:red;background:red;color:white;border:0px;width: 20%;">
                                                    <input name="za" value="<?php echo $extraeDatoIndicadorMetas['za']; ?>" readonly id="nindicador" style="text-align:center;border-color:yellow;background:yellow;color:black;border:0px;width: 20%;">
                                                    <input name="zc" value="<?php echo $extraeDatoIndicadorMetas['zc']; ?>" readonly id="nindicador" style="text-align:center;border-color:green;background:green;color:white;border:0px;width: 20%;">
                                                    <input name="ze" value="<?php echo $extraeDatoIndicadorMetas['ze']; ?>" readonly id="bindicador" style="text-align:center;border-color:blue;background:blue;color:white;border:0px;width: 20%;">
                                                <?php
                                                  }
                                                ?>
                                                    
                                                <form action="controlador/indicadores/controller" method="POST">
                                                     <input type="hidden" name='variablesIdPrincipal' value="<?php echo $recibeID; ?>" >
                                                    <input name="idIndicador" value="<?php echo $extraeDatoIndicadorMetas['id']; ?>" type="hidden" readonly>
                                                    <button type="submit" style="color:white;" class="btn btn-danger float-right" name="borrarMetaIdIndicador">Eliminar</button>
                                                </form>
                                                </div>
                                          </div>
                                          
                                    </div>
                                <!-- /.card-body -->
                               
                                            <?php
                                                }
                                            ?>
                    </div>
                    <!-- END muestra el historial con el script  --> 
                    
                    <?  ?>
                    
                </div> <!-- aca cierra la tercera vista -->
                
                 
                  
                </div>
                <!-- /.card-body -->

               
              
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
<script type="text/javascript">
	function ConfirmDelete(){
		var answer = confirm("Está seguro de eliminar?");

		if(answer == true){
			return true;
		}else{
			return false;
		}
	}
	
	function ConfirmPermiso(){
		var answer = confirm("No tiene permiso para terminar el indicador !");
    }
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoRI').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoRI").html(data);
            }); 
        });
        $('#rad_usuarioRI').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoRI").html(data);
            }); 
        });
    });
</script>
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
<script>
    $(document).ready(function(){
        $('#rad_cargoAut').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoAut").html(data);
            }); 
        });
        $('#rad_usuarioAut').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoAutU").html(data);
            }); 
        });
    });
</script>
<script>
        $(document).ready(function(){
            $('#siguienteA').click(function(){
                document.getElementById('primeraVista').style.display = 'none';
                document.getElementById('tercerVista').style.display = 'none';
                document.getElementById('segundaVista').style.display = '';
                
            });
            $('#siguienteB').click(function(){
                document.getElementById('primeraVista').style.display = 'none';
                document.getElementById('segundaVista').style.display = 'none';
                document.getElementById('tercerVista').style.display = '';
            });
            
            $('#regresarA').click(function(){
                document.getElementById('primeraVista').style.display = '';
                document.getElementById('segundaVista').style.display = 'none';
                document.getElementById('tercerVista').style.display = 'none';
               
            });
            $('#regresarB').click(function(){
                document.getElementById('primeraVista').style.display = 'none';
                document.getElementById('segundaVista').style.display = '';
                document.getElementById('tercerVista').style.display = 'none';
               
            });
        });
</script>
<script>
        $(document).ready(function(){
            $('#rad_mostrar').click(function(){
                
                document.getElementById('ocultarMostrar').style.display = 'none';
                document.getElementById('ocultar').style.display = '';
                document.getElementById('mostrar').style.display = '';
            });

            $('#rad_ocultar').click(function(){
                document.getElementById('ocultarMostrar').style.display = '';
                document.getElementById('mostrar').style.display = 'none';
                document.getElementById('ocultar').style.display = 'none';
            });
        });
        
        $(document).ready(function(){
            $('#abrirAgregarMEta').click(function(){
                document.getElementById('abrirAgregarMEta').style.display = 'none'; 
                document.getElementById('agregarMeta').style.display = '';
                document.getElementById('cerrarAgregarMEta').style.display = '';
                
            });
        });
        
        $(document).ready(function(){
            $('#cerrarAgregarMEta').click(function(){
                document.getElementById('abrirAgregarMEta').style.display = '';
                document.getElementById('agregarMeta').style.display = 'none';
                document.getElementById('cerrarAgregarMEta').style.display = 'none';
            });
        });
        
         $(document).ready(function(){
            $('#mostrarVariablesAbrir').click(function(){
                document.getElementById('mostrarVariablesAbrir').style.display = 'none';
                document.getElementById('mostrarVariables').style.display = '';
                document.getElementById('mostrarVariablesCerrar').style.display = '';
                
            });
        });
        $(document).ready(function(){
            $('#mostrarVariablesCerrar').click(function(){
                document.getElementById('mostrarVariablesAbrir').style.display = '';
                document.getElementById('mostrarVariables').style.display = 'none';
                document.getElementById('mostrarVariablesCerrar').style.display = 'none';
                
            });
        });
    </script>
 <!-- archivos para el filtro de busqueda y lista de información -->

    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
 
    <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
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
$validacionExisteB=$_POST['validacionExisteB'];
$validacionExisteC=$_POST['validacionExisteC'];
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
            title: ' El nombre o el archivo ya existe.'
        })
    <?php
    }
    if($validacionExisteB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Error, la fecha seleccionada ya se encuentra asignada.'
        })
    <?php
    }
    if($validacionExisteC == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' La variable ya existe.'
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
</body>
</html>
<?php
}
?>