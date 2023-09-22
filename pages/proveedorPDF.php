
<!DOCTYPE html> 
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Orden de Compra</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
  <!-- summernote -->
  <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.css">
  <!--CKeditor-->
  <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
  <script>
        CKEDITOR.plugins.addExternal( 'save-to-pdf', 'https://rawgit.com/Api2Pdf/api2pdf.ckeditor4/master/plugins/save-to-pdf/', 'plugin.js' );
    </script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
   <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script>
    function printDiv(nombreDiv) {
     var contenido= document.getElementById(nombreDiv).innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;
}
    
</script>
<style>
    .page {table-layout:fixed; width: 21cm; min-height: 29.7cm; padding: 2cm; margin: 1cm auto; border: 1px #D3D3D3 solid; border-radius: 5px; background: white; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); }
    

</style>

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
 
  <?php  require_once 'conexion/bd.php'; ?>

  <!-- Content Wrapper. Contains page content -->
 
    <!-- Content Header (Page header) -->
    <section class="content-header border-0">
      <div class="container-fluid">
        
        
      </div><!-- /.container-fluid -->
    </section>
  
        <div class="row">
            
                  <style>
                            .card.card-body{ border:none; }

                             .btn-primary.focus, .btn-primary:focus { box-shadow:unset !important;}
                             
                             .btn.focus, .btn:focus{ box-shadow:unset !important;}
                    </style>
                
             
            
                <div  class="card-body page border-0" >
                     
                    <!-- aca inicia la vista de los datos de la factura-->
                    
                    <div class="row" >
                        
                         <input type="hidden" name="idOrdenCompra" value="<?php echo $_GET['pdf']; ?>">
                        <?php
                            $idOrdenCompra = $_GET['pdf']; //$_GET['pdf'];
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            
                           
                            
                            $consultandoProveedorSeleccionado=$mysqli->query("SELECT * FROM solicitudComprador WHERE idSolicitud='$idOrdenCompra' ");
                            $extraerDatosConsultaProveedorSeleccionado=$consultandoProveedorSeleccionado->fetch_array(MYSQLI_ASSOC);
                            $existenciaProveedor=$extraerDatosConsultaProveedorSeleccionado['proveedor'];
                            $userProv=$extraerDatosConsultaProveedorSeleccionado['idUsuario'];
                            $idSolicituCOmprador=$extraerDatosConsultaProveedorSeleccionado['id'];
                            $fechaActivada=$extraerDatosConsultaProveedorSeleccionado['fechaActivada'];
                            $fechaSolicitud=$extraerDatosConsultaProveedorSeleccionado['fecha'];
                            $fechaSolicitudActivada=$extraerDatosConsultaProveedorSeleccionado['fechaActivada'];
                            
                            $consultaUsuarioComprador=$mysqli->query("SELECT * FROM usuario WHERE id = '$userProv'");
                            $extraerDatosCompradorCompleto=$consultaUsuarioComprador->fetch_array(MYSQLI_ASSOC);
                            $usuarioCompras=$extraerDatosCompradorCompleto['nombres'].' '.$extraerDatosCompradorCompleto['apellidos'];
                            
                            $consultandoProveedor=$mysqli->query("SELECT * FROM proveedores WHERE id='$existenciaProveedor' ");
                            $extraerDatosConsultaProveedor=$consultandoProveedor->fetch_array(MYSQLI_ASSOC);
                            echo '<br>';
                            //echo '<b>RAZÓN SOCIAL</b> '.$extraerDatosConsultaProveedor['razonSocial'];
                           
                           $consultaProductos = $mysqli->query("SELECT * FROM solicitudAlistamiento WHERE idSolicitud='$idOrdenCompra' ORDER BY id");
                           
                              ?>
                              <input name="idAlistamiento[]" value="<?php echo $extraerConsulta['id'];?>" type="hidden">
                              
                            <tr>
                                <td><?php  
                                    $consultandoProductos=$mysqli->query("SELECT * FROM  proveedorProductos WHERE id='".$extraerConsulta['idProducto']."' ");
                                    $extraerProductos=$consultandoProductos->fetch_array(MYSQLI_ASSOC);
                                    
                                    $grupo=$mysqli->query("SELECT * FROM proveedoresProductoGrupo WHERE id='". $extraerProductos['grupo']."' ");
                                    $extraerGrupo=$grupo->fetch_array(MYSQLI_ASSOC);
                                     $extraerGrupo['grupo'];
                                    
                                    $subgrupo=$mysqli->query("SELECT * FROM proveedoresProductoSubGrupo WHERE id='". $extraerGrupo['sub']."' ");
                                    $extraerSubgrupo=$subgrupo->fetch_array(MYSQLI_ASSOC);
                                    
                                    
                                    
                                    ?>
                                </td>
                                <td><?php echo $extraerSubgrupo['grupo'];?></td>
                                
                                <td><?php 
                                    $consultandoProductos=$mysqli->query("SELECT * FROM  proveedorProductos WHERE id='".$extraerConsulta['idProducto']."' ");
                                    $extraerProductos=$consultandoProductos->fetch_array(MYSQLI_ASSOC);
                                     $extraerProductos['nombre'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                      $extraerProductos['identificador'];
                                    ?>
                                </td>
                                 <td>
                                    <?php
                                      $extraerProductos['codigo'];
                                    ?>
                                </td>
                                
                                <td>
                                </td>
                                
                                <td>
                                   
                                </td>
                               
                                 <td>
                                    <?php
                                    $enviarCantidad=$extraerConsulta['cantidad'];
                                     echo $extraerConsulta['cantidad'];
                                    ?>
                                </td>
                                <td>
                                </td>
                           
                        <div class="form-group col-md-12">
                            
                                <?php
                                if($idEncabezado != NULL){
                                    $queryEncabezado = $mysqli->query("SELECT * FROM encabezado WHERE id = '2' ");
                                    //$ConsultaOrdenCompra = $mysqli->query("SELECT * FROM ");
                                    $encabezado = $queryEncabezado->fetch_array(MYSQLI_ASSOC);
                                    echo $encabezado['encabezado'];
                                    
                                }else{
                                    $queryEncabezado = $mysqli->query("SELECT * FROM encabezado WHERE principal = '2' ");
                                    $encabezado = $queryEncabezado->fetch_array(MYSQLI_ASSOC);
                                    echo $encabezado['encabezado'];
                                    
                                }
                                
                                ?>
                            
                        </div>
                        
                        <style>
                            @media print {
                            .noPrint{
                            display:none;
                            }
                            }
                            h1{
                                      
                            }
                        </style>
                        
                       <div class="invoice p-3 mb-3">
                  <!-- title row -->
                  <div class="row">
                    <div class="col-12">
                      <h4>
                        <i class="fas fa-globe"></i> Fixwei.
                        <small class="float-right"><!--Date: 2/10/2014--></small>
                      </h4>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- info row -->
                  <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                      
                      <address>
                        Razón social: <strong><?php echo $extraerDatosConsultaProveedor['razonSocial'];?>.</strong><br>
                        Nit: <?php echo $extraerDatosConsultaProveedor['nit']; ?><br>
                        Teléfono: <?php echo $extraerDatosConsultaProveedor['telefono']; ?><br>
                        Ciudad: <?php  $extraerDatosConsultaProveedor['ciudad']; ?>
                        <?php 
                        //echo $extraerDatosConsultaProveedor['ciudad']; 
                        $resultado=$mysqli->query("SELECT municipios.id AS codigo,municipios.nombre AS Municipio, departamentos.nombre AS Departamento FROM municipios INNER JOIN departamentos ON municipios.departamento_id = departamentos.id AND municipios.id='".$extraerDatosConsultaProveedor['ciudad']."' ");
                        $rowCiudad = $resultado->fetch_array(MYSQLI_ASSOC);
                        echo $idCiudad = utf8_decode($rowCiudad['codigo']).'-';
                        echo $nombreDepartamento = ($rowCiudad['Departamento']).'-';
                        echo $codigoCiud = ($rowCiudad['Municipio']);
                            
                        ?>
                        <br>
                        Dirección: <?php echo ($extraerDatosConsultaProveedor['direccion']); ?><br>
                        <?php
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
                        ?>
                        Metódo de pago: <?php echo $mostrarMetodoPago; 
                        
                            $metodoPago=$extraerDatosConsultaProveedor['terminoPago'];
                            $tipoMetodoPago=$extraerDatosConsultaProveedor['tipo'];
                            ?>
                      </address>
                    </div>
                                <?php
                                $consultaSolicitudDeCompra = $mysqli->query("SELECT * FROM solicitudCompra WHERE id = '$idOrdenCompra'");
                                $extraerDatosSolicitud = $consultaSolicitudDeCompra->fetch_array(MYSQLI_ASSOC);
                                $DateAndTime = date('d-m-Y', time());  
                                ?>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                      
                      <address>
                        <strong>Orden de Compra # &nbsp;
                                <?php 
                               
                                    $count=$_POST['idOrdenCompra'];
                                    $consucutivo=$mysqli->query("SELECT * FROM consecutivoOC ORDER BY id ");
                                    while($extraerConsecutivo=$consucutivo->fetch_array()){
                                        
                                        if($extraerConsecutivo['aplicado'] == '1'){
                                        echo    $idSolicituCOmprador;
                                        }elseif($extraerConsecutivo['caracter'] == 'Fecha'){
                                        echo $fechaSolicitudActivada;
                                        }else{
                                        echo $extraerConsecutivo['caracter'];
                                        }
                                        echo '-';
                                       
                                    }
                                      $count++;
                                ?>
                        </strong><br>
                        Solicitud de Compra # <?php echo $idOrdenCompra; ?><br>
                        Fecha de emisión Orden de Compra: <?php echo $fechaSolicitud ; ?><br>
                        Comprador: <?php echo $usuarioCompras; ?>
                        <!--<br> Email: john.doe@example.com-->
                      </address>
                    </div>
                    <!-- /.col 
                    <div class="col-sm-4 invoice-col">
                      <b>Invoice #007612</b><br>
                      <br>
                      <b>Order ID:</b> 4F3S8J<br>
                      <b>Payment Due:</b> 2/22/2014<br>
                      <b>Account:</b> 968-34567
                    </div>
                     /.col -->
                  </div>
                  <!-- /.row -->
    
                  <!-- Table row -->
                  <div class="row">
                    <div class="col-12 table-responsive">
                      <table class="table table-striped">
                        <thead>
                        <tr>
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
                                        echo $extraerProductos['nombre'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $consultaidentificadorProducto=$mysqli->query("SELECT * FROM proveedoresProductoIdentificador WHERE id='".$extraerProductos['identificador']."' ");
                                        $traerDAtosconsultaidentificadorProducto=$consultaidentificadorProducto->fetch_array(MYSQLI_ASSOC);
                                        echo $traerDAtosconsultaidentificadorProducto['grupo'];
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
                                       
                                        
                                            
                                        <?php 
                                        $consultaImpuesto=$extraerConsulta['impuesto'];
                                        $validarImpuesto=$mysqli->query("SELECT * FROM proveedoresTipoImpuesto WHERE id='$consultaImpuesto' ");
                                        $extraerValidarImpuesto=$validarImpuesto->fetch_array(MYSQLI_ASSOC);
                                        $enviarImpuesto=$extraerValidarImpuesto['descripcion'];
                                        
                                         echo $extraerValidarImpuesto['grupo'].' '.$extraerValidarImpuesto['descripcion'].' %'; ?>
                                       
                                        
                                    </td>
                                   
                                     <td>
                                        <?php
                                        $enviarCantidad=$extraerConsulta['cantidad'];
                                         echo $extraerConsulta['cantidad'];
                                        ?>
                                    </td>
                                    
                                    <td>
                                        <?php echo '$'.(number_format($extraerConsulta['unitario']));?>
                                    </td>
                                     
                                    <td>
                                        <?php
                                             echo '$'.number_format($extraerConsulta['costos']);
                                             $costoPorUnidad=$extraerConsulta['costos'];
                                        ?>   
                                    </td>
                                   
                                    <td>
                                        <?php 
                                            
                                            $impuestoAplicado=$costoPorUnidad*($enviarImpuesto/100);
                                            echo '$'.number_format($impuestoAplicado);
                                            $enviarImpuesto; echo '';
                                        ?>   
                                    </td>
                                       
                                    <td>
                                        <?php
                                            echo '$'.number_format($costoPorUnidad+$impuestoAplicado);
                                        ?>
                                    </td>
                                </tr>    
                                <?php
                                $costoPorUnidadSumatoria2+=$extraerConsulta['costos'];
                                $impuestoAplicadoSumatora2+=$costoPorUnidad*($enviarImpuesto/100);
                                   
                               }
                          
                                                  
                           ?>
                        <input name="oc" value="<?php echo $extraerConsultaComprador['id'];?>" type="hidden">
                          
                          
                        
                     
                                
                        </tbody>
                      </table>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
    
                  <div class="row">
                    <!-- accepted payments column -->
                    <div class="col-6">
                      
                    </div>
                    <!-- /.col -->
                    <div class="col-6">
                      <!--<p class="lead">Amount Due 2/22/2014</p>-->
    
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td>$<?php echo number_format($costoPorUnidadSumatoria2); ?></td>
                          </tr>
                          <tr>
                            <th>Iva:</th>
                            <td>$<?php echo number_format($impuestoAplicadoSumatora2); ?></td>
                          </tr>
                          <tr>
                            <th>Total:</th>
                            <td>$<?php  echo number_format($costoPorUnidadSumatoria2+$impuestoAplicadoSumatora2);  ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
    
                  <!-- this row will not appear when printing -->
                  <div class="row no-print">
                    <div class="col-12">
                      <button type="button" id="action-button" onclick="window.print();return false;" class="btn btn-primary float-right" style="display:none;">
                        <i class="fas fa-print"></i> Imprimir
                      </button>
                    </div>
                  </div>
                </div> 
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
                       
                       
                      
                <?php
                $consultaComprador=$mysqli->query("SELECT * FROM `solicitudComprador` WHERE idSolicitud='".$idOrdenCompra."' ");
                $extraerConsultaComprador=$consultaComprador->fetch_array(MYSQLI_ASSOC);
                ?>
                
               
                    
                

                    
                     
                  
                </div>
                
                <!-- aca finaliza la vista de los datos de la factura-->
                
                
                
                        <?php
                         'IM'. $extrerImpuesto['descripcion'];
                     
                                     $consultaProductos = $mysqli->query("SELECT * FROM solicitudAlistamiento WHERE idSolicitud='$idOrdenCompra' ORDER BY id");
                                     $extraerConsulta=$consultaProductos->fetch_array(MYSQLI_ASSOC);
                          
                        ?>     
               <div class="form-group" >
                   
                   <div style="border-style:groove;border: 1px #D3D3D3 solid;" class="form-group"  >
                     <?php
                   
                       if($tipoMetodoPago == 'contado'){
                           $disabledContado='none';
                           $titulo='contado';   
                       }elseif($tipoMetodoPago == 'contraentrega'){
                           $disabledContraEntrega='none';
                           $titulo='contra entrega'; 
                       }elseif($tipoMetodoPago == 'otro'){
                           $disabledOtro='none';
                           $titulo='otro'; 
                           $descrpcion=$metodoPago;
                       }elseif($tipoMetodoPago == 'credito'){
                           $disabledCredito='none';
                           $titulo='crédito'; 
                           $descrpcion='Término de pago a '.$metodoPago.' días';
                           $cadenaespacio = '---------';
                       }
                           //echo '<b> &nbsp&nbspMétodo de pago '.$titulo;
                           //echo '<br>';
                            $ancho=130; 
                            if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { 
                              $eol="\r\n"; 
                            }elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { 
                              $eol="\r"; 
                            } else { 
                              $eol="\n"; 
                            } 
                             //$eol="\r\n";
                             $cad=wordwrap($titulo, $ancho, $eol, 1); 
                             $lineas=substr_count($cad,$eol)+1;
                               //echo '&nbsp&nbsp <b>Metodo De Pago: </b>&nbsp '.ucwords($titulo);
                               //echo '</b><br><br>';
                     
                       ?>
                 
                    
                    <?php
                      
                     $consultaPolitica = $mysqli->query("SELECT * FROM proveedorPoliticas");
                     $extraerPolitica=$consultaPolitica->fetch_array(MYSQLI_ASSOC);
                     $ancho=130; 
                     $nombrePolitica = $extraerPolitica['politica'];
                     if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { 
                      $eol="\r\n"; 
                    }elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { 
                      $eol="\r"; 
                    } else { 
                      $eol="\n"; 
                    } 
                     //$eol="\r\n";
                     $cad=wordwrap($nombrePolitica, $ancho, $eol, 1); 
                     $lineas=substr_count($cad,$eol)+1;
                     echo" <center><textarea readonly cols='$ancho' rows='$lineas' style='border-color:white;width:;Height:;font-size:14px;text-align: justify;' >".$nombrePolitica."</textarea></center>";
                   
                    ?>
                  <br>     
                  </div>
                 
               </div>
                
                </div>
               
               
           
            </div>
           
    
  
  </div>
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
<!-- Bootstrap4 Duallistbox -->
<script src="../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<script type="text/javascript">
	/*Con este script imprimo el informe*/
	function printDiv(nombreDiv) {
	    var contenido= document.getElementById(nombreDiv).innerHTML;
 	    var contenidoOriginal= document.body.innerHTML;
	    document.body.innerHTML = contenido;
	    window.print();
	    document.body.innerHTML = contenidoOriginal;
	}
</script>


<!--Ckeditor-->
<script>
    CKEDITOR.replace( 'editor1',
            {
                extraPlugins: 'save-to-pdf',
                pdfHandler: 'savetopdf/savetopdf.php'
            } );
</script>
</body>
</html>