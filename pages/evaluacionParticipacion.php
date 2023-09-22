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
                        <div class="col-sm" id="mostrarBotonDocumento">
                            <span id="botonVisualizar" class="btn btn-block btn-info btn-sm"><font color="white"><i class="fas fa-list"></i> Documentos </font></span>
                        </div>
                        <div class="col-sm" id="mostrarBotonCapacitacion" style="display:none;">
                            <span id="botonVisualizarCapacitacion" class="btn btn-block btn-info btn-sm"><font color="white"><i class="fas fa-list"></i> Capacitación </font></span>
                        </div>
                        <div class="col-sm"></div>
                        <div class="col-sm"></div>
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
       

                    
                    <?php
                    // traemos la evaluación vigente
                    $evaluacionVer=$_POST['idEvaluacion'];
                    $consultaEvaluacion=$mysqli->query("SELECT * FROM evaluacion WHERE id='$evaluacionVer' ");
                    $extraerConsultaEvaluacion=$consultaEvaluacion->fetch_array(MYSQLI_ASSOC);
                    $nombreEvaluacionIDP=$extraerConsultaEvaluacion['id'];
                    $nombreEvaluacion=$extraerConsultaEvaluacion['nombre'];
                    $encabezadoEvaluacion=$extraerConsultaEvaluacion['encabezado'];
                    
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
                         
              
      
    </section>
    
    
    <!-- Formulario -->
   <section class="content-header" id="capacitacion">
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
                        <form action="controlador/evaluacion/controllerRespuesta" method="post"> <!-- controlador/evaluacion/controllerRespuesta -->
                        <input name="usuario" value="<?php echo $idparaChat;?>" type="hidden">
                        <input name="idEvaluacion" value="<?php echo $evaluacionVer;?>" type="hidden">
                        <div class="row"> 
                        <?php
                        //// preguntamos que la capacitación esté resuelta para mostrarnos en listado con los resultados
                        $preguntaCapacitaipon=$mysqli->query("SELECT * FROM evaluacionRespuesta WHERE idEvaluacion='$nombreEvaluacionIDP' ");
                        $respuestaPreguntaCapacitacion=$preguntaCapacitaipon->fetch_array(MYSQLI_ASSOC);
                        
                        if($respuestaPreguntaCapacitacion['id'] != NULL){
                           
                            
                            $recorridoPreguntas=$mysqli->query("SELECT * FROM evaluacionPrueba WHERE idEvaluacion='$nombreEvaluacionIDP' ");
                            $contadorPreguntas=1;
                            while($extraerRecorridoPreguntas=$recorridoPreguntas->fetch_array()){
                                $id=$extraerRecorridoPreguntas['id'];
                                
                                
                                //// realizamos una subconsulta para traer los resultados de la evaluación aplicada
                                
                                $preguntaCapacitacionSub=$mysqli->query("SELECT * FROM evaluacionRespuesta WHERE tipoPregunta='".$extraerRecorridoPreguntas['tipoPregunta']."' ");
                                $respuestaPreguntaCapacitacionSub=$preguntaCapacitacionSub->fetch_array(MYSQLI_ASSOC);
                                
                            ?>
                            
                                    <div class="form-group col-sm-6">
                                        
                                        <?php echo $contadorPreguntas++; echo '. '; echo nl2br($extraerRecorridoPreguntas['pregunta']); 
                                        
                                        if($extraerRecorridoPreguntas['tipoPregunta'] == '1'){ ///nl2br(
                                         
                                            echo '<br><br>'.nl2br($respuestaPreguntaCapacitacionSub['respuesta1']);
                                         
                                        }elseif($extraerRecorridoPreguntas['tipoPregunta'] == '2'){
                                            if($respuestaPreguntaCapacitacionSub['respuesta1']  == 'Si'){
                                                $checkedSi='Si';
                                            }else{
                                                $checkedSi='No';
                                            }
                                            if($respuestaPreguntaCapacitacionSub['respuesta1']  == 'No'){
                                                 $checkedNo='checked';
                                            }else{
                                                 $checkedNo='';
                                            }
                                            
                                            if($extraerRecorridoPreguntas['correcto'] == $respuestaPreguntaCapacitacionSub['respuesta1']){
                                                $respuestaCorrectaSi='&#10004;';
                                            }else{
                                                $respuestaCorrectaSi='<font color="red">X</font>';
                                            }
                                            
                                            ?> 
                                            <br><br>
                                                Si
                                                <input type="radio" name="SiNo" value="Si" <?php echo $checkedSi;?> disabled>
                                                &nbsp;
                                                No
                                                <input type="radio" name="SiNo" value="No" <?php echo $checkedNo;?> disabled>
                                                &nbsp;
                                            <?php
                                            echo $respuestaCorrectaSi;
                                            
                                            echo '<br> La respuesta correcta es: '.$extraerRecorridoPreguntas['correcto'].'<br><br>';
                                            
                                        }elseif($extraerRecorridoPreguntas['tipoPregunta'] == '3'){
                                                
                                                
                                                
                                                if($respuestaPreguntaCapacitacionSub['respuesta1'] == TRUE){
                                                    $validarcorrecto1='checked';
                                                }else{
                                                    $validarcorrecto1='';
                                                }
                                                if($respuestaPreguntaCapacitacionSub['respuesta2'] == TRUE){
                                                    $validarcorrecto2='checked';
                                                }else{
                                                    $validarcorrecto2='';
                                                }
                                                if($respuestaPreguntaCapacitacionSub['respuesta3'] == TRUE){
                                                    $validarcorrecto3='checked';
                                                }else{
                                                    $validarcorrecto3='';
                                                }
                                                if($respuestaPreguntaCapacitacionSub['respuesta4'] == TRUE){
                                                    $validarcorrecto4='checked';
                                                }else{
                                                    $validarcorrecto4='';
                                                }
                                                if($respuestaPreguntaCapacitacionSub['respuesta5'] == TRUE){
                                                    $validarcorrecto5='checked';
                                                }else{
                                                    $validarcorrecto5='';
                                                }
                                                
                                                
                                                
                                                /// validamos pregunta 1 y correcto 1
                                                $validarPregunta2=$extraerRecorridoPreguntas['pregunta2'];
                                                $validarPregunta3=$extraerRecorridoPreguntas['pregunta3'];
                                                $validarPregunta4=$extraerRecorridoPreguntas['pregunta4'];
                                                $validarPregunta5=$extraerRecorridoPreguntas['pregunta5'];
                                                
                                                if($extraerRecorridoPreguntas['correcto1'] != NULL && $respuestaPreguntaCapacitacionSub['respuesta1'] != NULL){
                                                    $respuestaCorrectaSi1='&#10004;';
                                                }else{
                                                    if($respuestaPreguntaCapacitacionSub['respuesta1'] != NULL){
                                                        $respuestaCorrectaSi1='<font color="red">X</font>';
                                                    }else{
                                                        $respuestaCorrectaSi1='';
                                                    }
                                                }
                                                if($extraerRecorridoPreguntas['correcto2'] != NULL && $respuestaPreguntaCapacitacionSub['respuesta2'] != NULL){
                                                    $respuestaCorrectaSi2='&#10004;';
                                                }else{
                                                    if($respuestaPreguntaCapacitacionSub['respuesta2'] != NULL){
                                                        $respuestaCorrectaSi2='<font color="red">X</font>';
                                                    }else{
                                                        $respuestaCorrectaSi2='';
                                                    }
                                                }
                                                if($extraerRecorridoPreguntas['correcto3'] != NULL && $respuestaPreguntaCapacitacionSub['respuesta3'] != NULL ){
                                                    $respuestaCorrectaSi3='&#10004;';
                                                }else{
                                                    if($respuestaPreguntaCapacitacionSub['respuesta3'] != NULL){
                                                        $respuestaCorrectaSi3='<font color="red">X</font>';
                                                    }else{
                                                        $respuestaCorrectaSi3='';
                                                    }
                                                }
                                                if($extraerRecorridoPreguntas['correcto4'] != NULL && $respuestaPreguntaCapacitacionSub['respuesta4'] != NULL ){
                                                    $respuestaCorrectaSi4='&#10004;';
                                                }else{
                                                    if($respuestaPreguntaCapacitacionSub['respuesta4'] != NULL){
                                                        $respuestaCorrectaSi4='<font color="red">X</font>';
                                                    }else{
                                                        $respuestaCorrectaSi4='';
                                                    }
                                                }
                                                if($extraerRecorridoPreguntas['correcto5'] != NULL && $respuestaPreguntaCapacitacionSub['respuesta5'] != NULL){
                                                    $respuestaCorrectaSi5='&#10004;';
                                                }else{
                                                    if($respuestaPreguntaCapacitacionSub['respuesta5'] != NULL){
                                                        $respuestaCorrectaSi5='<font color="red">X</font>';
                                                    }else{
                                                        $respuestaCorrectaSi5='';
                                                    }
                                                }
                                                
                                                
                                                
                                                echo '<br><br>'.nl2br($extraerRecorridoPreguntas['pregunta1']);
                                                ?>
                                                <br>Seleccionar correcto <input name="correcto1" type="checkbox" <?php echo $validarcorrecto1; ?> disabled> &nbsp;<?php echo $respuestaCorrectaSi1;?>
                                                <?php
                                                    if($extraerRecorridoPreguntas['correcto1'] != NULL){
                                                        echo '<font color="green">Esta es la correcta</font>';
                                                    }
                                                if($validarPregunta2 != NULL){
                                                echo '<br><br>'.nl2br($extraerRecorridoPreguntas['pregunta2']);?>
                                                <br>Seleccionar correcto
                                                <input name="correcto2" type="checkbox" <?php echo $validarcorrecto2; ?> disabled> &nbsp;<?php echo $respuestaCorrectaSi2;?>
                                                <?php
                                                    if($extraerRecorridoPreguntas['correcto2'] != NULL){
                                                        echo 'Esta es la correcta';
                                                    }
                                                }
                                                if($validarPregunta3 != NULL){
                                                echo '<br><br>'.nl2br($extraerRecorridoPreguntas['pregunta3']);?>
                                                <br>Seleccionar correcto
                                                <input name="correcto3" type="checkbox" <?php echo $validarcorrecto3; ?> disabled> &nbsp;<?php echo $respuestaCorrectaSi3;?>
                                                <?php
                                                    if($extraerRecorridoPreguntas['correcto3'] != NULL){
                                                        echo '<font color="green">Esta es la correcta</font>';
                                                    }
                                                }
                                                if($validarPregunta4 != NULL){
                                                echo '<br><br>'.nl2br($extraerRecorridoPreguntas['pregunta4']);?>
                                                <br>Seleccionar correcto
                                                <input name="correcto4" type="checkbox" <?php echo $validarcorrecto4; ?> disabled> &nbsp;<?php echo $respuestaCorrectaSi4;?>
                                                <?php
                                                    if($extraerRecorridoPreguntas['correcto4'] != NULL){
                                                        echo '<font color="green">Esta es la correcta</font>';
                                                    }
                                                }
                                                if($validarPregunta5 != NULL){
                                                echo '<br><br>'.nl2br($extraerRecorridoPreguntas['pregunta5']);?>
                                                <br>Seleccionar correcto
                                                <input name="correcto5" type="checkbox" <?php echo $validarcorrecto5; ?> disabled> &nbsp;<?php echo $respuestaCorrectaSi5;?>
                                                <?php
                                                    if($extraerRecorridoPreguntas['correcto5'] != NULL){
                                                        echo '<font color="green">Esta es la correcta</font>';
                                                    }
                                                }
                                                ?>
                                                <br><br>
                                                
                                                
                                                
                                                
                                                
                                            <?php
                                            ////// SE hace un recorrido de las respuestas correctas para mostrar
                                            
                                            
                                            //// END
                                            
                                        }elseif($extraerRecorridoPreguntas['tipoPregunta'] == '4'){
                                            
                                                
                                                /// validamos pregunta 1 y correcto 1
                                                $validarPregunta2=$extraerRecorridoPreguntas['pregunta2'];
                                                $validarPregunta3=$extraerRecorridoPreguntas['pregunta3'];
                                                $validarPregunta4=$extraerRecorridoPreguntas['pregunta4'];
                                                $validarPregunta5=$extraerRecorridoPreguntas['pregunta5'];
                                                
                                               
                                                
                                                
                                                //// verificamos el resultado
                                                if($respuestaPreguntaCapacitacionSub['respuesta1'] == '1'){
                                                   $validarcorrecto1='checked';
                                                    if($extraerRecorridoPreguntas['correcto'] == $respuestaPreguntaCapacitacionSub['respuesta1']){
                                                        $respuestaCorrectaopciones1='&#10004;';
                                                    }else{
                                                        $respuestaCorrectaopciones1='<font color="red">X</font>';
                                                    }
                                                }else{
                                                   $validarcorrecto1='';
                                                }
                                                if($respuestaPreguntaCapacitacionSub['respuesta1'] == '2'){
                                                   $validarcorrecto2='checked';
                                                    if($extraerRecorridoPreguntas['correcto'] == $respuestaPreguntaCapacitacionSub['respuesta1']){
                                                        $respuestaCorrectaopciones2='&#10004;';
                                                    }else{
                                                        $respuestaCorrectaopciones2='<font color="red">X</font>';
                                                    }
                                                }else{
                                                   $validarcorrecto2='';
                                                }
                                                if($respuestaPreguntaCapacitacionSub['respuesta1'] == '3'){
                                                    $validarcorrecto3='checked';
                                                    if($extraerRecorridoPreguntas['correcto'] == $respuestaPreguntaCapacitacionSub['respuesta1']){
                                                        $respuestaCorrectaopciones3='&#10004;';
                                                    }else{
                                                        $respuestaCorrectaopciones3='<font color="red">X</font>';
                                                    }
                                                }else{
                                                    $validarcorrecto3='';
                                                }
                                                if($respuestaPreguntaCapacitacionSub['respuesta1'] == '4'){
                                                    $validarcorrecto4='checked';
                                                    if($extraerRecorridoPreguntas['correcto'] == $respuestaPreguntaCapacitacionSub['respuesta1']){
                                                        $respuestaCorrectaopciones4='&#10004;';
                                                    }else{
                                                        $respuestaCorrectaopciones4='<font color="red">X</font>';
                                                    }
                                                }else{
                                                    $validarcorrecto4='';
                                                }
                                                if($respuestaPreguntaCapacitacionSub['respuesta1'] == '5'){
                                                    $validarcorrecto5='checked';
                                                    if($extraerRecorridoPreguntas['correcto'] == $respuestaPreguntaCapacitacionSub['respuesta1']){
                                                        $respuestaCorrectaopciones5='&#10004;';
                                                    }else{
                                                        $respuestaCorrectaopciones5='<font color="red">X</font>';
                                                    }
                                                }else{
                                                   $validarcorrecto5='';
                                                }
                                                //// end
                                                
                                                
                                                
                                                echo '<br><br>'.nl2br($extraerRecorridoPreguntas['pregunta1']);?>
                                                <br>Seleccionar correcto<input name="correcto" type="radio" value="1" <?php echo $validarcorrecto1; ?> disabled>&nbsp; <?php echo $respuestaCorrectaopciones1;?>
                                                <?php
                                                    if($extraerRecorridoPreguntas['correcto'] == '1'){
                                                        echo '<font color="green">Esta es la correcta</font>';
                                                    }
                                                if($validarPregunta2 != NULL){
                                                echo '<br><br>'.nl2br($extraerRecorridoPreguntas['pregunta2']);?>
                                                <br>Seleccionar correcto
                                                <input name="correcto" type="radio" value="2" <?php echo $validarcorrecto2; ?> disabled>&nbsp; <?php echo $respuestaCorrectaopciones2;?>
                                                <?php
                                                    if($extraerRecorridoPreguntas['correcto'] == '2'){
                                                        echo '<font color="green">Esta es la correcta</font>';
                                                    }
                                                }
                                                if($validarPregunta3 != NULL){
                                                echo '<br><br>'.nl2br($extraerRecorridoPreguntas['pregunta3']);?>
                                                <br>Seleccionar correcto
                                                <input name="correcto" type="radio" value="3" <?php echo $validarcorrecto3; ?> disabled>&nbsp; <?php echo $respuestaCorrectaopciones3;?>
                                                <?php
                                                    if($extraerRecorridoPreguntas['correcto'] == '3'){
                                                        echo '<font color="green">Esta es la correcta</font>';
                                                    }
                                                }
                                                if($validarPregunta4 != NULL){
                                                echo '<br><br>'.nl2br($extraerRecorridoPreguntas['pregunta4']);?>
                                                <br>Seleccionar correcto
                                                <input name="correcto" type="radio" value="4" <?php echo $validarcorrecto4; ?> disabled>&nbsp; <?php echo $respuestaCorrectaopciones4;?>
                                                <?php
                                                    if($extraerRecorridoPreguntas['correcto'] == '4'){
                                                        echo '<font color="green">Esta es la correcta</font>';
                                                    }
                                                }
                                                if($validarPregunta5 != NULL){
                                                echo '<br><br>'.nl2br($extraerRecorridoPreguntas['pregunta5']);?>
                                                <br>Seleccionar correcto
                                                <input name="correcto" type="radio" value="5" <?php echo $validarcorrecto5; ?> disabled>&nbsp; <?php echo $respuestaCorrectaopciones5;?>
                                                <?php
                                                    if($extraerRecorridoPreguntas['correcto'] == '5'){
                                                        echo '<font color="green">Esta es la correcta</font>';
                                                    }
                                                }
                                                ?>
                                                <br><br>
                                                
                                                
                                                
                                                
                                                
                                            <?php
                                            ////// SE hace un recorrido de las respuestas correctas para mostrar
                                            
                                            
                                            //// END
                                            
                                            
                                        }elseif($extraerRecorridoPreguntas['tipoPregunta'] == '5'){
                                            
                                            
                                                ?>
                                                <div class="card-body table-responsive p-0" >
                                                <table class="table table-head-fixed text-center">
                                                <?php    
                                                $idRelacionon=$extraerRecorridoPreguntas['id'];
                                                $recorriendoRelaciones1=$mysqli->query("SELECT * FROM evaluacionRelacional WHERE tipoPregunta='$idRelacionon' ORDER BY id ASC LIMIT 0,1 ");
                                                $extraerRecorridoRelaciones1=$recorriendoRelaciones1->fetch_array(MYSQLI_ASSOC);
                                                if($extraerRecorridoRelaciones1['id'] != NULL){
                                                echo '<tr>';
                                                    echo '<td>1</td>';
                                                    echo '<td>';
                                                        echo nl2br($extraerRecorridoRelaciones1['pregunta']);
                                                    echo '</td>';
                                                    if($extraerRecorridoRelaciones1['relacionar'] == $respuestaPreguntaCapacitacionSub['respuesta1']){
                                                        $respuestaCorrecta1='&#10004;';
                                                    }else{
                                                        $respuestaCorrecta1='<font color="red">X</font>';
                                                    }
                                                    echo '<td>'.$respuestaPreguntaCapacitacionSub['respuesta1'].'<font color="white">_</font>'.$respuestaCorrecta1.'</td>';
                                                    echo '<td>';
                                                        echo nl2br($extraerRecorridoRelaciones1['informacion']);
                                                    echo '</td>';
                                                    echo '<td>';
                                                        echo '<font color="green">Correcto:<font color="white">_</font>'.$extraerRecorridoRelaciones1['relacionar'].'</font>'; 
                                                    echo '</td>';
                                                echo '</tr>';
                                                }
                                                $recorriendoRelaciones2=$mysqli->query("SELECT * FROM evaluacionRelacional WHERE tipoPregunta='$idRelacionon' ORDER BY id ASC LIMIT 1,2 ");
                                                $extraerRecorridoRelaciones2=$recorriendoRelaciones2->fetch_array(MYSQLI_ASSOC);
                                                if($extraerRecorridoRelaciones2['id'] != NULL){
                                                echo '<tr>';
                                                    echo '<td>2</td>';
                                                    echo '<td>';
                                                        echo nl2br($extraerRecorridoRelaciones2['pregunta']);
                                                    echo '</td>';
                                                    if($extraerRecorridoRelaciones2['relacionar'] == $respuestaPreguntaCapacitacionSub['respuesta2']){
                                                        $respuestaCorrecta2='&#10004;';
                                                    }else{
                                                        $respuestaCorrecta2='<font color="red">X</font>';
                                                    }
                                                    echo '<td>'.$respuestaPreguntaCapacitacionSub['respuesta2'].'<font color="white">_</font>'.$respuestaCorrecta2.'</td>';
                                                    echo '<td>';
                                                        echo nl2br($extraerRecorridoRelaciones2['informacion']);
                                                    echo '</td>';
                                                    echo '<td>';
                                                        echo '<font color="green">Correcto:<font color="white">_</font>'.$extraerRecorridoRelaciones2['relacionar'].'</font>'; 
                                                    echo '</td>';
                                                echo '</tr>';
                                                }
                                                
                                                $recorriendoRelaciones3=$mysqli->query("SELECT * FROM evaluacionRelacional WHERE tipoPregunta='$idRelacionon' ORDER BY id ASC LIMIT 2,3 ");
                                                $extraerRecorridoRelaciones3=$recorriendoRelaciones3->fetch_array(MYSQLI_ASSOC);
                                                if($extraerRecorridoRelaciones3['id'] != NULL){
                                                echo '<tr>';
                                                    echo '<td>3</td>';
                                                    echo '<td>';
                                                        echo nl2br($extraerRecorridoRelaciones3['pregunta']);
                                                    echo '</td>';
                                                    if($extraerRecorridoRelaciones3['relacionar'] == $respuestaPreguntaCapacitacionSub['respuesta3']){
                                                        $respuestaCorrecta3='&#10004;';
                                                    }else{
                                                        $respuestaCorrecta3='<font color="red">X</font>';
                                                    }
                                                    echo '<td>'.$respuestaPreguntaCapacitacionSub['respuesta3'].'<font color="white">_</font>'.$respuestaCorrecta3.'</td>';
                                                    echo '<td>';
                                                        echo nl2br($extraerRecorridoRelaciones3['informacion']);
                                                    echo '</td>';
                                                    echo '<td>';
                                                        echo '<font color="green">Correcto:<font color="white">_</font>'.$extraerRecorridoRelaciones3['relacionar'].'</font>'; 
                                                    echo '</td>';
                                                echo '</tr>';
                                                }
                                                $recorriendoRelaciones4=$mysqli->query("SELECT * FROM evaluacionRelacional WHERE tipoPregunta='$idRelacionon' ORDER BY id ASC LIMIT 3,4 ");
                                                $extraerRecorridoRelaciones4=$recorriendoRelaciones4->fetch_array(MYSQLI_ASSOC);
                                                if($extraerRecorridoRelaciones4['id'] != NULL){
                                                echo '<tr>';
                                                    echo '<td>4</td>';
                                                    echo '<td>';
                                                        echo nl2br($extraerRecorridoRelaciones4['pregunta']);
                                                    echo '</td>';
                                                    if($extraerRecorridoRelaciones4['relacionar'] == $respuestaPreguntaCapacitacionSub['respuesta4']){
                                                        $respuestaCorrecta4='&#10004;';
                                                    }else{
                                                        $respuestaCorrecta4='<font color="red">X</font>';
                                                    }
                                                    echo '<td>'.$respuestaPreguntaCapacitacionSub['respuesta4'].'<font color="white">_</font>'.$respuestaCorrecta4.'</td>';
                                                    echo '<td>';
                                                        echo nl2br($extraerRecorridoRelaciones4['informacion']);
                                                    echo '</td>';
                                                    echo '<td>';
                                                        echo '<font color="green">Correcto:<font color="white">_</font>'.$extraerRecorridoRelaciones4['relacionar'].'</font>'; 
                                                    echo '</td>';
                                                echo '</tr>';
                                                }
                                                
                                                $recorriendoRelaciones5=$mysqli->query("SELECT * FROM evaluacionRelacional WHERE tipoPregunta='$idRelacionon' ORDER BY id ASC LIMIT 4,5 ");
                                                $extraerRecorridoRelaciones5=$recorriendoRelaciones5->fetch_array(MYSQLI_ASSOC);
                                                if($extraerRecorridoRelaciones5['id'] != NULL){
                                                echo '<tr>';
                                                    echo '<td>5</td>';
                                                    echo '<td>';
                                                        echo nl2br($extraerRecorridoRelaciones5['pregunta']);
                                                    echo '</td>';
                                                    if($extraerRecorridoRelaciones5['relacionar'] == $respuestaPreguntaCapacitacionSub['respuesta5']){
                                                        $respuestaCorrecta5='&#10004;';
                                                    }else{
                                                        $respuestaCorrecta5='<font color="red">X</font>';
                                                    }
                                                    echo '<td>'.$respuestaPreguntaCapacitacionSub['respuesta5'].'<font color="white">_</font>'.$respuestaCorrecta5.'</td>';
                                                    echo '<td>';
                                                        echo nl2br($extraerRecorridoRelaciones5['informacion']);
                                                    echo '</td>';
                                                    echo '<td>';
                                                        echo '<font color="green">Correcto:<font color="white">_</font>'.$extraerRecorridoRelaciones5['relacionar'].'</font>'; 
                                                    echo '</td>';
                                                echo '</tr>';
                                                }
                                                
                                                /*
                                                echo '<br><br>R1: '.$respuestaPreguntaCapacitacionSub['respuesta1'];
                                                echo '<br>R2: '.$respuestaPreguntaCapacitacionSub['respuesta2'];
                                                echo '<br>R3: '.$respuestaPreguntaCapacitacionSub['respuesta3'];
                                                echo '<br>R4: '.$respuestaPreguntaCapacitacionSub['respuesta4'];
                                                echo '<br>R5: '.$respuestaPreguntaCapacitacionSub['respuesta5'];
                                                */
                                                
                                                //echo '<br><br>';
                                                /// traemos la consultade la relacion
                                                /*
                                                $idRelacionon=$extraerRecorridoPreguntas['id'];
                                                $recorriendoRelaciones=$mysqli->query("SELECT * FROM evaluacionRelacional WHERE tipoPregunta='$idRelacionon' ");
                                                $conteoRelaciones=1;
                                                $conteoRelacionesName=0;
                                                while($extraerRecorridoRelaciones=$recorriendoRelaciones->fetch_array()){
                                            ?>
                                                     <tr>
                                                     <td><?php echo $conteoRelaciones++;?><input name="idRelacionado[]" value="<?php echo $extraerRecorridoRelaciones['id'];?>" type="hidden"></td>
                                                     <td><?php echo nl2br($extraerRecorridoRelaciones['pregunta']);?></td>
                                                     <td>
                                                        <?php
                                                        
                                                        if($extraerRecorridoRelaciones['relacionar'] == $respuestaPreguntaCapacitacionSub['respuesta1']){
                                                            //echo $respuestaPreguntaCapacitacionSub['respuesta1'];
                                                        }
                                                        
                                                       
                                                        
                                                        echo '<br><font color="green">La correcta es: '.$extraerRecorridoRelaciones['relacionar'].'</font>'; 
                                                         ?>
                                                     </td>
                                                     <td><?php echo nl2br($extraerRecorridoRelaciones['informacion']);?></td>
                                                     </tr>
                                            <?php
                                                }
                                                */
                                            ?>
                                            </table>
                                            </div>
                                            <?php
                                            }
                                            
                                        $tipoPregunta=$extraerRecorridoPreguntas['tipoPregunta'];
                                        echo"<input type='hidden' name='idPregunta[]' value= '$id' >";
                                        echo"<input type='hidden' name='tipoPregunta[]' value= '$tipoPregunta' >";
                                        ?>
                                       
                                       
                                    </div>
                            
                            <?php
                            }
                            
                        }else{
                            
                            $recorridoPreguntas=$mysqli->query("SELECT * FROM evaluacionPrueba WHERE idEvaluacion='$nombreEvaluacionIDP' ");
                            $contadorPreguntas=1;
                            $contadorDePreguntas=1;
                            $contadorDePreguntasDiv=1;
                            $contadorDePreguntasDivB=1;
                            $contadorDePreguntasDivC=1;
                            $contadorDePreguntasScript=1;
                            $contadorDePreguntasScriptFuncion=1;
                            
                            /// contador para la pregunta anterior
                            $validarBotonAnterior=1;
                            $contadorDePreguntasAnterior=1;
                            $contadorDePreguntasScriptAnterior=1;
                            $contadorDePreguntasDivBAnterior=1;
                            $contadorDePreguntasDivCAnterior=1;
                            /// end
                            
                            //// validamos la vista
                            $contadorParaVista=1;
                            /// end
                            
                            //// validando conteo
                            $conteoExistente=1;
                            $conteoExistenteB=1;
                            //// end
                            
                            /// validamos el conteo para el campo obligatorio
                            $contadorValidarCechebox1=1;
                            $contadorValidarCechebox2=1;
                            $contadorValidarCechebox3=1;
                            $contadorValidarCechebox4=1;
                            $contadorValidarCechebox5=1;
                            $contadorValidarCecheboxB1=1;
                            $contadorValidarCecheboxB2=1;
                            $contadorValidarCecheboxB3=1;
                            $contadorValidarCecheboxB4=1;
                            $contadorValidarCecheboxB5=1;
                            // end
                            
                            // remover obligatorios
                            $contadorValidarCechebox1Remover1=1;
                            $contadorValidarCechebox1Remover11=1;
                            $contadorValidarCechebox1Remover111=1;
                            $contadorValidarCechebox1Remover1111=1;
                            $contadorValidarCechebox1Remover11111=1;
                            
                            $contadorValidarCechebox1Remover2=1;
                            $contadorValidarCechebox1Remover22=1;
                            $contadorValidarCechebox1Remover222=1;
                            $contadorValidarCechebox1Remover2222=1;
                            $contadorValidarCechebox1Remover22222=1;
                            
                            $contadorValidarCechebox1Remover3=1;
                            $contadorValidarCechebox1Remover33=1;
                            $contadorValidarCechebox1Remover333=1;
                            $contadorValidarCechebox1Remover3333=1;
                            $contadorValidarCechebox1Remover33333=1;
                            
                            $contadorValidarCechebox1Remover4=1;
                            $contadorValidarCechebox1Remover44=1;
                            $contadorValidarCechebox1Remover444=1;
                            $contadorValidarCechebox1Remover4444=1;
                            $contadorValidarCechebox1Remover44444=1;
                            
                            $contadorValidarCechebox1Remover5=1;
                            $contadorValidarCechebox1Remover55=1;
                            $contadorValidarCechebox1Remover555=1;
                            $contadorValidarCechebox1Remover5555=1;
                            $contadorValidarCechebox1Remover55555=1;
                            // end
                            while($extraerRecorridoPreguntas=$recorridoPreguntas->fetch_array()){
                                $id=$extraerRecorridoPreguntas['id'];
                                
                               
                            ?>
                            
                                    <div class="form-group col-sm-10" id="pregunta<?php echo $contadorDePreguntasDiv++;?>" style="display:<?php if($contadorParaVista++ == 1){ }else{  echo 'none'; } ?>;">
                                        
                                        <?php echo $contadorPreguntas++; echo '. '; echo nl2br($extraerRecorridoPreguntas['pregunta']); 
                                        
                                        
                                        if($extraerRecorridoPreguntas['tipoPregunta'] == '1'){
                                        ?>
                                            <textarea type="text"  placeholder="" class="form-control"  name="respuesta"  required></textarea>   
                                        <?php
                                        }elseif($extraerRecorridoPreguntas['tipoPregunta'] == '2'){
                                               
                                            ?><br><br>
                                                Si
                                                <input type="radio" name="SiNo" value="Si" required>
                                                &nbsp;
                                                No
                                                <input type="radio" name="SiNo" value="No" required> <br>
                                                <?php
                                                //echo '<br> La respuesta correcta es: '.$extraerRecorridoPreguntas['correcto'].'<br><br>';
                                        }elseif($extraerRecorridoPreguntas['tipoPregunta'] == '3'){
                                                
                                                /// validamos pregunta 1 y correcto 1
                                                $validarPregunta2=$extraerRecorridoPreguntas['pregunta2'];
                                                $validarPregunta3=$extraerRecorridoPreguntas['pregunta3'];
                                                $validarPregunta4=$extraerRecorridoPreguntas['pregunta4'];
                                                $validarPregunta5=$extraerRecorridoPreguntas['pregunta5'];
                                                echo '<br><br>'.nl2br($extraerRecorridoPreguntas['pregunta1']);
                                                ?>
                                                <br>Seleccionar correcto <input name="correcto1" type="checkbox" id="campoObligatorioC1<?php echo $contadorValidarCechebox1++;?>">
                                                <script>
                                                // colocams todos los campos obligatorios
                                                document.getElementById("campoObligatorioC1<?php echo $contadorValidarCecheboxB1++;?>").setAttribute("required","any");
                                                </script>
                                                <?php
                                                if($validarPregunta2 != NULL){
                                                echo '<br><br>'.nl2br($extraerRecorridoPreguntas['pregunta2']);?>
                                                <br>Seleccionar correcto
                                                <input name="correcto2" type="checkbox" id="campoObligatorioC2<?php echo $contadorValidarCechebox2++;?>">
                                                <script>
                                                // colocams todos los campos obligatorios
                                                document.getElementById("campoObligatorioC2<?php echo $contadorValidarCecheboxB2++;?>").setAttribute("required","any");
                                                </script>
                                                <?php
                                                }
                                                if($validarPregunta3 != NULL){
                                                echo '<br><br>'.nl2br($extraerRecorridoPreguntas['pregunta3']);?>
                                                <br>Seleccionar correcto
                                                <input name="correcto3" type="checkbox" id="campoObligatorioC3<?php echo $contadorValidarCechebox3++;?>">
                                                <script>
                                                // colocams todos los campos obligatorios
                                                document.getElementById("campoObligatorioC3<?php echo $contadorValidarCecheboxB3++;?>").setAttribute("required","any");
                                                </script>
                                                <?php
                                                }
                                                if($validarPregunta4 != NULL){
                                                echo '<br><br>'.nl2br($extraerRecorridoPreguntas['pregunta4']);?>
                                                <br>Seleccionar correcto
                                                <input name="correcto4" type="checkbox" id="campoObligatorioC4<?php echo $contadorValidarCechebox4++;?>">
                                                <script>
                                                // colocams todos los campos obligatorios
                                                document.getElementById("campoObligatorioC4<?php echo $contadorValidarCecheboxB4++;?>").setAttribute("required","any");
                                                </script>
                                                <?php
                                                }
                                                if($validarPregunta5 != NULL){
                                                echo '<br><br>'.nl2br($extraerRecorridoPreguntas['pregunta5']);?>
                                                <br>Seleccionar correcto
                                                <input name="correcto5" type="checkbox" id="campoObligatorioC5<?php echo $contadorValidarCechebox5++;?>"><br><br>
                                                <script>
                                                // colocams todos los campos obligatorios
                                                document.getElementById("campoObligatorioC5<?php echo $contadorValidarCecheboxB5++;?>").setAttribute("required","any");
                                                </script>
                                                <?php
                                                }
                                                ?>
                                                
                                            <!-- Colocamos los campos obligatorios -->    
                                            <script>
                                                $(document).ready(function(){
                                                    $('#campoObligatorioC1<?php echo $contadorValidarCechebox1Remover1++;?>').click(function(){
                                                        //alert("entra validacion");
                                                        document.getElementById("campoObligatorioC2<?php echo $contadorValidarCechebox1Remover11++;?>").removeAttribute("required","any");
                                                        document.getElementById("campoObligatorioC3<?php echo $contadorValidarCechebox1Remover111++;?>").removeAttribute("required","any");
                                                        document.getElementById("campoObligatorioC4<?php echo $contadorValidarCechebox1Remover1111++;?>").removeAttribute("required","any");
                                                        document.getElementById("campoObligatorioC5<?php echo $contadorValidarCechebox1Remover11111++;?>").removeAttribute("required","any");
                                                    });
                                                        
                                                }); 
                                                $(document).ready(function(){
                                                    $('#campoObligatorioC2<?php echo $contadorValidarCechebox1Remover2++;?>').click(function(){
                                                        //alert("entra validacion");
                                                        document.getElementById("campoObligatorioC1<?php echo $contadorValidarCechebox1Remover22++;?>").removeAttribute("required","any");
                                                        document.getElementById("campoObligatorioC3<?php echo $contadorValidarCechebox1Remover222++;?>").removeAttribute("required","any");
                                                        document.getElementById("campoObligatorioC4<?php echo $contadorValidarCechebox1Remover2222++;?>").removeAttribute("required","any");
                                                        document.getElementById("campoObligatorioC5<?php echo $contadorValidarCechebox1Remover22222++;?>").removeAttribute("required","any");
                                                    });
                                                        
                                                }); 
                                                $(document).ready(function(){
                                                    $('#campoObligatorioC3<?php echo $contadorValidarCechebox1Remover3++;?>').click(function(){
                                                        //alert("entra validacion");
                                                        document.getElementById("campoObligatorioC1<?php echo $contadorValidarCechebox1Remover33++;?>").removeAttribute("required","any");
                                                        document.getElementById("campoObligatorioC2<?php echo $contadorValidarCechebox1Remover333++;?>").removeAttribute("required","any");
                                                        document.getElementById("campoObligatorioC4<?php echo $contadorValidarCechebox1Remover3333++;?>").removeAttribute("required","any");
                                                        document.getElementById("campoObligatorioC5<?php echo $contadorValidarCechebox1Remover33333++;?>").removeAttribute("required","any");
                                                    });
                                                        
                                                }); 
                                                $(document).ready(function(){
                                                    $('#campoObligatorioC4<?php echo $contadorValidarCechebox1Remover4++;?>').click(function(){
                                                        //alert("entra validacion con cuarta opcion");
                                                        document.getElementById("campoObligatorioC1<?php echo $contadorValidarCechebox1Remover44++;?>").removeAttribute("required","any");
                                                        document.getElementById("campoObligatorioC2<?php echo $contadorValidarCechebox1Remover444++;?>").removeAttribute("required","any");
                                                        document.getElementById("campoObligatorioC3<?php echo $contadorValidarCechebox1Remover4444++;?>").removeAttribute("required","any");
                                                        document.getElementById("campoObligatorioC5<?php echo $contadorValidarCechebox1Remover44444++;?>").removeAttribute("required","any");
                                                    });
                                                        
                                                }); 
                                                $(document).ready(function(){
                                                    $('#campoObligatorioC5<?php echo $contadorValidarCechebox1Remover5++;?>').click(function(){
                                                        //alert("entra validacion con quinta opcion");
                                                        document.getElementById("campoObligatorioC1<?php echo $contadorValidarCechebox1Remover55++;?>").removeAttribute("required","any");
                                                        document.getElementById("campoObligatorioC2<?php echo $contadorValidarCechebox1Remover555++;?>").removeAttribute("required","any");
                                                        document.getElementById("campoObligatorioC3<?php echo $contadorValidarCechebox1Remover5555++;?>").removeAttribute("required","any");
                                                        document.getElementById("campoObligatorioC4<?php echo $contadorValidarCechebox1Remover55555++;?>").removeAttribute("required","any");
                                                    });
                                                        
                                                }); 
                                            </script>    
                                            <!-- END -->    
                                                
                                                
                                            <?php
                                           
                                            
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
                                                
                                                
                                               
                                                echo '<br><br>'.nl2br($extraerRecorridoPreguntas['pregunta1']);?>
                                                <br>Seleccionar correcto<input name="correcto" type="radio" value="1" required>
                                                <?php
                                                if($validarPregunta2 != NULL){
                                                echo '<br><br>'.nl2br($extraerRecorridoPreguntas['pregunta2']);?>
                                                <br>Seleccionar correcto
                                                <input name="correcto" type="radio" value="2" required>
                                                <?php
                                                }
                                                if($validarPregunta3 != NULL){
                                                echo '<br><br>'.nl2br($extraerRecorridoPreguntas['pregunta3']);?>
                                                <br>Seleccionar correcto
                                                <input name="correcto" type="radio" value="3" required>
                                                <?php
                                                }
                                                if($validarPregunta4 != NULL){
                                                echo '<br><br>'.nl2br($extraerRecorridoPreguntas['pregunta4']);?>
                                                <br>Seleccionar correcto
                                                <input name="correcto" type="radio" value="4" required>
                                                <?php
                                                }
                                                if($validarPregunta5 != NULL){
                                                echo '<br><br>'.nl2br($extraerRecorridoPreguntas['pregunta5']);?>
                                                <br>Seleccionar correcto
                                                <input name="correcto" type="radio" value="5" required>
                                                <?php
                                                }
                                                ?>
                                                
                                                
                                                <br><br>
                                                
                                                
                                                
                                            <?php
                                            ////// SE hace un recorrido de las respuestas correctas para mostrar
                                            
                                            
                                            //// END
                                            
                                            
                                        }elseif($extraerRecorridoPreguntas['tipoPregunta'] == '5'){
                                                ?>
                                                <div class="card-body table-responsive p-0" >
                                                <table class="table table-head-fixed text-center">
                                                <?php
                                                echo '<br><br>';
                                                /// traemos la consultade la relacion
                                                $idRelacionon=$extraerRecorridoPreguntas['id'];
                                                $recorriendoRelaciones=$mysqli->query("SELECT * FROM evaluacionRelacional WHERE tipoPregunta='$idRelacionon' ");
                                                $conteoRelaciones=1;
                                                $conteoRelacionesName=1;
                                                while($extraerRecorridoRelaciones=$recorriendoRelaciones->fetch_array()){
                                            ?>
                                                     <tr>
                                                     <td><?php echo $conteoRelaciones++;?><input name="idRelacionado[]" value="<?php echo $extraerRecorridoRelaciones['id'];?>" type="hidden"></td>
                                                     <td style="text-align:justify;"><?php echo nl2br($extraerRecorridoRelaciones['pregunta']);?></td>
                                                     <td>Relacionar <input type="number" style="border:0px;background:#F3F3EA;" name="relacionar<?php echo $conteoRelacionesName++;?>"  min="1" max="5"  required></td>
                                                     <td style="text-align:justify;"><?php echo nl2br($extraerRecorridoRelaciones['informacion']);?></td>
                                                     </tr>
                                            <?php
                                                }
                                            ?>
                                            </table>
                                            </div>
                                            <?php
                                            }
                                            
                                        $tipoPregunta=$extraerRecorridoPreguntas['tipoPregunta'];
                                        echo"<input type='hidden' name='idPregunta[]' value= '$id' >";
                                        echo"<input type='hidden' name='tipoPregunta[]' value= '$tipoPregunta' >"; 
                                        ?>
                                       <br>
                                       <div class="card-footer" >
                                        <?php
                                        //echo $conteoExistente++; 
                                        //echo ' -- '.(($conteoExistenteB++)+1);
                                        //if($conteoExistente++ == ($conteoExistenteB++)+1 ){ 
                                        ?>
                                        <span class="btn btn-success float-right" style="display:;" id="siguientePregunta<?php echo $contadorDePreguntas++;?>" >Siguiente >></span>
                                        <?php
                                        //}
                                        ?>
                                        <span class="btn btn-success float-left" style="display:<?php if($validarBotonAnterior++ == 1){ echo 'none'; }else{  }?>;" id="anteriorPregunta<?php echo $contadorDePreguntasAnterior++;?>" ><< Anterior </span>
                                       </div>
                                    </div>
                                    
                            <script> //// funcion del click de preguntas
                                $(document).ready(function(){
                                    $('#siguientePregunta<?php echo $contadorDePreguntasScript++;?>').click(function(){ 
                                        //alert("siguiente: <?php //echo $contadorDePreguntasScriptFuncion++;?> ");
                                        ///// ocultamos la pregunta anterior
                                         document.getElementById('pregunta<?php  echo ($contadorDePreguntasDivB++); ?>').style.display = 'none';
                                         document.getElementById('pregunta<?php  echo ($contadorDePreguntasDivC++)+1; ?>').style.display = '';
                                    });
                                    $('#anteriorPregunta<?php echo $contadorDePreguntasScriptAnterior++;?>').click(function(){ 
                                        ///// mostramos la pregunta anterior
                                         document.getElementById('pregunta<?php  echo ABS(($contadorDePreguntasDivBAnterior++)-1); ?>').style.display = '';
                                         document.getElementById('pregunta<?php  echo ABS(($contadorDePreguntasDivCAnterior++)); ?>').style.display = 'none';
                                    });
                                });
                            </script>   
                            <?php
                            }
                            
                        }
                        ?>
                        </div>
                        <div class="card-footer" >   
                        <?php
                        if($respuestaPreguntaCapacitacion['id'] != NULL){ }else{
                        ?>
                            <span type="submit" class="btn btn-primary float-right" data-toggle='modal' data-target='#modal-danger' >Finalizar</span>
                        <?php
                        }
                        ?>    
                            <!-- colocamos una alerta para verificar si está seguro de finalizar la evaluación -->
                            <div class="modal fade" id="modal-danger">
                                <div class="modal-dialog">
                                  <div class="modal-content bg-info">
                                    <div class="modal-header">
                                      <h4 class="modal-title">Alerta</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <p>¿Est&aacute; seguro de finalizar la capacitación?</p>
                                    </div>
                                    
                                    
                                    <div class="modal-footer justify-content-between">
                                     
                                      <button type="submit" name="crearEvaluacion" class="btn btn-outline-light">Si</button>
                                      <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                                    </div>
                                     
                                     
                                  </div>
                                </div>
                            </div>
                            <!-- END -->
                        </div>
                        </form>
                </div>
            </div>
            
            
                      
                                   

          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
     
    </section>
    <!-- End Formulario -->
    
     <!-- Formulario -->
   <section class="content-header" id="materiales" style="display:none;">
         <div class="container-fluid">
            <div class="row">
                <div class="col-sm">
               
                <div class="card card-info" >
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
                                     
                                     
                                     <input value="<?php echo $evaluacionVer;?>" name="idEvaluacion" id="idEvaluacion" type="hidden">
                                   
                                     <!-- END-->
                                    <script>
                         
                                        
                                            // traemos los datos de la consulta, después de hacer el primer click, trae los datos actualizados después de agregar otro producto
                                                $(document).on('click', '#botonVisualizar', function(e){
                                                	e.preventDefault();
                                                	var idEvaluacion = $('#idEvaluacion').val(),
                                                	    idEvaluacionEditar = $('#idEvaluacionEditar').val();
                                                	
                                                	$.ajax({
                                                		url: 'evaluacionJSP.php', // Es importante que la ruta sea correcta si no, no se va a ejecutar
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
                           
                </div>
            </div>  
        </div>      
        <div class="row">
           
          <!-- /.col (LEFT) -->
          <div class="col-md-12">
            <!-- LINE CHART -->
            
          
          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
     
    </section>
    <!-- End Formulario -->
    
    
    
    

            <script> //// Evento para cambiar entre el formulario de preguntas y el formulario de material de trabajo
                $(document).ready(function(){
                    $('#botonVisualizar').click(function(){ 
                        document.getElementById('capacitacion').style.display = 'none';
                        document.getElementById('mostrarBotonDocumento').style.display = 'none'; 
                        document.getElementById('mostrarBotonCapacitacion').style.display = '';
                        document.getElementById('materiales').style.display = '';
                    });
                    $('#botonVisualizarCapacitacion').click(function(){ 
                        document.getElementById('capacitacion').style.display = '';
                        document.getElementById('mostrarBotonDocumento').style.display = ''; 
                        document.getElementById('mostrarBotonCapacitacion').style.display = 'none';
                        document.getElementById('materiales').style.display = 'none';
                    });
                    
                   
                });
            </script>         
    
    
    
                       
    
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
              title: ' La cédula ya existe con otro usuario, asegúrese que el número de documento permanezca al usuario que se encuentra editando.'
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
