<?php
error_reporting(E_ERROR);
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
  <title>FIXWEI - Ver Proveedor</title>
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
  <?php
                    $idProveedor=$_POST['idProveedor'];
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $query = $mysqli->query("SELECT * FROM proveedores WHERE id= '$idProveedor'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $idEnviarProveedor = $row['id'];
                    $nit = $row['nit'];
                     $nitDigito= $row['nitDigito'];
                    $contacto = $row['contacto'];
                    $razonSocial = $row['razonSocial'];
                    $email = $row['email'];
                    $descripcion = $row['descripcion'];
                    $codigoCiiu= $row['codigoCiiu'];
                    $criticidad = $row['criticidad'];
                    $grupo = $row['grupo'];
                    $terminoP = $row['terminoPago'];
                    $ciudad = $row['ciudad'];
                    $frecuenciaA = $row['frecuenciaActualizacion'];
                    $direccion = $row['direccion'];
                    $frecuenciaAD = $row['frecuenciaActualizacionD'];
                    $telefono = $row['telefono'];
                    $tiempoE = $row['tiempoEvaluacion'];
                    $tipoproveedor=$row['tipoproveedor'];
                    $personaNaturalJuridica = ucwords(utf8_decode($row['personaNJ']));
                    $proveedorEstado = $row['estado'];
                    $movil = $row['movil'];
                    $descripcion = $row['descripcion'];
                    
                ?>
                    



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ver Proveedor</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Ver proveedor</li>
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
                            if($_POST['masivo'] != NULL){
                            ?>
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="proveedorVigente"><font color="white"><i class="fas fa-list"></i> Listar proveedores vigentes</font></a></button>
                            <?php
                            }else{
                            ?>
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="proveedores"><font color="white"><i class="fas fa-list"></i> Listar proveedores</font></a></button>
                            <?php
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
                    <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              
              <!-- /.card-header -->
              <!-- form start -->
                <div class="card-body">
                    
                
                   <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Nit:</label>
                             <?php echo $nit.'-'.$nitDigito; ?>
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label>Contacto:</label>
                            <?php echo $contacto; ?>
                        </div>                                
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Raz&oacute;n social:</label>
                            <?php echo $razonSocial; ?>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Correo Electrónico:</label>
                            <?php echo $email; ?>
                        </div>
                    </div>
                    
                    <div class="row">
                        
                        <div class="form-group col-sm-6">
                            <label>Móvil:</label>
                            <?php echo $movil; ?>
                        </div>
                        <div class="form-group col-sm-3">
                            <label>Código Ciuu:</label>
                            <?php echo $codigoCiiu; ?>
                        </div>
                    </div>
                     <div class="row">
                        <div class="form-group col-sm-">
                            <label>Descripci&oacute;n para el Texto:</label><br>
                            <?php echo $descripcion; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Criticidad:</label>
                            <?php 
                            $consulta=$mysqli->query("SELECT * FROM proveedoresCriticidad WHERE id='$criticidad' ");
                            $extraerConsulta=$consulta->fetch_array(MYSQLI_ASSOC);
                            echo $extraerConsulta['tipo']; 
                            ?>
                        </div>                        
                   
                        <div class="form-group col-sm-6">
                            <label>Grupo:</label>
                            <?php
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $queryGrupos = $mysqli->query("SELECT * FROM proveedoresGrupo WHERE id= '$grupo'");
                            $rowGrupos = $queryGrupos->fetch_array(MYSQLI_ASSOC);
                            echo $nombreGrupo = $rowGrupos['grupo'];
                            ?>
                            
                            
                        </div>
                    </div>
                    <div class="row">  
                        <div class="form-group col-sm-6">
                            <label>Método de pago  :</label>
                            <?php 
                            
                                if($terminoP > 0){
                                    echo ucwords($terminoP).' días';
                                }else{
                                   if($row['tipo'] == 'otro'){
                                       echo 'Otro '.ucwords($row['terminoPago']);
                                   }else{
                                       echo ucwords($row['tipo']);
                                   }
                                }
                            
                            ?>
                         </div>
                    
                        <div class="form-group col-sm-6">
                            <label>Ciudad:</label>
                            
                            <?php 
                                $resultado=$mysqli->query("SELECT municipios.id AS codigo,municipios.nombre AS Municipio, departamentos.nombre AS Departamento FROM municipios INNER JOIN departamentos ON municipios.departamento_id = departamentos.id AND municipios.id='$ciudad'");
                                $rowCiudad = $resultado->fetch_array(MYSQLI_ASSOC);
                                echo $idCiudad = $rowCiudad['codigo'].'-';
                                echo $nombreDepartamento = $rowCiudad['Departamento'].'-';
                                echo $codigoCiud = $rowCiudad['Municipio'];
                            ?>
                        </div>
                        <!--
                        <div class="form-group col-sm-6">
                            <label>Frecuencia de actualizaci&oacute;n (Meses):</label>
                            <?php //echo $frecuenciaA; ?>
                        </div>
                        -->
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Direcci&oacute;n:</label>
                            <?php echo $direccion; ?>
                        </div>
                  
                        <div class="form-group col-sm-6">
                            <label>Frecuencia actualizaci&oacute;n de documentos (Meses):</label>
                            <?php echo $frecuenciaAD; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Tel&eacute;fono:</label>
                            <?php echo $telefono; ?>
                        </div>
                    
                        
                        <div class="form-group col-sm-6">
                            <label>Tiempo para evaluaci&oacute;n (Meses):</label>
                            <?php echo $tiempoE; ?>
                        </div> 
                        
                     </div>
                    <div class="row">    
                        <div class="form-group col-sm-6">
                            <label>Persona:</label>
                            <?php echo ucwords($personaNaturalJuridica);?>
                        </div>
                   
                        
                        <div class="form-group col-sm-6">
                            <label>Tipo de proveedor:</label>
                            <?php 
                            $consultaTP=$mysqli->query("SELECT * FROM proveedoresTipo WHERE id='$tipoproveedor' ");
                            $extraerConsultaTP=$consultaTP->fetch_array(MYSQLI_ASSOC);
                            echo $extraerConsultaTP['tipo']; 
                            ?>
                        </div>
                        <div class="form-group col-sm-6">
                             <label>Aprobación de proveedor: </label><br>
                            <?php 
                            $tipoResponsableV=$row['radio'];
                            $personalIDV =  json_decode($row['aprobador']);
                            $longitudV = count($personalIDV);
                   
                             if($tipoResponsableV == 'usuario'){
                                    for($i=0; $i<$longitudV; $i++){ //// inicia for
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalIDV[$i]' ");
                                                while($columna = $nombreuser->fetch_assoc()){
                                                    echo $cedulaUsuario=$columna['nombres'].' '.$cedulaUsuario=$columna['apellidos']; echo "<br>";
                                                }
                                            }  /////// cierre del for
                                            
                                            
                                
                            }else{    
                               
                                for($i=0; $i<$longitudV; $i++){ //// inicia for
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$personalIDV[$i]' ");
                                                while($columna = $nombreuser->fetch_assoc()){
                                                    echo $cedulaUsuario=$columna['nombreCargos']; echo "<br>";
                                                }
                                            }  /////// cierre del for    
                                
                            }
                            
                            ?>
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label>Bloqueo/desbloqueo: </label><br>
                            <?php
                                echo $row['bloqueo'];
                            ?>
                        </div>
                        <?php
                            if($_POST['masivo'] != NULL){}else{
                        ?>
                         <div class="col-sm-12">
                            <div class="card">
                                <center>
                                    <br>
                                    <p><h4>Comentarios</h4></p>
                                </center>
                                    <div style="padding: 20px;" class="tab-pane" id="timeline">
                                        <!-- The timeline -->
                                        <div class="timeline timeline-inverse">
                                          <!-- timeline time label -->
                                          <?php 
                                           
                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                            $queryControl = $mysqli->query("SELECT * FROM proveedoresControlCambio WHERE idProveedor = '$idProveedor' ")or die(mysqli_error($mysqli));
                                            
                                            while($row = $queryControl->fetch_assoc()){
                                                $idUser = $row['Usuario'];
                                                $rol = $row['rol'];
                                                $queryUser = $mysqli->query("SELECT * FROM usuario WHERE id = '$idUser' ")or die(mysqli_error($mysqli));
                                                $datosUser = $queryUser->fetch_assoc();

                                                $nombreUsuario = $datosUser['nombres']." ".$datosUser['apellidos'];
                                          
                                          ?>
                                          
                                          <div class="time-label">
                                            <span class="bg-danger">
                                              <?php echo $row['fecha'];?>
                                            </span>
                                          </div>

                                          <div>
                                            <i class="fas fa-user bg-info"></i>
                    
                                            <div class="timeline-item">
                                              <h3 class="timeline-header border-0"><b><?php echo $row['rol'];?></b> - <a href="#"><?php echo $nombreUsuario;?></a> <?php  if('1' != NULL){ echo utf8_decode($row['comentario']); }else{ echo 'N/A';} ?>
                                              </h3>
                                            </div>
                                          </div>
                                        <?php }?>
                                        </div>
                                     </div>
                            </div>
                        </div>   
                        <?php
                            }
                        ?> 
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
                <!--
                <div class="row">
                    <div class="form-group col-sm-9">
                        <form action="proveedorDocumetos" method="POST">
                            <input value="<?php //echo $idEnviarProveedor;?>" name="idProveedor" type="hidden" readonly>
                            <button type="submit" class="btn btn-primary float-right">Documentos Adjuntos</button>
                        </form>
                    </div>
                    <div class="form-group col-sm-2">
                        <form action="proveedorProductos" method="POST">
                            <input value="<?php //echo $idEnviarProveedor;?>" name="idProveedor" type="hidden" readonly>
                            <button type="submit" class="btn btn-warning float-right">Productos</button>
                        </form>
                    </div>
                </div>
                -->
         
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
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
</body>
</html>
<?php
}
?>