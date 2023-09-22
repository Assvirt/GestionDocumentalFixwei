<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

///////// notificaciones para plataforma y correo
require_once 'conexion/bd.php';
$formulario = 'actas'; //Se cambia el nombre del formulario
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
  <title>FIXWEI - Crear Acta</title>
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
  <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
  <!--CKeditor-->
 <!-- -->
 <!-- <script src="https://cdn.ckeditor.com/ckeditor5/23.1.0/classic/ckeditor.js"></script> -->
</head>
<script>
   	
    function nobackbutton(){
    	
       window.location.hash="no-back-button";
    	
       window.location.hash="Again-No-back-button" //chrome
    	
       window.onhashchange=function(){window.location.hash="no-back-button";}
    	
    }
</script>
<body class="hold-transition sidebar-mini" onload="nobackbutton();" >
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
            <h1>Crear Acta</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Crear Acta</li>
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
    
    <form role="form" action="controlador/actas/controller" method="POST" onsubmit="return checkSubmit();" > 
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
                    <!-- form start -->
                    
                        <!-- parametros para la activacion de correo y plataforma -->
                            
                                <input name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden" readonly>
                                
                                    <?php if($visibleP != 'none'){ ?>
                                    
                                    
                                            <input style="border:0px;" name="plataforma" value="1" type="hidden" readonly>
                                        <?php }else{  }
                                
                                    if($visibleP != 'none' && $visibleC != 'none'){
                                        '-';
                                    }
                                
                                            if($visibleC != 'none'){ ?>
                                        
                                            <input style="border:0px;" name="correo" value="1" type="hidden" readonly>
                                        <?php }else{  } ?>
                            
                        <!-- Fin parametros para la activacion de correo y plataforma -->
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                <label for="">Nombre:</label>
                                    <input type="text" class="form-control" name="nombre" placeholder="Nombre acta"  autocomplete="off" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Proceso:</label>
                                    <select name="proceso" id="cbx_cedi" class="form-control" required>
                                    <?php
                                    require 'conexion/bd.php';
                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $resultado = $mysqli->query("SELECT * FROM procesos ORDER BY id");
                                    while($row = $resultado->fetch_assoc()) { 
                                    if($row['estado'] == 'Eliminado'){
                                        continue;
                                    }
                                    ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                    <?php } 
                                        ?>
                                    </select>
                                </div>
                                
                                
                                <div class="form-group col-md-6">
                                    <label for="exampleInputPassword1">Ubicación:</label>
                                    <input type="text" class="form-control" name="ubicacion" placeholder="Ubicación" autocomplete="off" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                                </div>
                                
                                
                                <div class="form-group col-md-6">
                                    <label for="exampleInputPassword1">Fecha y hora de inicio:</label>
                                    <!--
                                    <input type="datetime-local" class="form-control" name="fechainicio" placeholder="">
                                    <input type="date" class="form-control" name="fechainicio" placeholder="">
                                    <input type="time" class="form-control" name="fechainicio" placeholder="">
                                    -->
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                </div>
                                                <input type="date" class="form-control" max="3000-01-01" name="fechainicio" placeholder="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                    </div>
                                                    <input type="time" name="hora" class="form-control float-right" id="reservationtime">
                                            </div>
                                            <!--<select name="hora" class="form-control" required>
                                            <option value="">Hora</option>
                                            <option value="0">12:00 am</option>
                                            <option value="1">1:00 am</option>
                                            <option value="2">2:00 am</option>
                                            <option value="3">3:00 am</option>
                                            <option value="4">4:00 am</option>
                                            <option value="5">5:00 am</option>
                                            <option value="6">6:00 am</option>
                                            <option value="7">7:00 am</option>
                                            <option value="8">8:00 am</option>
                                            <option value="9">9:00 am</option>
                                            <option value="10">10:00 am</option>
                                            <option value="11">11:00 am</option>
                                            <option value="12">12:00 pm</option>
                                            <option value="13">1:00 pm</option>
                                            <option value="14">2:00 pm</option>
                                            <option value="15">3:00 pm</option>
                                            <option value="16">4:00 pm</option>
                                            <option value="17">5:00 pm</option>
                                            <option value="18">6:00 pm</option>
                                            <option value="19">7:00 pm</option>
                                            <option value="20">8:00 pm</option>
                                            <option value="21">9:00 pm</option>
                                            <option value="22">10:00 pm</option>
                                            <option value="23">11:00 pm</option>
                                            </select>-->
                                        </div>
                                        <!--
                                        <div class="col-md-3">
                                            <select name="minuto" class="form-control" required>
                                                <option value="">Minuto</option>
                                                <?php/*
                                                    $minuto = 0;
                                                    for($i=0;$i <= 59;$i++){
                                                        echo "<option value='$i'>$i</option>";
                                                    }*/
                                                ?>
                                            </select>
                                        </div>-->
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <!--
                                    <label for="exampleInputPassword1">Fecha y hora de cierre:</label>
                                    <input type="datetime-local" class="form-control" name="fechafin" placeholder="">
                                    Se comenta este campo por que ya nose require.
                                    -->
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Quién Cita: </label><br>
                                    <input type="radio" id="rad_cargoE" name="radiobtn" value="cargo">
                                    <label for="cargo">Cargo</label>
                                    <input type="radio" id="rad_usuarioE" name="radiobtn" value="usuario">
                                    <label for="usuarios">Usuarios</label>

                                    
                                    <div class="select2-blue">
                                        <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoE[]" id="select_encargadoE" required></select>
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Quién Elabora: </label><br>
                                    <input type="radio" id="rad_cargoR" name="radiobtn2" value="cargo">
                                    <label for="cargo">Cargo</label>
                                    <input type="radio" id="rad_usuarioR" name="radiobtn2" value="usuario">
                                    <label for="usuarios">Usuarios</label>
                                    <div class="select2-blue">
                                        <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoR[]" id="select_encargadoR" required></select>
                                    </div>
                                </div>
                                
                                <!--<div class="form-group col-md-6">
                                    <label>¿Los compromisos del acta requieren aprobación? : </label><br>
                                    <input type="radio" id="rad_si" name="radiobtn3" value="si" required>
                                    <label for="cargo">Si</label>
                                    <input type="radio" id="rad_no" name="radiobtn3" value="no" required>
                                    <label for="usuarios">No</label>
                                    
                                    <div id="aprovar_regitros" style="display:none;">
                                        <input type="radio" id="rad_cargoA" name="radiobtn31" value="cargo">
                                        <label for="cargo">Cargo</label>
                                        <input type="radio" id="rad_usuarioA" name="radiobtn31" value="usuario">
                                        <label for="usuarios">Usuarios</label>
            
                                        
                                        <div class="select2-blue">
                                            <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoAR[]" id="select_encargadoA"></select>
                                        </div>
                                    </div>
                                </div>-->
                                
                                <div class="form-group col-md-6">
                                    <label>¿El acta necesita de aprobación?: </label><br>
                                    <input type="radio" id="radActa_si" name="radiobtnActa" value="si" required>
                                    <label for="cargo">Si</label>
                                    <input type="radio" id="radActa_no" name="radiobtnActa" value="no" required>
                                    <label for="usuarios">No</label>
                                    
                                    <div id="aprovar_regitros2A" style="display:none;">
                                        <input type="radio" id="rad_cargoAActa" name="rad_AActa" value="cargo">
                                        <label for="cargo">Cargo</label>
                                        <input type="radio" id="rad_usuarioAActa" name="rad_AActa" value="usuario">
                                        <label for="usuarios">Usuarios</label>
            
                                        
                                        <div class="select2-blue">
                                            <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoAR2[]" id="select_encargadoAR2"></select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>¿Acta abierta a todo público? : </label><br>
                                    <input type="radio" id="rad_si2" name="radiobtnP" value="si" required>
                                    <label for="cargo">Si</label>
                                    <input type="radio" id="rad_no2" name="radiobtnP" value="no" required>
                                    <label for="usuarios">No</label>
                                    
                                    <div id="aprovar_regitros2" style="display:none;">
                                        <input type="radio" id="rad_cargoA2" name="radiobtnP2" value="cargo">
                                        <label for="cargo">Cargo</label>
                                        <input type="radio" id="rad_usuarioA2" name="radiobtnP2" value="usuario">
                                        <label for="usuarios">Usuarios</label>
                                        <input type="radio" id="rad_grupo" name="radiobtnP2" value="grupo">
                                        <label for="usuarios">Grupos</label>
            
                                        
                                        <div class="select2-blue">
                                            <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoA2[]" id="select_encargadoA2"></select>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Convocados: </label><br>
                                    <input type="radio" id="rad_cargoC" name="radiobtnC" value="cargo">
                                    <label for="cargo">Cargo</label>
                                    <input type="radio" id="rad_usuarioC" name="radiobtnC" value="usuario">
                                    <label for="usuarios">Usuarios</label>
                                    <div class="select2-blue">
                                        <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoC[]" id="select_encargadoC" required></select>
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Asistentes: </label><br>
                                    <input type="radio" id="rad_cargoAsis" name="rad_Asis" value="cargo">
                                    <label for="cargo">Cargo</label>
                                    <input type="radio" id="rad_usuarioAsis" name="rad_Asis" value="usuario">
                                    <label for="usuarios">Usuarios</label>
                                    <div class="select2-blue">
                                        <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoAsis[]" id="select_encargadoAsis" required></select>
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-12">
                                    <label for="">Convocados Externos:</label>
                                    <?php //require_once'agregarMas.php'; ?>
                                    <div id="main">
                                        <table>
                                            <tr>
                                                <td>
                                                    <input type="button" id="btAdd" value="Añadir" class="form-control" />
                                                </td>
                                                <!-- <td>
                                                    <input type="button" id="btRemove" value="Eliminar" class="form-control" />
                                                </td> -->
                                                <td>
                                                    <input type="button" id="btRemoveAll" value="Eliminar Todo" class="form-control" />
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

                                    <script>
                                    $(document).ready(function() {
                                        var max_fields = 8;
                                        var wrapper = $(".container1");
                                        var add_button = $(".add_form_field");

                                        var x = 1;
                                        $(add_button).click(function(e) {
                                            e.preventDefault();
                                            if (x < max_fields) {
                                                x++;
                                                $(wrapper).append('<div><input type="text" id="mytext[]"/><a href="#" class="delete">Delete</a></div>'); //add input box
                                                $(wrapper).append('<div><select  id="mytext2[]"> </select><a href="#" class="delete">Delete</a></div>');
                                                $(wrapper).append('<div><input type="text" id="mytext3[]"/><a href="#" class="delete">Delete</a></div>');
                                                $(wrapper).append('<div><input type="text" id="mytext3[]"/><a href="#" class="delete">Delete</a></div>');
                                            } else {
                                                alert('You Reached the limits')
                                            }
                                        });

                                        $(wrapper).on("click", ".delete", function(e) {
                                            e.preventDefault();
                                            $(this).parent('div').remove();
                                            x--;
                                        })
                                    });
                                    </script>
                                    <!--  script para evento mas mas, Convocados externos -->
                                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                                    <script>
                                                                    $(document).ready(function() {
                                                                    var iCnt = 0;
                                                            
                                                            // Crear un elemento div a単adiendo estilos CSS
                                                                    var container = $(document.createElement('div')).css({
                                                                        padding: '0px', margin: '0px', width: '100%', border: '0px dashed',
                                                                        borderTopColor: '#999', borderBottomColor: '#999',
                                                                        borderLeftColor: '#999', borderRightColor: '#999'
                                                                    });
                                                            
                                                                    $('#btAdd').click(function() {
                                                                        if (iCnt <= 9) {
                                                            
                                                                            iCnt = iCnt + 1;
                                                            
                                                                            // A単adir caja de texto.
                                                                            $(container).append('<table><tr><th><input type=text class="form-control"  onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" placeholder="Convocados" name="convocadosEXT'+ iCnt + '" id=tb' + iCnt + ' ' +
                                                                                        ' ></th><th><select class="form-control" name="tipoEmpresaEXT'+ iCnt + '" id=tb' + iCnt + ' ' +'" required><option value="">Seleccionar...</option><option value="Cliente">Cliente</option><option value="Proveedor">Proveedor</option><option value="Cliente prospecto">Cliente prospecto</option><option value="Otro">Otro</option></select></th><th><input type=text class="form-control" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" placeholder="Nombre Empresa" name="nombreEmpresa'+ iCnt + '" id=tb' + iCnt + ' ' +' ></th><th><input type=text class="form-control" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" placeholder="Cargo"  name="cargoEXT'+ iCnt + '" id=tb' + iCnt + ' ' +' ><th></tr></table><br>');
                                                            
                                                                            if (iCnt == 1) {   
                                                            // funcion del ++ por cada click
                                                            var divSubmit = $(document.createElement('div'));
                                                                                $(divSubmit).append('<!-- <input type=button class="bt" onclick="GetTextValue()"' + 
                                                                                        'id=btSubmit value=Enviar /> -->');
                                                            
                                                                            }
                                                            
                                                            $('#main').after(container, divSubmit); 
                                                                        }
                                                                        else {      //se establece un limite para a単adir elementos, 20 es el limite
                                                                            
                                                                            $(container).append('<label> </label>'); 
                                                                            $('#btAdd').attr('class', 'form-control'); 
                                                                            $('#btAdd').attr('disabled', 'disabled');
                                                            
                                                                        }
                                                                    });
                                                            
                                                                    $('#btRemove').click(function() {   // Elimina un elemento por click
                                                                        if (iCnt != 0) { $('#tb' + iCnt).remove(); iCnt = iCnt - 1; }
                                                                    
                                                                        if (iCnt == 0) { $(container).empty(); 
                                                                    
                                                                            $(container).remove(); 
                                                                            $('#btSubmit').remove(); 
                                                                            $('#btAdd').removeAttr('disabled'); 
                                                                            $('#btAdd').attr('class', 'form-control') 
                                                            
                                                                        }
                                                                    });
                                                            
                                                                    $('#btRemoveAll').click(function() {    // Elimina todos los elementos del contenedor
                                                                    
                                                                        $(container).empty(); 
                                                                        $(container).remove(); 
                                                                        $('#btSubmit').remove(); iCnt = 0; 
                                                                        $('#btAdd').removeAttr('disabled'); 
                                                                        $('#btAdd').attr('class', 'form-control');
                                                            
                                                                    });
                                                                });
                                                            
                                                                // Obtiene los valores de los textbox al dar click en el boton "Enviar"
                                                                var divValue, values = '';
                                                            
                                                                function GetTextValue() {
                                                            
                                                                    $(divValue).empty(); 
                                                                    $(divValue).remove(); values = '';
                                                            
                                                                    $('.input').each(function() {
                                                                        divValue = $(document.createElement('div')).css({
                                                                            padding:'5px', width:'300px'
                                                                        });
                                                                        values += this.value + '<br />'
                                                                    });
                                                            
                                                                    $(divValue).append('<p><b>Tus valores añadidos</b></p>' + values);
                                                                    $('body').append(divValue);
                                                            
                                                                }
                                                        </script>
                                </div>
                                
                                
                                
                                <div class="form-group col-md-6">
                                
                                </div>
                                
                                
                        </div>
                        <!-- /.form-group -->
                    
                
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
                        
                        </div>
                    
                    </div>
                    </div>    

                <div class="col">
                    </div>
                    
                
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    
        <!-- ACTA-->
        <section class="content">
            <div class="container-fluid">
                    <div class="row">
                        <div class="col"></div>
                    
                    <div class="col-12">
                        <!-- Default box -->
                        <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Desarrollo del acta</h3>
            
                            
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <p>
                                <a style="color:white;" class="btn btn-primary float-right" onclick="window.open('uploadImg')"> Subir imagen</a>
                                </p>
                                <br>
                                <?php
                                    
                                    $queryEncabezado = $mysqli->query("SELECT * FROM encabezado WHERE principal = '1'");
                                    $encabezado = $queryEncabezado->fetch_array(MYSQLI_ASSOC);
                                    $enviarEncabezadoActivo=$encabezado['encabezado'];
                                    $enviarIdEncabezadoActivo=$encabezado['id'];
                                    
                                    $idPlantilla = $_POST['idPlantilla'];
                                    
                                if($idPlantilla == NULL){
                                /// si no ha seleccionado un encabezado me pedirá seleccionar 1
                                if($enviarEncabezadoActivo == NULL){
                                    ?>
                                    <div class="form-group col-md-12">
                                        <center>
                                            
                                                <div class="modal-dialog">
                                                <div class="modal-content bg-danger">
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Alerta</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <p>Contacte al administrador para definir el encabezado.</p>
                                                    </div>
                                                <div class="modal-footer justify-content-between">
                                                </div>
                                                </div>
                                                </div>
                                        </center>
                                    </div>
                                    <?php
                                }else{
                                ?>
                                
                                    <div class="form-group col-md-12">  
                                        <input name="idEncabezado" type="hidden" value="<?php //echo $enviarIdEncabezadoActivo;?>" readonly required>
                                        <textarea id="editor1" name="editor1" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)"><?php //echo $enviarEncabezadoActivo;?></textarea>
                                    </div>
                                <?php
                                }
                                    /// end
                                
                                    }else{
                                        $datos = $mysqli->query("SELECT * FROM actasPlantilla WHERE id = '$idPlantilla'");
                                        $row = $datos->fetch_array(MYSQLI_ASSOC);
                                        $acta = $row['acta'];
                                        $actaID = $row['id'];
                                ?>
                                <div class="form-group col-md-12">
                                    <input name="idEncabezadoPlantilla" type="hidden" value="<?php echo $actaID;?>" readonly required>
                                    <textarea id="editor1" name="editor1" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)"><?php //echo $encabezado['encabezado'];?> <?php echo $acta; ?></textarea>
                                    <!--<textarea name="editor1" required><?php //echo $encabezado['encabezado']?> <?php //echo $acta; ?></textarea>-->
                                </div>
                                <?php
                                    }
                                if($enviarEncabezadoActivo == NULL){ }else{
                                ?>
                                
                                <div class="form-group col-md-12 text-center">
                                    <br>
                                    <label>¿Agregar compromisos?</label><br>
                                    <label ><input type="radio" name="radiobtnCom" id="radiobtnComSi" value="si" required> Si</label>
                                    <label ><input type="radio" name="radiobtnCom" id="radiobtnComNo" value="no" required> No</label>
                                    
                                    <div id="horaFin" name="horaFin" style="display:none;">
                                        <div class="row" >
                                            <label for="exampleInputPassword1">Fecha y hora de cierre:</label>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-clock" required></i></span>
                                                    </div>
                                                    <input type="date" class="form-control" id="fechaCierre" max="3000-01-01" name="fechafin" value=<?php echo 'aaaaaa';?> >
                                                </div>
                                            </div>
                                        
                                        
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                    </div>
                                                    <input type="time" name="horafin" class="form-control float-right" id="reservationtimeB" >
                                                </div>
                                                <!--
                                                <select name="horafin" class="form-control" >
                                                <option value="">Hora</option>
                                                <option value="0">12:00 am</option>
                                                <option value="1">1:00 am</option>
                                                <option value="2">2:00 am</option>
                                                <option value="3">3:00 am</option>
                                                <option value="4">4:00 am</option>
                                                <option value="5">5:00 am</option>
                                                <option value="6">6:00 am</option>
                                                <option value="7">7:00 am</option>
                                                <option value="8">8:00 am</option>
                                                <option value="9">9:00 am</option>
                                                <option value="10">10:00 am</option>
                                                <option value="11">11:00 am</option>
                                                <option value="12">12:00 pm</option>
                                                <option value="13">1:00 pm</option>
                                                <option value="14">2:00 pm</option>
                                                <option value="15">3:00 pm</option>
                                                <option value="16">4:00 pm</option>
                                                <option value="17">5:00 pm</option>
                                                <option value="18">6:00 pm</option>
                                                <option value="19">7:00 pm</option>
                                                <option value="20">8:00 pm</option>
                                                <option value="21">9:00 pm</option>
                                                <option value="22">10:00 pm</option>
                                                <option value="23">11:00 pm</option>
                                                </select>-->
                                            </div>
                                            <!--
                                            <div class="col-md-3">
                                                <select name="minutofin" class="form-control" >
                                                    <option value="">Minuto</option>
                                                    <?php
                                                        /*
                                                        $minuto = 0;
                                                        for($i=0;$i <= 59;$i++){
                                                            echo "<option value='$i'>$i</option>";
                                                        } */
                                                    ?>
                                                </select>
                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>    
                                
                                
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <?php
                        /// si no se ha asignado un encabezado bloqueo
                        if($enviarEncabezadoActivo == NULL){ }else{
                        ?>
                        <div class="card-footer">
                            <button type="submit" name="siguiente" class="btn btn-primary float-right" id=""> >> Siguiente</button>
                        </div>
                        <?php
                        }
                        ?>
                        <!-- /.card-footer-->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col"></div>
                    </div>
                
            </div>
        </section>
        <!-- ACTA-->
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
<!--Select dinamico-->
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
    $(document).ready(function(){
        $('#rad_cargoR').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoR").html(data);
            }); 
        });
        $('#rad_usuarioR').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoR").html(data);
            }); 
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('#rad_si').click(function(){
            document.getElementById('aprovar_regitros').style.display = '';
        });
        $('#rad_no').click(function(){
            document.getElementById('aprovar_regitros').style.display = 'none';
        });
    });
