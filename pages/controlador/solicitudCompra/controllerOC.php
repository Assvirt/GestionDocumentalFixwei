<?php

error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario


if(isset($_POST['Actualizar'])){
    $idAlistamiento=$_POST['idAlistamiento'];
    $impuesto=$_POST['impuesto'];
    $costo=$_POST['cantidad'];
    
     'Orden de compra: '.$idOrdenCompra=$_POST['idOrdenCompra'];
     '<br><br>';
    
    $updateSolicitud=$mysqli->query("UPDATE solicitudCompra SET modificacion='0' WHERE id='$idOrdenCompra' ");
    
    
    
    
    
    for ($i = 0, $j = 0, $k=0; $i<count($idAlistamiento), $j<count($impuesto), $k<count($costo); $i++,$j++,$k++){
         'Id alistamiento : '.$idAlistamiento[$i]; echo '<br>';
        
         
         /// consultamos la tabla de alistamiento para sacar las cantidades
          $consultaProductos = $mysqli->query("SELECT * FROM solicitudAlistamiento WHERE id='$idAlistamiento[$i]' ");
          $extraerConsulta=$consultaProductos->fetch_array(MYSQLI_ASSOC);
           'Cantidad: '.$cantidadProducto=$extraerConsulta['cantidad']; echo '<br>';
         /// END
         
         ///// traemos el impuesto predeterminado o seleccionado por el cliente
          'Id impuesto : '.$impuesto[$j]; 
            $validarImpuesto=$mysqli->query("SELECT * FROM proveedoresTipoImpuesto WHERE id='$impuesto[$j]' ");
            $extraerValidarImpuesto=$validarImpuesto->fetch_array(MYSQLI_ASSOC);
            ' -- % '.$convertirImpuestoP=($extraerValidarImpuesto['descripcion']/100);
             ' -- $ '.$convertirImpuestoC=($extraerValidarImpuesto['descripcion']/100)*($costo[$k]*$cantidadProducto);
         //// END
          '<br>';
         
         
         /// realizamos la operación para hacer los calculos y enviar los valores por una variable temporal
          'Id costo sin Iva : '.$calculoSIva=$cantidadProducto*$costo[$k]; echo '<br>';
          'Id costo con Iva : '.$calculoIva=$convertirImpuestoC+$costo[$k]*$cantidadProducto; echo '<br><br>';
         /// END
         
        //// tenemos los id de los productos de la tabla de alistamiento para actualizar el valor de costo
            $consultaActualizacionCosto = $mysqli->query("UPDATE solicitudAlistamiento SET costos='$calculoSIva', impuesto='".$extraerValidarImpuesto['id']."',unitario='$costo[$k]' WHERE id = '$idAlistamiento[$i]'")or die(mysqli_error($mysqli));
        //// END
         
         /// variables para enviar el total
         $sumaImpuestos+=($extraerValidarImpuesto['descripcion']/100)*($costo[$k]*$cantidadProducto);
         $sumaCalculoSIva+=$cantidadProducto*$costo[$k];
         
    }
    
     '<br> Impuesto:'.$sumaImpuestos;
     '<br>Subtotal :'.$sumaCalculoSIva;
     '<br>Total :'.$totales=$sumaImpuestos+$sumaCalculoSIva;
     
    // registramos el proveedor seeccionado a la orden de compra
    $mysqli->query("UPDATE solicitudCompradorTemporal SET proveedor='".$_POST['proveedor']."', total='$totales' WHERE idSolicitud='$idOrdenCompra' "); //solicitudComprador
    // END
                        ?>
      
                            <script>
                                    window.onload=function(){
                                       
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../registroValores" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="idOrdenCompra" value="<?php echo $idOrdenCompra; ?>">
                                <input type="hidden" name="impuestos" value="<?php echo $sumaImpuestos; ?>">
                                <input type="hidden" name="subtotal" value="<?php echo $sumaCalculoSIva; ?>">
                                <input name="proveedor" value="<?php echo $_POST['proveedor'];?>" type="hidden">
                            </form>
                            
                        <?php
}
if(isset($_POST['vistaPrevia'])){
     $idOrdenCompra=$_POST['idOrdenCompra'];
    
    $consultaTablaID=$mysqli->query("SELECT * FROM solicitudComprador WHERE idSolicitud = '$idOrdenCompra'");
    $extraerConsultaID=$consultaTablaID->fetch_array(MYSQLI_ASSOC);
    $ObtenerFecha=$extraerConsultaID['fecha'];
    
    if($ObtenerFecha != NULL){
        
    }else{
        
        date_default_timezone_set('America/Bogota');
         'Fecha:'.$fecha=date('Y-m-j');
        $consultaActualiza=$mysqli->query("UPDATE solicitudComprador SET fecha = '$fecha' WHERE idSolicitud = '$idOrdenCompra' ")or die(mysqli_error($mysqli));
        
    }
    
    ?>
      
                            <script>
                                    window.onload=function(){
                                       
                                       document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../registroValoresPDF" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>">
                                <input type="hidden" name="impuestos" value="<?php echo $sumaImpuestos; ?>">
                                <input type="hidden" name="subtotal" value="<?php echo $sumaCalculoSIva; ?>">
                                <input name="proveedor" value="<?php echo $_POST['proveedor'];?>" type="hidden">
                            </form>
                            
                        <?php
}

if(isset($_POST['notificar'])){
    $idOrdenCompra=$_POST['idOrdenCompra'];
    '<br>'.$usuario=$_POST['usuario'];
    '<br>'.$correo=$_POST['correo'];
    '<br>'.$razonSocial=$_POST['razonSocial'];
    $total=$_POST['total'];
    
    
   //// consultamos el temporal para hacer el insert en la tabla de comprador y enviar el procedimiento normal
   
   $solicituCompraTemporal=$mysqli->query("SELECT * FROM solicitudCompradorTemporal WHERE idSolicitud='$idOrdenCompra' ");
   $extraerTemporal=$solicituCompraTemporal->fetch_array(MYSQLI_ASSOC);
   
   //// realizamos el insert
    date_default_timezone_set('America/Bogota');
    $fecha1=date('Y-m-j'); 
    $consucutivoCnsultando=$mysqli->query("SELECT * FROM consecutivoOC WHERE caracter='Fecha' ORDER BY id ");
    $extraerFechaConsulta=$consucutivoCnsultando->fetch_array(MYSQLI_ASSOC);
    if($extraerFechaConsulta['id'] != NULL){ 
        $mysqli->query("INSERT INTO solicitudComprador (idSolicitud,idUsuario,estado,total,proveedor,aprobador,estadoAprobador,fechaActivada,fecha)VALUES('$idOrdenCompra','".$extraerTemporal['idUsuario']."','pendiente','".$extraerTemporal['total']."','".$extraerTemporal['proveedor']."','".$extraerTemporal['aprobador']."','".$extraerTemporal['estadoAprobador']."','".$extraerTemporal['fechaActivada']."', '$fecha1')  ")or die(mysqli_error($mysqli));
    }else{
        $mysqli->query("INSERT INTO solicitudComprador (idSolicitud,idUsuario,estado,total,proveedor,aprobador,estadoAprobador,fecha)VALUES('$idOrdenCompra','".$extraerTemporal['idUsuario']."','pendiente','".$extraerTemporal['total']."','".$extraerTemporal['proveedor']."','".$extraerTemporal['aprobador']."','".$extraerTemporal['estadoAprobador']."', '$fecha1')  ")or die(mysqli_error($mysqli));
    }
   
   $solicituCompra=$mysqli->query("SELECT * FROM solicitudComprador WHERE idSolicitud='$idOrdenCompra' ");
   $extraer=$solicituCompra->fetch_array(MYSQLI_ASSOC);
   $id=$extraer['id'];
   $fechaActivada=$extraer['fechaActivada'];
   
                                $consucutivo=$mysqli->query("SELECT * FROM consecutivoOC ORDER BY id ");
                                $string="";
                                while($extraerConsecutivo=$consucutivo->fetch_array()){
                                    
                                    if($extraerConsecutivo['aplicado'] == '1'){
                                        $string.=($id);
                                    }elseif($extraerConsecutivo['caracter'] == 'Fecha'){
                                        if($fechaActivada != NULL){
                                        $string.=($fechaActivada);
                                        }else{
                                         $string.=($fecha1);    
                                        }
                                    }else{
                                     echo '<br>';
                                     $string.=($extraerConsecutivo['caracter']);
                                    }
                                    $string .= "-";
                                }
                                $newStrinG=trim($string, '-');
                                $enviarOrdenCOmpra=$newStrinG;
    
    ///// notificar proveedor
     require '../usuarios/libreria/PHPMailerAutoload.php';

                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                             
                                            //Configuracion servidor mail
                                            require '../../correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correo);
                                            $mail->Subject = utf8_decode('Orden de compra N° '.$enviarOrdenCOmpra);
                                            //$mail->Body = $_POST['message'];
                                            
                                            $mail->Body = utf8_decode('
                                            <html>
                                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                            <title>HTML</title>
                                            </head>
                                            <body>
                                            <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                            
                                            <p>Estimados. <b><em>'.$razonSocial.', cordial saludo</em></b>.
                                            <br>
                                            <p>La orden de compra N° '.$enviarOrdenCOmpra.' ha sido asignada para su gestión </p>
                                            <br>
                                             Visualiza su orden de compra <a href="https://fixwei.com/plataforma/pages/proveedorPDF?pdf='.$idOrdenCompra.'">Link</a>
                                            <br><br>
                                            Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                            </p>
                                            </body>
                                            </html>
                                            '); 
                                            
                                            //Avisar si fue enviado o no y dirigir al index
                                           
                                            if ($mail->Send()) {
                                             
                                            } else {
                                               
                                            }
    
    
                                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$usuario' ");
                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']);
                                                        $correoResponsable=$columna['correo'];  echo '<br>';
                                                        $enviarIdUsuario=$columna['id'];  echo '<br>';
                                        
                                                            //Create a new PHPMailer instance
                                                            $mail = new PHPMailer();
                                                            $mail->IsSMTP();
                                                            
                                                            //Configuracion servidor mail
                                                            require '../../correoEnviar/contenido.php';
                                                            
                                                            //Agregar destinatario
                                                            $mail->isHTML(true);
                                                            $mail->AddAddress($correoResponsable);
                                                            $mail->Subject = utf8_decode('Orden de compra N° '.$enviarOrdenCOmpra);
                                                            //$mail->Body = $_POST['message'];
                                                            
                                                            $mail->Body = utf8_decode('
                                                            <html>
                                                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                                            <title>HTML</title>
                                                            </head>
                                                            <body>
                                                            <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                                            
                                                            <p>Estimados. <b><em>'.$razonSocial.', cordial saludo</em></b>.
                                                            <br>
                                                            <p>La orden de compra N° '.$enviarOrdenCOmpra.' ha sido asignada para su gestión <p>
                                                            <br>
                                                            Visualiza su orden de compra <a href="https://fixwei.com/plataforma/pages/proveedorPDF?pdf='.$idOrdenCompra.'">Link</a>
                                                            
                                                            <br><br>
                                                            Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                                            </p>
                                                            </body>
                                                            </html>
                                                            ');
                                                            
                                                            //Avisar si fue enviado o no y dirigir al index
                                                        
                                                            if ($mail->Send()) {
                                                            // echo 'Enviado';
                                                            } else {
                                        
                                                            }    
       
    
    $mysqli->query("UPDATE solicitudCompradorTemporal SET estado='ejecutado', correo='$usuario', total='$total' WHERE idSolicitud='$idOrdenCompra' ");
    $mysqli->query("UPDATE solicitudComprador SET estado='ejecutado', correo='$usuario', total='$total' WHERE idSolicitud='$idOrdenCompra' ");
    $mysqli->query("UPDATE solicitudCompra SET estado='Aprobado' WHERE id='$idOrdenCompra' ");
    
    
    
    /// update del metodo de pago del proveedor
    
    if($_POST['opcion'] == 'si'){
        if( $_POST['terminoPago'] == 'credito'){
             $terminoP=$_POST['terminoPagoNumeros'];
            //$mysqli->query("UPDATE proveedores SET tipo='credito',terminoPago='$terminoP' WHERE id='$idProveedor'")or die(mysqli_error($mysqli));
        }elseif($_POST['terminoPago'] == 'otro'){
           $terminoP=utf8_decode($_POST['otro']);  
        }else{
           $terminoP='0';
        }
        
         'Metodo Nuevo:'.$metodo = $_POST['terminoPago'];
         '<br>';
         'Proveedor:'.$idProveedor = $_POST['id'];
        
        // se actualiza el metodo de pago del proveedor
        
        $mysqli->query("UPDATE proveedores SET tipo='$metodo',terminoPago='$terminoP' WHERE id='$idProveedor'")or die(mysqli_error($mysqli));
       
        // end
    }else{
       
    }
    
    /// END
    
    
    ?>
      
                            <script>
                                    window.onload=function(){
                                       
                                       document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../solicitudComprador" method="POST" onsubmit="procesar(this.action);" >
                                <input name="validacionAgregar" value="1" type="hidden">
                            </form>
                            
                        <?php
}

if(isset($_POST['ultimo'])){
    $idOrdenCompra=$_POST['idOrdenCompra'];
    '<br>'.$usuario=$_POST['usuario'];
    '<br>'.$correo=$_POST['correo'];
    '<br>'.$razonSocial=$_POST['razonSocial'];
    $total=$_POST['total'];
    
   $solicituCompra=$mysqli->query("SELECT * FROM  solicitudCompradorTemporal WHERE idSolicitud='$idOrdenCompra' ");//solicitudComprador
   $extraer=$solicituCompra->fetch_array(MYSQLI_ASSOC);
   $id=$extraer['id'];
   $fechaActivada=$extraer['fechaActivada'];
   
                                $consucutivo=$mysqli->query("SELECT * FROM consecutivoOC ORDER BY id ");
                                $string="";
                                while($extraerConsecutivo=$consucutivo->fetch_array()){
                                    
                                    if($extraerConsecutivo['aplicado'] == '1'){
                                        $string.=($id);
                                    }elseif($extraerConsecutivo['caracter'] == 'Fecha'){
                                        $string.=($fechaActivada);
                                    }else{
                                        echo '<br>';
                                     $string.=($extraerConsecutivo['caracter']);
                                    }
                                    $string .= "-";
                                }
                                $newStrinG=trim($string, '-');
                                $enviarOrdenCOmpra=$newStrinG;
    
    ///// notificar proveedor
     require '../usuarios/libreria/PHPMailerAutoload.php';

    
                                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$usuario' ");
                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']);
                                                        $correoResponsable=$columna['correo'];  echo '<br>';
                                                        $enviarIdUsuario=$columna['id'];  echo '<br>';
                                        
                                                            //Create a new PHPMailer instance
                                                            $mail = new PHPMailer();
                                                            $mail->IsSMTP();
                                                            
                                                            //Configuracion servidor mail
                                                            require '../../correoEnviar/contenido.php';
                                                            
                                                            //Agregar destinatario
                                                            $mail->isHTML(true);
                                                            $mail->AddAddress($correoResponsable);
                                                            $mail->Subject = utf8_decode('Orden de compra N° '.$id); //$enviarOrdenCOmpra
                                                            //$mail->Body = $_POST['message'];
                                                            
                                                            $mail->Body = utf8_decode('
                                                            <html>
                                                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                                            <title>HTML</title>
                                                            </head>
                                                            <body>
                                                            <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                                            
                                                            <p>Estimados. <b><em>'.$nombreResponsable.', cordial saludo</em></b>.
                                                            <br>
                                                            <p>La orden de compra N° '.$id.' ha sido asignada para su gestión y verificación<p>
                                                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                            <br>
                                                            <em>Mi perfil --> mis pendientes --> Compras --> Verificar Orden de compra +</em>.
                                                            <br>
                                                            <br><br>
                                                            Este correo es informativo por tanto, le pedimos no responda este mensaje.
                                                            </p>
                                                            </body>
                                                            </html>
                                                            '); //$enviarOrdenCOmpra
                                                            
                                                            //Avisar si fue enviado o no y dirigir al index
                                                        
                                                            if ($mail->Send()) {
                                                            // echo 'Enviado';
                                                            } else {
                                        
                                                            }    
       
    
    $mysqli->query("UPDATE solicitudCompradorTemporal SET total='$total', aprobador='$usuario', estadoAprobador='Pendiente' WHERE idSolicitud='$idOrdenCompra' "); //solicitudComprador
  
    if($_POST['masivo'] != NULL){ // unicamente cuando viene por masivo
         $mysqli->query("UPDATE solicitudCompra SET estado='Orden de compra' WHERE id='$idOrdenCompra' ");
    }
    
    
    /// update del metodo de pago del proveedor
    
    if($_POST['opcion'] == 'si'){
        if( $_POST['terminoPago'] == 'credito'){
             $terminoP=$_POST['terminoPagoNumeros'];
            //$mysqli->query("UPDATE proveedores SET tipo='credito',terminoPago='$terminoP' WHERE id='$idProveedor'")or die(mysqli_error($mysqli));
        }elseif($_POST['terminoPago'] == 'otro'){
           $terminoP=utf8_decode($_POST['otro']);  
        }else{
           $terminoP='0';
        }
        
         'Metodo Nuevo:'.$metodo = $_POST['terminoPago'];
         '<br>';
         'Proveedor:'.$idProveedor = $_POST['id'];
        
        // se actualiza el metodo de pago del proveedor
        
        $mysqli->query("UPDATE proveedores SET tipo='$metodo',terminoPago='$terminoP' WHERE id='$idProveedor'")or die(mysqli_error($mysqli));
        
 
        // end
    }else{
        ////////// no se hace nada
    }
    
    /// END
    
    
    ?>
      
                            <script>
                                    window.onload=function(){
                                       
                                       document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../solicitudComprador" method="POST" onsubmit="procesar(this.action);" >
                                <input name="validacionAgregar" value="1" type="hidden">
                            </form>
                            
                        <?php
}

?>