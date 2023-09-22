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
  <title>FIXWEI</title>
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
  <!--CKeditor-->
  <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
</head>
<body class="hold-transition sidebar-mini">
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
            <h1>Asignar Acta</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Actualizar Acta</li>
            </ol>
          </div>
        </div>
        
      </div><!-- /.container-fluid -->
    </section>
    <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="actas"><font color="white"><i class="fas fa-list"></i> Listar Actas</font></a></button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    
                </div>
                
           
            </div><br>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col-1">
            </div>
            <div class="col-4">
                <div class="row">
                    <div class="col">
                        <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Nueva Acta</h3>
                  </div>
                  <!-- /.card-header -->
                  <?php
                    $idActa = $_POST['idActa'];
                    $nombrePlantilla = $_POST['id'];
                    
                     $acta = $mysqli->query("SELECT * FROM actas WHERE id = '$idActa' ");
                    while($col = $acta->fetch_assoc()) { 
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
                    }
                  ?>
                  
                  
                  
                  
                  
                  <!-- form start -->
                  <form role="form" action="controlador/actas/controller" method="POST">
                    <div class="card-body">
                      <div class="form-group">
                        <label for="">Nombre:</label>
                        <input type="text" class="form-control" name="nombre" value="<?php echo $nombreActa;?>" >
                      </div>
                      <div class="form-group">
                        <label>Proceso:</label>
                        <select name="proceso" id="cbx_cedi" class="form-control">
                         <?php
                         require 'conexion/bd.php';
                         $resultado = $mysqli->query("SELECT * FROM procesos where id = '$proceso'");
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
                      <div class="form-group">
                        <label for="exampleInputPassword1">Ubicación:</label>
                        <input type="text" class="form-control" name="ubicacion" value="<?php echo $ubicacion;?>" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Fecha y hora de inicio:</label><br>
                        <p><?php echo $fechaini;?></p> 
                        <input type="datetime-local" class="form-control" name="fechainicio" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Fecha y hora de cierre:</label><br>
                        <p><?php echo $fechaCierre;?></p>
                        <input type="datetime-local" class="form-control" name="fechafin" placeholder="">
                      </div>
                      <div class="form-group col-sm-6">
                          
                              <label>Quién Cita: </label><br>
                              
                                  <p>
                                <?php 
                                if($quienCita == 'usuario'){
                                    
                                    echo "Usuario(s) - ";
                                    
                                    for($i=0; $i<$longitud; $i++){
                                        
                                        $nombreuser = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$quienCitaID[$i]'");
                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo $columna['nombres']." ".$columna['apellidos'];echo "<br>";
                                     
                                    }
                                 
                                }else{
                                    echo "Cargo(s) - ";
                                    
                                    for($i=0; $i<$longitud; $i++){
                                    $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienCitaID[$i]'");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    echo $columna['nombreCargos'];echo "<br>";
                                    }
                                }
                                
                                ?>
                                
                            </p>
                              
                                  
                                
                                <input type="radio" id="rad_cargoE" name="radiobtn" value="cargo">
                                <label for="cargo">Cargo</label>
                                <input type="radio" id="rad_usuarioE" name="radiobtn" value="usuario">
                                <label for="usuarios">Usuarios</label>

                            
                                <div class="select2-blue">
                                    <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoE[]" id="select_encargadoE" required></select>
                             
                                </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Quién Elabora: </label><br>
                            <p>
                                <?php 
                                if($quienElabora == 'usuario'){
                                    echo "Usuario(s) - ";
                                    
                                    for($i=0; $i<$longitud2; $i++){
                                        
                                        $nombreuser2 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$quienElaboraID[$i]'");
                                        $columna2 = $nombreuser2->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo $columna2['nombres']." ".$columna2['apellidos'];echo "<br>";
                                     
                                    }
                                 
                                }else{
                                    echo "Cargo(s) - ";
                                    
                                    for($i=0; $i<$longitud2; $i++){
                                    $nombrecargo2 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienElaboraID[$i]'");
                                    $columna2 = $nombrecargo2->fetch_array(MYSQLI_ASSOC);
                                    echo $columna2['nombreCargos'];echo "<br>";
                                    }
                                }
                                
                                ?>
                                
                            </p>
                            <input type="radio" id="rad_cargoR" name="radiobtn2" value="cargo">
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioR" name="radiobtn2" value="usuario">
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoR[]" id="select_encargadoR" required></select>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Los compromisos del acta requieren aprobacion? : </label><br>
                             <?php
                            if($aprobacion == 'si'){
                                echo "Si";
                            ?>
                            
                            
                            <p>
                                <?php 
                                if($compromisos == 'usuario'){
                                    
                                    for($i=0; $i<$longitud3; $i++){
                                        
                                        $nombreuser3 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$compromisosID[$i]'");
                                        $columna3 = $nombreuser3->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo $columna3['nombres']." ".$columna3['apellidos'];echo "<br>";
                                     
                                    }
                                 
                                }else{
                                    
                                    for($i=0; $i<$longitud3; $i++){
                                    $nombrecargo3 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$compromisosID[$i]'");
                                    $columna3 = $nombrecargo3->fetch_array(MYSQLI_ASSOC);
                                    echo $columna3['nombreCargos'];echo "<br>";
                                    }
                                }
                                
                                ?>
                                
                            </p>
                            <?php
                            }else{
                                echo "No";
                            }
                            ?>
                            
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
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Convocados: </label><br>
                            <p>
                                <?php 
                                if($convocados == 'usuario'){
                                    echo "Usuario(s) - ";
                                    
                                    for($i=0; $i<$longitud4; $i++){
                                        
                                        $nombreuser4 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$convocadosID[$i]'");
                                        $columna4 = $nombreuser4->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo $columna4['nombres']." ".$columna4['apellidos'];echo "<br>";
                                     
                                    }
                                 
                                }else{
                                    echo "Cargo(s) - ";
                                    
                                    for($i=0; $i<$longitud4; $i++){
                                    $nombrecargo4 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$convocadosID[$i]'");
                                    $columna4 = $nombrecargo4->fetch_array(MYSQLI_ASSOC);
                                    echo $columna2['nombreCargos'];echo "<br>";
                                    }
                                }
                                
                                ?>
                                
                            </p>
                            <input type="radio" id="rad_cargoC" name="radiobtnC" value="cargo">
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioC" name="radiobtnC" value="usuario">
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoC[]" id="select_encargadoC" required></select>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Asistentes: </label><br>
                            <p>
                                <?php 
                                if($asistentes == 'usuario'){
                                    echo "Usuario(s) - ";
                                    
                                    for($i=0; $i<$longitud5; $i++){
                                        
                                        $nombreuser5 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$asistentesID[$i]'");
                                        $columna5 = $nombreuser5->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo $columna5['nombres']." ".$columna5['apellidos'];echo "<br>";
                                     
                                    }
                                 
                                }else{
                                    echo "Cargo(s) - ";
                                    for($i=0; $i<$longitud5; $i++){
                                    $nombrecargo5 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$asistentesID[$i]'");
                                    $columna5 = $nombrecargo5->fetch_array(MYSQLI_ASSOC);
                                    echo $columna5['nombreCargos'];echo "<br>";
                                    }
                                }
                                
                                ?>
                                
                            </p>
                            <input type="radio" id="rad_cargoAsis" name="rad_Asis" value="cargo">
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioAsis" name="rad_Asis" value="usuario">
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoAsis[]" id="select_encargadoAsis" required></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- se trae script para agregar con evento más más junto al click de añadir -->
                            <label for="">Convocados Externos:</label>
                             <div class="row">
                        <div class="col-3">   
                        <label for="">Nombres:</label><br>
                        <?php
                        $arrayConvocados = explode(',',$jsonConvocado);
                        foreach($arrayConvocados as $convocado){
  
                            if($convocado == ''){
                                continue;
                            }else{
                              echo $convocado;echo"<br>";  
                            }
                            
                        }
                        
                        ?>
                        </div>
                        <div class="col-3">
                        <label for="">Tipos Empresa:</label><br>
                        <?php
                        $arrayTipo = explode(',',$jsonTipo);
                        foreach($arrayTipo as $tipo){
  
                            if($tipo == ''){
                                continue;
                            }else{
                              echo $tipo;echo"<br>";  
                            }
                            
                        }
                        
                        ?>
                        </div>
                        <div class="col-3">
                        <label for=""> Empresa:</label><br>
                        <?php
                        $arrayEmpresaNombre = explode(',',$jsonNombre);
                        foreach($arrayEmpresaNombre as $nombreE){
  
                            if($nombreE == ''){
                                continue;
                            }else{
                              echo $nombreE;echo"<br>";  
                            }
                            
                        }
                        
                        
                        ?>
                        </div>
                        <div class="col-3">
                        <label for="">Cargo:</label><br>
                        <?php
                        $arrayCargos = explode(',', $jsonCargo);
                        //print_r($arrayCargos);
                        //echo $longitud9;
                        foreach($arrayCargos as $cargo){
  
                            if($cargo == ''){
                                continue;
                            }else{
                              echo $cargo;echo"<br>";  
                            }
                            
                        }
                        
                        ?>
                        </div>
                        </div>
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
                                                                    $(container).append('<input type=text class="form-control"  placeholder="Convocados" name="convocadosEXT'+ iCnt + '" id=tb' + iCnt + ' ' +
                                                                                ' ><select class="form-control" name="tipoEmpresaEXT'+ iCnt + '" id=tb' + iCnt + ' ' +'" required><option value="0">Seleccionar...</option><option value="cliente">Cliente</option><option value="proveedor">Proveedor</option><option value="clienteProspecto">Cliente prospecto</option><option value="otro">Otro</option></select><input type=text class="form-control" placeholder="Nombre Empresa" name="nombreEmpresa'+ iCnt + '" id=tb' + iCnt + ' ' +' ><input type=text class="form-control" placeholder="Cargo"  name="cargoEXT'+ iCnt + '" id=tb' + iCnt + ' ' +' ><br>');
                                                    
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
                                                                    $('#btAdd').attr('class', 'bt-disable'); 
                                                                    $('#btAdd').attr('disabled', 'disabled');
                                                    
                                                                }
                                                            });
                                                    
                                                            $('#btRemove').click(function() {   // Elimina un elemento por click
                                                                if (iCnt != 0) { $('#tb' + iCnt).remove(); iCnt = iCnt - 1; }
                                                            
                                                                if (iCnt == 0) { $(container).empty(); 
                                                            
                                                                    $(container).remove(); 
                                                                    $('#btSubmit').remove(); 
                                                                    $('#btAdd').removeAttr('disabled'); 
                                                                    $('#btAdd').attr('class', 'bt') 
                                                    
                                                                }
                                                            });
                                                    
                                                            $('#btRemoveAll').click(function() {    // Elimina todos los elementos del contenedor
                                                            
                                                                $(container).empty(); 
                                                                $(container).remove(); 
                                                                $('#btSubmit').remove(); iCnt = 0; 
                                                                $('#btAdd').removeAttr('disabled'); 
                                                                $('#btAdd').attr('class', 'bt');
                                                    
                                                            });
                                                        });
                                                    
                                                        // Obtiene los valores de los textbox al dar click en el boton "Enviar"
                                                        var divValue, values = '';
                                                    
                                                        function GetTextValue() {
                                                    
                                                            $(divValue).empty(); 
                                                            $(divValue).remove(); values = '';
                                                    
                                                            $('.input').each(function() {
                                                                divValue = $(document.createElement('div')).css({
                                                                    padding:'5px', width:'200px'
                                                                });
                                                                values += this.value + '<br />'
                                                            });
                                                    
                                                            $(divValue).append('<p><b>Tus valores a単adidos</b></p>' + values);
                                                            $('body').append(divValue);
                                                    
                                                        }
                                                </script>
