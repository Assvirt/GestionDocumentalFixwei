<?php
//Solicitud Compra
error_reporting(E_ERROR);
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
<head><meta charset="gb18030">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Agregar Solicitud</title>
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
            <h1>Agregar solicitud de compra</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Agregar solicitud de compra</li>
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
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="solicitudCompra"><font color="white"><i class="fas fa-list"></i> Listar solicitud de compra</font></a></button>
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
               
                <div class="card card-primary">
              <div class="card-header">
               <!-- <h3 class="card-title">Agregar solicitud de compra</h3>-->
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/solicitudCompra/controllerSolicitudCompra" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    
                <!-- parametros para la activacion de correo y plataforma -->
                    <div class="row"> 
                        <div class="form-group col-sm-6">
                          <input name="idUsuario" value="<?php echo $sesion;?>" type="hidden" readonly>
                          <!--<label>Notificaciones por: </label>&nbsp;&nbsp;-->
                              <?php if($visibleP != 'none'){ ?>
                              
                                <!--<label>Plataforma</label>-->
                                    <input style="border:0px;" name="plataforma" value="1" type="hidden" readonly>
                                <?php }else{  }
                          
                              if($visibleP != 'none' && $visibleC != 'none'){
                                   '-';
                              }
                          
                                    if($visibleC != 'none'){ ?>
                                <!--<label>Correo</label>-->
                                    <input style="border:0px;" name="correo" value="1" type="hidden" readonly>
                                <?php }else{  } ?>
                        </div>
                    </div>
                <!-- Fin parametros para la activacion de correo y plataforma -->
                    
                    
                    
                   <?php
                             date_default_timezone_set('America/Bogota');
                             //$fecha1=date('d-m-Y');
                    ?>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Fecha Solicitud</label>
                            <input type="date" class="form-control" name="fechaSolicitud" min="<?php echo date("Y-m-d"); ?>" value="<?php echo date("Y-m-d"); ?>" required>
                        </div>
                         <div class="form-group col-sm-6">
                            <label>Dirección y contacto de entrega:</label>
                            <input type="text" class="form-control" name="contacto" placeholder="Ingrese Direccion" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                        </div>
                         <div class="form-group col-sm-6">
                            <label>Tipo de solicitud:</label>
                           <select type="text" class="form-control"  name="tipoSolicitud" placeholder="" required>
                                <option value=""></option>
                                <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $data = $mysqli->query("SELECT * FROM solicitudCompraSolicitud ORDER BY tipo ASC")or die(mysqli_error());
                                while($row = $data->fetch_assoc()){
                                ?>
                                <option value="<?php echo $row['id'];?>"><?php echo $row['tipo'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Tipo de gasto</label>
                            <select type="text" class="form-control"  name="tipoCompra" placeholder="" required>
                                <option value=""></option>
                                <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $data = $mysqli->query("SELECT * FROM solicitudCompraTipo ORDER BY tipo ASC")or die(mysqli_error());
                                while($row = $data->fetch_assoc()){
                                ?>
                                <option value="<?php echo $row['id'];?>"><?php echo $row['tipo'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                         <div class="form-group col-sm-6">
                             <label>Centro de costos:</label>
                             
                                <div class="select2-blue">
                                    
                                    
                                    <select class="select2" multiple="multiple" data-placeholder="Seleccionar centro de costo" style="width: 100%;" name="centroCostoS[]" id="centroCostoS" required>
                                        <?php 
                                        $resultadoCT =$mysqli->query("SELECT * FROM presupuesto ORDER BY nombre ASC");
                                        while ($columna = mysqli_fetch_array( $resultadoCT )) { 
                                        
                                            //// validamos la existencia del presupuesto para el responsable del centro de costo
                                            $preguntandoExistenciaResponsableCC=$mysqli->query("SELECT * FROM centroCostos WHERE persona='".$columna['responsable']."' ");
                                            $respuestaExistenciaPresupuesto=$preguntandoExistenciaResponsableCC->fetch_array(MYSQLI_ASSOC);
                                            
                                            
                                            if($respuestaExistenciaPresupuesto['id'] != NULL){
                                                
                                            }else{
                                                continue;
                                            }
                                        
                                        ?>
                                        <option value="<?php echo $respuestaExistenciaPresupuesto['id']; ?>"><?php echo $respuestaExistenciaPresupuesto['codigo'].'-'.$respuestaExistenciaPresupuesto['nombre'];?> </option>
                                        <?php }  ?>      
                                    </select>
                                    <?php
                                    /*
                                    ?>
                                    <select class="select2" multiple="multiple" data-placeholder="Seleccionar centro de costo" style="width: 100%;" name="centroCostoS[]" id="centroCostoS" required>
                                        <?php 
                                        $resultadoCT =$mysqli->query("SELECT * FROM centroCostos ORDER BY nombre ASC");
                                        while ($columna = mysqli_fetch_array( $resultadoCT )) { 
                                        
                                            //// validamos la existencia del presupuesto para el responsable del centro de costo
                                            $preguntandoExistenciaResponsableCC=$mysqli->query("SELECT * FROM presupuesto WHERE responsable='".$columna['persona']."' ");
                                            $respuestaExistenciaPresupuesto=$preguntandoExistenciaResponsableCC->fetch_array(MYSQLI_ASSOC);
                                            
                                            
                                            if($respuestaExistenciaPresupuesto['id'] != NULL){
                                                
                                            }else{
                                                continue;
                                            }
                                        
                                        ?>
                                        <option value="<?php echo $columna['id']; ?>"><?php echo $columna['codigo'].'-'.$columna['nombre'];?> </option>
                                        <?php }  ?>      
                                    </select>
                                    <?php
                                    */
                                    ?>
                                    
                                    
                                </div>
                           
                        </div>  
                         <div class="form-group col-sm-6">
                             <label>Centro de trabajo para entrega:</label>
                            <select type="text" class="form-control"  name="centroTrabajo" placeholder="" required>
                                <option value=""></option>
                                <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $data = $mysqli->query("SELECT * FROM centrodetrabajo ORDER BY nombreCentrodeTrabajo ASC")or die(mysqli_error());
                                while($row = $data->fetch_assoc()){
                                ?>
                                <option value="<?php echo $row['id_centrodetrabajo'];?>"><?php echo $row['nombreCentrodeTrabajo'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                         <div class="form-group col-sm-6">
                           <label>Área o Proceso</label>
                           
                            <?php
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultadoProcesos=$mysqli->query("SELECT * FROM procesos ORDER BY nombre");
                            ?>
                            <select type="text" class="form-control" id="proceso" name="procesoS" placeholder="Proceso" required>
                                <option value='' required></option>
                                <?php
                                while ($columnaProcesos = mysqli_fetch_array( $resultadoProcesos )) {
                                    if($columnaProcesos['estado'] == 'Eliminado'){
                                        continue;
                                    }
                                ?>
                                <option value="<?php echo $columnaProcesos['id']; ?>"><?php echo $columnaProcesos['nombre']; ?> </option>
                                <?php }  ?>
                            </select>
                        </div>         
                       
                        <div class="form-group col-sm-6">
                            <label>Necesidad:</label>
                            <br>
                              Bienes
                                <input type="radio" value="B" name="tipoBien"  required> &nbsp&nbsp
                                Servicios
                                <input type="radio" value="S" name="tipoBien"  required>&nbsp&nbsp
                                Ambas
                                <input type="radio" value="A" name="tipoBien"  required>
                            
                        </div>
                         
                         <div class="form-group col-sm-6">
                            <label>Contrato:</label>
                            <br>
                            <textarea name="contrato" cols="40" rows="10" class="form-control" placeholder="Digite Contrato..." onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required></textarea>
                        </div> 
                        <div class="form-group col-sm-6">
                          
                            <label>Observaciones:</label>
                            <br>
                            <textarea name="observacion" ols="40" rows="10" class="form-control" placeholder="Observaciones..." onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required></textarea>
                        </div> 
                        <div class="form-group col-sm-6">
                         
                            <label>Tiempo de entrega (días):</label>
                            <br>
                            <input type="number" min="0" name="tiempo" class="form-control" placeholder="Tiempo de entrega..." required>
                        </div> 
                    
                          
                        </div>
                       
                   
                    <!--
                    Nuevo producto
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Si </label>
                            <input type="radio" name="nuevoProducto" id="rad_si" value="si" >
                            <label>No </label>
                            <input type="radio" name="nuevoProducto" id="rad_no" value="no" >
                        </div>
                    </div>-->
                   
                   
                   <!-- cuando el producto es nuevo abrimos esta vista -->
                   <div id="si" style="display:none;">
                           <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Grupo</label>
                                    <select type="text" class="form-control" name="grupo2" placeholder="" >
                                        <option value="">Seleccionar grupo...</option>
                                        <?php
                                        require 'conexion/bd.php';
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $data = $mysqli->query("SELECT * FROM proveedoresGrupo ORDER BY grupo ASC")or die(mysqli_error());
                                        while($row = $data->fetch_assoc()){
                                        ?>
                                        <option value="<?php echo $row['id'];?>"><?php echo $row['grupo'];?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Nombre del producto:</label>
                                    <input type="text" class="form-control" name="nombreProducto" placeholder="Nombre del producto" >
                                </div>                        
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Identificador</label>
                                    <input type="text" class="form-control" name="identificador" placeholder="Indicador" >
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Presentaci&oacute;n:</label>
                                    <input type="text" class="form-control" name="presentacion2" placeholder="Presentaci&oacute;n" >
                                </div>                        
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Cantidad</label>
                                    <input type="number" min="0" class="form-control"  name="cantidad2" placeholder="" >
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Nivel de urgencia:</label>
                                    <select type="text" class="form-control"  name="urgencia2" placeholder="" >
                                        <option value="">Seleccionar urgencia...</option>
                                        <?php
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $data = $mysqli->query("SELECT * FROM solicitudCompraUrgencia ORDER BY tipo ASC")or die(mysqli_error());
                                        while($row = $data->fetch_assoc()){
                                        ?>
                                        <option value="<?php echo $row['id'];?>"><?php echo $row['tipo'];?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>                        
                            </div> 
                    </div>
                    <!-- Fin al elegir el si -->
                   
                   <!-- cuando el producto no es nuevo abrimos esta vista -->
                   <div id="no" style="display:none;">
                           <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Grupo</label>
                                    <select type="text" class="form-control" id="cbx_grupo" name="grupo" placeholder="" >
                                        <option value="">Seleccionar grupo...</option>
                                        <?php
                                        require 'conexion/bd.php';
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $data = $mysqli->query("SELECT * FROM proveedoresGrupo ORDER BY grupo ASC")or die(mysqli_error());
                                        while($row = $data->fetch_assoc()){
                                        ?>
                                        <option value="<?php echo $row['id'];?>"><?php echo $row['grupo'];?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                               <!-- <div class="form-group col-sm-6">
                                    <label>Nombre del producto:</label>
                                    <select type="text" class="form-control" id="cbx_producto" name="nombreProducto" placeholder="" >
                                    </select>
                                </div>-->                        
                            </div>
                            
                            <div class="row">
                                <!--<div class="form-group col-sm-6">
                                    <label>Identificador</label>
                                    <select type="text" class="form-control" id="cbx_identificador" name="identificador" placeholder="" >
                                    </select>
                                </div>-->
                                <!--<div class="form-group col-sm-6">
                                    <label>Presentaci&oacute;n:</label>
                                    <select type="text" class="form-control"  name="presentacion" placeholder="" >
                                        <option value="">Seleccionar presentaci&oacute;n...</option>
                                        <?php
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $data = $mysqli->query("SELECT * FROM centroCostos ORDER BY nombre ASC")or die(mysqli_error());
                                        while($row = $data->fetch_assoc()){
                                        ?>
                                        <option value="<?php echo $row['id'];?>"><?php echo $row['nombre'];?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>-->                        
                            </div>
                            
                          <!--  <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Cantidad</label>
                                    <input type="number" min="0" class="form-control"  name="cantidad" placeholder="" >
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Nivel de urgencia:</label>
                                    <select type="text" class="form-control"  name="urgencia" placeholder="" >
                                        <option value="">Seleccionar urgencia...</option>
                                        <?php
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $data = $mysqli->query("SELECT * FROM solicitudCompraUrgencia ORDER BY tipo ASC")or die(mysqli_error());
                                        while($row = $data->fetch_assoc()){
                                        ?>
                                        <option value="<?php echo $row['id'];?>"><?php echo $row['tipo'];?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>                        
                            </div>-->
                    </div>
                    <!-- Fin al elegir el no -->
                    
                    
                   <!-- <div class="row">
                                <div class="form-group col-sm-6">
                                    <!--<input type="file" class="form-control"  name="archivo"  >
                                    <input type="file" class="form-control"  name="archivo2"  >
                                    <input type="file" class="form-control"  name="archivo3"  >
                                    <input type="file" class="form-control"  name="archivo4"  >
                                    <input type="file" class="form-control"  name="archivo5"  >-->
                      <!--              <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="archivo"  >
                                            <label class="custom-file-label" >Subir Archivo</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="archivo2"  >
                                            <label class="custom-file-label" >Subir Archivo</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="archivo3"  >
                                            <label class="custom-file-label" >Subir Archivo</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="archivo4"  >
                                            <label class="custom-file-label" >Subir Archivo</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="archivo5"  >
                                            <label class="custom-file-label" >Subir Archivo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                  
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
                  
                  <button type="submit" class="btn btn-primary float-right" name="AgregarSolicitud">Agregar</button>
                </div>
              </form>
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

<script>
        $(document).ready(function(){
            $('#rad_si').click(function(){
                
                document.getElementById('si').style.display = '';
                document.getElementById('no').style.display = 'none';
            });

            $('#rad_no').click(function(){
                document.getElementById('si').style.display = 'none';
                document.getElementById('no').style.display = '';
            });
        });
</script>
<script language="javascript">
                                        $(document).ready(function(){
                                            $("#cbx_grupo").change(function () {
                                                $("#cbx_grupo option:selected").each(function () {
                                                    id_producto = $(this).val();
                                                    $.post("controlador/solicitudCompra/javascript/producto.php", { id_producto: id_producto }, function(data){
                                                        $("#cbx_producto").html(data);
                                                    });            
                                                });
                                            })
                                        });
                                        $(document).ready(function(){
                                            $("#cbx_grupo").change(function () {
                                                $("#cbx_grupo option:selected").each(function () {
                                                    id_producto = $(this).val();
                                                    $.post("controlador/solicitudCompra/javascript/identificador.php", { id_producto: id_producto }, function(data){
                                                        $("#cbx_identificador").html(data);
                                                    });            
                                                });
                                            })
                                        });
</script>
   <!-- para mostrar el archivo seleccionado en el file -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>

 <script>
    const MAXIMO_TAMANIO_BYTES = 6000000; // 1MB = 1 millón de bytes

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
            title: ` El tamaño máximo del archivo es de 5 MB`
        })
		// Limpiar
		$miInput.value = "";
	} else {
		// Validación asada. Envía el formulario o haz lo que tengas que hacer
	}
});

</script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
    
    
<!-- END -->
</body>
</html>
<?php
}
?>