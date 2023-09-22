<?php
session_start();
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
require_once 'inactividad.php'; 
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Cargar acta</title>
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
  <!-- summernote -->
  <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.css">
  <!--CKeditor
  <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.min.js"></script>
  <style>
    .pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }
  </style>
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
            <h1>Cargar acta</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Cargar acta</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="actas"><font color="white"><i class="fas fa-list"></i> Listar Actas</font></a></button>
                        </div>
                        <div class="col-sm">
                        </div>
                        <div class="col-sm">
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
            <div class="col-12">
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header --> 
              <?php
                    require 'conexion/bd.php';//conexion
                    $idActa = $_POST['idActa'];//id acta editar
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $actaInfo = $mysqli->query("SELECT * FROM actas WHERE id = $idActa");//trear datos del acta
                    
                    while($col = $actaInfo->fetch_assoc()) { //extrayendo los datos del acta.
                        $nombreActa = $col['nombreActa'];
                        $proceso = $col['proceso'];
                        $ubicacion = $col['ubicacion'];
                        $fechaini = $col['fechaInicio'];
                        $fechaCierre = $col['fechaCierre'];
                        $quienCita = $col['quienCita'];
                        $quienCitaID =  json_decode($col['quienCitaID']);
                        
                        //var_dump($quienCitaID);
                        $longitud = count($quienCitaID);
                        $quienElabora = $col['quienElabora'];
                        $quienElaboraID = json_decode($col['quienElaboraID']);
                        $longitud2 = count($quienElaboraID);
                        $aprobacion = $col['aprobacionCompromisos'];
                        $compromisos = $col['compromisos'];
                        $compromisosID = json_decode($col['compromisosID']);
                        $longitud3 = count($compromisosID);
                        $convocados = $col['convocado'];
                        $convocadosID = json_decode($col['convocadoID']);
                        $longitud4 = count($convocadosID);
                        $asistentes = $col['asistente'];
                        $asistentesID = json_decode($col['asistenteID']);
                        $longitud5 = count($asistentesID);
                        //aqui va todo lo de EXTERNOS
                        $jsonConvocado = json_decode($col['nombreConvocadoEXT']);
                        $longitud6 = count($jsonConvocado);
                        $jsonTipo = json_decode($col['tipoEmpresaCovEXT']);
                        $longitud7 = count($jsonTipo);
                        $jsonNombre = json_decode($col['nombreEmpresa']);
                        $longitud8 = count($jsonNombre);
                        $jsonCargo = json_decode($col['cargoConvocadoEXT']);
                        //var_dump($jsonCargo);
                        $longitud9 = count($jsonCargo);
                        
                        ///////
                        
                        $permisoActa = $col['permisosActa'];  /// usuario, grupo o cargo
                        $publico = $col['publico'];  // si o no
                        $responsablesID = json_decode($col['responsablesActa']); 
                        $longitud10 = count($responsablesID);
                        $editor = $col['acta'];
                        $compromiso = $col['compromiso'];
                        $responsableCompromiso = $col['responsableCompromiso'];
                        $responsableCompromisoID =  json_decode($col['responsableID']);
                        $longitud11 = count($responsableCompromisoID);
                        $fechaPrimera =  $col['fechaEntrega'];
                        $entregarA = $col['entregarA'];
                        $entregarAID =  json_decode($col['entregarAID']);
                        $longitud12 = count($entregarAID);
                        
                        $radioActaSiNO = $col['aprobarActa'];//requiere compromisos
                        $radioActaTipo = $col['quienAprueba'];//quien aprueba acta
                        $selectActaAprobacion = json_decode($col['quienApruebaId']);//id quien aprueba
                        
                        $nombrePDF = $col['rutaArchivo'];
                    }
                    
                    
                    //Validacion de si puede editar el acta 
                    
                    $permisoEditar = FALSE;
                    
                    
                    
                    
                    
                    
                    ///Para preseleccionar si son cargo o usuarios en los select multiples
                    if($quienCita == 'cargo'){
                        $checkedCCita= "checked";            
                    }
                        
                    if($quienCita == 'usuario'){
                        $checkedUCita = "checked"; 
                    }
                    
                    
                    if($quienElabora == 'cargo'){
                        $checkedCElabora = "checked";            
                    }
                        
                    if($quienElabora == 'usuario'){
                        $checkedUElabora = "checked"; 
                    }
                    
                    if($convocados == 'cargo'){
                        $checkedCConvocados = "checked";            
                    }
                        
                    if($convocados == 'usuario'){
                        $checkedUConvocados = "checked"; 
                    }
                    
                    if($asistentes == 'cargo'){
                        $checkedCAsistentes = "checked";            
                    }
                        
                    if($asistentes == 'usuario'){
                        $checkedUAsistentes = "checked"; 
                    }
                    
                    
                    /*
                    Aproobacion acta 
                    $checkAprobacionSi  
                    $checkedCAprueba
                    */
                    
                    if($radioActaSiNO == 'si'){
                        $checkAprobacionSi = "checked";
                        
                        if($radioActaTipo == 'cargo'){
                            $checkedCAprueba = "checked";            
                        }
                            
                        if($radioActaTipo == 'usuario'){
                            $checkedUAprueba = "checked"; 
                        }
                        
                    }else{
                        $checkAprobacionNo = "checked";
                    }
                    
                    
                    
                    if($publico == 'no'){
                        $checkPublicoNo = "checked";
                        
                        if($permisoActa == 'cargo'){
                            $checkedCPublico = "checked";            
                        }
                            
                        if($permisoActa == 'usuario'){
                            $checkedUPublico = "checked"; 
                        }
                        
                        if($permisoActa == 'grupo'){
                            $checkedGPublico = "checked"; 
                        }
                    }else{
                        $checkPublicoSi = "checked";
                    }
                    
                    
                  ?>
              
              
              
              <!-- form start -->
              <form role="form" action="controlador/actas/controller" method="POST" onsubmit="return checkSubmit();">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                           <label for="">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre acta" value="<?php echo $nombreActa;?>" autocomplete="off" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46 || event.charCode == 44 )" required>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>Proceso:</label>
                            <select name="proceso" id="cbx_cedi" class="form-control" required> 
                             <?php
                             require 'conexion/bd.php';
                             $acentos = $mysqli->query("SET NAMES 'utf8'");
                             $resultado = $mysqli->query("SELECT * FROM procesos ORDER BY nombre ASC");
                             while($row = $resultado->fetch_assoc()) {
                                
                                    if($row['estado'] == 'Eliminado'){
                                        continue;
                                    }
                                
                                if($row['id'] == $proceso){
                                    $selectProceso = "selected";
                                }else{
                                    $selectProceso = "";
                                }
                                 
    				         
                              ?>
                              <option value="<?php echo $row['id']; ?>" <?php echo $selectProceso;?>><?php echo $row['nombre']; ?></option>
                              <?php } 
    				            ?>
                            </select>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Ubicación:</label>
                            <input type="text" class="form-control" name="ubicacion" placeholder="Ubicación" value="<?php echo $ubicacion;?>" autocomplete="off" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46 || event.charCode == 44 )">
                        </div>
                        
                        
                        
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Fecha y hora de inicio:</label> <br>
                            <label><?php //echo $fechaini;?></label>
                            
                            <?php
                            
                            //Descomponiendo fecha de inicio
                            
                            $fechaini;
                            
                            $fecha = date('Y-m-d',strtotime($fechaini));
                            $hora = date('H',strtotime($fechaini));
                            $minuto = date('i',strtotime($fechaini));
                            
                            //// lo siento no se como mas hace el select de la hora, que logica mas mala :c ademas hay afan pos sacar esto.
                           
                            ?>
                            
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="input-group">
                                            <div class="input-group-prepend">
                                               <span class="input-group-text"><i class="far fa-clock"></i></span>
                                            </div>
                                        <input type="date" class="form-control" name="fechainicio" value="<?php echo $fecha;?>" required>
                                    </div>
                                    <!--<input type="date" class="form-control" name="fechainicio" value="<?php //echo $fecha;?>" required>-->
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text"><i class="far fa-clock"></i></span>
                                            </div>
                                            <input type="time" name="hora" value="<?php echo $hora.':'.$minuto;?>" class="form-control float-right" id="reservationtime">
                                        </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                       
                        
                        <div class="form-group col-md-6">
                            <label>Quién Cita: </label><br>
                            <input type="radio" id="rad_cargoE" name="radiobtnE" value="cargo" <?php echo $checkedCCita;?>>
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioE" name="radiobtnE" value="usuario" <?php echo $checkedUCita;?>>
                            <label for="usuarios">Usuarios</label>

                            
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoE[]" id="select_encargadoE" required></select>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>Quién Elabora: </label><br>
                            <input type="radio" id="rad_cargoR" name="radiobtn2" value="cargo" <?php echo $checkedCElabora;?>>
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioR" name="radiobtn2" value="usuario" <?php echo $checkedUElabora;?>>
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoR[]" id="select_encargadoR" required></select>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>¿El acta necesita de aprobación?:  </label><br>
                            <input type="radio" id="rad_siAprueba" name="radiobtnAprueba" value="si" <?php echo $checkAprobacionSi;?>>
                            <label for="cargo">Si</label>
                            <input type="radio" id="rad_noAprueba" name="radiobtnAprueba" value="no" <?php echo $checkAprobacionNo;?>>
                            <label for="usuarios">No</label>
                            
                            <div id="divApruebaActa" style="display:none;">
                                <input type="radio" id="rad_cargoAprueba" name="radiobtnAprueba2" value="cargo" <?php echo $checkedCAprueba; ?>>
                                <label for="cargo">Cargo</label>
                                <input type="radio" id="rad_usuarioAprueba" name="radiobtnAprueba2" value="usuario" <?php echo $checkedUAprueba; ?>>
                                <label for="usuarios">Usuarios</label>
                                
                                <div class="select2-blue">
                                    <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoAR[]" id="select_encargadoAR"></select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>¿Acta abierta a todo público? : </label><br>
                            <input type="radio" id="rad_si2" name="radiobtnP" value="si" <?php echo $checkPublicoSi;?>>
                            <label for="cargo">Si</label>
                            <input type="radio" id="rad_no2" name="radiobtnP" value="no" <?php echo $checkPublicoNo;?>>
                            <label for="usuarios">No</label>
                            
                            <div id="aprovar_regitros2" style="display:none;">
                                <input type="radio" id="rad_cargoA2" name="radiobtnP2" value="cargo" <?php echo $checkedCPublico;?>>
                                <label for="cargo">Cargo</label>
                                <input type="radio" id="rad_usuarioA2" name="radiobtnP2" value="usuario" <?php echo $checkedUPublico;?>>
                                <label for="usuarios">Usuarios</label>
                                <input type="radio" id="rad_grupo" name="radiobtnP2" value="grupo" <?php echo $checkedGPublico;?>>
                                <label for="usuarios">Grupos</label>
    
                                
                                <div class="select2-blue">
                                    <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoA2[]" id="select_encargadoA2"></select>
                                </div>
                                
                            </div>
                        </div>
                        
                       
                        
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Cargar acta:</label><br>
                            <?php
                            if($nombrePDF != NULL){
                                echo 'Acta cargada';
                            }
                            ?>
                        </div>
                        <div class="form-group col-md-12 text-center">
                                <div id="horaFin" name="horaFin" >
                                    <div class="row" >
                                        <label for="exampleInputPassword1">Fecha y hora de cierre:</label>
                            <?php
                            
                            //Descomponiendo fecha de cierre
                            
                            
                            $fechaFin = date('Y-m-d',strtotime($fechaCierre));
                            $horaFin = date('H',strtotime($fechaCierre));
                            $minutoFin = date('i',strtotime($fechaCierre));
                            
                            //// lo siento no se como mas hace el select de la hora, que logica mas mala :c ademas hay afan pos sacar esto.
                           
                            ?>
                                        <div class="col-md-4">
                                           <input type="date" class="form-control" name="fechafin" placeholder="" value="<?php echo $fechaFin;?>">
                                        </div>
                                    
                                        <div class="col-md-3">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                  <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                </div>
                                                        <input type="time" name="horafin" value="<?php echo $horaFin.':'.$minutoFin; ?>" class="form-control float-right" id="reservationtime">
                                            </div>
                                             
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        
                </div>
                <!-- /.form-group -->
              
        
                 
                  
                  
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                   <input type="hidden" id="idActa" name="idActa" value="<?php echo $idActa;?>">
                          <input type="hidden" id="" name="actaCargada" value="si">
                          <input type="hidden" id="" name="precarga" value="1">
                        <button type="submit" name="editarActa" class="btn btn-primary float-right">>>Siguiente</button>
                </div>
              
            </div>
            </div>    

            <div class="col">
            </div>
            
           
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    </form>
     <script>
         enviando = false; //Obligaremos a entrar el if en el primer submit
    
        function checkSubmit() {
            if (!enviando) {
        		enviando= true;
        		return true;
            } else {
                //Si llega hasta aca significa que pulsaron 2 veces el boton submit
                //alert("El formulario ya se esta enviando");
                return false;
            }
        }
    </script>
    
    
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
<!-- Quien cita-->
<script>
    $(document).ready(function(){
        $('#rad_cargoE').click(function(){
            rad_cargo = "cargo";
            $.post("selectDinamicoActas.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoE").html(data);
            }); 
        });
        
        $('#rad_usuarioE').click(function(){
            rad_usuario = "usuario";
            $.post("selectDinamicoActas.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoE").html(data);
            }); 
        });
        

        var radios = document.getElementsByName('radiobtnE');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idActa").value;
            var grupo = radios[i].value;
            var radEncargado = "radEncargado";

            $.post("selectDinamicoActas.php", { rad_post: rad_post, grupo: grupo, radEncargado: radEncargado}, function(data){
                $("#select_encargadoE").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
       
        
    });
