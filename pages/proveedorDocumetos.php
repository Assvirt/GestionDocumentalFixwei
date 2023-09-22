<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'politicas'; //Se cambia el nombre del formulario

require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
    <title>Proveedores Documentos</title>
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
               <?php
                    $consulta=$mysqli->query("SELECT * FROM proveedordocumentosCarpetas WHERE id='".$_POST['idCarpeta']."' ");
                    $extarer=$consulta->fetch_array(MYSQLI_ASSOC);
                    $idCarpetaPrincipal=$extarer['id'];
                    echo 'Carpeta <b>'.$nombreCarpeta=$extarer['nombre']; echo '</b>';
                    $estadoCarpeta=$extarer['estado'];
                    if($estadoCarpeta == 'aprobado' || $estadoCarpeta == 'Pendiente' ){
                        $disabledAprobado='disabled';
                    }else{
                        $disabledAprobado='';
                    }
                
                    $idProveedor=$_POST['idProveedor'];
                    $query = $mysqli->query("SELECT * FROM proveedores WHERE id= '$idProveedor'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $idEnviarProveedor = $row['id'];
                    $nit = $row['nit'];
                    $proveedor = $row['razonSocial'];
                    $realizador = $row['realizador'];
              ?>
            <h1>Documentos del proveedor <?php echo $proveedor; ?></h1>
            
            
           
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Proveedores Documentos</li>
            </ol>
          </div>
        </div>
        <div>
           
            <div class="row">
            
             <?php
                if($visibleI == FALSE){
                  
            ?>
                        <div class="col-sm">
                            <form action="agregarProveedorDocumento" method="POST">
                                <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" >
                                <input name="idCarpeta" value="<?php echo $_POST['idCarpeta'];?>" type="hidden">
                                
                                 <!-- id de la carpeta contenedora-->
                                  <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                                  <!-- Contador para las filas -->
                                  <input name="filas" value="<?php echo $_POST['filas']; ?>" type="hidden">
                                  <!-- mantenemos la carpeta abierta -->
                                  <?php
                                  if(isset($_POST['agregarArchivosDocumentos'])){
                                  ?>
                                  <input name="mantenerAbierto" value="1" type="hidden">
                                   <?php
                                  }
                                  
                                  
                                  /// si agregamos un documento en una carpeta diferentea la principal, se debe activar este input
                                  if($_POST['idCarpetaIdividual'] != NULL){
                                  ?>
                                  <input name="idCarpetaIdividual" value="<?php echo $_POST['idCarpetaIdividual'];?>" type="hidden">
                                  <?php
                                  }
                                   ?>
                                   <input name="nombreCarpeta" value="<?php echo $_POST['nombreCarpeta'];?>" type="hidden">
                                
                                <button type="submit"  name="agregarArchivosDocumentos" class="btn btn-block btn-info btn-sm"><a href="#"><font color="white"><i class="fas fa-plus-square"></i> Nuevo documento</font></a></button>
                            </form>
                        </div>
           
            <div class="col-sm">
                    <button type="button" class="btn btn-block btn-info btn-sm" data-toggle="modal" data-target="#modal-carpeta"><font color="white"><i class="fas fa-plus-square"></i> Nueva carpeta</font></button>
            
            <!--Modals-->
        <div class="modal fade" id="modal-carpeta">
            <div class="modal-dialog">
              <div class="modal-content">
                  <form action="controlador/proveedor/controllerCarpeta" method="POST">
                    <div class="modal-header">
                      <h4 class="modal-title">Crear carpeta</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                
                      <label>Nombre carpeta:</label><br>
                      <input type="text" name="nombre" placeholder="Nombre carpeta" class="form-control" required pattern="[a-zA-Z0-9á-úñ-áéíóúÁÉÍÓÚ ]{1,205}" title="No utilice caracteres especiales"onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" />
                    </div>
                  
                    <div class="modal-footer justify-content-between">
                      <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" >
                      <input name="idCarpeta" value="<?php echo $_POST['idCarpeta'];?>" type="hidden">
                      <!-- id de la carpeta contenedora-->
                      <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                      <!-- Contador para las filas -->
                      <input name="filas" value="<?php echo $_POST['filas']; ?>" type="hidden">
                      <!-- mantenemos la carpeta abierta -->
                      <?php
                      if(isset($_POST['agregarArchivosDocumentos'])){
                      ?>
                      <input name="mantenerAbierto" value="1" type="hidden">
                       <?php
                      }
                       ?>
                       
                       <input name="nombreCarpeta" value="<?php echo $_POST['nombreCarpeta'];?>" type="hidden">
                       
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
            
           
            </div>
            <?php
                }
            ?>
            
            <div class="col-sm"><!-- Vista PPAL -->
            <form action="proveedorDocumetosCarpetas" method="POST">
                    <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                    <button type="submit" class="btn btn-block btn-success btn-sm"><a href="#"><font color="white"><i class="fas fa-list"></i> Regresar</font></a></button>
            </form>
            </div>
            <?php
            if($realizador == $idparaChat){
                
                ///// validación para evitar la notificación del encargado de aprobación de documentos
                $validandoDocumento=$mysqli->query("SELECT * FROM proveedordocumentos WHERE idCarpeta='".$_POST['idCarpeta']."' ORDER BY nombre ASC")or die(mysqli_error());
                $extraerValidaciónDocumentos=$validandoDocumento->fetch_array(MYSQLI_ASSOC);
                
                if($extraerValidaciónDocumentos['id'] != NULL){
            ?>
            <div class="col-sm">
                <form action="controlador/proveedor/controllerProveedor" method="post">
                 <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                 <input name="nombreCarpetaPrincial" value="<?php echo $nombreCarpeta;?>" type="hidden">
                <button type="submit" class="btn btn-block btn-warning btn-sm" name="notificarAprobador"><a href="#"><font color="white"><i class="fas fa-bell"></i> Notificar aprobador</font></a></button>
                </form>
            </div>
            <?php
                }
            }
            ?>
            <div class="col-sm" id="mostrarBotonDescargar" style="display:none;">
                <form action="documentosProveedorB" target='_blank' method="post">
                        <input id="rutaNombreArchivo" name="rutaNombreArchivo" type="hidden">
                        <button  type='submit'  class='btn btn-block btn-warning btn-sm'>
                            <i style='color:white' class='fas fa-download'></i>
                           <a style='color:white' >Descargar</a>
                        </button>
                        
                </form>    
            </div>
            <div class="col-sm">
                   
                <?php
                
                           
               
                    
                    $data = $mysqli->query("SELECT * FROM proveedordocumentos WHERE idCarpeta='".$_POST['idCarpeta']."' ORDER BY nombre ASC")or die(mysqli_error());
                    $conteo=0;
                    while($row = $data->fetch_assoc()){
                        $conteo++;
                        $ruta=$row['soporte']; //echo '<br>';
                        $row['nombre'];
                    }
                   
                      
                       if($conteo > 0){ 
                            unlink('archivos/documentoProveedor/'.$nombreCarpeta.'.zip');
                            $zip = new ZipArchive();
                            $archivo="archivos/documentoProveedor/".$nombreCarpeta.".zip";
                            
                            if($zip->open($archivo,ZIPARCHIVE::CREATE)==true){
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $data = $mysqli->query("SELECT * FROM proveedordocumentos WHERE idCarpeta='".$_POST['idCarpeta']."' ORDER BY nombre ASC")or die(mysqli_error());
                                while($row = $data->fetch_assoc()){
                                    if($row['soporte'] != NULL){
                                        $zip->addFile(($row['soporte']));
                                       // echo ($row['soporte']); echo '<br>'; 
                                    }
                                }
                                
                                $zip->close();
                                //echo 'Agregado '.$archivo;
                                echo "<button type='button'  class='btn btn-block btn-warning btn-sm' >
                                                        <a style='color:white' href='archivos/documentoProveedor/".$nombreCarpeta.".zip'><i class='fas fa-download'></i> Descargar documentos</a>
                                                    </button>";
                            }else{
                                echo 'Ups ! algo salío mal, ponerse  en contacto con los programadores.';
                            }
                        }
                        
                ?>
            </div>
            <div class="col-sm">
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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"></h3>
                <div class="card-body table-responsive p-1 card-tools">
                <?php
                 if(isset($_POST['agregarArchivosDocumentos'])){ //// botón para regresar a la carpeta anterior ----------------------
                    
                ?>
               
                <form action="" method="post">
                    <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" >
                    <input name="idCarpeta" value="<?php echo $_POST['idCarpeta'];?>" type="hidden">
                      
                      
                      
                      
                    <?php
                     
                     if(ABS($_POST['filas']-1) == '0'){
                          $nombreboton='';
                     }else{
                    ?>
                      <!-- id de la carpeta contenedora-->
                      <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                      <!-- Contador para las filas -->
                      <input name="filas" value="<?php echo ABS($_POST['filas']-1); ?>" type="hidden">
                      <!-- mantenemos la carpeta abierta -->
                      <?php
                      if(ABS($_POST['filas']-1) == 1){ }else{
                      
                      /// consultamos la ruta anterior
                      
                      
                      if($_POST['regresar'] != NULL){ 
                            $consultarAnterior=$mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE id='".$_POST['regresar']."' ");
                            $extraerConsultaRutaAnteior=$consultarAnterior->fetch_array(MYSQLI_ASSOC);
                      }else{
                            $consultarAnterior=$mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE idCarpeta='".$_POST['idCarpeta']."' AND filas='".$_POST['filas']."'-1 AND ruta='".$_POST['nombreCarpeta']."'  ");
                            $extraerConsultaRutaAnteior=$consultarAnterior->fetch_array(MYSQLI_ASSOC);
                            $extraerConsultaRutaAnteior['id'];
                      }
                      
                     
                      
                      ?>
                      
                      <input name="nombreCarpeta" value="<?php echo $extraerConsultaRutaAnteior['indicativo'];?>" type="hidden">
                      
                    <?php
                      }
                         $nombreboton='agregarArchivosDocumentos';
                     
                        
                     }
                     
                    
                          
                ?>
                   
                    <button type="submit" class="btn btn-primary float-left btn-sm" name="<?php echo $nombreboton;?>"><i class="fa fa-arrow-left"></i></button>
                </form> 
                <br>
                <?php 
               
                // traemos la ruta donde viajamos
                echo $nombreCarpeta.'/';
                
                    $indicativo=$_POST['nombreCarpeta'];
                    if($indicativo != NULL){
                    
                        
                                        $subConsultaRuta=$mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE id='".$_POST['idCarpetaIdividual']."' ");
                                        $extraerSubConsultaRuta=$subConsultaRuta->fetch_array(MYSQLI_ASSOC);
                                        $nombreCarpetaRuta=$extraerSubConsultaRuta['ruta'];
                                            $consultarRuta=$mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE principal='".$_POST['id']."' GROUP BY filas");
                                            while($extraerRuta=$consultarRuta->fetch_array()){
                                                
                                                if($extraerRuta['indicativo'] != NULL){
                                                    
                                                }else{
                                                    $subConsultaRutaPrincipal=$mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE id='".$extraerRuta['principal']."' ");
                                                    $extraerSubConsultaRutaPrincipal=$subConsultaRutaPrincipal->fetch_array(MYSQLI_ASSOC);
                                                    echo ($extraerSubConsultaRutaPrincipal['nombre']).'/';
                                                }
                                                
                                                if($extraerRuta['filas'] <= $_POST['filas']){
                                                    
                                                }else{
                                                    continue;
                                                }
                                            
                                                echo ($extraerRuta['indicativo']);
                                            }
                                        echo ($nombreCarpetaRuta);
                        
                    }else{ //$acentos2 = $mysqli->query("SET NAMES 'utf8'");
                        $subConsultaRutaPrincipal=$mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE id='".$_POST['id']."' ");
                        $extraerSubConsultaRutaPrincipal=$subConsultaRutaPrincipal->fetch_array(MYSQLI_ASSOC);
                        echo ($extraerSubConsultaRutaPrincipal['nombre']).'/';
                    }
                
                // END
              
                    $idRuta=$_POST['id']; //echo '<br>';
                    $buscandoRuta=$mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE id='$idRuta' ");
                    while($extraerRuta=$buscandoRuta->fetch_array()){
                        $idFilas=$extraerRuta['filas'];
                        
                      
                            $buscandoRutaB=$mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE id='$idFilas' ");
                            while($extraerRutaB=$buscandoRutaB->fetch_array()){
                                 $extraerRutaB['filas'];
                                
                            }
                            
                           
                            echo '<br>';
                        
                        
                        
                        
                    }
                
                }else{
                    //echo 'Carpeta <b>'.$nombreCarpeta; echo '</b>'; 
                }
                ?>
              </div>
            </div>
              <!-- /.card-header -->
              
              <div class="card-body table-responsive p-0" >
                
                <table class="table table-head-fixed text-center">
                  <thead>
                    <tr>
                      <th>Seleccionar</th>
                      <th>Nombre</th>
                      <!--<th>Detalle</th>-->
                      <th>Editar</th>
                      <th>Eliminar </th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                   
                   
                    if($_POST['id'] != NULL){
                     $_POST['id'];
                     $_POST['filas'];
                     
                      
                     $indicativo=$_POST['nombreCarpeta'];
                     if($indicativo != NULL){
                        $data = $mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE idCarpeta='".$_POST['idCarpeta']."' AND principal='".$_POST['id']."' AND filas='".$_POST['filas']."'  AND indicativo='".$_POST['nombreCarpeta']."' ORDER BY nombre ASC")or die(mysqli_error());
                     }else{
                        $data = $mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE idCarpeta='".$_POST['idCarpeta']."' AND principal='".$_POST['id']."' AND filas='".$_POST['filas']."'  ORDER BY nombre ASC")or die(mysqli_error());
                     }
                    }else{
                     $data = $mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE idCarpeta='".$_POST['idCarpeta']."' ORDER BY nombre ASC")or die(mysqli_error());
                    }
                     $conteo=1;
                     while($row = $data->fetch_assoc()){
                         $id = $row['id'];
                        
                        if(isset($_POST['agregarArchivosDocumentos'])){
                            
                        }else{
                            if($row['principal'] != NULL){
                                continue;
                            }
                        }
                        
                    echo"<tr>";
                     ?>
                    <td>
                        <input type="checkbox" name="seleccionar" id="rad_mostrar1<?php echo $conteoCarpetas++;?>" value="<?php echo $id;?>"> 
                        <script>
                        //// se coloca script para poder enviar la ruta con 3 contadres diferentes para que pueda conocer el conteo de las columnas por archivos
                        $(document).ready(function(){
                                             
                                    $('#rad_mostrar1<? echo $conteoCarpetasE++;?>').click(function(){
                                        document.getElementById("recibeDel").value = document.getElementById("rad_mostrar1<?php echo $conteoCarpetasE2++;?>").value;
                                        
                                        document.getElementById('validadarNotificacion').style.display = ''; 
                                        document.getElementById('validadarNotificacionMensaje').style.display = 'none'; 
                                        
                                    });
                        });
                        /// END
                        </script>
                    </td>
                    <td style="text-align:left;">
                        <form action="" method="post">
                            <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" >
                            <input name="idCarpeta" value="<?php echo $_POST['idCarpeta']; ?>" type="hidden" >
                          
                          
                            <?php
                            // validamos que no exista un principal para amarrar todo a la primera carpeta
                            if($row['principal'] != NULL){
                            ?>
                            <input name="filas" value="<?php echo $row['filas']+1;?>" type="hidden">
                            <input name="id" value="<?php echo $row['principal']; ?>" type="hidden" >
                            <input name="nombreCarpeta" value="<?php echo $row['nombre']; ?>/" type="hidden" >
                            <input name="regresar" value="<?php echo $row['id'];?>" type="hidden">
                           <?php
                            }else{
                           ?>
                             
                             <input name="filas" value="1" type="hidden">
                             <input name="id" value="<?php echo $row['id']; ?>" type="hidden" >
                            <?php
                            }
                            ?>
                            <input name="idCarpetaIdividual" value="<?php echo $row['id'];?>" type="hidden"> 
                            <!-- para matener los archivos enviamos este campo -->
                           
                            <button type="submit" style="border:0px;background:transparent;" name="agregarArchivosDocumentos">
                            <?php
                                echo"<span style=' color:#293B7D;' align='text-align: left;' ><i class='fa fa-folder fa-2x' ></i></span><font color='white'>--</font>".utf8_encode($row['nombre']).''." ";
                            ?>
                            </button>
                        </form>
                    </td>
                    <?php
                    $idEnviarCarpeta=$_POST['idCarpeta'];
                    echo '<td>';
                    echo"<form action='' method='POST'>";
                    echo "<input name=\"idProveedor\" value=\"$idProveedor\" type=\"hidden\" >
                          <input name=\"idCarpeta\" value=\"$idEnviarCarpeta\" type=\"hidden\" >";
                          
                    ?>
                    
                     <!-- id de la carpeta contenedora-->
                              <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                              <!-- Contador para las filas -->
                              <input name="filas" value="<?php echo $_POST['filas']; ?>" type="hidden">
                              <!-- mantenemos la carpeta abierta -->
                              <?php
                              if(isset($_POST['agregarArchivosDocumentos'])){
                              ?>
                              <input name="mantenerAbierto" value="1" type="hidden">
                               <?php
                              }
                              ?>
                              <input name="nombreCarpeta" value="<?php echo $_POST['nombreCarpeta'];?>" type="hidden">
                              <input name="idCarpetaIndividual" value="<?php echo $row['id']; ?>" type="hidden">
                    <?php
                      if(isset($_POST['agregarArchivosDocumentos'])){
                         echo "<input type=\"hidden\" name=\"agregarArchivosDocumentos\" value=\"1\">";
                      }
                      
                    echo" <button type='submit' name='editarCarpeta' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button>
                    </form>";
                    
                   
                    ?>
                    </td>
                        <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $id;?>' >
                        <td style='display:<?php ?>'><a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                        <script>
                            function funcionFormula<?php echo $contador2++;?>() {
                                /*alert("entre");*/
                              document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                            }
                       </script>
                        <?php
                    echo"</tr>";
                    
                        
                    } 
                    ?>
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
                            <form action='controlador/proveedor/controllerCarpeta' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" >
                              <input name="idCarpeta" value="<?php echo $_POST['idCarpeta']; ?>" type="hidden" >
                              
                              <!-- id de la carpeta contenedora-->
                              <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                              <!-- Contador para las filas -->
                              <input name="filas" value="<?php echo $_POST['filas']; ?>" type="hidden">
                              <!-- mantenemos la carpeta abierta -->
                              <?php
                              if(isset($_POST['agregarArchivosDocumentos'])){
                              ?>
                              <input name="mantenerAbierto" value="1" type="hidden">
                               <?php
                              }
                              ?>
                              <input name="nombreCarpeta" value="<?php echo $_POST['nombreCarpeta'];?>" type="hidden">
                               
                              
                              
                              <input type="hidden" id="capturarFormula" name='idEditar' readonly>
                              
                              <button type="submit" name='EliminarSubcarpeta' class="btn btn-outline-light">Si</button>
                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                            </div>
                             </form>
                             <!-- END formulario para eliminar por el id -->
                          </div>
                        </div>
                    </div> 
                  </tbody>
                  
                  <!-- iniciamos la consulta para mostrar los archivos ------------------------------    -->
                  
                   <tbody>
                    <?php
                    ////// tabla para los archivos
                    
                    if($_POST['id'] != NULL){
                        $_POST['id'];
                        $_POST['filas'];
                        $indicativo=$_POST['nombreCarpeta'];
                        if($indicativo != NULL){
                         
                           '-'.$_POST['id'];
                           '-'.$_POST['filas'];
                           '-'.$_POST['nombreCarpeta'];
                          
                          $subConsultaId = $mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE idCarpeta='".$_POST['idCarpeta']."' AND principal='".$_POST['id']."' AND filas='".$_POST['filas']."'  AND indicativo='".$_POST['nombreCarpeta']."' ORDER BY nombre ASC")or die(mysqli_error());
                          $extraerSubConsultaId=$subConsultaId->Fetch_array(MYSQLI_ASSOC);
                           '--indicativo: '.$mostrarResultado=$extraerSubConsultaId['indicativo'];
                          
                          // en caso que el indicativo venga vacio se cambia la consulta
                          if($mostrarResultado != NULL){
                              $mostrarResultado=$mostrarResultado;
                          }else{
                              $subConsultaId = $mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE idCarpeta='".$_POST['idCarpeta']."' AND principal='".$_POST['id']."' AND filas='".$_POST['filas']."'-1  AND ruta='".$_POST['nombreCarpeta']."' ORDER BY nombre ASC")or die(mysqli_error());
                              $extraerSubConsultaId=$subConsultaId->Fetch_array(MYSQLI_ASSOC);
                               '--indicativo: '.$mostrarResultado=$extraerSubConsultaId['ruta']; 
                          }
                          
                          $subConsultaIdValidando = $mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE idCarpeta='".$_POST['idCarpeta']."' AND principal='".$_POST['id']."' AND filas='".$_POST['filas']."'-1  AND ruta='$mostrarResultado' ORDER BY nombre ASC")or die(mysqli_error());
                          $extraerSubConsultaIdValidando=$subConsultaIdValidando->Fetch_array(MYSQLI_ASSOC);
                          $mostrarResultadoValidando=$extraerSubConsultaIdValidando['id'];
                          $data = $mysqli->query("SELECT * FROM proveedordocumentos WHERE idCarpeta='".$_POST['idCarpeta']."' AND indicativo ='$mostrarResultadoValidando' ORDER BY nombre ASC")or die(mysqli_error());
                          
                        }else{ 
                         
                          $subConsultaId = $mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE idCarpeta='".$_POST['idCarpeta']."' AND principal='".$_POST['id']."' AND filas='".$_POST['filas']."'  ORDER BY nombre ASC")or die(mysqli_error());
                          $extraerSubConsultaId=$subConsultaId->Fetch_array(MYSQLI_ASSOC);
                          echo $mostrarResultado=$extraerSubConsultaId['indicativo'];
                          if($mostrarResultado != NULL){
                            
                          }else{ 
                            if($extraerSubConsultaId['principal'] != NULL){ 
                            $data = $mysqli->query("SELECT * FROM proveedordocumentos WHERE idCarpeta='".$_POST['idCarpeta']."' AND indicativo ='".$extraerSubConsultaId['principal']."' ORDER BY nombre ASC")or die(mysqli_error());
                            }else{
                            $data = $mysqli->query("SELECT * FROM proveedordocumentos WHERE idCarpeta='".$_POST['idCarpeta']."' AND indicativo ='".$_POST['id']."' ORDER BY nombre ASC")or die(mysqli_error());
                            }
                          }
                        }
                    }else{
                        // $data = $mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE idCarpeta='".$_POST['idCarpeta']."' ORDER BY nombre ASC")or die(mysqli_error());
                        $data = $mysqli->query("SELECT * FROM proveedordocumentos WHERE idCarpeta='".$_POST['idCarpeta']."' AND indicativo IS NULL ORDER BY nombre ASC")or die(mysqli_error());
                    }
                    
                   
                     
                     $conteo=1;
                     while($row = $data->fetch_assoc()){
                        $id = $row['id'];
                        $ruta=$row['soporte'];
                        
                         
                        
                        
                    echo"<tr>";
                    ?>
                        <td><input type="checkbox" name="seleccionar2<?php echo $conteoArchivosName++;?>" id="rad_mostrar2<?php echo $conteoArchivos++;?>" value="<?php echo $id;?>"> </td>
                        <script>
                        //// se coloca script para poder enviar la ruta con 3 contadres diferentes para que pueda conocer el conteo de las columnas por archivos
                        $(document).ready(function(){
                                            
                                    $('#rad_mostrar2<? echo $conteArchivossE++;?>').click(function(){ 
                                        replicarId = document.getElementById("rutaNombreArchivo").value = document.getElementById("rad_mostrar2<?php echo $conteoArchivosE2++;?>").value;
                                       
                                        /// replicamos el id que se envia para descargar el documento, enviar al controlador que notifica el documento rechazado
                                        document.getElementById("recibeDel").value = replicarId;  
                                        document.getElementById("identificarArchivo").value = 1;
                                       
                                        /// mostramos el boton de descargar
                                        document.getElementById('mostrarBotonDescargar').style.display = '';
                                        // agregamos la funcion del boton también al seleccionar el archivo
                                        document.getElementById('validadarNotificacion').style.display = ''; 
                                        document.getElementById('validadarNotificacionMensaje').style.display = 'none'; 
                                    });
                        });
                        /// END
                        </script>
                    <?php
                    // echo"<span style=' color:#293B7D;' ><i class='fa fa-folder fa-2x' ></i></span><font color='white'>--</font>".$row['nombre'].''." ";
                    echo "<td style='text-align:left;'><span i class='far fa-file fa-2x' style=' color:#000080;'></i></span>  ".' '. $row['nombre'].' '."</td>";
                    
                    
                    
                    
                        
                    
                 
                    echo"<form action='agregarProveedorDocumentoEditar' method='POST'>";
                    echo"<input type='hidden' name='idA' value= '$id' >";
                    echo"<input type='hidden' name='idProveedor' value= '$idProveedor' >";
                    echo"<input type='hidden' name='idCarpeta' value=".$_POST['idCarpeta']." >";
                    
                    
                    // validamos que el aporbador no pueda editar o eliminar un documento
                    $consultaProveedores=$mysqli->query("SELECT * FROM proveedores WHERE id='$idProveedor' ");
                    $extraerConsultaProveedor=$consultaProveedores->fetch_array(MYSQLI_ASSOC);
                  
                            $tipoResponsableV=$extraerConsultaProveedor['radio'];
                            $personalIDV =  json_decode($extraerConsultaProveedor['aprobador']);
                            $longitudV = count($personalIDV);
                   
                            if($tipoResponsableV == 'usuario'){
                                            for($i=0; $i<$longitudV; $i++){ //// inicia for
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalIDV[$i]' ");
                                                while($columna = $nombreuser->fetch_assoc()){
                                                    $cedulaUsuario=$columna['id'];
                                                }
                                            }  /////// cierre del for
                            }else{    
                                            for($i=0; $i<$longitudV; $i++){ //// inicia for
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$personalIDV[$i]' ");
                                                while($columna = $nombreuser->fetch_assoc()){
                                                    $cedulaUsuario=$columna['id_cargos']; 
                                                }
                                            }  /////// cierre del for    
                                
                            }
                            
                            if($tipoResponsableV == 'usuario'){
                                if($cedulaUsuario == $idparaChat){
                                    $hbilitarPermisoAprpbador='disabled';
                                }else{
                                    $hbilitarPermisoAprpbador='';
                                }
                            }else{
                                if($cedulaUsuario == $cargo){
                                    $hbilitarPermisoAprpbador='disabled';
                                }else{
                                    $hbilitarPermisoAprpbador='';
                                }
                                
                            }
                            
                    //$visibleE
                   //$hbilitarPermisoAprpbador
                    echo" <td style='display:;'><button type='submit'  class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";// $disabledAprobado
                    ?>
                     <!-- id de la carpeta contenedora-->
                                  <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                                  <!-- Contador para las filas -->
                                  <input name="filas" value="<?php echo $_POST['filas']; ?>" type="hidden">
                                  <!-- mantenemos la carpeta abierta -->
                                  <?php
                                  if(isset($_POST['agregarArchivosDocumentos'])){
                                  ?>
                                  <input name="mantenerAbierto" value="1" type="hidden">
                                   <?php
                                  }
                                  
                                  
                                  /// si agregamos un documento en una carpeta diferentea la principal, se debe activar este input
                                  if($_POST['idCarpetaIdividual'] != NULL){
                                  ?>
                                  <input name="idCarpetaIdividual" value="<?php echo $_POST['idCarpetaIdividual'];?>" type="hidden">
                                  <?php
                                  }
                                   ?>
                                   <input name="nombreCarpeta" value="<?php echo $_POST['nombreCarpeta'];?>" type="hidden">
                    <?php
                    echo" </form>";
                    
                    
                    //$visibleD
                    if($disabledAprobado == 'disabled'){
                        echo "<td style='display:;'><button $disabledAprobado type='submit' class='btn btn-block btn-danger btn-sm'><i class='fas fa-edit'></i> Eliminar</button></td>";
                    }else{
                        ?>
                        <input type='hidden' id='capturaVariableArchivos<?php echo $contadorArchivo++;?>'  value= '<?php echo $id;?>' >
                        <?php
                        /*if($hbilitarPermisoAprpbador == 'disabled'){
                            
                            echo "<td style='display:;'><button disabled type='submit' class='btn btn-block btn-danger btn-sm'><i class='fas fa-edit'></i> Eliminar</button></td>";
                    
                        }else{*/
                        ?>
                        <td style='display:<?php ?>'><a onclick='funcionFormulaarchivos<?php echo $contador1Archivos++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-dangerArchivos' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                        <?php
                        //}
                        ?>
                        <script>
                            function funcionFormulaarchivos<?php echo $contador2Archivos++;?>() {
                               
                              document.getElementById("capturarFormulaArchivos").value = document.getElementById("capturaVariableArchivos<?php echo $contador3Archivos++;?>").value;
                            
                              
                            }
                       </script>
                    <?php   
                    }
                    
                    echo"</tr>";
                    
                        echo '</td>';
                    } 
                    ?>
                     <div class="modal fade" id="modal-dangerArchivos">
                        <div class="modal-dialog">
                          <div class="modal-content bg-danger">
                            <div class="modal-header">
                              <h4 class="modal-title">Alerta</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>¿Est&aacute; seguro que desea eliminar el archivo?</p>
                            </div>
                             <!-- formulario para eliminar por el id -->
                            <form action='controlador/proveedor/controllerDocumento' method='POST'>
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               <input name="idCarpeta" value="<?php echo $_POST['idCarpeta']; ?>" type="hidden" readonly>
                               
                               
                              <!-- id de la carpeta contenedora-->
                                  <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                                  <!-- Contador para las filas -->
                                  <input name="filas" value="<?php echo $_POST['filas']; ?>" type="hidden">
                                  <!-- mantenemos la carpeta abierta -->
                                  <?php
                                  if(isset($_POST['agregarArchivosDocumentos'])){
                                  ?>
                                  <input name="agregarArchivosDocumentos" value="1" type="hidden">
                                   <?php
                                  }
                                  
                                  
                                  /// si agregamos un documento en una carpeta diferentea la principal, se debe activar este input
                                  if($_POST['idCarpetaIdividual'] != NULL){
                                  ?>
                                  <input name="idCarpetaIdividual" value="<?php echo $_POST['idCarpetaIdividual'];?>" type="hidden">
                                  <?php
                                  }
                                   ?>
                                   <input name="nombreCarpeta" value="<?php echo $_POST['nombreCarpeta'];?>" type="hidden">
                               
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormulaArchivos" name='idA' >
                              <button type="submit" name='eliminar' class="btn btn-outline-light">Si</button>
                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                            </div>
                             </form>
                             <!-- END formulario para eliminar por el id -->
                          </div>
                        </div>
                    </div>
                  </tbody>
                  
                </table>
              </div>
              
              
                <?php
                /////// recuperamos el id que ingresa para editar con funciones del modal
                if(isset($_POST['editarCarpeta'])){
                   $idCarpetaIndividual=$_POST['idCarpetaIndividual'];
                   
                   $consultaCarpeta=$mysqli->query("SELECT * FROM proveedorSubCarpetas WHERE id='$idCarpetaIndividual' ");
                   $extraerConsultaCarpeta=$consultaCarpeta->fetch_array(MYSQLI_ASSOC);
                   $nombreCarpetaEditar=$extraerConsultaCarpeta['nombre'];
                ?>
                
                      <button style="display:none;" type="button" id="action-button" data-toggle="modal" data-target="#modal-carpetaEditar"></button>
                
                        <!--Modals-->
                        <div class="modal fade" id="modal-carpetaEditar">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                  <form action="controlador/proveedor/controllerCarpeta" method="POST">
                                    <div class="modal-header">
                                      <h4 class="modal-title">Editar carpeta</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                
                                      <label>Nombre carpeta:</label><br>
                                      <input type="text" name="nombre" placeholder="Nombre carpeta" value="<?php echo $nombreCarpetaEditar;?>" class="form-control" required pattern="[a-zA-Z0-9á-úñ-áéíóúÁÉÍÓÚ ]{1,205}" title="No utilice caracteres especiales" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)"/>
                                    </div>
                                  
                                    <div class="modal-footer justify-content-between">
                                      <input name="idEditar" value="<?php echo $idCarpetaIndividual; ?>" type="hidden" >
                                       <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" >
                                      <input name="idCarpeta" value="<?php echo $_POST['idCarpeta'];?>" type="hidden">
                                      
                                       <!-- id de la carpeta contenedora-->
                                      <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                                      <!-- Contador para las filas -->
                                      <input name="filas" value="<?php echo $_POST['filas']; ?>" type="hidden">
                                      <!-- mantenemos la carpeta abierta -->
                                      <?php
                                      if(isset($_POST['agregarArchivosDocumentos'])){
                                      ?>
                                      <input name="mantenerAbierto" value="1" type="hidden">
                                       <?php
                                      }
                                      ?>
                                      <input name="nombreCarpeta" value="<?php echo $_POST['nombreCarpeta'];?>" type="hidden">
                                       
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                      <button type="submit" name="EditarSubCarpeta" class="btn btn-primary">Editar</button>
                                    </div>
                                </form>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                            <script>
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
                           </script> 
                           <button id="action-button" style="display:none;" data-toggle="modal" data-target="#modal-sm"></button>
                <?php
                }
                  /// end
                ?>
              
             
              
               <!-- capturamos el id para enviar al correo la ruta exacta -->
                
              
              <?php
               
                       $validandoAprobador=$mysqli->query("SELECT * FROM proveedores WHERE id='$idProveedor' ");
                       while($extraerValidacionAProbdor=$validandoAprobador->fetch_array()){
                       
                       
                        $quienElaboraConteoV = $extraerValidacionAProbdor['radio']; 
                        $quienElaboraIDconteoV = json_decode($extraerValidacionAProbdor['aprobador']);
                        
                        if($quienElaboraConteoV == "cargo"){
                            if(in_array($cargo,$quienElaboraIDconteoV)){
                                $habilitarAprbacion='1';
                            }
                        }
                        
                        if($quienElaboraConteoV == "usuario"){
                            if(in_array($idparaChat,$quienElaboraIDconteoV)){
                                $habilitarAprbacion='1';
                            }
                        }
                       }
                
              
              
              
            ?>  
             <div class="col-sm-12">
                            <div class="card">
                               
                                    <div style="padding: 20px;" class="tab-pane" id="timeline">
                                        <!-- The timeline -->
                                        <div class="timeline timeline-inverse">
                                          <!-- timeline time label -->
                                          <?php 
                                           
                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                            $queryControl = $mysqli->query("SELECT * FROM proveedoresControlCambio WHERE idProveedor = '$idProveedor' ")or die(mysqli_error($mysqli));
                                            
                                            while($row = $queryControl->fetch_assoc()){
                                                $idUser = $row['Usuario'];
                                                $rol = $row['rol'];
                                                $queryUser = $mysqli->query("SELECT * FROM usuario WHERE id = '$idUser' ")or die(mysqli_error($mysqli));
                                                $datosUser = $queryUser->fetch_assoc();

                                                $nombreUsuario = $datosUser['nombres']." ".$datosUser['apellidos'];
                                          
                                          ?>
                                          
                                          <div class="time-label">
                                            <span class="bg-danger">
                                              <?php echo $row['fecha'];?>
                                            </span>
                                          </div>

                                          <div>
                                            <i class="fas fa-user bg-info"></i>
                    
                                            <div class="timeline-item">
                                              <h3 class="timeline-header border-0"><b><?php echo $row['rol'];?></b> - <a href="#"><?php echo $nombreUsuario;?></a> <?php  if('1' != NULL){ echo utf8_decode($row['comentario']); }else{ echo 'N/A';} ?>
                                              </h3>
                                            </div>
                                          </div>
                                        <?php }?>
                                        </div>
                                     </div>
                            </div>
                        </div>   
                    
            <?php        
                if($habilitarAprbacion == 1){
              ?>
              <form action="controlador/proveedor/controllerDocumento" method="post"> <!---->
                  
                  <input name="idCarpetaParaCorreo" id="recibeDel" type="hidden" > 
                  <input name="identificarArchivo" id="identificarArchivo" type="hidden" >
                  
                  <input name="filas" value="<?php echo $_POST['filas']; ?>" type="hidden">
              <div class="card-header">
                
                    <input type='hidden' name='idProveedor' value= '<?php echo $idProveedor;?>' >
                    <input type='hidden' name='idCarpeta' value="<?php echo $_POST['idCarpeta']; ?>" >
                    
                <?php
                $estadoCarpeta=$extarer['estado'];
                if($estadoCarpeta == 'aprobado'){
                    $checkedA='checked';
                    $disabledEstadoComentado='disabled';
                }
                if($estadoCarpeta == 'rechazado'){
                    $checkedB='checked'; 
                    $disabledEstadoComentado='disabled';
                }
                ?>
               
               
                
                
                
                
                <br>
                <?php
                if($estadoCarpeta=$extarer['estado'] == 'aprobado'){
                    $ocultandoOpciones='1';
                    echo '<font color="green">Documentos aprobados</font>';
                }
                
                if($estadoCarpeta=$extarer['estado'] == 'rechazado'){
                    $ocultandoOpciones='1';
                    echo '<font color="red">Documentos rechazados</font>';
                }
                
                if($estadoCarpeta=$extarer['estado'] == 'Pendiente'){
                    echo '<font color="green">Documentos pendientes en revisión</font><br>';
                }
                
                if($ocultandoOpciones == '1'){ }else{
                ?>
                <label>Aprobación del proveedor</label><br>
                Aprobar
                <input type="radio" name="aprobadorDocumento" id="desactivarInput" value="aprobado" <?php echo $checkedA; ?> required>&nbsp;
                Rechazar
                <input type="radio" name="aprobadorDocumento" id="activarInput" value="rechazado" <?php echo $checkedB; ?> required>
                <?php
                }
                ?>
                <br><br>
                
                <?php
                if($habilitarAprbacion == 1){
                ?>
                <label>Especifique el Motivo de decisión</label>
                <?php
                }else{
                ?>
                <label>Comentario</label>
                <?php
                }
                ?>
                <textarea name="comentario" <?php //echo $disabledEstadoComentado;?> class="form-control" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)"><?php //echo utf8_decode($extarer['comentario']);?></textarea>
                <br>
                <?php
                 if($ocultandoOpciones == '1'){ }else{
                ?>
                <button type="submit" id="validadarNotificacion" <?php echo $disabledEstadoComentado;?> class="btn btn-primary float-left" name="aprobado">Agregar</button>
                
                <span style="display:none;" id="validadarNotificacionMensaje" <?php echo $disabledEstadoComentado;?> class="btn btn-primary float-left" >Agregar</span>
                <?php
                }
                ?>
                <input name="rol" value="Aprobador" type="hidden">
                <input name="usuario" value="<?php echo $idparaChat;?>" type="hidden">
                </form>
              </div>
                <script>
                    //////////// si le damos en rechazar nos pide obligatorio el campo de la notificación
                                    $(document).ready(function(){
                                        $('#activarInput').click(function(){ 
                                            document.getElementById("recibeDel").setAttribute("required","any"); 
                                            
                                            var notificacionID = document.getElementById("recibeDel").value;
                                            //document.getElementById("recibeDel").removeAttribute("required","any"); // se agrega esta linea
                                            
                                            
                                            /*if(notificacionID > 0){
                                                
                                                document.getElementById('validadarNotificacion').style.display = '';
                                                document.getElementById('validadarNotificacionMensaje').style.display = 'none';
                                                
                                            }else{
                                               
                                                document.getElementById('validadarNotificacion').style.display = 'none';
                                                document.getElementById('validadarNotificacionMensaje').style.display = '';
                                                        $('#validadarNotificacionMensaje').click(function(){ 
                                                         
                                                                    const Toast = Swal.mixin({
                                                                      toast: true,
                                                                      position: 'top-end',
                                                                      showConfirmButton: false,
                                                                      timer: 4000
                                                                    });
                                                                   Toast.fire({
                                                                        type: 'warning',
                                                                        title: ' Debe seleccionar el elemento ha notificar.'
                                                                    })
                                                        });
                                            }*/
                                            
                                            
                                        });
                                        $('#desactivarInput').click(function(){ 
                                            document.getElementById("recibeDel").removeAttribute("required","any");
                                        });
                                        
                                        /// se agregar para validar enviar datos sin seleccionar
                                        //$('#activarInput').click(function(){ 
                                        //    document.getElementById("recibeDel").removeAttribute("required","any");
                                        //});
                                        /// ENd
                                    });
                                    
                                   
                                    
                                    
                                    
                    
                </script>
                
                                      <!-- id de la carpeta contenedora-->
                                      <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                                      <!-- Contador para las filas -->
                                      <input name="filas" value="<?php echo $_POST['filas']; ?>" type="hidden">
                                      <!-- mantenemos la carpeta abierta -->
                                      <?php
                                      if(isset($_POST['agregarArchivosDocumentos'])){
                                      ?>
                                      <input name="mantenerAbierto" value="1" type="hidden">
                                       <?php
                                      }
                                      ?>
                                      <input name="nombreCarpeta" value="<?php echo $_POST['nombreCarpeta'];?>" type="hidden">
                                 
                <?php
                }else{
                ?>
                
                <div class="card-header">
                    <!-- únicamente para dejar descargar el archivo, cuando no es el aprobador-->
                    <input  id="recibeDel" type="hidden" >
                    <input  id="identificarArchivo" type="hidden" >
                    <!-- END -->
                    
                    <form action="controlador/proveedor/controllerDocumento" method="post"> 
                        <input type='hidden' name='idProveedor' value= '<?php echo $idProveedor;?>' >
                        <input name="rol" value="Solicitante" type="hidden">
                         <input name="usuario" value="<?php echo $idparaChat;?>" type="hidden">
                        <?php
                        if($estadoCarpeta=$extarer['estado'] == 'aprobado'){
                            $alertaMensaje='<font color="green">Documentos aprobados</font>';
                            $displayDisponibilidad='none';
                        }
                        
                        if($estadoCarpeta=$extarer['estado'] == 'rechazado'){
                            $alertaMensaje='<font color="red">Documentos rechazados</font>';
                            $displayDisponibilidad='';
                        }
                        
                        if($estadoCarpeta=$extarer['estado'] == 'Pendiente'){
                            $alertaMensaje='<font color="green">Documentos pendientes en revisión</font>';
                            $displayDisponibilidad='';
                        }
                        
                        
                         'Quién hizo la solicitud: '.$realizador;
                         '<br>Mi id: '.$idparaChat;
                        if($realizador == $idparaChat){
                        ?>            
                        <div class="card-header">
                            <label>Comentario</label>
                            <textarea  name="comentario" class="form-control" required></textarea>
                            <br>
                            <?php echo $alertaMensaje; ?>
                            <br><br>
                             <button style="display:<?php echo $displayDisponibilidad;?>;" type="submit"  class="btn btn-primary float-left" name="comentarioAgregar">Agregar</button>
                        </div>
                        <?php
                        }
                        ?>
                    </form>
                </div>
                <?php
                }
              ?>
              
              
   <?php
