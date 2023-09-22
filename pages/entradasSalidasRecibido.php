<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'entradasSalidas'; //Se cambia el nombre del formulario
require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
    <title>Ingreso orden de compra</title>
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
            <h1>Ingreso orden de compra</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Ingreso orden de compra</li>
            </ol>
          </div>
        </div>
        <div class="col-sm-6">
               <?php
                $idOrdenCompra=$_POST['idOrdenCompra'];
                $consultaSolicitud=$mysqli->query("SELECT * FROM solicitudCompra WHERE id='$idOrdenCompra' ");
                $extraerCnsultaSolicitud=$consultaSolicitud->fetch_array(MYSQLI_ASSOC);
                $estadoGeneral=$extraerCnsultaSolicitud['estado'];
                ?>
            <h1><?php $extraerCnsultaSolicitud['id'];?></h1>
        <div>
            <div class="row">
               
                <div class="col-9">
                    <div class="row">
                        
                        <div class="col-sm-3">
                        <form action="solicitudCompraVerMas" method="post">
                             <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                            
                            </form>
                        </div>
                    </div>
                </div>
                 
                <div class="col">
                  
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
          <div class="col">
              <div class="row">
                <div class="col-9">
                    <div class="row">
                        <div class="col-sm">
                          <button  type="button" class="btn btn-block btn-info btn-sm"><a href="ordenCompraEntradasRecibidos"><font color="white"><i class="fas fa-list"></i> Listar </font></a></button>
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

              <br>
            <div class="card">
              <div class="card-header">
                  
                <?php
                $idOrdenCompra=$_POST['idOrdenCompra'];
                $consultaSolicitud=$mysqli->query("SELECT * FROM solicitudCompra WHERE id='$idOrdenCompra' ");
                $extraerCnsultaSolicitud=$consultaSolicitud->fetch_array(MYSQLI_ASSOC);
                $estadoGeneral=$extraerCnsultaSolicitud['estado'];
                
                
                ///// cuando el comprador modifica los productos o no, debe obligar a volver a calcular
                
                if($_POST['compradorEditar'] != NULL){
                   $updateSolicitud=$mysqli->query("UPDATE solicitudCompra SET modificacion='1' WHERE id='$idOrdenCompra' ");
                }
                
                /// END
                
                
                ?>
                <h3 class="card-title">
                    <b>Solicitud N°</b> <?php echo $extraerCnsultaSolicitud['id'];?> <br> 
                    <b>Orden de compra N°</b> 
                    <?php 
                     ///// validamos quién puede ver las solitudes asignadas
                         $visualizacionSolicitud=$mysqli->query("SELECT * FROM solicitudComprador WHERE idSolicitud='$idOrdenCompra'  ");
                         $extraerDatos=$visualizacionSolicitud->fetch_array(MYSQLI_ASSOC);
                         
                            $idSolicitudOC=$extraerDatos['id']; 
                            $idSolicitudOCFechaActivada=$extraerDatos['fechaActivada'];
                        
                         
                            $consultaSolicitudComprador=$mysqli->query("SELECT * FROM solicitudComprador WHERE idSolicitud='$idOrdenCompra' ");
                            $extraerCnsultaSolicitudComprador=$consultaSolicitudComprador->fetch_array(MYSQLI_ASSOC);
                             
                                $consucutivo=$mysqli->query("SELECT * FROM consecutivoOC ORDER BY id ");
                                while($extraerConsecutivo=$consucutivo->fetch_array()){
                                    
                                    /*
                                    if($extraerConsecutivo['aplicado'] == '1'){
                                    echo    $extraerCnsultaSolicitudComprador['id'];
                                    }else{
                                    echo $extraerConsecutivo['caracter'];
                                    }
                                    */
                                    if($extraerConsecutivo['aplicado'] == '1'){
                                    echo    $idSolicitudOC;
                                    }elseif($extraerConsecutivo['caracter'] == 'Fecha'){
                                    echo $idSolicitudOCFechaActivada;
                                    }else{
                                    echo $extraerConsecutivo['caracter'];
                                    }
                                    echo '-';
                                }
                            ?>
                    <br>
                    <b>N° de ingreso</b> 
                    <?php
                        $consultaSolicitudCompradorIngreso=$mysqli->query("SELECT * FROM solicitudEntradaSalidasEstado WHERE idSolicitud='".$_POST['idOrdenCompra']."' ");
                        $extraerCnsultaSolicitudCompradorIngreso=$consultaSolicitudCompradorIngreso->fetch_array(MYSQLI_ASSOC);
                        echo $extraerCnsultaSolicitudCompradorIngreso['id'];
                    ?>
                  
                </h3>
           
               </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <div class="card-header">
                <?php
                
                $consultamosRecibidp=$mysqli->query("SELECT * FROM solicitudEntradaSalidasEstado WHERE idSolicitud='".$_POST['idOrdenCompra']."' ");
                $extraerConsultasRevibido=$consultamosRecibidp->fetch_array(MYSQLI_ASSOC);
                $observacionesCon=$extraerConsultasRevibido['observacion'];
                
                $ancho=120; 
                $cadena=$observacionesCon;

                if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { 
                  $eol="\r\n"; 
                }elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { 
                  $eol="\r"; 
                } else { 
                  $eol="\n"; 
                } 
                    
                $cad=wordwrap($cadena, $ancho, $eol, 1); 
                $lineas=substr_count($cad,$eol)+1; 
                ?>
                
                <label>Observaciones</label>
                <textarea class="form-control" cols="<?php echo $ancho; ?>" rows="<?php echo $lineas;?>" disabled><?php echo $cadena;?></textarea>
                
                
                
                
                
                
                <?php
                
                $consultandoResponsables=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idSolicitud='".$_POST['idOrdenCompra']."' ");
                $extraerValidacion=$consultandoResponsables->fetch_array(MYSQLI_ASSOC);
                $idSolicitudValidacion=$extraerValidacion['idSolicitud'];
               
               
               // validamos si en alguno rechazo la solicitud
                $consultandoResponsablesValidacion=$mysqli->query("SELECT count(*) FROM solicitudCompraFlujo WHERE idSolicitud='".$_POST['idOrdenCompra']."' AND estado='rechazado' ");
                while($extraerValidacionValidacion=$consultandoResponsablesValidacion->fetch_array()){
                $conteoValidacionRechazo=$extraerValidacionValidacion['count(*)'];
                }
               
               if($conteoValidacionRechazo > 0 && $extraerCnsultaSolicitud['idUsuario'] == $cc){
               
               
               
               
               }else{
               
                if($estadoGeneral == 'Aprobado'){
                    //echo '<center><font color="green">Solicitud aprobada</font></center>';
                }else{
                   if($extraerValidacion['idSolicitud'] != NULL){ 
                       if($_POST['compradorEditar'] != NULL){
                        //echo '<center><font color="green">En proceso Orden de compra</font></center>';   
                       }else{
                       // echo '<center><font color="red">Solicitud en revisión</font></center>';
                       }
                   }else{
                   ?>
                   
                       
                    
                  
                              <!-- Acá se encontraba el modal de registro -->
                    
                        
                   
                    <?php
                   }
                }
               }
                ?>
                
                
               
                
                
                
                </div>
              </div>
              
              
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
     
     <section class="content-header">
         <div class="container-fluid">
            <div class="row">
                <div class="col-sm">
                <!-- AREA CHART -->
                    <div class="card">
                        
                
              
                           
              </div>
            </div>  
        </div>      
        <div class="row">
           
          <!-- /.col (LEFT) -->
          <div class="col-md-12">
            <!-- LINE CHART -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Productos recibidos </h3>
              </div>
              <div class="card-body">
                <div class="chart">
                    
                    
                    <table class="table table-head-fixed text-center" >
                         <thead>
                            <tr>
                                <!--<th>Grupo</th>
                                <th>Subgrupo</th>
                                <th>Consecutivo</th>-->
                                <th>Producto</th>
                                <th>Identificador</th>
                                <th>Código</th>
                                <!--<th>Impuesto</th>
                                <th>Tipo producto</th>-->
                                <th>Cantidad</th>
                                <th>Comentario</th>
                                <th>Observaciones</th>
                              
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $consultaProductos=$mysqli->query("SELECT * FROM solicitudEntradaSalidas WHERE idSolicitud='".$_POST['idOrdenCompra']."' ORDER BY id ");
                            while($extraerConsulta=$consultaProductos->fetch_array()){
                            ?>
                            <tr>
                                <?php
                                /*
                                ?>
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
                                
                                <td><?php echo $extraerProductos['codigoG'];?></td>
                                <?php
                                */
                                ?>
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
                                <?php
                                /*
                                ?>
                                <td><?php 
                                    $consultaImpuesto=$extraerProductos['impuesto'];
                                    $validarImpuesto=$mysqli->query("SELECT * FROM proveedoresTipoImpuesto WHERE id='$consultaImpuesto' ");
                                    $extraerValidarImpuesto=$validarImpuesto->fetch_array(MYSQLI_ASSOC);
                                    echo $extraerValidarImpuesto['grupo'].' '.$extraerValidarImpuesto['descripcion'].' %';
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
                                <?php
                                */
                                ?>
                                 <td>
                                    <?php
                                     echo $extraerConsulta['cantidad'];
                                    ?>
                                </td>
                                <?php /* ?>
                                <td>
                                    <form action="" method="post">
                                    <input name="idOrdenCompra" value="<?php echo $_POST['consultaProductos']; ?>" type="">
                                    <input name="id" value="<?php echo $extraerConsulta['id']; ?>" type="">
                                    <button type="submit" name="eliminacion">Eliminar</button>
                                    </form>
                                </td>
                                <?php */ ?>
                                <td><?php echo $extraerConsulta['comentario']; ?></td>
                                <td>
                                    <?php 
                                        $validandoConsultaPedido=$mysqli->query("SELECT * FROM solicitudAlistamiento WHERE idSolicitud='".$_POST['idOrdenCompra']."' AND idProducto='".$extraerConsulta['idProducto']."' ");
                                        $extrerValidacionProductos=$validandoConsultaPedido->fetch_array(MYSQLI_ASSOC);
                                        
                                        if($extraerConsulta['cantidad'] == $extrerValidacionProductos['cantidad']){
                                            echo '<font color="green">El producto está completo</font>';
                                        }elseif($extraerConsulta['cantidad'] > $extrerValidacionProductos['cantidad']){
                                            $restante=ABS($extraerConsulta['cantidad']-$extrerValidacionProductos['cantidad']);
                                          
                                            
                                            if($restante == 1){
                                                 echo '<font color="blue">Llego '.$restante.' de más</font>';
                                            }else{
                                                 echo '<font color="blue">Llegaron '.$restante.' de más</font>';
                                            }
                                        }elseif($extraerConsulta['cantidad'] < $extrerValidacionProductos['cantidad']){
                                            $restante=ABS($extraerConsulta['cantidad']-$extrerValidacionProductos['cantidad']);
                                            
                                            if($restante == 1){
                                                 echo '<font color="red">Falta '.$restante.' producto</font>';
                                            }else{
                                                 echo '<font color="red">Faltan '.$restante.' del producto</font>';
                                            }
                                           
                                        }
                                    ?>
                                </td>
                                
                                
                                
                                
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                     </table>
                  
                  
                  
                  
                 
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            
               
                        
                   
                                   

          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    
    
    
    
    
    
  </div>
  <!-- /.content-wrapper -->
<?php //echo require_once'footer.php'; ?>

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
<!--Librerias para el estilo del campo para cargar archivos -->


<!-- END-->
<?php
  $validacionActualizar=$_POST['validacionActualizar'];
  $validacionEliminar=$_POST['validacionEliminar'];
?>

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
  
<script type='text/javascript'>
	    //document.oncontextmenu = function(){return false}
    </script>


  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
 
     
    <!-- archivos para el filtro de busqueda y lista de información -->
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
 
    <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>
    <!-- END -->
    
    
    
      <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- SweetAlert2 -->
  <script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
  <?php
  /// validaciones de alertas
  $validacionExiste=$_POST['validacionExiste'];
  $validacionExisteA=$_POST['validacionExisteA'];
  $validacionExisteB=$_POST['validacionExisteB'];
  $validacionAgregar=$_POST['validacionAgregar'];
  $validacionAgregarB=$_POST['validacionAgregarB'];
  $validacionActualizar=$_POST['validacionActualizar'];
  $validacionEliminar=$_POST['validacionEliminar'];
  $validacionEliminarB=$_POST['validacionEliminarB'];
  $Tipodocumeto=$_POST['Tipodocumeto'];

  //// Validaciones de la importación
  $validacionExisteImportacionA=$_POST['validacionExisteImportacionA'];
  $validacionExisteImportacionB=$_POST['validacionExisteImportacionB'];
  $validacionExisteImportacionC=$_POST['validacionExisteImportacionC'];
  $validacionExisteImportacionD=$_POST['validacionExisteImportacionD'];
  $validacionExisteImportacionE=$_POST['validacionExisteImportacionE'];
  $validacionExisteImportacionF=$_POST['validacionExisteImportacionF'];
  $validacionExisteImportacionG=$_POST['validacionExisteImportacionG'];
  $validacionExisteImportacionI=$_POST['validacionExisteImportacionI'];
  $validacionExisteImportacionVacio=$_POST['validacionExisteImportacionVacio'];
  //// END
  
  
    $validacionProductoExiste=$_POST['validacionProductoExiste'];
    $validacionCodigoExiste=$_POST['validacionCodigoExiste'];
    $validacionIdentificadorExiste=$_POST['validacionIdentificadorExiste'];
    $validacionNumericoExiste=$_POST['validacionNumericoExiste'];
  
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
      if($validacionNumericoExiste == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' Esta intentando ingresar letras en un campo númerico.'
          })
        <?php
      }
      if($validacionProductoExiste == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El producto no existe.'
          })
        <?php
      }
      if($validacionCodigoExiste == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El código no existe.'
          })
        <?php
      }
      if($validacionIdentificadorExiste == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El identificador no existe.'
          })
        <?php
      }
      
      
      
      
      
      if($Tipodocumeto == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El tipo de documento no es valido.'
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
       if($validacionExisteImportacionA == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos cargos no existen en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionB == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos lideres no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionC == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos procesos no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionD == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos centro de costos no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionE == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos centro de trabajo no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionF == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos grupos no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionG == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos usuarios ya existen.'
          })
      <?php
      }
      if($validacionExisteImportacionI == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Está intentando subir un archivo diferente.'
          })
      <?php
      }
      
      
      if($validacionExiste == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' El usuario ya existe.'
          })
      <?php
      }
      if($validacionExisteA == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' La fecha seleccionada no debe superar la del presente año.'
          })
      <?php
      }
      if($validacionExisteB == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' La cédula ya existe con otro usuario, asegúrese que el número de documento permanezca al usuario que se encuentra editando.'
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
              title: 'Registro activado.'
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
      if($validacionEliminarB == 1){
      ?>
          Toast.fire({
              type: 'error',
              title: 'Registro Anulado.'
          })
      
      <?php
      }
      ?>
      
    });

  </script>
 
    <script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function () {
    bsCustomFileInput.init();
  });
  </script>
  <!-- END -->
  
</body>
</html>
<?php

}
?>
<!-- END -->
</body>
</html>
