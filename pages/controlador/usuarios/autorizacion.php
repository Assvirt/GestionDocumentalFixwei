<?php
//////// traemos la bd
ini_set('display_errors', 1);
error_reporting(0);
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
    Vienes procedente de la página: {$_SERVER['HTTP_REFERER']}<hr> 
    Te has conectado usando el puerto: {$_SERVER['REMOTE_PORT']}<hr> 
    El agente de usuario de tu navegador es: {$_SERVER['HTTP_USER_AGENT']}
    ";

    $mysqli->query("UPDATE cliente SET hora='$fecha1', ip='$informacionCompleta' ")or die(mysqli_error($mysqli));
    
    ////// vaciar tablas
    $mysqli->query("TRUNCATE actas ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE actasPlantilla ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE actividades ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE agenda ")or die(mysqli_error($mysqli)); 
    $mysqli->query("TRUNCATE agendaEtiqueta ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE cargos ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE cargosasociados ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE centroCostos ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE centrodetrabajo ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE chat ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE chat_login_details ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE chat_message ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE chat_users ")or die(mysqli_error($mysqli)); //no borrar Nunca
    $mysqli->query("TRUNCATE codificacion ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE comentarioSolicitud ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE comnetariosRevision ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE compromisos ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE compromisosIndividuales ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE comunicaciones ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE comunicacionInterna ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE comunicacionInternaVer ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE ConectadoUsuario ")or die(mysqli_error($mysqli));
    //$mysqli->query("TRUNCATE consecutivoDocumento ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE consecutivoOC ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE controlCambioRegistros ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE controlCambios ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE controlCambiosFlujo ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE controlCambiosCompromisos ")or die(mysqli_error($mysqli));
    //$mysqli->query("TRUNCATE controlCambiosParametrizacion ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE cTrabajoUusuario ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE definicion ")or die(mysqli_error($mysqli));
    //$mysqli->query("TRUNCATE departamentos ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE documento ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE documentoExterno ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE documentoExternoTipo ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE encabezado ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE evaluacion ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE evaluacionMaterial ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE evaluacionPrueba ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE evaluacionRelacional ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE grupo ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE grupoUcargo ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE grupoUcCosto ")or die(mysqli_error($mysqli)); 
    $mysqli->query("TRUNCATE grupoUcTrabajo ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE grupoUusuario ")or die(mysqli_error($mysqli));
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
    $mysqli->query("TRUNCATE macroproceso ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE mensagens ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE mensajes ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE nivelcargo ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE normatividad ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE notificaciones ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE numeralNorma ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE perfiles ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE permisos ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE permisosNotificaciones ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE photo ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE politicas ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE presupuesto ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE presupuestoGestionar ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE presupuestoGrupos ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE presupuestoGruposGastos ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE procesos ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE proveedordocumentos ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE proveedordocumentosCarpetas ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE proveedores ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE proveedoresControlCambio ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE proveedoresCriticidad ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE proveedoresGrupo ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE proveedoresProductoEmpaque ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE proveedoresProductoGrupo ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE proveedoresProductoMedida ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE proveedoresProductoSubGrupo ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE proveedorProductos ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE proveedorSubCarpetas ")or die(mysqli_error($mysqli));//	
    $mysqli->query("TRUNCATE proveedoresTipo ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE proveedoresTipoImpuesto ")or die(mysqli_error($mysqli));
    //$mysqli->query("TRUNCATE proveedorPoliticas ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE registros ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE repositorioArchivoSolicitud ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE repositorioCarpeta ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE repositorioCarpetaSolicitud ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE repositorioRegistro ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE solicitudAlistamiento ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE solicitudCompra ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE solicitudCompraComentarios ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE solicitudComprador ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE solicitudCompraFlujo ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE solicitudCompraSolicitud ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE solicitudCompraTipo ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE solicitudCompraUrgencia ")or die(mysqli_error($mysqli));
    //$mysqli->query("TRUNCATE solicitudUploads ")or die(mysqli_error($mysqli));
    
    $mysqli->query("TRUNCATE solicitudDocumentos ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE solicitudEntradaSalidas")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE solicitudEntradaSalidasEstado")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE tabla ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE tablita ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE tiempo ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE tipoDocumento ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE uploads ")or die(mysqli_error($mysqli));
   
    $mysqli->query("TRUNCATE usuario ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE usuarioEliminado ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE usuarios ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE versionamiento ")or die(mysqli_error($mysqli));
    
    //// tabla para los archivos temporales para la validación de documento dañado
    $mysqli->query("TRUNCATE documentoArchivoTemporal ")or die(mysqli_error($mysqli));
    //// end
    
    $mysqli->query("TRUNCATE documentoDatosTemporalesActas ")or die(mysqli_error($mysqli));
    //$mysqli->query("TRUNCATE documentoRevision ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE proveedoresProductoIdentificador ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE proveedoresProductoTiempo ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE proveedorProductosDocumentos ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE solicitudCompradorTemporal ")or die(mysqli_error($mysqli));
    
    //// ultimas tablas para documentos del proveedor
    $mysqli->query("TRUNCATE carpeta ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE uploadsP ")or die(mysqli_error($mysqli));
    
    
    /// tablas del nuevo chat
    $mysqli->query("TRUNCATE users ")or die(mysqli_error($mysqli));
    $mysqli->query("TRUNCATE messages ")or die(mysqli_error($mysqli));
    
  
  //// obligamos a cargar nuevamente el sistema
  ?>
  <script> 
                 window.onload=function(){
               
                     document.forms["recuperacionFormulario"].submit();
                 }
                 setTimeout(clickbuttonArchivoEditable, 0999);
                 function clickbuttonArchivoEditable() { 
                    document.forms["recuperacionFormulario"].submit();
                 }
    </script>
             
            <form name="recuperacionFormulario" action="" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="codigo" value="<?php echo $_POST['codigo'];?>">
                <input type="hidden" name="solicitando" value="1">
                <input name="solicitando" id="captura_boton_recuperacion" type="submit" style="display:none;">
            </form> 
            <script>
                      //// agregamos un click automatico para después refrescar la página y entrar al chat
                    $(document).ready(function() {
                      // indicamos que se ejecuta la funcion en 1 segundo de haberse
                      // cargado la pagina
                      setTimeout(clickbutton, 1000);
                                            
                      function clickbutton() { 
                          
                          
                                if (window.localStorage) { 
                                    // recargamos la página una sola vez
                                    if (!localStorage.getItem('reload')) {
                                        localStorage['reload'] = true;
                                        window.location.reload(); 
                                    } else {
                                        localStorage.removeItem('reload');
                                    }
                                }
                          
                          
                        // simulamos el click del mouse en el boton del formulario
                        $("#captura_boton_recuperacion").click();
                        //después de capturar el botón, recargamos la vista
                            // JavaScript function
                            setTimeout(clickbuttonformario, 2000);
                                function clickbuttonformario() { 
                                         document.forms["recuperacionFormulario"].submit();
                                }
                            (() => { 
                                
                                if (window.localStorage) { 
                                    // recargamos la página una sola vez
                                    if (!localStorage.getItem('reload')) {
                                        localStorage['reload'] = true;
                                        window.location.reload(); 
                                    } else {
                                        localStorage.removeItem('reload');
                                    }
                                }
                            })(); // Calling anonymous function here only
                        
                      }
                      $('#captura_boton_recuperacion').on('click',function() {
                       // console.log('action');
                      });
                    });
                  </script>
    <?php
  
  
  
    
    //// Eliminación de documentos en el archivo
    $files = glob('../../archivos/actas/*'); //obtenemos todos los nombres de los ficheros
    foreach($files as $file){
        if(is_file($file)) 
        unlink($file); //elimino el fichero
        
        function deleteDirectory($dir) {
            if(!$dh = @opendir($dir)) return;
            while (false !== ($current = readdir($dh))) {
                if($current != '.' && $current != '..') {
                     'Se ha borrado el archivo '.$dir.'/'.$current.'<br/>';
                    if (!@unlink($dir.'/'.$current)) 
                        deleteDirectory($dir.'/'.$current);
                }       
            }
            closedir($dh);
             'Se ha borrado el directorio '.$dir.'<br/>';
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
                     'Se ha borrado el archivo '.$dir.'/'.$current.'<br/>';
                    if (!@unlink($dir.'/'.$current)) 
                        deleteDirectory($dir.'/'.$current);
                }       
            }
            closedir($dh);
             'Se ha borrado el directorio '.$dir.'<br/>';
            @rmdir($dir);
            
            
          
            
        }
        
        $dir = "../../archivos/compromisos/.";
        $dir = $dir."/";
        deleteDirectory($dir);
        
        
    }
    
    
    
    $filesProveedor = glob('../../archivos/documentoProveedor/*'); //obtenemos todos los nombres de los ficheros
    foreach($filesProveedor as $fileProveedor){
        if(is_file($fileProveedor))
        unlink($fileProveedor); //elimino el fichero
    }
    $filesDocumentos = glob('../../archivos/documentos/*'); //obtenemos todos los nombres de los ficheros
    foreach($filesDocumentos as $fileDocumentos){
        if(is_file($fileDocumentos))
        unlink($fileDocumentos); //elimino el fichero
    }
    $filesExternos = glob('../../archivos/documentosExternos/*'); //obtenemos todos los nombres de los ficheros
    foreach($filesExternos as $fileExternos){
        if(is_file($fileExternos))
        unlink($fileExternos); //elimino el fichero
    }
    $filesImg = glob('../../archivos/img/*'); //obtenemos todos los nombres de los ficheros
    foreach($filesImg as $fileImg){
        if(is_file($fileImg))
        unlink($fileImg); //elimino el fichero
    }
    
    $filesIndicadores = glob('../../archivos/indicadores/*'); //obtenemos todos los nombres de los ficheros
    foreach($filesIndicadores as $fileIndicadores){
        if(is_file($fileIndicadores))
        unlink($fileIndicadores); //elimino el fichero
    }
    
    $filesTipoDocumento = glob('../../archivos/plantillasTipoDocumento/*'); //obtenemos todos los nombres de los ficheros
    foreach($filesTipoDocumento as $fileTipoDocumento){
        if(is_file($fileTipoDocumento))
        unlink($fileTipoDocumento); //elimino el fichero
    }
    
    $filesRegistro = glob('../../archivos/registros/*'); //obtenemos todos los nombres de los ficheros
    foreach($filesRegistro as $fileRegistro){
        if(is_file($fileRegistro))
        unlink($fileRegistro); //elimino el fichero
    }
    
    $filesRpositorio = glob('../../archivos/repositorio/*'); //obtenemos todos los nombres de los ficheros
    foreach($filesRpositorio as $fileRpositorio){
        if(is_file($fileRpositorio))
        unlink($fileRpositorio); //elimino el fichero
    }
    
    $filesNormatividad = glob('../../archivos/plantillasNormatividad/*'); //obtenemos todos los nombres de los ficheros
    foreach($filesNormatividad as $fileNormatividad){
        if(is_file($fileNormatividad))
        unlink($fileNormatividad); //elimino el fichero
    }
    
    $filesSolicitudes = glob('../../archivos/solicitudes/*'); //obtenemos todos los nombres de los ficheros
    foreach($filesSolicitudes as $fileSolicitudes){
        if(is_file($fileSolicitudes))
        unlink($fileSolicitudes); //elimino el fichero
    }
    
    $filesRaiz = glob('../../raiz/*'); //obtenemos todos los nombres de los ficheros
    foreach($filesRaiz as $fileRaiz){
        if(is_file($fileRaiz))
        unlink($fileRaiz); //elimino el fichero
        function deleteDirectory($dirRaiz) {
            if(!$dh = @opendir($dirRaiz)) return;
            while (false !== ($current = readdir($dh))) {
                if($current != '.' && $current != '..') {
                     'Se ha borrado el archivo '.$dirRaiz.'/'.$current.'<br/>';
                    if (!@unlink($dirRaiz.'/'.$current)) 
                        deleteDirectory($dirRaiz.'/'.$current);
                }       
            }
            closedir($dh);
             'Se ha borrado el directorio '.$dirRaiz.'<br/>';
            @rmdir($dirRaiz);
        
        }
        
        $dirRaiz = "../../raiz/.";
        $dirRaiz = $dirRaiz."/";
        deleteDirectory($dirRaiz);
    }
    // END
    
    $filesMultiple = glob('../../almacenamientoMultiple/uploads/*'); //obtenemos todos los nombres de los ficheros
    foreach($filesMultiple as $fileMultiple){
        if(is_file($fileMultiple))
        unlink($fileMultiple); //elimino el fichero
    }
    
    $filesMultipleProductos = glob('../../almacenamientoMultipleProductos/uploads/*'); //obtenemos todos los nombres de los ficheros
    foreach($filesMultipleProductos as $fileMultipleProductos){
        if(is_file($fileMultipleProductos))
        unlink($fileMultipleProductos); //elimino el fichero
    }
    
    $filesProveedor = glob('../../almacenamientoMultipleProveedores/uploads/*'); //obtenemos todos los nombres de los ficheros
    foreach($filesProveedor as $fileProveedor){
        if(is_file($fileProveedor))
        unlink($fileProveedor); //elimino el fichero
    }
    
    
    $filesProveedorNuevoDelete = glob('../../archivos/documentoProveedor/*'); //obtenemos todos los nombres de los ficheros
    foreach($filesProveedorNuevoDelete as $fileProveedorNuevoDelete){
        if(is_file($fileProveedorNuevoDelete))
        unlink($fileProveedorNuevoDelete); //elimino el fichero
        function deleteDirectoryP($dirProveedorNuevoDelete) {
            if(!$dh = @opendir($dirProveedorNuevoDelete)) return;
            while (false !== ($current = readdir($dh))) {
                if($current != '.' && $current != '..') {
                     'Se ha borrado el archivo '.$dirProveedorNuevoDelete.'/'.$current.'<br/>';
                    if (!@unlink($dirProveedorNuevoDelete.'/'.$current)) 
                        deleteDirectoryP($dirProveedorNuevoDelete.'/'.$current);
                }       
            }
            closedir($dh);
             'Se ha borrado el directorio '.$dirProveedorNuevoDelete.'<br/>';
            @rmdir($dirProveedorNuevoDelete);
        
        }
        
        $dirProveedorNuevoDelete = "../../archivos/documentoProveedor/.";
        $dirProveedorNuevoDelete = $dirProveedorNuevoDelete."/";
        deleteDirectoryP($dirProveedorNuevoDelete);
    }
    // END
    
    //// END
    ?>
    <br>
    <center>
                            <style>
                                .preloader {
                                    width: 70px;
                                    height: 70px;
                                    border: 10px solid #eee;
                                    border-top: 10px solid #666;
                                    border-radius: 50%;
                                    animation-name: girar;
                                    animation-duration: 2s;
                                    animation-iteration-count: infinite;
                                    animation-timing-function: linear;
                                    }
                                    @keyframes girar {
                                    from {
                                        transform: rotate(0deg);
                                    }
                                    to {
                                        transform: rotate(360deg);
                                    }
                                    }
                            </style> 
                            <div class="preloader"></div> Cargando...
                            <br><br>
                            <form action="../../cliente" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="autorizado" value="1">
                                <button id="captura_boton" style="padding: 0.25rem 0.5rem;font-size: .875rem;line-height: 1.5;border-radius: 0.2rem;color: #fff;background-color: #28a745;border-color: #28a745;box-shadow: none;" type="submit" >Redireccionar</button>
                            </form>
                        </center> 
    
        
            <script> 
                 window.onload=function(){
               
                     document.forms["miformularioEnvioAutorizado"].submit();
                 }
                 setTimeout(clickbuttonArchivoEditable, 0999);
                 function clickbuttonArchivoEditable() { 
                    document.forms["miformularioEnvioAutorizado"].submit();
                 }
            </script>
             
            <form name="miformularioEnvioAutorizado" action="../../cliente" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="autorizado" value="1">
            </form> 
            <script>
                      //// agregamos un click automatico para después refrescar la página y entrar al chat
                    $(document).ready(function() {
                      // indicamos que se ejecuta la funcion en 1 segundo de haberse
                      // cargado la pagina
                      setTimeout(clickbutton, 1000);
                                            
                      function clickbutton() { 
                          
                          
                                if (window.localStorage) { 
                                    // recargamos la página una sola vez
                                    if (!localStorage.getItem('reload')) {
                                        localStorage['reload'] = true;
                                        window.location.reload(); 
                                    } else {
                                        localStorage.removeItem('reload');
                                    }
                                }
                          
                          
                        // simulamos el click del mouse en el boton del formulario
                        $("#captura_boton").click();
                        //después de capturar el botón, recargamos la vista
                            // JavaScript function
                            setTimeout(clickbuttonformario, 2000);
                                function clickbuttonformario() { 
                                         document.forms["miformularioEnvioAutorizado"].submit();
                                }
                            (() => { 
                                
                                if (window.localStorage) { 
                                    // recargamos la página una sola vez
                                    if (!localStorage.getItem('reload')) {
                                        localStorage['reload'] = true;
                                        window.location.reload(); 
                                    } else {
                                        localStorage.removeItem('reload');
                                    }
                                }
                            })(); // Calling anonymous function here only
                        
                      }
                      $('#captura_boton').on('click',function() {
                       // console.log('action');
                      });
                    });
                  </script>
        <?php
        
    }else{
        ?>
            <script> 
                 window.onload=function(){
               
                    // document.forms["miformularioRechazo"].submit();
                 }
                 setTimeout(clickbuttonArchivoRechazo, 0999);
                 function clickbuttonArchivoRechazo() { 
                    document.forms["miformularioRechazo"].submit();
                 }
            </script>
             
            <form name="miformularioRechazo" action="../../cliente" method="POST" onsubmit="procesar(this.action);" >
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
        $mysqli->query("UPDATE usuario SET sesionIP='NULL' "); //$direccionIPEmpresa
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
     $direccionIPEmpresa=$_SERVER['REMOTE_ADDR'];
    $updateSolicitud=$mysqli->query("UPDATE usuario SET estadoPermiso='Aprobado', sesionIP='$direccionIPEmpresa'  WHERE cedula='$ccSolicitandoUsuario'  ");
    //aca estaba así sesionIP='NULL'
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
    //$direccionIPEmpresa='200.89.255.183'; sesionIP='$direccionIPEmpresa'
    $updateSolicitud=$mysqli->query("UPDATE usuario SET estadoPermiso='NULL', descripcionPermiso='NULL', sesionIP='NULL'  WHERE cedula='$ccSolicitandoUsuario'  ");
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
