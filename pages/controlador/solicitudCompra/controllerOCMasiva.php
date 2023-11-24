<?php

error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['AgregarSolicitud'])){
    
     'Id:'.$idUsuario = $_POST['idUsuario'];
     '<br>';
     'Fecha:'.$fechaSolicitud = $_POST['fechaSolicitud'];
     '<br>';
     'Contacto:'.$contacto = utf8_decode($_POST['contacto']);
     '<br>';
     'Tipo Compra:'.$tipoCompra = $_POST['tipoCompra'];
     '<br>';
     'Centro Trabajo:'.$centroTrabajo = $_POST['centroTrabajo'];
     '<br>';
     'Centro Costo:'. $centroCosto = json_encode($_POST['centroCostoS']);//$centroCosto = $_POST['centroCostoS'];
     '<br>';
     'Proceso:'.$proceso = $_POST['procesoS'];
     '<br>';
     'Contrato:'.$contrato = utf8_decode($_POST['contrato']);
     '<br>';
     'Observacion:'.$observacion = utf8_decode($_POST['observacion']);
     '<br>';
     'Tipo:'.$tipoBien = $_POST['tipoBien'];
     '<br>';
     $tiempo=$_POST['tiempo']; 
     $tipoSolicitud=$_POST['tipoSolicitud'];
                $mysqli->query("INSERT INTO solicitudCompra(fechaSolicitud,contacto,tipoCompra,centroTrabajo,centroCosto,proceso,contrato,observacion,TipoBS,idUsuario,estado,tiempo,tipoSolicitud)VALUES('$fechaSolicitud','$contacto','$tipoCompra','$centroTrabajo','$centroCosto','$proceso','$contrato','$observacion','$tipoBien','$idUsuario','Ejecucion','$tiempo','$tipoSolicitud')")or die(mysqli_error($mysqli));//'$ruta','$ruta2','$ruta3',
                //,archivo,archivo2,archivo3
    
                
                   $consultaUltimo=$mysqli->query("SELECT MAX(id) AS idSolicitudCompra FROM solicitudCompra WHERE idUsuario='$idUsuario' ");
                    $estraUltimo=$consultaUltimo->fetch_array(MYSQLI_ASSOC);
                    $idSC=$estraUltimo['idSolicitudCompra'];
                ?>
                    <script> 
                         window.onload=function(){
                       
                             document.forms["miformulario"].submit();
                         }
                    </script>
                     
                    <form name="miformulario" action="../../ordenCompraMasiva" method="POST" onsubmit="procesar(this.action);" >
                        <input name="idOrdenCompra" value="<?php echo $idSC;?>" type="hidden">
                        <input type="hidden" name="validacionAgregar" value="1">
                    </form> 
                <?php  
                
          
}
if(isset($_POST['Actualizar'])){
    $id=$_POST['id'];
     'Id:'.$idUsuario = $_POST['idUsuario'];
     '<br>';
     'Fecha:'.$fechaSolicitud = $_POST['fechaSolicitud'];
     '<br>';
      'Contacto:'.$contacto = utf8_decode($_POST['contacto']);
     '<br>';
     'Tipo Compra:'.$tipoCompra = $_POST['tipoCompra'];
     '<br>';
     'Centro Trabajo:'.$centroTrabajo = $_POST['centroTrabajo'];
     '<br>';
     'Centro Costo:'.$centroCosto = json_encode($_POST['centroCostoS']);//$centroCosto = $_POST['centroCosto'];
     '<br>';
     'Proceso:'.$proceso = $_POST['procesoS'];
     '<br>';
     'Contrato:'.$contrato = utf8_decode($_POST['contrato']);
     '<br>';
     'Observacion:'.$observacion = utf8_decode($_POST['observacion']);
      '<br>';
     'Tipo:'.$tipoBien = $_POST['tipoBien'];
     '<br>';
      'Archivo:'.$archivopdf = $_POST['archivopdf']['name'];
     //echo 'Archivo:';
     $tiempo=$_POST['tiempo']; 
     $tipoSolicitud=$_POST['tipoSolicitud'];
    $mysqli->query("UPDATE solicitudCompra SET fechaSolicitud ='$fechaSolicitud',contacto ='$contacto',tipoCompra='$tipoCompra',centroTrabajo='$centroTrabajo',centroCosto='$centroCosto',proceso='$proceso',contrato='$contrato',observacion='$observacion',TipoBS='$tipoBien', tiempo='$tiempo', tipoSolicitud='$tipoSolicitud' WHERE id='$id' ")or die(mysqli_error($mysqli));
  ?>     
   <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../ordenCompraMasiva" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionActualizar" value="1">
            </form> 
  <?php  
}