<!-- Fin -->
                            <!-- Fin proceso -->
                            
                        
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Acta abierta a todo publico? : </label><br>
                            <?php
                            if($publico == 'no'){
                                echo "No";
                            ?>
                            <br>
                            <label>Respondables : </label><br>
                            <p>
                                <?php 
                                if($permisoActa == 'usuario'){
                                    echo"Usuario(s) - ";
                                    
                                    for($i=0; $i<$longitud10; $i++){
                                        
                                        
                                        $nombreuser6 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$responsablesID[$i]'");
                                        $columna6 = $nombreuser6->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo $columna6['nombres']." ".$columna6['apellidos'];echo "<br>";
                                     
                                    }
                                 
                                }elseif($permisoActa == 'grupo'){
                                    echo"Grupo(s) - ";
                                    
                                    
                                    for($i=0; $i<$longitud10; $i++){
                                    $nombrecargo6 = $mysqli->query("SELECT nombre FROM grupo WHERE id = '$responsablesID[$i]'");
                                    $columna6 = $nombrecargo6->fetch_array(MYSQLI_ASSOC);
                                    echo $columna6['nombre'];echo "<br>";
                                    }
                                }
                                else{
                                    
                                    echo"Cargo(s) - ";
                                    for($i=0; $i<$longitud10; $i++){
                                    $nombrecargo6 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$responsablesID[$i]'");
                                    $columna6 = $nombrecargo6->fetch_array(MYSQLI_ASSOC);
                                    echo $columna6['nombreCargos'];echo "<br>";
                                    }
                                }
                                
                                ?>
                                
                            </p>
                            <?php
                            }else{
                                echo "No!";
                            }
                            ?>
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
                        
                        
                    </div>
                    <!-- /.card-body -->
  
                </div>
                    </div>
                   </div>
                   </div>
                   

                    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            
            <div class="col-12">
                
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
            <?php  
            
            
            
                if($nombrePlantilla != NULL){
                    
                
                $datos = $mysqli->query("SELECT acta FROM actasPlantilla WHERE id = '$nombrePlantilla'");
                $row = $datos->fetch_array(MYSQLI_ASSOC);
                $acta = $row['acta'];
            
            ?>
            <div class="form-group">
                <label>Desarrollo de la plantilla: </label><br>
                <div class="form-group ">
                    <textarea name="editor1" required><?php echo $acta; ?></textarea>
                </div>
            </div>
            <?php }else{ ?>

                  <div class="form-group">
                    <label>Desarrollo del acta: </label><br>
                       <div class="form-group ">
                            <textarea name="editor1" required><?php echo $editor; ?></textarea>
                        </div>
                  </div>
                  <?php } ?>
                  
                  <!-- se agrega otro modelo de agregar varios formularios -->
                    <div class="form-group">
                        <label for="exampleInputPassword1">Compromiso/Tareas</label>
                        <input type="text" class="form-control" name="compromisos" value="<?php echo $compromiso;?>" placeholder="compromiso">
                      </div>
                        <div class="form-group col-sm-6">
                            <label>Responsable: </label><br>
                            <p>
                                <?php 
                                if($responsableCompromiso == 'usuario'){
                                    echo"Usuario(s) - ";
                                    for($i=0; $i<$longitud11; $i++){
                                        
                                        $nombreuser11 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$responsableCompromisoID[$i]'");
                                        $columna11 = $nombreuser11->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo $columna11['nombres']." ".$columna11['apellidos'];echo "<br>";
                                     
                                    }
                                 
                                }else{
                                    echo"Cargo(s) - ";
                                    for($i=0; $i<$longitud11; $i++){
                                    $nombrecargo11 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$responsableCompromisoID[$i]'");
                                    $columna11 = $nombrecargo11->fetch_array(MYSQLI_ASSOC);
                                    echo $columna11['nombreCargos'];echo "<br>";
                                    }
                                }
                                
                                ?>
                                
                            </p>
                            <input type="radio" id="rad_cargoRes" name="rad_Res" value="cargo">
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioRes" name="rad_Res" value="usuario">
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoRes[]" id="select_encargadoRes" required></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Fecha Entrega:</label>
                            <p><?php echo $fechaPrimera;?></p>
                            <input type="datetime-local" class="form-control" name="fechaEntrega" placeholder="">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Entregar A: </label><br>
                            <p>
                                <?php 
                                if($entregarA == 'usuario'){
                                    echo"Usuario(s) - ";
                                    
                                    for($i=0; $i<$longitud12; $i++){
                                        
                                        $nombreuser12 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$entregarAID[$i]'");
                                        $columna12 = $nombreuser12->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo $columna12['nombres']." ".$columna12['apellidos'];echo "<br>";
                                     
                                    }
                                 
                                }else{
                                    echo"Cargo(s) - ";
                                    for($i=0; $i<$longitud12; $i++){
                                    $nombrecargo12 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$entregarAID[$i]'");
                                    $columna12 = $nombrecargo12->fetch_array(MYSQLI_ASSOC);
                                    echo $columna12['nombreCargos'];echo "<br>";
                                    }
                                }
                                
                                ?>
                                
                            </p>
                            <input type="radio" id="rad_cargoEntrega" name="rad_Entrega" value="cargo">
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioEntrega" name="rad_Entrega" value="usuario">
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoEntrega[]" id="select_encargadoEntrega" required></select>
                            </div>
                        </div>
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                        <div id="main2">
            									    <table>
            									        <tr>
            									            <td>
            									                <input type="button" id="btAdd2" value="Añadir" class="form-control" />
            									            </td>
            									            <td>
            									                <input type="button" id="btRemoveAll2" value="Eliminar" class="form-control" />
            									            </td>
            									        </tr>
            									    </table>
                                                </div>
                                                <script>
                                                            $(document).ready(function() {
                                                            var iCnt = 0;
                                                    
                                                    // Crear un elemento div añadiendo estilos CSS
                                                            var container = $(document.createElement('div')).css({
                                                                padding: '5px', margin: '20px', width: '570px', border: '1px dashed',
                                                                borderTopColor: '#999', borderBottomColor: '#999',
                                                                borderLeftColor: '#999', borderRightColor: '#999'
                                                            });
                                                    
                                                            $('#btAdd2').click(function() {
                                                                if (iCnt <= 4) {
                                                    
                                                                    iCnt = iCnt + 1;
                                                    
                                                                    // Añadir caja de texto.
                                                                    $(container).append('<div class="form-group"><label for="">Compromiso/Tareas</label><input type="text" class="form-control" name="compromisos'+ iCnt + '" id=tb' + iCnt + ' ' + ' placeholder="compromiso"></div><div class="form-group col-sm-6"><label>Responsable: </label><br><input type="radio" id="rad_cargoRes" name="rad_Res'+ iCnt + '" id=tb' + iCnt + ' ' + ' value="cargo"><label for="cargo">Cargo</label><input type="radio" id="rad_usuarioRes" name="rad_Res'+ iCnt + '" id=tb' + iCnt + ' ' + ' value="usuario"><label for="usuarios">Usuarios</label><div class=""><select class="" multiple="" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoRes[]'+ iCnt + '" id=tb' + iCnt + ' ' + ' id="select_encargadoRes" required></select></div></div>');
                                                    
                                                    
                                                    
                                                                    if (iCnt == 1) {   
                                                    
                                                     var divSubmit = $(document.createElement('div'));
                                                                        $(divSubmit).append('<!-- <input type=button class="bt" onclick="GetTextValue()"' + 
                                                                                'id=btSubmit value=Enviar /> -->');
                                                    
                                                                    }
                                                    
                                                     $('#main2').after(container, divSubmit); 
                                                                }
                                                                else {      //se establece un limite para añadir elementos, 20 es el limite
                                                                    
                                                                    $(container).append('<label>Limite Alcanzado</label>'); 
                                                                    $('#btAdd').attr('class', 'bt-disable'); 
                                                                    $('#btAdd').attr('disabled', 'disabled');
                                                    
                                                                }
                                                            });
                                                    
                                                            $('#btRemove').click(function() {   // Elimina un elemento por click
                                                                if (iCnt != 0) { $('#tb' + iCnt).remove(); iCnt = iCnt - 1; }
                                                            
                                                                if (iCnt == 0) { $(container).empty(); 
                                                            
                                                                    $(container).remove(); 
                                                                    $('#btSubmit').remove(); 
                                                                    $('#btAdd').removeAttr('disabled'); 
                                                                    $('#btAdd').attr('class', 'bt') 
                                                    
                                                                }
                                                            });
                                                    
                                                            $('#btRemoveAll2').click(function() {    // Elimina todos los elementos del contenedor
                                                            
                                                                $(container).empty(); 
                                                                $(container).remove(); 
                                                                $('#btSubmit').remove(); iCnt = 0; 
                                                                $('#btAdd').removeAttr('disabled'); 
                                                                $('#btAdd').attr('class', 'bt');
                                                    
                                                            });
                                                        });
                                                    
                                                        // Obtiene los valores de los textbox al dar click en el boton "Enviar"
                                                        var divValue, values = '';
                                                    
                                                        function GetTextValue() {
                                                    
                                                            $(divValue).empty(); 
                                                            $(divValue).remove(); values = '';
                                                    
                                                            $('.input').each(function() {
                                                                divValue = $(document.createElement('div')).css({
                                                                    padding:'5px', width:'200px'
                                                                });
                                                                values += this.value + '<br />'
                                                            });
                                                    
                                                            $(divValue).append('<p><b>Tus valores añadidos</b></p>' + values);
                                                            $('body').append(divValue);
                                                    
                                                        }
                                                </script>
                    <!-- Fin se agrega otro modelo de agregar varios formularios -->
              </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                  <button type="submit" name="actualizarActa" class="btn btn-primary float-right">Submit</button>
                </div>
              </form>
            </div>
            </div>    

        
            
           
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
               
                    
                    
               
                
                    
                    
                    
                    
            
            
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
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<script>
    $(function () {
        $('.selectpicker').selectpicker();
    });
</script>
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
        $('#rad_cargoRes').click(function(){
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
<!--ENTREGAR A -->
<script>
    $(document).ready(function(){
        $('#rad_cargoEntrega').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoEntrega").html(data);
            }); 
        });
        $('#rad_usuarioEntrega').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoEntrega").html(data);
            }); 
        });
    });
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
<!--Ckeditor-->
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
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>

</body>
</html>
<?php
}
?>