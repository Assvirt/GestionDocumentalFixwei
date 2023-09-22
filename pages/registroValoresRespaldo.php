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
                $data = $mysqli->query("SELECT * FROM solicitudCompra ORDER BY id ASC")or die(mysqli_error());
                $idCompra = $row['id'];
                echo"<form action='registroProductos' method='POST'>";
                echo"<input type='hidden' name='' value= '$id' >";
                echo"</form>";
                
                if($_POST['gestionar']!= NULL){
            ?>
            <form action="solicitudCompraGestionar" method="post">
             <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
             <button type="submit" class="btn btn-block btn-success btn-sm"><font color="white"><i class="fas fa-list"></i> Regresar</font></button>
            </form>   
            <?php
                }elseif($_POST['comprador']){
            ?>
            <form action="solicitudCompradorVer" method="post">
             <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
             <button type="submit" class="btn btn-block btn-success btn-sm"><font color="white"><i class="fas fa-list"></i> Regresar</font></button>
            </form>
            <?php
                }else{
            ?>
            <form action="solicitudCompradorVer" method="post">
             <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
             <button type="submit" class="btn btn-block btn-success btn-sm"><font color="white"><i class="fas fa-list"></i> Regresar</font></button>
            </form> 
            <?php
                }
            ?>
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
                 <form>
                 <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                
                      
                       <table class="table table-head-fixed text-center" >
                            <thead>
                                <tr>
                                <th>Grupo</th>
                                <th>Subgrupo</th>
                                <th>Producto</th>
                                <th>Identificador</th>
                                <th>Código</th>
                                <th>Tipo producto</th>
                                <th>Impuesto</th>
                                <th>Cantidad</th>
                                <th>V.Unitario</th>
                                <th>Subtotal (Iva)</th>
                                <th>Total</th>
                                </tr>
                            </thead> 
                            <tbody>
                        <?php 
                           $consultaProductos = $mysqli->query("SELECT * FROM solicitudAlistamiento WHERE idSolicitud='$idOrdenCompra' ORDER BY id");
                           
                           while($extraerConsulta = mysqli_fetch_array($consultaProductos)){
                              ?>
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
                                <td><?php 
                                    $consultandoProductos=$mysqli->query("SELECT * FROM  proveedorProductos WHERE id='".$extraerConsulta['idProducto']."' ");
                                    $extraerProductos=$consultandoProductos->fetch_array(MYSQLI_ASSOC);
                                    echo $extraerProductos['nombre'];
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
                                <td><?php 
                                    $consultaImpuesto=$extraerProductos['impuesto'];
                                    $validarImpuesto=$mysqli->query("SELECT * FROM proveedoresTipoImpuesto WHERE id='$consultaImpuesto' ");
                                    $extraerValidarImpuesto=$validarImpuesto->fetch_array(MYSQLI_ASSOC);
                                    echo $extraerValidarImpuesto['grupo'].' '.$extraerValidarImpuesto['descripcion'].' %';
                                    $enviarIvaCalcular=$extraerValidarImpuesto['descripcion'];
                                    $enviarIva=($enviarIvaCalcular/100);
                                    ?>
                                </td>
                               
                                 <td>
                                    <?php
                                    $enviarCantidad=$extraerConsulta['cantidad'];
                                     echo $extraerConsulta['cantidad'];
                                    ?>
                                </td>
                                <td>
                               
                               
                                <input  type='number' min="0" name ='cantidad' id="Costo<?php echo $contadorA++;?>"  class="monto form-control" onkeyup="sumar()" step="any"  placeholder='$...' >
                                </td>
                                <td>
                                        <script type="text/javascript" >

                                        $(document).ready(function () {
                                        $("#Costo<?php echo $contadorB++;?>").keyup(function () {
                                                var value<?php echo $contadorVA++;?> = $(this).val();
                                                //$("#cliente2").val(value); para imprimir en input
                                               
                                                var calculoIva<?php echo $contadorCalcularIva++;?> = (value<?php echo $contadorPAIva++;?> * <?php echo $enviarIva;?>) * <?php echo $enviarCantidad;?> ;
                                                var pesosUnitario<?php echo $contadorPA++;?> = new Intl.NumberFormat().format(calculoIva<?php echo $contadorVB++;?>);
                                                
                                                document.getElementById('cliente2<?php echo $contadorC++;?>').innerHTML = pesosUnitario<?php echo $contadorPB++;?>;
                                            });
                                        });
                                       
                                        </script>
                                        $<span id="cliente2<?php echo $contadorD++;?>"  step="0.01"></span>
                                </td>
                                <td>
                                     <script type="text/javascript" >

                                        $(document).ready(function () {
                                        $("#Costo<?php echo $contadorBT++;?>").keyup(function () {
                                                var valueT<?php echo $contadorVAT++;?> = $(this).val();
                                                //$("#cliente2").val(value); para imprimir en input
                                               
                                                var calculoIvaT<?php echo $contadorCalcularIvaT++;?> = (valueT<?php echo $contadorPAIvaT++;?> * <?php echo $enviarIva;?>) * <?php echo $enviarCantidad;?> ;
                                                var pesosUnitarioT<?php echo $contadorPAT++;?> = new Intl.NumberFormat().format(calculoIvaT<?php echo $contadorVBT++;?>);
                                                
                                                document.getElementById('totalSumado<?php echo $contadorCT++;?>').innerHTML = pesosUnitarioT<?php echo $contadorPBT++;?>;
                                            });
                                        });
                                       
                                        </script>
                                        $<span id="totalSumado<?php echo $contadorDTotal++;?>"  step="0.01"></span>
                                </td>
                               <?php
                              echo '</tr>'; 
                           }
                      
                       
                       
                       ?>
                      </tbody>  
                   </table>
                    
                  
                          <div class="card-body">
                            <div class="chart">
                                 <!-- Medianto un for enviamos el id de la solicitud para traer los productos asignados -->
                                 <form method="post" id="js-form" onsubmit="return false">
                                    <input id="consultaProductos" value="<?php echo $idOrdenCompra; ?>" type="hidden">
                                    <button id="js-consulta" style="display:none;"></button>
                                 </form>
                                 <!-- END -->
                                   <script>
                                   
                                    
                                    
                                    
                                                    function sumar() {
                                                        var total = 0;
                                                        var imp = 18;
                                                        var totalF = 0;
                                                        $(".monto").each(function() {
                                                            if (isNaN(parseFloat($(this).val()))) {
                                                                total += 0;
                                                            }else{
                                                                total += parseFloat($(this).val());
                                                            }
                                                    });
                                                    //alert(total);
                                                    var sumatoria = document.getElementById('spTotal').innerHTML = total;
                                                    
                                                    var pesosTotal = new Intl.NumberFormat().format(sumatoria);
                                                    document.getElementById('spTotal').innerHTML = pesosTotal;
                                                    
                                                    var subtotal = sumatoria * 0.19;
                                                    var pesosSubtotal = new Intl.NumberFormat().format(subtotal);
                                                    document.getElementById('spsubTotal').innerHTML = pesosSubtotal;
                                                   
                                                    var totalCosto =  subtotal + sumatoria;
                                                    var pesosTotalCosto = new Intl.NumberFormat().format(totalCosto);
                                                    
                                                    Math.floor10(document.getElementById('spTotalCosto').innerHTML = pesosTotalCosto);
                                                    
                                                   
                                                    } 
                                                    
                                                    
                                                
                                                    
                                                    
                                </script>
                                  
                                  <b>Subtotal : $ <span id="spTotal" step="0.01"></span></b>
                                  <br>
                                  <b>IVA(19%) : $ <span id="spsubTotal" step="0.01"></span></b>
                                  <br>
                                   <b>Total: $ <span id="spTotalCosto" pattern="[0-9]+([\.,][0-9]+)?" step="0.01"></span></b>
                                 <!-- listamos los datos de la tabla -->
                                 <div id="mostrarDatos" style="display:none;"></div>
                                 <!-- END-->
                                <input type="hidden" value="19">    
                              
                                 
                              <!--alert(new Intl.NumberFormat().format(number));-->
                              
                              
                            </div>
                          </div>
                          <!-- /.card-body -->
                      

            
                        <script>
                            $(document).on('click', '#js-enviar', function(e){
                            	e.preventDefault();
                            	var reg1 = $('#js-reg1').val(), 
                            	    reg3 = $('#js-reg3').val(),
                            	    reg2 = $('#js-reg2').val();
                            
                            	$.ajax({
                            		url: 'registroProductos.php', // Es importante que la ruta sea correcta si no, no se va a ejecutar
                            		method: 'POST',
                            		data: { reg1: reg1, reg2: reg2, reg3: reg3 },
                            		beforeSend: function(){
                            			$('#mostrarDatos').css('display','block');
                            			//$('#estado p').html('Guardando datos...');
                            		},
                            		success: function(r){
                            			//if (r == '200' ) { // Si el php anterior, imprimió 200
                            				$('#mostrarDatos').html(r);
                            			//} else {
                            			//	$('#estado').html('<hr><p>Error al guardar los datos.</p><hr>');
                            			//}
                            		}
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
	    document.oncontextmenu = function(){return false}
    </script>
</body>
</html>
<?php
}
?>