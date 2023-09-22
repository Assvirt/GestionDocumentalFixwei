<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
require_once 'conexion/bd.php';

/*Variables de sesion*/
$celdulaUser = $_SESSION['session_username']; 
$cargoID = $_SESSION['session_cargo']; 
$idUsuario = $_SESSION['session_idUsuario'];

/*consulta datos del documento*/
$idDocumento = $_POST['idDocumento'];

$acentos = $mysqli->query("SET NAMES 'utf8'");
$queryDoc = $mysqli->query("SELECT * FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
$datosDoc = $queryDoc->fetch_assoc();
$rolFlujo = $_POST['rol'];

/*Validacion de que algun asuario ya se encargara de la solicitud*/
if($datosDoc['asumeFlujo'] == NULL){
    //echo "<h1>Aún no se asume flujo</h1>";
    
    //$update = $mysqli->query("UPDATE documento SET asumeFlujo = '$idUsuario' WHERE id = '$idDocumento' ");
        ?>    
            <script> 
                 window.onload=function(){
               
                    // document.forms["miformularioA"].submit();
                 }
                //setTimeout(clickbuttonPDF, 0999);
                //function clickbuttonPDF() { 
                //         document.forms["miformularioA"].submit();
                //}
            </script>
             
            <form name="miformularioA" action="revisaDoc" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="idDocumento" value="<?php echo $idDocumento;?>">
                <input type="hidden" name="rol" value="<?php echo $rolFlujo;?>">
                <input type="hidden" name="solicitud" value="<?php echo $_POST['solicitud'];?>">
            </form>
        <?php
}else{
    
    if($datosDoc['asumeFlujo'] == $idUsuario){
        
        //echo '<script language="javascript">alert("Ya se asigno")</script>';
        
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
        
       // echo '<script language="javascript">alert("Un usuario ya se encargo de la solicitud.");
       // window.location.href="creacionDocumental.php"</script>';
        
    }
    
    //validar que sea el usuario
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
            <?php
            /// de acuerdo al rol de la persona cambia el título
            $elaboraValidacion = json_decode($datosDoc['elabora']);
            $revisaValidacion = json_decode($datosDoc['revisa']);
            $apruebaValidacion = json_decode($datosDoc['aprueba']);
            
            ///////////////////////////// para el elaborador
                if($elaboraValidacion[0] == 'usuarios'){
                    $longitudValidacion = count($elaboraValidacion);
                                                        
                    for($i=1; $i<$longitudValidacion; $i++){
                                                            //saco el valor de cada elemento
                        $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE id = '$elaboraValidacion[$i]'");
                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                        
                        if($idparaChat == $elaboraValidacion[$i]){                                    
                    	    $variableValidado=$nombres['id'];
                        }else{
                            continue;
                        }                                  
                    	//$variableValidado=$nombres['id'];
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
                        $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE id = '$revisaValidacion[$i]' ");
                        $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
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
                        
                        if($idparaChat == $apruebaValidacion[$i]){                                    
                    	    $variableValidadoC=$nombres['id'];
                        }else{
                            continue;
                        }                                    
                    	//$variableValidadoC=$nombres['id'];
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
                
            /// consultamos el cargo del usuario
            
            
            /*   
            $variableValidadoB;    
            if($variableValidado == $datosDoc['asumeFlujo'] && $datosDoc['estado'] == 'Pendiente'){
                $títulRol='Crear documento';
            }elseif($variableValidadoB == $datosDoc['asumeFlujo'] && $datosDoc['estado'] == 'Elaborado'){ 
                $títulRol='Revisar documento';
            }elseif($variableValidadoC == $datosDoc['asumeFlujo'] && $datosDoc['estado'] == 'Revisado'){ 
                $títulRol='Aprobar documento';
            }
            */
            
            // consultamos el usuario de la sesión para verificar que tenga el mismo cargo para la aprobación del documento
            $query_busqueda_cargo = $mysqli->query("SELECT  cedula,cargo FROM usuario WHERE cedula = '$celdulaUser'");
            $nombres_busqueda_cargo = $query_busqueda_cargo->fetch_array(MYSQLI_ASSOC);
            
            $enviar_id_solicitud=$datosDoc['id_solicitud'];
            /// traemos el cargo asociado que está en la solicitud
            $query_busqueda_cargo_solicitud = $mysqli->query("SELECT  * FROM solicitudDocumentos WHERE id = '$enviar_id_solicitud'");
            $nombres_busqueda_cargo_solicitud = $query_busqueda_cargo_solicitud->fetch_array(MYSQLI_ASSOC);
            
             '<br> quien aprieba: '.$nombres_busqueda_cargo_solicitud['QuienAprueba'];
            ' - '.$nombres_busqueda_cargo['cargo'];
            
            if($variableValidado == $datosDoc['asumeFlujo'] && $datosDoc['estado'] == null || $variableValidado == $datosDoc['asumeFlujo'] && $datosDoc['estado'] == 'Pendiente'){
                $títulRol='Crear documento';
                $activador_usuario='Si';
            }elseif($variableValidadoB == $datosDoc['asumeFlujo'] && $datosDoc['estado'] == 'Elaborado'){ 
                $títulRol='Revisar documento';
                $activador_usuario='Si';
            }elseif($variableValidadoC == $datosDoc['asumeFlujo'] && $datosDoc['estado'] == 'Revisado'){ 
                $títulRol='Aprobar documento';
                $activador_usuario='Si';
            }else{ /// verificamos que los roles estén ingresando, tmabién verificamos que el encargado que es el aprobador, sea quien tenga el documento abierto
                if($activador_usuario != NULL){ //echo 'a 1';
                    $títulRol='Asignar documento';
                }elseif($nombres_busqueda_cargo_solicitud['QuienAprueba'] == $celdulaUser && $datosDoc['estado'] == null || $nombres_busqueda_cargo_solicitud['QuienAprueba'] == $celdulaUser && $datosDoc['estado'] == 'Pendiente'){ //echo 'a 2';
                    $títulRol='Asignar documento';
                }else{
                    $títulRol==NULL;
                }
            }
            
            
             
             if($títulRol == NULL || $datosDoc['id'] == null){
                 //echo 'Campo vacio';
                 $update = $mysqli->query("UPDATE documento SET asumeFlujo = null WHERE id = '$idDocumento' ");
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
            <h1><?php echo $títulRol; //echo' - '.$variableValidadoB.' - '.$datosDoc['asumeFlujo'].' - '.$datosDoc['estado'];?></h1>
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
        $control = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = $idDocumento")or die(mysqli_error($mysqli));
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
                    <p><h4>Comentarios</h4></p>
                                </center>
                                    <div style="padding: 20px;" class="tab-pane" id="timeline">
                                        <!-- The timeline -->
                                        <div class="timeline timeline-inverse">
                                          <!-- timeline time label -->
                                          <?php 
                                             'IDENTIFICADOR: '.$idSol = $datosDoc['id_solicitud'];
                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                            $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = $idSol ORDER BY id DESC")or die(mysqli_error($mysqli));
                                            $i=0;
                                            while($i < 1){
                                                $row = $queryControl->fetch_assoc();
                                                 $idUser = $row['idUsuario'];
                                                $rol = $row['rol'];
                                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$idUser' ")or die(mysqli_error($mysqli));
                                                $datosUser = $queryUser->fetch_assoc();

                                                 $nombreUsuario = $datosUser['nombres']." ".$datosUser['apellidos'];
                                                $i++;
                                          ?>
                                          
                                          <div class="time-label">
                                            <span class="bg-danger">
                                              <?php echo substr($row['fecha'],0,-8);//$row['fecha']?>
                                            </span>
                                          </div>

                                          <div>
                                            <i class="fas fa-user bg-info"></i>
                    
                                            <div class="timeline-item">
                                              
                                              <h3 class="timeline-header border-0"><b><?php echo $rol?></b> - <a href="#"><?php echo $nombreUsuario?></a><br> <?php  if($row['comentario'] != NULL){ echo nl2br($row['comentario']); }else{ echo 'N/A';} ?>
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
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              <form role="form" id="formCrearDoc" action="revisaDoc2" onsubmit="event.preventDefault(); sendForm();" method="POST"> 
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Nombre del documento: </label>
                            <input autocomplete="off" value="<?php echo $datosDoc['nombres']?>" type="text" class="form-control" name="nombreDocumento" placeholder="Nombre del documento" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Proceso:</label>
                            <?php
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT * FROM procesos ORDER BY estado");
                            ?>
                            <select type="text" class="form-control" id="descripcion" name="proceso" placeholder="Proceso" required>
                                <option value=''>Seleccionar proceso</option>
                                <?php
                                while ($columna = mysqli_fetch_array( $resultado )) { 
                                    if($datosDoc['proceso'] == $columna['id']){
                                        $selecPro = "selected";
                                    }else{
                                        $selecPro = "";
                                    }
                                    
                                    if($columna['estado'] == 'Eliminado'){
                                    ?>
                                    <option value="<?php echo $columna['id']; ?>" style="color:red;" <?php echo $selecPro;?> ><?php echo $columna['nombre'].' -- '.$columna['estado']; ?></option>
                                    <?php
                                    }else{
                                    ?>
                                    <option value="<?php echo $columna['id']; ?>" style="color:green;" <?php echo $selecPro;?> ><?php echo $columna['nombre'].' -- Activos'; ?></option>
                                    <?php
                                    }  
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <?php
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
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
                              <input autocomplete="off" class="custom-control-input" type="radio" id="customRadio1" name="rad_metodo" value="documento" <?php echo $checkDoc; echo $disabledDoc; ?>>
                              <label for="customRadio1" class="custom-control-label">Documento (PDF, WORD, EXCEL, AUTOCAD)</label>
                            </div>
                            <div class="custom-control custom-radio">
                              <input autocomplete="off" class="custom-control-input" type="radio" id="customRadio2" name="rad_metodo" value="html" <?php echo $checkHTML; echo $disabledHtml; ?>>
                              <label for="customRadio2" class="custom-control-label">Edición HTML</label>
                            </div>
                            
                            <div><br>
                                <label>Tipo documento:</label>
                                <?php
                                    require_once'conexion/bd.php';
                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $resultado=$mysqli->query("SELECT * FROM tipoDocumento ORDER BY nombre");
                                ?>
                                <select type="text" class="form-control" id="descripcion" name="tipoDoc" placeholder="" required>
                                    <option value=''>Seleccionar tipo documento</option>
                                    <?php
                                    while ($columna = mysqli_fetch_array( $resultado )) {
                                        if($datosDoc['tipo_documento'] == $columna['id']){
                                            $selectTipoDoc = "selected";
                                        }else{
                                            $selectTipoDoc = "";
                                        }
                                    ?>
                                    <option value="<?php echo $columna['id']; ?>"  <?php echo $selectTipoDoc; ?>><?php echo $columna['nombre']; ?> </option>
                                    <?php }  ?>
                                </select>
                            </div>
                            
                            <div>
                                <br>
                                <label>Ubicación: </label>
                                <input autocomplete="off" value="<?php echo $datosDoc['ubicacion']; ?>" type="text" class="form-control" name="ubicacion" placeholder="Ubicación" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46 ||  event.charCode == 44 || event.charCode == 58 || event.charCode == 59 || event.charCode == 13 || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || event.charCode == 47)" required>
                            </div>
                        </div>

                    </div>
                    
                    <?php
                    //aca voy a validar si son usuarios o cargos los que se encargan de elaborar, revisar, aprobar            
                    
                        $elabora = json_decode($datosDoc['elabora']);
                        $revisa = json_decode($datosDoc['revisa']);
                        $aprueba = json_decode($datosDoc['aprueba']);
                        
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
                        
                        if($datosDoc['estado'] != NULL){//si el estado es null quiere decir que no se ah asigando quien elabora, revisa, aprueba entonces puede asigar quien lo hace
                            $display = "none";
                        }else{
                            $display = "";
                        }
                        
                    ?>
                    
                    
                    
                    <div class="row" style="display:<?php echo $display;?>;">
                        <div class="form-group col-sm-6">
                            <label>Quién elabora: </label><br>
                            <input autocomplete="off" type="radio" id="rad_cargoE" name="radiobtnE" value="cargos" <?php echo $checkedCElabora;?> >
                            <label for="cargo">Cargo</label>
                            <input autocomplete="off" type="radio" id="rad_usuarioE" name="radiobtnE" value="usuarios" <?php echo $checkedUElabora;?> >
                            <label for="usuarios">Usuarios</label>

                            
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoE[]" id="select_encargadoE" ></select>
                            </div>
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label>Quién revisa: </label><br>
                            <input autocomplete="off" type="radio" id="rad_cargoR" name="radiobtnR" value="cargos" <?php echo $checkedCRevisa;?>>
                            <label for="cargo">Cargo</label>
                            <input autocomplete="off" type="radio" id="rad_usuarioR" name="radiobtnR" value="usuarios" <?php echo $checkedURevisa;?>>
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoR[]" id="select_encargadoR" ></select>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row" >
                        <div class="form-group col-sm-6" style="display:<?php echo $display;?>;">
                            <label>Quién aprueba: </label><br>
                            <input autocomplete="off" type="radio" id="rad_cargoA" name="radiobtnA" value="cargos" <?php echo $checkedCAprueba;?>>
                            <label for="cargo">Cargo</label>
                            <input autocomplete="off" type="radio" id="rad_usuarioA" name="radiobtnA" value="usuarios" <?php echo $checkedUAprueba;?>>
                            <label for="usuarios">Usuarios</label>

                            
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoA[]" id="select_encargadoA" ></select>
                            </div>
                        </div>
                        
                        <?php
                                
                                if($datosDoc['tipoCodificacion'] == "manual"){
                                    $checkManual = "checked";
                                    $disabledAutomatico = "disabled";
                                    $displayManual = "";
                                    $requiredVersion = "required";
                                    $requiredConsecutivo = "required";
                                    $version = $datosDoc['version'];
                                    $consecutivo = $datosDoc['consecutivo'];
                                    
                                }else{
                                    $checkAutomatico = "checked";
                                    $displayManual = "none";
                                    $requiredVersion = "";
                                    $requiredConsecutivo = "";
                                    $version = "";
                                    $consecutivo = "";
                                }
                                
                                $proceso = $datosDoc['proceso'];
                                $tipoDocumento = $datosDoc['tipo_documento'];
                                

                            ?>
                        
                        <div class="form-group col-sm-6">
                            <label>Codificación:</label><br>
                            <label><input autocomplete="off" name="radCodificacion" id="rad_automatica" type='radio' value="automatico" <?php echo $checkAutomatico;?> > Automática </label>
                            <!--<br>
                            <label><input autocomplete="off" name="radCodificacion" id="rad_manual" type='radio' value="manual" <?php echo $checkManual;?> > Manual </label><br>
                            -->
                            <div id="codificacionManual" style="display:<?php echo $displayManual;?>;">
                                <div class="form-group col-sm-6">
                                    <div class="form-group col-sm-3">
                                        <label>Versión: </label>
                                        <input autocomplete="off" name="versionDeclarada" id="id_version" type="number" min="1" value="<?php echo $version;?>">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Consecutivo: </label>
                                        <input autocomplete="off" name="consecutivoDeclarado" id="consecutivo" type="number" min="1" value="<?php echo $consecutivo;?>">
                                    </div>
                                    
                                    <input autocomplete="off" type="hidden" id="idproceso" name="" value="<?php echo $proceso;?>"> 
                                    <input autocomplete="off" type="hidden" id="idtipoDoc" name="" value="<?php echo $tipoDocumento;?>"> 
                                </div>
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
                    <input autocomplete="off" type="hidden" name="rol" value="<?php echo $rolFlujo;?>"> 
                    <input type="hidden" id="idDocumento" name="idDocumento" value="<?php echo $idDocumento;?>">    
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
        

        var radios = document.getElementsByName('radiobtnE');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idDocumento").value;
            var grupo = radios[i].value;
            var radEncargado = "radEncargado";
            
            //alert(rad_post);
            
            $.post("selectDocumentos2.php", { rad_post: rad_post, grupo: grupo, radEncargado: radEncargado}, function(data){
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
        

        var radios = document.getElementsByName('radiobtnR');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idDocumento").value;
            var grupo = radios[i].value;
            var radRevisar = "radRevisar";
            
            //alert(rad_post);
            
            $.post("selectDocumentos2.php", { rad_post: rad_post, grupo: grupo, radRevisar: radRevisar}, function(data){
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
        
        var radios = document.getElementsByName('radiobtnA');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idDocumento").value;
            var grupo = radios[i].value;
            var radAprobar = "radAprobar";
            
            //alert(rad_post);
            
            $.post("selectDocumentos2.php", { rad_post: rad_post, grupo: grupo, radAprobar: radAprobar}, function(data){
                $("#select_encargadoA").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
    });
</script>
<!--Oculta div versionamiento-->
<script>
    $(document).ready(function(){
        $('#rad_manual').click(function(){
            document.getElementById('codificacionManual').style.display = '';
            document.getElementById("id_version").setAttribute("required","any");
            document.getElementById("consecutivo").setAttribute("required","any");
        });
        $('#rad_automatica').click(function(){
            document.getElementById('codificacionManual').style.display = 'none';
            document.getElementById("id_version").removeAttribute("required","any");
            document.getElementById("consecutivo").removeAttribute("required","any");
        });
    });
</script>
<!-- script que valida version y consecutivo -->

<script>

function sendForm(){

    
    var idProceso = $('#idproceso').val();
    var idTipoDocumento = $('#idtipoDoc').val();
    var consecutivo = $('#consecutivo').val();
    var valido = '';
    
    
    
    
    
    $.post("validaVersionamiento.php", { consecutivo: consecutivo, idProceso: idProceso, idTipoDocumento: idTipoDocumento }, function(data){
        valido = data;
        //alert("ENTRO A LA FUNCION"+valido);
        if(valido == "si"){
            //alert("Consecutivo no valido.");
            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000
            });
            Toast.fire({
            type: 'warning',
            title: ' Consecutivo no valido.'
            })
        	return false;
        }else{
            //alert("Consecutivo valido.");
            document.getElementById("formCrearDoc").submit();
            return true;
        }
        
    }); 

}
    
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
</body>
</html>
<?php
}
?>