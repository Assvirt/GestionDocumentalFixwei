<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'ordenCom'; //Se cambia el nombre del formulario solicitudComprador
require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
    <title>Registrar Valores</title>
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
                $idOrdenCompra=$_POST['idOrdenCompra'];
                $consultaSolicitud=$mysqli->query("SELECT * FROM solicitudCompra WHERE id='$idOrdenCompra' ");
                $extraerCnsultaSolicitud=$consultaSolicitud->fetch_array(MYSQLI_ASSOC);
                $estadoGeneral=$extraerCnsultaSolicitud['estado'];
                 $validarComprador=$extraerCnsultaSolicitud['modificacion'];
                ?>
            <h1>Asignacion de costos para la Solicitud N°<?php echo $extraerCnsultaSolicitud['id'];?></h1>
            
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
            <?php
                }
            ?>
            
            <div class="col-sm"><!-- Vista PPAL -->
            <?php
                $acentos = $mysqli->query("SET NAMES 'utf8'");
                $data = $mysqli->query("SELECT * FROM solicitudCompra ORDER BY id ASC")or die(mysqli_error());
                $idCompra = $row['id'];
                echo"<form action='registroProductos' method='POST'>";
                echo"<input type='hidden' name='' value= '$id' >";
                echo"</form>";
                
               
            ?>
            <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
             <button type="button" onclick="window.location.href='ordenCompraMasiva'" class="btn btn-block btn-info btn-sm"><font color="white"><i class="fas fa-list"></i> Listar masivo</font></button>
            
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
                 <form action="controlador/solicitudCompra/controllerOCMasiva" method="post">
                
                <div class="card-header">
                    <label>Proveedor</label>
                    <select name="proveedor" id="proveedor" class="form-control" style="width:25%;">
                        <option value=""></option>
                        <?php
                        $consutamosProveedor=$mysqli->query("SELECT * FROM proveedores WHERE estado='Aprobado'  ORDER BY razonSocial");
                        while($extraerDatosProveedor=$consutamosProveedor->fetch_array()){
                        ?>
                        <option value="<?php echo $extraerDatosProveedor['id']; ?>"><?php echo $extraerDatosProveedor['razonSocial']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <?php
                    
                    // traemos el proveedor guardado anteriormente
                    $consultandoProveedorSeleccionado=$mysqli->query("SELECT * FROM solicitudComprador WHERE idSolicitud='$idOrdenCompra' ");
                    $extraerDatosConsultaProveedorSeleccionado=$consultandoProveedorSeleccionado->fetch_array(MYSQLI_ASSOC);
                    $existenciaProveedor=$extraerDatosConsultaProveedorSeleccionado['proveedor'];
                    // 
                    
                    
                    ////////////// traemos los datos del proveedor
                    $consultandoProveedor=$mysqli->query("SELECT * FROM proveedores WHERE id='$existenciaProveedor' ");
                    $extraerDatosConsultaProveedor=$consultandoProveedor->fetch_array(MYSQLI_ASSOC);
                    echo '<br>';
                    echo '<b>RAZÓN SOCIAL</b> '.$extraerDatosConsultaProveedor['razonSocial'];
                    echo '<br>';
                    echo '<b>NIT</b> '.$extraerDatosConsultaProveedor['nit'];
                    echo '<br>';
                    echo '<b>TELÉFONO</b> '.$extraerDatosConsultaProveedor['telefono'];
                    echo '<br>';
                    echo '<b>CIUDAD</b> '.$extraerDatosConsultaProveedor['ciudad'];
                    echo '<br>';
                    echo '<b>DIRECCIÓN</b> '.($extraerDatosConsultaProveedor['direccion']);
                    echo '<br>';
                    
                    if($extraerDatosConsultaProveedor['tipo'] == 'otro'){
                        $mostrarMetodoPago=$extraerDatosConsultaProveedor['tipo'].' '.$extraerDatosConsultaProveedor['terminoPago'];
                    }else{
                        $mostrarMetodoPago=$extraerDatosConsultaProveedor['tipo'];
                        if($mostrarMetodoPago == 'credito'){
                            $mostrarMetodoPago='crédito';
                        }else{
                            $mostrarMetodoPago=$extraerDatosConsultaProveedor['tipo'];
                        }
                    }
                    echo '<b>METÓDO DE PAGO</b> '.$mostrarMetodoPago;
                    ?>
                </div>
                 <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                <?php
                $consultaComprador=$mysqli->query("SELECT * FROM `solicitudComprador` WHERE idSolicitud='".$idOrdenCompra."' ");
                $extraerConsultaComprador=$consultaComprador->fetch_array(MYSQLI_ASSOC);
                ?>
                <input name="oc" value="<?php echo $extraerConsultaComprador['id'];?>" type="hidden">
                      
                       <table class="table table-head-fixed text-center" >
                            <thead>
                                <tr>
                                <th>Grupo</th>
                                <th>Subgrupo</th>
                                <!--<th>Consecutivo</th>-->
                                <th>Producto</th>
                                <th>Identificador</th>
                                <th>Código</th>
                                <th>Tipo producto</th>
                                <th>Impuesto</th>
                                <th>Cantidad</th>
                                <th>V.Unitario</th>
                                <th>Subtotal</th>
                                <th>Iva</th>
                                <th>Total</th>
                                </tr>
                            </thead> 
                            <tbody>
                        <?php 
                           $consultaProductos = $mysqli->query("SELECT * FROM solicitudAlistamiento WHERE idSolicitud='$idOrdenCompra' ORDER BY id");
                           
                           while($extraerConsulta = mysqli_fetch_array($consultaProductos)){
                              ?>
                              <input name="idAlistamiento[]" value="<?php echo $extraerConsulta['id'];?>" type="hidden">
                            <tr>
                                <td><?php  
                                    $consultandoProductos=$mysqli->query("SELECT * FROM  proveedorProductos WHERE id='".$extraerConsulta['idProducto']."' ");
                                    $extraerProductos=$consultandoProductos->fetch_array(MYSQLI_ASSOC);
                                    
                                    $grupo=$mysqli->query("SELECT * FROM proveedoresProductoGrupo WHERE id='". $extraerProductos['grupo']."' ");
                                    $extraerGrupo=$grupo->fetch_array(MYSQLI_ASSOC);
                                    echo $extraerGrupo['grupo'];
                                    $subgrupo=$mysqli->query("SELECT * FROM proveedoresProductoSubGrupo WHERE id='". $extraerGrupo['sub']."' ");
                                    $extraerSubgrupo=$subgrupo->fetch_array(MYSQLI_ASSOC);
                                    
                                    ?>
                                </td>
                                <td><?php echo $extraerSubgrupo['grupo'];?></td>
                                <!--<td><?php //echo $extraerProductos['codigoG'];?></td>-->
                                
                                <td><?php 
                                    $consultandoProductos=$mysqli->query("SELECT * FROM  proveedorProductos WHERE id='".$extraerConsulta['idProducto']."' ");
                                    $extraerProductos=$consultandoProductos->fetch_array(MYSQLI_ASSOC);
                                    echo $extraerProductos['nombre'];
                                    $reemplazoImpuesto=$extraerProductos['impuesto'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                     echo $extraerProductos['identificador'];
                                    ?>
                                </td>
                                 <td>
                                    <?php
                                     echo $extraerProductos['codigo'];
                                    ?>
                                </td>
                                <td><?php 
                                        if($extraerProductos['tipoProducto']){
                                            echo 'Bienes'; 
                                        }else{
                                            echo 'Servicios';
                                        }
                                    ?>
                                </td>
                                <td>
                                    
                                    <select name="impuesto[]" class="form-control">
                                        
                                    <?php 
                                    $consultaImpuesto=$extraerConsulta['impuesto'];
                                    if($consultaImpuesto != NULL){
                                         $consultaImpuesto=$extraerConsulta['impuesto'];
                                    }else{
                                         $consultaImpuesto=$reemplazoImpuesto;
                                    }
                                    
                                    $validarImpuesto=$mysqli->query("SELECT * FROM proveedoresTipoImpuesto WHERE id='$consultaImpuesto' ");
                                    $extraerValidarImpuesto=$validarImpuesto->fetch_array(MYSQLI_ASSOC);
                                    $enviarImpuesto=$extraerValidarImpuesto['descripcion'];
                                    ?>
                                    <option value="<?php echo $extraerValidarImpuesto['id']; ?>"><?php echo $extraerValidarImpuesto['grupo'].' '.$extraerValidarImpuesto['descripcion'].' %'; ?></option>
                                    ?>
                                    <?php 
                                    
                                    $validarImpuestoSelec=$mysqli->query("SELECT * FROM proveedoresTipoImpuesto WHERE not id='$consultaImpuesto' ");
                                    while($extraerValidarImpuestoSelec=$validarImpuestoSelec->fetch_array()){
                                    ?>
                                    <option value="<?php echo $extraerValidarImpuestoSelec['id']; ?>"><?php echo $extraerValidarImpuestoSelec['grupo'].' '.$extraerValidarImpuestoSelec['descripcion'].' %'; ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </td>
                               
                                 <td>
                                    <?php
                                    $enviarCantidad=$extraerConsulta['cantidad'];
                                     echo $extraerConsulta['cantidad'];
                                    ?>
                                </td>
                                <td>
                                    <input  type='number' min="0" name ='cantidad[]' value="<?php echo $extraerConsulta['unitario'];?>" class="form-control" placeholder='$...' required>
                                </td>
                                
                                <td>
                                    <?php
                                         echo '$'.number_format($extraerConsulta['costos']);
                                         $costoPorUnidad=$extraerConsulta['costos'];
                                    ?>   
                                </td>
                                
                                <td>
                                    <?php 
                                        
                                        $impuestoAplicado=$costoPorUnidad*($enviarImpuesto)/100;
                                        echo '$'.(number_format($impuestoAplicado));
                                    ?>   
                                </td>
                                     
                                <td>
                                    <?php
                                        echo '$'.number_format($costoPorUnidad+$impuestoAplicado);
                                    ?>
                                </td>
                                
                               <?php
                              echo '</tr>'; 
                                
                            $costoPorUnidadSumatoria+=$extraerConsulta['costos'];
                            $impuestoAplicadoSumatora+=$costoPorUnidad*($enviarImpuesto/100);
                               
                           }
                      
                                              
                       ?>
                      </tbody>  
                   </table>
                    
                  
                        <div class="card-body">
                            
                            <div class="float-right">
                                <div class="chart">
                                  <b style='text-align:right'>Subtotal : $ <?php echo number_format($costoPorUnidadSumatoria); ?></b>
                                  <br>
                                  <b style='text-align:right'>Iva : $ <?php echo number_format($impuestoAplicadoSumatora); ?></b>
                                  <br>
                                  <b style='text-align:right'>Total: $ <?php  echo number_format($costoPorUnidadSumatoria+$impuestoAplicadoSumatora);  ?></b>
                                </div>
                                <br>
                                <?php
                                if($existenciaProveedor != NULL){
                                   $enviarNombreId=''; 
                                }else{
                                   $enviarNombreId="id='guardar'"; 
                                }
                                ?>
                                <button type="submit" class="btn btn-primary " <?php echo $enviarNombreId;?> name="ActualizarF">Calcular</button>
                                <?php
                                if($validarComprador == 1){ }else{
                                ?>
                                <button type="submit" class="btn btn-success " id="vista" name="vistaPrevia">Vista previa</button>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                         <script>
                              $(document).ready(function(){
                                $('#guardar').click(function(){
                                    document.getElementById("proveedor").setAttribute("required","any"); 
                                });
                                $('#vista').click(function(){
                                    document.getElementById("proveedor").removeAttribute("required","any");
                                });
                            });
                         </script>
                          
                      </form>
                   
               
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
<?php // require_once'footer.php'; ?>

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
    
    
    
    
    if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El documento ya existe.'
        })
    <?php
    }
    if($validacionExisteB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El archivo no se pudo eliminar.'
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
    if($validacionExisteD == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El prefijo del proceso ya existe.'
        })
    <?php
    }
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
<script type='text/javascript'>
//	    document.oncontextmenu = function(){return false}
    </script>
</body>
</html>
<?php
}
?>