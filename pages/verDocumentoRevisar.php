<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{

$idDocumento = $_POST['idDocumento'];

require 'conexion/bd.php';


?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Revisión Documental</title>
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
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.min.js"></script>
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
            <h1>Revisión Documental</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Revisión Documental</li>
            </ol>
          </div>
        </div>
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col-sm">
                            <form action="revisarDocumento" method="post">
                                <input name="idDocumento" value="<?php echo $_POST['idDocumento'];?>" type="hidden">
                                <input name="idSolicitud" value="<?php echo $_POST['idSolicitud'];?>" type="hidden"><!-- revisionDocumental -->
                            <button type="submit" class="btn btn-block btn-info btn-sm"><font color="white"><i class="fas fa-chevron-left"></i> Revisión Documental</font></button>
                            </form>
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
        <div>

        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <!-- TABLA PERMISOS-->
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-9">
                    <!-- Default box -->
                    
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title"> </h3>

                          </div>
                          <?php
                            require_once 'conexion/bd.php';
                            $mysqli->query("SET NAMES 'utf8'");
                            $queryDoc = $mysqli->query("SELECT * FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
                            $datosDoc = $queryDoc->fetch_assoc();
                            
                            $tipo = $datosDoc['tipo_documento'];
                            $proceso = $datosDoc['proceso'];
                            
                            $mysqli->query("SET NAMES 'utf8'");
                            $nombreTipoDocumento = $mysqli->query("SELECT * FROM tipoDocumento WHERE id ='$tipo'")or die(mysqli_error());
                            $colu = $nombreTipoDocumento->fetch_array(MYSQLI_ASSOC);
                            $nombreT = $colu['nombre'];
                            
                            $mysqli->query("SET NAMES 'utf8'");
                            $nombreProceso = $mysqli->query("SELECT * FROM procesos WHERE id ='$proceso'")or die(mysqli_error());
                            $col3 = $nombreProceso->fetch_array(MYSQLI_ASSOC);
                            $nombreP = $col3['nombre'];
                            
                          ?>
                          
                          
                          <div class="card-body">
                            <div class="col-sm-12">
                                <div class="card">
                                    <center>
                                        <br>
                                        <p><h4>Información del documento</h4></p>
                                    </center>
                                    
                                        <div class="row" style="padding-left: 50px;" >
                                            <div class="col-sm-3">
                                              <!-- text input -->
                                              <div class="form-group">
                                                <label>Nombre Documento:</label><br>
                                                <?php echo $datosDoc['nombres'];?>
                                              </div>
                                            </div>
                                            <div class="col-sm-3">
                                              <div class="form-group">
                                                <label>Proceso:</label><br>
                                                <?php echo $nombreP;?>
                                              </div>
                                            </div>
                                            <div class="col-sm-3">
                                              <div class="form-group">
                                                <label>Tipo documento:</label><br>
                                                <?php echo $nombreT;?>
                                              </div>
                                            </div>
                                        </div>
                                    <!--d-flex justify-content-center-->
                                        
                                        <div class="row" style="padding-left: 50px;">
                                            <div class="col-sm-3">
                                              <!-- text input -->
                                              <div class="form-group">
                                                <label>Código:</label><br>
                                                <?php echo $datosDoc['codificacion'];?>
                                              </div>
                                            </div>
                                            <div class="col-sm-3">
                                              <div class="form-group">
                                                <label>Ultima versión:</label><br>
                                                <?php echo $datosDoc['version'];?>
                                              </div>
                                            </div>
                                        </div>
                                    <?php
                                        if($datosDoc['nombrePDF'] != NULL){
                                            $nombrePDF = $datosDoc['nombrePDF'];
                                    ?>
                                        <div class="card-body">
                                            <div id="example1"></div>
                                        </div>
                                     <?php } 
                                     
                                     
                                     /// verificar que no permita hacer ora revisión, hasta que sea rechazada o aprobada
                                     
                                     $validarActualizacion=$mysqli->query("SELECT * FROM `solicitudDocumentos` WHERE tipoSolicitud=2 AND proceso='$proceso' AND tipoDocumento='$tipo' AND nombreDocumento='$idDocumento' AND estado IS NULL");
                                     $extraer_validarActualizacion=$validarActualizacion->fetch_array(MYSQLI_ASSOC);
                                     
                                     if($extraer_validarActualizacion['id'] != NULL){
                                        $nombreCargoAsignado=$mysqli->query("SELECT * FROM cargos WHERE id_cargos='".$extraer_validarActualizacion['encargadoAprobar']."' ");
                                        $extraer_validarEncargadoAsignado=$nombreCargoAsignado->fetch_array(MYSQLI_ASSOC);
                                        
                                        echo '<center><font color="blue">La solicitud ya se encuentra en trámite, el cargo <b>"'.$extraer_validarEncargadoAsignado['nombreCargos'].'"</b> la está gestionando</font></center>';
                                        echo '<br>';
                                       
                                     }else{
                                     ?>
                                     <!--  -->
                                    <form action="controlador/revisionDocumental/controller.php" method="POST" onsubmit="enviar();">
                                            
                                        <center>
                                            <br>
                                            <p><h4>Control de cambios revisión</h4></p>
                                        </center>
                                            
                                        <div class="row">
                                        
                                            <div class="form-group col-sm-6">
                                                
                                                <label>Comentario: </label>
                                                <textarea rows="4" class="form-control" name="controlCambios" placeholder="Control de cambios" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required></textarea>
                                                <br>
                                            
                                            </div>
                                            
                                            <div class="form-group col-sm-6">
                                                <label>¿El documento requiere actualización?</label><br>
                                                <label ><input type="radio" id='rad_siActualizar' name="radiobtnActualizar" value="si" required> Si</label>
                                                <label ><input type="radio" id='rad_noActualizar' name="radiobtnActualizar" value="no" required> No</label>
                                                
                                                <br>
                                                <div id="encargadoSolicitud" style="display:none;">
                                                    <label>Encargado:</label>
                                                    <select name="encargado" id="selectEncargado" class="form-control">
                                                       <option value="">Seleccione un encargado</option>
                                                       <?php
                                                        require_once'conexion/bd.php';
                                                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                                                        $resultado2=$mysqli->query("SELECT * FROM cargos ORDER BY nombreCargos ASC");
                                                        
                                                        while ($columna = mysqli_fetch_array( $resultado2 )) { ?>
                                                            <option value="<?php echo $columna['id_cargos']; ?>"><?php echo $columna['nombreCargos']; ?> </option>
                                                        <?php }  ?>
                                                    </select>
                                                    <br>
                                                    <label>Notificar también a: </label><br>
                                                    <input type="radio" id="rad_cargoE" name="radiobtnE" value="cargos">
                                                    <label for="cargo">Cargo</label>
                                                    <input type="radio" id="rad_usuarioE" name="radiobtnE" value="usuarios">
                                                    <label for="usuarios">Usuarios</label>
                        
                                                    
                                                    <div class="select2-blue">
                                                        <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoE[]" id="select_encargadoE" ></select>
                                                    </div>
                                                </div>
                                                
                                                <div id="mesesRevision" style="display:none;">
                                                    <label>Meses para la próxima revisión:</label>
                                                    <input type="number" min="1" max="24" name="nmesesRevision" id="nmesesRevision">
                                                </div>
                                                
                                            </div>    
                                            
                                            


                                        
                                        </div>
                                        
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                            </div>    
                                            
                                            <div class="form-group col-sm-6" style="padding: 15px;">
                                                
                                                <input type="hidden" name="idDocumento" value="<?php echo $idDocumento;?>">
                                                <input type="hidden" name="nombre" value="<?php echo $datosDoc['id'];?>">
                                                <input type="hidden" name="nombreDocumento" value="<?php echo $datosDoc['nombres']; ?>">
                                                <input type="hidden" name="proceso" value="<?php echo $proceso;?>">
                                                <input type="hidden" name="tipoDoc" value="<?php echo $tipo;?>">
                                                
                                                
                                                <button type="submit" id="btn" name="revision" class="btn float-right btn-primary btn-sm">Realizar revisión</font></a></button>
                                                
                                                
                                                
                                            </div>
                                        </div>    
                                    </form>
                                    <script> /// agregamos una funcion de ejecutar en el form, para leer el botón de submit y bloquearlo una vez sea enviado los datos
                                          function enviar(){
                                            var btn = document.getElementById('btn');
                                            btn.setAttribute('disabled','');
                                            //alert('botón disabled');
                                          }
                                    </script>
                                    <?php
                                     }
                                    ?>
                            </div>
                        </div>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              
                              
                          </div>
                          <!-- /.card-footer-->
                        </div>
                    
                    <!-- /.card -->
                  </div>
                  <div class="col"></div>
                </div>
        </div>
    </section>
    <!-- TABLA PERMISOS-->

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
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- Encargado de la solicitud-->
<script>
    $(document).ready(function(){
        
        
        $('#rad_siActualizar').click(function(){
            document.getElementById('mesesRevision').style.display = 'none';
            document.getElementById("nmesesRevision").removeAttribute("required","required");
        });
        $('#rad_noActualizar').click(function(){
            document.getElementById('mesesRevision').style.display = '';
            document.getElementById("nmesesRevision").setAttribute("required","required");
        });
        
        
        $('#rad_siActualizar').click(function(){
            document.getElementById('encargadoSolicitud').style.display = '';
            document.getElementById("selectEncargado").setAttribute("required","required");
        });
        $('#rad_noActualizar').click(function(){
            document.getElementById('encargadoSolicitud').style.display = 'none';
            document.getElementById("selectEncargado").removeAttribute("required","required");
        });
        
        
        
        
        
    });
</script>
<!-- Select2 -->
<script src="../plugins/select2/js/select2.full.min.js"></script>
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
<script>
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
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
<script>PDFObject.embed("archivos/documentos/<?php echo $nombrePDF;?>", "#example1");</script>
<style>
    .pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }
  </style>
</body>
</html>
<?php
}
?>