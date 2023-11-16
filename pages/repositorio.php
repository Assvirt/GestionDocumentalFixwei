<?php
session_start();
error_reporting(E_ERROR);
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';


//error_reporting(E_ERROR);

//rename("repositorio/año 2020/","repositorio/años 2020");


if(isset($_POST['rutaAtras'])){
    $rutaVer = $_POST['rutaAtras'];
    
    if($rutaVer != "raiz/"){
        
    }
    
    //echo "Ruta Atras:".$rutaAtras;echo "<br>";
    //echo "Ruta actual:".$rutaVer; echo "<br>";
            
    $rutaDividida = explode('/',$rutaVer);
           
            
    //echo "n1: ". 
    $n1 = count($rutaDividida)-1;// echo "<br>";
    //echo "n2: ".
    $n2 = count($rutaDividida)-2;// echo "<br>";
            
    unset($rutaDividida[$n1],$rutaDividida[$n2]);
            
    $tamano = count($rutaDividida);
            
    $rutaAtras = "";
    
    if($tamano != 0){
          
        for($i = 0; $i < $tamano ;$i++){
        
            $rutaAtras .= $rutaDividida[$i]."/";
                    
        }
    }

    //echo "<br>";
    //echo "Ruta Atras:".$rutaAtras;echo "<br>";
    
}else{
    
    $subCarperta = $_POST['verCarpeta'];//Recibo el nombre de la carpeta que quiero ver 

    if($subCarperta != NULL){
        
        if(opendir($_SESSION["ruta_carpeta"])){
            //$rutaAtras = $_SESSION["ruta_carpeta"];
            
            $_SESSION["ruta_carpeta"] .= $subCarperta."/";
            $rutaVer=$_SESSION["ruta_carpeta"];
        }else{
            //$_SESSION["ruta_carpeta"] = "repositorio/";
            //$rutaVer = "repositorio/";
        }
        
    }else{
        $_SESSION["ruta_carpeta"] = "raiz/";
        $rutaVer = "raiz/";
        
        if(isset($_POST['verCarpetaCreada'])){
            $rutaVer=$_POST['verCarpetaCreada'];
            $_SESSION["ruta_carpeta"] = $rutaVer;
        }
        
    }
    
    //echo "Ruta Atras:".$rutaAtras;echo "<br>";
    //echo "Ruta actual:".$rutaVer; echo "<br>";
        
    $rutaDividida = explode('/',$rutaVer);
           
            
    $n1 = count($rutaDividida)-1; 
    $n2 = count($rutaDividida)-2; 
            
    unset($rutaDividida[$n1],$rutaDividida[$n2]);
            
    $tamano = count($rutaDividida);
            
    //$nombreEditar = $rutaDividida[$tamano];
            
    $rutaAtras = "";
    
    if($tamano != 0){
        
        for($i = 0; $i < $tamano;$i++){
    
            $rutaAtras .= $rutaDividida[$i]."/";
                    
        }
        
    }
    
    //echo "<br>";
    //echo "Ruta Atras:".$rutaAtras;echo "<br>";
    
}

if(isset($_POST['verCarpetaCreada'])){
    $rutaVer=$_POST['verCarpetaCreada'];
    $_SESSION["ruta_carpeta"] = $rutaVer;
}


/*Extraer nombre actual carpeta*/

    $dividir = explode('/',$rutaVer);
    //print_r($dividir);
     $countDividir = count($dividir)-2;
     $nombreEditar = $dividir[$countDividir];



require_once 'conexion/bd.php';

//////////////////////PERMISOS////////////////////////

$formulario = 'repositorio'; //aqui se cambia el nombre del formulario

