<?php
//////// traemos la bd
ini_set('display_errors', 1);
error_reporting(-1);
error_reporting(E_ERROR);
require_once '../../conexion/bd.php';

if(isset($_POST['solicitar'])){
     $admin=$_POST['admin'];
     $usuario=$_POST['usuario'];
     $pass=$_POST['pass'];
     $autorizacion=$_POST['autorizacion'];
     $nit=$_POST['nit'];
    
    $consulta=$mysqli->query("SELECT * FROM cliente ");
    $validacion=$consulta->fetch_array(MYSQLI_ASSOC);
    $autorizacionAdmin=$validacion['administrador'];
    $autorizacionUsuario=$validacion['usuario'];
    $autorizacionPass=$validacion['clave'];
    $autorizacionNit=$validacion['nit'];
    
    if($autorizacionAdmin == $admin && $autorizacionUsuario == $usuario && $autorizacionPass == $pass && $autorizacion == '1' && $autorizacionNit == $nit){
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../cliente" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="ingreso" value="1">
            </form> 
        <?php
    }else{
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../cliente" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="autorizacion" value="1">
            </form> 
        <?php
    }
}

if(isset($_POST['solicitando'])){
    $codigo=$_POST['codigo'];
    
    $consultaAdministrador=$mysqli->query("SELECT * FROM cliente ");
    $extraInfoAdministrador=$consultaAdministrador->fetch_array(MYSQLI_ASSOC);
    
    if($codigo == $extraInfoAdministrador['passautoriza'] ){
        
        date_default_timezone_set('America/Bogota');
        $fecha1=date('Y-m-j h:i:s A');
        
        function get_client_ip_env() {
            $ipaddress = '';
            if (getenv('HTTP_CLIENT_IP'))
                $ipaddress = getenv('HTTP_CLIENT_IP');
            else if(getenv('HTTP_X_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
            else if(getenv('HTTP_X_FORWARDED'))
                $ipaddress = getenv('HTTP_X_FORWARDED');
            else if(getenv('HTTP_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_FORWARDED_FOR');
            else if(getenv('HTTP_FORWARDED'))
                $ipaddress = getenv('HTTP_FORWARDED');
            else if(getenv('REMOTE_ADDR'))
                $ipaddress = getenv('REMOTE_ADDR');
            else
                $ipaddress = 'UNKNOWN';
        
            return $ipaddress;
        }

        function get_client_ip_server() {
            $ipaddress = '';
            if ($_SERVER['HTTP_CLIENT_IP'])
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            else if($_SERVER['HTTP_X_FORWARDED_FOR'])
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if($_SERVER['HTTP_X_FORWARDED'])
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            else if($_SERVER['HTTP_FORWARDED_FOR'])
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            else if($_SERVER['HTTP_FORWARDED'])
                $ipaddress = $_SERVER['HTTP_FORWARDED'];
            else if($_SERVER['REMOTE_ADDR'])
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            else
                $ipaddress = 'UNKNOWN';
        
            return $ipaddress;
        }
        
//echo 'IP address (usando get_client_ip_env function) es ' . get_client_ip_env() . '<br>';
//echo 'IP address (usando get_client_ip_server function) es ' . get_client_ip_server() . '<br>';

  $informacionCompleta="
    IP address (usando get_client_ip_env function) es " . get_client_ip_env() . "
    <br>
    IP address (usando get_client_ip_server function) es " . get_client_ip_server() . "
    <br>
    <br>
    El nombre del servidor es: {$_SERVER['SERVER_NAME']}<hr> 
    Vienes procedente de la p谩gina: {$_SERVER['HTTP_REFERER']}<hr> 
    Te has conectado usando el puerto: {$_SERVER['REMOTE_PORT']}<hr> 
    El agente de usuario de tu navegador es: {$_SERVER['HTTP_USER_AGENT']}
    ";

    $mysqli->query("UPDATE cliente SET hora='$fecha1', ip='$informacionCompleta' ")or die(mysqli_error($mysqli));
    
    ////// vaciar tablas
    $mysqli->query("TRUNCATE actas ")or die(mysqli_error($mysqli));
   // $mysqli->query("TRUNCATE actasPlantilla ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE actividades ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE agenda ")or die(mysqli_error($mysqli)); 
    $mysqli->query("TRUNCATE agendaEtiqueta ")or die(mysqli_error($mysqli));
    
    //$mysqli->query("TRUNCATE cargos ")or die(mysqli_error($mysqli));
    //$mysqli->query("TRUNCATE cargosasociados ")or die(mysqli_error($mysqli));
    //$mysqli->query("TRUNCATE centroCostos ")or die(mysqli_error($mysqli));
    //$mysqli->query("TRUNCATE centrodetrabajo ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE chat ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE chat_login_details ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE chat_message ")or die(mysqli_error($mysqli));
    //$mysqli->query("TRUNCATE chat_users ")or die(mysqli_error($mysqli)); no borrar Nunca
    //$mysqli->query("TRUNCATE codificacion ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE comentarioSolicitud ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE comnetariosRevision ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE compromisos ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE compromisosIndividuales ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE comunicaciones ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE comunicacionInterna ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE comunicacionInternaVer ")or die(mysqli_error($mysqli));
    //$mysqli->query("TRUNCATE ConectadoUsuario ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE controlCambioRegistros ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE controlCambios ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE controlCambiosCompromisos ")or die(mysqli_error($mysqli));
    
    //$mysqli->query("TRUNCATE cTrabajoUusuario ")or die(mysqli_error($mysqli));
   // $mysqli->query("TRUNCATE definicion ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE documento ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE documentoExterno ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE documentoExternoTipo ")or die(mysqli_error($mysqli));
    
    //$mysqli->query("TRUNCATE encabezado ")or die(mysqli_error($mysqli));
    //$mysqli->query("TRUNCATE grupo ")or die(mysqli_error($mysqli));
    //$mysqli->query("TRUNCATE grupoUcargo ")or die(mysqli_error($mysqli));
   // $mysqli->query("TRUNCATE grupoUcCosto ")or die(mysqli_error($mysqli)); 
   // $mysqli->query("TRUNCATE grupoUcTrabajo ")or die(mysqli_error($mysqli));
    
    //$mysqli->query("TRUNCATE grupoUusuario ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE indicadores ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE IndicadoresFormula ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE indicadoresGestionar ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE indicadoresMetas ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE indicadoresTipo ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE indicadoresUnidad ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE indicadoresVariables ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE indicadoresVariablesAsociadas ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE login ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE login_details ")or die(mysqli_error($mysqli));
    //$mysqli->query("TRUNCATE macroproceso ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE mensagens ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE mensajes ")or die(mysqli_error($mysqli));
    //$mysqli->query("TRUNCATE nivelcargo ")or die(mysqli_error($mysqli));
    
    //$mysqli->query("TRUNCATE normatividad ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE notificaciones ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE numeralNorma ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE perfiles ")or die(mysqli_error($mysqli));
   // $mysqli->query("TRUNCATE permisos ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE permisosNotificaciones ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE politicas ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE presupuesto ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE presupuestoGestionar ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE presupuestoGrupos ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE presupuestoGruposGastos ")or die(mysqli_error($mysqli));
   // $mysqli->query("TRUNCATE procesos ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE proveedorDocumentos ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE proveedores ")or die(mysqli_error($mysqli)); 
    $mysqli->query("TRUNCATE proveedoresGrupo ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE proveedorProductos ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE registros ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE repositorioArchivoSolicitud ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE repositorioCarpeta ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE repositorioCarpetaSolicitud ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE repositorioRegistro ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE solicitudCompra ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE solicitudCompraComentarios ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE solicitudCompraTipo ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE solicitudCompraUrgencia ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE solicitudDocumentos ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE tiempo ")or die(mysqli_error($mysqli));
   // $mysqli->query("TRUNCATE tipoDocumento ")or die(mysqli_error($mysqli));
   // $mysqli->query("TRUNCATE usuario ")or die(mysqli_error($mysqli));
   // $mysqli->query("TRUNCATE usuarioEliminado ")or die(mysqli_error($mysqli));
    
   // $mysqli->query("TRUNCATE usuarios ")or die(mysqli_error($mysqli));
   // $mysqli->query("TRUNCATE versionamiento ")or die(mysqli_error($mysqli));
    
    
    //// Eliminaci贸n de documentos en el archivo
    $files = glob('../../archivos/actas/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file)) 
        unlink($file); //elimino el fichero
        
        function deleteDirectory($dir) {
            if(!$dh = @opendir($dir)) return;
            while (false !== ($current = readdir($dh))) {
                if($current != '.' && $current != '..') {
                    echo 'Se ha borrado el archivo '.$dir.'/'.$current.'<br/>';
                    if (!@unlink($dir.'/'.$current)) 
                        deleteDirectory($dir.'/'.$current);
                }       
            }
            closedir($dh);
            echo 'Se ha borrado el directorio '.$dir.'<br/>';
            @rmdir($dir);
            
            
          
            
        }
        
        $dir = "../../archivos/actas/.";
        $dir = $dir."/";
        deleteDirectory($dir);
        
    }
    $files = glob('../../archivos/compras/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
    $filesCompromisos = glob('../../archivos/compromisos/*'); //obtenemos todos los nombres de los ficheros
   
    foreach($filesCompromisos as $fileCompromisos){
        if(is_file($fileCompromisos)) 
        unlink($fileCompromisos); //elimino el fichero
        
        
        
        function deleteDirectory($dir) {
            if(!$dh = @opendir($dir)) return;
            while (false !== ($current = readdir($dh))) {
                if($current != '.' && $current != '..') {
                    echo 'Se ha borrado el archivo '.$dir.'/'.$current.'<br/>';
                    if (!@unlink($dir.'/'.$current)) 
                        deleteDirectory($dir.'/'.$current);
                }       
            }
            closedir($dh);
            echo 'Se ha borrado el directorio '.$dir.'<br/>';
            @rmdir($dir);
            
            
          
            
        }
        
        $dir = "../../archivos/compromisos/.";
        $dir = $dir."/";
        deleteDirectory($dir);
        
        
    }
    /*
    
    
    $files = glob('../../archivos/documentoProveedor/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
    $files = glob('../../archivos/documentos/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
    $files = glob('../../archivos/documentosExternos/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
    $files = glob('../../archivos/img/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
    $files = glob('../../archivos/indicadores/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
    $files = glob('../../archivos/plantillasTipoDocumento/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
    $files = glob('../../archivos/registros/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
   
    
    $files = glob('../../archivos/repositorio/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
    $files = glob('../../archivos/solicitudes/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }*/
    $files = glob('../../raiz/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
        function deleteDirectory($dir) {
            if(!$dh = @opendir($dir)) return;
            while (false !== ($current = readdir($dh))) {
                if($current != '.' && $current != '..') {
                    echo 'Se ha borrado el archivo '.$dir.'/'.$current.'<br/>';
                    if (!@unlink($dir.'/'.$current)) 
                        deleteDirectory($dir.'/'.$current);
                }       
            }
            closedir($dh);
            echo 'Se ha borrado el directorio '.$dir.'<br/>';
            @rmdir($dir);
            
            
          
            
        }
        
        $dir = "../../raiz/.";
        $dir = $dir."/";
        deleteDirectory($dir);
    }
    // END
    
    
    /// Archivos de importaci贸n
    $files = glob('../../importacion/importar-cargos/subidas/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
    $files = glob('../../importacion/importar-centroCostos/subidas/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
    $files = glob('../../importacion/importar-centrodetrabajo/subidas/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
    $files = glob('../../importacion/importar-definicion/subidas/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
    $files = glob('../../importacion/importar-macroproceso/subidas/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
    $files = glob('../../importacion/importar-normatividad/subidas/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
    $files = glob('../../importacion/importar-procesos/subidas/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
    $files = glob('../../importacion/importar-proveedor/subidas/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
    $files = glob('../../importacion/importar-proveedor-productos/subidas/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
    $files = glob('../../importacion/importar-usuario/subidas/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file))
        unlink($file); //elimino el fichero
    }
    //// END
        ?>
            <script> 
                 window.onload=function(){
               
            //         document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../cliente" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="autorizado" value="1">
            </form> 
        <?php
        
    }else{
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../cliente" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="autorizacionRechazo" value="1">
            </form> 
        <?php
    }
}

if(isset($_POST['solicitudIP'])){
    $auctoirzandoSesionIp=$_POST['sesionIP'];
    
    
    if($auctoirzandoSesionIp == 'activar'){
        ///200.89.255.183
        $direccionIPEmpresa=$_SERVER['REMOTE_ADDR'];
        //$direccionIPEmpresa='200.89.255.183';
        $mysqli->query("UPDATE cliente SET registroIP='$direccionIPEmpresa', sesion='Si' ");
        $mysqli->query("UPDATE usuario SET sesionIP='$direccionIPEmpresa' ");
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../cliente" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="activado" value="1">
            </form> 
        <?php
    }
    
    if($auctoirzandoSesionIp == 'descativar'){
        $mysqli->query("UPDATE cliente SET registroIP='NULL', sesion='No' ");
        $mysqli->query("UPDATE usuario SET sesionIP='NULL', descripcionPermiso='NULL', estadoPermiso='NULL' ");
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../cliente" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="desactivado" value="1">
            </form> 
        <?php
    }
    
}

if(isset($_POST['solicitarPermiso'])){
 ///////////// validamos y aturoizamos a la persona que se le otorgo el permiso
    $ccSolicitandoUsuario=$_POST['cedulaPeticion'];
    $updateSolicitud=$mysqli->query("UPDATE usuario SET estadoPermiso='Aprobado', sesionIP='NULL'  WHERE cedula='$ccSolicitandoUsuario'  ");
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../clientePermisos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="notificacionAutorizacion" value="1">
            </form> 
        <?php
///// END
    
}
if(isset($_POST['solicitarPermisoRestablecer'])){
 ///////////// validamos y aturoizamos a la persona que se le otorgo el permiso
    $ccSolicitandoUsuario=$_POST['cedulaPeticion'];
    $direccionIPEmpresa=$_SERVER['REMOTE_ADDR'];
    //$direccionIPEmpresa='200.89.255.183';
    $updateSolicitud=$mysqli->query("UPDATE usuario SET estadoPermiso='NULL', descripcionPermiso='NULL', sesionIP='$direccionIPEmpresa'  WHERE cedula='$ccSolicitandoUsuario'  ");
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../clientePermisos" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="notificacionAutorizacionB" value="1">
            </form> 
        <?php
///// END
    
}
                    
?>