if(isset($_POST['Eliminar'])){
   
   
   
    $idElminacion = $_POST['id'];
    $ConsultaDocumento = $mysqli->query("SELECT * FROM uploads WHERE idSolicitudCompra='$idElminacion'");
    while($extraerConsultaDocumento= $ConsultaDocumento->fetch_array()){
    $IdOrden=$extraerConsultaDocumento['file_name'];
        $eliminacion=unlink('../../almacenamientoMultiple/uploads/'.$IdOrden);
    }
    
     $mysqli->query("DELETE FROM solicitudCompra WHERE id ='".$_POST['id']."'")or die(mysqli_error($mysqli));
     $mysqli->query("DELETE FROM solicitudAlistamiento WHERE idSolicitud ='".$_POST['id']."'")or die(mysqli_error($mysqli));
     $mysqli->query("DELETE FROM solicitudCompraFlujo WHERE idSolicitud ='".$_POST['id']."'")or die(mysqli_error($mysqli)); 
     $mysqli->query("DELETE FROM uploads WHERE idSolicitudCompra ='".$_POST['id']."'")or die(mysqli_error($mysqli));
   
     //echo 'Registro eliminado';
     ?>
            <script> 
                 window.onload=function(){
               
                    document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../solicitudCompra" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
<?php
}


if(isset($_POST['alistamiento'])){
    
    
    $porcentaje=$_POST['porcentaje'];
    $usuario=$_POST['usuario'];
     $idOrdenCompra=$_POST['idOrdenCompra'];
     '<br>Aprobador: '.$aprobador=$_POST['aprobador'];
     $total=$_POST['total'];

     // validamos si el total del porcentaje es igual a 100, en caso contrario nos debe avisar que no se puede
     for ($iA = 0, $jA = 0; $iA<count($porcentaje), $jA<count($usuario); $iA++, $jA++){
        $sumandoPorcentaje+=$porcentaje[$iA];
     }
     if($sumandoPorcentaje == '100'){  
                                    for ($i = 0, $j = 0; $i<count($porcentaje), $j<count($usuario); $i++, $j++){
                                          'Ingresar porcentaje : '.$porcentaje[$i]; 
                                          '--- y el usuario a notificar es : '.$usuario[$j]; 
                                          '<br>';
                                         
                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$usuario[$j]' ");
                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']);
                                        $correoResponsable=$columna['correo'];  echo '<br>';
                        
                                               
                                         
                                         $mysqli->query("INSERT INTO solicitudCompraFlujo (idUsuario,estado,rol,porcentaje,idSolicitud)VALUEs('$usuario[$j]','aprobado','1','$porcentaje[$i]','$idOrdenCompra')");
                                     
                                    }
                                    
                                    
                                    $mysqli->query("INSERT INTO solicitudCompraFlujo (idUsuario,rol,idSolicitud,estado)VALUES('$aprobador','2','$idOrdenCompra','ejecucion')");
                                 ?>
                                  <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../ordenCompraMasiva" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionAgregar" value="1">
                                    </form> 
                                 <?php
     }else{
          ?>
                                  <script> 
                                         window.onload=function(){
                                       
                                             document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../registroProductosMasvivos" method="POST" onsubmit="procesar(this.action);" >
                                        <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                                        <input type="hidden" name="validacionValidarPorcentaje" value="1">
                                    </form> 
                                 <?php
     }

}

if(isset($_POST['notificarComprador'])){
    
 date_default_timezone_set('America/Bogota'); 
//$fecha=date('Y-m-j h:i:s A');  
 $fecha=date('Y-m-j');
     'Orden Compra: '.$idOrdenCompra=$_POST['idOrdenCompra'];
    echo '<br>';
     'Usuario: '.$idUsuario =$_POST['idUsuario'];
    echo '<br>';
     'Comentario: '.$comentario =utf8_decode($_POST['comentario']);
    echo '<br>';
     'Estado: '.$estado=$_POST['opcion'];
    echo '<br>';
   
    
    $consultarAprobacionesPendienteFinal=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idSolicitud='$idOrdenCompra' AND rol='2' AND estado='pendiente' ");
    $extraerApribacionesPendienteFinal=$consultarAprobacionesPendienteFinal->fetch_array(MYSQLI_ASSOC);
    
    
     
        //require '../usuarios/libreria/PHPMailerAutoload.php';
        
        if($estado == 'aprobado'){
            $resultado='aprobado';
            $comprador=$_POST['comprador'];
            $total =$_POST['total'];
            
             /// si la fecha se encuentra activada, debe guardar la fecha que se genera la orden de compra
            date_default_timezone_set('America/Bogota'); 
            $fecha=date('Y-m-j');
            $consucutivoCnsultando=$mysqli->query("SELECT * FROM consecutivoOC WHERE caracter='Fecha' ORDER BY id ");
            $extraerFechaConsulta=$consucutivoCnsultando->fetch_array(MYSQLI_ASSOC);
            if($extraerFechaConsulta['id'] != NULL){
            $mysqli->query("INSERT INTO solicitudComprador (idSolicitud,idUsuario,estado,total,fechaActivada)VALUES('$idOrdenCompra','$comprador','pendiente','$total','$fecha')  ")or die(mysqli_error($mysqli));
            }else{
            $mysqli->query("INSERT INTO solicitudComprador (idSolicitud,idUsuario,estado,total)VALUES('$idOrdenCompra','$comprador','pendiente','$total')  ")or die(mysqli_error($mysqli));
            }
            $consultarUltimoRegistro=$mysqli->query("SELECT MAX(id) AS ordenCompra FROM solicitudComprador WHERE idSolicitud='$idOrdenCompra' AND idUsuario='$comprador' ");
            $extraerConsultaUltimRegistro=$consultarUltimoRegistro->fetch_array(MYSQLI_ASSOC);
            $enviarOrdenCOmpra=$extraerConsultaUltimRegistro['ordenCompra'];
            
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
                                         $string.=($fecha);    
                                        }
                                    }else{
                                     echo '<br>';
                                     $string.=($extraerConsecutivo['caracter']);
                                    }
                                    $string .= "-";
                                    /*
                                    
                                    if($extraerConsecutivo['aplicado'] == '1'){
                                        $string.=($enviarOrdenCOmpra);
                                    }elseif($extraerConsecutivo['caracter'] == 'Fecha'){
                                        $string.=$fecha;
                                    }else{
                                        echo '<br>';
                                     $string.=($extraerConsecutivo['caracter']);
                                    }
                                    $string .= "-";*/
                                }
                                $newStrinG=trim($string, '-');
                                $enviarOrdenCOmpra=$newStrinG;
                                 
            
            
            // si es aprobado notificamos al comprador
                                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$comprador' ");
                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']);
                                                        $correoResponsable=$columna['correo'];  echo '<br>';
                                                        $enviarIdUsuario=$columna['id'];  echo '<br>';
            
               //Create a new PHPMailer instance
                                                            /*$mail = new PHPMailer();
                                                            $mail->IsSMTP();
                                                            
                                                            //Configuracion servidor mail
                                                            require '../../correoEnviar/contenido.php';
                                                            
                                                            //Agregar destinatario
                                                            $mail->isHTML(true);
                                                            $mail->AddAddress($correoResponsable);
                                                            $mail->Subject = utf8_decode('Orden de compra # '.$enviarOrdenCOmpra);
                                                            //$mail->Body = $_POST['message'];
                                                            
                                                            $mail->Body = utf8_decode('
                                                            <html>
                                                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                                            <title>HTML</title>
                                                            </head>
                                                            <body>
                                                            <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                                            
                                                            <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                                                            <br>
                                                            <p>La solicitud # <b>'.$idOrdenCompra.'</b> fue aprobada y autorizada para su proceso de compra y la orden de compra # '.$enviarOrdenCOmpra.' ha sido asignada para su gestión.</p>
                                                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                            <br>
                                                            <em>Mi perfil --> mis pendientes --> Compras --> Orden de compra +</em>.
                                                            <br>
                                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
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
                                                        */
          
        
        
        }else{
            $resultado='rechazado';
        }
        
                   $consultamos=$mysqli->query("SELECT * FROM solicitudCompra WHERE id='$idOrdenCompra' ");
                   $extraerConsulta=$consultamos->fetch_array(MYSQLI_ASSOC);
                    
                     $usuario=$extraerConsulta['idUsuario'];
                                                
                                    if($resultado == 'aprobado'){
                                     $mensaje='';   
                                    }else{
                                      $mensaje='Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                                <br>
                                                <em>Mi perfil --> mis pendientes --> Compras --> Solicitud +</em>.
                                                <br>
                                                <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.';  
                                    }                
                                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$usuario' ");
                                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']);
                                                        $correoResponsable=$columna['correo'];  echo '<br>';
                                                        $enviarIdUsuario=$columna['id'];  echo '<br>';
                                        
                                                            //Create a new PHPMailer instance
                                                          /*  $mail = new PHPMailer();
                                                            $mail->IsSMTP();
                                                            
                                                            //Configuracion servidor mail
                                                            require '../../correoEnviar/contenido.php';
                                                            
                                                            //Agregar destinatario
                                                            $mail->isHTML(true);
                                                            $mail->AddAddress($correoResponsable);
                                                            $mail->Subject = utf8_decode('Gestión de solicitud # '.$idOrdenCompra);
                                                            //$mail->Body = $_POST['message'];
                                                            
                                                            $mail->Body = utf8_decode('
                                                            <html>
                                                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                                            <title>HTML</title>
                                                            </head>
                                                            <body>
                                                            <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                                            
                                                            <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                                                            <br>
                                                            <p>La solicitud # <b>'.$idOrdenCompra.'</b> fue '.$resultado.'.</p>
                                                            '.$mensaje.'
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
                                                            */
       
        if($estado == 'aprobado'){ //,  comentario='$comentario'
        $mysqli->query("UPDATE solicitudCompraFlujo SET estado='$estado' WHERE idSolicitud='$idOrdenCompra' AND rol='2' ")or die(mysqli_error($mysqli));
        $mysqli->query("UPDATE solicitudCompra SET estado='Ejecucion' WHERE id='$idOrdenCompra' ")or die(mysqli_error($mysqli));
        }
        if($estado == 'rechazado'){ //,  comentario='$comentario' 
        $mysqli->query("UPDATE solicitudCompraFlujo SET estado =NULL WHERE idSolicitud='$idOrdenCompra' AND rol='2' ")or die(mysqli_error($mysqli));
        $mysqli->query("UPDATE solicitudCompraFlujo SET estado='$estado' WHERE idSolicitud='$idOrdenCompra' AND rol='1' ")or die(mysqli_error($mysqli));
        }
        
        $mysqli->query("INSERT INTO solicitudCompraComentarios (idSolicitud,idUsuario,comentario,estado,fecha)VALUES('$idOrdenCompra','$idUsuario','$comentario','$estado','$fecha')  ")or die(mysqli_error($mysqli));
        
    
    
   ?>
                             <script> 
                                         window.onload=function(){
                                       
                                           document.forms["miformulario"].submit();
                                         }
                                    </script>
                                     
                                    <form name="miformulario" action="../../ordenCompraMasiva" method="POST" onsubmit="procesar(this.action);" >
                                        <input type="hidden" name="validacionActualizar" value="1">
                                    </form> 
                            
                            
                        <?php

}

