<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

//$formulario = 'solicitudCom'; //Se cambia el nombre del formulario
//require_once 'permisosPlataforma.php';
//////////////////////PERMISOS//////////////////////// 

?>
<!DOCTYPE html>
<html>
    <title>Evaluación</title>
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
            <h1>Evaluación</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Evaluación</li>
            </ol>
          </div>
        </div>
        <div class="col-sm-6">
        
      </div><!-- /.container-fluid -->
     </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
          <div class="col">
              <div class="row">
                <div class="col-9">
                    <div class="row">
                        <div class="col-sm">
                          <button  type="button" class="btn btn-block btn-info btn-sm"><a href="evaluacion"><font color="white"><i class="fas fa-list"></i> Listar evaluaciones</font></a></button>
                        </div>
                        <div class="col-sm" id="DivMaterial">
                              <span id="botonMaterial" class="btn btn-block btn-info btn-sm"><font color="white"><i class="fas fa-list"></i> Materiales </font></span>
                        </div>
                        <div class="col-sm" id="DivPregunta"  style="display:none;">
                              <span id="botonPregunta" class="btn btn-block btn-info btn-sm"><font color="white"><i class="fas fa-list"></i> Preguntas </font></span>
                        </div>
                        <div class="col-sm" id="visualizarDocumentos">
                            <span id="botonVisualizar" class="btn btn-block btn-info btn-sm"><font color="white"><i class="fas fa-list"></i> Documentos </font></span>
                        </div>
                        <div class="col-sm">
                        
                        </div>
                </div>
                 
                
          
            </div>

          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
      </div>
    </section>
     
    <section class="content-header">
         <div class="container-fluid">
            <div class="row">
                <div class="col-sm">
               
               
                           
                </div>
            </div>  
        </div>      
        <div class="row">
           
          <!-- /.col (LEFT) -->
          <div class="col-md-12">
            <!-- LINE CHART -->
            
            <div class="card card-info" id="formularios">
                <div class="card-header">
                    <?php
                    // traemos la evaluación vigente
                    if(isset($_POST['idEvaluacion'])){ 
                        $consultaEvaluacion=$mysqli->query("SELECT * FROM evaluacion WHERE id='".$_POST['idEvaluacion']."'  ");
                        echo '<h3 class="card-title">Editar formulario </h3>';
                    }else{
                        echo '<h3 class="card-title">Formulario </h3>';
                        $consultaEvaluacion=$mysqli->query("SELECT * FROM evaluacion WHERE idUsuario='$idparaChat' AND estado='proceso' ");
                    }
                    
                    $extraerConsultaEvaluacion=$consultaEvaluacion->fetch_array(MYSQLI_ASSOC);
                    $nombreEvaluacionIDP=$extraerConsultaEvaluacion['id'];
                    $nombreEvaluacion=$extraerConsultaEvaluacion['nombre'];
                    $encabezadoEvaluacion=$extraerConsultaEvaluacion['encabezado'];
                    $estadoEvaluacion=$extraerConsultaEvaluacion['estado'];
                    
                    
                    
                    $ancho=120; 
                    $cadena=$encabezadoEvaluacion;//$row['definicion'];

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
                    
                </div>
                <div class="card-body">
                    
                    
                         
                   
                        <form method="post" action="controlador/evaluacion/controllerEvaluacion">
                            <?php
                            ////// rescatamos el id del editar para mantener la variable activa
                            if($_POST['idEvaluacion'] != NULL){
                            ?>
                            <input name="idEvaluacion" id="idEvaluacionEditar" value="<?php echo $_POST['idEvaluacion'];?>" type="hidden">
                            <?php
                            }
                            /// end
                            ?>
                            <input name="usuario" value="<?php echo $idparaChat;?>" type="hidden">
                            <div class="row">
                                <div class="form-group col-sm">
                                <input type="text" placeholder="Formulario sin título" value="<?php echo $nombreEvaluacion;?>" name="titulo" class="form-control" style="width:;" required>   
                                <br>
                                <textarea type="text" cols='<?php echo $ancho;?>' rows='<?php echo $lineas;?>' placeholder="Descripción del formulario..." class="form-control"  id="js-encabezado" name="descripcion"  required><?php echo $cadena;?></textarea>
                                </div>
                            </div>
                            <br><br>
                            
                            <div class="row">
                                <div class="form-group col-sm-6">
                                 <textarea type="text" placeholder="Pregunta sin título" name="pregunta" class="form-control" style="width:;" ></textarea>
                                 <br>
                                 <input style="width:50%;" name="puntajeCalificacion" type="number" min="1" class="form-control" placeholder="Puntaje..." required> 
                                 <br><br>
                                </div>
                                <div class="form-group col-sm-6">
                                 <select class="form-control" id="tipoPregunta" name="tipoPregunta" onchange="ShowSelectedOption();" >
                                     <option value=""></option>
                                     <option value="1">Abierta</option>
                                     <option value="2">Si ó No</option>
                                     <option value="3">Multiple</option>
                                     <option value="4">Completa ó única respuesta</option>
                                     <option value="5">Relacionar</option>
                                 </select>
                                </div>
                            </div>
                            
                            
                            <div class="row" id="habilitarRespuestaSiNo" style="display:none;">
                                <div class="form-group col-sm-6">
                                    Si
                                    <input type="radio" name="SiNo" value="Si">
                                    &nbsp;
                                    No
                                    <input type="radio" name="SiNo" value="No">
                                </div>
                            </div>
                            <div class="row" id="habilitarRespuestaMultiple" style="display:none;">
                                <div class="form-group col-sm-6">
                                   <div id="main"> Agregar las preguntas con múltiple respuesta<br><br>
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
                                                            
                                                            // Crear un elemento div añadiendo estilos CSS
                                                                    var container = $(document.createElement('div')).css({
                                                                        padding: '0px', margin: '0px', width: '100%', border: '0px dashed',
                                                                        borderTopColor: '#999', borderBottomColor: '#999',
                                                                        borderLeftColor: '#999', borderRightColor: '#999'
                                                                    });
                                                            
                                                                    $('#btAdd').click(function() {
                                                                        if (iCnt <= 4) {
                                                            
                                                                            iCnt = iCnt + 1;
                                                            
                                                                            // Añadir caja de texto.
                                                                            $(container).append('<br>'+ iCnt +'. <textarea type=text class="form-control" placeholder="Digíte la opción" name="opciones'+ iCnt + '" id=tb' + iCnt + ' ' +' ></textarea>Seleccionar el correcto <input type="checkbox"  name="correcto'+ iCnt + '" id=tb' + iCnt + ' ' +' ><br>');
                                                            
                                                                            if (iCnt == 1) {   
                                                            // funcion del ++ por cada click
                                                            var divSubmit = $(document.createElement('div'));
                                                                                $(divSubmit).append('<!-- <input type=button class="bt" onclick="GetTextValue()"' + 
                                                                                        'id=btSubmit value=Enviar /> -->');
                                                            
                                                                            }
                                                            
                                                            $('#main').after(container, divSubmit); 
                                                                        }
                                                                        else {      //se establece un limite para añadir elementos, 20 es el limite
                                                                            
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
                            </div>
                            <div class="row" id="habilitarRespuestaCompleta" style="display:none;">
                                <div class="form-group col-sm-6">
                                   <div id="mainCompleta"> Agregar las preguntas con única respuesta<br><br>
                                        <table>
                                            <tr>
                                                <td>
                                                    <input type="button" id="btAddCompleta" value="Añadir" class="form-control" />
                                                </td>
                                                <td>
                                                    <input type="button" id="btRemoveAllCompleta" value="Eliminar Todo" class="form-control" />
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
                                                            
                                                            // Crear un elemento div añadiendo estilos CSS
                                                                    var container = $(document.createElement('div')).css({
                                                                        padding: '0px', margin: '0px', width: '100%', border: '0px dashed',
                                                                        borderTopColor: '#999', borderBottomColor: '#999',
                                                                        borderLeftColor: '#999', borderRightColor: '#999'
                                                                    });
                                                            
                                                                    $('#btAddCompleta').click(function() {
                                                                        if (iCnt <= 4) {
                                                            
                                                                            iCnt = iCnt + 1;
                                                            
                                                                            // Añadir caja de texto.
                                                                            $(container).append('<br>'+ iCnt +'. <textarea type=text class="form-control" placeholder="Digíte la opción" name="completa'+ iCnt + '" id=tb' + iCnt + ' ' +' ></textarea>Seleccionar el correcto <input type="radio"  name="correcto"  value="'+ iCnt + '" id=tb' + iCnt + ' ' +' ><br>');
                                                            
                                                                            if (iCnt == 1) {   
                                                            // funcion del ++ por cada click
                                                            var divSubmit = $(document.createElement('div'));
                                                                                $(divSubmit).append('<!-- <input type=button class="bt" onclick="GetTextValue()"' + 
                                                                                        'id=btSubmit value=Enviar /> -->');
                                                            
                                                                            }
                                                            
                                                            $('#mainCompleta').after(container, divSubmit); 
                                                                        }
                                                                        else {      //se establece un limite para añadir elementos, 20 es el limite
                                                                            
                                                                            $(container).append('<label> </label>'); 
                                                                            $('#btAddCompleta').attr('class', 'form-control'); 
                                                                            $('#btAddCompleta').attr('disabled', 'disabled');
                                                            
                                                                        }
                                                                    });
                                                            
                                                                    $('#btRemove').click(function() {   // Elimina un elemento por click
                                                                        if (iCnt != 0) { $('#tb' + iCnt).remove(); iCnt = iCnt - 1; }
                                                                    
                                                                        if (iCnt == 0) { $(container).empty(); 
                                                                    
                                                                            $(container).remove(); 
                                                                            $('#btSubmit').remove(); 
                                                                            $('#btAddCompleta').removeAttr('disabled'); 
                                                                            $('#btAddCompleta').attr('class', 'form-control') 
                                                            
                                                                        }
                                                                    });
                                                            
                                                                    $('#btRemoveAllCompleta').click(function() {    // Elimina todos los elementos del contenedor
                                                                    
                                                                        $(container).empty(); 
                                                                        $(container).remove(); 
                                                                        $('#btSubmit').remove(); iCnt = 0; 
                                                                        $('#btAddCompleta').removeAttr('disabled'); 
                                                                        $('#btAddCompleta').attr('class', 'form-control');
                                                            
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
                            </div>
                            <div class="row" id="habilitarRespuestaRelacionar" style="display:none;">
                                <div class="form-group col-sm-10">
                                   <div id="mainRelacionar"> Agregar las preguntas a relacionar<br><br>
                                        <table>
                                            <tr>
                                                <td>
                                                    <input type="button" id="btAddRelacionar" value="Añadir" class="form-control" />
                                                </td>
                                                <td>
                                                    <input type="button" id="btRemoveAllRelacionar" value="Eliminar Todo" class="form-control" />
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
                                                            
                                                            // Crear un elemento div añadiendo estilos CSS
                                                                    var container = $(document.createElement('div')).css({
                                                                        padding: '0px', margin: '0px', width: '100%', border: '0px dashed',
                                                                        borderTopColor: '#999', borderBottomColor: '#999',
                                                                        borderLeftColor: '#999', borderRightColor: '#999'
                                                                    });
                                                            
                                                                    $('#btAddRelacionar').click(function() { 
                                                                        if (iCnt <= 4) {
                                                            
                                                                            iCnt = iCnt + 1;
                                                            
                                                                            // Añadir caja de texto.
                                                                            $(container).append('<div class="card-body table-responsive p-0" style=""><table class="table table-head-fixed text-center"> <td> '+ iCnt +'. </td><td><textarea type=text class="form-control" placeholder="Digítar información..." name="completa[]" id=tb' + iCnt + ' ' +' ></textarea> </td><td><input placeholder="Relacionar..." name="relacionar[]" type="number" min="1" class="form-control" ></td><td><textarea type=text class="form-control" placeholder="Digítar información..." name="info[]" id=tb' + iCnt + ' ' +' ></textarea></td></table></div>');
                                                            
                                                                            if (iCnt == 1) {   
                                                            // funcion del ++ por cada click
                                                            var divSubmit = $(document.createElement('div'));
                                                                                $(divSubmit).append('<!-- <input type=button class="bt" onclick="GetTextValue()"' + 
                                                                                        'id=btSubmit value=Enviar /> -->');
                                                            
                                                                            }
                                                            
                                                            $('#mainRelacionar').after(container, divSubmit); 
                                                                        }
                                                                        else {      //se establece un limite para añadir elementos, 20 es el limite
                                                                            
                                                                            $(container).append('<label> </label>'); 
                                                                            $('#btAddRelacionar').attr('class', 'form-control'); 
                                                                            $('#btAddRelacionar').attr('disabled', 'disabled');
                                                            
                                                                        }
                                                                    });
                                                            
                                                                    $('#btRemove').click(function() {   // Elimina un elemento por click
                                                                        if (iCnt != 0) { $('#tb' + iCnt).remove(); iCnt = iCnt - 1; }
                                                                    
                                                                        if (iCnt == 0) { $(container).empty(); 
                                                                    
                                                                            $(container).remove(); 
                                                                            $('#btSubmit').remove(); 
                                                                            $('#btAddRelacionar').removeAttr('disabled'); 
                                                                            $('#btAddRelacionar').attr('class', 'form-control') 
                                                            
                                                                        }
                                                                    });
                                                            
                                                                    $('#btRemoveAllRelacionar').click(function() {    // Elimina todos los elementos del contenedor
                                                                    
                                                                        $(container).empty(); 
                                                                        $(container).remove(); 
                                                                        $('#btSubmit').remove(); iCnt = 0; 
                                                                        $('#btAddRelacionar').removeAttr('disabled'); 
                                                                        $('#btAddRelacionar').attr('class', 'form-control');
                                                            
                                                                    });
                                                                });
                                                            
                                                              
                                                        </script>
                                </div>
                            </div>
                           
                            
                            <div class="card-footer" >     
                            <button type="submit" class="btn btn-primary float-right" name="crearEvaluacion" >Agregarr</button>
                            </div>   
                        </form>
                        
                        <script>
                            function ShowSelectedOption(){
                                    /* Para obtener el valor */
                                        var cod = document.getElementById("tipoPregunta").value;
                                        
                                        if(cod == "1"){  
                                            document.getElementById('habilitarRespuestaSiNo').style.display = 'none';
                                            document.getElementById('habilitarRespuestaMultiple').style.display = 'none';
                                            document.getElementById('habilitarRespuestaCompleta').style.display = 'none';
                                            document.getElementById('habilitarRespuestaRelacionar').style.display = 'none';
                                        }
                                        if(cod == "2"){
                                            document.getElementById('habilitarRespuestaSiNo').style.display = '';
                                            document.getElementById('habilitarRespuestaMultiple').style.display = 'none';
                                            document.getElementById('habilitarRespuestaCompleta').style.display = 'none';
                                            document.getElementById('habilitarRespuestaRelacionar').style.display = 'none';
                                        }
                                        if(cod == "3"){
                                            document.getElementById('habilitarRespuestaSiNo').style.display = 'none';
                                            document.getElementById('habilitarRespuestaMultiple').style.display = '';
                                            document.getElementById('habilitarRespuestaCompleta').style.display = 'none';
                                            document.getElementById('habilitarRespuestaRelacionar').style.display = 'none';
                                        }
                                        if(cod == "4"){
                                            document.getElementById('habilitarRespuestaSiNo').style.display = 'none';
                                            document.getElementById('habilitarRespuestaMultiple').style.display = 'none';
                                            document.getElementById('habilitarRespuestaCompleta').style.display = '';
                                            document.getElementById('habilitarRespuestaRelacionar').style.display = 'none';
                                        }
                                        if(cod == "5"){
                                            document.getElementById('habilitarRespuestaSiNo').style.display = 'none';
                                            document.getElementById('habilitarRespuestaMultiple').style.display = 'none';
                                            document.getElementById('habilitarRespuestaCompleta').style.display = 'none';
                                            document.getElementById('habilitarRespuestaRelacionar').style.display = '';
                                        }
                                        
                                        
                                        
                                        
                                    }
                        </script>    
                      
                      
                    
                     
                   
                </div>
            </div>
            
            <div class="card card-info" id="materiales" style="display:none;">
                <div class="card-header">
                    <h3 class="card-title">Materiales de trabajo </h3>
                </div>
                <div class="card-body">
                    
                    <?php
                    // traemos la evaluación vigente
                    if(isset($_POST['idEvaluacion'])){ 
                        $consultaEvaluacionMaterial=$mysqli->query("SELECT * FROM evaluacion WHERE id='".$_POST['idEvaluacion']."' ");
                        $extraerConsultaEvaluacionMaterial=$consultaEvaluacionMaterial->fetch_array(MYSQLI_ASSOC);
                        $evaluacionIDPMaterial=$extraerConsultaEvaluacionMaterial['id'];
                    }else{
                        $consultaEvaluacionMaterial=$mysqli->query("SELECT * FROM evaluacion WHERE idUsuario='$idparaChat' AND estado='proceso' ");
                        $extraerConsultaEvaluacionMaterial=$consultaEvaluacionMaterial->fetch_array(MYSQLI_ASSOC);
                        $evaluacionIDPMaterial=$extraerConsultaEvaluacionMaterial['id'];
                    }
                    ?>
                         
                   
                    <link rel="stylesheet" type="text/css" href="almacenamientoMultipleEvaluacion/css/dropzone.css" />
                    <script type="text/javascript" src="almacenamientoMultipleEvaluacion/js/dropzone.js"></script>
                    <style type="text/css">
                    .file_upload{
                    	border: 4px dashed #292929;
                    	}
                    </style>
                
                
                	<div class="file_upload">
                		<form action="almacenamientoMultipleEvaluacion/file_upload.php" class="dropzone">
                		    <input name="idEvaluacion" value="<?php echo $evaluacionIDPMaterial; ?>" type="hidden" >
                            
                			<div class="dz-message needsclick">
                				<strong>Arrastra archivos a cualquier lugar para subirlos.</strong><br /><br />
                				<span class="note needsclick">
                                <span class="glyphicon glyphicon-open" aria-hidden="true" style="font-size:60px;"></span>
                                </span>
                			</div>
                		</form>		
                	</div>   
                </div>
            </div>
            
            
            <div class="card card-info" id="documentosVisualizar" style="display:none;">
                <div class="card-header">
                    <h3 class="card-title">Materiales de trabajo </h3>
                </div>
                <div class="card-body">
                    Documentos
                    <div class="row">
                        <div class="form-group col-sm">
                            
                            <div class="card-body table-responsive p-0" style="">
                                 <!-- listamos los datos de la tabla -->
                                 <div id="mostrarDatos" style="display:;"></div>
                                 
                                 
                                 <input value="<?php echo $evaluacionIDPMaterial;?>" name="idEvaluacion" id="idEvaluacion" type="hidden">
                               
                                 <!-- END-->
                                <script>
                     
                                    
                                        // traemos los datos de la consulta, después de hacer el primer click, trae los datos actualizados después de agregar otro producto
                                            $(document).on('click', '#botonVisualizar', function(e){
                                            	e.preventDefault();
                                            	var idEvaluacion = $('#idEvaluacion').val(),
                                            	    idEvaluacionEditar = $('#idEvaluacionEditar').val();
                                            	
                                            	$.ajax({
                                            		url: 'evaluacionJS.php', // Es importante que la ruta sea correcta si no, no se va a ejecutar
                                            		method: 'POST',
                                            		data: { idEvaluacion: idEvaluacion, idEvaluacionEditar: idEvaluacionEditar },
                                            		beforeSend: function(){
                                            			$('#mostrarDatos').css('display','block');
                                            			//$('#estado p').html('Guardando datos...');
                                            		},
                                            		success: function(lista){
                                            				$('#mostrarDatos').html(lista);
                                            		}
                                            	});
                                            });
                                        // END    
                                        
                                       
                                    </script>  
                            </div>
                            
                        </div>
                    </div>  
                      
                    
                     
                   
                </div>
            </div>
            
            <script> //// Evento para cambiar entre el formulario de preguntas y el formulario de material de trabajo
                $(document).ready(function(){
                    $('#botonMaterial').click(function(){ 
                        document.getElementById('materiales').style.display = '';
                        document.getElementById('botonPregunta').style.display = '';
                        document.getElementById('formularios').style.display = 'none';
                        document.getElementById('botonMaterial').style.display = 'none'; 
                        document.getElementById('DivMaterial').style.display = 'none';
                        document.getElementById('DivPregunta').style.display = '';
                        document.getElementById('documentosVisualizar').style.display = 'none';
                    });
                    $('#botonPregunta').click(function(){ 
                        document.getElementById('materiales').style.display = 'none';
                        document.getElementById('botonPregunta').style.display = 'none';
                        document.getElementById('formularios').style.display = '';
                        document.getElementById('botonMaterial').style.display = '';
                        document.getElementById('DivMaterial').style.display = '';
                        document.getElementById('DivPregunta').style.display = 'none';
                        document.getElementById('documentosVisualizar').style.display = 'none';
                    });
                    $('#botonVisualizar').click(function(){ 
                        document.getElementById('materiales').style.display = 'none';
                        document.getElementById('botonPregunta').style.display = '';
                        document.getElementById('formularios').style.display = 'none';
                        document.getElementById('botonMaterial').style.display = '';
                        document.getElementById('documentosVisualizar').style.display = '';
                    });
                   
                });
            </script>         
                                   

          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
      
    </section>
    
    
    <!-- Formulario -->
   <section class="content-header">
         <div class="container-fluid">
            <div class="row">
                <div class="col-sm">
               
               
                           
                </div>
            </div>  
        </div>      
        <div class="row">
           
          <!-- /.col (LEFT) -->
          <div class="col-md-12">
            <!-- LINE CHART -->
            
            
            
            
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Evaluación </h3>
                </div>
                <div class="card-body">
                    <center><?php echo $nombreEvaluacion;?></center><br><br>
                        <div class="row">
                                <div class="form-group col-sm">
                                    <p style="text-align:justify;"><?php echo nl2br($encabezadoEvaluacion);?></p>
                                </div>
                        </div>
                        <br>
                        <div class="row">
                            <?php
                            $recorridoPreguntas=$mysqli->query("SELECT * FROM evaluacionPrueba WHERE idEvaluacion='$nombreEvaluacionIDP' ORDER BY id ASC");
                            $contadorPreguntas=1;
                            while($extraerRecorridoPreguntas=$recorridoPreguntas->fetch_array()){
                                $id=$extraerRecorridoPreguntas['id'];
                            ?>
                            
                                    <div class="form-group col-sm-6">
                                        <?php echo $contadorPreguntas++; 
                                        echo '. ';
                                        ?>
                                        <form action="controlador/evaluacion/controllerEvaluacion" method="post">
                                            <?php
                                            ////// rescatamos el id del editar para mantener la variable activa
                                            if($_POST['idEvaluacion'] != NULL){
                                            ?>
                                            <input name="idEvaluacion" value="<?php echo $_POST['idEvaluacion'];?>" type="hidden">
                                            <?php
                                            }
                                            /// end
                                            ?>
                                        <textarea type="text" placeholder="Pregunta sin título" name="pregunta" class="form-control" style="width:;" required><?php echo $extraerRecorridoPreguntas['pregunta']; ?></textarea>
                                        <br>
                                        <input style="width:50%;" name="puntajeCalificacion" value="<?php echo $extraerRecorridoPreguntas['puntajeCalificacion'];?>" type="number" min="1" class="form-control" placeholder="Puntaje..."> 
                                        <br><br>
                                        <?php
                                        ///// agregamos las opciones de las preguntas
                                        
                                        
                                            if($extraerRecorridoPreguntas['tipoPregunta'] == '1'){
                                            ?>
                                                <!-- <textarea type="text"  placeholder="" class="form-control"  name="respuesta"  ></textarea>--><br>
                                            <?php
                                            }elseif($extraerRecorridoPreguntas['tipoPregunta'] == '2'){
                                                if($extraerRecorridoPreguntas['correcto'] == 'Si'){
                                                    $checkedS='checked';
                                                }elseif($extraerRecorridoPreguntas['correcto'] == 'No'){
                                                    $checkedN='checked';
                                                }
                                            ?>
                                                Si
                                                <input type="radio" name="SiNo" value="Si" <?php echo $checkedS;?> required>
                                                &nbsp;
                                                No
                                                <input type="radio" name="SiNo" value="No" <?php echo $checkedN;?> required><br><br>
                                                <?php
                                                echo '<br> La respuesta correcta es: '.$extraerRecorridoPreguntas['correcto'].'<br><br>';
                                            }elseif($extraerRecorridoPreguntas['tipoPregunta'] == '3'){
                                                
                                                /// validamos pregunta 1 y correcto 1
                                                $validarPregunta2=$extraerRecorridoPreguntas['pregunta2'];
                                                $validarPregunta3=$extraerRecorridoPreguntas['pregunta3'];
                                                $validarPregunta4=$extraerRecorridoPreguntas['pregunta4'];
                                                $validarPregunta5=$extraerRecorridoPreguntas['pregunta5'];
                                                
                                                if($extraerRecorridoPreguntas['correcto1'] == TRUE){
                                                    $validarcorrecto1C='checked';
                                                }else{
                                                    $validarcorrecto1C='';
                                                }
                                                if($extraerRecorridoPreguntas['correcto2'] == TRUE){
                                                    $validarcorrecto2C='checked';
                                                }else{
                                                    $validarcorrecto2C='';
                                                }
                                                if($extraerRecorridoPreguntas['correcto3'] == TRUE){
                                                    $validarcorrecto3C='checked';
                                                }else{
                                                    $validarcorrecto3C='';
                                                }
                                                if($extraerRecorridoPreguntas['correcto4'] == TRUE){
                                                    $validarcorrecto4C='checked';
                                                }else{
                                                    $validarcorrecto4C='';
                                                }
                                                if($extraerRecorridoPreguntas['correcto5'] == TRUE){
                                                    $validarcorrecto5C='checked';
                                                }else{
                                                    $validarcorrecto5C='';
                                                }
                                                
                                                
                                               
                                                ?>
                                                <textarea class="form-control" name="opciones1"><?php echo $extraerRecorridoPreguntas['pregunta1'];?></textarea>
                                                Seleccionar correcto <input name="correcto1" type="checkbox" <?php echo $validarcorrecto1C; ?> ><br><br>
                                                <?php
                                                if($validarPregunta2 != NULL){
                                                ?>
                                                <textarea class="form-control" name="opciones2"><?php echo $extraerRecorridoPreguntas['pregunta2'];?></textarea>
                                                Seleccionar correcto
                                                <input name="correcto2" type="checkbox" <?php echo $validarcorrecto2C; ?> ><br><br>
                                                <?php
                                                }
                                                if($validarPregunta3 != NULL){
                                                ?>
                                                <textarea class="form-control" name="opciones3"><?php echo $extraerRecorridoPreguntas['pregunta3'];?></textarea>
                                                Seleccionar correcto
                                                <input name="correcto3" type="checkbox" <?php echo $validarcorrecto3C; ?> ><br><br>
                                                <?php
                                                }
                                                if($validarPregunta4 != NULL){
                                                ?>
                                                <textarea class="form-control" name="opciones4"><?php echo $extraerRecorridoPreguntas['pregunta4'];?></textarea>
                                                Seleccionar correcto
                                                <input name="correcto4" type="checkbox" <?php echo $validarcorrecto4C; ?> ><br><br>
                                                <?php
                                                }
                                                if($validarPregunta5 != NULL){
                                                ?>
                                                <textarea class="form-control" name="opciones5"><?php echo $extraerRecorridoPreguntas['pregunta5'];?></textarea>
                                                Seleccionar correcto
                                                <input name="correcto5" type="checkbox" <?php echo $validarcorrecto5C; ?> ><br><br>
                                                <?php
                                                }
                                                ?>
                                                
                                                
                                                
                                                
                                                
                                                
                                            <?php
                                            ////// SE hace un recorrido de las respuestas correctas para mostrar
                                            
                                            
                                            //// END
                                            
                                            }elseif($extraerRecorridoPreguntas['tipoPregunta'] == '4'){
                                            
                                                
                                                /// validamos pregunta 1 y correcto 1
                                                $validarPregunta2=$extraerRecorridoPreguntas['pregunta2'];
                                                $validarPregunta3=$extraerRecorridoPreguntas['pregunta3'];
                                                $validarPregunta4=$extraerRecorridoPreguntas['pregunta4'];
                                                $validarPregunta5=$extraerRecorridoPreguntas['pregunta5'];
                                                
                                                if($extraerRecorridoPreguntas['correcto'] == 1){
                                                    $validarcorrecto1='checked';
                                                }else{
                                                    $validarcorrecto1='';
                                                }
                                                if($extraerRecorridoPreguntas['correcto'] == 2){
                                                    $validarcorrecto2='checked';
                                                }else{
                                                    $validarcorrecto2='';
                                                }
                                                if($extraerRecorridoPreguntas['correcto'] == 3){
                                                    $validarcorrecto3='checked';
                                                }else{
                                                    $validarcorrecto3='';
                                                }
                                                if($extraerRecorridoPreguntas['correcto'] == 4){
                                                    $validarcorrecto4='checked';
                                                }else{
                                                    $validarcorrecto4='';
                                                }
                                                if($extraerRecorridoPreguntas['correcto'] == 5){
                                                    $validarcorrecto5='checked';
                                                }else{
                                                    $validarcorrecto5='';
                                                }
                                                
                                                
                                               
                                                ?>
                                                <textarea class="form-control" name="completa1"><?php echo $extraerRecorridoPreguntas['pregunta1'];?></textarea>
                                                Seleccionar correcto<input name="correcto" type="radio" value="1" <?php echo $validarcorrecto1; ?> ><br><br>
                                                <?php
                                                if($validarPregunta2 != NULL){
                                                ?>
                                                <textarea class="form-control" name="completa2"><?php echo $extraerRecorridoPreguntas['pregunta2'];?></textarea>
                                                Seleccionar correcto
                                                <input name="correcto" type="radio" <?php echo $validarcorrecto2; ?> value="2"><br><br>
                                                <?php
                                                }
                                                if($validarPregunta3 != NULL){
                                                ?>
                                                <textarea class="form-control" name="completa3"><?php echo $extraerRecorridoPreguntas['pregunta3'];?></textarea>
                                                Seleccionar correcto
                                                <input name="correcto" type="radio" <?php echo $validarcorrecto3; ?> value="3"><br><br>
                                                <?php
                                                }
                                                if($validarPregunta4 != NULL){
                                                ?>
                                                <textarea class="form-control" name="completa4"><?php echo $extraerRecorridoPreguntas['pregunta4'];?></textarea>
                                                Seleccionar correcto
                                                <input name="correcto" type="radio" <?php echo $validarcorrecto4; ?> value="4"><br><br>
                                                <?php
                                                }
                                                if($validarPregunta5 != NULL){
                                                ?>
                                                <textarea class="form-control" name="completa5"><?php echo $extraerRecorridoPreguntas['pregunta5'];?></textarea>
                                                Seleccionar correcto
                                                <input name="correcto" type="radio" <?php echo $validarcorrecto5; ?> value="5"><br><br>
                                                <?php
                                                }
                                                ?>
                                                
                                                
                                                
                                                
                                                
                                                
                                            <?php
                                            ////// SE hace un recorrido de las respuestas correctas para mostrar
                                            
                                            
                                            //// END
                                            
                                            
                                            }elseif($extraerRecorridoPreguntas['tipoPregunta'] == '5'){
                                                /// traemos la consultade la relacion
                                                $idRelacionon=$extraerRecorridoPreguntas['id'];
                                                $recorriendoRelaciones=$mysqli->query("SELECT * FROM evaluacionRelacional WHERE tipoPregunta='$idRelacionon' ");
                                                $conteoRelaciones=1;
                                                while($extraerRecorridoRelaciones=$recorriendoRelaciones->fetch_array()){
                                            ?>
                                            <div class="card-body table-responsive p-0" style="">
                                                <table class="table table-head-fixed text-center">
                                                     <td><?php echo $conteoRelaciones++;?><input name="idRelacionado[]" value="<?php echo $extraerRecorridoRelaciones['id'];?>" type="hidden"></td>
                                                     <td><textarea type=text class="form-control" placeholder="Digítar información..." name="completa[]"  ><?php echo $extraerRecorridoRelaciones['pregunta'];?></textarea></td>
                                                     <td><input type="number" class="form-control" placeholder="Relacionar..." name="relacionar[]"  min="1" value="<?php echo $extraerRecorridoRelaciones['relacionar'];?>" ></td>
                                                     <td><textarea type=text class="form-control" placeholder="Digítar información..." name="info[]" ><?php echo $extraerRecorridoRelaciones['informacion'];?></textarea></td>
                                                </table>
                                            </div>
                                            <?php
                                                }
                                            }
                                            
                                        ///// END
                                        
                                        
                                        /// agregamos la tabla de editar o eliminar
                                        $tipoPregunta=$extraerRecorridoPreguntas['tipoPregunta'];
                                        echo '<table>';    
                                           
                                            echo"<input type='hidden' name='idPregunta' value= '$id' >";
                                            echo"<input type='hidden' name='tipoPregunta' value= '$tipoPregunta' >";
                                            echo" <td><button type='submit' name='editarEvaluacion' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                                            ?>
                                            <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $id;?>' >
                                            <td><a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                                            <script>
                                                function funcionFormula<?php echo $contador2++;?>() {
                                                    /alert("entre");/
                                                  document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                                                }
                                           </script>
                                       </table>
                                       <!-- END -->
                                       
                                       </form>
                                    </div>
                            
                            <?php
                            }
                            ?>
                            
                            <!-- Modulo de eliminación-->
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
                                    <form action='controlador/evaluacion/controllerEvaluacion' method='POST'>
                                            <?php
                                            ////// rescatamos el id del editar para mantener la variable activa
                                            if($_POST['idEvaluacion'] != NULL){
                                            ?>
                                            <input name="idEvaluacion" value="<?php echo $_POST['idEvaluacion'];?>" type="hidden">
                                            <?php
                                            }
                                            /// end
                                            ?>
                                    <div class="modal-footer justify-content-between">
                                      <input type="hidden" id="capturarFormula" name='id' readonly>
                                      <button type="submit" name='eliminarEvaluacion' class="btn btn-outline-light">Si</button>
                                      <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                                    </div>
                                     </form>
                                     <!-- END formulario para eliminar por el id -->
                                  </div>
                                </div>
                            </div>
                            <!-- END -->
                        </div>
                </div>
                
                        <?php
                        
                         if(isset($_POST['idEvaluacion'])){ 
                         }else{
                        ?>    
                        <form action='controlador/evaluacion/controllerEvaluacion' method='POST'>    
                        <div class="card-footer" >     
                            <input name="idEvaluacion" value="<?php echo $nombreEvaluacionIDP; ?>" type="hidden">
                            <button type="submit" class="btn btn-primary float-right" name="cerrarEvaluacion" >Agregar</button>
                        </div>
                        </form>
                        <?php
                         }
                        ?>
            </div>
            
            
                      
                                   

          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
     
    </section>
    <!-- End Formulario -->
    
    
    
    
    
    
    
    
                       
    
  </div>
  <!-- /.content-wrapper -->
<?php //echo require_once'footer.php'; ?>


<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- Script advertencia eliminar -->
<!--Librerias para el estilo del campo para cargar archivos -->


<!-- END-->
<?php
  $validacionActualizar=$_POST['validacionActualizar'];
  $validacionEliminar=$_POST['validacionEliminar'];
?>

<script type="text/javascript">
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
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>  
<script>
    $(document).ready(function () {
      bsCustomFileInput.init();
    });
</script>


  
<script type='text/javascript'>
	    //document.oncontextmenu = function(){return false}
    </script>


  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
 
     
    <!-- archivos para el filtro de busqueda y lista de información -->
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
 
    <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>
    <!-- END -->
    
    
    
      <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- SweetAlert2 -->
  <script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
  <?php
  /// validaciones de alertas
  $validacionExiste=$_POST['validacionExiste'];
  $validacionExisteA=$_POST['validacionExisteA'];
  $validacionExisteB=$_POST['validacionExisteB'];
  $validacionAgregar=$_POST['validacionAgregar'];
  $validacionAgregarB=$_POST['validacionAgregarB'];
  $validacionActualizar=$_POST['validacionActualizar'];
  $validacionEliminar=$_POST['validacionEliminar'];
  $validacionEliminarB=$_POST['validacionEliminarB'];
  $Tipodocumeto=$_POST['Tipodocumeto'];

  //// Validaciones de la importación
  $validacionExisteImportacionA=$_POST['validacionExisteImportacionA'];
  $validacionExisteImportacionB=$_POST['validacionExisteImportacionB'];
  $validacionExisteImportacionC=$_POST['validacionExisteImportacionC'];
  $validacionExisteImportacionD=$_POST['validacionExisteImportacionD'];
  $validacionExisteImportacionE=$_POST['validacionExisteImportacionE'];
  $validacionExisteImportacionF=$_POST['validacionExisteImportacionF'];
  $validacionExisteImportacionG=$_POST['validacionExisteImportacionG'];
  $validacionExisteImportacionI=$_POST['validacionExisteImportacionI'];
  $validacionExisteImportacionVacio=$_POST['validacionExisteImportacionVacio'];
  //// END
  
  
    $validacionProductoExiste=$_POST['validacionProductoExiste'];
    $validacionCodigoExiste=$_POST['validacionCodigoExiste'];
    $validacionIdentificadorExiste=$_POST['validacionIdentificadorExiste'];
    $validacionNumericoExiste=$_POST['validacionNumericoExiste'];
  
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
      if($validacionNumericoExiste == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' Esta intentando ingresar letras en un campo númerico.'
          })
        <?php
      }
      if($validacionProductoExiste == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El producto no existe.'
          })
        <?php
      }
      if($validacionCodigoExiste == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El código no existe.'
          })
        <?php
      }
      if($validacionIdentificadorExiste == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El identificador no existe.'
          })
        <?php
      }
      
      
      
      
      
      if($Tipodocumeto == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El tipo de documento no es valido.'
          })
        <?php
      }
      
      if($validacionExisteImportacionVacio == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos campos están vacios.'
          })
      <?php
      }
       if($validacionExisteImportacionA == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos cargos no existen en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionB == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos lideres no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionC == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos procesos no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionD == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos centro de costos no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionE == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos centro de trabajo no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionF == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos grupos no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionG == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos usuarios ya existen.'
          })
      <?php
      }
      if($validacionExisteImportacionI == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Está intentando subir un archivo diferente.'
          })
      <?php
      }
      
      
      if($validacionExiste == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' El usuario ya existe.'
          })
      <?php
      }
      if($validacionExisteA == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' La fecha seleccionada no debe superar la del presente año.'
          })
      <?php
      }
      if($validacionExisteB == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Error, no se pudo eliminar el archivo.'
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
      if($validacionAgregarB == 1){
      ?>
          Toast.fire({
              type: 'success',
              title: 'Registro activado.'
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
      if($validacionEliminarB == 1){
      ?>
          Toast.fire({
              type: 'error',
              title: 'Registro Anulado.'
          })
      
      <?php
      }
      ?>
      
    });

  </script>
 
  <script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function () {
    bsCustomFileInput.init();
  });
  </script>
  <script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
  <!-- END -->
  <!--Ckeditor
  <script src="ckeditor/ckeditor.js"></script>
  <script>
    CKEDITOR.replace( 'encabezado' );
  </script>
  -->
</body>
</html>
<?php

}
?>
<!-- END -->
</body>
</html>
