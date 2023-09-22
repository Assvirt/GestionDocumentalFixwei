<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'presupuesto'; //Se cambia el nombre del formulario
require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
    <title>Presupuesto</title>
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
            <h1>Presupuesto</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Presupuesto</li>
            </ol>
          </div>
        </div>
        <div>
            <?php
                if($visibleI == FALSE){
            ?>
            <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarPresupuesto"><font color="white"><i class="fas fa-plus-square"></i> Nuevo presupuesto</font></a></button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/presupuesto'"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
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
            <?php }else{?>
            <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/presupuesto'"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
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

            <?php }?>
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
               
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>N°</th>
                      <th>Nombre del presupuesto</th>
                      <th>Total presupuesto</th>
                      <th>Total ejecutado</th>
                      <th>Disponible</th>
                      <th>Responsable</th>
                      <th>Periodo</th>
                      <th>Ver más</th>
                      <th style="display:<?php echo $visibleE;?>;">Editar</th>
                      <th style="display:<?php echo$visibleD;?>;">Eliminar</th>
                      <!--<th>Gestionar</th>-->
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                    
                         $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $data = $mysqli->query("SELECT * FROM presupuesto ORDER BY nombre ASC")or die(mysqli_error());
                    
                     $conteo=1;
                     while($row = $data->fetch_assoc()){
                        $id = $row['id'];
                                echo"<tr>";
                                echo"<td>".$conteo++."</td>";
                                echo "<td>".$row['nombre']."</td>";
                                $totalPresupuesto=$row['totalPresupuesto'];
                                echo "<td> $ ".number_format($totalPresupuesto,0,'.',',') ."</td>";
                                
                                
                                $totalEjecutado=$row['totalEjecutado'];
                                
                                echo '<td>';
                                //// obtenemos el id del responsable
                                //echo '<b>Id responsable: </b>'.$row['responsable'];
                                //echo '<br>';
                               
                                $consultaSolicitudCompra=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idUsuario='".$row['responsable']."' AND rol='1' ");
                                $contadorTotal='0';
                                while($extraerCentroCostoSolicituCompra=$consultaSolicitudCompra->fetch_array()){
                                    
                                    /// validamos solo los que están aprobados
                                    $aprobadosTotales=$mysqli->query("SELECT * FROM solicitudComprador WHERE idSolicitud='".$extraerCentroCostoSolicituCompra['idSolicitud']."' AND estado='ejecutado' ");
                                    $validamosEjecutados=$aprobadosTotales->fetch_array(MYSQLI_ASSOC);
                                    if($validamosEjecutados['idSolicitud'] == $extraerCentroCostoSolicituCompra['idSolicitud']){
                                        
                                    }else{
                                        continue;
                                    }
                                    // ENd
                                    
                                    
                                     '<b>*Porcentaje para aplicar :</b> '. $extraerCentroCostoSolicituCompra['porcentaje'].'%';
                                    $variableCentroCostoId=$extraerCentroCostoSolicituCompra['porcentaje'];
                                     '<br>';
                                    $solicitudFinalizada=$mysqli->query("SELECT * FROM solicitudComprador WHERE idSolicitud='".$extraerCentroCostoSolicituCompra['idSolicitud']."' ");
                                    $extraerSolicituFinal=$solicitudFinalizada->fetch_array(MYSQLI_ASSOC);
                                    
                                    if($variableCentroCostoId == '100'){  /// cuanto es el 100 % se trae el totl directamente
                                    
                                      'Total: '.'$ '.$extraerSolicituFinal['total'];
                                     $presupuesto=$extraerSolicituFinal['total'];
                                     
                                    }else{ // cuando no e sel 100 % se debe calcular
                                      '$ '.$presupuesto=$extraerSolicituFinal['total'];
                                      '<br><b>Se debe aplicar este % $'.number_format($presupuesto*($extraerCentroCostoSolicituCompra['porcentaje']/100));
                                     $presupuesto=$presupuesto*($extraerCentroCostoSolicituCompra['porcentaje']/100);
                                    }
                                    
                                    $contadorTotal+=$presupuesto;
                                     '<br><br>';
                                }
                                
                                echo '$'.number_format($contadorTotal);
                    echo '</td>';
                    
                    $calculandoDisponible=ABS($contadorTotal-$totalPresupuesto);
                    echo "<td> $ ". number_format($calculandoDisponible,0,'.',',')."</td>";
                    
                    
                    
                    
                    
                            $tipoResponsable=$row['tipoResponsable'];
                            //$personalID =  json_decode($row['responsable']);
                            //$longitud = count($personalID);
                            //if($tipoResponsable == 'usuario'){
                                    echo"<td>";
                                    //for($i=0; $i<$longitud; $i++){
                                        
                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '".$row['responsable']."' "); //'$personalID[$i]'
                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                        $cedulaUsuario=$columna['cedula'];
                                        
                                        $conultaCentroCostos = $mysqli->query("SELECT * FROM centroCostos WHERE persona = '".$columna['id']."'"  );
                                        $DataCostos = $conultaCentroCostos->fetch_array(MYSQLI_ASSOC);
                                        
                                        echo $DataCostos['codigo'].'-'.$DataCostos['nombre'];
                                        echo '<br>';
                                        echo '<br>'.$columna['nombres']." ".$columna['apellidos'];
                                    //} 
                                    echo"</td>";
                                 
                                /*}else{
                                    echo"<td>";
                                    for($i=0; $i<$longitud; $i++){
                                    $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$personalID[$i]'");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    echo $carga = $columna['nombreCargos']; echo "<br>";
                                    } "</td>";
                                }*/
                    
                    echo" <td>".$row['periodo']."</td>";
            	    echo"<form action='presupuestoVer' method='POST'>";
                    echo"<input type='hidden' name='idPresupuesto' value= '$id' >";
                    echo"<td><button type='submit' class='btn btn-block btn-primary btn-sm'><i class='fas fa-eye'></i> Ver más</button></td>";
                    echo"</form>";
                    
                    /////// validacion por usuario para botones de editar y eliminar
                        if($tipoResponsable == 'usuario'){
                                      
                                        //for($i=0; $i<$longitud; $i++){ //// inicia for
                                            
                                            $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '".$row['responsable']."' AND cedula='$cc' ");
                                            while($columna = $nombreuser->fetch_assoc()){
                                                 $cedulaUsuario=$columna['cedula']; echo "<br>";
                                            }
                                        //}  /////// cierre del for
                                        
                        if($cc == $cedulaUsuario){ 
                        echo"<form action='editarPresupuesto' method='POST'>";
                        echo"<input type='hidden' name='id' value= '$id' >";
                        echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                        echo"</form>";
                        /*
                        echo"<form action='controlador/presupuesto/controllerPresupuesto' method='POST'>";
                        echo"<input type='hidden' name='idPresupuesto' value= '$id' >";
                        echo" <td style='display:$visibleD;'><button onclick='return ConfirmDelete()' type='submit' name='Eliminar' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                        echo"</form>";
                        */
                        /// validación de script y funcion de eliminacion
                            ?>
                            <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $id;?>' >
                            <td style='display:<?php echo$visibleD;?>'><a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                            <script>
                                function funcionFormula<?php echo $contador2++;?>() {
                                    /*alert("entre");*/
                                  document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                                }
                           </script>
                            <?php
                            /// END
                        }else{ 
                            
                        
                        echo"<input type='hidden' name='idPresupuesto'  >";
                        echo" <td style='display:$visibleE;'><button type='butotn' disabled class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                       
                       
                        echo"<input type='hidden' name='idPresupuesto'  >";
                        echo" <td style='display:$visibleD;'><button type='butotn' disabled name='Eliminar' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                       
                            
                        }             
                    /////////// finaliza el botón para el usuario editar y eliminar 
                   
                   //////////// validacion por cargo del boton de editar y eliminar
                                }else{} //////// finaliza el  validaciones con los botones
                    
                    
                    /*
                    echo"<form action='presupuestoGestionar' method='POST'>";
                    echo"<input type='hidden' name='idPresupuesto' value= '$id' >";
                    echo"<input type='hidden' name='tipo' value= '$tipoResponsable' >";
                    echo"<input type='hidden' name='cedula' value= '$cedulaUsuario' >";
                    echo"<input type='hidden' name='cargo' value= '$carga' >";
                    echo" <td style='display:;'><button  type='submit'  class='btn btn-block btn-warning btn-sm'><i class='fas fa-clipboard'></i>Gestionar</button></td>";
                    echo"</form>";
                    
                     */
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
                            <form action='controlador/presupuesto/controllerPresupuesto' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormula" name='idPresupuesto' readonly>
                              <button type="submit" name='Eliminar' class="btn btn-outline-light">Si</button>
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

<!-- archivos para el filtro de busqueda y lista de información -->

    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>
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

//// validaciones de importación
$validacionAgregarA=$_POST['validacionAgregarA'];
$validacionExisteImportacionAA=$_POST['validacionExisteImportacionAA'];
$validacionExisteImportacionA=$_POST['validacionExisteImportacionA'];
$validacionExisteImportacionB=$_POST['validacionExisteImportacionB'];
$validacionExisteImportacionC=$_POST['validacionExisteImportacionC'];
$validacionExisteImportacionD=$_POST['validacionExisteImportacionD'];
$validacionExisteImportacionE=$_POST['validacionExisteImportacionE'];
$validacionExisteImportacionVacio=$_POST['validacionExisteImportacionVacio'];
//// END
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
    if($validacionAgregarA == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: 'Registro agregado.'
        })
    <?php
    } 
    if($validacionExisteImportacionVacio == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos campos están vacios.'
        })
    <?php
    }
    if($validacionExisteImportacionAA == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Está intentando subir un archivo diferente.'
        })
    <?php
    }
    if($validacionExisteImportacionA == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos cargos están repetidos en el documento.'
        })
    <?php
    }
    if($validacionExisteImportacionB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos cargos están repetidos.'
        })
    <?php
    }
    if($validacionExisteImportacionC == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos de los jefes inmediato están repetidos o no existen.'
        })
    <?php
    }
    
    if($validacionExisteImportacionD == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos de los niveles están repetidos o no existen.'
        })
    <?php
    }
    if($validacionExisteImportacionE == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos elementos no existen o están repetidos.'
        })
    <?php
    }
    
    if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El nombre ya existe.'
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
    <script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
<!-- END -->
</body>
</html>
<?php
}
?>