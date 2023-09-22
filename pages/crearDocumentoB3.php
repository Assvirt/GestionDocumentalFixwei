<?php
session_start();
date_default_timezone_set("America/Bogota");
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
require_once 'conexion/bd.php';

error_reporting(E_ERROR);    
    $idSolicitud = $_POST['idSolicitud'];
    $nombreDoc = $_POST['nombreDocumento'];
    $norma = $_POST['norma'];
    $proceso = $_POST['proceso'];
    $metodo = $_POST['rad_metodo'];
    $tipoDoc = $_POST['tipoDoc'];
    $ubicacion = $_POST['ubicacion'];
    $elabora = $_POST['select_encargadoE'];
    $revisa = $_POST['select_encargadoR'];
    $aprueba = $_POST['select_encargadoA'];
    $radElabora = $_POST['radiobtnE'];
    $radRevisa = $_POST['radiobtnR'];
    $radAprueba = $_POST['radiobtnA'];
    $codificacion = $_POST['radCodificacion'];
    $versionDeclarada = $_POST['versionDeclarada'];
    $consecutivoDeclarada = $_POST['consecutivoDeclarado'];
    
    
    $html = htmlentities($_POST['editor1']);
    
     '1: '.$nombrePDF = $_FILES['archivopdf']['name']; 
    $rutaPDF =$_FILES['archivopdf']['tmp_name']; 
     '<br>2: '.$nombreOtro =$_FILES['archivootro']['name'];
    $rutaOtro =$_FILES['archivootro']['tmp_name'];
    
    $documetosExternos = $_POST['documentos_externos'];
    $definiciones = $_POST['definiciones'];
    
    $archivo_gestion = $_POST['archivo_gestion']; 
    $archivo_central = $_POST['archivo_central']; 
    $archivo_historico = $_POST['archivo_historico']; 
    
    $diposicion_documental = $_POST['diposicion_documental'];
    $select_encargadoD = $_POST['select_encargadoD'];
    $radDispoDoc = $_POST['radiobtnD'];

    $fecha = date("Ymjhis");

    $rol = "Encargado(a) solicitud";


    if(!file_exists('archivos/documentos/')){
    	mkdir('archivos/documentos',0777,true);
    	if(file_exists('archivos/documentos/')){
    		if(move_uploaded_file($rutaPDF, 'archivos/documentos/'.$fecha.$nombrePDF)){
    			
    		}else{
    			//echo "Archivo no se pudo guardar";
    		}
    	}
    }else{
    	if(move_uploaded_file($rutaPDF, 'archivos/documentos/'.$fecha.$nombrePDF)){
    	
    	}else{
    		//echo "Archivo no se pudo guardar";
    	}
    }
    
    if(!file_exists('archivos/documentos/')){
    	mkdir('archivos/documentos',0777,true);
    	if(file_exists('archivos/documentos/')){
    		if(move_uploaded_file($rutaOtro, 'archivos/documentos/'.$fecha.$nombreOtro)){
    			//echo "Archivo guardado con exito";
    			
    		}else{
    			//echo "Archivo no se pudo guardar";
    		}
    	}
    }else{
    	if(move_uploaded_file($rutaOtro, 'archivos/documentos/'.$fecha.$nombreOtro)){
    		//echo "Archivo guardado con exito";
    	}else{
    		//echo "Archivo no se pudo guardar";
    	}
    }
    
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Crear documento</title>
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
            <h1>Crear Documento</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Crear documento</li>
            </ol>
          </div>
        </div>
        <!--<div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                <div class="row">
                    <div class="col-sm">
                        <button type="button" class="btn btn-block btn-success btn-sm"><a href="crearDocumento2"><font color="white"><i class="fas fa-chevron-left"></i> Regresar</font></a></button>
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
        </div>-->
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
              <!-- form start controlador/documentos/controllerDocumentos -->
              <form role="form" action="controlador/documentos/controllerDocumentos" method="POST">
                <div class="card-body">
                    <div class="row">
                        <!-- <div class="form-group col-sm-12">
                            <label>Flujo de aprobación</label>
                            <br> -->
                            <input type="hidden" id="rad_flujo" name="rad_flujo" value="reinicia" required>
                            <!--<label>Reinicia flujo de aprobación</label>
                            <br> -->
                            <input type="hidden" id="rad_reinicio" name="rad_flujo" value="ajusta" checked required>
                        <!--    <label>Ajusta y continua flujo de aprobación</label>
                            <br> -->
                            <input type="hidden" id="rad_cierra" name="rad_flujo" value="cierra" required>
                        <!--    <label>Cierra solicitud documental</label>
                         </div> -->
                        
                        <div class="form-group col-sm-6">
                            <label>Meses para próxima revisión</label>
                            <input name="mesesRevision" type="number" min="1" max="24" required>
                        </div>
                        
                        <div class="form-group col-sm-12">
                            <label>Quién elaboró: </label>
                            <?php 
                                $elabora;
                                $elaboraN = unserialize($elabora); // para la notificación creación
                                $radElabora;
                                array_unshift($elaboraN,$radElabora);
                                $elaboraT=json_encode($elaboraN);
                                $elaboraTS=json_decode($elaboraT);
                               
                                                if($elaboraTS[0] == 'cargos' || $elaboraTS[0] == 'usuarios') {   
                                                    if($elaboraTS[0] == 'cargos'){
                                                        $longitud = count($elaboraTS);
                                                        
                                                        for($i=1; $i<$longitud; $i++){
                                                            //saco el valor de cada elemento
                                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$elaboraTS[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                                                        	echo "<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                        	$elaboraUsuario=$nombres['nombreCargos'];
                                                        }            
                                                    }
                                                    
                                                    if($elaboraTS[0] == 'usuarios'){ 
                                                        $longitud = count($elaboraTS);
                                                        
                                                        for($i=1; $i<$longitud; $i++){
                                                            //saco el valor de cada elemento
                                                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$elaboraTS[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                                                        	echo "<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                        	$elaboraUsuario=$nombres['cedula'];
                                                        } 
                                                    }
                                                }else{
                                                    echo $elaboraUsuario=$elabora;
                                                }
                            ?>
                            <div class="input-group" style="width:30%;">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                <input type="date" id="primerafecha" name="fechaElaboracion" class="form-control float-right" id="reservationtime" required>
                                <!-- este input es para mostrar la fecha sin dejarse modificar después de validar las fechas -->
                                    <input style="display:none;" type="date" id="mostrarPrimeraFecha"  class="form-control float-right" id="reservationtime" readonly required>
                                <!-- END -->
                            </div>
                            
                            <input class="form-control" name="controlCambios" placeholder="Comentarios..." required>
                            <br>
                            <label>Quién revisó: </label>
                             <?php 
                                $revisa;
                                $revisaN = unserialize($revisa); // para la notificación creación
                                $radRevisa;
                                array_unshift($revisaN,$radRevisa);
                                $revisaT=json_encode($revisaN);
                                $revisaTS=json_decode($revisaT);
                                                if($revisaTS[0] == 'cargos' || $revisaTS[0] == 'usuarios') {   
                                                    if($revisaTS[0] == 'cargos'){
                                                        $longitud = count($revisaTS);
                                                        
                                                        for($i=1; $i<$longitud; $i++){
                                                            //saco el valor de cada elemento
                                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$revisaTS[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                                                        	echo "<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                        	$revisaUsuario=$nombres['nombreCargos'];
                                                        }            
                                                    }
                                                    
                                                    if($revisaTS[0] == 'usuarios'){ 
                                                        $longitud = count($revisaTS);
                                                        
                                                        for($i=1; $i<$longitud; $i++){
                                                            //saco el valor de cada elemento
                                                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$revisaTS[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                                                        	echo "<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                        	$revisaUsuario=$nombres['cedula'];
                                                        } 
                                                    }
                                                }else{
                                                    echo $revisaUsuario=$revisa;
                                                }
                             ?>
                            <div class="input-group" style="width:30%;">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                <input type="date" id="segundafecha" name="fechaRevision" class="form-control float-right" id="reservationtime" required>
                                <!-- este input es para mostrar la fecha sin dejarse modificar después de validar las fechas -->
                                    <input style="display:none;" type="date" id="mostrarSegundaFecha"  class="form-control float-right" id="reservationtime" readonly required>
                                <!-- END -->
                            </div>
                            <input class="form-control" name="comentarioRevision" placeholder="Comentarios..." required>
                            <br>
                            <label>Quién aprobó: </label>
                             <?php 
                                $aprueba; 
                                $apruebaN = unserialize($aprueba); // para la notificación creación
                                array_unshift($apruebaN,$radAprueba);
                                $apruebaT=json_encode($apruebaN);
                                $apruebaTS=json_decode($apruebaT);
                               
                                                if($apruebaTS[0] == 'cargos' || $apruebaTS[0] == 'usuarios') {   
                                                    if($apruebaTS[0] == 'cargos'){
                                                        $longitud = count($apruebaTS);
                                                        
                                                        for($i=1; $i<$longitud; $i++){
                                                            //saco el valor de cada elemento
                                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$apruebaTS[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                                                        	echo "<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                        	$apruebaUsuario=$nombres['nombreCargos'];
                                                        }            
                                                    }
                                                    
                                                    if($apruebaTS[0] == 'usuarios'){ 
                                                        $longitud = count($apruebaTS);
                                                        
                                                        for($i=1; $i<$longitud; $i++){
                                                            //saco el valor de cada elemento
                                                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$apruebaTS[$i]'");
                                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                                                        	echo "<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                        	$apruebaUsuario=$nombres['cedula'];
                                                        } 
                                                    }
                                                }else{
                                                    echo $apruebaUsuario=$aprueba;
                                                }
                             ?>
                             
                             
                             
                            <div class="input-group" style="width:30%;">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                    <input type="date" id="terceraFecha" name="fechaAprobacion" class="form-control float-right" id="reservationtime" required>
                                    <!-- este input es para mostrar la fecha sin dejarse modificar después de validar las fechas -->
                                        <input style="display:none;" type="date" id="mostrarSTercerFecha"  class="form-control float-right" id="reservationtime" readonly required>
                                    <!-- END -->
                            </div>
                            
                            <input class="form-control" name="comentarioAprobo" placeholder="Comentarios..." required>
                            <br>
                            <!--
                            <label>Control de cambios: </label>
                            <textarea rows="2" class="form-control" name="controlCambios" placeholder="Control de cambios" required></textarea>
                            <br>
                            -->
                            <!-- podemos enviar el tipo de flujo de usuarios para el almacenamiento -->
                            <?php
                                $verificandoUsuariosActivosRetirados=$_POST['almacenamientoArray'];
                            ?>
                            <input value="<?php echo $verificandoUsuariosActivosRetirados; ?>" name="almacenamientoArray" type="hidden">
                            <!-- END -->
                            <input name="nombreElaboro" value="<?php echo $elaboraUsuario; ?>" type="hidden" readonly required>
                            <input name="nombreReviso" value="<?php echo $revisaUsuario; ?>" type="hidden" readonly required>
                            <input name="nombreAprobo" value="<?php echo $apruebaUsuario; ?>" type="hidden" readonly required>
                            
                            <input type="radio" id="aprobado" name="radiobtnAprobado" value="aprobado" checked required>
                            <label id="tituloAprobado"> Aprobado</label>
                            
                            <input style="display:none;" type="radio" id="rechazado" name="radiobtnAprobado" value="rechazado" required>
                            <label style="display:none;" id="tituloRechazado"> Rechazado</label>
                        
                        </div>
                        
                    </div>
        
                 
                  
                  
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                    <!--Envio variables ocultas-->
                    <input type="hidden" name="rol" value="<?php echo $rol;?>"> 
                    <input type="hidden" name="idSolicitud" value="<?php echo $idSolicitud ;?>" >
                    <input type="hidden" name="nombreDocumento" value="<?php echo $nombreDoc ;?>" >
                    <input type="hidden" name="norma" value='<?php echo $norma;?>' >
                    <input type="hidden" name="proceso" value="<?php echo $proceso ;?>" >
                    <input type="hidden" name="rad_metodo" value="<?php echo $metodo ;?>" >
                    <input type="hidden" name="tipoDoc" value="<?php echo $tipoDoc ;?>" >
                    <input type="hidden" name="ubicacion" value="<?php echo $ubicacion ;?>" >
                    
                    <?php
                        if($_POST['almacenamientoArray'] == 'activosUsuarios'){
                    ?>
                    <input type="hidden" name="select_encargadoE" value='<?php echo $elaboraT;?>' >
                    <input type="hidden" name="select_encargadoR" value='<?php echo $revisaT;?>' >
                    <input type="hidden" name="select_encargadoA" value='<?php echo $apruebaT;?>' >
                    <?php
                        }
                     
                    if($_POST['almacenamientoArray'] == 'retiradosUsuarios'){
                    ?>
                    <input type="hidden" name="select_encargadoE" value='<?php echo $elabora;?>' >
                    <input type="hidden" name="select_encargadoR" value='<?php echo $revisa;?>' >
                    <input type="hidden" name="select_encargadoA" value='<?php echo $aprueba;?>' >
                    <?php
                    }
                    ?>
                    <input type="hidden" name="radiobtnE" value="<?php echo $radElabora; ?>">
                    <input type="hidden" name="radiobtnR" value="<?php echo $radRevisa; ?>">
                    <input type="hidden" name="radiobtnA" value="<?php echo $radAprueba; ?>">
                    
                    
                    <input type="hidden" name="radCodificacion" value="<?php echo $codificacion;?>">
                    <input type="hidden" name="versionDeclarada" value="<?php echo $versionDeclarada;?>">
                    <input type="hidden" name="consecutivoDeclarado" value="<?php echo $consecutivoDeclarada;?>">
                    <!--Datos de crearDocumento 2-->

                    <input type="hidden" name="editorHtml"  value="<?php echo $html?>" >
                    <input type="hidden" name="nombrePDF" value="<?php if($nombrePDF != NULL){echo $fecha.$nombrePDF;} ?>">
                    <input type="hidden" name="rutaPDF" value="<?php echo $rutaPDF ;?>">
                    <input type="hidden" name="nombreOtro" value="<?php if($nombreOtro != NULL){echo $fecha.$nombreOtro;} ?>">
                    <input type="hidden" name="rutaOtro" value="<?php echo $rutaOtro ;?>">
                    <input type="hidden" name="documentos_externos" value='<?php echo serialize($documetosExternos) ;?>'>
                    <input type="hidden" name="definiciones" value='<?php echo serialize($definiciones) ;?>'>
                    <input type="hidden" name="archivo_gestion" value="<?php echo $archivo_gestion ;?>">
                    <input type="hidden" name="archivo_central" value="<?php echo $archivo_central ;?>">
                    <input type="hidden" name="archivo_historico" value="<?php echo $archivo_historico ;?>">
                    <input type="hidden" name="diposicion_documental" value="<?php echo $diposicion_documental ;?>">
                    <!-- select_encargadoD: este es el encargado de la disposicion documental -->
                    <?php
                    if($_POST['validandoUsuarios'] == 'activosUsuariosResponsable'){
                        $select_encargadoD;
                        array_unshift($select_encargadoD,$radDispoDoc);
                        $select_encargadoDNT=json_encode($select_encargadoD);
                       
                    ?>
                    <input type="hidden" name="select_encargadoD" value='<?php echo $select_encargadoDNT;?>'>
                    <?php
                    }
                    
                    if($_POST['validandoUsuarios'] == 'retiradosUsuariosResponsable'){
                    ?>
                     <input type="hidden" name="select_encargadoD" value='<?php echo $select_encargadoD;?>'>
                    <?php
                    }
                    ?>
                    <input type="hidden" name="radiobtnD" value="<?php echo $radDispoDoc; ?>">
                    
                    <a href="#" id="ocultarValidarFecha" class="btn btn-success float-right" onclick="funcionFormula()" >Validar fecha</a>
                    <button type="submit" name="agregarDocB" id="mostrarBotonFinalizar" style="display:none;" class="btn btn-success float-right">Finalizar >></button>
                  
                                <script>
                                   /// validamos si la fecha está bien digitada o no
                                    function funcionFormula(){ 
                                       //// capturamos las variables de las fechas
                                       fechaAprobacionPrimera = document.getElementById("primerafecha").value;
                                       fechaAprobacionSegunda = document.getElementById("segundafecha").value;
                                       fechaAprobacion = document.getElementById("terceraFecha").value;
                                       //// END
                                       
                                       /// validamos si la fecha de aprobación es menor que la fecha de elaboración y revisor
                                       if(fechaAprobacion < fechaAprobacionSegunda || fechaAprobacion < fechaAprobacionPrimera || fechaAprobacionSegunda < fechaAprobacionPrimera || fechaAprobacionPrimera == ''){
                                            //alert('La fecha de aprobación no puede ser menor a la fecha de revisión');
                                             const Toast = Swal.mixin({
                                              toast: true,
                                              position: 'top-end',
                                              showConfirmButton: false,
                                              timer: 3000
                                            });
                                            
                                            
                                                Toast.fire({
                                                    type: 'warning',
                                                    title: ' La fecha de aprobación no puede ser menor a la fecha de revisión ó de la fecha de elaboración.'
                                                })
                                       }else{
                                            //// en caso que la fecha esté correcta nos ejecuta esta acción para activar el botón de manera automatica
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
                                            //// END
                                           
                                       }
                                       /// END
                                    }
                                    /// END  
                                </script>
                               
                                <!-- al momento que se ejecuta el script de manera automatica, acciona este botón para simular el click y poder habilitar el botón oculto -->
                                    <a href="#" id="action-button" style="display:none;" onclick="enviar()" >Mostrara botón</a>
                                <!-- END -->
                                
                                <!-- al momento de ejecutar la simulación del botón de las fechas esta función se ejecuta para mostrar el botón de finalizar -->
                                    <script>
                                        function enviar(){
                                            document.getElementById('mostrarBotonFinalizar').style.display = '';
                                            document.getElementById('ocultarValidarFecha').style.display = 'none';
                                            
                                            ///// montamos las fechas para que solo sean visuales y no nos deje modificarlas y habilitamos el input date 
                                            document.getElementById("mostrarPrimeraFecha").value = document.getElementById("primerafecha").value;
                                            document.getElementById('mostrarPrimeraFecha').style.display = '';
                                            
                                            document.getElementById("mostrarSegundaFecha").value = document.getElementById("segundafecha").value;
                                            document.getElementById('mostrarSegundaFecha').style.display = '';
                                            
                                            document.getElementById("mostrarSTercerFecha").value = document.getElementById("segundafecha").value;
                                            document.getElementById('mostrarSTercerFecha').style.display = '';
                                            /// END
                                            
                                            ///// luego ocultamos la fecha original y enviamos los datos sin poder modificar 
                                            document.getElementById('primerafecha').style.display = 'none';
                                            document.getElementById('segundafecha').style.display = 'none';
                                            document.getElementById('terceraFecha').style.display = 'none';
                                            //// END
                                        }
                                    </script>
                                <!-- END -->
                </div>
              </form>
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
<!--Oculta div-->
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
<!--Ckeditor-->
<script>
    CKEDITOR.replace( 'editor1' );
</script>
                
        <script>
            $(document).ready(function(){
                $('#rad_flujo').click(function(){
                    document.getElementById('aprobado').style.display = 'none';
                    document.getElementById('rechazado').style.display = '';
                    document.getElementById('tituloRechazado').style.display = '';
                    document.getElementById('tituloAprobado').style.display = 'none';
                });
            });
            $(document).ready(function(){
                $('#rad_reinicio').click(function(){
                    document.getElementById('aprobado').style.display = '';
                    document.getElementById('rechazado').style.display = 'none';
                    document.getElementById('tituloRechazado').style.display = 'none';
                    document.getElementById('tituloAprobado').style.display = '';
                });
            
            });
            $(document).ready(function(){
                $('#rad_cierra').click(function(){
                    document.getElementById('aprobado').style.display = 'none';
                    document.getElementById('rechazado').style.display = '';
                    document.getElementById('tituloRechazado').style.display = '';
                    document.getElementById('tituloAprobado').style.display = 'none';
                });
            
            });
        </script>
        <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>

<script type="text/javascript">
  $(function() {
   
    
    
  });

</script>
</body>
</html>
<?php
}
?>