if(isset($_POST['ActualizarF'])){
    
    $idAlistamiento=$_POST['idAlistamiento'];
    $impuesto=$_POST['impuesto'];
    $costo=$_POST['cantidad'];
    
     'Orden de compra: '.$idOrdenCompra=$_POST['idOrdenCompra'];
     '<br><br>';
    
    $updateSolicitud=$mysqli->query("UPDATE solicitudCompra SET modificacion='0' WHERE id='$idOrdenCompra' ");
    
    
    // registramos el proveedor seeccionado a la orden de compra
    $mysqli->query("UPDATE solicitudComprador SET proveedor='".$_POST['proveedor']."' WHERE idSolicitud='$idOrdenCompra' ");
    // END
    
    
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
         
         
         /// realizamos la operaci��n para hacer los calculos y enviar los valores por una variable temporal
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
     
                        ?>
      
                            <script>
                                    window.onload=function(){
                                       
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../registroValoresMasivo" method="POST" onsubmit="procesar(this.action);" >
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
                            <form name="miformulario" action="../../registroValoresPDFMasivo" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>">
                                <input type="hidden" name="impuestos" value="<?php echo $sumaImpuestos; ?>">
                                <input type="hidden" name="subtotal" value="<?php echo $sumaCalculoSIva; ?>">
                                <input name="proveedor" value="<?php echo $_POST['proveedor'];?>" type="hidden">
                            </form>
                            
                        <?php

}

?>