if($_POST['alerta'] != NULL){
?>
                        <script>
                            $(document).ready(function() {
                              // indicamos que se ejecuta la funcion a los 5 segundos de haberse
                              // cargado la pagina
                              setTimeout(clickbutton, 0000);
                            
                              function clickbutton() {
                                // simulamos el click del mouse en el boton del formulario
                                $("#action-button-bloqueado").click();
                                //alert("Aqui llega"); //Debugger
                              }
                              $('#action-button-bloqueado').on('click',function() {
                               // console.log('action');
                              });
                            });
                       </script> 
                       <button id="action-button-bloqueado" style="display:none;" data-toggle="modal" data-target='#modal-danger-alerta-Bloqueo'></button>
                    
                        <div class="modal fade" id="modal-danger-alerta-Bloqueo">
                            <div class="modal-dialog">
                              <div class="modal-content bg-danger">
                                <div class="modal-header">
                                  <h4 class="modal-title">Alerta</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>El nombre del archivo contiene caracteres inválidos, por favor digite el nombre completo del archivo e intente cargar.</p>
                                </div>
                                 <!-- END formulario para eliminar por el id -->
                              </div>
                            </div>
                        </div>
<?php
}
?>               
              
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
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
<!-- Script advertencia eliminar -->
<script type="text/javascript">
	function ConfirmDelete(){
		var answer = confirm("¿Esta seguro de eliminar?");

		if(answer == true){
			return true;
		}else{
			return false;
		}
	}
