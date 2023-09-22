<?php error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
require_once 'conexion/bd.php';
    
    $rolFlujo = $_POST['rol'];
    $idDocumento = $_POST['idDocumento'];
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
    
    $acentos = $mysqli->query("SET NAMES 'utf8'");
    $queryDoc = $mysqli->query("SELECT * FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
    $datosDoc = $queryDoc->fetch_assoc();
    
    $idUsuario = $_SESSION['session_idUsuario'];
    if($datosDoc['asumeFlujo'] == $idUsuario){//sE VALIDA QUE SEA EL USUARIO QUE TOMO PRIMERO LA SOLICITUD. 
        

    }else{
        
        if($datosDoc['asumeFlujo'] == NULL){
        ?>    
            <script> 
                 window.onload=function(){
               
                     document.forms["sacarDelFlujo"].submit();
                 }
                 setTimeout(clickbuttonScarFlujo, 0999);
                 function clickbuttonScarFlujo() { 
                    document.forms["sacarDelFlujo"].submit();
                 }
            </script>
             
            <form name="sacarDelFlujo" action="creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="idDocumento" value="<?php echo $idDocumento;?>">
                <input type="hidden" name="validacionUsuario2" value="1">
            </form>
    <?php    
        }else{
    ?>    
            <script> 
                 window.onload=function(){
               
                     document.forms["sacarDelFlujo"].submit();
                 }
                 setTimeout(clickbuttonScarFlujo, 1000);
                 function clickbuttonScarFlujo() { 
                    document.forms["sacarDelFlujo"].submit();
                 }
            </script>
             
            <form name="sacarDelFlujo" action="creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="idDocumento" value="<?php echo $idDocumento;?>">
                <input type="hidden" name="validacionUsuario" value="1">
            </form>
    <?php    
        }
     
    }
    
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Revisar documento</title>
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
  <?php echo require_once'menu.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
                      <?php
            /// de acuerdo al rol de la persona cambia el título
            $elaboraValidacion = json_decode($datosDoc['elaboraElimanar']);
            $revisaValidacion = json_decode($datosDoc['revisaElimanar']);
            $apruebaValidacion = json_decode($datosDoc['apruebaElimanar']);
            
          
            ///////////////////////////// para el elaborador
                if($elaboraValidacion[0] == 'usuarios'){
                    $longitudValidacion = count($elaboraValidacion);
                                                        
                    for($i=1; $i<$longitudValidacion; $i++){
                                                            //saco el valor de cada elemento
                        $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE id = '$elaboraValidacion[$i]'");
                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                    	//$variableValidado=$nombres['id'];
                    	if($idparaChat == $elaboraValidacion[$i]){                                    
                    	    $variableValidado=$nombres['id'];
                        }else{
                            continue;
                        }  
                    } 
                }
                elseif($elaboraValidacion[0] == 'cargos'){
                    $longitudCValidacion = count($elaboraValidacion);
                                                        
                    for($i=1; $i<$longitudCValidacion; $i++){
                                                            //saco el valor de cada elemento
                        $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE cargo = '$elaboraValidacion[$i]' AND id='$idparaChat' ");
                        while($nombres = $queryNombres->fetch_array()){ 
                                                            
                    	$variableValidado=$nombres['id'];
                        }
                    } 
                }
            
            /////////////////////////////// para el revisor
                if($revisaValidacion[0] == 'usuarios'){
                    $longitudBValidacion = count($revisaValidacion);
                                                        
                    for($i=1; $i<$longitudBValidacion; $i++){
                                                            //saco el valor de cada elemento
                        $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE id = '$revisaValidacion[$i]'");
                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                    	//$variableValidadoB=$nombres['id'];
                    	if($idparaChat == $revisaValidacion[$i]){                                    
                    	    $variableValidadoB=$nombres['id'];
                        }else{
                            continue;
                        }
                    } 
                }elseif($revisaValidacion[0] == 'cargos'){
                    $longitudCValidacion = count($revisaValidacion);
                                                        
                    for($i=1; $i<$longitudCValidacion; $i++){
                                                            //saco el valor de cada elemento
                        $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE cargo = '$revisaValidacion[$i]' AND id='$idparaChat' ");
                        while($nombres = $queryNombres->fetch_array()){ 
                                                            
                    	$variableValidadoB=$nombres['id'];
                        }
                    } 
                }
            
            
            ////////////////////////////// para el aprobador
                if($apruebaValidacion[0] == 'usuarios'){
                    $longitudCValidacion = count($apruebaValidacion);
                                                        
                    for($i=1; $i<$longitudCValidacion; $i++){
                                                            //saco el valor de cada elemento
                        $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE id = '$apruebaValidacion[$i]'");
                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                            
                    	//$variableValidadoC=$nombres['id'];
                    	if($idparaChat == $apruebaValidacion[$i]){                                    
                    	    $variableValidadoC=$nombres['id'];
                        }else{
                            continue;
                        } 
                    } 
                }elseif($apruebaValidacion[0] == 'cargos'){
                    $longitudCValidacion = count($apruebaValidacion);
                                                        
                    for($i=1; $i<$longitudCValidacion; $i++){
                                                            //saco el valor de cada elemento
                        $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE cargo = '$apruebaValidacion[$i]' AND id='$idparaChat' ");
                        while($nombres = $queryNombres->fetch_array()){ 
                                                            
                    	$variableValidadoC=$nombres['id'];
                        }
                    } 
                }
                
                
            /*    
            if($variableValidado == $datosDoc['asumeFlujo'] && $datosDoc['estadoElimina'] == null || $datosDoc['estadoElimina'] == 'Pendiente'){
                $títulRol='Crear documento';
            }elseif($variableValidadoB == $datosDoc['asumeFlujo'] && $datosDoc['estadoElimina'] == 'Elaborado'){ 
                $títulRol='Revisar documento';
            }elseif($variableValidadoC == $datosDoc['asumeFlujo'] && $datosDoc['estadoElimina'] == 'Revisado'){ 
                $títulRol='Aprobar documento';
            }else{
                $títulRol='Asignar documento';
            }*/
            
             
             // consultamos el usuario de la sesión para verificar que tenga el mismo cargo para la aprobación del documento
            $celdulaUser = $_SESSION['session_username']; 
            $query_busqueda_cargo = $mysqli->query("SELECT  cedula,cargo FROM usuario WHERE cedula = '$celdulaUser'");
            $nombres_busqueda_cargo = $query_busqueda_cargo->fetch_array(MYSQLI_ASSOC);
            
            $enviar_id_solicitud=$datosDoc['id_solicitud'];
            /// traemos el cargo asociado que está en la solicitud
            $query_busqueda_cargo_solicitud = $mysqli->query("SELECT  * FROM solicitudDocumentos WHERE id = '$enviar_id_solicitud'");
            $nombres_busqueda_cargo_solicitud = $query_busqueda_cargo_solicitud->fetch_array(MYSQLI_ASSOC);
            
             '<br> quien aprieba: '.$nombres_busqueda_cargo_solicitud['QuienAprueba'];
            ' - '.$nombres_busqueda_cargo['cargo'];
            
                
            if($variableValidado == $datosDoc['asumeFlujo'] && $datosDoc['estadoElimina'] == null || $variableValidado == $datosDoc['asumeFlujo'] && $datosDoc['estadoElimina'] == 'Pendiente'){
                $títulRol='Crear documento';
                $activador_usuario='Si';
            }elseif($variableValidadoB == $datosDoc['asumeFlujo'] && $datosDoc['estadoElimina'] == 'Elaborado'){ 
                $títulRol='Revisar documento';
                $activador_usuario='Si';
            }elseif($variableValidadoC == $datosDoc['asumeFlujo'] && $datosDoc['estadoElimina'] == 'Revisado'){ 
                $títulRol='Aprobar documento';
                $activador_usuario='Si';
            }else{ /// verificamos que los roles estén ingresando, tmabién verificamos que el encargado que es el aprobador, sea quien tenga el documento abierto
                if($activador_usuario != NULL){ //echo 'a 1';
                    $títulRol='Asignar documento';
                }elseif($nombres_busqueda_cargo_solicitud['QuienAprueba'] == $celdulaUser && $datosDoc['estadoElimina'] == null || $nombres_busqueda_cargo_solicitud['QuienAprueba'] == $celdulaUser && $datosDoc['estadoElimina'] == 'Pendiente'){ //echo 'a 2';
                    $títulRol='Asignar documento';
                }else{
                    $títulRol==NULL;
                }
            }
             
             if($títulRol == NULL){
                 //echo 'Campo vacio';
                 //$update = $mysqli->query("UPDATE documento SET asumeFlujo = null WHERE id = '$idDocumento' ");
                 ?>
                    <script> 
                         window.onload=function(){
                            // document.forms["documentoValidarSinEstado"].submit();
                         }
                         setTimeout(clickbuttonArchivoPerfil, 2000);
                         function clickbuttonArchivoPerfil() { 
                            document.forms["documentoValidarSinEstado"].submit();
                         }
                    </script>
                     
                    <form name="documentoValidarSinEstado" action="creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                        <input value="1" name="alertaSinMensaje" type="hidden">
                    </form>
                <?php
             }
             
            ?>
            <h1><?php echo $títulRol;?></h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active"><?php echo $títulRol;?></li>
            </ol>
          </div>
        </div>
        <!--<div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                <div class="row">
                    <div class="col-sm">
                        <button type="button" class="btn btn-block btn-success btn-sm"><a href="crearDocumento"><font color="white"><i class="fas fa-chevron-left"></i> Regresar</font></a></button>
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
                <h3 class="card-title"> </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="eliminarDoc3" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        
                        <?php
                            if($metodo != "documento"){
                        ?>
                        <div class="form-group col-sm-12">
                            <textarea name="editor1" required><?php echo $datosDoc['htmlDoc']; ?></textarea>
                        </div>
                        <?php }else{?>
                        
                        <?php

                        
                            if($datosDoc['nombrePDF'] == NULL){
                                $disabledPDF = "disabled";    
                            }else{
                                $disabledPDF= "#";
                                $rutaPDF = "archivos/documentos/".$datosDoc['nombrePDF'];
                            }
                            
                            if($datosDoc['nombreOtro'] == NULL){
                                $disabledOtro = "disabled";
                                $rutaOtro = "#";
                            }else{
                                $disabledOtro = "";
                                $rutaOtro = "archivos/documentos/".$datosDoc['nombreOtro'];
                            }
                        ?>
                        <div class="form-group col-sm-6">
                            <label for="exampleInputFile">Documento PDF</label>
                            <?php
                            if($disabledPDF == 'disabled'){
                            ?>
                            <button type='button'  class='btn btn-block btn-warning btn-sm  <?php echo $disabledPDF;?>'>
                                <a style='color:black' href='#' ><i class='fas fa-download'></i> Descargar</a>
                            </button>
                            <?php
                            }else{
                            ?>
                            <button type='button'  class='btn btn-block btn-warning btn-sm  <?php echo $disabledPDF;?>'>
                                <a style='color:black' href='<?php echo $rutaPDF;?>' target="_blank" ><i class='fas fa-download'></i> Descargar</a>
                            </button>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="exampleInputFile">Documento editable</label>
                            <?php
                            if( $disabledOtro == 'disabled'){
                            ?>
                            <button type='button'  class='btn btn-block btn-warning btn-sm <?php echo $disabledOtro;?>' >
                               <a style='color:black' href='#' > <i class='fas fa-download'></i> Descargar</a>
                            </button>
                            <?php
                            }else{
                            ?>
                            <button type='button'  class='btn btn-block btn-warning btn-sm <?php echo $disabledOtro;?>' >
                               <a style='color:black' href='<?php echo $rutaOtro;?>' target="_blank" > <i class='fas fa-download'></i> Descargar</a>
                            </button>
                            <?php
                            }
                            ?>
                        </div>
                        <?php }?>
                        
                        
                        <style>
                        /*
                          .pointer-events-none {
                            pointer-events: none;
                        }
                        
                        .wrapper {
                            cursor: not-allowed;
                        }
                        */
                        </style>
                        <div class="form-group col-sm-6" disabled>
                            <?php
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT id, nombre FROM documentoExterno");
                                $arrayDocE = json_decode($datosDoc['documento_externo']);
                            ?>
                            <label>Documentos externos: </label>
                            <span disabled>
                              <select class="duallistbox" name="documentos_externos[]" multiple >
                                <?php
                                    while ($columna = mysqli_fetch_array( $resultado )) {
                                      if($arrayDocE != NULL){
                                        if(in_array($columna['id'],$arrayDocE)){
                                            $seleccionarDocE = "selected";        
                                        }else{
                                            $seleccionarDocE ="";
                                        }
                                      }
                                    ?>
                                    <option value="<?php echo $columna['id']; ?>" <?php echo $seleccionarDocE; ?>><?php echo $columna['nombre']; ?> </option>
                                <?php }  ?>
                              </select>
                              </span>
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <?php
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT id, nombre FROM definicion");
                                $arrayDefiniciones = json_decode($datosDoc['definiciones']);
                            ?>
                            <label>Definiciones: </label>
                              <select class="duallistbox" id="dual-list-disabled-state" multiple disabled name="definiciones[]">
                                <?php
                                    while ($columna = mysqli_fetch_array( $resultado )) { 
                                      if($arrayDefiniciones != NULL){
                                        if(in_array($columna['id'],$arrayDefiniciones)){
                                            $seleccionarDef = "selected";        
                                        }else{
                                            $seleccionarDef ="";
                                        }
                                      }
                                    ?>
                                    <option value="<?php echo $columna['id']; ?>" <?php echo $seleccionarDef; ?>><?php echo $columna['nombre']; ?> </option>
                                <?php }  ?>
                              </select>
                        </div>
                        <script>
                           select. duallistbox { background: cyan; }
                        </script>

                        <div class="form-group col-sm-6">
                            <label>Archivo en gestión: </label>
                            <input value="<?php echo $datosDoc['archivo_gestion'];?>" type="text" class="form-control" name="archivo_gestion" placeholder="Archivo en gestión" required readonly>
                                <br>
                            <label>Archivo central: </label>
                            <input value="<?php echo $datosDoc['archivo_central'];?>" type="text" class="form-control" name="archivo_central" placeholder="Archivo central" required readonly>
                                <br>
                            <label>Archivo histórico: </label>
                            <input value="<?php echo $datosDoc['archivo_historico'];?>"type="text" class="form-control" name="archivo_historico" placeholder="Archivo histórico" required readonly>
                            
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <?php
                                //aca voy a validar si son usuarios o cargos los que se encargan de elaborar, revisar, aprobar            
                                
                                $resposableDispoDoc = json_decode($datosDoc['responsable_disposicion']);
                        
                                    if($resposableDispoDoc[0] == 'cargos'){
                                        $checkedDispoC = "checked";            
                                    }
                                    
                                    if($resposableDispoDoc[0] == 'usuarios'){
                                        $checkedDispoU = "checked"; 
                                    }
                                
                                    
                            ?>
                            
                            <label>Disposición Documental: </label>
                            <textarea rows="3" class="form-control" name="diposicion_documental" placeholder="Disposición Documental" required readonly><?php echo $datosDoc['disposicion_documental'];?></textarea>
                            <br>
                            <label>Responsable de disposición: </label><br>
                            <?php
                            if($resposableDispoDoc != NULL){ 
                            ?>
                                <input type="radio" id="rad_cargoD" name="radiobtnD" value="cargos" <?php echo $checkedDispoC;?> >
                                <label for="cargo">Cargo</label>
                                <input type="radio" id="rad_usuarioD" name="radiobtnD" value="usuarios" <?php echo $checkedDispoU;?> >
                                <label for="usuarios">Usuarios</label>
                                <div class="select2-blue">
                                    <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoD[]" id="select_encargadoD" required></select>
                                </div>
                            <?php
                            }else{
                            ?><br><br>
                                <div class="select2-blue">
                                    <input class="form-control" value="<?php echo $datosDoc['responsable_disposicion']; ?>" type="text" readonly>
                                    <input  name="select_encargadoD[]" value="<?php echo $datosDoc['responsable_disposicion']; ?>" type="hidden" >
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        
                        
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

                <div class="card-footer" >
                    <!--Envio variables ocultas-->
                    <input type="hidden" name="rol" value="<?php echo $rolFlujo;?>"> 
                    <input type="hidden" name="idDocumento" id="idDocumento" value="<?php echo $idDocumento ;?>" >
                    <input type="hidden" name="nombreDocumento" value="<?php echo $nombreDoc ;?>" >
                    <input type="hidden" name="norma" value='<?php echo serialize($norma);?>' >
                    <input type="hidden" name="proceso" value="<?php echo $proceso ;?>" >
                    <input type="hidden" name="rad_metodo" value="<?php echo $metodo ;?>" >
                    <input type="hidden" name="tipoDoc" value="<?php echo $tipoDoc ;?>" >
                    <input type="hidden" name="ubicacion" value="<?php echo $ubicacion ;?>" >
                    <input type="hidden" name="select_encargadoE" value='<?php echo serialize($elabora) ;?>' >
                    <input type="hidden" name="select_encargadoR" value='<?php echo serialize($revisa) ;?>' >
                    <input type="hidden" name="select_encargadoA" value='<?php echo serialize($aprueba) ;?>' >

                    <input type="hidden" name="radiobtnE" value="<?php echo $radElabora; ?>">
                    <input type="hidden" name="radiobtnR" value="<?php echo $radRevisa; ?>">
                    <input type="hidden" name="radiobtnA" value="<?php echo $radAprueba; ?>">
                    
                  <button id="" type="submit" name="agregarDoc" class="btn btn-success float-right">Siguiente >></button> <!-- validarOcultar -->
                  <style>
                                .preloader {
                                    width: 70px;
                                    height: 70px;
                                    border: 10px solid #eee;
                                    border-top: 10px solid #666;
                                    border-radius: 50%;
                                    animation-name: girar;
                                    animation-duration: 2s;
                                    animation-iteration-count: infinite;
                                    animation-timing-function: linear;
                                    }
                                    @keyframes girar {
                                    from {
                                        transform: rotate(0deg);
                                    }
                                    to {
                                        transform: rotate(360deg);
                                    }
                                    }
                            </style> 
                            <div id="cargando" class="preloader float-right" style="display:none;"></div>
                            <script>
                                $(document).ready(function(){
                                    $('#validarOcultar').click(function(){
                                        document.getElementById('cargando').style.display = '';
                                        document.getElementById('validarOcultar').style.display = 'none';
                                    });
                                });
                            </script>
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
<!--Select dinamico-->
<script>
    $(document).ready(function(){
        $('#rad_cargoD').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoD").html(data);
            }); 
        });
        $('#rad_usuarioD').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoD").html(data);
            }); 
        });
        
        /* Aca se carga los datos que ya se an seleccioando*/            
        var radios = document.getElementsByName('radiobtnD');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idDocumento").value;
            var grupo = radios[i].value;
            var radEncargadoDD = "radEncargadoDD";
            
            //alert(rad_post);
            
            $.post("selectDocumentos2.php", { rad_post: rad_post, grupo: grupo, radEncargadoDD: radEncargadoDD}, function(data){
                $("#select_encargadoD").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
    });
</script>
<!--Ckeditor-->
<script>
    CKEDITOR.replace( 'editor1' );
</script>
<!-- bs-custom-file-input -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
</body>
</html>
<?php
}
?>