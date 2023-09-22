<?php error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
//require_once 'inactividad.php';
require_once 'conexion/bd.php';

/*Variables de sesion*/
$celdulaUser = $_SESSION['session_username']; 
$cargoID = $_SESSION['session_cargo']; 
$idUsuario = $_SESSION['session_idUsuario'];

$rolFlujo = $_POST['rol'];
$idDoc = $_POST['idDoc'];
$idSolicitudActualizar = $_POST['idSolicitud'];


$acentos = $mysqli->query("SET NAMES 'utf8'");
$querySol = $mysqli->query("SELECT codificacion FROM documento WHERE id = $idDoc")or die(mysqli_error($mysqli));
$datosSol = $querySol->fetch_assoc();

$codDoc = $datosSol['codificacion'];
$acentos = $mysqli->query("SET NAMES 'utf8'");
$query3 = $mysqli->query("SELECT MAX(id) as idDocumento FROM documento WHERE codificacion = '$codDoc'")or die(mysqli_error($mysqli));
$datos3 = $query3->fetch_assoc();


$idDocumento = $datos3['idDocumento'];

$acentos = $mysqli->query("SET NAMES 'utf8'");
$queryDoc = $mysqli->query("SELECT * FROM documento WHERE id = $idDoc")or die(mysqli_error($mysqli));
$datosDoc = $queryDoc->fetch_assoc();

/// traemos el id de la solicitud para verificar el cargo del usuario y validar que sea la única persona que ingresa a la vista
$enviar_id_solicitud=$datosDoc['id_solicitud'];

/*Validacion de que algun asuario ya se encargara de la solicitud*/
if($datosDoc['asumeFlujo'] == NULL){

    //$update = $mysqli->query("UPDATE documento SET asumeFlujo = '$idUsuario' WHERE id = '$idDoc' ");
        ?>    
            <script> 
                 window.onload=function(){
                     //document.forms["miformularioA"].submit();
                 }
                 //setTimeout(clickbuttonArchivoEditable, 0999);
                 //function clickbuttonArchivoEditable() { 
                 //   document.forms["miformularioA"].submit();
                 //}
            </script>
             
            <form name="miformularioA" action="actualizarDoc" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="idDoc" value="<?php echo $idDoc;?>">
                <input type="hidden" name="rol" value="<?php echo $rolFlujo;?>">
                <input type="hidden" name="idSolicitud" value="<?php echo $_POST['idSolicitud'];?>">
                <input type="hidden" name="solicitud" value="<?php echo $_POST['solicitud'];?>">
            </form>
        <?php
    
}else{
    
    if($datosDoc['asumeFlujo'] == $idUsuario){//sE VALIDA QUE SEA EL USUARIO QUE TOMO PRIMERO LA SOLICITUD. 
        

    }else{
    ?>    
            <script> 
                 window.onload=function(){
               
                    // document.forms["sacarDelFlujo"].submit();
                 }
                 //setTimeout(clickbuttonScarFlujo, 1000);
                 //function clickbuttonScarFlujo() { 
                 //   document.forms["sacarDelFlujo"].submit();
                 //}
            </script>
             
            <form name="sacarDelFlujo" action="creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <input name="documentoAsignado" value="<?php echo $idDocumento;?>" type="hidden">
                <input type="hidden" name="validacionUsuario" value="1">
            </form>
    <?php    
     //echo '<script language="javascript">alert("Un usuario ya se encargo de la solicitud.");
       // window.location.href="creacionDocumental.php"</script>';
    }
    
}




if($datosDoc['id'] != NULL){
    
}else{ 
    ?>    
            <script> 
                 window.onload=function(){
               
                     document.forms["sacarDelFlujoNoExiste"].submit();
                 }
                 setTimeout(clickbuttonScarFlujoNoExiste, 1000);
                 function clickbuttonScarFlujoNoExiste() { 
                    document.forms["sacarDelFlujoNoExiste"].submit();
                 }
            </script>
             
            <form name="sacarDelFlujoNoExiste" action="creacionDocumental" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionUsuarioNoExiste" value="1">
            </form>
    <?php 
}


