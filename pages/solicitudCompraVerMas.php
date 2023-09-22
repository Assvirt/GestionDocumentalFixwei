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
  <title>FIXWEI - Ver m&aacute;s</title>
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
            <h1>Ver solicitud de compra</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Ver solicitud de compra</li>
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
                            <?php
                            if($_POST['gestionar']!= NULL){
                            ?>
                            <form action="solicitudCompraGestionar" method="post">
                             <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                             <button type="submit" class="btn btn-block btn-success btn-sm"><font color="white"><i class="fas fa-list"></i> Regresar</font></button>
                            </form>   
                            <?php
                                }else{
                            if(isset($_POST['informacion'])){
                            ?>
                            <form action="registroProductos" method="post">
                                <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                                <button type="submit" class="btn btn-block btn-success btn-sm"><font color="white"><i class="fas fa-list"></i> Regresar</font></button>
                            </form>
                            <?php
                            }else{
                            ?>
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="solicitudCompra"><font color="white"><i class="fas fa-list"></i> Listar solicitud de compra</font></a></button>
                            <?php
                              }
                            }
                            ?>
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
            
             
                <div class="card-body">
                    
               
                    
                    <?php
                    if($_POST['idOrdenCompra'] != NULL){
                        $idSolicitudCompra=$_POST['idOrdenCompra'];
                    }else{
                        $idSolicitudCompra=$_POST['idSolicitudCompra'];
                    }
                    
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $data = $mysqli->query("SELECT * FROM solicitudCompra WHERE id='$idSolicitudCompra' ")or die(mysqli_error());
                    $datos = $data->fetch_array(MYSQLI_ASSOC);
                    $presupuesto=$datos['presupuesto'];
                    $centroCosto=$datos['centroCosto'];
                    $proceso=$datos['proceso'];
                    $fechaSolicitud=$datos['fechaSolicitud'];
                    $centroTrabajo=$datos['centroTrabajo'];
                    $quienRecibe=$datos['centroTrabajoEntrega'];
                    $tipoSolicitud=$datos['tipoCompra'];                    
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
                    $contrato=$datos['contrato'];
                    $observaciones=$datos['observacion'];
                    ?>
                    
                    
                    <div class="row">
                       <!-- <div class="form-group col-sm-6">
                           <!-- <label>Presupuesto</label>-->
                            <br>
                               
                                <?php
                                
                                require 'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $data = $mysqli->query("SELECT * FROM presupuesto WHERE id='$presupuesto' ")or die(mysqli_error());
                                while($row = $data->fetch_assoc()){
                                 echo $row['nombre'];
                                }
                                ?>
                          
                        <!--</div>-->
                        
                        <div class="form-group col-sm-6">
                              <div class="row">
                       <!-- <div class="form-group col-sm-6">
                            <label>Fecha estimada de entrega</label>
                            <br><?php //echo $fechaEstimada; ?>
                        </div>-->
                         <div class="form-group col-sm-6">
                            <label>Fecha Solicitud</label>
                            <br><?php echo $fechaSolicitud; ?>
                            <br>
                            <br>
                             <label>Tipo de Compra:</label> 
                            <br>
                            <?php
                                 $acentos = $mysqli->query("SET NAMES 'utf8'");
                                 $dataTipoSolicitud = $mysqli->query("SELECT * FROM solicitudCompraTipo WHERE id='$tipoSolicitud' ")or die(mysqli_error());
                                 while($row = $dataTipoSolicitud->fetch_assoc()){
                                 echo ''. $row['tipo'];
                                 echo $row['nombre'];
                                }
                                ?>
                                <br>
                            <br>
                             <label>Centro de Costos:</label>
                            <br>
                                   <?php
                                    $array = json_decode ($datos['centroCosto']);
                                    $longitud = count($array);
                                        for($i=0; $i<$longitud; $i++){
                                          
                                            $validacionCentroCostoExt = $mysqli->query("SELECT * FROM centroCostos WHERE id='$array[$i]' ");
                                            $columnaValidandoCentroCosto = $validacionCentroCostoExt->fetch_array(MYSQLI_ASSOC); 
                                            
                                        	echo "*".$columnaValidandoCentroCosto['nombre']."<br>";
                                        }
                                   ?>
                            <br>
                            </select>

                             <label>Necesidad:</label>
                             <br>
                             <?php
                                $data = $mysqli->query("SELECT * FROM solicitudCompra WHERE id='$idSolicitudCompra' ")or die(mysqli_error());
                                while ($columna = mysqli_fetch_array( $data )) { 
                                    if($columna['TipoBS']=='B'){
                                        echo 'Bien';
                                    }else{
                                     if($columna['TipoBS']=='S'){
                                        echo 'Servicio';
                                    }else{
                                        echo 'Bien';
                                        echo ' / ';
                                        echo 'Servicio';
                                    } 
                                }
                                }
                             ?>
                                            
                        </div>
                           <div class="form-group col-sm-6">
                        </div> 
                        </div> 
                         
                           
                    </div>    
                       
                        <div class="form-group col-sm-6">
                            <label>Dirección y Contacto de entrega</label>
                            <br><?php echo $contacto;?>
                            <br>
                              <br>
                                    
                            <label>Centro de trabajo para entrega:</label>
                            <br>
                            <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $data = $mysqli->query("SELECT * FROM centrodetrabajo WHERE id_centrodetrabajo = '$centroTrabajo' ")or die(mysqli_error());
                                while($row = $data->fetch_assoc()){
                                echo $row['nombreCentrodeTrabajo'];
                                }
                                ?>
                                <br>
                                <br>
                          <label>Área o Proceso:</label>
                            <br>
                                <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $data = $mysqli->query("SELECT * FROM procesos WHERE id = ' $proceso' ")or die(mysqli_error());
                                while($row = $data->fetch_assoc()){
                                 echo $row['nombre'];
                                }
                                ?>
                            </select>  
                        </div>  
                        
                        <div class="form-group col-sm-6">
                                <label> Contrato:</label>
                                    <br>
                                    <?php
                                    $ancho=120; 
                                    $cadena=$contrato;
                                    
                                    if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { 
                                      $eol="\r\n"; 
                                    }elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { 
                                      $eol="\r"; 
                                    } else { 
                                      $eol="\n"; 
                                    } 
                                    
                                    $cad=wordwrap($cadena, $ancho, $eol, 1); 
                                    $lineas=substr_count($cad,$eol)+1; 
                                    ?>
                                      <textarea name="contrato" class="form-control" cols="<?php echo $ancho; ?>" rows="<?php echo $lineas; ?>" readonly><?php echo $cadena; ?></textarea>
                                </div>
                                <br>
                        <div class="form-group col-sm-6">
                                <label>Observaciones:</label>
                                    <br>
                                    <?php
                                    $ancho2=120; 
                                    $cadena2=$observaciones;
                                    
                                    if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { 
                                      $eol2="\r\n"; 
                                    }elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { 
                                      $eol2="\r"; 
                                    } else { 
                                      $eol2="\n"; 
                                    } 
                                    
                                    $cad2=wordwrap($cadena2, $ancho2, $eol2, 1); 
                                    $lineas2=substr_count($cad2,$eol2)+1; 
                                    ?>
                                       <textarea name="observacion" class="form-control" placeholder="" cols="<?php echo $ancho2; ?>" rows="<?php echo $lineas2; ?>"  readonly><?php echo $cadena2; ?></textarea>
                                </div>
                                 
                                <div class="form-group col-sm-6">
                                   <br>
                                    <label>Tiempo de entrega:</label>
                                    <br>
                                    <?php echo $datos['tiempo'];?> días
                                </div> 
                                    
                              
                        </div>
                       
                       <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Comentarios</h3>
                         </div>
                          <div class="card-body">
                            <div class="tab-pane" id="timeline">
                                        <!-- The timeline -->
                                        <div class="timeline timeline-inverse">
                                          <!-- timeline time label -->
                                         
                                          <?php
                                           $consultaComentarios = $mysqli->query("SELECT * FROM solicitudCompraComentarios WHERE idSolicitud='$idSolicitudCompra'  ");

                                           while($extraerComentario = $consultaComentarios->fetch_assoc()){
                                                       
                                                      
                                                        
                                                        'Usuario-->'.$usuario=$extraerComentario['idUsuario'];
                                                        $rol=$extraerComentario['rol'];
                                                        $consultaUsuario = $mysqli->query("SELECT nombres,apellidos FROM usuario WHERE id = '$usuario'");
                                                        $extraerUsuario=$consultaUsuario->fetch_array(MYSQLI_ASSOC);
                                                        $usuarioComentario=$extraerUsuario['nombres'].' '.$extraerUsuario['apellidos'];
                                                      
                                                        ?>
                                                       
                                          <div class="time-label">
                                            <span class="bg-danger">
                                             <?php echo $extraerComentario['fecha'];?>
                                            </span>
                                          </div>

                                          <div>
                                            <i class="fas fa-user bg-info"></i>
                    
                                            <div class="timeline-item">
                                              
                                              <h3 class="timeline-header border-0"><b><?php echo ($rol).'  '?><a href="#"><?php echo $usuarioComentario;?></a><?php echo ' - '.ucwords($extraerComentario['estado']);?></b>  <?php echo $extraerComentario['comentario'];?>
                                              </h3>
                                            </div>
                                          </div>
                                        <?php } ?>
                                        </div>
                                     </div>
                          </div>
                        
                        </div>
                       
                       
                    </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              <button type="button" onclick="window.location='solicitudCompra'" class="btn btn-success float-right" name="Agregar">Regresar</button>
                          </div>
                          <!-- /.card-footer-->
                        </div>
                       
                   
                   
            </div>
                
            <div class="col">
             </div>
             
            </div>
             
        </div>    
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php // require_once'footer.php'; ?>

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

<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>   
</body>
</html>
<?php
}
?>