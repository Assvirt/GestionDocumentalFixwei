<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
//require_once 'inactividad.php';
require_once 'conexion/bd.php';

$celdulaUser = $_SESSION['session_username']; 
$cargoID = $_SESSION['session_cargo']; 

//////////////////////PERMISOS////////////////////////

$formulario = 'solicitudDocumentos'; //aqui se cambia el nombre del formulario

require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Solicitud documental</title>
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
<script>
   	
    function nobackbutton(){
    	
       window.location.hash="no-back-button";
    	
       window.location.hash="Again-No-back-button" //chrome
    	
       window.onhashchange=function(){window.location.hash="no-back-button";}
    	
    }
</script>
<body class="hold-transition sidebar-mini" onload="nobackbutton();">
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
            <h1>Solicitud Documental</h1>
            <h6>Gestione las solicitudes de actualización, eliminación y/o creación documental.</h6><br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Solicitud Documental</li>
            </ol>
          </div>
        </div>
        <div>
            <?php
            //si tiene permiso de insertar , se muestran los botones de agregar, importar y demas
            
                if($visibleI == FALSE){
            ?>
            <div class="row">
            <?php
            
            
                /// VALIDAMOS LA CODIFICACIÓN, QUE EXISTA TODOS LOS CAMPOS AGREGAMOS EXCEPTO VERSIÓN
                    $verificamosCodificacion=$mysqli->query("SELECT * FROM codificacion WHERe codificacion='Proceso' ");
                    $extraerVerificamosCodificacion=$verificamosCodificacion->fetch_array(MYSQLI_ASSOC);
                    
                    if($extraerVerificamosCodificacion['codificacion'] == 'Proceso'){
                        $proceso_activado='1';
                    }else{
                        $proceso_activado='0';
                    }
                    
                    $verificamosCodificacion=$mysqli->query("SELECT * FROM codificacion WHERe codificacion='Tipo de documento' ");
                    $extraerVerificamosCodificacion=$verificamosCodificacion->fetch_array(MYSQLI_ASSOC);
                    
                    if($extraerVerificamosCodificacion['codificacion'] == 'Tipo de documento'){
                        $tipo_documento_activado='1';
                    }else{
                        $tipo_documento_activado='0';
                    }
                    
                    $verificamosCodificacion=$mysqli->query("SELECT * FROM codificacion WHERe codificacion='Consecutivo' ");
                    $extraerVerificamosCodificacion=$verificamosCodificacion->fetch_array(MYSQLI_ASSOC);
                    
                    if($extraerVerificamosCodificacion['codificacion'] == 'Consecutivo'){
                        $consecutivo_activado='1';
                    }else{
                        $consecutivo_activado='0';
                    }
                /// END
              
                //// VALIDAMOS CUALES SON LOS DATOS FALTANTES EN LA CONFIGURACIÓN
                    if($proceso_activado == '0'){
                        $nombre_proceso='proceso<br>';
                    }
                    if($tipo_documento_activado == '0'){
                        $nombre_tipo_documento='tipo de documento<br>';
                    }
                    if($consecutivo_activado == '0'){
                        $nombre_consecutivo='consecutivo<br>';
                    }
                    
                    
                    $enviarMensajeAlerta=$nombre_proceso.''.$nombre_tipo_documento.''.$nombre_consecutivo;
                //// END
                
                
                if($proceso_activado == 1 && $tipo_documento_activado == 1 && $consecutivo_activado == 1){
                    if($root == 1){
                
                    }else{
            ?>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarSolicitud"><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>
            </div>
            <?php
                    }
                }else{
                ?>
                                    <div class="form-group col-md-12">
                                        <center>
                                            
                                                <div class="modal-dialog">
                                                <div class="modal-content bg-danger">
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Alerta</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <p>Defina la codificación, falta registrar los siguientes datos:<br> <?php echo $enviarMensajeAlerta; ?></p>
                                                    </div>
                                                <div class="modal-footer justify-content-between">
                                                </div>
                                                </div>
                                                </div>
                                        </center>
                                    </div>
                <?php
                }
            //}
            ?>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="solicitudDocumentosCerradas"><font color="white"><i class="fas fa-clipboard-check"></i> Solicitudes cerradas</font></a></button>
            </div>
            
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-warning btn-sm"><a href="exportacion/solicitudDocumentos"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
            </div>
            <?php
            
            
            if($root == 1){
            
            if($proceso_activado == 1 && $tipo_documento_activado == 1 && $consecutivo_activado == 1){
            ?>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="solicitudDocumentosAsignacion"><font color="white"><i class="fas fa-clipboard-check"></i> Asignaciones</font></a></button>
            </div>
            <?php
            }
            
            }else{
            ?>
            <div class="col-sm">
                
            </div>
            <?php
            }
            ?>
            <div class="col-sm">
                
            </div>

            <div class="col-sm">
                
            </div>
            <div class="col-sm">
                
            </div>
            </div>
            <?php }else{?> 
            <div class="row">
                <div class="col-sm">
                    <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/solicitudDocumentos'"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
                </div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
            </div>
            <?php }//si no, solo el de exportar?>
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
                
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>Fecha <?php  $cargo; ?></th>
                      <th>Quién Solicita</th>
                      <th>Tipo Solicitud</th>
                      <th>Documento</th>
                      <th>Encargado Aprobar</th>
                      <th>Estado</th>
                      <!--<th>Fecha de cierre</th>-->
                      <th>Tiempo de respuesta</th>
                      <th>Proceso</th>
                      <th>Tipo de documento</th>
                      <th>Tiempo restante para responder la solicitud</th>
                      <th>Ver más</th>
                      <th style="display:<?php echo$visibleE;?>;">Seguimiento</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $data = $mysqli->query("SELECT * FROM solicitudDocumentos ")or die(mysqli_error()); //WHERE estado = 'Aprobado' OR estado IS NULL
                     
                     while($row = $data->fetch_assoc()){
                         
                         
                         if($row['estado'] == 'Aprobado' || $row['estado'] == NULL || $row['estado'] == 'documento'){
                             
                         }else{
                             continue;
                         }
                         
                         
                         
                        $quienSolicita = $row['quienSolicita'];
                        $encargadoAprobar = $row['encargadoAprobar'];
                       
                            if($row['cambioCargo'] == $cargo){ 
                                
                                //echo 'Asignado: '.$row['asignacion'];
                                //echo '<br>id cargo asignado: '.$row['cambioCargo'];
                                
                            }elseif($row['asignacion'] == $idparaChat){
                                    
                            }else{
                                if($quienSolicita != $celdulaUser){ 
                                        if($encargadoAprobar != $cargo){ //$cargoID
                                            continue;
                                        }
                                }
                            }
                        
                            if($row['cambioCargo'] != NULL){ /// identificamos que exista un cambio, si existe un cambio, se lo omite al solicitante anterior y solo le muestra al nuevo encargado
                                if($row['cambioCargo'] == $cargo){
                                    
                                }else{
                                    continue;
                                }
                            }
                        
                        
                        
                        $fechainicial = $row['fecha'];
                        $fechaactual = date("Y-m-d");
                        
                        $tiempoRespuesta =$row['tiempoRespuesta'];
                        
                        $fechaRestar = date("Y-m-d",strtotime($fechainicial."+ ".$tiempoRespuesta." days")); 
                        
                        $datetime1 = date_create($fechaRestar);
                        $datetime2 = date_create($fechaactual);
                        $contador = date_diff($datetime1, $datetime2);
                        $differenceFormat = '%a';
                        
                        
                        
                        
                     echo"<tr>";
                     echo" <td style='text-align: justify;'>".$row['fecha']."</td>";
                     $solicitudID = $row['id'];
                     $usuarioName= $row['quienSolicita'];
                     $nombreUsuario = $mysqli->query("SELECT * FROM usuario WHERE cedula ='$usuarioName'")or die(mysqli_error());
                     $col = $nombreUsuario->fetch_array(MYSQLI_ASSOC);
                     $nombre = $col['nombres'];
                     $nombre2 = $col['apellidos'];
                     echo" <td style='text-align: justify;'>".$nombre.' '.$nombre2."</td>";
                     $row['tipoSolicitud'];
                     if($row['tipoSolicitud'] == 1){
                        echo" <td style='text-align: justify;'>CREAR</td>";
                     }elseif($row['tipoSolicitud'] == 2){
                        echo" <td style='text-align: justify;'>ACTUALIZAR</td>"; 
                     }else{
                        echo" <td style='text-align: justify;'>ELIMINAR</td>"; 
                     }
                     if($row['tipoSolicitud'] != 1){
                        $idMelo = $row['nombreDocumento'];
                        $querymela = $mysqli->query("SELECT * FROM documento WHERE id = '$idMelo'");
                        $colMela = $querymela->fetch_array(MYSQLI_ASSOC);
                        $nombreMelo = $colMela['nombres'];
                        echo" <td style='text-align: justify;'>".$nombreMelo."</td>";
                     }else{
                     echo" <td style='text-align: justify;'>".$row['nombreDocumento']."</td>";
                     }
                     $encargadoA = $row['encargadoAprobar'];
                     $nombreEncargado = $mysqli->query("SELECT * FROM cargos WHERE id_cargos ='$encargadoA'")or die(mysqli_error());
                     $col2 = $nombreEncargado->fetch_array(MYSQLI_ASSOC);
                     $nombreE = $col2['nombreCargos'];
                     
                     if($encargadoA == 0){
                      echo" <td style='text-align: justify;'>".$row['nombreEncargado']."</td>";
                     }else{
                        
                        if($root == 1){
                            echo" <td style='text-align: justify;'>".$nombreE."</td>"; 
                        }else{
                            if($row['cambioCargo'] == $cargo){
                                echo" <td style='text-align: justify;color:black;'>".$nombreE."<br>(Solicitud transferida)</td>";
                            }elseif($row['asignacion'] == $idparaChat){
                                echo" <td style='text-align: justify;color:black;'>".$nombreE."<br>(Solicitud asignada)</td>";
                            }else{
                                echo" <td style='text-align: justify;'>".$nombreE."</td>";
                            }
                        }
                     
                         
                     }
                     
                     echo" <td style='text-align: justify;'>".$row['estado']."</td>";
                    // echo" <td style='text-align: justify;'>".$row['fechaCierre']."</td>";
                     echo" <td style='text-align: center;'>".$tiempoRespuesta."</td>";
                     $proceso = $row['proceso'];
                     $nombreProceso = $mysqli->query("SELECT * FROM procesos WHERE id ='$proceso'")or die(mysqli_error());
                     $col3 = $nombreProceso->fetch_array(MYSQLI_ASSOC);
                     $nombreP = $col3['nombre'];
                     
                     if($nombreP != NULL){
                         echo" <td style='text-align: justify;'>".$nombreP."</td>";
                     }else{
                         echo" <td style='text-align: justify;'>nombre G</td>";
                     }
                     
                     $nombreTipoDocumento = $mysqli->query("SELECT * FROM tipoDocumento WHERE id ='".$row['tipoDocumento']."'")or die(mysqli_error());
                     $col3TipoDcumento = $nombreTipoDocumento->fetch_array(MYSQLI_ASSOC);
                     $nombreTipoDOcumentoN=$col3TipoDcumento['nombre'];
                     
                     if($nombreTipoDOcumentoN != NULL){
                        echo" <td style='text-align: justify;'>".$nombreTipoDOcumentoN."</td>";
                     }else{
                        echo" <td style='text-align: justify;'>".$row['tpdG']."</td>";
                     }
                     
                     if($tiempoRespuesta == NULL){
                         echo" <td style='text-align: center;'><b>Sin definir</b></td>";
                     }else{
                         echo" <td style='text-align: center;'>";
                          //echo $fechaRestar;
                          //echo '<br>';
                          //echo $fechaactual;
                          
                          if($fechaRestar > $fechaactual){
                              //echo 'se pasa de la fecha';
                              echo $contador->format($differenceFormat);
                          }else{
                              //echo 'dentro de la fecha';
                              echo '-'.$contador->format($differenceFormat);
                          }
                         
                         echo "</td>";
                     }
                     
                     echo"<form action='solicitudDocumentosVerMas' method='post'>";
                     echo"<input type='hidden' name='id' value='$solicitudID'>";
                     echo"<td><button type='submit' class='btn btn-block btn-info btn-sm'><i class='fas fa-eye'></i> Ver Más</button></td>";
                     echo"</form>";
                     
                     if($row['estado'] == 'documento'){
                     echo"<form action='agregarSolicitud' method='post'>";
                     echo "<input name='retorno' value='1' type='hidden'>";
                     echo"<input type='hidden' name='idRetorno' value='$solicitudID'>";
                     echo"<input type='hidden' name='tipoSolicitud' value='".$row['tipoSolicitud']."'>";
                     echo"<td><button style='display:$visibleE;' type='submit' class='btn btn-block btn-warning btn-sm'><i class='fas fa-eye'></i> Proceso</button></td>";   
                     }else{
                     echo"<form action='solicitudDocumentosSeguimiento' method='post'>";
                     echo"<input type='hidden' name='id' value='$solicitudID'>";
                     echo"<input type='hidden' name='tipoSolicitud' value='".$row['tipoSolicitud']."'>";
                     echo"<td><button style='display:$visibleE;' type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-eye'></i> Seguimiento</button></td>";
                     echo"</form>";
                     }
                    echo"</tr>";
                    }
                    ?> 
                   
                  </tbody>
                </table>
              </div>
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

<!-- archivos para el filtro de busqueda y lista de información -->
  
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>
<!-- END -->
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
    }if($_POST['validacionAgregarRechazado'] == 1){
    ?>
        Toast.fire({
            type: 'error',
            title: 'solicitud rechazada.'
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