<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
//require_once 'inactividad.php';


$celdulaUser = $_SESSION['session_username']; 
$cargoID = $_SESSION['session_cargo']; 
$idUsuario = $_SESSION['session_idUsuario'];

?>
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
<body class="hold-transition sidebar-mini">
<div class="wrapper">


  <!-- Main Sidebar Container -->
  <?php  require_once'menu.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header border-1">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ver orden de compra</h1>
            <br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Ver orden de compra</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm">
                            <!--<button type="button" class="btn btn-block btn-info btn-sm"><a href="solicitudCompra"><font color="white"><i class="fas fa-list"></i> Listar Orden de compra</font></a></button>-->
                            
                                            
                           
                            <!--
                                <input type="hidden" name="impuestos" value="<?php //echo $sumaImpuestos; ?>">
                                <input type="hidden" name="subtotal" value="<?php //echo $sumaCalculoSIva; ?>">
                                <input name="proveedor" value="<?php// echo $_POST['proveedor'];?>" type="hidden">
                                
                            -->
                         <div class="col-sm">
                            <form action="registroValoresMasivo" method="post">
                             <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                             <button type="submit" class="btn btn-block btn-success btn-sm"><font color="white"><i class="fas fa-list"></i> Regresar</font></button>
                            </form>   
                        </div> 
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
        </div>
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
                        
                         <input type="hidden" name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>">
                        <?php
                            $idOrdenCompra = $_POST['idOrdenCompra'];
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            
                           
                            
                            $consultandoProveedorSeleccionado=$mysqli->query("SELECT * FROM solicitudComprador WHERE idSolicitud='$idOrdenCompra' ");
                            $extraerDatosConsultaProveedorSeleccionado=$consultandoProveedorSeleccionado->fetch_array(MYSQLI_ASSOC);
                            $existenciaProveedor=$extraerDatosConsultaProveedorSeleccionado['proveedor'];
                            $userProv=$extraerDatosConsultaProveedorSeleccionado['idUsuario'];
                            $idSolicituCOmprador=$extraerDatosConsultaProveedorSeleccionado['id'];
                            $fechaActivada=$extraerDatosConsultaProveedorSeleccionado['fechaActivada'];
                            $fechaSolicitud=$extraerDatosConsultaProveedorSeleccionado['fecha'];
                            
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
                        
                       
                      
                        <span style="">
                            
                            &nbsp<b> Razón Social:&nbsp;</b> <?php echo $extraerDatosConsultaProveedor['razonSocial'];?> 
                            <br>
                            &nbsp<b> NIT:&nbsp;</b><?php echo $extraerDatosConsultaProveedor['nit']; ?>
                            <br>
                            &nbsp<b> Teléfono:&nbsp;</b><?php echo $extraerDatosConsultaProveedor['telefono']; ?>
                            <br>
                            &nbsp<b> Ciudad:&nbsp;</b><?php echo $extraerDatosConsultaProveedor['ciudad']; ?>
                            <br>
                            &nbsp<b> Dirección: &nbsp;</b><?php echo ($extraerDatosConsultaProveedor['direccion']); ?>
                            
                            
                            <br>
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
                            &nbsp;&nbsp;<b>Metódo de pago</b> <?php echo $mostrarMetodoPago; ?>
                    
                            <?php
                            $metodoPago=$extraerDatosConsultaProveedor['terminoPago'];
                            $tipoMetodoPago=$extraerDatosConsultaProveedor['tipo'];
                            ?>
                        </span>
                        
                        <span type="hidden" style="align:right;width:190px;text-align:right;">
                        </span>
                        
                        <span style="">
                            <?php
                            $consultaSolicitudDeCompra = $mysqli->query("SELECT * FROM solicitudCompra WHERE id = '$idOrdenCompra'");
                            $extraerDatosSolicitud = $consultaSolicitudDeCompra->fetch_array(MYSQLI_ASSOC);
                            $DateAndTime = date('d-m-Y', time());  
                            
                            ?>
                            <br>
                            
                            &nbsp;<b> Orden de Compra # &nbsp;
                            <?php 
                           
                             
                                $consucutivo=$mysqli->query("SELECT * FROM consecutivoOC ORDER BY id ");
                                while($extraerConsecutivo=$consucutivo->fetch_array()){
                                    
                                    if($extraerConsecutivo['aplicado'] == '1'){
                                    echo    $idSolicituCOmprador;
                                    }elseif($extraerConsecutivo['caracter'] == 'Fecha'){
                                    echo $fechaActivada;
                                    }else{
                                    echo $extraerConsecutivo['caracter'];
                                    }
                                    echo '-';
                                }
                            ?></b>
                            <br>
                            &nbsp;<b> Solicitud de Compra # <?php echo $idOrdenCompra; ?>&nbsp</b>
                            <br>
                            &nbsp;<b> Fecha de emisión Orden de Compra:&nbsp;</b> <?php echo $fechaSolicitud ; ?>
                            <br>
                            &nbsp;<b> Comprador:&nbsp;</b><?php echo $usuarioCompras; ?>

                        </span>
                        
                        <style>
                                   @media print {
                                      .noPrint{
                                        display:none;
                                      }
                                    }
                                    h1{
                                      
                                    }
                            </style>
                        
                       
                        <div class="form-group col-md-6">
                        </div>
                        
                        <div class="form-group col-md-6">
                            <br>
                            <br>
                            <button align="right" media="print" onclick="window.print();return false;" class="btn btn-primary btn-raised float-right noPrint" style="color:white;"><i class="fas fa-print"></i> Imprimir</button>
                            
                        </div>
                      
                      
                         <?php
                $consultaComprador=$mysqli->query("SELECT * FROM `solicitudComprador` WHERE idSolicitud='".$idOrdenCompra."' ");
                $extraerConsultaComprador=$consultaComprador->fetch_array(MYSQLI_ASSOC);
                ?>
                
                 <table style="border-style:groove;border: 5px #D3D3D3 solid;"  class="table-head-fixed text-center" > 
                            
                            <thead>
                                <tr>
                               
                                <th>Producto</th>
                                <th>Identificador</th>
                                <th>Código</th>
                                <th>Tipo producto</th>
                                <th>Impuesto</th>
                                <th>Cantidad</th>
                                 <th><font color="white">--</font></th>
                                <th>V.Unitario</th>
                                <th><font color="white">--</font></th>
                                <th>Subtotal</th>
                                 <th><font color="white">--</font></th>
                                <th>Iva</th>
                                 <th><font color="white">--</font></th>
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
                                <td></td>
                                <td>
                                    <?php echo '$'.(number_format($extraerConsulta['unitario']));?>
                                </td>
                                 <td></td>
                                <td>
                                    <?php
                                         echo '$'.number_format($extraerConsulta['costos']);
                                         $costoPorUnidad=$extraerConsulta['costos'];
                                    ?>   
                                </td>
                                 <td></td>
                                <td>
                                    <?php 
                                        
                                        $impuestoAplicado=$costoPorUnidad*($enviarImpuesto/100);
                                        echo '$'.number_format($impuestoAplicado);
                                        $enviarImpuesto; echo '';
                                    ?>   
                                </td>
                                   <td></td>   
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
                    
                <input name="oc" value="<?php echo $extraerConsultaComprador['id'];?>" type="hidden">
                      
                      
                    
                 
                                    <?php
                                          '$'.number_format($extraerConsulta['costos']);
                                         $costoPorUnidad=$extraerConsulta['costos'];
                                   
                                        
                                        $impuestoAplicado=$costoPorUnidad*($enviarImpuesto/100);
                                         '$'.number_format($impuestoAplicado);
                                         
                                  
                                         '$'.number_format($costoPorUnidad+$impuestoAplicado);
                                  
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
                                
                            </div>
                            
                        
                         
                                                 
                        </div>
                  
                </div>
                
                <!-- aca finaliza la vista de los datos de la factura-->
                
                
                
                        <?php
                         'IM'. $extrerImpuesto['descripcion'];
                     
                                     $consultaProductos = $mysqli->query("SELECT * FROM solicitudAlistamiento WHERE idSolicitud='$idOrdenCompra' ORDER BY id");
                                     $extraerConsulta=$consultaProductos->fetch_array(MYSQLI_ASSOC);
                          
                        ?>     
               <div class="form-group" >
                   
                   <div style="border-style:groove;border: 5px #D3D3D3 solid;" class="form-group"  >
                    
                    
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
                  
                   <form action="controlador/solicitudCompra/controllerOC" method="post"> <!-- controlador/solicitudCompra/controllerOC -->
                   <input name="masivo" value="1" type="hidden">
                   <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">  
                   <input name="correo" value="<?php echo $extraerDatosConsultaProveedor['email']; ?>" type="hidden"> 
                   <input name="razonSocial" value="<?php echo $extraerDatosConsultaProveedor['razonSocial']; ?>" type="hidden">
                   <input type="hidden" name="total" value="<?php echo ($costoPorUnidadSumatoria+$impuestoAplicadoSumatora); ?>">
                   <input type="hidden" name="id" value="<?php echo $extraerDatosConsultaProveedor['id'];?>">
                   <label class="no-print">Notificar al proveedor: </b> <?php echo $extraerDatosConsultaProveedor['email'];  ?></label>
                   <br>
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
                   }
                   
                   echo '<b>Método de pago '.$titulo;
                   echo '<br>';
                   echo $descrpcion;
                   echo '</b><br><br>';
                   ?>
                   <br>
                  <div  class="form-group no-print">
                      <label>¿ Desea cambiar el método de pago ?</label>
                      Si&nbsp;&nbsp;<input id="respuesta" name="opcion" value="si" type="radio" required>
                      No&nbsp;&nbsp;<input id="opcion2" name="opcion" value="no" type="radio" required>
                      
                      <div id="opcionesMetodo" style="display:none;">
                           
                            <label style="display:<?php echo $disabledCredito;?>;">Crédito</label> <input style="display:<?php echo $disabledCredito;?>;" id="habilitarCredito" type="radio" name="terminoPago" value="credito"  >&nbsp;&nbsp;
                            
                            <label style="display:<?php echo $disabledContado;?>;">Contado</label> <input style="display:<?php echo $disabledContado;?>;" id="habilitarContado" type="radio" name="terminoPago" value="contado"  >&nbsp;&nbsp;
                            
                            <label style="display:<?php echo $disabledContraEntrega;?>;">Contraentrega</label> <input style="display:<?php echo $disabledContraEntrega;?>;" id="habilitarContraEntrefa" type="radio" name="terminoPago"  value="contraentrega" >&nbsp;&nbsp;
                            
                            <label style="display:<?php echo $disabledOtro;?>;">Otro</label> <input style="display:<?php echo $disabledOtro;?>;" id="habilitarOtro" type="radio" name="terminoPago"  value="otro" >
                      </div>
                      <div class="form-group col-sm-6"> 
                            <label style="display:none;" id="nd">Número de días</label>
                            <label style="display:none;" id="io">Ingrese otro método de pago</label>
                            <input type="number" style="display:none;" id="mostrar" value="" class="form-control" name="terminoPagoNumeros" placeholder="Días" min="" >
                            <br>
                            
                            <input type="text" style="display:none;" id="otro" class="form-control" value="" name="otro" placeholder="Ingrese metodo de pago" >
                            
                          <script>
                                $(document).ready(function(){
                                    $('#respuesta').click(function(){
                                        document.getElementById('opcionesMetodo').style.display = '';
                                        document.getElementById("habilitarCredito").setAttribute("required","any"); 
                                        document.getElementById("habilitarContado").setAttribute("required","any"); 
                                        document.getElementById("habilitarContraEntrefa").setAttribute("required","any"); 
                                        document.getElementById("habilitarOtro").setAttribute("required","any"); 
                                        //document.getElementById("select_encargadoE").removeAttribute("required","any");
                                      
                                    });
                                    $('#opcion2').click(function(){
                                        document.getElementById('opcionesMetodo').style.display = 'none';
                                        document.getElementById('mostrar').style.display = 'none';
                                        document.getElementById('nd').style.display = 'none';
                                        document.getElementById('otro').style.display = 'none';
                                        document.getElementById('io').style.display = 'none';
                                        document.getElementById("mostrar").removeAttribute("required","any");
                                        document.getElementById("otro").removeAttribute("required","any");
                                        
                                    });
                                });
                            
                                $(document).ready(function(){
                                    $('#habilitarCredito').click(function(){ 
                                        document.getElementById('mostrar').style.display = '';
                                        document.getElementById('otro').style.display = 'none';
                                        document.getElementById('nd').style.display = '';
                                        document.getElementById('io').style.display = 'none';
                                        document.getElementById("mostrar").setAttribute("required","any");
                                        document.getElementById("otro").removeAttribute("required","any");
                                    });
                                    $('#habilitarContado').click(function(){  
                                        document.getElementById('mostrar').style.display = 'none';
                                        document.getElementById('otro').style.display = 'none';
                                        document.getElementById('nd').style.display = 'none';
                                        document.getElementById('io').style.display = 'none';
                                        document.getElementById("mostrar").removeAttribute("required","any");
                                        document.getElementById("otro").removeAttribute("required","any");
                                    });
                                    $('#habilitarContraEntrefa').click(function(){ 
                                        document.getElementById('mostrar').style.display = 'none';
                                        document.getElementById('otro').style.display = 'none';
                                        document.getElementById('nd').style.display = 'none';
                                        document.getElementById('io').style.display = 'none';
                                        document.getElementById("mostrar").removeAttribute("required","any");
                                        document.getElementById("otro").removeAttribute("required","any");
                                    });
                                    $('#habilitarOtro').click(function(){ 
                                        document.getElementById('otro').style.display = '';
                                        document.getElementById('mostrar').style.display = 'none';
                                        document.getElementById('nd').style.display = 'none';
                                        document.getElementById('io').style.display = '';
                                        document.getElementById("mostrar").removeAttribute("required","any");
                                        document.getElementById("otro").setAttribute("required","any"); 
                                    });
                                  
                                });
                            </script>
                         </div>
                      
                  </div>
                   <?php
                /// validamos si el usuario tiene el permiso del grupo de distribución
                $permisoHabilitado=$mysqli->query("SELECT * FROM `permisos` WHERE formulario='aprobacionOC' AND listar='1'");
                $extrerPermisoHabilitado=$permisoHabilitado->fetch_array(MYSQLI_ASSOC);
                $idPermisosGrupo=$extrerPermisoHabilitado['idGrupo'];
                
                
                $consultaGrupoExistenteValidacion=$mysqli->query("SELECT * FROM `grupoUusuario` WHERE idGrupo='$idPermisosGrupo' AND idUsuario='$cc' ");
                $extraerValidacionGrupo=$consultaGrupoExistenteValidacion->fetch_array(MYSQLI_ASSOC);
                $habilitarPermisoBotonGrupo=$extraerValidacionGrupo['id'];
                
                if($habilitarPermisoBotonGrupo != NULL){
                ?>
                <div  class="form-group no-print">
                      <label>Aprobador:</label>
                      <select class="form-control" type="text" name="usuario" required style="width:500px;">
                          <option value=""></option>
                          	<?php 
                          	 $acentos = $mysqli->query("SET NAMES 'utf8'");
                          	$consultausuarios=$mysqli->query("SELECT * FROM usuario ORDER BY nombres ");
                          	while ($columna = $consultausuarios->fetch_array()) { 
                          	?>
                          <option class="form-control" value="<?php echo $columna['id']; ?>"><?php echo $columna['nombres'].' '.$columna['apellidos']; ?> </option>
                          <?php } ?>
                         
                      </select>
                       
                    </div>
                    <button type="submit" name="ultimo" class="btn btn-block btn-success btn-sm no-print" style="width:25%;"><font color="white"><i class="fas fa-bell"></i> Verificación</font></button>
                    
                <?php
                }else{
                ?>
                  <div  class="form-group no-print">
                      <label>Correo con copia a:</label>
                      <select class="form-control" type="text" name="usuario" required style="width:500px;">
                          <option value=""></option>
                          	<?php 
                          	 $acentos = $mysqli->query("SET NAMES 'utf8'");
                          	$consultausuarios=$mysqli->query("SELECT * FROM usuario ORDER BY nombres ");
                          	while ($columna = $consultausuarios->fetch_array()) { 
                          	?>
                          <option class="form-control" value="<?php echo $columna['id']; ?>"><?php echo $columna['nombres'].' '.$columna['apellidos']; ?> </option>
                          <?php } ?>
                         
                      </select>
                       
                    </div>
                    <button type="submit" name="notificar" class="btn btn-block btn-warning btn-sm no-print" style="width:25%;"><font color="white"><i class="fas fa-bell"></i> Notificar</font></button>
                    
                <?php
                }
                ?>     
                     
                    
                    </form>
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
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
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