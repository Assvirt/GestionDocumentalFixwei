<?php error_reporting(E_ERROR);
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
  <title>FIXWEI - Agregar Indicadores</title>
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
            <h1>Agregar Metas y Zonas <?php  $quienCrea=$_POST['quienCrea'];?></h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Agregar Metas y Zonas </li>
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
               
                <div class="card card-primary">
                  <div class="card-header">
                    <?php
                    $variablesIdPrincipal=$_POST['variablesIdPrincipal'];
                   
                                /// se trae el último indicador que realizo el usuario
                                $quienCrea;
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $ultimoIndicado=$mysqli->query("SELECT * FROM `indicadores` WHERE id='$variablesIdPrincipal'  ");
                                $extraeDatoIndicador= $ultimoIndicado->fetch_array(MYSQLI_ASSOC);
                                $ultimoIndicadorSale=$extraeDatoIndicador['id'];
                                $ultimoIndicadorSaleQuienCrea=$extraeDatoIndicador['quienCrea'];
                                $nombreIndicador=$extraeDatoIndicador['nombre'];
                                $sentido=$extraeDatoIndicador['sentido'];
                                ?>
                    <h3 class="card-title"><b><?php// echo $nombreIndicador; ?></b></h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <?php
                  if(isset($_POST['AplicarMeta'])){
                      
                  }else{
                  ?>
                  <div class="card-body">
                        
                        <label>¿Desea manejar un indicador con metas?</label><br>
                                    Si
                                    <input type="radio" id="habilitarSI"  name="metasValidar" value="Si" required>
                                    No
                                    <input type="radio" id="habilitarNO"  name="metasValidar" value="No" required>
                                     <br><br>
                  </div>
                  
                  
                    
                    <div class="card-body" style="display:none;" id="nmostrarBotonGuardar">
                    <form role="form" action="controlador/indicadores/controller" method="POST" enctype="multipart/form-data"> 
                    <input name="variablesIdPrincipal" type="hidden" readonly value="<?php echo $ultimoIndicadorSale; ?>">
                    <input name="quienCrea" value="<?php echo $quienCrea;?>" type="hidden" readonly>
                    <input type="hidden" name="metasValidar" value="No" required>
                          <div class="form-group col-sm-6" >
                                    <input name="variablesIdPrincipal" type="hidden" readonly value="<?php echo $ultimoIndicadorSale; ?>">
                                    <button type="submit" style="color:white;" class="btn btn-warning float-left" name="AgregarZonasB">Guardar</button>
                          </div>
                     </form>
                    </div>      
                   
                    
                  <form role="form" action="" method="POST" enctype="multipart/form-data">
                      
                     
                    <div style="display:none;" id="abrirMetas" class="card-body">
                        
                         <input type="hidden" id="habilitarSI"  name="metasValidar" value="Si" required>
                          <div class="row">
                              <div class="form-group col-sm-6">
                                    <label>Unidad de medida:</label>
                                    <!--<input type="text" class="form-control" name="unidadValidar" placeholder="Unidad de medida" required>-->
                                     <select type="text" class="form-control" name="unidadValidar" placeholder="Unidad de medida" required>
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
                                
                                <div class="form-group col-sm-6">
                                    <label>Meta actual:</label>
                                    <input type="number" class="form-control" name="metaActualValidar" id="metaActual" placeholder="Meta actual" required>
                                    </div>
                                <div class="form-group col-sm-6">
                                    <label>Desde:</label>
                                    <input type="date" class="form-control" name="desdeValidar" placeholder="Desde" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Hasta:</label>
                                    <input type="date" class="form-control" name="hastaValidar" placeholder="Hasta" required>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <input name="variablesIdPrincipal" type="hidden" readonly value="<?php echo $ultimoIndicadorSale; ?>">
                                    <button type="submit" style="color:white;" class="btn btn-success float-left" name="AplicarMeta">Aplicar Meta</button>
                                </div>
                                
                                <input name="quienCrea" value="<?php echo $quienCrea;?>" type="hidden" readonly>
                          </div>
                       
                    </div>
                <!-- /.card-body -->
                </form>
                 <!-- validacion para abrir el script de si necesita una meta o no necesita una meta -->  
                        <script>
                            $(document).ready(function(){
                                $('#habilitarSI').click(function(){
                                    document.getElementById('abrirMetas').style.display = '';
                                    document.getElementById('nmostrarBotonGuardar').style.display = 'none';
                                });
                                $('#habilitarNO').click(function(){
                                     document.getElementById('abrirMetas').style.display = 'none';
                                     document.getElementById('nmostrarBotonGuardar').style.display = '';
                                });
                            });
                        </script>
                        <!--  end  -->
                  <?php
                  }
                  ?>
            
            <!-- despues de aplicar la meta para la validación de la grafica, este debe conservar todos los campos llenados hasta el momento -->
            <?php
            
            if($metasValidar=$_POST['metasValidar'] == 'Si'){
                $checkedSi='checked';
            }else{
                $checkedNo='checked';
            }
            $unidadValidar=$_POST['unidadValidar'];
            $metaActualValidar=$_POST['metaActualValidar'];
            $desdeValidar=$_POST['desdeValidar'];
            $hastaValidar=$_POST['hastaValidar'];
            
            if(isset($_POST['AplicarMeta'])){
            ?>
               
            <form role="form" action="controlador/indicadores/controller" method="POST" enctype="multipart/form-data">
                      
                     
                    <div class="card-body">
                        
                        <!-- parametros para la activacion de correo y plataforma -->
                            <div class="row"> 
                                <div class="form-group col-sm-6">
                                    
                                    
                                  <input name="quienCrea" value="<?php echo $quienCrea;?>" type="hidden" readonly>
                                  <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal;?>" type="hidden" readonly>
                                  
                                  
                                  
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
                           
                          <div class="row">
                              <div class="form-group col-sm-6">
                                    <label>¿Desea manejar un indicador con metas?</label><br>
                                    Si
                                    <input type="radio" class=""  name="metas" value="Si" <?php echo $checkedSi; ?> required>
                                    No
                                    <input type="radio" class=""  name="metas" value="No" <?php echo $checkedNo; ?> required>
                                     <br><br>
                                    
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
                                                 $unidadMedida=$mysqli->query("SELECT * FROM indicadoresUnidad WHERE not unidad='$unidadValidar' ORDER BY unidad");
                                                 while($datoUnidad=$unidadMedida->fetch_array()){
                                                 ?>
                                                 <option value="<?php echo $datoUnidad['unidad']; ?>"><?php echo $datoUnidad['unidad']; ?></option>
                                                <?php
                                                 }
                                                ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label><font color="white">------</font></label><br>
                                    <input type="radio" style="visibility:hidden;" >
                                    <input type="radio" style="visibility:hidden;" >
                                     <br><br>
                                    <label>Meta actual:</label>
                                    <input type="number" min="1" class="form-control" name="metaActual" value="<?php echo $metaActualValidar; ?>" placeholder="Meta actual" required>
                                    </div>
                                <div class="form-group col-sm-6">
                                    <label>Desde:</label>
                                    <input type="date" class="form-control" name="desde" placeholder="Desde" value="<?php echo $desdeValidar; ?>" required>
                                </div>
                                <div class="form-group col-sm-6">
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
                                    $max=$metaActualValidar-1;
                                    $max2=$metaActualValidar+1;
                                ?>
                                    <input name="zp" class="bindicador" placeholder="Zona de Peligro" style="text-align:center;border-color:red;background:red;color:white;border:0px;width: 20%;" type="number" min="1" max="<?php echo $max; ?>" required>
                                    <input name="za" class="nindicador" placeholder="Zona de alerta" style="text-align:center;border-color:yellow;background:yellow;color:black;border:0px;width: 20%;" type="number" min="1" max="<?php echo $max; ?>" required>
                                    <input name="zc" class="nindicador" value="<?php echo $metaActualValidar; ?>" placeholder="Zona de Cumplimiento" style="text-align:center;border-color:green;background:green;color:black;border:0px;width: 20%;" type="number" min="<?php echo $metaActualValidar; ?>" max="<?php echo $metaActualValidar; ?>" required>
                                    <input name="ze" class="bindicador" placeholder="Zona de Exceso" style="text-align:center;border-color:blue;background:blue;color:white;border:0px;width: 20%;" type="number" min="<?php echo $max2; ?>" required>
                                <?php
                                }
                                
                                
                                ////// si el indicador viene negativo tiene este orden
                                if($sentido == 'Negativo'){
                                $min=$metaActualValidar+1;
                                $min2=$metaActualValidar-1;
                                ?>
                                <input name="ze" class="bindicador" placeholder="Zona de Exceso" style="text-align:center;border-color:blue;background:blue;color:white;border:0px;width: 20%;" type="number" min="-100" max="<?php echo $min2; ?>" required>
                                <input name="zc" class="nindicador" value="<?php echo $metaActualValidar; ?>" placeholder="Zona de Cumplimiento" style="text-align:center;border-color:green;background:green;color:black;border:0px;width: 20%;" type="number" min="<?php echo $metaActualValidar; ?>" max="<?php echo $metaActualValidar; ?>" required>
                                <input name="za" class="nindicador" placeholder="Zona de alerta" style="text-align:center;border-color:yellow;background:yellow;color:black;border:0px;width: 20%;" type="number" min="<?php echo $min; ?>" required>
                                <input name="zp" class="bindicador" placeholder="Zona de Peligro" style="text-align:center;border-color:red;background:red;color:white;border:0px;width: 20%;" type="number" min="<?php echo $min; ?>" required>
                                <?php
                                }
                                ?>
                                </div>
                                <div class="form-group col-sm-6">
                                    <input name="variablesIdPrincipal" type="hidden" readonly value="<?php echo $ultimoIndicadorSale; ?>">
                                    <button type="submit" style="color:white;" class="btn btn-warning float-left" name="AgregarZonas">Guardar</button>
                                </div>
                                
                                
                               
                          </div>
                          
                    </div>
                <!-- /.card-body -->
                </form>
            
            <?php
            }
            ?>    
                <!-- despues de aplicar la meta para la validación de la grafica, este debe conservar todos los campos llenados hasta el momento -->
                </div>
            </div>    
            <div class="col">
                    
            </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
   
   <?php /*?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                </div>
                <div class="col-9">
                    <div name="ocultarMostrar" id="ocultarMostrar">
                        <input type="button" class="btn btn-primary" value="Ver historial de metas" id="rad_mostrar" name="radiobtn" value="mostrar">
                    </div>      
                    
                    <div name="ocultar" id="ocultar" style="display:none;">
                        <input type="button" class="btn btn-success" value="Ocultar historial de metas" id="rad_ocultar" name="radiobtn" value="ocultar">
                    </div>
                     <!--       
                    <form action="" method="POST">
                        <input name="calculadoraMetas" type="hidden" readonly value="TRUE">
                        <input type="hidden" name="quienCrea" value= "<?php //echo $quienCrea; ?>" >
                        <input name="variablesIdPrincipal" type="hidden" readonly value="<?php //echo $ultimoIndicadorSale; ?>">
                        <input value="Ver historial de metas" class="btn btn-primary" type="submit">
                    </form> -->
                </div>
                <div class="col">
                </div>
            </div>
        </div>
    </section>
    
    
    <div name="mostrar" id="mostrar" style="display:none;"> <!-- muestra el historial con el script  -->
        <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
                    
            </div>
            <div class="col-9">
               
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Historial de Metas </h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                 
                            <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $ultimoIndicadoMetas=$mysqli->query("SELECT * FROM `indicadoresMetas` WHERE idIndicador='$ultimoIndicadorSale' AND quienCrea='$quienCrea' ORDER BY metaActual ASC ");
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
                                    <input class="form-control" value="<?php echo $extraeDatoIndicadorMetas['metaActual']; ?>" readonly>
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
                                    <input name="zp" value="<?php echo $extraeDatoIndicadorMetas['zp']; ?>" readonly id="bindicador" style="text-align:center;border-color:red;background:red;color:white;border:0px;width: 20%;">
                                    <input name="za" value="<?php echo $extraeDatoIndicadorMetas['za']; ?>" readonly id="nindicador" style="text-align:center;border-color:yellow;background:yellow;color:black;border:0px;width: 20%;">
                                    <input name="zc" value="<?php echo $extraeDatoIndicadorMetas['zc']; ?>" readonly id="nindicador" style="text-align:center;border-color:green;background:green;color:black;border:0px;width: 20%;">
                                    <input name="ze" value="<?php echo $extraeDatoIndicadorMetas['ze']; ?>" readonly id="bindicador" style="text-align:center;border-color:blue;background:blue;color:white;border:0px;width: 20%;">
                                </div>
                          </div>
                          
                    </div>
                <!-- /.card-body -->
               
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
    </div>
    
    */ ?>
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
<script type="text/javascript">
	function ConfirmDelete(){
		var answer = confirm("Está seguro de eliminar?");

		if(answer == true){
			return true;
		}else{
			return false;
		}
	}
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
            title: ' La meta ya existe.'
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