</script>
<!--Select dinamico-->
<script>
    $(document).ready(function(){
        $('#rad_cargoA').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoA").html(data);
            }); 
        });
        $('#rad_usuarioA').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoA").html(data);
            }); 
        });
    });
</script>
<!--CONVOCADOS-->
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
<!--ASISTENTES-->
<script>
    $(document).ready(function(){
        $('#rad_cargoAsis').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoAsis").html(data);
            }); 
        });
        $('#rad_usuarioAsis').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoAsis").html(data);
            }); 
        });
    });
</script>
<!--RESPONSABLES-->
<script>
    $(document).ready(function(){
        
        
        $('#agregaCompromiso').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoRes").html(data);
            }); 
        });
        $('#rad_usuarioRes').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoRes").html(data);
            }); 
        });
    });
</script>
<!--RESPONSABLES-->

<!--ENTREGAR A -->
<script>
    /*$(document).ready(function(){
        usuario = "usuario";
        $.post("selectDocumentos2.php", { rad_usuario: usuario }, function(data){
                $("#select_encargadoEntrega").html(data);
        });
        
        $.post("selectDocumentos2.php", { rad_usuario: usuario }, function(data){
                $("#select_encargadoCom").html(data);
        });
        
        $('#agregaCompromiso').click(function(){
            alert("Dio click");
            usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: usuario }, function(data){
                $("#select_encargadoEntrega").html(data);
            });
            
            $.post("selectDocumentos2.php", { rad_usuario: usuario }, function(data){
                $("#select_encargadoCom").html(data);
            });
            
        });
    });*/
