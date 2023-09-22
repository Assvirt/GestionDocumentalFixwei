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
<form action="solicitudDocumentosAsignacionNotificacion" method="post">
    
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Asignación solicitud Documental</h1>
            <h6>Asigne las solicitudes de actualización, eliminación y/o creación documental a un nuevo usuario.</h6><br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Asignación solicitud Documental</li>
            </ol>
          </div>
        </div>
        <div>
          
            <div class="row">
           
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="solicitudDocumentos"><font color="white"><i class="fas fa-list "></i> Listar solicitudes</font></a></button>
            </div>
            
            
            
            <div class="col-sm">
                
            </div>

            <div class="col-sm">
                
            </div>
            <div class="col-sm">
                
            </div>
            </div>
           
        </div>
        <div>
        <br><br>
        
            <div class="col-sm">
                <table>
                    <tbody>
                        <tr>
                            <th>
                                <select name="consultaUsario" class="form-control" onchange = "this.form.submit()" required>
                                    
                                    <?php
                                    if($_POST['consultaUsario'] != NULL){
                                        $recorridousuariosA=$mysqli->query("SELECT * FROM usuario WHERE id='".$_POST['consultaUsario']."' ORDER BY nombres ");
                                        while($extraerRecorridousuariosA=$recorridousuariosA->fetch_array()){
                                            
                                            
                                            /// pregunta el cargo
                                            $pregunta_cargo=$mysqli->query("SELECT id_cargos,nombreCargos FROM cargos WHERe id_cargos='".$extraerRecorridousuariosA['cargo']."' ");
                                            $esxtraer_pregunta_cargo=$pregunta_cargo->fetch_array(MYSQLI_ASSOC);
                                            
                                        ?>
                                        <option value="<?php echo $extraerRecorridousuariosA['id'];?>"><?php echo $esxtraer_pregunta_cargo['nombreCargos'].', '.$extraerRecorridousuariosA['nombres'].' '.$extraerRecorridousuariosA['apellidos'];?></option>
                                        <?php
                                        }
                                        $recorridousuariosA=$mysqli->query("SELECT * FROM usuario WHERE not id='".$_POST['consultaUsario']."' ORDER BY nombres ");
                                        while($extraerRecorridousuariosA=$recorridousuariosA->fetch_array()){
                                            
                                             /// pregunta el cargo
                                            $pregunta_cargo=$mysqli->query("SELECT id_cargos,nombreCargos FROM cargos WHERe id_cargos='".$extraerRecorridousuariosA['cargo']."' ");
                                            $esxtraer_pregunta_cargo=$pregunta_cargo->fetch_array(MYSQLI_ASSOC);
                                        ?>
                                        <option value="<?php echo $extraerRecorridousuariosA['id'];?>"><?php echo $esxtraer_pregunta_cargo['nombreCargos'].', '.$extraerRecorridousuariosA['nombres'].' '.$extraerRecorridousuariosA['apellidos'];?></option>
                                        <?php
                                        }
                                    }else{
                                        ?>
                                        <option value="">Seleccionar...</option>
                                        <?php
                                        $recorridousuariosA=$mysqli->query("SELECT * FROM usuario ORDER BY nombres "); 
                                        while($extraerRecorridousuariosA=$recorridousuariosA->fetch_array()){
                                            
                                            /// pregunta el cargo
                                            $pregunta_cargo=$mysqli->query("SELECT id_cargos,nombreCargos FROM cargos WHERe id_cargos='".$extraerRecorridousuariosA['cargo']."' ");
                                            $esxtraer_pregunta_cargo=$pregunta_cargo->fetch_array(MYSQLI_ASSOC);
                                        ?>
                                        <option value="<?php echo $extraerRecorridousuariosA['id'];?>"><?php echo $esxtraer_pregunta_cargo['nombreCargos'].', '.$extraerRecorridousuariosA['nombres'].' '.$extraerRecorridousuariosA['apellidos'];?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </th>
                            <th>
                            Transferir actividades ha:
                            </th>
                            
                            <th>
                                <?php
                                if($_POST['consultaUsario'] != NULL){
                                ?>
                                <select name="transferir" class="form-control" >
                                    <?php
                                    if($_POST['transferir'] != NULL){
                                        $recorridousuariosA=$mysqli->query("SELECT * FROM usuario WHERE id='".$_POST['transferir']."' ORDER BY nombres ");
                                        while($extraerRecorridousuariosA=$recorridousuariosA->fetch_array()){
                                            /// pregunta el cargo
                                            $pregunta_cargo=$mysqli->query("SELECT id_cargos,nombreCargos FROM cargos WHERe id_cargos='".$extraerRecorridousuariosA['cargo']."' ");
                                            $esxtraer_pregunta_cargo=$pregunta_cargo->fetch_array(MYSQLI_ASSOC);
                                        ?>
                                        <option value="<?php echo $extraerRecorridousuariosA['id'];?>"><?php echo $esxtraer_pregunta_cargo['nombreCargos'].', '.$extraerRecorridousuariosA['nombres'].' '.$extraerRecorridousuariosA['apellidos'];?></option>
                                        <?php
                                        }
                                        $recorridousuariosA=$mysqli->query("SELECT * FROM usuario WHERE not id='".$_POST['transferir']."' ORDER BY nombres ");
                                        while($extraerRecorridousuariosA=$recorridousuariosA->fetch_array()){
                                            /// pregunta el cargo
                                            $pregunta_cargo=$mysqli->query("SELECT id_cargos,nombreCargos FROM cargos WHERe id_cargos='".$extraerRecorridousuariosA['cargo']."' ");
                                            $esxtraer_pregunta_cargo=$pregunta_cargo->fetch_array(MYSQLI_ASSOC);
                                        ?>
                                        <option value="<?php echo $extraerRecorridousuariosA['id'];?>"><?php echo $esxtraer_pregunta_cargo['nombreCargos'].', '.$extraerRecorridousuariosA['nombres'].' '.$extraerRecorridousuariosA['apellidos'];?></option>
                                        <?php
                                        }
                                    }else{
                                        ?>
                                        <option value="">Seleccionar...</option>
                                        <?php
                                        $recorridousuariosA=$mysqli->query("SELECT * FROM usuario ORDER BY nombres "); 
                                        while($extraerRecorridousuariosA=$recorridousuariosA->fetch_array()){
                                            /// pregunta el cargo
                                            $pregunta_cargo=$mysqli->query("SELECT id_cargos,nombreCargos FROM cargos WHERe id_cargos='".$extraerRecorridousuariosA['cargo']."' ");
                                            $esxtraer_pregunta_cargo=$pregunta_cargo->fetch_array(MYSQLI_ASSOC);
                                        ?>
                                        <option value="<?php echo $extraerRecorridousuariosA['id'];?>"><?php echo $esxtraer_pregunta_cargo['nombreCargos'].', '.$extraerRecorridousuariosA['nombres'].' '.$extraerRecorridousuariosA['apellidos'];?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <?php
                                }
                                ?>
                            </th>
                            <th>
                                <?php
                                if($_POST['consultaUsario'] != NULL){
                                ?>
                                <button type="submit" name="asignacionEntrante" class="btn btn-block btn-info btn-sm"><font color="white"> Asignar</font></button>
                                <?php
                                }
                                ?>
                            </th>
                        </tr>
                    </tbody>
                </table>
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
                
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>Seleccionar</th>
                      <th>Fecha</th>
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
                      <th>Estado</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                        
                    ///sacamos el cargo del usuario   
                    if($_POST['consultaUsario'] != NULL){
                        $consultamosUsuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$_POST['consultaUsario']."' ");
                        $sacamosCargo=$consultamosUsuario->fetch_array(MYSQLI_ASSOC);
                        
                     'Cargo: '.$sacamosCargo['cargo']; 
                     ' - Consulta usuario: '.$sacamosCargo['cedula'];   
                    //quienSolicita='".$sacamosCargo['cedula']."' OR asignacion='".$_POST['consultaUsario']."'
                    $data = $mysqli->query("SELECT * FROM solicitudDocumentos WHERE  encargadoAprobar='".$sacamosCargo['cargo']."' ")or die(mysqli_error()); //WHERE estado = 'Aprobado' OR estado IS NULL
                    while($row = $data->fetch_assoc()){
                        ///encargadoAprobar='".$sacamosCargo['cargo']."' OR asignacion='".$_POST['consultaUsario']."'
                         
                         
                         if($row['estado'] == 'Aprobado' || $row['estado'] == NULL || $row['estado'] == 'documento'){
                             
                         }else{
                             continue;
                         }
                         
                         
                         
                        $quienSolicita = $row['quienSolicita'];
                        'Encargado lista: '.$encargadoAprobar = $row['encargadoAprobar'];
                        ' - Encargado usuario: '.$sacamosCargo['cargo'];
                        
                        /*    
                            if($_POST['consultaUsario'] == $row['asignacion']){
                               
                            }else{
                                if($quienSolicita != $celdulaUser){ 
                                        if($encargadoAprobar != $sacamosCargo['cargo']){ //$cargoID
                                            continue;
                                        }
                                }
                            }
                        */
                        
                        
                        
                        $fechainicial = $row['fecha'];
                        $fechaactual = date("Y-m-d");
                        
                        $tiempoRespuesta =$row['tiempoRespuesta'];
                        
                        $fechaRestar = date("Y-m-d",strtotime($fechainicial."+ ".$tiempoRespuesta." days")); 
                        
                        $datetime1 = date_create($fechaRestar);
                        $datetime2 = date_create($fechaactual);
                        $contador = date_diff($datetime1, $datetime2);
                        $differenceFormat = '%a';
                        
                        
                        
                        
                     echo"<tr>";
                     
                     //// envio de variables
                    
                     echo "<td>";
                     echo "<input name='seleccionar[]' value='".$row['id']."' type='checkbox' >";
                     echo "</td>";
                     /// end
                     
                     
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
                       
                        echo" <td style='text-align: justify;'>".$nombreE."</td>";
                       
                     
                         
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
                     
                   
                    echo '<td>';
                    
                        if(isset($_POST['asignacionEntrante'])){
                            echo 'Transferido con éxito';
                        }else{
                            if( $row['asignacion'] != NULL){
                                echo 'Documento transferido';
                            }else{
                                echo 'Sin asignar';
                            }
                        }
                                
                    echo '</td>';
                    
                    
                    echo"</tr>";
                    }
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
    
    
    
</form>
    
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
    if($_POST['validacion_select_ok'] == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: 'Transferencia exitosa.'
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
    
    if($_POST['validacion_select'] == 1){
    ?>
         Toast.fire({
             type: 'warning',
             title: 'Para transferir debe seleccionar la solicitud'
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