?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Revisar documento</title>
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
            $elaboraValidacion = json_decode($datosDoc['elaboraActualizar']);
            $revisaValidacion = json_decode($datosDoc['revisaActualizar']);
            $apruebaValidacion = json_decode($datosDoc['apruebaActualizar']);
            
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
                }elseif($elaboraValidacion[0] == 'cargos'){
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
            
            
            // consultamos el usuario de la sesión para verificar que tenga el mismo cargo para la aprobación del documento
            $query_busqueda_cargo = $mysqli->query("SELECT  cedula,cargo FROM usuario WHERE cedula = '$celdulaUser'");
            $nombres_busqueda_cargo = $query_busqueda_cargo->fetch_array(MYSQLI_ASSOC);
            
            /// traemos el cargo asociado que está en la solicitud
            $query_busqueda_cargo_solicitud = $mysqli->query("SELECT  * FROM solicitudDocumentos WHERE id = '$enviar_id_solicitud'");
            $nombres_busqueda_cargo_solicitud = $query_busqueda_cargo_solicitud->fetch_array(MYSQLI_ASSOC);
            
             '<br> quien aprieba: '.$nombres_busqueda_cargo_solicitud['QuienAprueba'];
            ' - '.$nombres_busqueda_cargo['cargo'];
            
                
            if($variableValidado == $datosDoc['asumeFlujo'] && $datosDoc['estadoActualiza'] == null || $variableValidado == $datosDoc['asumeFlujo'] && $datosDoc['estadoActualiza'] == 'Pendiente'){
                $títulRol='Crear documento';
                $activador_usuario='Si';
            }elseif($variableValidadoB == $datosDoc['asumeFlujo'] && $datosDoc['estadoActualiza'] == 'Elaborado'){ 
                $títulRol='Revisar documento';
                $activador_usuario='Si';
            }elseif($variableValidadoC == $datosDoc['asumeFlujo'] && $datosDoc['estadoActualiza'] == 'Revisado'){ 
                $títulRol='Aprobar documento';
                $activador_usuario='Si';
            }else{ /// verificamos que los roles estén ingresando, tmabién verificamos que el encargado que es el aprobador, sea quien tenga el documento abierto
                if($activador_usuario != NULL){ //echo 'a 1';
                    $títulRol='Asignar documento';
                }elseif($nombres_busqueda_cargo_solicitud['QuienAprueba'] == $celdulaUser && $datosDoc['estadoActualiza'] == null || $nombres_busqueda_cargo_solicitud['QuienAprueba'] == $celdulaUser && $datosDoc['estadoActualiza'] == 'Pendiente'){ //echo 'a 2';
                    $títulRol='Asignar documento';
                }else{
                    $títulRol==NULL;
                }
            }
            
            
              if($títulRol == NULL){
                 //echo 'Campo vacio';
                 
                    $mysqli->query("UPDATE documento SET asumeFlujo = null WHERE id = '$idDocumento' ");
                 
                 ?>
                    <script> 
                         window.onload=function(){
                            document.forms["documentoValidarSinEstado"].submit();
                         }
                         setTimeout(clickbuttonArchivoPerfil, 0999);
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
            <h1><?php echo $títulRol; //echo' - '.$variableValidadoC.' - '.$datosDoc['asumeFlujo'].' - '.$datosDoc['estadoActualiza'];?></h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active"><?php echo $títulRol;?></li>
            </ol>
          </div>
        </div>
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                <div class="row">
                    <div class="col-sm">
                        <button type="button" class="btn btn-block btn-success btn-sm"><a href="creacionDocumental"><font color="white"><i class="fas fa-chevron-left"></i> Regresar</font></a></button>
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
        
        
      </div><!-- /.container-fluid -->
    </section>


    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col"></div>
          <div class="col-9">
            <div class="card">
                <center>
                    <br>
                    <h2>SOLICITUD</h2>
                   
                <?php
                    $solicitud = $_POST['solicitud']; 
                ?>
                <p>
                    <?php echo $solicitud;?>
                </p>
                
                    <br><br>
                </center>
            </div>
            <!-- /.card -->
          </div>
          <div class="col"></div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    
    
    <?php 
        $acentos = $mysqli->query("SET NAMES 'utf8'");
        $control = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = $idSolicitudActualizar")or die(mysqli_error($mysqli));
        $nControles = mysqli_num_rows($control);
        
        if($nControles < 1){
            
        }else{ 
            
    ?>
    
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col"></div>
          <div class="col-9">
            <div class="card">
                <center>
                    <br>
                    <p><h4>Comentarios </h4></p>
                                </center>
                                    <div style="padding: 20px;" class="tab-pane" id="timeline">
                                        <!-- The timeline -->
                                        <div class="timeline timeline-inverse">
                                          <!-- timeline time label -->
                                          <?php 
                                            $idSol = $datosDoc['id_solicitud'];
                                            $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '$idSolicitudActualizar' ORDER BY id DESC")or die(mysqli_error($mysqli));
                                            $i=0;
                                            while($i < 1){
                                                $row = $queryControl->fetch_assoc();
                                                $idUser = $row['idUsuario'];
                                                $rol = $row['rol'];
                                                $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$idUser' ")or die(mysqli_error($mysqli));
                                                $datosUser = $queryUser->fetch_assoc();

                                                $nombreUsuario = $datosUser['nombres']." ".$datosUser['apellidos'];
                                                $i++;
                                          ?>
                                          
                                          <div class="time-label">
                                            <span class="bg-danger">
                                              <?php echo substr($row['fecha'],0,-8); //$row['fecha']?>
                                            </span>
                                          </div>

                                          <div>
                                            <i class="fas fa-user bg-info"></i>
                    
                                            <div class="timeline-item">
                                              
                                              <h3 class="timeline-header border-0"><b><?php echo $rol?></b> - <a href="#"><?php echo $nombreUsuario?></a> <?php  if($row['comentario'] != NULL){ echo nl2br($row['comentario']); }else{ echo 'N/A';} ?>
                                              </h3>
                                            </div>
                                          </div>
                                        <?php }?>
                                        </div>
                                     </div>
            </div>
            <!-- /.card -->
          </div>
          <div class="col"></div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    
     <?php 
        }
    ?>
    
    
    
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

              <form role="form" action="actualizarDoc2" method="POST">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Nombre del documento: </label>
                            <input autocomplete="off" value="<?php echo $datosDoc['nombres']?>" type="text" class="form-control" name="nombreDocumento" placeholder="Nombre del documento" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Proceso:</label>
                            <?php
                                require_once 'conexion/bd.php';
                                $resultado=$mysqli->query("SELECT * FROM procesos ORDER BY nombre");
                            ?>
                            <select class="form-control" id="descripcion" name="" disabled>
                                <option value=''>Seleccionar proceso</option>
                                <?php
                                while ($columna = mysqli_fetch_array( $resultado )) { 
                                    if($datosDoc['proceso'] == $columna['id']){
                                        $selecPro = "selected";
                                        $idProceso = $columna['id'];
                                    }else{
                                        $selecPro = "";
                                    }
                                ?>
                                <option value="<?php echo $columna['id']; ?>" <?php echo $selecPro; ?>><?php echo $columna['nombre']; ?> </option>
                                <?php }  ?>
                            </select>
                            <input type="hidden" value="<?php echo $idProceso;?>" name="proceso">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <?php
                                require_once 'conexion/bd.php';
                                $resultado=$mysqli->query("SELECT * FROM normatividad");
                                $arrayNormas = json_decode($datosDoc['norma']);
                            ?>
                            <label>Norma: </label>
                              <select class="duallistbox" name="norma[]" multiple>
                                <?php
                                    while ($columna = mysqli_fetch_array( $resultado )) { 
                                      if($arrayNormas != NULL){
                                        if(in_array($columna['id'],$arrayNormas)){
                                            $seleccionarNorm = "selected";        
                                        }else{
                                            $seleccionarNorm ="";
                                        }
                                      }
                                    ?>
                                    <option value="<?php echo $columna['id']; ?>" <?php echo $seleccionarNorm; ?>><?php echo $columna['nombre']; ?> </option>
                                <?php }  ?>
                              </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <?php
                                
                                if($datosDoc['metodo'] == "html"){
                                    $checkHTML = "checked";
                                    $disabledDoc = "disabled";
                                }else{
                                    $checkDoc = "checked";
                                    $disabledHtml = "disabled";
                                }
                                
                            ?>
                            <label>Método de creación: </label><br>
                            <div class="custom-control custom-radio">
                              <input class="custom-control-input" type="radio" id="customRadio1" name="rad_metodo" value="documento" <?php echo $checkDoc; echo $disabledDoc; ?>>
                              <label for="customRadio1" class="custom-control-label">Documento (PDF, WORD, EXCEL, AUTOCAD)</label>
                            </div>
                            <div class="custom-control custom-radio">
                              <input class="custom-control-input" type="radio" id="customRadio2" name="rad_metodo" value="html" <?php echo $checkHTML; echo $disabledHtml; ?>>
                              <label for="customRadio2" class="custom-control-label">Edicion HTML</label>
                            </div>
                            
                            <div><br>
                                <label>Tipo documento:</label>
                                <?php
                                    require_once 'conexion/bd.php';
                                    //$acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $resultado=$mysqli->query("SELECT * FROM tipoDocumento ORDER BY nombre");
                                ?>
                                <select type="text" class="form-control" id="descripcion" name="" disabled>
                                    <option value=''>Seleccionar tipo documento</option>
                                    <?php
                                    while ($columna = mysqli_fetch_array( $resultado )) {
                                        if($datosDoc['tipo_documento'] == $columna['id']){
                                            $selectTipoDoc = "selected";
                                            $idTipoDoc= $columna['id'];
                                        }else{
                                            $selectTipoDoc = "";
                                        }
                                    ?>
                                    <option value="<?php echo $columna['id']; ?>"  <?php echo $selectTipoDoc; ?>><?php echo $columna['nombre']; ?> </option>
                                    <?php }  ?>
                                </select>
                                <input type="hidden" value="<?php echo $idTipoDoc;?>" name="tipoDoc">
                            </div>
                            <br>
                            <div>
                                <label>Ubicación: </label>
                                <input autocomplete="off" value="<?php echo $datosDoc['ubicacion']; ?>" type="text" class="form-control" name="ubicacion" placeholder="Ubicación" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || event.charCode == 47)" required>
                            </div>
                        </div>

                    </div>
                    
                    <?php
                    //aca voy a validar si son usuarios o cargos los que se encargan de elaborar, revisar, aprobar            
                    
                        $elabora = json_decode($datosDoc['elaboraActualizar']);
                        $revisa = json_decode($datosDoc['revisaActualizar']);
                        $aprueba = json_decode($datosDoc['apruebaActualizar']);
                        
                        if($elabora[0] == 'cargos'){
                            $checkedCElabora = "checked";            
                        }
                        
                        if($elabora[0] == 'usuarios'){
                            $checkedUElabora = "checked"; 
                        }
                        
                        if($revisa[0] == 'cargos'){
                            $checkedCRevisa = "checked";            
                        }
                        
                        if($revisa[0] == 'usuarios'){
                            $checkedURevisa = "checked"; 
                        }
                        
                        if($aprueba[0] == 'cargos'){
                            $checkedCAprueba = "checked";            
                        }
                        
                        if($aprueba[0] == 'usuarios'){
                            $checkedUAprueba = "checked"; 
                        }
                        
                        if($datosDoc['estadoActualiza'] != NULL){//si el estado es null quiere decir que no se ah asigando quien elabora, revisa, aprueba entonces puede asigar quien lo hace
                            $display = "none";
                        }else{
                            $display = "";
                        }
                        
                    ?>
                    
                    
                    
                    <div class="row" style="display:<?php echo $display;?>;">
                        <div class="form-group col-sm-6">
                            <label>Quién elabora: </label><br>
                            <input type="radio" id="rad_cargoE" name="radiobtnE" value="cargos" <?php echo $checkedCElabora;?> >
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioE" name="radiobtnE" value="usuarios" <?php echo $checkedUElabora;?> >
                            <label for="usuarios">Usuarios</label>

                            
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccione encargado" style="width: 100%;" name="select_encargadoE[]" id="select_encargadoE" required></select>
                            </div>
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label>Quién revisa: </label><br>
                            <input type="radio" id="rad_cargoR" name="radiobtnR" value="cargos" <?php echo $checkedCRevisa;?>>
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioR" name="radiobtnR" value="usuarios" <?php echo $checkedURevisa;?>>
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccione encargado" style="width: 100%;" name="select_encargadoR[]" id="select_encargadoR" required></select>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row" style="display:<?php echo $display;?>;">
                        <div class="form-group col-sm-6">
                            <label>Quién aprueba: </label><br>
                            <input type="radio" id="rad_cargoA" name="radiobtnA" value="cargos" <?php echo $checkedCAprueba;?>>
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioA" name="radiobtnA" value="usuarios" <?php echo $checkedUAprueba;?>>
                            <label for="usuarios">Usuarios</label>

                            
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccione encargado" style="width: 100%;" name="select_encargadoA[]" id="select_encargadoA" required></select>
                            </div>
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
                    <input type="hidden" name="rol" value="<?php echo $rolFlujo;?>"> 
                    <input type="hidden" id="idDocumento" name="idDocumento" value="<?php echo $idDoc;?>">    
                  <button type="submit" name="crearDocumenohtml" class="btn btn-success float-right">Siguiente >></button>
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
        $('#rad_cargoE').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentosActualizar.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoE").html(data);
            }); 
        });
        $('#rad_usuarioE').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentosActualizar.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoE").html(data);
            }); 
        });
        

        var radios = document.getElementsByName('radiobtnE');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idDocumento").value;
            var grupo = radios[i].value;
            var radEncargado = "radEncargado";
            
            //alert(rad_post);
            
            $.post("selectDocumentosActualizar.php", { rad_post: rad_post, grupo: grupo, radEncargado: radEncargado}, function(data){
                $("#select_encargadoE").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
       
        
    });
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoR').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentosActualizar.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoR").html(data);
            }); 
        });
        $('#rad_usuarioR').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentosActualizar.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoR").html(data);
            }); 
        });
        

        var radios = document.getElementsByName('radiobtnR');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idDocumento").value;
            var grupo = radios[i].value;
            var radRevisar = "radRevisar";
            
            //alert(rad_post);
            
            $.post("selectDocumentosActualizar.php", { rad_post: rad_post, grupo: grupo, radRevisar: radRevisar}, function(data){
                $("#select_encargadoR").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
    });
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoA').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentosActualizar.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoA").html(data);
            }); 
        });
        $('#rad_usuarioA').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentosActualizar.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoA").html(data);
            }); 
        });
        
        var radios = document.getElementsByName('radiobtnA');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idDocumento").value;
            var grupo = radios[i].value;
            var radAprobar = "radAprobar";
            
            //alert(rad_post);
            
            $.post("selectDocumentosActualizar.php", { rad_post: rad_post, grupo: grupo, radAprobar: radAprobar}, function(data){
                $("#select_encargadoA").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
    });
</script>
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
            title: ' No se pudo cargar el archivo con Exito.'
        })
    <?php
    }
    
    if($validacionAgregar == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: 'Proceda a asignar elaborador, revisor y aprobador.'
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
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
</body>
</html>
<?php

}
?>