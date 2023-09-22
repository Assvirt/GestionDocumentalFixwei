<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
require_once 'conexion/bd.php';

$idSolicitud = $_POST['idSolicitud'];
$rol = $_POST['rol'];

$formulario = 'ordenCom'; //aqui se cambia el nombre del formulario
//require_once 'permisosPlataforma.php';
$documento = $_SESSION["session_username"];
$queryGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario = '$documento'");

while($row = $queryGrupos->fetch_assoc()){
    $idGrupo = $row['idGrupo'];
    
    $queryPermisos = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupo' AND formulario = '$formulario'");
    $permisos = $queryPermisos->fetch_array(MYSQLI_ASSOC);
    if($permisos['listar'] == TRUE){
        $permisoListar = $permisos['listar'];    
    }
    if($permisos['crear'] == TRUE){
        $permisoInsertar = $permisos['crear'];    
    }
    if($permisos['editar'] == TRUE){
        $permisoEditar = $permisos['editar'];    
    }
    if($permisos['eliminar'] == TRUE){
       $permisoEliminar = $permisos['eliminar'];    
    }
    
}

$root = $_SESSION['session_root'];

if($root == 1){
    $permisoListar = TRUE;
    $permisoInsertar = TRUE;
    $permisoEditar = TRUE;
    $permisoEliminar = TRUE;
}

if($permisoListar == FALSE){
    echo '<script language="javascript">window.location.href="accesoDenegado"</script>';
}

if($permisoInsertar == FALSE){
    $visibleI = 'none';
}else{
    $visibleI = '';
}

if($permisoEditar == FALSE){
    $visibleE = 'none';
}else{
    $visibleE = '';
}