</script>
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
<!--Aprobacion del acta-->
<script>
    $(document).ready(function(){
        $('#radActa_si').click(function(){
            document.getElementById('aprovar_regitros2A').style.display = '';
        });
        $('#radActa_no').click(function(){
            document.getElementById('aprovar_regitros2A').style.display = 'none';
        });
    });
</script>
<!--Select dinamico-->
<script>
    $(document).ready(function(){
        $('#rad_cargoAActa').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoAR2").html(data);
            }); 
        });
        $('#rad_usuarioAActa').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoAR2").html(data);
            }); 
        });

    });
</script>


<!--ACTA finalizada-->
<script>
    $(document).ready(function(){
        $('#radiobtnComSi').click(function(){
            document.getElementById('horaFin').style.display = 'none';
            document.getElementById("fechaCierre").removeAttribute("required","any");
            document.getElementById("reservationtimeB").removeAttribute("required","any");
        });
        $('#radiobtnComNo').click(function(){
            document.getElementById('horaFin').style.display = ''; 
            document.getElementById("fechaCierre").setAttribute("required","any");
            document.getElementById("reservationtimeB").setAttribute("required","any");
        });
    });
</script>
<!--Select dinamico-->
<script>
    $(document).ready(function(){
        $('#rad_cargoAActa').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoAR2").html(data);
            }); 
        });
        $('#rad_usuarioAActa').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoAR2").html(data);
            }); 
        });

    });