</script>
<!-- /Quien cita-->

<!-- Quien elabora-->
<script>
    $(document).ready(function(){
        $('#rad_cargoR').click(function(){
            rad_cargo = "cargo";
            $.post("selectDinamicoActas.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoR").html(data);
            }); 
        });
        
        $('#rad_usuarioR').click(function(){
            rad_usuario = "usuario";
            $.post("selectDinamicoActas.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoR").html(data);
            }); 
        });
        

        var radios = document.getElementsByName('radiobtn2');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idActa").value;
            var grupo = radios[i].value;
            var radEncargadoR = "radEncargadoR";

            $.post("selectDinamicoActas.php", { rad_post: rad_post, grupo: grupo, radEncargadoR: radEncargadoR}, function(data){
                $("#select_encargadoR").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
       
        
    });
</script>
<!-- /Quien elabora-->



<!--Oculta div permisos acta-->
<script>
    $(document).ready(function(){
        $('#rad_si2').click(function(){
            document.getElementById('aprovar_regitros2').style.display = 'none';
        });
        $('#rad_no2').click(function(){
            document.getElementById('aprovar_regitros2').style.display = '';
        });
    });
</script>
<!-- Permisos acta-->
<script>
    $(document).ready(function(){
        
        $('#rad_cargoA2').click(function(){
            rad_cargo = "cargo";
            $.post("selectDinamicoActas.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoA2").html(data);
            }); 
        });
        $('#rad_usuarioA2').click(function(){
            rad_usuario = "usuario";
            $.post("selectDinamicoActas.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoA2").html(data);
            }); 
        });
        
        var radios = document.getElementsByName('radiobtnP');
        
        for (var i = 0, length = radios.length; i < length; i++) {
          
          if (radios[i].checked) {
              if(radios[i].value == 'si'){
                 document.getElementById('aprovar_regitros2').style.display = 'none'; 
              }
              
              if(radios[i].value == 'no'){
                 document.getElementById('aprovar_regitros2').style.display = ''; 
              }
          }
        }
        
        var radios = document.getElementsByName('radiobtnP2');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idActa").value;
            var grupo = radios[i].value;
            var radEncargadoA2 = "radEncargadoA2";

            $.post("selectDinamicoActas.php", { rad_post: rad_post, grupo: grupo, radEncargadoA2: radEncargadoA2}, function(data){
                $("#select_encargadoA2").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
        
        
    });
