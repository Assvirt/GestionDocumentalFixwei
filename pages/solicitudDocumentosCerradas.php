<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
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
            <h1>Solicitudes Documentales Cerradas</h1>
            <h6>Gestione las solicitudes de actualización, eliminación y/o creación documental.</h6><br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Solicitudes Documentales Cerradas</li>
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
            if($root == 1){
                
            }else{
                /// validamos que exista una codificación para poder realizar una solicitud
                $verificamosCodificacion=$mysqli->query("SELECT * FROM codificacion ");
                $extraerVerificamosCodificacion=$verificamosCodificacion->fetch_array(MYSQLI_ASSOC);
                if($extraerVerificamosCodificacion['id'] != NULL){
            ?>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarSolicitud"><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>
            </div>
            <?php
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
                                                    <p>Defina la codificación.</p>
                                                    </div>
                                                <div class="modal-footer justify-content-between">
                                                </div>
                                                </div>
                                                </div>
                                        </center>
                                    </div>
                <?php
                }
            }
            ?>
              <!--  <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarSolicitud"><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>-->
           
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="solicitudDocumentos"><font color="white"><i class="fas fa-list "></i> Listar solicitudes</font></a></button>
            </div>
            
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-warning btn-sm"><a href="exportacion/solicitudDocumentosCerradas"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
            </div>    
            <div class="col-sm"></div>
            
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
                    <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/solicitudDocumentosCerradas'"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
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
                 <?   ?>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 800px;">
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>Fecha</th>
                      <th>Quién Solicita</th>
                      <th>Tipo Solicitud</th>
                      <th>Documento</th>
                      <th>Encargado Aprobar</th>
                      <th>Estado</th>
                      <th>Fecha de cierre</th>
                      <th>Tiempo de respuesta</th>
                      <th>Proceso</th>
                      <th>Tipo de documento</th>
                      <th>Tiempo restante para responder la solicitud</th>
                      <th>Ver más</th>
                      <th>Seguimiento</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     $consultaBuscar=$_POST['buscar'];
                     $consultaBuscar2=$_POST['buscar2'];
                     $consultaBuscar3=$_POST['buscar3'];
                     $consultaBuscar4=$_POST['buscar4'];
                     
                     if($consultaBuscar != NULL || $consultaBuscar2 != NULL || $consultaBuscar3 != NULL || $consultaBuscar4 != NULL){
                         
                         if($consultaBuscar != NULL){
                         ///// se trae la consulta de la 3
                         $acentos = $mysqli->query("SET NAMES 'utf8'");
                         $queryConsultaUsuario=$mysqli->query("SELECT * FROM usuario WHERE nombres LIKE  '%$consultaBuscar%' ");
    	                 $rowConsulta=$queryConsultaUsuario->fetch_array(MYSQLI_ASSOC);
    	                 $nombreUsuario=$rowConsulta['cedula'];
    	                 ///////// fin
                         }
                         
                         if($consultaBuscar2 != NULL){
                         ///// se trae la consulta de la 3
                            if($consultaBuscar2 == 'CREAR'){
                                $tipoDocumentoEs='1';
                            }elseif($consultaBuscar2 == 'ACTUALIZAR'){
                                $tipoDocumentoEs='2';
                            }elseif($consultaBuscar2 == 'ELIMINAR'){
                                $tipoDocumentoEs='3';
                            }
                         ///////// fin
                         }
                         
                         if($consultaBuscar3 != NULL){
                         ///// se trae la consulta de la 3
                         $queryJefeInmediatoConsulta=$mysqli->query("SELECT * FROM cargos WHERE nombreCargos LIKE  '%$consultaBuscar3%' ");
    	                 $rowConsulta=$queryJefeInmediatoConsulta->fetch_array(MYSQLI_ASSOC);
    	                 $nombreJefeInmediato=$rowConsulta['id_cargos'];
    	                 ///////// fin
                         }
                        $acentos = $mysqli->query("SET NAMES 'utf8'"); 
                        $data = $mysqli->query("SELECT * FROM solicitudDocumentos WHERE quienSolicita LIKE '%$nombreUsuario%' AND tipoSolicitud LIKE '%$tipoDocumentoEs%'
                        AND   encargadoAprobar LIKE '%$nombreJefeInmediato%' AND estado='Ejecutado' ")or die(mysqli_error());
                     }else{
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $data = $mysqli->query("SELECT * FROM solicitudDocumentos WHERE estado ='Ejecutado' OR estado = 'Rechazado'")or die(mysqli_error());
                     }
                     while($row = $data->fetch_assoc()){
                        
                        $quienSolicita = $row['quienSolicita'];
                        $encargadoAprobar = $row['encargadoAprobar'];
                        
                        if($quienSolicita != $celdulaUser){
                            if($encargadoAprobar != $cargoID ){
                                continue;
                            }
                        }
                        
                        
                        $fechainicial = $row['fecha'];
                        $fechaactual = date("Y-m-d");
                        
                        $fechainicial2 = strtotime($row['fecha']);
                        $fechacierre = strtotime($row['fechaCierre']);
                        
                        $datediff = $fechacierre - $fechainicial2 ;
                        
                        $tiempoeElaboracion = round($datediff / (60 * 60 * 24));
                        
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
                        $nombreMelo = $row['nombreDocumento2'];
                        
                        echo" <td style='text-align: justify;'>".$nombreMelo."</td>";
                     }else{
                     echo" <td style='text-align: justify;'>".$row['nombreDocumento2']."</td>";
                     }
                     $encargadoA = $row['encargadoAprobar'];
                     $nombreEncargado = $mysqli->query("SELECT * FROM cargos WHERE id_cargos ='$encargadoA'")or die(mysqli_error());
                     $col2 = $nombreEncargado->fetch_array(MYSQLI_ASSOC);
                     $nombreE = $col2['nombreCargos'];
                     echo" <td style='text-align: justify;'>".$nombreE."</td>";
                     echo" <td style='text-align: justify;'><font color='#35840E'>".$row['estado']."</font></td>";
                     echo" <td style='text-align: justify;'>".$row['fechaCierre']."</td>";
                     
                     if($tiempoRespuesta < $tiempoeElaboracion){
                        echo" <td style='text-align: justify;'><font color='red'>".$tiempoeElaboracion."</font></td>"; 
                     }else{
                        echo" <td style='text-align: justify;'><font color='green'>".$tiempoeElaboracion."</font></td>"; 
                     }
                     
                     
                     
                     $proceso = $row['proceso'];
                     $nombreProceso = $mysqli->query("SELECT * FROM procesos WHERE id ='$proceso'")or die(mysqli_error());
                     $col3 = $nombreProceso->fetch_array(MYSQLI_ASSOC);
                     $nombreP = $col3['nombre'];
                     echo" <td style='text-align: justify;'>".$nombreP."</td>";
                     
                     $nombreTipoDocumento = $mysqli->query("SELECT * FROM tipoDocumento WHERE id ='".$row['tipoDocumento']."'")or die(mysqli_error());
                     $col3TipoDcumento = $nombreTipoDocumento->fetch_array(MYSQLI_ASSOC);
                     $nombreTipoDOcumentoN=$col3TipoDcumento['nombre'];
                     
                     if($nombreTipoDOcumentoN != NULL){
                        echo" <td style='text-align: justify;'>".$nombreTipoDOcumentoN."</td>";
                     }else{
                        echo" <td style='text-align: justify;'>".$row['tpdG']."</td>";
                     }
                     
                     
                     if($tiempoRespuesta == NULL){
                         echo" <td style='text-align: justify;'><b>Sin definir</b></td>";
                     }else{
                         echo" <td style='text-align: justify;'>".$contador->format($differenceFormat)."</td>";
                     }
                     
                     echo"<form action='solicitudDocumentosVerMas' method='post'>";
                     echo"<input type='hidden' name='cerrado' value='1'>";
                     echo"<input type='hidden' name='id' value='$solicitudID'>";
                     echo"<td><button type='submit' class='btn btn-block btn-info btn-sm'><i class='fas fa-eye'></i>Ver Más</button></td>";
                     echo"</form>";
                     echo"<form action='solicitudDocumentosSeguimiento' method='post'>";
                     echo"<input type='hidden' name='cerrado' value='1'>";
                     echo"<input type='hidden' name='id' value='$solicitudID'>";
                     echo"<input type='hidden' name='tipoSolicitud' value='".$row['tipoSolicitud']."'>";
                     echo"<td><button type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-eye'></i>Seguimiento</button></td>";
                     echo"</form>";
                     
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


    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>
    <script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
<!-- END -->
</body>
</html>
<?php
}
?>