<?php
//Comentario nuevo para prueba de github
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

$root2=$_SESSION["session_root"];

if($root2 != 1){
   echo '<script language="javascript">window.location.href="accesoDenegado"</script>';
}


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
  <title>FIXWEI - Parametrización de cliente</title>
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
<body class="hold-transition sidebar-mini" oncopy="return false" onpaste="return false" onload="nobackbutton();">
<div class="wrapper">


  <!-- Main Sidebar Container -->
  <?php echo require_once'menu.php';?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Parametrizaci&oacute;n cliente</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Parametrizaci&oacute;n cliente</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <div class="col-sm">
                    <button Onclick="window.location='politicasOC'"  class="btn btn-block btn-info btn-sm"><i class='fas fa-landmark'></i> Politicas </button>
                </div>
                <div class="col-sm">
                    <button Onclick="window.location='clienteEditar'"  class="btn btn-block btn-success btn-sm"><i class='fas fa-edit'></i> Editar</button>
                </div>
                
                
                <?php
                // validamos la elminación de datos por medio de un código de seguridad
                $seguridadPreguntar=$mysqli->query("SELECT * FROM seguridadDelete WHERE documento ='".$_POST['recibiendoDatos']."'  ");
                $resultadoSeguridadPreguntar=$seguridadPreguntar->fetch_array(MYSQLI_ASSOC);
                
                //AND codigo='".$_POST['codigoDatos']."'
                if($resultadoSeguridadPreguntar['intentos'] == 0 && $resultadoSeguridadPreguntar['estado'] == 'bloqueado'){
                
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
                                  <p>Ha superado la cantidad de intentos permitidos, el administrador será bloqueado, contacte a su proveedor para desbloquear el administrador</p>
                                </div>
                                 <!-- END formulario para eliminar por el id -->
                              </div>
                            </div>
                        </div>
                        <script languaje="JavaScript">
                            
                            setTimeout(clickbutton, 8000);
                            function clickbutton() { 
                                location = "controlador/sesion/logout";
                            }
                        </script>
                
                <?php
                }else{
                    if($resultadoSeguridadPreguntar['id'] != NULL && $resultadoSeguridadPreguntar['estado'] == 'activo'){
                    ?>
                    <div class="col-sm">
                        <a onclick='funcionFormula()' style='color:white;' data-toggle='modal' data-target='#modal-danger-Seguridad-Codigo' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Ingresar código de seguridad</a>
                    
                        <div class="modal fade" id="modal-danger-Seguridad-Codigo">
                            <div class="modal-dialog">
                              <div class="modal-content bg-info">
                                <div class="modal-header">
                                  <h4 class="modal-title">Alerta</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form action="controlador/permisoEliminacion" method="post">
                                <div class="modal-body">
                                  <p>Ingrese el código de seguridad que fue envíado al correo electrónico registrado</p>
                                  <input class="form-control" name="cdigoSeguridad" type="text" placeholder="Ingresar código...">
                                  <input name="recibiendoDatos" type="hidden" value="<?php echo $_POST['recibiendoDatos'];?>">
                                </div>
                                 <!-- formulario para eliminar por el id -->
                                <div class="modal-footer justify-content-between">
                                  <button type="submit" name="codigoIntentos" class="btn btn-outline-light" >Si</button>
                                  <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                                </div>
                                </form>
                                 <!-- END formulario para eliminar por el id -->
                              </div>
                            </div>
                        </div>
                        
                    </div>
                    <?php
                    }elseif($resultadoSeguridadPreguntar['id'] != NULL && $resultadoSeguridadPreguntar['estado'] == 'proceso'){
                    ?>
                    <div class="col-sm">
                        <button Onclick="window.location='clienteBorrarRegistros'"  class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar registros</button>
                    </div>
                    <div class="col-sm">
                        <a onclick='funcionFormula()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar bases de datos y archivos</a>
                    </div>
                    <?php
                    }else{
                    // END
                    ?>
                    <div class="col-sm">
                        <a onclick='funcionFormula()' style='color:white;' data-toggle='modal' data-target='#modal-danger-Seguridad' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar datos del sistema</a>
                    
                        <div class="modal fade" id="modal-danger-Seguridad">
                            <div class="modal-dialog">
                              <div class="modal-content bg-info">
                                <div class="modal-header">
                                  <h4 class="modal-title">Alerta</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form action="controlador/permisoEliminacion" method="post">
                                <div class="modal-body">
                                  <p>Ingrese el documento de identidad registrado</p>
                                  <input class="form-control" name="ingresoDatos" type="number" min="1" placeholder="Ingresar documento de identidad...">
                                </div>
                                 <!-- formulario para eliminar por el id -->
                                <div class="modal-footer justify-content-between">
                                  <button type="submit" name="solicitudEliminacion" class="btn btn-outline-light" >Si</button>
                                  <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                                </div>
                                </form>
                                 <!-- END formulario para eliminar por el id -->
                              </div>
                            </div>
                        </div>
                        
                    </div>
                    <?php
                    }
                
                
                }
                ?>
                <div class="col-sm">
                    <?php
                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                        $query = $mysqli->query("SELECT * FROM cliente");
                        $row = $query->fetch_array(MYSQLI_ASSOC);
                        $nombre = $row['nombre'];
                        $nit = $row['nit'];
                        $imagen = $row['img'];
                        $telefono = $row['telefono'];
                        $direccion = $row['direccion'];
                        $administrador = $row['administrador'];
                        $administradorUsuario = $row['usuario'];
                        $email = $row['email'];
                        $permisoIpDSesion = $row['sesion'];
                        
                    if($permisoIpDSesion == 'No'){
                    ?>
                    <form action="controlador/usuarios/autorizacion" method="POST">
                        <input name="sesionIP" value="activar" type="hidden" readonly>
                        <button style='color:white;' name="solicitudIP" class='btn btn-block btn-warning btn-sm'><i class="fas fa-ban"></i> Activar sesión por IP</button>
                    </form>
                    <?php
                        }else{
                    ?>
                    <form action="controlador/usuarios/autorizacion" method="POST">
                        <input name="sesionIP" value="descativar" type="hidden" readonly>
                        <button style='color:white;' name="solicitudIP" class='btn btn-block btn-warning btn-sm'><i class="fas fa-ban"></i> Desactivar sesión por IP</button>
                    </form>
                    <?php
                        }
                    ?>
                </div>
                <?php
                if($permisoIpDSesion == 'No'){
                
                    
                }else{
                
                    /// validamos que existan solicitudes del permiso par autorizar la IP
                    $consultandoPeticiones=$mysqli->query("SELECT count(*) FROM usuario WHERE descripcionPermiso <> 'NULL' AND estadoPermiso='Pendiente' ");
                    $extraerConsultaPeticiones=$consultandoPeticiones->fetch_array(MYSQLI_ASSOC);
                    /// END
                
                ?>
                    <div class="col-sm">
                        <button style='color:white;' Onclick="window.location='clientePermisos'" class='btn btn-block btn-info btn-sm'><b><font style="font-size:15px;"><?php echo $extraerConsultaPeticiones['count(*)'];?></b></font> Permiso de acceso IP</button>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

               


    <section class="content">
        <div class="containet-fluid">
            <div class="row">
                <div class="col"></div>
                <div class="col-9">
                    <div class="card card-widget widget-user">
                      <!-- Add the bg color to the header using any of the bg-* classes -->
                      <div class="widget-user-header bg-info">
                        <h3 class="widget-user-username"><?php echo $nombre;?></h3>
                        <h5 class="widget-user-desc description-text"></h5>
                      </div>
                      <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="data:image/jpg;base64, <?php echo base64_encode($imagen); ?>" alt="Imagen corporativa">
                      </div>
                      <div class="card-footer">
                        <div class="row">
                          <div class="col-sm-4 border-right border-left ">
                            <div class="description-block">
                              <h5 class="description-header">Raz&oacute;n social</h5>
                              <span class=""><?php echo $nombre;?></span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4 border-right">
                            <div class="description-block">
                              <h5 class="description-header">Nit</h5>
                              <span class=""><?php echo $nit;?></span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                        <!-- /.col -->
                          <div class="col-sm-4 border-right">
                            <div class="description-block">
                              <h5 class="description-header">T&eacute;lefono</h5>
                              <span class=""><?php echo $telefono;?></span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                                                    <!-- /.col -->
                          <div class="col-sm-4 border-right border-left">
                            <div class="description-block">
                              <h5 class="description-header">Direcci&oacute;n</h5>
                              <span class=""><?php echo $direccion;?></span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4 border-right">
                            <div class="description-block">
                              <h5 class="description-header">Administrador</h5>
                              <span class=""><?php echo $administrador;?></span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4 border-right">
                            <div class="description-block">
                              <h5 class="description-header">Usuario </h5>
                              <span class=""><?php echo $administradorUsuario;?></span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4 border-right border-left">
                            <div class="description-block">
                              <h5 class="description-header">Correo eléctronico</h5>
                              <span class=""><?php echo $email;?></span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                         

                          <!-- /.col -->
                        </div>
                        </div>    
                    </div>
                    <input type='hidden' id='capturaVariable'  value= 'true' >
                    <!-- anteriormente estaba el botón de eliminación-->
                        <script>
                            function funcionFormula() {
                                /*alert("entre");*/
                              document.getElementById("capturarFormula").value = document.getElementById("capturaVariable").value;
                            }
                       </script>
                       
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
                              <p>¿Ést&aacute; seguro que desea eliminar las bases de datos y archivos del sistema?</p>
                            </div>
                             <!-- formulario para eliminar por el id -->
                            
                            <div class="modal-footer justify-content-between">
                              <button data-dismiss="modal" type="button" class="btn btn-outline-light" data-toggle="modal" data-target="#modal-lg">Si</button>
                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                            </div>
                            
                             <!-- END formulario para eliminar por el id -->
                          </div>
                        </div>
                    </div>
                    
                    <div class="modal fade" id="modal-lg">
                        <div class="modal-dialog modal-lg">
                          <form action="controlador/usuarios/autorizacion" method="POST">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Autorización para la eliminación de datos del sistema</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p style="text-align:justify;">Mediante este formato, declaro que conozco términos, condiciones e implicaciones de la solicitud de eliminación total de la documentación y registros que se encuentran almacenados a la fecha en el sistema de información Fixwei correspondiente a la compañia <b><?php echo $nombre; ?><!-- Reliability Maintenance Services S.A. --></b>, y que no podrá ser restaurada.</p>
                               <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>Administrador:</label><br>
                                        <input type="text" class="form-control" value="" name="admin" placeholder="Administrador" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>Usuario del administrador: </label><br>
                                        <input type="text" class="form-control" value="" name="usuario" placeholder="Nombre del administrador" required>
                                     </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>Nit del administrador:</label><br>
                                        <input type="text" class="form-control" value="" name="nit" placeholder="Nit del administrador" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>Clave del administrador:</label><br>
                                        <input type="password" class="form-control" value="" id="password" name="pass" placeholder="Clave del administrador" required>
                                        <br>
                                        <span class="btn btn-success" onclick="mostrarContrasena()" >Mostrar contrase&ntilde;a</span> 
                                        <script>
                        function mostrarContrasena(){
                            var tipo = document.getElementById("password");
                            if(tipo.type == "password"){
                                tipo.type = "text";
                            }else{
                              tipo.type = "password";
                            }
                        }
                     </script>
                                    </div>
                                </div>
                                <div class="row">
                                     <div class="form-group col-sm-6">
                                        <label>
                                          <input name="autorizacion" type="checkbox" value="1" required> Acepto términos y condiciones.
                                        </label>
                                     </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                              <button type="submit" name="solicitar" class="btn btn-primary">Solicitar autorización</button>
                            </div>
                          </div>
                          </form>
                            </div>
                    
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <?php
                    if($_POST['ingreso'] == 1){
                    ?>
                       <script>
                            $(document).ready(function() {
                              // indicamos que se ejecuta la funcion a los 5 segundos de haberse
                              // cargado la pagina
                              setTimeout(clickbutton, 0000);
                            
                              function clickbutton() {
                                // simulamos el click del mouse en el boton del formulario
                                $("#action-button").click();
                                //alert("Aqui llega"); //Debugger
                              }
                              $('#action-button').on('click',function() {
                               // console.log('action');
                              });
                            });
                       </script> 
                       <button id="action-button" style="display:none;" data-toggle="modal" data-target="#modal-sm"></button>
                    <?php
                    }
                    ?>
                    <div class="modal fade" id="modal-sm"> 
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Ingresar código de seguridad</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action="controlador/usuarios/autorizacion" method="POST">
                            <div class="modal-body">
                              <p>Digite el código de seguridad que autoriza la elminación total de la información del sistema.</p>
                              <input name="codigo" type="text" placeholder="Ingresar código..." class="form-control" required>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                              <button type="submit" name="solicitando" class="btn btn-primary">Solicitar</button>
                            </div>
                            </form>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                  <!-- /.modal -->
            <div class="col"></div>    
      <!-- /.modal -->
        </div>
        <div class="col">
        </div>
    </section>



  
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

    <script type="text/javascript">
	function ConfirmDelete(){
		var answer = confirm("Esta seguro de eliminar?");

		if(answer == true){
			return true;
		}else{
			return false;
		}
	}
</script>
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<?php
/// validaciones de alertas
$validacionActualizar=$_POST['validacionActualizar'];
$autorizacion=$_POST['autorizacion'];
$ingreso=$_POST['ingreso'];
$autorizado=$_POST['autorizado'];
$autorizacionRechazo=$_POST['autorizacionRechazo'];
$activado=$_POST['activado'];
$desactivado=$_POST['desactivado'];

// mensaje del código
$mensajeCodigo=$_POST['mensajeCodigo'];
$alertaIngreso=$_POST['alertaIngreso'];


// mensaje intentos
$mensajeIntentos=$_POST['mensajeIntentos'];

if($mensajeIntentos == 3){
    $activarMensajeYCierreAdministrador=1;
}elseif($mensajeIntentos != NULL){
    $activarMensajeYCierreAdministrador=2;
    if($mensajeIntentos == 1){
        $mensajeIntentosEnviar='lleva 1 intento';
    }elseif($mensajeIntentos == 2){
        $mensajeIntentosEnviar='lleva 2 intentos';
    }
}
?>
<script type="text/javascript">
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });
    
    
    <?php
    
    if($activarMensajeYCierreAdministrador == 2){
    ?>
       Toast.fire({
            type: 'warning',
            title: ' Error en el código de seguridad, <?php echo $mensajeIntentosEnviar;?>, recuerde que al tercer intento el administador se bloqueará.'
        }) 
    <?php
    }
    
    if($alertaIngreso == 1){
    ?>
       Toast.fire({
            type: 'warning',
            title: ' El documento de identidad ingresado no existe.'
        }) 
    <?php
    }
    
    if($mensajeCodigo == 1){
    ?>
     Toast.fire({
            type: 'success',
            title: 'El código de seguridad ha sido enviado al correo electrónico registrado.'
        })
    <?php    
    }
    if($activado == 1){
    ?>
     Toast.fire({
            type: 'success',
            title: 'Inicio de sesión por IP restringida Activado.'
        })
    <?php    
    }
    if($desactivado == 1){
    ?>
     Toast.fire({
            type: 'success',
            title: 'Inicio de sesión por IP restringida Desactivado.'
        })
    <?php    
    }
    
    
    
    if($autorizacionRechazo == 1){
    ?>
        Toast.fire({
            type: 'error',
            title: 'El código ingresado no es el correcto.'
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
    if($autorizacion == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: 'Los datos ingresados no corresponden a los datos del administrador del sistema.'
        })
    <?php
    }
    if($ingreso == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: 'Proceda a ingresar el código de seguridad.'
        })
    <?php
    }
    if($autorizado == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: 'La información del sistema fue eliminada con éxito.'
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