require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Repositorio</title>
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
            <h1>Repositorio</h1>
            <h6>Gestione la información documentada y/u otros archivos de su compañía.</h6><br>
            <h6>
                <b>
                    <?php 
                         $rutaVer; 
                        
                        echo $verruta=substr($rutaVer, 5, -1);  /// oculta las primeras letras Raiz/
                    ?>
                </b>
            </h6>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Repositorio</li>
            </ol>
          </div>
        </div>
        <div>
            
            <div class="row">
             <?php // validación agregar
                if($visibleI == FALSE){
                    /////// si es administrador no debería poder crear archivo o carpeta
                    if($root == '1'){
                        
                    }else{
             ?>
                    <div class="col-sm">
                        <form action="cargarRegistros" method="POST" >
                            <input type="hidden" name="rutaSubir" value="<?php echo $rutaVer;?>">          
                            <button type="submit" class="btn btn-block btn-info btn-sm float-right"> <i class="fas fa-file-upload"></i> Subir Archivo</button>
                        </form>
                    </div>
                    <div class="col-sm">
                        <button type="button" class="btn btn-block btn-info btn-sm" data-toggle="modal" data-target="#modal-carpeta"><font color="white"><i class="fas fa-plus-square"></i> Nueva carpeta</font></button>
                    </div>
            <?php
                    } 
            }
            
            /////// si es administrador no debería poder crear archivo o carpeta
            if($root == '1'){
                        
            }else{
            ?>
            <div class="col-sm">
                    <form action="repositorioVerMas" method="POST" >
                        <input type="hidden" name="nombre" id="recibeID" value="">
                        <input type="hidden" name="ruta" value="<?php echo $rutaVer;?>">
                        <button type="submit" id="enviar"  class="btn btn-block btn-primary btn-sm float-right"> <i class="fas fa-eye"></i> Ver Más</button>
                    </form>
                </div>
            <?php
            }
            
            
            // validacion Editar
             if($visibleE == FALSE){
                 
                 /////// si es administrador no debería poder crear archivo o carpeta
                    if($root == '1'){
                        
                    }else{
                    ?>
                        <div class="col sm">
                            <form action="repositorioEditar" method="POST">
                                <input type="hidden" name="nombre" id="recibeEdit" value="">     
                                <input type="hidden" value="<?php echo $rutaVer;?>" name='rutaEditar'>
                                <button type="submit" class="btn btn-block btn-success float-left btn-sm" name="editar"><i class='fas fa-edit'></i> Editar</button>
                                        
                            </form>
                        </div>
                    <?php
                    }
            }
            
            // validacion Eliminar
             if($visibleD == FALSE){
                /////// si es administrador no debería poder crear archivo o carpeta
                if($root == '1'){
                        
                }else{
            ?>
                <div class="col sm">
                    <!--
                    <form action="controlador/repositorio/controllerRepositorio" method="POST">
                        <button type="submit"  onclick='return ConfirmDelete()' class="btn btn-block btn-danger float-left btn-sm" name="EliminarCarpeta"><i class="fas fa-trash-alt"></i> Eliminar</button>
                        <input type="" name="nombre" id="recibeDel" value="">
                        <input type="hidden" name="rutaEliminar" value="<?php //echo $rutaVer;?>">
                     </form>
                     -->
                        <a style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                        
                     
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
                                        <form action='controlador/repositorio/controllerRepositorio' method='POST'>
                                        <div class="modal-footer justify-content-between">
                                          <input type="hidden" name="nombre" id="recibeDel" value="">
                                          <input type="hidden" name="rutaEliminar" value="<?php echo $rutaVer;?>">
                                          <button type="submit" name='EliminarCarpeta' class="btn btn-outline-light">Si</button>
                                          <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                                        </div>
                                         </form>
                                         <!-- END formulario para eliminar por el id -->
                                      </div>
                                    </div>
                                </div>
                     
                     
                     
                     
                     
                </div>
            <?php
                }
             }

                /////// si es administrador no debería poder crear archivo o carpeta
                if($root == '1'){
                   
                }else{
                ?>
                <div class="col-sm">
                   <form action="repositorioDescarga" method="POST" target="_blank">
                        <button type='submit' class='btn btn-block btn-warning float-left btn-sm' name="descargar"><font color="white"><i class='fas fa-download'></i> Descargar</font></button>
                        <input type="hidden" name="nombre" id="recibeDes" value="">
                        <input type="hidden" name="ruta" value="<?php echo $rutaVer;?>">
                    </form>
                </div>
                <?php
                }
                ?>
                <div class="col-sm">
                    <?php
                    /////// si es administrador no debería poder crear archivo o carpeta
                    if($root == '1'){
                        $tamaW='50%';
                    
                    }else{
                        $tamaW='100%';
                        
                    ?>
                    <form action="" method="POST" >
                        <input type="hidden" name="recibeCarpeta" id="recibeCarpeta" value=""> 
                        <input type="hidden" name="verCarpetaCreada" value="<?php echo $rutaVer;?>">
                        <button type="submit" name="descarMasiva" class="btn btn-block btn-success float-left btn-sm"  style='color:white;width:<?php echo $tamaW;?>;'><i class='fas fa-edit'></i> Validar descarga</button>
                    </form>
                    <?php
                    }
                    ?>
                     
                    <?php
                    //}
                    ?>
                    
                </div>
                <div class="col-sm">
                     <?php
                    if(isset($_POST['descarMasiva'])){
                    
                        if($_POST['recibeCarpeta'] != NULL){
                                function agregar_zip($dir, $zip) {
                                    if (is_dir($dir)) {
                                        if ($da = opendir($dir)) {
                                            while (($archivo = readdir($da)) !== false) {
                                                if (is_dir($dir . $archivo) && $archivo != "." && $archivo != "..") {
                                                    "<strong>Creando directorio: $dir$archivo</strong><br/>";
                                                    agregar_zip($dir . $archivo . "/", $zip);
                                                } elseif (is_file($dir . $archivo) && $archivo != "." && $archivo != "..") {
                                                    "Agregando archivo: $dir$archivo <br/>";
                                                    $zip->addFile($dir . $archivo, $dir . $archivo);
                                                }
                                            }
                                            closedir($da);
                                        }
                                    }
                                }
                                 
                                ini_set("memory_limit","91256M");
                                $zip = new ZipArchive();
                               
                              
                                //$dir = 'raiz/Carpeta á/Nómina Agosto/'.$_POST['recibeCarpeta'].'/'; 
                                $dir = $rutaVer.''.$_POST['recibeCarpeta'].'/';
                                $rutaFinal = "raiz/";
                                $archivoZip = $_POST['recibeCarpeta'].".zip";
                                 
                                if ($zip->open('raiz/'.$archivoZip, ZIPARCHIVE::CREATE) === true) {
                                    agregar_zip($dir, $zip);
                                    $zip->close();
                                    if (file_exists($rutaFinal."/".$archivoZip)) { // 
                                        //echo "Proceso Finalizado!! <br/><br/>";
                                        //echo "Descargar: <a href='$rutaFinal/$archivoZip'>$archivoZip</a>";
                                        
                                        echo "<button type='button'  class='btn btn-block btn-warning btn-sm' >
                                                    <a style='color:white' href='$rutaFinal/$archivoZip'><i class='fas fa-download'></i> Descargar documentos</a>
                                                </button>";
                                        
                                    } else {
                                        $enviarAlertaArchivosNoExisteCarpeta=1;
                                        //echo "<font color='red'>Error, la carpeta ".$_POST['recibeCarpeta']."no tiente archivos!!</font>";
                                    }
                                }
                        }else{
                            $enviarAlertaArchivosNoExisteCarpetaB=1;
                        }
                        
                    }
                    ?>
                </div>
            </div>
            
            
             <!--
            <div class="row">
               
                <div class="col-sm">
                    <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/usuarios'"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
                </div>
               
                              
                <div class="col-sm">
                </div>
                
                <div class="col-sm">
                </div>
                <div class="col-sm">
                </div>
            </div>
             -->
            
        </div>
      </div><!-- /.container-fluid -->
      
      <!--Modals-->
        <div class="modal fade" id="modal-carpeta">
            <div class="modal-dialog">
              <div class="modal-content">
                  <form action="controlador/repositorio/controllerRepositorio.php" method="POST">
                    <div class="modal-header">
                      <h4 class="modal-title">Crear carpeta</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                
                      <label>Nombre carpeta:</label><br>
                      <input autocomplete="off" type="text" name="nombreCarpeta" placeholder="Nombre carpeta" class="form-control" required pattern="[a-zA-Z0-9á-úñ-áéíóúÁÉÍÓÚ ]{1,205}" title="No utilice caracteres especiales" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250  || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" />
                      <input type="hidden" name="rutaCarpeta" value="<?php echo $rutaVer;?>">
                      <div class="form-group ">
                        <label>Autorizados para Visualizar: </label><br>
                            <input type="radio" id="rad_cargoAut" name="radiobtnAut" value="cargo" required>
                            <label for="cargo">Cargo</label>&nbsp;&nbsp;
                            <input type="radio" id="rad_usuarioAut" name="radiobtnAut" value="usuario" required>
                            <label for="usuarios">Usuarios</label>&nbsp;&nbsp;
                            <input type="radio" id="rad_grupoAut" name="radiobtnAut" value="grupo" required>
                            <label for="grupos">Grupos</label>
                            
                            <div class="select2-blue" id="listarCargos" required style="display:none;" >
                                
                                <label></label>
                                <!--  <select class="duallistbox" id="select_encargadoAut" name="select_encargadoAut[]" multiple="multiple">
                                   
                                </select>
                                    <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar aprobador" style="width: 100%;" name="select_encargadoAut[]" id="select_encargadoAut" required></select>
                            -->
                                 <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $consultaCargos=$mysqli->query("SELECT * FROM cargos order by nombreCargos ASC");
                                ?>
                                <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar..." style="width: 100%;" name="select_encargadoAut[]"  >
                                    <?php
                                    while($extraerCargos=$consultaCargos->fetch_array()){
                                    ?>
                                    <option value="<?php echo $extraerCargos['id_cargos']; ?>"><?php echo $extraerCargos['nombreCargos']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="select2-blue" id="listarUsuarios" style="display:none;">
                                
                                <label></label>
                                <!--  <select class="duallistbox" id="select_encargadoAut" name="select_encargadoAut[]" multiple="multiple">
                                   
                                </select>
                                    <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar aprobador" style="width: 100%;" name="select_encargadoAut[]" id="select_encargadoAut" required></select>
                            -->
                                 <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $consultaCargos=$mysqli->query("SELECT * FROM usuario Order by nombres ASC");
                                ?>
                                <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar..." style="width: 100%;" name="select_encargadoAut[]"  >
                                    <?php
                                    while($extraerCargos=$consultaCargos->fetch_array()){
                                    ?>
                                    <option value="<?php echo $extraerCargos['id']; ?>"><?php echo $extraerCargos['nombres'].' '.$extraerCargos['apellidos']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="select2-blue" id="listarGrupos" style="display:none;">
                                
                                <label></label>
                                <!--  <select class="duallistbox" id="select_encargadoAut" name="select_encargadoAut[]" multiple="multiple">
                                   
                                </select>
                                    <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar aprobador" style="width: 100%;" name="select_encargadoAut[]" id="select_encargadoAut" required></select>
                            -->
                                 <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $consultaGrupo=$mysqli->query("SELECT * FROM grupo Order by nombre ASC");
                                ?>
                                <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar..." style="width: 100%;" name="select_encargadoAut[]"  >
                                    <?php
                                    while($extraerGrupo=$consultaGrupo->fetch_array()){
                                    ?>
                                    <option value="<?php echo $extraerGrupo['id']; ?>"><?php echo $extraerGrupo['nombre']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                      </div>

                    </div>
                    <input name="usuario" value="<?php echo $idparaChat;?>" type="hidden" readonly>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button type="submit" name="crearSubCarpeta" class="btn btn-primary">Crear carpeta</button>
                    </div>
                </form>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

       
        

      
      
    </section>

    
       
        
        <!-- /.col -->
        
        <?php
        $acentos = $mysqli->query("SET NAMES 'utf8'");
            $data = $mysqli->query("SELECT * FROM registros WHERE carpeta = '$rutaVer'");
            $numRegistros = mysqli_num_rows($data);
            
             $_SESSION["ruta_carpeta"] = $rutaVer;
             $rutaVer;
            if($rutaVer == "raiz/"){
                $ocultaAtras = false;
            }else{
                $ocultaAtras = true;
            }
           
        ?>
        
        
       
         
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                  <?php
                    if($ocultaAtras){
                  ?>
                  <div class="col sm-3">
                        <form action="" method="POST">
                            <button type="submit" class="btn btn-primary float-left btn-sm" name="AgregarRegistro"><i class="fa fa-arrow-left"></i></button>
                            <input type="hidden" value="<?php echo $rutaAtras;?>" name='rutaAtras'>
                        </form>
                    </div>
                    <?php
                    }
                    ?>
                    
              </div>      
              
            
                
                   <?php
                            
                            
                            
                            $directorio = opendir($rutaVer);
                            ?>
                <div class="card-body table-responsive p-0">
                    <table class="table table-head-fixed text-center" id="example">
                                      <thead>
                                        <tr>
                                            <th>Seleccionar</th>
                                            <th></th>
                                            <th></th>
                                            <!--<th>Nombre</th>-->
                                            <th>Fecha de creación</th>
                                            <th>Responsable</th>
                                            <!--<th>Tipo Documento</th>-->
                                            <th style="text-align:left;">Solicitud de visualización</th> 
                                        </tr>
                                      </thead>
                                      <tbody>
                                          
                                    
                                    <?php
                                  //// se colocan los contadores que se van a usar en el script y en el id del checkbox que se usa para poder enviar los nombres de los archivos
                                  $conteoArchivos=0;
                                  $conteoArchivosE=0;
                                  $conteoArchivosE2=0;
                                  $conteoArchivosE3=0;
                                  $conteoArchivosE4=0;
                                  $conteoArchivosE5=0;
                                  $conteoArchivosE6=0;
                                  
                                  $conteoCarpetas=0;
                                  $conteoCarpetasE=0;
                                  $conteoCarpetasE2=0;
                                  $conteoCarpetasE3=0;
                                  $conteoCarpetasE4=0;
                                  $conteoCarpetasEE4=0;
                                  
                                  $conteoSolicitud=0;
                                  $conteoSolicitudA=0;
                                  $conteoSolicitudB=0;
                                  $conteoSolicitudC=0;
                                  
                                  $conteoSolicitudBB=0;
                                  $conteoSolicitudBBB=0;
                                  $conteoSolicitudAB=0;
                                  $conteoSolicitudCC=0;
                                  //// END
                                  while($elemento = readdir($directorio)){
                                        if($elemento != '.' && $elemento != '..'){
                                            
                                            //////////////// CARPETAS
                                                $var = "../../".$rutaVer.$elemento;
                                                 $var;
                                                $datos = $mysqli->query("SELECT * FROM repositorioCarpeta WHERE ruta = '$var'");
                                                $extraerDatos = $datos->fetch_array(MYSQLI_ASSOC);
                                                
                                                //// permiso de visualizar carpetas
                                                $permisoVerMas = FALSE;
                                                 '<br>id visua: '.$quienElabora = $extraerDatos["visualizar"];
                                                 '<br>id: '.$quienElaboraID = json_decode($extraerDatos["visualizarID"]);
                                                if($quienElabora == "cargo"){
                                                    if(in_array($cargo,$quienElaboraID)){
                                                        $permisoVerMas = TRUE;
                                                    }
                                                }
                                                
                                                if($quienElabora == "usuario"){ 
                                                    if(in_array($idparaChat,$quienElaboraID)){
                                                        $permisoVerMas = TRUE; 
                                                    }
                                                }
                                                
                                                $consultarIdGrupo=$mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario='$sesion' ");
                                                while($extraerGruposId=$consultarIdGrupo->fetch_array()){
                                                   $enviarIdGrupo=$extraerGruposId['idGrupo']; 
                                                   
                                                   if($quienElabora == "grupo"){
                                                        if(in_array($enviarIdGrupo,$quienElaboraID)){
                                                            $permisoVerMas = TRUE;
                                                        }
                                                    }
                                                
                                                }
                                                
                                                
                                                ///// colocamos esta linea de codigo, para que el dueño de la carpeta o la de un archivo pueda ver su propio documento o carpeta
                                                if($extraerDatos['usuario'] == $idparaChat ){
                                                    $habilitarVisualizar = "";
                                                }else{
                                                
                                                    if($permisoVerMas == FALSE){
                                                        $habilitarVisualizar = "disabled";
                                                    }else{
                                                        $habilitarVisualizar = "";
                                                    }
                                                }
                                                //// END
                                                
                                                
                                            ///// END
                                            
                                            
                                            
                                            //////////////// ARCHIVOS
                                            
                                            $varArchivo =$elemento;
                                            $explorando=explode(".",$varArchivo);
                                            $enviarSinExtension= $explorando[0];
                                            $enviarConExtension= $explorando[1];
                                            
                                                 //var_dump($enviarConExtension);
                                                //echo $var;
                                                $datosArchivos = $mysqli->query("SELECT * FROM repositorioRegistro WHERE nombre = '$enviarSinExtension' AND extension='$enviarConExtension' ");
                                                $extraerDatosArchivos = $datosArchivos->fetch_array(MYSQLI_ASSOC);
                                                
                                                //// permiso de visualizar carpetas
                                                $permisoVerMasArchivos = FALSE;
                                                $quienElaboraArchivos = $extraerDatosArchivos["visualizar"];
                                                
                                                
                                                $quienElaboraIDArchivos = json_decode($extraerDatosArchivos["visualizarID"]);
                                                if($quienElaboraArchivos == "cargo"){
                                                    if(in_array($cargo,$quienElaboraIDArchivos)){
                                                        $permisoVerMasArchivos = TRUE;
                                                    }
                                                }
                                                
                                                if($quienElaboraArchivos == "usuario"){
                                                    if(in_array($idparaChat,$quienElaboraIDArchivos)){
                                                        $permisoVerMasArchivos = TRUE;
                                                    }
                                                }
                                                
                                                $consultarIdGrupoArchivos=$mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario='$sesion' ");
                                                while($extraerGruposIdArchivos=$consultarIdGrupoArchivos->fetch_array()){
                                                   $enviarIdGrupoArchivos=$extraerGruposIdArchivos['idGrupo']; 
                                                   
                                                   if($quienElaboraArchivos == "grupo"){
                                                        if(in_array($enviarIdGrupoArchivos,$quienElaboraIDArchivos)){
                                                            $permisoVerMasArchivos = TRUE;
                                                        }
                                                    }
                                                
                                                }
                                                
                                                
                                                //// miramos la variable de quien sube el documento para habilitar la selec del usuario
                                                 'quien sube: '.$extraerDatosArchivos["realiza"];
                                                 '<br> - '.$idparaChat;
                                                
                                                //if($idparaChat == $extraerDatosArchivos["realiza"]){
                                                // $permisoVerMasArchivos=TRUE;    
                                                //}
                                                
                                                //var_dump($permisoVerMasArchivos);
                                                
                                                ///// colocamos esta linea de codigo, para que el dueño de la carpeta o la de un archivo pueda ver su propio documento o carpeta
                                                if($extraerDatosArchivos['realiza'] == $idparaChat ){
                                                    $habilitarVisualizarArchivos = "";
                                                }else{
                                                    if($permisoVerMasArchivos == FALSE){
                                                        $habilitarVisualizarArchivos = "disabled";
                                                    }else{
                                                        $habilitarVisualizarArchivos = "";
                                                    }
                                                }
                                                //// END
                                                
                                                
                                            ///// END
                                            
                                                  
                                             ?>
                                    <tr>
                                        <td class="" style="text-align:justify;">
                                        <?php
                                        if(is_dir($rutaVer.$elemento)){
                                        ?>
                                        
                                            <!--<form id=""> -->
                                                <input type="checkbox" <?php echo $habilitarVisualizar; ?> name="countries" id="rad_mostrar1<?php echo $conteoCarpetas++;?>" value="<?php echo $elemento;?>">
                                            <!--</form> -->
                                         
                                        <script>
                                        //// se coloca script para poder enviar la ruta con 3 contadres diferentes para que pueda conocer el conteo de las columnas por archivos
                                        $(document).ready(function(){
                                            
                                                    $('#rad_mostrar1<? echo $conteoCarpetasE++;?>').click(function(){
                                                        
                                                        //alert('Entre'); 
                                                        
                                                        document.getElementById("recibeDel").value = document.getElementById("rad_mostrar1<?php echo $conteoCarpetasE2++;?>").value;
                                                        document.getElementById("recibeEdit").value = document.getElementById("rad_mostrar1<?php echo $conteoCarpetasE3++;?>").value;
                                                        document.getElementById("solicitar").value = document.getElementById("rad_mostrar1<?php echo $conteoCarpetasE4++;?>").value;
                                                        document.getElementById("recibeCarpeta").value = document.getElementById("rad_mostrar1<?php echo $conteoCarpetasEE4++;?>").value;

                                                    });
                                                    
                                        
                                                });
                                        /// END
                                        </script>
                                        <?php
                                        }else{ 
                                        ?>
                                       
                                            <form id="formid">
                                                <?php  //validación para oculatar los archivos .zip
                                                $habilitarVisualizarArchivos;
                                                    if($enviarConExtension == 'zip'){ continue; }
                                                ?>
                                                <input type="checkbox" <?php echo $habilitarVisualizarArchivos; ?> name="countries" id="rad_mostrar<?php echo $conteoArchivos++;?>" value="<?php echo $elemento;?>">
                                            </form>
                                       
                                        <script>
                                        //// se coloca script para poder enviar la ruta con 3 contadres diferentes para que pueda conocer el conteo de las columnas por archivos
                                        $(document).ready(function(){
                                            
                                                    $('#rad_mostrar<?php echo $conteoArchivosE++;?>').click(function(){
                                                        
                                                        //alert('Entre');
                                                        document.getElementById("recibeID").value = document.getElementById("rad_mostrar<?php echo $conteoArchivosE2++;?>").value;
                                                        document.getElementById("recibeDel").value = document.getElementById("rad_mostrar<?php echo $conteoArchivosE3++;?>").value;
                                                        document.getElementById("recibeEdit").value = document.getElementById("rad_mostrar<?php echo $conteoArchivosE4++;?>").value;
                                                        document.getElementById("recibeDes").value = document.getElementById("rad_mostrar<?php echo $conteoArchivosE5++;?>").value;
                                                        document.getElementById("solicitar").value = document.getElementById("rad_mostrar<?php echo $conteoArchivosE6++;?>").value;

                                                    });
                                                    
                                        
                                                });
                                        /// END
                                        </script>
                                        <?php
                                        }
                                        ?>
                                        </td>
                                        <td>
                                        <?php    
                                        if(is_dir($rutaVer.$elemento)){
                                        ?>
                                            <form action="" method="POST">
                                                <button <?php echo $habilitarVisualizar; ?> class="btn" type="submit">
                                                <input type="hidden" name="verCarpeta" value="<?php echo $elemento;?>">
                                                <input type="hidden" name="nombreCarpeta" value="<?php echo $elemento;?>">
                                                <span style=" color:#293B7D;" ><i class="fa fa-folder fa-2x" ></i></span>
                                                </button>
                                            </form>
                                        <?php
                                        }else{  
                                        ?>
                                            <span style=" color: gray;" >
                                                <?php
                                                    //// dependiente de la extensión del archivo nos muestra su icono
                                                    //validación para oculatar los archivos .zip
                                                        if($enviarConExtension == 'zip'){
                                                           continue; 
                                                        }
                                                    if($enviarConExtension == 'docx' || $enviarConExtension == 'doc' ){
                                                            echo $iconoAchivo="<img src='iconos/word.jpg'  width='25px' height='30px'> ";
                                                            $saleA=TRUE;
                                                    }
                                                    elseif($enviarConExtension == 'pdf'){
                                                            echo $iconoAchivo="<img src='iconos/pdf.jpg'  width='25px' height='30px'> ";
                                                            $saleB=TRUE;
                                                    }
                                                    elseif($enviarConExtension == 'pptx'){
                                                            echo $iconoAchivo="<img src='iconos/power.jpg'  width='25px' height='30px'> ";
                                                            $saleB=TRUE;
                                                    }
                                                    elseif($enviarConExtension == 'xlsx' || $enviarConExtension == 'xls'){
                                                            echo $iconoAchivo="<img src='iconos/excel.jpg'  width='35px' height='30px'> ";
                                                             $saleC=TRUE;
                                                    }
                                                    elseif($enviarConExtension == 'png'){
                                                            echo $iconoAchivo="<img src='iconos/png.jpg'  width='25px' height='30px'> ";
                                                             $saleD=TRUE;
                                                    }
                                                    elseif($enviarConExtension == 'jpg'){
                                                            echo $iconoAchivo="<img src='iconos/jpg.jpg'  width='25px' height='30px'> ";
                                                             $saleE=TRUE;
                                                    }else{
                                                        echo '<i class="fas fa-file-alt fa-2x " ></i>';
                                                    }
                                                    
                                                    
                                                    
                                                     //echo '<i class="fas fa-file-alt fa-2x " ></i>';
                                                ?>
                                                <!--<i class="fas fa-file-alt fa-2x " ></i>-->
                                            </span>
                                        <?php
                                        } 
                                        ?>
                                        </td> 
                                        <td class="" style="text-align:left;">
                                            <?php    
                                                if(is_dir($rutaVer.$elemento)){
                                            ?>  <form action="" method="POST"></form>
                                                         <div class="">
                                                             <form action="" method="POST">
                                                                 <button <?php echo $habilitarVisualizar; ?> class="btn" type="submit">
                                                                 <span style="float:left;padding:0;"><h6><?php echo $elemento;?></h6></span>
                                                                 </button>
                                                                 <input type="hidden" name="verCarpeta" value="<?php echo $elemento;?>">
                                                                 <input type="hidden" name="nombreCarpeta" value="<?php echo $elemento;?>">
                                                             </form>
                                                         </div>
                                             <?php
                                                }else{ 
                                                    $varArchivo =$elemento;
                                                    $explorando=explode(".",$varArchivo);
                                                    $enviarSinExtension= $explorando[0];
                                                    
                                                    $consultamosArchivosBNombre=$mysqli->query("SELECT * FROM repositorioRegistro WHERE nombre='$enviarSinExtension' ");
                                                    $extraeIDArchivoBNombre=$consultamosArchivosBNombre->fetch_array(MYSQLI_ASSOC);
                                                    $verificandoSolicitudBNombre=$extraeIDArchivoBNombre['nombre'];
                                                    ?>
                                                    
                                                         <button class="btn" type="submit"><span style="float:left;padding:0;" ><h6><?php echo $elemento;?></h6></span></button>
                                                     
                                                    <?php
                                                }
                                            
                                            ?>
                                        </td>
                                        <!--
                                        <td>
                                            <?php
                                                $varArchivo =$elemento;
                                                $explorando=explode(".",$varArchivo);
                                                $enviarSinExtension= $explorando[0];
                                                    
                                                $consultamosArchivosBNombre=$mysqli->query("SELECT * FROM repositorioRegistro WHERE nombre='$enviarSinExtension' ");
                                                $extraeIDArchivoBNombre=$consultamosArchivosBNombre->fetch_array(MYSQLI_ASSOC);
                                                //echo $verificandoSolicitudBNombre=$extraeIDArchivoBNombre['nombre'];
                                            ?>
                                        </td>
                                        -->
                                        <td class=""  style="text-align:justify;">
                                            <?php 
                                                ////// id usuario archivos
                                                echo substr($extraerDatosArchivos['fechaCreacion'],0,-8);
                                                //// END
                                                ///// id usuario carpetas
                                                echo substr($extraerDatos['fechaCreacion'],0,-8);
                                                /// END
                                            ?>
                                        </td>
                                        <td class=""  style="text-align:justify;">
                                            <?php 
                                                ////// id usuario archivos
                                                $QuienRealizaArchivos=$extraerDatosArchivos['realiza'];
                                                $datosUsuarioArchivos = $mysqli->query("SELECT * FROM usuario WHERE id='$QuienRealizaArchivos' ");
                                                $extraUsuarioArchivos = $datosUsuarioArchivos->fetch_array(MYSQLI_ASSOC);
                                                echo $extraUsuarioArchivos['nombres'].' '.$extraUsuarioArchivos['apellidos'];
                                                //// END
                                                ////// id usuario carpetas
                                                $QuienRealizaArchivos=$extraerDatos['usuario'];
                                                $datosUsuarioArchivos = $mysqli->query("SELECT * FROM usuario WHERE id='$QuienRealizaArchivos' ");
                                                $extraUsuarioArchivos = $datosUsuarioArchivos->fetch_array(MYSQLI_ASSOC);
                                                echo $extraUsuarioArchivos['nombres'].' '.$extraUsuarioArchivos['apellidos'];
                                                //// END
                                            ?>
                                        </td> 
                                        <?php
                                        /*
                                        ?>
                                        <td class=""  style="text-align:justify;font-size:;"><?php
                                        
                                            if(is_dir($rutaVer.$elemento)){
                                               echo "Carpeta de archivos";
                                            }else{
                                                $varArchivo =$elemento;
                                                $explorando=explode(".",$varArchivo);
                                                json_encode($explorando);
                                                
                                                if($enviarConExtension == 'docx' || $enviarConExtension == 'doc'){
                                                    echo 'Word'; //'Documento de Microsoft Word';
                                                }
                                                elseif($enviarConExtension == 'pdf'){
                                                    echo 'Pdf';' //Microsoft Edge PDF Document';
                                                }
                                                elseif($enviarConExtension == 'pptx'){
                                                    echo 'PowerPoint'; //'Documento de Microsoft PowerPoint';
                                                }
                                                elseif($enviarConExtension == 'xlsx' || $enviarConExtension == 'xls'){
                                                    echo 'Excel'; //'Hoja de cálculo de Microsoft Excel';
                                                }
                                                elseif($enviarConExtension == 'png'){
                                                    echo 'Png'; //'Archivo PNG';
                                                }
                                                elseif($enviarConExtension == 'jpg'){
                                                    echo 'Jpg'; //'Archivo JPG';
                                                }else{
                                                    echo 'No existe descripción del archivo';
                                                }
                                                
                                               //echo "Archivo ".$enviarConExtension; 
                                            
                                                
                                            }
                                            ?>
                                        </td>
                                        <?php
                                        */
                                        ?>
                                        
                                        <?php
                                        if(is_dir($rutaVer.$elemento)){
                                        
                                         /// validación de script y funcion de eliminacion
                                        ?> 
                                       <td style="text-align:left;">
                                            <?php
                                            /// validamos en el sistema si la petición ya fue enviada, en caso de ser así el botón de solicitar queda desabilitado
                                                $consultamosArchivos=$mysqli->query("SELECT * FROM repositorioCarpeta WHERE nombre='$elemento' ");
                                                $extraeIDArchivo=$consultamosArchivos->fetch_array(MYSQLI_ASSOC);
                                                $verificandoSolicitud=$extraeIDArchivo['id'];
                                                $consultamosArchivosSolicitud=$mysqli->query("SELECT * FROM repositorioCarpetaSolicitud WHERE idRepositorio='$verificandoSolicitud' AND solicitante='$idparaChat' ");
                                                $extraeIDArchivoSolicitud=$consultamosArchivosSolicitud->fetch_array(MYSQLI_ASSOC);
                                                $extraeIDArchivoSolicitud['idRepositorio'];
                                            /// ENd
                                            
                                            
                                            if($verificandoSolicitud == $extraeIDArchivoSolicitud['idRepositorio']){
                                                
                                                /*
                                                //// validamos existencia de visualizacion de carpeta y declaramos la variable de visualizacion de carpeta
                                                $visualizacionCarpetaSseguraU=0;
                                                $visualizacionCarpetaSseguraC=0;
                                                $visualizacionCarpetaSseguraG=0;
                                                
                                                /// pregunta por usuario
                                                if($extraeIDArchivo['visualizar'] == 'usuario'){
                                                    
                                                   $validarUsuarioVer=json_decode($extraeIDArchivo['visualizarID']);
                                                    
                                                    for($u=0; $u<=count($validarUsuarioVer); $u++){ 
                                                        if($validarUsuarioVer[$u] == $idparaChat){
                                                            //echo ' (existe U) ';
                                                            $visualizacionCarpetaSseguraU=0;
                                                        }else{
                                                            //echo ' (no existe U) ';
                                                            $visualizacionCarpetaSseguraU++;
                                                        }
                                                    }
                                                
                                                }
                                                */
                                                
                                                    if($extraeIDArchivoSolicitud['estado'] == 'Aprobado' && $extraeIDArchivoSolicitud['solicitante'] == $idparaChat){
                                                    ?>
                                                        <button disabled style='background:#F7FA1E;width:70%;border:0px;' data-toggle='modal' data-target='#modal-dangerSolicitud' class='btn btn-block  btn-sm'><i class='fas fa-user-edit'></i> Autorizado</button>
                                                    <?php
                                                    }elseif($extraeIDArchivoSolicitud['estado'] == 'Pendiente' && $extraeIDArchivoSolicitud['solicitante'] == $idparaChat){
                                                    ?>
                                                        <button disabled style='background:#F7FA1E;width:70%;border:0px;' class='btn btn-block  btn-sm'><i class='fas fa-user-edit'></i> En proceso</button>
                                                    <?php
                                                    }else{
                                                        if($habilitarVisualizar == 'disabled'){ /// si esta variable viene disabled, quiere decir que debe solicitar, en caso contrario ya está habilitado
                                                            /////// si es administrador no debería poder crear archivo o carpeta
                                                            if($root == '1'){
                                                                echo 'El administrador no puede manipular repositorio';
                                                            }else{
                                                            ?>
                                                            <input type='hidden' id='capturaVariable<?php echo $conteoSolicitud++;?>'  value= '<?php echo $elemento;?>' >
                                                            <a onclick='funcionFormula<?php echo $conteoSolicitudA++;?>()' style='background:#F7FA1E;width:70%;border:0px;' data-toggle='modal' data-target='#modal-dangerSolicitud' class='btn btn-block  btn-sm'><i class='fas fa-user-edit'></i> Solicitar</a>
                                                            <?php 
                                                            }
                                                        }else{
                                                        ?>
                                                        <button disabled style='background:#F7FA1E;width:70%;border:0px;' data-toggle='modal' data-target='#modal-dangerSolicitud' class='btn btn-block  btn-sm'><i class='fas fa-user-edit'></i> Autorizado</button>
                                                    <?php    
                                                        }
                                                    
                                                    }
                                                
                                            
                                            }else{
                                           
                                                if($habilitarVisualizar == 'disabled'){
                                                    /////// si es administrador no debería poder crear archivo o carpeta
                                                    if($root == '1'){
                                                        echo 'El administrador no puede manipular repositorio';
                                                    }else{
                                                    ?>
                                                    
                                                        <input type='hidden' id='capturaVariable<?php echo $conteoSolicitud++;?>'  value= '<?php echo $elemento;?>' >
                                                        <a onclick='funcionFormula<?php echo $conteoSolicitudA++;?>()' style='background:#F7FA1E;width:70%;border:0px;' data-toggle='modal' data-target='#modal-dangerSolicitud' class='btn btn-block  btn-sm'><i class='fas fa-user-edit'></i> Solicitar</a>
                                                    
                                                    <?php
                                                    }
                                                }else{
                                            ?>
                                                <button disabled style='background:#F7FA1E;width:70%;border:0px;' data-toggle='modal' data-target='#modal-dangerSolicitud' class='btn btn-block  btn-sm'><i class='fas fa-user-edit'></i> Autorizado</button>
                                                
                                            <?php
                                                }
                                            }
                                            ?>
                                            
                                        </td> 
                                            <script>
                                                function funcionFormula<?php echo $conteoSolicitudB++;?>() {
                                                    /*alert("entre");*/
                                                  document.getElementById("solicitar").value = document.getElementById("capturaVariable<?php echo $conteoSolicitudC++;?>").value;
                                                }
                                           </script>
                                        <?php
                                        /// END
                                        
                                        }else{
                                        
                                         /// validación de script y funcion de eliminacion
                                        ?> 
                                        <td style="text-align:left;">
                                            <?php
                                            /// validamos en el sistema si la petición ya fue enviada, en caso de ser así el botón de solicitar queda desabilitado
                                           
                                            //// sacamos el nombre del archivo para poder consultar en la table de la base de datos 
                                                $varArchivo =$elemento;
                                                $explorando=explode(".",$varArchivo);
                                                $enviarSinExtension= $explorando[0];
                                            //// END sacamos el nombre del archivo para poder consultar en la table de la base de datos
                                            
                                            
                                                $consultamosArchivosB=$mysqli->query("SELECT * FROM repositorioRegistro WHERE nombre='$enviarSinExtension' ");
                                                $extraeIDArchivoB=$consultamosArchivosB->fetch_array(MYSQLI_ASSOC);
                                                $verificandoSolicitudB=$extraeIDArchivoB['id'];
                                                $consultamosArchivosSolicitudB=$mysqli->query("SELECT * FROM repositorioArchivoSolicitud WHERE idRepositorio='$verificandoSolicitudB' AND solicitante='$idparaChat' ");
                                                $extraeIDArchivoSolicitudB=$consultamosArchivosSolicitudB->fetch_array(MYSQLI_ASSOC);
                                                $extraeIDArchivoSolicitudB['idRepositorio'];
                                            /// ENd
                                            if($verificandoSolicitudB == $extraeIDArchivoSolicitudB['idRepositorio']){
                                                
                                                
                                              
                                                
                                                
                                                    if($extraeIDArchivoSolicitudB['estado'] == 'Aprobado' && $extraeIDArchivoSolicitudB['solicitante'] == $idparaChat ){
                                                    ?>
                                                        <button disabled style='background:#F7FA1E;width:70%;border:0px;' class='btn btn-block  btn-sm'><i class='fas fa-user-edit'></i> Autorizado</button>
                                                    <?php
                                                    }elseif($extraeIDArchivoSolicitudB['estado'] == 'Pendiente' && $extraeIDArchivoSolicitudB['solicitante'] == $idparaChat){
                                                    ?>
                                                        <button disabled style='background:#F7FA1E;width:70%;border:0px;' class='btn btn-block  btn-sm'><i class='fas fa-user-edit'></i> En proceso</button>
                                                    <?php
                                                    }else{
                                                        /////// si es administrador no debería poder crear archivo o carpeta
                                                        if($root == '1'){
                                                            echo 'El administrador no puede manipular repositorio';
                                                        }else{
                                                        ?>
                                                        <input type='hidden' id='capturaVariableB<?php echo $conteoSolicitudBB++;?>'  value= '<?php echo $enviarSinExtension;?>' >
                                                        <a onclick='funcionFormulaB<?php echo $conteoSolicitudAB++;?>()' style='background:#F7FA1E;width:70%;border:0px;' data-toggle='modal' data-target='#modal-dangerSolicitudArchivos' class='btn btn-block  btn-sm'><i class='fas fa-user-edit'></i> Solicitar</a>
                                                    
                                                        <?php
                                                        }
                                                    }
                                                
                                            
                                            }else{
                                                if($habilitarVisualizarArchivos == 'disabled'){
                                                    /////// si es administrador no debería poder crear archivo o carpeta
                                                    if($root == '1'){
                                                        echo 'El administrador no puede manipular repositorio';    
                                                    }else{
                                                    ?>
                                                    <input type='hidden' id='capturaVariableB<?php echo $conteoSolicitudBB++;?>'  value= '<?php echo $enviarSinExtension;?>' >
                                                    <a onclick='funcionFormulaB<?php echo $conteoSolicitudAB++;?>()' style='background:#F7FA1E;width:70%;border:0px;' data-toggle='modal' data-target='#modal-dangerSolicitudArchivos' class='btn btn-block  btn-sm'><i class='fas fa-user-edit'></i> Solicitar</a>
                                                
                                                    <?php
                                                    }
                                                }else{
                                                    ?>
                                                        <button disabled style='background:#F7FA1E;width:70%;border:0px;' class='btn btn-block  btn-sm'><i class='fas fa-user-edit'></i> Autorizado</button>
                                                
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </td> 
                                            <script>
                                                function funcionFormulaB<?php echo $conteoSolicitudBBB++;?>() {
                                                    //alert("entr2e");
                                                  document.getElementById("solicitarB").value = document.getElementById("capturaVariableB<?php echo $conteoSolicitudCC++;?>").value;
                                                }
                                           </script>
                                        <?php
                                        /// END
                                        
                                        }
                                        ?>
                                        
                                    <?php    
                                    } 
                                        
                                        
                                        ?>
                                        <div class="">
                                        </div>
                                    </tr>
                                <?php
                                  }
                                ?>
                        </tbody>
                    </table>
                            <!-- Creamos un form falso para no perder la petición cuando existe 1 sola carpeta-->
                             <div class="modal fade" id="">
                                    <div class="modal-dialog">
                                      <div class="modal-content bg-success">
                                        <div class="modal-header">
                                          <h4 class="modal-title">Alerta</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        
                                        <form action='' method='POST'>
                                        
                                        </form>
                                        
                                      </div>
                                    </div>
                                </div>  
                            <!-- end -->    
                                <div class="modal fade" id="modal-dangerSolicitud">
                                    <div class="modal-dialog">
                                      <div class="modal-content bg-success">
                                        <div class="modal-header">
                                          <h4 class="modal-title">Alerta</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        
                                        <form action='controlador/repositorio/controllerRepositorio' method='POST'>
                                        <div class="modal-body">
                                          
                                          
                                           <input type="" name="nombreSolicitante" id="solicitar" style="background:transparent;color:white;border:0px;width:100%;" >
                                          
                                           <br><br>
                                           <textarea class="form-control" name="motivo" placeholder="Describa el motivo de su solicitud....." onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || event.charCode == 46 || event.charCode == 44)" required></textarea>
                                        </div>
                                         <!-- formulario para eliminar por el id -->
                                        <div class="modal-footer justify-content-between">
                                          
                                          <input type="hidden" name="quienSolicita" value="<?php echo $idparaChat;?>">
                                          <input type="hidden" name="rutaSolicitar" value="<?php echo $rutaVer;?>">
                                          
                                          <button type="submit" name='solicitudMotivo' class="btn btn-outline-light">Aceptar</button>
                                          <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
                                        </div>
                                         </form>
                                         <!-- END formulario para eliminar por el id -->
                                      </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modal-dangerSolicitudArchivos">
                                    <div class="modal-dialog">
                                      <div class="modal-content bg-success">
                                        <div class="modal-header">
                                          <h4 class="modal-title">Alerta</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        
                                        <form action='controlador/repositorio/controllerRepositorio' method='POST'>
                                        <div class="modal-body">
                                          
                                          
                                           <input type="" name="nombreSolicitante" id="solicitarB" style="background:transparent;color:white;border:0px;width:100%;" >
                                          
                                           <br><br>
                                           <textarea class="form-control" name="motivo" placeholder="Describa el motivo de su solicitud....." onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || event.charCode == 46 || event.charCode == 44)" required></textarea>
                                        </div>
                                         <!-- formulario para eliminar por el id -->
                                        <div class="modal-footer justify-content-between">
                                          
                                          <input type="hidden" name="quienSolicita" value="<?php echo $idparaChat;?>">
                                          <input type="hidden" name="rutaSolicitar" value="<?php echo $rutaVer;?>">
                                          
                                          <button type="submit" name='solicitudMotivoArchivos' class="btn btn-outline-light">Aceptar</button>
                                          <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
                                        </div>
                                         </form>
                                         <!-- END formulario para eliminar por el id -->
                                      </div>
                                    </div>
                                </div>
                                
                </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid --> 
    </section>  
     
     
   
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
<!-- Script advertencia eliminar -->
<script>
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
</script>
<!-- Select2 -->
<script src="../plugins/select2/js/select2.full.min.js"></script>
<script type="text/javascript">
	function ConfirmDelete(){
		var answer = confirm("¿Esta seguro de eliminar?");

		if(answer == true){
			return true;
		}else{
			return false;
		}
	}
	function ConfirmAnular(){
		var answer = confirm("¿Esta seguro de anular?");

		if(answer == true){
			return true;
		}else{
			return false;
		}
	}
</script>
<script>
function myFunction() {
  alert("I am an alert box!");
}
</script>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    
    function ConfirmAnular(){
		var answer = confirm("¿Esta seguro de eliminar?");

		if(answer == true){
			return true;
		}else{
			return false;
		}
	}
</script>

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
        $('#rad_cargoAut').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoAut").html(data).required = true;
            }); 
        });
        $('#rad_usuarioAut').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoAut").html(data).required = true;
            }); 
        });
        $('#rad_grupoAut').click(function(){
            rad_grupo = "grupo";
            $.post("selectDocumentos2.php", { rad_grupo: rad_grupo }, function(data){
                $("#select_encargadoAut").html(data).required = true;
            }); 
        });
    });
