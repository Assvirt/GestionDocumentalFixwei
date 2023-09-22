<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'proveedores'; //Se cambia el nombre del formulario

require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
    <title>Proveedores Productos</title>
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
<body class="hold-transition sidebar-mini" onload="nobackbutton();" >
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
                 <h1>Productos</h1>
              <?php
                    $idProveedor=$_POST['idProveedor'];
                    $query = $mysqli->query("SELECT * FROM proveedores WHERE id= '$idProveedor'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $idEnviarProveedor = $row['id'];
                    $nit = $row['nit'];
                    $proveedor = $row['razonSocial'];
              ?>
            <h1><!-- Productos del proveedor <?php //echo $proveedor; ?>--></h1>
          </div>
        
          <div class="col-sm-6">
              
            <ol class="breadcrumb float-sm-right">
             
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Proveedores Productos</li>
            </ol>
          </div>
        </div>
          
        <div>
            <?php
                if($visibleI == FALSE){
            ?>
            <div class="row">
            <div class="col-sm">
                <form action="agregarProveedorProducto" method="POST">
                    <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                    <button type="submit" class="btn btn-block btn-info btn-sm"><a href="#"><font color="white"><i class="fas fa-plus-square"></i> Nuevo producto</font></a></button>
                </form>
            </div>
            <div class="col-sm">
                <form action="agregarProveedorGrupo" method="POST">
                    <button type="submit" class="btn btn-block btn-info btn-sm"><a href="#"><font color="white"><i class="fas fa-plus-square"></i> Grupo</font></a></button>
                </form>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarProveedoresProductosImpuesto"><font color="white"><i class="fas fa-money-check"></i> Tipo de impuesto</font></a></button>
            </div>
            <div class="col-sm">
                <form action="exportacion/ProveedorProductos" method="POST">
                    <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                <button type="submit" class="btn btn-block btn-warning btn-sm" ><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
                </form>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="importacion/importar-proveedor-productos/Producto.xlsx" onClick="javascript:document["ver-form"].submit();"><font color="white"><i class="fas fa-cloud-download-alt"></i> Descargar Plantilla</font></a></button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='excelProductosCargados'"><a href="#"><font color="white"><i class="fas fa-cloud-download-alt"></i> Plantilla De Datos</font></a></button>
            </div>

            <div class="col-sm">
                <form action="importacion2/importar-proveedor-productos/index" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                    <!--<input name="idProveedor" value="<?php //echo $idProveedor; ?>" type="hidden" readonly>-->
                    <div class="custom-file">
                        <input type="file" name="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile" accept=".xls,.xlsx">Importar archivo</label>
                         <script>
                                $('input[name="file"]').on('change', function(){
                                    var ext = $( this ).val().split('.').pop();
                                    if ($( this ).val() != '') {
                                      if(ext == "xls" || ext == "xlsx"){
                                        
                                      }
                                      else
                                      {
                                        $( this ).val('');
                                        //alert("Extensión no permitida: " + ext);
                                        const Toast = Swal.mixin({
                                          toast: true,
                                          position: 'top-end',
                                          showConfirmButton: false,
                                          timer: 3000
                                        });
                                    
                                    
                                        Toast.fire({
                                            type: 'warning',
                                            title: ` Extensión no permitida`
                                        })
                                      }
                                    }
                                  });
                                </script>
                    </div>
                
            </div>
            <div class="col-sm">
                <button type="submit" name="import" class="btn btn-block btn-info btn-sm"><a class="" href="#"><font color="white"><i class="fas fa-file-upload"></i> Importar</font></a></button>
            </div>
            </form>
            <!--
            <div class="col-sm">
                <form action="proveedoresVer" method="POST">
                    <input name="idProveedor" value="<?php //echo $idProveedor; ?>" type="hidden" readonly>
                <button type="submit" class="btn btn-block btn-success btn-sm"><a href="#"><font color="white"><i class="fas fa-list"></i> Regresar</font></a></button>
                </form>
            </div>
            -->
            <div class="col-sm"><!-- Vista PPAL -->
                <button type="button" class="btn btn-block btn-success btn-sm"><a href="proveedores"><font color="white"><i class="fas fa-list"></i> Regresar</font></a></button>
            </div>
            
            </div>
            <?php }else{?>
            <!--
            <div class="row">
                <div class="col-sm">
                    <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/usuarios'"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
                </div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
            </div>
            -->
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
              <div class="card-body table-responsive p-0" style="height: 800px;">
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>N°</th>
                      <th>Tipo de producto</th>
                      <th>Grupo</th>
                      <th>Subgrupo</th>
                      <!--<th>Consecutivo</th>-->
                      <th>Nombre del producto</th>
                      <th>Código</th>
                      <th>Identificador</th>
                      <th>Impuesto</th>
                      <th>Documentos</th>
                      <!--<th>Fecha de expiraci&oacute;n</th>-->
                      <th>Ver m&aacute;s</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                    
                         $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $data = $mysqli->query("SELECT * FROM proveedorProductos  ORDER BY nombre ASC")or die(mysqli_error()); //WHERE idProveedor='$idProveedor'
                    
                     $conteo=1;
                     while($row = $data->fetch_assoc()){
                        $id = $row['id'];
                    echo"<tr>";
                    echo"<td>".$conteo++."</td>";
                    
                     /// traemos los datos faltantes
                    $opcion = $row['tipoProducto'];
                    if($opcion == 1){
                        $nombreTipo='Bienes';
                        $nombretítulo='bien';
                        $nombreUnidad='empaque';
                    }else{
                        $nombreTipo='Servicios';
                        $nombretítulo='servicio';
                        $nombreUnidad='medida';
                    }
                    /// END
                    echo '<td>'.$nombreTipo.'</td>';
                    
                    
                    $grupoConsulta=$mysqli->query("SELECT * FROM proveedoresProductoGrupo WHERE id='".$row['grupo']."' ");
                    $extraerProveedoresGrupo=$grupoConsulta->fetch_array(MYSQLI_ASSOC);
                    $nombreGrupo=$extraerProveedoresGrupo['grupo'];
                    $grupoConSub=$mysqli->query("SELECT * FROM proveedoresProductoSubGrupo WHERE id='".$extraerProveedoresGrupo['sub']."' ");
                    $extraerProveedoresSub=$grupoConSub->fetch_array(MYSQLI_ASSOC);
                    $nombreSubgrupo=$extraerProveedoresSub['grupo'];
                    
                    echo "<td>".$nombreGrupo."</td>";  
                    echo "<td>".$nombreSubgrupo."</td>";
                    //echo "<td>".$row['codigoG']."</td>";
                    $importaciones=$row['importacion'];
                    if($importaciones == 1){
                    echo "<td>".($row['nombre'])."</td>";
                    }else{
                    echo "<td>".$row['nombre']."</td>";    
                    }
                    
                    if($importaciones == 1){
                    echo "<td>".utf8_encode($row['codigo'])."</td>";
                    }else{
                    echo "<td>".$row['codigo']."</td>";    
                    }
                    
                    if($row['identificador'] != NULL){
                        
                        $unidadIdentificador=$mysqli->query("SELECT * FROM proveedoresProductoIdentificador WHERE id='".$row['identificador']."' ORDER BY grupo ");
                        $extraerIdentificador=$unidadIdentificador->fetch_array();
                    
                        
                        
                    echo "<td>".$extraerIdentificador['grupo']."</td>";
                    }else{
                      echo "<td>N/A</td>";  
                    }
                    $impuesto=$row['impuesto'];
                    
                    if($impuesto == 'N/A'){
                        echo "<td>N/A</td>";
                    }else{
                        $consultaImpuestos=$mysqli->query("SELECT * FROM proveedoresTipoImpuesto WHERE id='$impuesto' ORDER BY grupo");
                        while($extraerConsultaImpuestos=$consultaImpuestos->fetch_array()){
                            $enviarNombreImpuesto=$extraerConsultaImpuestos['grupo'].' '.$extraerConsultaImpuestos['descripcion'].' %';
                            echo "<td>".$enviarNombreImpuesto."</td>"; 
                        }
                    }
                    
                    
                    //echo "<td> $ ".number_format($row['costo'],0,'.',',')."</td>";
                    
                    //echo "<td>".$row['fechaExpedicion']."</td>";
                    $dataDocumentos = $mysqli->query("SELECT * FROM proveedorProductosDocumentos WHERE idProducto ='$id' ORDER BY id ASC")or die(mysqli_error());
                    $rowDocumentos = $dataDocumentos->fetch_array(MYSQLI_ASSOC);
                    if($rowDocumentos['id'] != NULL){
                    echo "<td><i style='color:green;' class='fas fa-paperclip'></i></td>";
                    }else{
                    echo "<td><i style='color:red;' class='fas fa-paperclip'></i></td>";    
                    }
                    
                    echo"<form action='proveedoresProductoVer' method='POST'>";
                    echo"<input type='hidden' name='idProveedor' value= '$idProveedor' >";
                    echo"<input type='hidden' name='idProveedorProducto' value= '$id' >";
                    echo"<td><button type='submit' class='btn btn-block btn-primary btn-sm'><i class='fas fa-eye'></i> Ver más</button></td>";
                    echo"</form>";
                    echo"<form action='proveedoresProductoEditar' method='POST'>";
                    echo"<input type='hidden' name='idProveedor' value= '$idProveedor' >";
                    echo"<input type='hidden' name='idProveedorProducto' value= '$id' >";
                    echo" <td style='display:$visibleE;'><button value'$idProveedor' type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                    echo"</form>";
                    /// validación de script y funcion de eliminacion
                        ?>
                        <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $id;?>' >
                        <td style='display:<?php echo $visibleD;?>'><a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                        <script>
                            function funcionFormula<?php echo $contador2++;?>() {
                                /*alert("entre");*/
                              document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                            }
                       </script>
                        <?php
                        /// END
                    /*
                    echo"<form action='controlador/proveedor/controllerProducto' method='POST'>";
                    echo"<input type='hidden' name='idProveedor' value= '$idProveedor' >";
                    echo"<input type='hidden' name='idProveedorProducto' value= '$id' >";
                    echo" <td style='display:$visibleD;'><button onclick='return ConfirmDelete()' type='submit' name='Eliminar' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
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
                            <form action='controlador/proveedor/controllerProducto' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input type='hidden' name='idProveedor' value= '<?php echo $idProveedor; ?>' >
                              <input type="hidden" id="capturarFormula" name='idProveedorProducto' readonly>
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

<!-- para mostrar el archivo seleccionado en el file -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<!-- END -->

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
$validacionExisteB=$_POST['validacionExisteB'];
$validacionExisteC=$_POST['validacionExisteC'];
$validacionExisteD=$_POST['validacionExisteD'];
$validacionExisteE=$_POST['validacionExisteE'];
$validacionAgregar=$_POST['validacionAgregar'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];


//// validaciones de importacion
$validacionExisteImportacion=$_POST['validacionExisteImportacion'];

//// validación de campo vacio, identificando la columna que contiene el campo vacio
$validacionExisteImportacionVacio=$_POST['validacionExisteImportacionVacio'];
$mensajeEnviarCampoVacio=" 'Algunos campos están vacios ".$_POST['mensajeEnviarCampoVacio']." ' ";
/// END

$validacionExisteImportacion1=$_POST['validacionExisteImportacion1'];
$validacionExisteImportacion2=$_POST['validacionExisteImportacion2'];
$validacionExisteImportacion3=$_POST['validacionExisteImportacion3'];
$validacionExisteImportacion4=$_POST['validacionExisteImportacion4'];
$validacionExisteImportacion5=$_POST['validacionExisteImportacion5'];
$validacionExisteImportacion6=$_POST['validacionExisteImportacion6'];
$validacionExisteImportacion7=$_POST['validacionExisteImportacion7'];
$validacionExisteImportacion8=$_POST['validacionExisteImportacion8'];
$validacionExisteImportacion9=$_POST['validacionExisteImportacion9'];
$validacionExisteImportacion10=$_POST['validacionExisteImportacion10'];
$validacionExisteImportacion11=$_POST['validacionExisteImportacion11'];
$validacionExisteImportacion12=$_POST['validacionExisteImportacion12'];
$validacionExisteImportacion13=$_POST['validacionExisteImportacion13'];
$validacionExisteImportacion14=$_POST['validacionExisteImportacion14'];
$validacionExisteNumerio=$_POST['validacionExisteNumerio'];

$validacionExisteImportacionTipoServicio=$_POST['validacionExisteImportacionTipoServicio'];
$validacionExisteImportacionExito=$_POST['validacionExisteImportacionExito'];

$validacionExisteCodigo=$_POST['validacionExisteCodigo'];
/// END

//// validación de campo vacio, identificando la columna que contiene el campo vacio
$validacionExisteImportacionVacio=$_POST['validacionExisteImportacionVacio'];
$mensajeEnviarCampoVacio=" 'Algunos campos están vacios ".$_POST['mensajeEnviarCampoVacio']." ' ";
/// END
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
     if($validacionExisteImportacionVacio == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: <?php echo $mensajeEnviarCampoVacio;?>
        })
    <?php
    } 
    if($validacionExisteCodigo == 1){
     ?>
        Toast.fire({
            type: 'warning',
            title: ' El código ya existe.'
        })
    <?php   
    }
    if($validacionExisteNumerio == 1){
     ?>
        Toast.fire({
            type: 'warning',
            title: ' Los datos ingresados en cantidad de tiempo de servicio son solo númericos:<br> <?php echo $_POST['enviarCantidadServicioNo'];?> '
        })
    <?php   
    }
    if($validacionExisteImportacionTipoServicio == 1){
     ?>
        Toast.fire({
            type: 'warning',
            title: ' El tiempo de servicio no existe:<br> <?php echo $_POST['enviarTiempoServicioNo'];?>'
        })
    <?php   
    }
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
    
    if($validacionExisteImportacionVacio == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: <?php echo $mensajeEnviarCampoVacio;?>
        })
    <?php
    } 
    
    if($validacionExisteImportacion1 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El nombre ya existe:<br><?php echo $_POST['enviarNombreExistente'];?>'
        })
    <?php
    }
    
    if($validacionExisteImportacion2 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El nombre está repetido en el documento.'
        })
    <?php
    }
    
     if($validacionExisteImportacion3 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El código ya existe.'
        })
    <?php
    }
    
    if($validacionExisteImportacion4 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El código está repetido en el documento.'
        })
    <?php
    }
    
    if($validacionExisteImportacion5 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El identificador no existe:<br> <?php echo $_POST['enviarIdentificadorNo'];?> '
        })
    <?php
    }
    
     if($validacionExisteImportacion6 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El identificador está repetido en el documento.'
        })
    <?php
    }
    
    if($validacionExisteImportacion7 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El impuesto no existe:<br> <?php echo $_POST['enviarImpuesto']?> '
        })
    <?php
    }
    
     if($validacionExisteImportacion8 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El identificador del grupo no existe:<br> <?php echo $_POST['enviarGrupo']?>'
        })
    <?php
    }
    
     if($validacionExisteImportacion9 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Está ingresando un tipo de producto no autorizado:<br> <?php echo $_POST['enviarTipoProductoNo'];?>'
        })
    <?php
    }
    
    if($validacionExisteImportacion10 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' La unidad de empaque no existe:<br> <?php echo $_POST['enviarUnidadEmpaque'];?>'
        })
    <?php
    }
    
     if($validacionExisteImportacion11 == 1){
         ///// preuntando si entra el mensaje y ver cuál mostrar
         $enviarDatoProveedorActivo=$_POST['enviarDatoProveedorActivo'];
         $enviarDatoProveedorNoExistente=$_POST['enviarDatoProveedorNoExistente'];
        
         if($enviarDatoProveedorActivo != NULL){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El proveedor sugerido no está activo: <br> <?php echo $enviarDatoProveedorActivo;?>'
        })
    <?php
         }
         
        if($enviarDatoProveedorNoExistente != NULL){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El proveedor no existe: <br> <?php echo $enviarDatoProveedorNoExistente;?>'
        })
    <?php
         }
         
    }
    
    if($validacionExisteImportacion12 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' La respuesta del inventario no es la correcta:<br> <?php echo $_POST['enviarRespuestaInventario'];?>'
        })
    <?php
    }   
    
    if($validacionExisteImportacion13 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' La respuesta del activo no es la correcta:<br> <?php echo $_POST['enviarActivoNo'];?> '
        })
    <?php
    }   
    
    if($validacionExisteImportacion14 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' La unidad de medida no existe:<br> <?php echo $_POST['enviarUnidadMedida'];?>'
        })
    <?php
    }   
    
    if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El producto  ya existe.'
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
            type: 'warning',
            title: ' El proceso se encuentra en uso, no se puede eliminar.'
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
    
    
    if($_POST['alertaEnter'] != NULL){ /// arrojamos el mensaje del enter
    ?>
        Toast.fire({
            type: 'warning',
            title: '<?php echo $_POST['titulo'];?> contiene un (ENTER) no permitido en la celda <?php echo $_POST['alertaEnter'];?> '
        })
    
    <?php
    }
    
    if($_POST['enviarMensajeCaracter'] != NULL){
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaTipoProducto'){
        $mensajeCaracter='El tipo de producto contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterTipoProducto'){
        $mensajeCaracter='El tipo de producto contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaNombre'){
        $mensajeCaracter='El nombre contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterNombre'){
        $mensajeCaracter='El nombre contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaDescripcion'){
        $mensajeCaracter='La descripción contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterDescripcion'){
        $mensajeCaracter='La descripción contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaGrupo'){
        $mensajeCaracter='El grupo y subgrupo contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterGrupo'){
        $mensajeCaracter='El grupo y subgrupo contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaCodigo'){
        $mensajeCaracter='El código contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterCodigo'){
        $mensajeCaracter='El código contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaIdentificador'){
        $mensajeCaracter='El identificador contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterIdentificador'){
        $mensajeCaracter='El identificador contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaImpuesto'){
        $mensajeCaracter='El impuesto contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterImpuesto'){
        $mensajeCaracter='El impuesto contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaUnidadempaque'){
        $mensajeCaracter='La unidad de empaque contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterUnidadempaque'){
        $mensajeCaracter='La unidad de empaque contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaUnidadmedida'){
        $mensajeCaracter='La unidad de medida contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterUnidadmedida'){
        $mensajeCaracter='La unidad de medida contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaProveedor'){
        $mensajeCaracter='El proveedor sugerido contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterProveedor'){
        $mensajeCaracter='El proveedor sugerido contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaTiemposervicio'){
        $mensajeCaracter='El tiempo de servicio contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterTiemposervicio'){
        $mensajeCaracter='El tiempo de servicio contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaActivo'){
        $mensajeCaracter='La columna activo contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterActivo'){
        $mensajeCaracter='La columna activo contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        
    ?>
        Toast.fire({
            type: 'warning',
            title: '<?php echo $mensajeCaracter;?> '
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