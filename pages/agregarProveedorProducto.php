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
  <title>FIXWEI - Agregar Productos del Proveedor</title>
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
            <h1>Agregar Productos del Proveedor</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Agregar productos del proveedor</li>
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
                         <div class="col-sm-3">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarUnidadEmpaque"><font color="white"><i class="fas fa-plus-square"></i> Unidad de empaque</font></a></button>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarUnidadMedida"><font color="white"><i class="fas fa-plus-square"></i> Unidad de  medida</font></a></button>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarUnidadTiempo"><font color="white"><i class="fas fa-plus-square"></i> Tiempo de servicio</font></a></button>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarUnidadIdentificador"><font color="white"><i class="fas fa-plus-square"></i> Identificador</font></a></button>
                        </div>
                        
                    </div>
                    
                </div>
                <div class="col">
                    
                </div>
                <!--<form role="form" action="controlador/proveedor/controllerProductoGrupo" method="POST">-->
               
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
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/proveedor/controllerProducto" method="POST" enctype="multipart/form-data"> <!--  -->
                <div class="card-body">
                    
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
                    
                    <b><label>Tipo:</label></b> 
                    <div class="row">
                        <div class="container">
                            Bienes <input name="opcion" value="1" type="radio" id="bienes" required>&nbsp;
                            Servicios <input name="opcion" value="2" type="radio" id="servicios" required>
                        </div>
                    </div>
                    
                    <br>
                    
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label id="nombreF">Nombre del bien o servicio:</label>
                            <label id="nombreS" style="display:none;">Nombre del bien o servicio:</label>
                            <input type="text" class="form-control"  name="nombre" placeholder="Nombre" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Descripci&oacute;n del bien o servicio:</label>
                            <textarea type="text" class="form-control"  name="descripcion" placeholder="Descripci&oacute;n del bien o servicio" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)"></textarea>
                        </div>
                        
                    </div>
                    <div class="row">
                        <?php $conteo=1; ?>    
                        <!-- Aqui pasar el grupo-->
                        <div class="form-group col-sm-6">
                                <label>Grupo y Subgrupo:</label>
                                <select type="text" class="form-control"  name="grupo" required>
                                    <option value="">Seleccionar Grupo y subgrupo</option>
                                    <?php
                                    
                                     
                         
                                    
                                    $conteo = 1;
                                    $length = 2;
                                    $string = substr(str_repeat(0, $length).$number, - $length);
                                    $unidadMedida=$mysqli->query("SELECT * FROM proveedoresProductoGrupo ORDER BY grupo ");
                                    while($extraerMedida=$unidadMedida->fetch_array()){
                                        /// consultamos los datos del subGrupo
                                        $consultaSubGrupo=$mysqli->query("SELECT * FROM proveedoresProductoSubGrupo WHERE id='".$extraerMedida['sub']."' ");
                                        $extraerSubGrupo=$consultaSubGrupo->fetch_array(MYSQLI_ASSOC);
                                    ?>
                                    <option value="<?php echo $extraerMedida['id'];?>"><?php echo 'Identificador ('.$extraerMedida['id'].') '.$extraerMedida['grupo'].' - '.$extraerMedida[''].' '.$extraerSubGrupo['grupo'].''.$extraerSubGrupo[''];?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        <div class="form-group col-sm-6">
                            <label>Código:</label>
                            <input required type="text" class="form-control"  name="codigo" placeholder="Código" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Identificador:</label>
                            <!--
                            <input required type="text" class="form-control"  name="identificador" placeholder="Identificador" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                            -->
                                <select type="text" class="form-control"  name="identificador" required>
                                    <option value="">Seleccionar identificador</option>
                                    <?php
                                    $unidadIdentificador=$mysqli->query("SELECT * FROM proveedoresProductoIdentificador ORDER BY grupo ");
                                    while($extraerIdentificador=$unidadIdentificador->fetch_array()){
                                        
                                    ?>
                                    <option value="<?php echo $extraerIdentificador['id'];?>"><?php echo $extraerIdentificador['grupo'];?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Impuesto:</label>
                            <select type="number" min="0" class="form-control"  name="impuesto" required>
                                <option value="N/A">N/A</option>
                                <?php
                                $consultaImpuestos=$mysqli->query("SELECT * FROM proveedoresTipoImpuesto ORDER BY grupo");
                                while($extraerConsultaImpuestos=$consultaImpuestos->fetch_array()){
                                ?>
                                <option value="<?php echo $extraerConsultaImpuestos['id']; ?>" title="<?php echo $extraerConsultaImpuestos['des']; ?>"><?php echo $extraerConsultaImpuestos['grupo'].' '.$extraerConsultaImpuestos['descripcion'].' %'; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>  
                    </div>
                    
                    <div id="bienesF" style="display:none;">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Unidad de empaque:</label>
                                <select type="text" class="form-control"  name="presentaciona" >
                                    <option value="">Seleccionar Unidad</option>
                                    <?php
                                    $unidadMedida=$mysqli->query("SELECT * FROM proveedoresProductoEmpaque ORDER BY grupo ");
                                    while($extraerMedida=$unidadMedida->fetch_array()){
                                    ?>
                                    <option value="<?php echo $extraerMedida['id'];?>"><?php echo $extraerMedida['grupo'].' - '.$extraerMedida['descripcion'];?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                             <div class="form-group col-sm-6">
                                <label>Unidad de medida:</label>
                                <select type="text" class="form-control"  name="presentacionb" >
                                    <option value="">Seleccionar unidad de medida</option>
                                    <?php
                                    $unidadMedida=$mysqli->query("SELECT * FROM proveedoresProductoMedida ORDER BY grupo ");
                                    while($extraerMedida=$unidadMedida->fetch_array()){
                                    ?>
                                    <option value="<?php echo $extraerMedida['id'];?>"><?php echo $extraerMedida['grupo'].' - '.$extraerMedida['descripcion'];?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Inventario:</label>
                                <select type="text" class="form-control"  name="inventario" >
                                    <option value="">Seleccionar Inventario</option>
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Activo:</label>
                                <select type="text" class="form-control"  name="activo" >
                                    <option value="">Seleccionar una opción</option>
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div id="serviciosF" style="display:none;">
                        
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Proveedor sugerido:</label>
                                <select type="text" class="form-control"  name="proveedor" >
                                    <option value="0">Seleccionar Proveedor</option>
                                    <?php
                                    $consultandoProeedores=$mysqli->query("SELECT * FROM proveedores WHERE estado = 'Aprobado' OR estado='bloqueo' ORDER BY razonSocial ");
                                    while($extraerconsultaProve=$consultandoProeedores->fetch_array()){
                                    ?>
                                    <option value="<?php echo $extraerconsultaProve['id']; ?>"><?php echo $extraerconsultaProve['razonSocial']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Tiempo de servicio:</label>
                                
                                <?php
                                $buscaTiempo=$mysqli->query("SELECT * FROM proveedoresProductoTiempo ORDER BY id ");
                                while($extraerDatos=$buscaTiempo->fetch_array()){
                                echo $extraerDatos['grupo'];
                                ?>
                                <input type="radio" name="tiempoServicio" value="<?php echo $extraerDatos['id']; ?>">
                                &nbsp;
                                <?php
                                }
                                ?>
                                <input type="number" min="0" class="form-control"  placeholder="Ingresar datos" name="cantidadTiempoServicio" >
                                    
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-sm-6">
                            
                            <label>Subir documentos:</label>
                            <select type="number" min="0" class="form-control"  name="imagen" required>
                                <option value="">Seleccionar...</option>
                                <option value="1">Si</option>
                                <option value="2">No</option>
                            </select>    
                            
                            <!--
                             <label for="upload-photo">Archivo (Máx 10MB):</label>
                              <div class="input-group">
                                <div class="custom-file">
                                    
                                    
                                  
                                  <input type="file" class="custom-file-input" name="imagen" id="miInput" accept=".jpg,.jpeg,.png,.gif,.jpeg,.bmp,.svg,.jfif,.PNG,.JPEG,.GIF,.JPG,.TIFF,.PPM,.PGM,.PBM,.PNM,.BPG,.PPM,.DRW,.ECW,.FITS,.FLIF,.XCF,.SVG">
                                  <label class="custom-file-label" >Subir Archivo</label>
                                 
                                </div>
                                  <!--<div class="input-group-append">
                                    <span class="input-group-text" id="miInput">Subir</span>
                                  </div>
                                  
                             </div>-->
                        </div> 
                    </div>
                    
                        
                         <script>
                                      $('input[name="imagen"]').on('change', function(){
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
                     
                         $(document).ready(function(){
                                    $('#bienes').click(function(){ 
                                        document.getElementById('bienesF').style.display = '';
                                        document.getElementById('serviciosF').style.display = 'none';
                                        document.getElementById('nombreF').style.display = '';
                                        document.getElementById('nombreS').style.display = 'none';
                                    });
                                    $('#servicios').click(function(){ 
                                        document.getElementById('bienesF').style.display = 'none';
                                        document.getElementById('serviciosF').style.display = '';
                                        document.getElementById('nombreF').style.display = 'none';
                                        document.getElementById('nombreS').style.display = '';
                                    });
                                   
                                });
                                
                                /*
                                 document.getElementById("retiradoTextoE").removeAttribute("required","any");
                                    document.getElementById("select_encargadoE").setAttribute("required","any");
                                */
                                
                                
                                
                    </script>
                    
                    <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                  
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                  
                  <button type="submit" class="btn btn-primary float-right" name="Agregar">Agregar</button>
                </div>
              </form>
            </div>
            </div>    

        <div class="col">
            </div>
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
<!-- para mostrar el archivo seleccionado en el file -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- bloqueo de clic derecho
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
</script>
-->
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
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
<!-- END -->
</body>
</html>
<?php
}
?>