</script>
<script>
        $(document).ready(function(){
            $('#rad_cargoAut').click(function(){
                document.getElementById('listarCargos').style.display = '';
                document.getElementById('listarUsuarios').style.display = 'none';
                document.getElementById('listarGrupos').style.display = 'none';

                
            });
            $('#rad_usuarioAut').click(function(){
                document.getElementById('listarCargos').style.display = 'none';
                document.getElementById('listarUsuarios').style.display = '';
                document.getElementById('listarGrupos').style.display = 'none';

            });
            $('#rad_grupoAut').click(function(){
                document.getElementById('listarCargos').style.display = 'none';
                document.getElementById('listarUsuarios').style.display = 'none';
                document.getElementById('listarGrupos').style.display = '';

            });
});
</script>
<script type="text/javascript">
/*
$(document).ready(function() {
    $('#enviar').click(function(){
        var selected = '';    
        $('#formid input[type=checkbox]').each(function(){
            if (this.checked) {
                selected += $(this).val()+', ';
            }
            
        }); 

        if (selected != '')
            alert('Has seleccionado: '+selected);
            
            
            
        else
            alert('Debes seleccionar  una opción.');

        return false;
    });         
});    */
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
// the selector will match all input controls of type :checkbox
// and attach a click event handler 
$("input:checkbox").on('click', function() {
  // in the handler, 'this' refers to the box clicked on
  var $box = $(this);
  if ($box.is(":checked")) {
    // the name of the box is retrieved using the .attr() method
    // as it is assumed and expected to be immutable
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    // the checked state of the group/box on the other hand will change
    // and the current value is retrieved using .prop() method
    $(group).prop("checked", false);
    $box.prop("checked", true);
  } else {
    $box.prop("checked", false);
  }
});    
</script>