</script>
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<?php
/// validaciones de alertas
$validacionExiste=$_POST['validacionExiste'];
$validacionExisteB=$_POST['validacionExisteB'];
$validacionExisteC=$_POST['validacionExisteC'];
$validacionExisteD=$_POST['validacionExisteD'];
$validacionExisteE=$_POST['validacionExisteE'];
$validacionAgregar=$_POST['validacionAgregar'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];


//// validaciones de importacion
$validacionExisteImportacion=$_POST['validacionExisteImportacion'];
$validacionExisteImportacionB=$_POST['validacionExisteImportacionB'];
$validacionExisteImportacionC=$_POST['validacionExisteImportacionC'];
$validacionExisteImportacionD=$_POST['validacionExisteImportacionD'];
$validacionExisteImportacionE=$_POST['validacionExisteImportacionE'];
$validacionExisteImportacionF=$_POST['validacionExisteImportacionF'];
$validacionExisteImportacionH=$_POST['validacionExisteImportacionG'];
$validacionExisteImportacionExito=$_POST['validacionExisteImportacionExito'];
$validacionExisteD=$_POST['validacionExisteD'];
/// END

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
    if($validacionExisteImportacionExito == 1){
     ?>
        Toast.fire({
            type: 'success',
            title: ' Excel importado correctamente.'
        })
    <?php   
    }
    if($validacionExisteImportacion == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Está intentando subir un archivo diferente.'
        })
    <?php
    }
    if($validacionExisteImportacionB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos procesos están repetidos en el documento.'
        })
    <?php
    }
    if($validacionExisteImportacionC == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos prefijos están repetidos en el documento.'
        })
    <?php
    }
    if($validacionExisteImportacionD == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos nombres están repetidos.'
        })
    <?php
    }
    if($validacionExisteImportacionE == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos dueños de procesos no existen.'
        })
    <?php
    }
    if($validacionExisteImportacionF == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos prefijos están repetidos.'
        })
    <?php
    }
    if($validacionExisteImportacionG == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos macroproceso no existen.'
        })
    <?php
    }
    if($validacionExisteImportacionH == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos elementos no existen o estan repetidos.'
        })
    <?php
    }
    
    
    
    if($validacionExisteD == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El archivo ya existe.'
        })
    <?php
    }
    
    if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' La carpeta ya existe.'
        })
    <?php
    }
    if($validacionExisteB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El prefijo ya existe.'
        })
    <?php
    }
    if($validacionExisteC == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El nombre del proceso ya existe.'
        })
    <?php
    }
    /*if($validacionExisteD == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El prefijo del proceso ya existe.'
        })
    <?php
    }*/
    if($validacionExisteE == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: ' Documentos aprobados.'
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
</body>
</html>
<?php
}
?>