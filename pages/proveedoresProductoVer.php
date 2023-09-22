<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

///////// notificaciones para plataforma y correo
require_once 'conexion/bd.php';

$formulario = 'proveedores'; //Se cambia el nombre del formulario

require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Ver Productos del Proveedor</title>
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
            <h1>Ver Productos del Proveedor</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Ver productos del proveedor</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <div class="col">
                <?php
                $idProveedor=$_POST['idProveedor'];
                ?>    
                </div>
                 <div class="col-9">
                    <div class="row">
                        <div class="col-sm-3">
                            <form action="proveedorProductos" method="POST">
                            <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                            <button type="submit" class="btn btn-block btn-info btn-sm"><a href="#"><font color="white"><i class="fas fa-list"></i> Listar productos</font></a></button>
                            </form>
                        </div>
                        
                        <?php
                        if($_POST['validacionAgregar'] != NULL){
                        ?>
                        <div class="col-sm">
                            <form action="agregarProveedorProductoArchivos" method="POST">
                            <input name="validacionAgregar" value="<?php echo $_POST['validacionAgregar']; ?>" type="hidden">    
                            <button type="submit" class="btn btn-block btn-success btn-sm"><font color="white"><i class="fas fa-list"></i> Documentos</font></button>
                            </form>
                        </div>
                        <?php
                        }else{
                        ?>
                        <div class="col-sm">
                            <form action="agregarProveedorProductoArchivos" method="POST">
                            <input name="validacionAgregar" value="<?php echo $_POST['idProveedorProducto']; ?>" type="hidden">    
                            <button type="submit" class="btn btn-block btn-success btn-sm"><font color="white"><i class="fas fa-list"></i> Documentos</font></button>
                            </form>
                        </div>
                        <?php
                        }
                        ?>
                        <div class="col-sm">
                        </div>
                        <div class="col-sm">
                           <!-- <button type="button" class="btn btn-block btn-success btn-sm"><a href="proveedores"><font color="white"><i class="fas fa-list"></i> Vista PPAL</font></a></button>-->
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
             
                <div class="card-body">
                <?php
                    $idProveedor=$_POST['idProveedor'];
                   
                    if($_POST['validacionAgregar'] != NULL){
                    $idProveedorProducto=$_POST['validacionAgregar'];
                    }else{
                    $idProveedorProducto=$_POST['idProveedorProducto'];    
                    }
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $query = $mysqli->query("SELECT * FROM proveedorProductos WHERE id= '$idProveedorProducto'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $idSolicitante = $row['id'];
                    $nombre = $row['nombre'];
                    $descripcion = $row['descripcion'];
                    $identificador = $row['identificador'];
                    $codigo = $row['codigo'];
                 
                    $costo = $row['costo'];
                    $fecha = $row['fechaExpedicion'];
                    $presentacion = $row['presentacion'];
                    $presentacionb = $row['presentacionb'];
                    $impuesto = $row['impuesto'];
                    $foto = $row['imagen'];
                    
                    $tiempoServicio=$row['tiempoServicio'];
                    $cantidadTiempoServicio=$row['cantidadTiempoServicio'];
                    
                    
                    /// traemos los datos faltantes
                    $opcion = $row['tipoProducto'];
                    if($opcion == 1){
                        $nombreTipo='Bienes';
                        $nombretítulo='bien';
                        $nombreUnidad='empaque';
                    }else{
                        $nombreTipo='Servicios';
                        $nombretítulo='servicio';
                        $nombreUnidad='medida';
                    }
                    
                    /// END
                    
                    
                ?>    
                <!-- parametros para la activacion de correo y plataforma -->
                    <div class="row"> 
                        <div class="form-group col-sm-6">
                          <input name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden" readonly>
                              <?php if($visibleP != 'none'){ ?>
                              
                                    <input style="border:0px;" name="plataforma" value="1" type="hidden" readonly>
                                <?php }else{  }
                          
                              if($visibleP != 'none' && $visibleC != 'none'){
                          //        echo '-';
                              }
                          
                                    if($visibleC != 'none'){ ?>
                                    <input style="border:0px;" name="correo" value="1" type="hidden" readonly>
                                <?php }else{  } ?>
                        </div>
                    </div>
                <!-- Fin parametros para la activacion de correo y plataforma -->
                    
                    <div class="row">
                      
                        <div class="form-group col-sm-6">
                            <label>Tipo:</label>
                            <?php echo $nombreTipo; ?>
                            <br>
                            <br>
                            <label>Nombre del <?php echo $nombretítulo;?>:</label>
                            <?php echo $nombre; ?>
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label>Descripci&oacute;n del bien o servicio:</label>
                            <?php echo $descripcion; ?>
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="form-group col-sm-6">
                            <label>Grupo:</label>
                            <?php
                            $grupo=$row['grupo'];
                            $unidadMedida=$mysqli->query("SELECT * FROM proveedoresProductoGrupo WHERE id='$grupo' ORDER BY grupo ");
                                    while($extraerMedida=$unidadMedida->fetch_array()){
                                        /// consultamos los datos del subGrupo
                                        $consultaSubGrupo=$mysqli->query("SELECT * FROM proveedoresProductoSubGrupo WHERE id='".$extraerMedida['sub']."' ");
                                        $extraerSubGrupo=$consultaSubGrupo->fetch_array(MYSQLI_ASSOC);
                                    
                                     echo $extraerMedida['grupo'].' - '.$extraerSubGrupo['grupo'];//.$row['codigoG'];
                                     echo '   ('.$extraerMedida['descripcion'].' - '.$extraerSubGrupo['descripcion'].')';
                                    
                                        
                                    }
                                    
                            ?>
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label>Código:</label>
                            <?php echo $codigo; ?>
                        </div>
                        
                       
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Identificador:</label>
                            <?php 
                             
                                    $unidadIdentificador=$mysqli->query("SELECT * FROM proveedoresProductoIdentificador WHERE id='$identificador' ORDER BY grupo ");
                                    $extraerIdentificador=$unidadIdentificador->fetch_array();
                                    echo $extraerIdentificador['grupo'];
                            ?>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Impuesto:</label>
                                <?php
                                
                                if($impuesto == 'N/A'){
                                    echo $impuesto;
                                }else{
                                    $consultaImpuestos=$mysqli->query("SELECT * FROM proveedoresTipoImpuesto WHERE id='$impuesto' ORDER BY grupo");
                                    while($extraerConsultaImpuestos=$consultaImpuestos->fetch_array()){
                                        echo $extraerConsultaImpuestos['grupo'].' '.$extraerConsultaImpuestos['descripcion'].' %';
                                    }
                                }
                                ?>
                        </div> 
                        
                    </div>
                    
                    <?php
                    if($opcion == '1'){
                    ?>
                    <div class="row">
                       
                        <div class="form-group col-sm-6">
                            
                            <?php
                            //if($opcion == '1'){
                                echo '<label>Unidad de empaque</label>: ';
                                    $unidadMedida=$mysqli->query("SELECT * FROM proveedoresProductoEmpaque WHERE id='".$row['presentacion']."' ORDER BY grupo ");
                                    while($extraerMedida=$unidadMedida->fetch_array()){
                                     echo $extraerMedida['grupo'].' - '.$extraerMedida['descripcion'];
                                    }
                                    
                            //}else{
                                 /*echo '<label>Unidad de medida</label>: ';
                                    $unidadMedida=$mysqli->query("SELECT * FROM proveedoresProductoMedida WHERE id='".$row['presentacion']."' ORDER BY grupo ");
                                    while($extraerMedida=$unidadMedida->fetch_array()){
                                     echo $extraerMedida['grupo'].' - '.$extraerMedida['descripcion'];
                                    }*/
                            //}
                            ?>
                        </div>
                        <div class="form-group col-sm-6">
                            
                            <?php
                                 echo '<label>Unidad de medida</label>: ';
                                    $unidadMedida=$mysqli->query("SELECT * FROM proveedoresProductoMedida WHERE id='".$presentacionb."' ORDER BY grupo ");
                                    while($extraerMedida=$unidadMedida->fetch_array()){
                                     echo $extraerMedida['grupo'].' - '.$extraerMedida['descripcion'];
                                    }
                            ?>
                        </div>
                    </div>
                    <?php
                    }
                    
                    if($opcion == '1'){
                    ?>
                    <div class="row">
                         <div class="form-group col-sm-6">
                             <label>Inventario:</label>
                             <?php echo $row['inventario'];?>
                         </div>
                         
                    </div>
                    <?php
                    }
                    
                    
                    if($opcion == '1'){
                    ?>
                    <div class="row">
                         <div class="form-group col-sm-6">
                             <label>Activo:</label>
                              <?php echo $row['activo'];?>
                         </div>
                    </div>
                    <?php
                    }
                    ?>
                    
                    <?php
                    if($opcion == '2'){
                    ?>
                    <div class="row">
                        <div class="form-group col-sm-6">
                             <label>Proveedor sugerido:</label>
                             <?php
                            
                                    $consultandoProeedores=$mysqli->query("SELECT * FROM proveedores WHERE id='". $row['proveedor']."' ORDER BY razonSocial ");
                                    while($extraerconsultaProve=$consultandoProeedores->fetch_array()){
                                     echo $extraerconsultaProve['razonSocial']; 
                                    }
                             ?>
                        </div>
                            <div class="form-group col-sm-6">
                                <label>Tiempo de servicio:</label>
                                
                                <?php
                                $buscaTiempo=$mysqli->query("SELECT * FROM proveedoresProductoTiempo WHERE id='".$tiempoServicio."' ORDER BY id ");
                                $extraerDatos=$buscaTiempo->fetch_array(MYSQLI_ASSOC);
                                if($cantidadTiempoServicio > 1 && strtolower($extraerDatos['grupo']) == 'año'){
                                    echo $cantidadTiempoServicio.' '.strtolower($extraerDatos['grupo'].'s');
                                }elseif($cantidadTiempoServicio == 1 && strtolower($extraerDatos['grupo']) == 'años'){
                                    echo $cantidadTiempoServicio.' año';
                                }elseif($cantidadTiempoServicio > 1 && strtolower($extraerDatos['grupo']) == 'mes'){
                                    echo $cantidadTiempoServicio.' '.strtolower($extraerDatos['grupo'].'es');
                                }elseif($cantidadTiempoServicio > 1 && strtolower($extraerDatos['grupo']) == 'meses'){
                                    echo $cantidadTiempoServicio.' mes';
                                }elseif($cantidadTiempoServicio > 1 && strtolower($extraerDatos['grupo']) == 'día'){
                                    echo $cantidadTiempoServicio.' '.strtolower($extraerDatos['grupo'].'s');
                                }elseif($cantidadTiempoServicio == 1 && strtolower($extraerDatos['grupo']) == 'días'){
                                    echo $cantidadTiempoServicio.' día';
                                }else{
                                    echo $cantidadTiempoServicio.' '.strtolower($extraerDatos['grupo']);
                                }
                                ?>
                            </div>
                    </div>
                    <?php
                    }
                    ?>
                    
                    
                    
                    
                    <div class="row">
                        <!--
                        <div class="form-group col-sm-6">
                            <label>Impuesto:</label>
                            <?php //echo $impuesto; ?> %
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Imagen:</label>
                            <img class="img-circle elevation-2" src="data:image/jpg;base64, <?php //echo base64_encode($foto); ?>" width="200" height="200">
                            
                        </div> 
                        -->
                        <div class="form-group col-sm-6">
                            <label>Documentos:</label>
                            <table class="table table-head-fixed text-center">
                              <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                              </thead>
                              <tbody>
                               <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                if($_POST['validacionAgregar'] != NULL){
                                    $consultandoProducto=$_POST['validacionAgregar'];
                                }else{
                                    $consultandoProducto=$_POST['idProveedorProducto'];
                                }
                                $data = $mysqli->query("SELECT * FROM proveedorProductosDocumentos WHERE idProducto ='".$consultandoProducto."' ORDER BY id ASC")or die(mysqli_error());
                                $conteo=1;
                                while($row = $data->fetch_assoc()){
                                   $id = $row['id'];
                                echo"<tr>";
                                echo "<td>".substr($row['file_name'],1)."</td>";
                                $ruta='almacenamientoMultipleProductos/uploads/'.$row['file_name'];
                                echo"<td>
                                      <button  type='button'  class='btn btn-block btn-warning btn-sm'>
                                        <i class='fas fa-download'></i>
                                        <a style='color:black' href='$ruta' download='' target='_blank'>Descargar</a>
                                      </button>
                                    </td>";
                                    ?>
                                    <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $id;?>' >
                                    <td style='display:<?php echo $visibleD;?>'><a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                                    <script>
                                        function funcionFormula<?php echo $contador2++;?>() {
                                              /*alert("entre");*/
                                            document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                                          }
                                    </script>
                                    <?php
                                echo "</tr>"; 
                                }     
                               ?>
                               </tbody>
                            </table>
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
                                    <form action='almacenamientoMultipleProductos/file_upload' method='POST'>
                                       <input name="validacionAgregar" value="<?php echo $consultandoProducto; ?>" type="hidden">
                                       <!--<input name="" value="" type="hidden" readonly>
                                       <input name="" value="" type="hidden" readonly>-->
                                    <div class="modal-footer justify-content-between">
                                      <input type="hidden" id="capturarFormula" name='id' readonly>
                                      <button type="submit" name='Eliminar' class="btn btn-outline-light">Si</button>
                                      <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                                    </div>
                                     </form>
                                     <!-- END formulario para eliminar por el id -->
                                  </div>
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

    <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<?php
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