<!-- archivos para el filtro de busqueda y lista de información -->

    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <!-- evento para funcionar el envio de la ruta y que funcione el filtro y el duallistbox -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- END -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>
<!-- END 
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script> -->

<!-- Page script -->
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<?php
/// validaciones de alertas
$validacionExisteSolicitud=$_POST['validacionExisteSolicitud'];
$validacionExiste=$_POST['validacionExiste'];
$validacionExisteR=$_POST['validacionExisteR'];
$validacionExisteRR=$_POST['validacionExisteRR'];
$validacionExisteB=$_POST['validacionExisteB'];
$validacionExisteC=$_POST['validacionExisteC'];
$validacionExisteD=$_POST['validacionExisteD'];
$validacionExisteE=$_POST['validacionExisteE'];
$validacionExisteF=$_POST['validacionExisteF'];
$validacionExisteG=$_POST['validacionExisteG'];
$validacionAgregar=$_POST['validacionAgregar'];
$validacionAgregarB=$_POST['validacionAgregarB'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionActualizarA=$_POST['validacionActualizarA'];
$validacionEliminar=$_POST['validacionEliminar'];
$validacionEliminarB=$_POST['validacionEliminarB'];

?>
<script type="text/javascript">
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 9000
    });
    
    
    <?php
    if($enviarAlertaArchivosNoExisteCarpeta == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Error, la carpeta no contiene archivos.'
        })
    <?php
    }
    if($enviarAlertaArchivosNoExisteCarpetaB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Error, debe seleccionar la carpeta ha comprimir.'
        })
    <?php
    }
    if($validacionExisteSolicitud == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Para solicitar elija un archivo o carpeta.'
        })
    <?php
    }
    if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Error, Asegurese de asignar usuarios para visualización.'
        })
    <?php
    }
    if($validacionExisteB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' La carpeta ya existe.'
        })
    <?php
    }
    if($validacionExisteC == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Fallo al crear las carpeta!'
        })
    <?php
    }
    if($validacionExisteD == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Para Eliminar elija un archivo o carpeta.'
        })
    <?php
    }
    if($validacionExisteE == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Para visualizar el contenido de la carpeta solo haga click sobre el nombre de la carpeta.'
        })
    <?php
    }
    if($validacionExisteF == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Para editar elija un archivo o carpeta.'
        })
    <?php
    }
    if($validacionExisteG == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Para Descargar elija un archivo.'
        })
    <?php
    }
    if($validacionExisteR == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Ya existe un registro con ese nombre.'
        })
    <?php
    }
     if($validacionExisteRR == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos caracteres no son permitidos.'
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
            title: 'La solicitud fue enviada.'
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
            title: 'Archivo Eliminado.'
        })
    
    <?php
    }
    if($validacionEliminarB == 1){
    ?>
        Toast.fire({
            type: 'error',
            title: 'Directorio Eliminado.'
        })
    
    <?php
    }
    ?>
    
  });

</script>
<script type='text/javascript'>
	   // document.oncontextmenu = function(){return false}
    </script>
</body>
</html>
<?php
}
?>