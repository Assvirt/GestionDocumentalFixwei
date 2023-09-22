<?php
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
  <title>FIXWEI - Editar Solicitud</title>
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
            <h1>Editar solicitud de compra</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Editar solicitud de compra</li>
            </ol>
          </div>
        </div>
        <div>
             <?php
                    $idSolicitudCompra=$_POST['idSolicitudCompra'];
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $data = $mysqli->query("SELECT * FROM solicitudCompra WHERE id='$idSolicitudCompra' ")or die(mysqli_error());
                    $datos = $data->fetch_array(MYSQLI_ASSOC);
                    $presupuesto=$datos['presupuesto'];
                    $centroCosto=$datos['centroCosto'];
                    $proceso=$datos['proceso'];
                    $fechaSolicitud=$datos['fechaSolicitud'];
                    $centroTrabajo=$datos['centroTrabajo'];
                    $quienRecibe=$datos['centroTrabajoEntrega'];
                    $tipoCompra=$datos['tipoCompra'];
                    $grupo=$datos['grupo'];
                    $nombreProducto=$datos['nombreProducto'];
                    $identificador=$datos['identificador'];
                    $presentacion=$datos['presentacion'];
                    $cantidad=$datos['cantidad'];
                    $urgencia=$datos['urgencia'];
                    $estado=$datos['estado'];
                    $rowUsuario=$datos['idUsuario'];
                    $contacto=$datos['contacto'];
                    $ruta=$datos['ruta'];
                    $ruta2=$datos['ruta2'];
                    $ruta3=$datos['ruta3'];
                    $ruta4=$datos['ruta4'];
                    $ruta5=$datos['ruta5'];
                    $contrato=utf8_encode($datos['contrato']);
                    $observaciones=$datos['observacion'];
                    $tipoSolicitud=$datos['tipoSolicitud'];
                   
                    ?>
                   
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col-sm-6">
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
              
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/solicitudCompra/controllerSolicitudCompra" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    
                <!-- parametros para la activacion de correo y plataforma -->
                    <div class="row"> 
                        <div class="form-group col-sm-6">
                          <input name="idUsuario" value="<?php echo $sesion;?>" type="hidden" readonly>
                          <?php    'Id:'.$idSolicitudCompra; ?>
                           <?php  '<br>'; ?>
                          <?php    'Fecha:'.$fechaSolicitud; ?>
                           <?php  '<br>'; ?>
                          <?php 
                          $dataCentroCostos = $mysqli->query("SELECT * FROM centroCostos WHERE id='$centroCosto' ")or die(mysqli_error());
                          while($row = $dataCentroCostos->fetch_assoc()){
                              'Centro de Costos:'. $row['nombre'];
                                 '<br>';
                                }                         ?>
                         
                          <?php  
                           $dataProcesos = $mysqli->query("SELECT * FROM procesos WHERE id='$proceso' ")or die(mysqli_error());
                           while($row = $dataProcesos->fetch_assoc()){
                              'Proceso:'. $row['nombre'];
                               '<br>';
                                }
                           ?>
                          <?php  
                           $dataCentroTrabajo = $mysqli->query("SELECT * FROM centrodetrabajo WHERE id_centrodetrabajo='$centroTrabajo' ")or die(mysqli_error());
                           while($row = $dataCentroTrabajo->fetch_assoc()){
                              'Centro Trabajo:'. $row['nombreCentrodeTrabajo'];
                               '<br>';
                                }
                           ?>
                         <?php  
                           $dataTipoSolicitud = $mysqli->query("SELECT * FROM solicitudCompraTipo WHERE id='$tipoCompra' ")or die(mysqli_error());
                           while($row = $dataTipoSolicitud->fetch_assoc()){
                              'Tipo Solicitud:'. $row['tipo'];
                               '<br>';
                                }
                           ?>
                        
                          <?php   'Contacto: '.$contacto; ?>
                           <?php  '<br>'; ?>
                          <?php   $fechaSolicitud; ?>
                           <?php  '<br>'; ?>
                          
                          <?php   'Contrato: '.$contrato; ?>
                           <?php  '<br>'; ?>
                          
                        </div>
                    </div>
                <!-- Fin parametros para la activacion de correo y plataforma -->
                    
                    <?php
                    $idSolicitudCompra=$_POST['idSolicitudCompra'];
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $data = $mysqli->query("SELECT * FROM solicitudCompra WHERE id='$idSolicitudCompra' ")or die(mysqli_error());
                    $datos = $data->fetch_array(MYSQLI_ASSOC);
                    $datos['tipoCompra'];
                    
     //echo 'Archivo:'.$archivopdf = $_POST['archivo'];
                    'Archivo:';
    
                     $archivoNombre = $_FILES['archivopdf']['name'];
                     $guardado = $_FILES['archivopdf']['tmp_name'];              
                    $ruta5=$datos['ruta5'];
                    ?>
                    <input value="<?php echo $idSolicitudCompra; ?>" name="id" type="hidden" readonly>
                    
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Fecha Solicitud</label>
                            <input type="date" class="form-control" name="fechaSolicitud" value="<?php echo $fechaSolicitud; ?>" required>
                           
                        </div>
                         <div class="form-group col-sm-6">
                            <label>Dirección y contacto de entrega:</label>
                            <input type="text" class="form-control" name="contacto" placeholder=" Direccion" value = "<?php echo $contacto;//$quienRecibe?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Tipo de solicitud:</label>
                           <select type="text" class="form-control"  name="tipoSolicitud" placeholder="" required>
                               
                                <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $data = $mysqli->query("SELECT * FROM solicitudCompraSolicitud WHERE id='$tipoSolicitud' ORDER BY tipo ASC")or die(mysqli_error());
                                while($row = $data->fetch_assoc()){
                                ?>
                                <option value="<?php echo $row['id'];?>"><?php echo $row['tipo'];?></option>
                                <?php
                                }
                                 $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $data = $mysqli->query("SELECT * FROM solicitudCompraSolicitud WHERE not id='$tipoSolicitud' ORDER BY tipo ASC")or die(mysqli_error());
                                while($row = $data->fetch_assoc()){
                                ?>
                                <option value="<?php echo $row['id'];?>"><?php echo $row['tipo'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Tipo de gasto:</label>
                               
                            <select type="text" class="form-control" id="descripcion" name="tipoCompra" placeholder="" required>
                              
                                <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $data = $mysqli->query("SELECT * FROM solicitudCompraTipo WHERE id='$tipoCompra' ORDER BY tipo")or die(mysqli_error());
                                while ($columna = mysqli_fetch_array( $data )) { 
                                ?>
                                <option value="<?php echo $columna['id']; ?>"><?php echo $columna['tipo']; ?> </option>
                                <?php }  
                             
                                $data = $mysqli->query("SELECT * FROM solicitudCompraTipo WHERE not id='$tipoCompra' ORDER BY tipo")or die(mysqli_error());
                                while ($columna = mysqli_fetch_array( $data )) { 
                                ?>
                                <option value="<?php echo $columna['id']; ?>"><?php echo $columna['tipo']; ?> </option>
                                <?php }  ?>
                               
                            </select>
                        </div>   
                        <div class="form-group col-sm-6">
                             <label>Centro de costos:</label>
                             <?php
                               
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT * FROM centroCostos "); ///// hacer inner join
                                $arrayCentroCosto = json_decode($datos['centroCosto']);
                            ?>
                          
                           
                                <div class="select2-blue">
                                    <select class="select2" multiple="multiple" data-placeholder="Seleccionar centro de costo" style="width: 100%;" name="centroCostoS[]" id="centroCostoS" required>
                                        <?php 
                                        $resultadoCT =$mysqli->query("SELECT * FROM presupuesto ORDER BY nombre ASC");
                                        while ($columna = mysqli_fetch_array( $resultadoCT )) { 
                                        
                                            //// validamos la existencia del presupuesto para el responsable del centro de costo
                                            $preguntandoExistenciaResponsableCC=$mysqli->query("SELECT * FROM centroCostos WHERE persona='".$columna['responsable']."' ");
                                            $respuestaExistenciaPresupuesto=$preguntandoExistenciaResponsableCC->fetch_array(MYSQLI_ASSOC);
                                            
                                            
                                            if($respuestaExistenciaPresupuesto['id'] != NULL){
                                                 if($arrayCentroCosto != NULL){ 
                                                    if(in_array($columna['id'],$arrayCentroCosto)){
                                                        $seleccionarCC= "selected";        
                                                    }else{
                                                        $seleccionarCC ="";
                                                    }
                                                  }
                                            }else{
                                                continue;
                                            }
                                        
                                        ?>
                                        <option value="<?php echo $respuestaExistenciaPresupuesto['id']; ?>"  <?php echo $seleccionarCC; ?> ><?php echo $respuestaExistenciaPresupuesto['codigo'].'-'.$respuestaExistenciaPresupuesto['nombre'];?> </option>
                                        <?php }  ?>      
                                    </select>
                                    <?php
                                    /*
                                    ?>
                                    <select class="select2" multiple="multiple" data-placeholder="Seleccionar centro de costo" style="width: 100%;" name="centroCostoS[]" id="centroCostoS" required>
                                       <?php
                                        while ($columna = mysqli_fetch_array( $resultado )) {
                                          if($arrayCentroCosto != NULL){ 
                                            if(in_array($columna['id'],$arrayCentroCosto)){
                                                $seleccionarCC= "selected";        
                                            }else{
                                                $seleccionarCC ="";
                                            }
                                          }
                                        ?>
                                        <option value="<?php echo $columna['id']; ?>" <?php echo $seleccionarCC; ?> ><?php echo $columna['nombre']; ?> </option>
                                    <?php }  ?>      
                                    </select>
                                    <?php
                                    */
                                    ?>
                                </div>
                            </div>
                            
                               
                          
                            
                                        
                 
                    
                        <div class="form-group col-sm-6">
                            <label>Centro de trabajo para entrega:  </label>
                                <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $data = $mysqli->query("SELECT * FROM centrodetrabajo ORDER BY nombreCentrodeTrabajo ")or die(mysqli_error());// WHERE id_centrodetrabajo='$centroTrabajo'
                                
                                ?>
                                <select type="text" class="form-control"  name="centroTrabajo" placeholder="" required>
                              
                                <?php
                                while($columna = mysqli_fetch_array($data)){
                                if($columna['id_centrodetrabajo'] == $centroTrabajo){    
                                     $selectTipo = "selected";
                                }else{
                                        $selectTipo = '';
                                    }
                                ?>    
                                 <option value="<?php echo $columna['id_centrodetrabajo'];?>"<?php echo $selectTipo;?>><?php echo $columna['nombreCentrodeTrabajo'];?></option>
                                <?php
                                }
                                ?>
                               
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Área o Proceso:</label>
                                <?php
                                
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $data = $mysqli->query("SELECT * FROM procesos ORDER BY nombre ")or die(mysqli_error());
                            ?>
                             <select type="text" class="form-control"  id="descripcion" name="procesoS" placeholder="" required>
                               
                                <?php
                                while ($columna = mysqli_fetch_array( $data )) { 
                                if($columna['id'] == $proceso){  
                                     $selectTipo = "selected";
                                    }else{
                                        $selectTipo = '';
                                    }
                               ?>
                                <option value="<?php echo $columna['id'];?>"<?php echo $selectTipo;?>><?php echo $columna['nombre'];?></option>
                                <?php
                                }
                                ?>
                               
                            </select>
                        </div>
                            <?php
                            $data = $mysqli->query("SELECT * FROM solicitudCompra WHERE id='$idSolicitudCompra' ")or die(mysqli_error());
                             while ($columna = mysqli_fetch_array( $data )) { 
                              if($columna['TipoBS']=='B'){
                                 $tipoBien='checked';
                             }else{
                             if($columna['TipoBS']=='S'){ 
                                $tipoServicio ='checked';
                              }else{
                               if($columna['TipoBS']=='A') 
                                $tipoAmbos ='checked';   
                              } 
                             }
                             }
                            ?>
                         <div class="form-group col-sm-6">
                            <label>Necesidad:</label>
                            <br>
                              Bienes
                                <input type="radio" value="B" name="tipoBien" <?php echo $tipoBien; ?> required> &nbsp
                                Servicios
                                <input type="radio" value="S" name="tipoBien" <?php echo $tipoServicio; ?> required>&nbsp
                                Ambos
                                <input type="radio" value="A" name="tipoBien" <?php echo $tipoAmbos; ?> required>
                            
                         </div>
                         
                        <div class="form-group col-sm-6">
                           <label>Contrato:</label>
                            <br>
                              <?php
                             $ancho=120; 
                            ?>
                            <textarea name="contrato" cols="40"  class="form-control" cols="<?php echo $ancho ; ?>" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)"><?php echo utf8_decode($contrato); ?></textarea>
                        </div> 
                         <div class="form-group col-sm-6">
                           
                            <label>Observaciones:</label>
                            <br>
                            <?php
                             $ancho=120; 
                            ?>
                             <textarea name="observacion" class="form-control" cols="<?php echo $ancho ; ?>" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)"><?php echo $observaciones;  ?></textarea>
                        </div>
                        <div class="form-group col-sm-6">
                          
                            <label>Tiempo de entrega (días):</label>
                            <br>
                            <input type="number" min="0" name="tiempo" value="<?php echo $datos['tiempo'];?>" class="form-control" placeholder="Tiempo de entrega..." required>
                        </div> 
                        
                        
                        </div>    
                     
                 
                
                </div>
                

                <div class="card-footer" >
                  
                  <button type="submit" class="btn btn-primary float-right" name="Actualizar">Actualizar</button>
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
   
</body>
</html>
<?php
}
?>