</script>
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>

<!--Ckeditor-->
<script src="ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor1')
</script>
<script>
//    CKEDITOR.replace( 'editor1' );
</script>
<!-- Summernote -->
<script src="../plugins/summernote/summernote-bs4.min.js"></script>
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote()
  })
</script>
<!--Agregar compromisos-->
<script type="text/javascript">
$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><label>Compromiso/Tareas</label><br><input type="text" class="form-control" name="compromisos[]" placeholder="Compromiso"><label>Responsable: </label><br><div class="select2-blue"><select class="select2" multiple="multiple" data-placeholder="Seleccione encargado compromiso" style="width: 100%;" name="select_encargadoCom[]" id="select_encargadoCom" required><?php while($usuario = $usuarios->fetch_assoc()){ echo "<option value='".$usuario['id']."'>".$usuario['nombres']." ".$usuario['apellidos']."</option>"; } ?></select></div><label for="exampleInputPassword1">Fecha Entrega:</label><input type="datetime-local" class="form-control" name="fechaEntrega" placeholder=""><label>Entregar A: </label><br><div class="select2-blue"><select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoEntrega[]" id="select_encargadoEntrega" required><?php while($usuario = $usuarios->fetch_assoc()){ echo "<option value='".$usuario['id']."'>".$usuario['nombres']." ".$usuario['apellidos']."</option>"; } ?></select></div><br><a href="javascript:void(0);" class="remove_button"><i class="fas fa-plus"></i></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>



</body>
</html>
<?php
}
?>