if($permisoEliminar == FALSE){
    $visibleD = 'none';
}else{
    $visibleD = '';
}
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Orden de compra masiva</title>
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
<script type="text/javascript">
$(document).ready(function () {
   
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
   
    $("body").on("contextmenu",function(e){
        return false;
    });
});
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
            <h1>Crear Orden de compra masiva</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Crear Orden de compra masiva</li>
            </ol>
          </div>
        </div>
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                <div class="row">
                    <div class="col-sm">
                        <button type="button" class="btn btn-block btn-info btn-sm"><a href="solicitudComprador"><font color="white"><i class="fas fa-list"></i> Listar orden de compra</font></a></button>
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
            <div class="col">
            </div>
            <div class="col-9">

            <div class="card card-primary">
                    <div class="card-body">
                        <div class="card-body table-responsive p-0">
                        <table class="table table-head-fixed text-center" id="example">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Proceso</th>
                                    <th>Tipo de solicitud</th>
                                    <th>Centro de Trabajo</th>
                                    <th>Centro de Costo</th>
                                    <th>Necesidad</th>
                                    <th style="display:<?php echo $visibleE;?>;" >Editar</th>
                                    <th>Productos</th>
                                    <th>Gestionar</th>
                                    <th style="display:<?php echo $visibleD;?>;">Orden de compra</th>
                                   
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $consultaOrdenDeCompra=$mysqli->query("SELECT * FROM solicitudCompra WHERE estado='Ejecucion' ORDER BY id");
                                
                                $conteo='1';
                                while($recorridoOrdenCompra=$consultaOrdenDeCompra->fetch_array()){
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $recorridoOrdenCompra['id'];?>
                                    </td>
                                    <td>
                                        <?php 
                                        $procesoOC=$recorridoOrdenCompra['proceso'];
                                        $consultaProcesoOc = $mysqli->query("SELECT * FROM procesos WHERE id='$procesoOC'");
                                        $extraerProceso=$consultaProcesoOc->fetch_array(MYSQLI_ASSOC);
                                        echo $extraerProceso['nombre'];
                                       ?>
                                    </td>
                                    <td>
                                        <?php 
                                        //Tipo Solicitud
                                        $tipoSolicitudOC=$recorridoOrdenCompra['tipoCompra'];
                                        $consultaTipoOC = $mysqli->query("SELECT * FROM solicitudCompraTipo WHERE id='$tipoSolicitudOC'");
                                        $extraerTipoOC=$consultaTipoOC->fetch_array(MYSQLI_ASSOC);
                                        echo $extraerTipoOC['tipo'];

                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $centroTrabajoOC=$recorridoOrdenCompra['centroTrabajo'];
                                        $consultaCentroTrabajoOC=$mysqli->query("SELECT * FROM 	centrodetrabajo WHERE id_centrodetrabajo='$centroTrabajoOC' ");
                                        $extraerCentroTrabajoOC=$consultaCentroTrabajoOC->fetch_array(MYSQLI_ASSOC);
                                        echo $extraerCentroTrabajoOC['nombreCentrodeTrabajo'];
                                        ?>
                                    </td>
                                    <td>
                                       <?php
                                        $array = json_decode ($recorridoOrdenCompra['centroCosto']);
                                        $longitud = count($array);
                                            for($i=0; $i<$longitud; $i++){
                                              
                                                $validacionCentroCostoExt = $mysqli->query("SELECT * FROM centroCostos WHERE id='$array[$i]' ");
                                                $columnaValidandoCentroCosto = $validacionCentroCostoExt->fetch_array(MYSQLI_ASSOC); 
                                                
                                            	echo "*".$columnaValidandoCentroCosto['nombre']."<br>";
                                            }
                                        ?>
                                    </td>
                                     <td>
                                        <?php
                                        /*$tipoSolicitudOC=$recorridoOrdenCompra['tipoSolicitud'];
                                        $consultaTipoSolicitudOC=$mysqli->query("SELECT * FROM 	solicitudCompraTipo WHERE id='$tipoSolicitudOC' ");
                                        $extraerTipoSolicitudOC=$consultaTipoSolicitudOC->fetch_array(MYSQLI_ASSOC);
                                        echo $extraerTipoSolicitudOC['tipo'];*/
                                            if($recorridoOrdenCompra['TipoBS']=='B'){
                                                echo 'Bienes';
                                            }elseif($recorridoOrdenCompra['TipoBS']=='S'){ 
                                                echo 'Servicios';
                                            }elseif($recorridoOrdenCompra['TipoBS']=='A'){
                                                echo 'Ambos';   
                                            }
                                        ?>
                                    </td>
                                    <td style="display:<?php echo $visibleE;?>;">
                                        <form action="" method="POST">
                                        <input name="idSolicitudCompra" value="<?php echo $recorridoOrdenCompra['id'];?>" type="hidden">
                                        <button type='submit' name="editarOCMasivo" class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button>
                                        </form>
                                    </td>
                                    <?php
                                        echo"<form action='registroProductosMasvivos' method='POST'>";
                                        echo"<input type='hidden' name='compradorEditar' value= '1' >";
                                        echo"<input type='hidden' name='idOrdenCompra' value= '".$recorridoOrdenCompra['id']."' >";
                                        echo" <td style='display:$visibleF;'><button type='submit'  class='btn btn-block btn-info btn-sm'><i class='fas fa-boxes'></i> Productos</button></td>";
                                        echo"</form>";
                                        
                                        
                                        /// esta validación se coloca para evitar gestionar si no se ha asignado el segundo aprobador
                                        $validacionSegundaPersona=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idSolicitud='".$recorridoOrdenCompra['id']."' AND rol='2' AND estado='ejecucion' ");
                                        $extraerSegundaValidacion=$validacionSegundaPersona->fetch_array(MYSQLI_ASSOC);
                                        
                                        if($extraerSegundaValidacion != NULL){
                                        echo"<form action='solicitudCompraGestionarMasivo' method='POST'>";
                                        echo"<input type='hidden' name='idOrdenCompra' value= '".$recorridoOrdenCompra['id']."' >";
                                        echo" <td style='display:;'><button  type='submit' class='btn btn-block btn-warning btn-sm'><i class='fas fa-clipboard'></i> Gestionar </button></td>";
                                        echo"</form>"; 
                                        }else{
                                        echo" <td style='display:;'><button disabled  class='btn btn-block btn-warning btn-sm'><i class='fas fa-clipboard'></i> Gestionar </button></td>";
                                        }
                                        ////// validamos quién puede ver las solitudes asignadas
                                         $visualizacionSolicitud=$mysqli->query("SELECT * FROM solicitudComprador WHERE idSolicitud='".$recorridoOrdenCompra['id']."' AND estado='pendiente' ");
                                         $extraerDatos=$visualizacionSolicitud->fetch_array(MYSQLI_ASSOC);
                                         $idSolicitudOC=$extraerDatos['id']; 
                                        
                                        ///// validacion, hasta que no se genere una orden de compra no se habilita el botón para su gestión
                                        
                                        if($idSolicitudOC != NULL){
                                        echo"<form action='registroValoresMasivo' method='POST'>";
                                        echo"<input type='hidden' name='idOrdenCompra' value= '".$recorridoOrdenCompra['id']."' >";
                                        echo"<input type='hidden' name='oc' value= '$idSolicitudOC' >";
                                        echo"<td style='display:$visibleD;'><button type='submit' class='btn btn-block btn-primary btn-sm'><i class='fas fa-check'></i> Ejecutar</button></td>";
                                        echo"</form>";
                                        }else{
                                            echo"<td style='display:$visibleD;'><button disabled class='btn btn-block btn-primary btn-sm'><i class='fas fa-check'></i> Ejecutar</button></td>";
                                        
                                        }
                                    ?>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        
                        <?php //echo $conteo;
                        if($conteo > 1){
                        ?>
                        <div class="card-body" style="display:<?php echo $visibleE;?>;">
                            <form action="controlador/solicitudDocumentos/pruebaAlmacenamiento" method="POST">
                            <button type='submit' name="ejecutador" class='btn btn-block btn-info btn-sm float-left' style="width:20%;"><i class="fas fa-tasks"></i> Ejecutar todo</button>
                            </form>
                        </div>
                        <?php
                        }
                            $solicitud = $_POST['solicitud']; 
                        ?>
                        <p>
                            <?php 
                                echo $solicitud;
                            
                            $buscandoNombre=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                            $traerNombreSolicitud=$buscandoNombre->fetch_array(MYSQLI_ASSOC);
                            
                            ?>
                        </p>
                        </div>
                        
                            <br><br>
                    </div>
            </div>
            </div>    
      <div class="col">
            </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
<?php
if( $conteo >= 21){ 
?>
                                <center>
                                        <div class="modal-dialog">
                                          <div class="modal-content bg-danger">
                                            <div class="modal-header">
                                              <h4 class="modal-title">Alerta</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              <p>Ha llegado a su límite de registro.</p>
                                            </div>
                                           <div class="modal-footer justify-content-between">
                                           </div>
                                          </div>
                                        </div>
                                </center>
<?php
 }else{ 

    if(isset($_POST['editarOCMasivo'])){ 
      
        echo"<input type='hidden' name='idSolicitudCompra' value= '".$_POST['idSolicitudCompra']."' >";
      
    

                    $idSolicitudCompra=$_POST['idSolicitudCompra'];
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $data = $mysqli->query("SELECT * FROM solicitudCompra WHERE id='$idSolicitudCompra' ")or die(mysqli_error());
                    $datos = $data->fetch_array(MYSQLI_ASSOC);
                    $presupuesto=$datos['presupuesto'];
                    $centroCosto=$datos['centroCosto'];
                    $proceso=$datos['proceso'];
                    $fechaSolicitud=$datos['fechaSolicitud'];
                    $centroTrabajo=$datos['centroTrabajo'];
                    $quienRecibe=$datos['centroTrabajoEntrega'];
                    $tipoCompra=$datos['tipoCompra'];
                    $grupo=$datos['grupo'];
                    $nombreProducto=$datos['nombreProducto'];
                    $identificador=$datos['identificador'];
                    $presentacion=$datos['presentacion'];
                    $cantidad=$datos['cantidad'];
                    $urgencia=$datos['urgencia'];
                    $estado=$datos['estado'];
                    $rowUsuario=$datos['idUsuario'];
                    $contacto=$datos['contacto'];
                    $ruta=$datos['ruta'];
                    $ruta2=$datos['ruta2'];
                    $ruta3=$datos['ruta3'];
                    $ruta4=$datos['ruta4'];
                    $ruta5=$datos['ruta5'];
                    $contrato=utf8_encode($datos['contrato']);
                    $observaciones=$datos['observacion'];
                    $tipoSolicitud=$datos['tipoSolicitud'];
                   
 ?>
 

 <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
               
                <div class="card card-primary">
              <div class="card-header">
              
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/solicitudCompra/controllerOCMasiva" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    
                <!-- parametros para la activacion de correo y plataforma -->
                    <div class="row"> 
                        <div class="form-group col-sm-6">
                          <input name="idUsuario" value="<?php echo $sesion;?>" type="hidden" readonly>
                          <?php    'Id:'.$idSolicitudCompra; ?>
                           <?php  '<br>'; ?>
                          <?php    'Fecha:'.$fechaSolicitud; ?>
                           <?php  '<br>'; ?>
                          <?php 
                          $dataCentroCostos = $mysqli->query("SELECT * FROM centroCostos WHERE id='$centroCosto' ")or die(mysqli_error());
                          while($row = $dataCentroCostos->fetch_assoc()){
                              'Centro de Costos:'. $row['nombre'];
                                 '<br>';
                                }                         ?>
                         
                          <?php  
                           $dataProcesos = $mysqli->query("SELECT * FROM procesos WHERE id='$proceso' ")or die(mysqli_error());
                           while($row = $dataProcesos->fetch_assoc()){
                              'Proceso:'. $row['nombre'];
                               '<br>';
                                }
                           ?>
                          <?php  
                           $dataCentroTrabajo = $mysqli->query("SELECT * FROM centrodetrabajo WHERE id_centrodetrabajo='$centroTrabajo' ")or die(mysqli_error());
                           while($row = $dataCentroTrabajo->fetch_assoc()){
                              'Centro Trabajo:'. $row['nombreCentrodeTrabajo'];
                               '<br>';
                                }
                           ?>
                         <?php  
                           $dataTipoSolicitud = $mysqli->query("SELECT * FROM solicitudCompraTipo WHERE id='$tipoCompra' ")or die(mysqli_error());
                           while($row = $dataTipoSolicitud->fetch_assoc()){
                              'Tipo Solicitud:'. $row['tipo'];
                               '<br>';
                                }
                           ?>
                        
                          <?php   'Contacto: '.$contacto; ?>
                           <?php  '<br>'; ?>
                          <?php   $fechaSolicitud; ?>
                           <?php  '<br>'; ?>
                          
                          <?php   'Contrato: '.$contrato; ?>
                           <?php  '<br>'; ?>
                          
                        </div>
                    </div>
                <!-- Fin parametros para la activacion de correo y plataforma -->
                    
                    <?php
                    $idSolicitudCompra=$_POST['idSolicitudCompra'];
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $data = $mysqli->query("SELECT * FROM solicitudCompra WHERE id='$idSolicitudCompra' ")or die(mysqli_error());
                    $datos = $data->fetch_array(MYSQLI_ASSOC);
                    $datos['tipoCompra'];
                    
     //echo 'Archivo:'.$archivopdf = $_POST['archivo'];
                    'Archivo:';
    
                     $archivoNombre = $_FILES['archivopdf']['name'];
                     $guardado = $_FILES['archivopdf']['tmp_name'];              
                    $ruta5=$datos['ruta5'];
                    ?>
                    <input value="<?php echo $idSolicitudCompra; ?>" name="id" type="hidden" readonly>
                    
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Fecha Solicitud</label>
                            <input type="date" class="form-control" name="fechaSolicitud" value="<?php echo $fechaSolicitud; ?>" required>
                           
                        </div>
                         <div class="form-group col-sm-6">
                            <label>Dirección y Contacto de entrega:</label>
                            <input type="text" class="form-control" name="contacto" placeholder=" Direccion" value = "<?php echo $contacto;//$quienRecibe?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Tipo de solicitud:</label>
                           <select type="text" class="form-control"  name="tipoSolicitud" placeholder="" required>
                               
                                <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $data = $mysqli->query("SELECT * FROM solicitudCompraSolicitud WHERE id='$tipoSolicitud' ORDER BY tipo ASC")or die(mysqli_error());
                                while($row = $data->fetch_assoc()){
                                ?>
                                <option value="<?php echo $row['id'];?>"><?php echo $row['tipo'];?></option>
                                <?php
                                }
                                 $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $data = $mysqli->query("SELECT * FROM solicitudCompraSolicitud WHERE not id='$tipoSolicitud' ORDER BY tipo ASC")or die(mysqli_error());
                                while($row = $data->fetch_assoc()){
                                ?>
                                <option value="<?php echo $row['id'];?>"><?php echo $row['tipo'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Tipo Compra:</label>
                               
                            <select type="text" class="form-control" id="descripcion" name="tipoCompra" placeholder="" required>
                              
                                <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $data = $mysqli->query("SELECT * FROM solicitudCompraTipo WHERE id='$tipoCompra' ORDER BY tipo")or die(mysqli_error());
                                while ($columna = mysqli_fetch_array( $data )) { 
                                ?>
                                <option value="<?php echo $columna['id']; ?>"><?php echo $columna['tipo']; ?> </option>
                                <?php }  
                             
                                $data = $mysqli->query("SELECT * FROM solicitudCompraTipo WHERE not id='$tipoCompra' ORDER BY tipo")or die(mysqli_error());
                                while ($columna = mysqli_fetch_array( $data )) { 
                                ?>
                                <option value="<?php echo $columna['id']; ?>"><?php echo $columna['tipo']; ?> </option>
                                <?php }  ?>
                               
                            </select>
                        </div>   
                        <div class="form-group col-sm-6">
                             <label>Centro de costos:</label>
                             <?php
                               
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT * FROM centroCostos ");
                                $arrayCentroCosto = json_decode($datos['centroCosto']);
                            ?>
                          
                           
                                <div class="select2-blue">
                                    <select class="select2" multiple="multiple" data-placeholder="Seleccionar centro de costo" style="width: 100%;" name="centroCostoS[]" id="centroCostoS" required>
                                       <?php 
                                        $resultadoCT =$mysqli->query("SELECT * FROM presupuesto ORDER BY nombre ASC");
                                        while ($columna = mysqli_fetch_array( $resultadoCT )) { 
                                        
                                            //// validamos la existencia del presupuesto para el responsable del centro de costo
                                            $preguntandoExistenciaResponsableCC=$mysqli->query("SELECT * FROM centroCostos WHERE persona='".$columna['responsable']."' ");
                                            $respuestaExistenciaPresupuesto=$preguntandoExistenciaResponsableCC->fetch_array(MYSQLI_ASSOC);
                                            
                                            
                                            if($respuestaExistenciaPresupuesto['id'] != NULL){
                                                 if($arrayCentroCosto != NULL){ 
                                                    if(in_array($columna['id'],$arrayCentroCosto)){
                                                        $seleccionarCC= "selected";        
                                                    }else{
                                                        $seleccionarCC ="";
                                                    }
                                                  }
                                            }else{
                                                continue;
                                            }
                                        
                                        ?>
                                        <option value="<?php echo $respuestaExistenciaPresupuesto['id']; ?>"  <?php echo $seleccionarCC; ?> ><?php echo $respuestaExistenciaPresupuesto['codigo'].'-'.$respuestaExistenciaPresupuesto['nombre'];?> </option>
                                        <?php }  ?>        
                                    </select>
                                </div>
                            </div>
                            
                               
                          
                            
                                        
                 
                    
                        <div class="form-group col-sm-6">
                            <label>Centro de trabajo para entrega:  </label>
                                <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $data = $mysqli->query("SELECT * FROM centrodetrabajo ORDER BY nombreCentrodeTrabajo ")or die(mysqli_error());// WHERE id_centrodetrabajo='$centroTrabajo'
                                
                                ?>
                                <select type="text" class="form-control"  name="centroTrabajo" placeholder="" required>
                              
                                <?php
                                while($columna = mysqli_fetch_array($data)){
                                if($columna['id_centrodetrabajo'] == $centroTrabajo){    
                                     $selectTipo = "selected";
                                }else{
                                        $selectTipo = '';
                                    }
                                ?>    
                                 <option value="<?php echo $columna['id_centrodetrabajo'];?>"<?php echo $selectTipo;?>><?php echo $columna['nombreCentrodeTrabajo'];?></option>
                                <?php
                                }
                                ?>
                               
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Área o Proceso:</label>
                                <?php
                                
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $data = $mysqli->query("SELECT * FROM procesos ORDER BY nombre ")or die(mysqli_error());
                            ?>
                             <select type="text" class="form-control"  id="descripcion" name="procesoS" placeholder="" required>
                               
                                <?php
                                while ($columna = mysqli_fetch_array( $data )) { 
                                if($columna['id'] == $proceso){  
                                     $selectTipo = "selected";
                                    }else{
                                        $selectTipo = '';
                                    }
                               ?>
                                <option value="<?php echo $columna['id'];?>"<?php echo $selectTipo;?>><?php echo $columna['nombre'];?></option>
                                <?php
                                }
                                ?>
                               
                            </select>
                        </div>
                            <?php
                            $data = $mysqli->query("SELECT * FROM solicitudCompra WHERE id='$idSolicitudCompra' ")or die(mysqli_error());
                             while ($columna = mysqli_fetch_array( $data )) { 
                              if($columna['TipoBS']=='B'){
                                 $tipoBien='checked';
                             }else{
                             if($columna['TipoBS']=='S'){ 
                                $tipoServicio ='checked';
                              }else{
                               if($columna['TipoBS']=='A') 
                                $tipoAmbos ='checked';   
                              } 
                             }
                             }
                            ?>
                         <div class="form-group col-sm-6">
                            <label>Necesidad:</label>
                            <br>
                              Bienes
                                <input type="radio" value="B" name="tipoBien" <?php echo $tipoBien; ?> required> &nbsp
                                Servicios
                                <input type="radio" value="S" name="tipoBien" <?php echo $tipoServicio; ?> required>&nbsp
                                Ambos
                                <input type="radio" value="A" name="tipoBien" <?php echo $tipoAmbos; ?> required>
                            
                         </div>
                         
                        <div class="form-group col-sm-6">
                           <label>Contrato:</label>
                            <br>
                              <?php
                             $ancho=120; 
                            ?>
                            <textarea name="contrato" cols="40"  class="form-control" cols="<?php echo $ancho ; ?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required><?php echo utf8_decode($contrato); ?></textarea>
                        </div> 
                         <div class="form-group col-sm-6">
                           
                            <label>Observaciones:</label>
                            <br>
                            <?php
                             $ancho=120; 
                            ?>
                             <textarea name="observacion" class="form-control" cols="<?php echo $ancho ; ?>" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" ><?php echo $observaciones;  ?></textarea>
                        </div>
                        <div class="form-group col-sm-6">
                          
                            <label>Tiempo de entrega: (días)</label>
                            <br>
                            <input type="number" min="0" name="tiempo" value="<?php echo $datos['tiempo'];?>" class="form-control" placeholder="Tiempo de entrega..." required>
                        </div> 
                        
                        
                        </div>    
                     
                 
                
                </div>
                

                <div class="card-footer" >
                  
                  <button type="submit" class="btn btn-primary float-right" name="Actualizar">Actualizar</button>
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
 
 
 
<?php
    }else{ 
?>  
    <form  role="form" id="formCrearDoc" action="controlador/solicitudCompra/controllerOCMasiva" onsubmit="return checkSubmit(); event.preventDefault(); sendForm();" method="POST" enctype="multipart/form-data">
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
               <!-- <h3 class="card-title">Agregar solicitud de compra</h3>-->
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/solicitudCompra/controllerSolicitudCompra" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    
                <!-- parametros para la activacion de correo y plataforma -->
                    <div class="row"> 
                        <div class="form-group col-sm-6">
                          <input name="idUsuario" value="<?php echo $sesion;?>" type="hidden" readonly>
                          <!--<label>Notificaciones por: </label>&nbsp;&nbsp;-->
                              <?php if($visibleP != 'none'){ ?>
                              
                                <!--<label>Plataforma</label>-->
                                    <input style="border:0px;" name="plataforma" value="1" type="hidden" readonly>
                                <?php }else{  }
                          
                              if($visibleP != 'none' && $visibleC != 'none'){
                                   '-';
                              }
                          
                                    if($visibleC != 'none'){ ?>
                                <!--<label>Correo</label>-->
                                    <input style="border:0px;" name="correo" value="1" type="hidden" readonly>
                                <?php }else{  } ?>
                        </div>
                    </div>
                <!-- Fin parametros para la activacion de correo y plataforma -->
                    
                    
                    
                   <?php
                             date_default_timezone_set('America/Bogota');
                             //$fecha1=date('d-m-Y');
                    ?>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Fecha Solicitud</label>
                            <input type="date" class="form-control" name="fechaSolicitud" min="<?php echo date("Y-m-d"); ?>" value="<?php echo date("Y-m-d"); ?>" required>
                        </div>
                         <div class="form-group col-sm-6">
                            <label>Dirección y Contacto de entrega:</label>
                            <input type="text" class="form-control" name="contacto" placeholder="Ingrese Direccion" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                        </div>
                         <div class="form-group col-sm-6">
                            <label>Tipo de solicitud:</label>
                           <select type="text" class="form-control"  name="tipoSolicitud" placeholder="" required>
                                <option value=""></option>
                                <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $data = $mysqli->query("SELECT * FROM solicitudCompraSolicitud ORDER BY tipo ASC")or die(mysqli_error());
                                while($row = $data->fetch_assoc()){
                                ?>
                                <option value="<?php echo $row['id'];?>"><?php echo $row['tipo'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Tipo Compra</label>
                            <select type="text" class="form-control"  name="tipoCompra" placeholder="" required>
                                <option value=""></option>
                                <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $data = $mysqli->query("SELECT * FROM solicitudCompraTipo ORDER BY tipo ASC")or die(mysqli_error());
                                while($row = $data->fetch_assoc()){
                                ?>
                                <option value="<?php echo $row['id'];?>"><?php echo $row['tipo'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                         <div class="form-group col-sm-6">
                             <label>Centro de costos:</label>
                             
                                <div class="select2-blue">
                                    <select class="select2" multiple="multiple" data-placeholder="Seleccionar centro de costo" style="width: 100%;" name="centroCostoS[]" id="centroCostoS" required>
                                        <?php 
                                        $resultadoCT =$mysqli->query("SELECT * FROM presupuesto ORDER BY nombre ASC");
                                        while ($columna = mysqli_fetch_array( $resultadoCT )) { 
                                        
                                            //// validamos la existencia del presupuesto para el responsable del centro de costo
                                            $preguntandoExistenciaResponsableCC=$mysqli->query("SELECT * FROM centroCostos WHERE persona='".$columna['responsable']."' ");
                                            $respuestaExistenciaPresupuesto=$preguntandoExistenciaResponsableCC->fetch_array(MYSQLI_ASSOC);
                                            
                                            
                                            if($respuestaExistenciaPresupuesto['id'] != NULL){
                                                
                                            }else{
                                                continue;
                                            }
                                        
                                        ?>
                                        <option value="<?php echo $respuestaExistenciaPresupuesto['id']; ?>"><?php echo $respuestaExistenciaPresupuesto['codigo'].'-'.$respuestaExistenciaPresupuesto['nombre'];?> </option>
                                        <?php }  ?>      
                                    </select>
                                </div>
                           
                        </div>  
                         <div class="form-group col-sm-6">
                             <label>Centro de trabajo para entrega:</label>
                            <select type="text" class="form-control"  name="centroTrabajo" placeholder="" required>
                                <option value=""></option>
                                <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $data = $mysqli->query("SELECT * FROM centrodetrabajo ORDER BY nombreCentrodeTrabajo ASC")or die(mysqli_error());
                                while($row = $data->fetch_assoc()){
                                ?>
                                <option value="<?php echo $row['id_centrodetrabajo'];?>"><?php echo $row['nombreCentrodeTrabajo'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                         <div class="form-group col-sm-6">
                           <label>Área o Proceso</label>
                           
                            <?php
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultadoProcesos=$mysqli->query("SELECT * FROM procesos ORDER BY nombre");
                            ?>
                            <select type="text" class="form-control" id="proceso" name="procesoS" placeholder="Proceso" required>
                                <option value='' required></option>
                                <?php
                                while ($columnaProcesos = mysqli_fetch_array( $resultadoProcesos )) {
                                    if($columnaProcesos['estado'] == 'Eliminado'){
                                        continue;
                                    }
                                ?>
                                <option value="<?php echo $columnaProcesos['id']; ?>"><?php echo $columnaProcesos['nombre']; ?> </option>
                                <?php }  ?>
                            </select>
                        </div>         
                       
                        <div class="form-group col-sm-6">
                            <label>Necesidad:</label>
                            <br>
                              Bienes
                                <input type="radio" value="B" name="tipoBien"  required> &nbsp&nbsp
                                Servicios
                                <input type="radio" value="S" name="tipoBien"  required>&nbsp&nbsp
                                Ambas
                                <input type="radio" value="A" name="tipoBien"  required>
                            
                        </div>
                         
                         <div class="form-group col-sm-6">
                            <label>Contrato:</label>
                            <br>
                            <textarea name="contrato" cols="40" rows="10" class="form-control" placeholder="Digite Contrato..." onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required></textarea>
                        </div> 
                        <div class="form-group col-sm-6">
                          
                            <label>Observaciones:</label>
                            <br>
                            <textarea name="observacion" ols="40" rows="10" class="form-control" placeholder="Observaciones..." onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required></textarea>
                        </div> 
                        <div class="form-group col-sm-6">
                         
                            <label>Tiempo de entrega: (días)</label>
                            <br>
                            <input type="number" min="0" name="tiempo" class="form-control" placeholder="Tiempo de entrega..." required>
                        </div> 
                    
                          
                        </div>
                   
                   <!-- cuando el producto es nuevo abrimos esta vista -->
                   <div id="si" style="display:none;">
                           <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Grupo</label>
                                    <select type="text" class="form-control" name="grupo2" placeholder="" >
                                        <option value="">Seleccionar grupo...</option>
                                        <?php
                                        require 'conexion/bd.php';
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $data = $mysqli->query("SELECT * FROM proveedoresGrupo ORDER BY grupo ASC")or die(mysqli_error());
                                        while($row = $data->fetch_assoc()){
                                        ?>
                                        <option value="<?php echo $row['id'];?>"><?php echo $row['grupo'];?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Nombre del producto:</label>
                                    <input type="text" class="form-control" name="nombreProducto" placeholder="Nombre del producto" >
                                </div>                        
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Identificador</label>
                                    <input type="text" class="form-control" name="identificador" placeholder="Indicador" >
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Presentaci&oacute;n:</label>
                                    <input type="text" class="form-control" name="presentacion2" placeholder="Presentaci&oacute;n" >
                                </div>                        
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Cantidad</label>
                                    <input type="number" min="0" class="form-control"  name="cantidad2" placeholder="" >
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Nivel de urgencia:</label>
                                    <select type="text" class="form-control"  name="urgencia2" placeholder="" >
                                        <option value="">Seleccionar urgencia...</option>
                                        <?php
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $data = $mysqli->query("SELECT * FROM solicitudCompraUrgencia ORDER BY tipo ASC")or die(mysqli_error());
                                        while($row = $data->fetch_assoc()){
                                        ?>
                                        <option value="<?php echo $row['id'];?>"><?php echo $row['tipo'];?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>                        
                            </div> 
                    </div>
                    <!-- Fin al elegir el si -->
                   
                   <!-- cuando el producto no es nuevo abrimos esta vista -->
                   <div id="no" style="display:none;">
                           <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Grupo</label>
                                    <select type="text" class="form-control" id="cbx_grupo" name="grupo" placeholder="" >
                                        <option value="">Seleccionar grupo...</option>
                                        <?php
                                        require 'conexion/bd.php';
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $data = $mysqli->query("SELECT * FROM proveedoresGrupo ORDER BY grupo ASC")or die(mysqli_error());
                                        while($row = $data->fetch_assoc()){
                                        ?>
                                        <option value="<?php echo $row['id'];?>"><?php echo $row['grupo'];?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                                  
                            </div>

                    </div>
                    <!-- Fin al elegir el no -->

                </div>

                <div class="card-footer" >
                  
                  <button type="submit" class="btn btn-primary float-right" name="AgregarSolicitud">Agregar</button>
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
    
    </form>

<?php
    }
}
?>    
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
<!--Ckeditor-->
<script>
    CKEDITOR.replace( 'editor1' );
</script>
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
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
    });
</script>
<!--Oculta div versionamiento-->
<script>
    $(document).ready(function(){
        $('#rad_manual').click(function(){
            document.getElementById('codificacionManual').style.display = '';
            document.getElementById("id_version").setAttribute("required","any");
            document.getElementById("consecutivo").setAttribute("required","any");
            document.getElementById("idDocumento").setAttribute("required","any");
        });
        $('#rad_automatica').click(function(){
            document.getElementById('codificacionManual').style.display = 'none';
            document.getElementById("id_version").removeAttribute("required","any");
            document.getElementById("consecutivo").removeAttribute("required","any");
            document.getElementById("idDocumento").removeAttribute("required","any");
        });
    });
</script>
<!-- script que valida version y consecutivo -->
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
    
<script>

function sendForm(){
    //alert("formulario");
    
    var idProceso = $('#idproceso').val();
    var idTipoDocumento = $('#idtipoDoc').val();
    var consecutivo = $('#consecutivo').val();
    var idDocumento = $('#idDocumento').val();
    var valido = '';
    //alert(idProceso);
    //alert(idTipoDocumento);
    //alert(consecutivo);
    //alert(idDocumento);
    
    $.post("validaVersionamientoB.php", { consecutivo: consecutivo, idProceso: idProceso, idTipoDocumento: idTipoDocumento, idDocumento : idDocumento }, function(data){
        valido = data;
        //alert("ENTRO A LA FUNCION"+valido);
        if(valido == "si"){
           // alert("Consecutivo no valido.");
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
            
            //alert("Entra");
                                $(document).ready(function(){ //alert("Validando");
                                    //$('mostrarBotonFinalizar').click(function(){ alert("ValidandoB");
                                        document.getElementById('cargando').style.display = '';
                                        document.getElementById('botonValidarCarga').style.display = 'none';
                                        //alert("Saliendo validando");
                                    //});
                                });
            //alert("Sale");
            //return true;
        }
        
    }); 

}
    
</script>
<!-- Traer los Json de elaborador, revisor y aprobador cuando se edita el documento-->
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
            var radElaborador = "radElaborador";
            
            //alert(rad_post);
            
            $.post("selectDocumentosActualizar.php", { rad_post: rad_post, grupo: grupo, radElaborador: radElaborador}, function(data){
                $("#select_encargadoE").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
       
        
    });
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
            var radRevisor = "radRevisor";
            
            //alert(rad_post);
            
            $.post("selectDocumentosActualizar.php", { rad_post: rad_post, grupo: grupo, radRevisor: radRevisor}, function(data){
                $("#select_encargadoR").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
       
        
    });
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
            var radAprobador = "radAprobador";
            
            //alert(rad_post);
            //alert(grupo);
            //alert(radAprobador);
            $.post("selectDocumentosActualizar.php", { rad_post: rad_post, grupo: grupo, radAprobador: radAprobador}, function(data){
                $("#select_encargadoA").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
       
        
    });
    $(document).ready(function(){
        $('#rad_cargoD').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentosActualizar.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoD").html(data);
            }); 
        });
        $('#rad_usuarioD').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentosActualizar.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoD").html(data);
            }); 
        });
        

        var radios = document.getElementsByName('radiobtnD');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idDocumento").value;
            var grupo = radios[i].value;
            var responsableDisposicion = "responsableDisposicion";
            
            //alert(rad_post);
            
            $.post("selectDocumentosActualizar.php", { rad_post: rad_post, grupo: grupo, responsableDisposicion: responsableDisposicion}, function(data){
                $("#select_encargadoD").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
       
        
    });
</script>
<!-- END -->
<!-- SweetAlert2 -->
<link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<script>
    const MAXIMO_TAMANIO_BYTES = 11000000; // 1MB = 1 millón de bytes



    // Obtener referencia al elemento
    const $myInputPDF = document.querySelector("#myInputPDF");

    $myInputPDF.addEventListener("change", function () {
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
            $myInputPDF.value = "";
        } else {
            //alert(`alerta`);
            // Validación asada. Envía el formulario o haz lo que tengas que hacer
        }
    });


// myInpuEditable

   // Obtener referencia al elemento
   const $myInpuEditable = document.querySelector("#myInpuEditable");

$myInpuEditable.addEventListener("change", function () {
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
        $myInpuEditable.value = "";
    } else {
        // Validación asada. Envía el formulario o haz lo que tengas que hacer
    }
});
</script>
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
            title: 'Proceda a gestionar la orden de compra para habilitar la orden de compra.'
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