</script>
<!--/ Permisos acta-->

<!--Oculta div permisos acta quien puede ver acta-->
<script>
    $(document).ready(function(){
        $('#rad_siAprueba').click(function(){
            document.getElementById('divApruebaActa').style.display = '';
        });
        $('#rad_noAprueba').click(function(){
            document.getElementById('divApruebaActa').style.display = 'none';
        });
    });
</script>
<!-- Permisos quien puede ver acta-->
<script>
    $(document).ready(function(){
        
        $('#rad_cargoAprueba').click(function(){
            rad_cargo = "cargo";
            $.post("selectDinamicoActas.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoAR").html(data);
            }); 
        });
        $('#rad_usuarioAprueba').click(function(){
            rad_usuario = "usuario";
            $.post("selectDinamicoActas.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoAR").html(data);
            }); 
        });
        
        var radios = document.getElementsByName('radiobtnAprueba');
        
        for (var i = 0, length = radios.length; i < length; i++) {
          
          if (radios[i].checked) {
              if(radios[i].value == 'si'){
                 document.getElementById('divApruebaActa').style.display = ''; 
              }
              
              if(radios[i].value == 'no'){
                 document.getElementById('divApruebaActa').style.display = 'none'; 
              }
          }
        }
        
        var radios = document.getElementsByName('radiobtnAprueba2');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idActa").value;
            var grupo = radios[i].value;
            var radEncargadoActa = "radEncargadoActa";

            $.post("selectDinamicoActas.php", { rad_post: rad_post, grupo: grupo, radEncargadoActa: radEncargadoActa}, function(data){
                $("#select_encargadoAR").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
        
        
    });
</script>
<!--/ Permisos quien puede ver acta-->
<!--Select dinamico-->
<script>
    $(document).ready(function(){
        $('#rad_cargoA2').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoA2").html(data);
            }); 
        });
        $('#rad_usuarioA2').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoA2").html(data);
            }); 
        });
        $('#rad_grupo').click(function(){
            rad_grupo = "grupo";
            $.post("selectDocumentos3.php", { rad_grupo: rad_grupo }, function(data){
                $("#select_encargadoA2").html(data);
            }); 
        });
    });
</script>


<!--Ckeditor-->
<script src="ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'editor1' );
</script>
<!-- Summernote -->
<script src="../plugins/summernote/summernote-bs4.min.js"></script>
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote()
  })
</script>

<script>PDFObject.embed("archivos/actas/<?php echo $nombrePDF;?>", "#example1");</script>
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
            title: ' La fecha de cierre no puede ser menor a la fecha de inicio.'
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
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
</body>
</html>
<?php
}
?>