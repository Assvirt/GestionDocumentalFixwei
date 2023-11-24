<?php   error_reporting(E_ERROR);
session_start();

    include 'conexion/bd.php';
    
    $_SESSION["session_username"];
    $root=$_SESSION["session_root"];
    
                $acentos = $mysqli->query("SET NAMES 'utf8'");
                $consultarNombre=$mysqli->query("SELECT * FROM usuario WHERE cedula='".$_SESSION["session_username"]."' AND estadoUsuario='Conectado'  "); //AND NOT cedula='".$_SESSION["session_username"]."'
                while($traerNombre=$consultarNombre->fetch_array()){
                     '<font color=\'white\' >'.$enviasesionSeguridad=$traerNombre['cedula']; echo '</font>'; 
                     /// usamos la validación de sesion IP para cerrar dispositivos fuera de la red registrada
                    '<font color=\'white\' >'.$enviasesionSeguridadSesionIP=$traerNombre['sesionIP']; echo'</font>';
                     /// end
                }
         if($enviasesionSeguridad == NULL ){
             
             if($root == 1){
                 
             }else{
                    ?>
                        <meta  http-equiv="refresh" content="0; URL='https://fixwei.com/plataforma/pages/controlador/sesion/logout"> 
                    <?php
                    
             }
         }else{   
                // validamos que está activado el ip sesion para navegar sobre la ip de la empresa
                    $consultaClienteSescion=$mysqli->query("SELECT * FROM cliente ");
                    $extraerClienteSesion=$consultaClienteSescion->fetch_array(MYSQLI_ASSOC);
                                 
                                
                    if($extraerClienteSesion['sesion'] == 'Si'){
                    $direccionIPEmpresa=$extraerClienteSesion['registroIP'];//$_SERVER['REMOTE_ADDR']; 
                        
                        /// en caso que le autoricen el ingreso por cualquier IP no me cierre la sesión automatica
                        if($enviasesionSeguridadSesionIP == 'NULL'){
                            ?>
                                    <meta  http-equiv="refresh" content="0; URL='https://fixwei.com/plataforma/pages/controlador/sesion/logout"> 
                                <?php
                        }else{
                            if($extraerClienteSesion['registroIP'] == $enviasesionSeguridadSesionIP){ //$_SERVER['REMOTE_ADDR']
                                //echo 'Mismo id sigue la sesion';
                            }else{
                                ?>
                                    <meta  http-equiv="refresh" content="0; URL='https://fixwei.com/plataforma/pages/controlador/sesion/logout"> 
                                <?php
                            }
                        }
                        /// END
                            
                    
                    }
                    if($extraerClienteSesion['sesion'] == 'No'){
                        $direccionIPEmpresa='NULL';
                        if($direccionIPEmpresa == 'NULL'){
                            //echo 'Siegu seión';
                        }
                    }
                /// END
                
               
                
                
             
         }          



    //// generador de copia de seguridad
        function exportarTablas($host, $usuario, $pasword, $nombreDeBaseDeDatos)
        {
            set_time_limit(3000);
            $tablasARespaldar = [];
            $mysqli = new mysqli($host, $usuario, $pasword, $nombreDeBaseDeDatos);
            $mysqli->select_db($nombreDeBaseDeDatos);
            $mysqli->query("SET NAMES 'utf8'");
            $tablas = $mysqli->query('SHOW TABLES');
            while ($fila = $tablas->fetch_row()) {
                $tablasARespaldar[] = $fila[0];
            }
            $contenido = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `" . $nombreDeBaseDeDatos . "`\r\n--\r\n\r\n\r\n";
            foreach ($tablasARespaldar as $nombreDeLaTabla) {
                if (empty($nombreDeLaTabla)) {
                    continue;
                }
                $datosQueContieneLaTabla = $mysqli->query('SELECT * FROM `' . $nombreDeLaTabla . '`');
                $cantidadDeCampos = $datosQueContieneLaTabla->field_count;
                $cantidadDeFilas = $mysqli->affected_rows;
                $esquemaDeTabla = $mysqli->query('SHOW CREATE TABLE ' . $nombreDeLaTabla);
                $filaDeTabla = $esquemaDeTabla->fetch_row();
                $contenido .= "\n\n" . $filaDeTabla[1] . ";\n\n";
                for ($i = 0, $contador = 0; $i < $cantidadDeCampos; $i++, $contador = 0) {
                    while ($fila = $datosQueContieneLaTabla->fetch_row()) {
                        //La primera y cada 100 veces
                        if ($contador % 100 == 0 || $contador == 0) {
                            $contenido .= "\nINSERT INTO " . $nombreDeLaTabla . " VALUES";
                        }
                        $contenido .= "\n(";
                        for ($j = 0; $j < $cantidadDeCampos; $j++) {
                            $fila[$j] = str_replace("\n", "\\n", addslashes($fila[$j]));
                            if (isset($fila[$j])) {
                                $contenido .= '"' . $fila[$j] . '"';
                            } else {
                                $contenido .= '""';
                            }
                            if ($j < ($cantidadDeCampos - 1)) {
                                $contenido .= ',';
                            }
                        }
                        $contenido .= ")";
                        # Cada 100...
                        if ((($contador + 1) % 100 == 0 && $contador != 0) || $contador + 1 == $cantidadDeFilas) {
                            $contenido .= ";";
                        } else {
                            $contenido .= ",";
                        }
                        $contador = $contador + 1;
                    }
                }
                $contenido .= "\n\n\n";
            }
            $contenido .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
        
            # Se guardará dependiendo del directorio, en una carpeta llamada respaldos
            $carpeta = __DIR__ . "/respaldos";
            if (!file_exists($carpeta)) {
                mkdir($carpeta);
            }
        
            # Calcular un ID único
            $id = uniqid();
        
            # También la fecha
            $fecha = date("Y-m-d");
        
            # Crear un archivo que tendrá un nombre como respaldo_2018-10-22_asd123.sql
            $nombreDelArchivo = sprintf('%s/respaldo_%s.sql', $carpeta, $fecha ); //$nombreDelArchivo = sprintf('%s/respaldo_%s_%s.sql', $carpeta, $fecha, $id);
        
            #Escribir todo el contenido. Si todo va bien, file_put_contents NO devuelve FALSE
            return file_put_contents($nombreDelArchivo, $contenido) !== false;
        }
        
        //// función para conectar la base de datos para el respaldo de información
        exportarTablas("localhost", "fixwei_pageroot", "l_9&e~Lu+SzX", "fixwei_c9rp5r4t2v8");


    ///traemos el formato de fecha
    date_default_timezone_set("America/Bogota");
    
    //construimos el nombre del archivo con la fecha del día presente
    $guardar_respaldo_fecha='respaldo_'.$fecha=date("Y-m-d").'.sql';
    
    
    /// listamos los archivos existentes de la carpeta respaldo
    $thefolder = "respaldos/";
    if ($handler = opendir($thefolder)) {
     while (false !== ($file = readdir($handler))) {
            // filtramos para no traer extension de libreria . y ..
            
            if($file == '.' || $file == '..'){
                
            }else{
                if($guardar_respaldo_fecha == $file){
                    $enviarArchivo.=$file;
                }
            }
        }
       
        closedir($handler);
    }

    /// consultamos si ya existe una copia de seguridad generada el día presente
    if($enviarArchivo == $guardar_respaldo_fecha){
        /// se consulta la fecha de la copia guardada
        $consulta_copia_seguridad=$mysqli->query("SELECT * FROM seguridadCopia ");
        $extraer_consulta_copia_seguridad=$consulta_copia_seguridad->fetch_array(MYSQLI_ASSOC);
        $extraer_consulta_copia_seguridad['copia'];
        
        if($extraer_consulta_copia_seguridad['copia'] == $guardar_respaldo_fecha) { // verificamos que la ultima copia guardada coincida con la copia generada en el servidor
            
        }else{
            $mysqli->query("UPDATE seguridadCopia SET copia='$guardar_respaldo_fecha' ");
            require 'correoEnviar/libreria/PHPMailerAutoload.php';
             
             /// enviamos la ruta para visualizar el script de la BD
             $divulgarDocumento='<br><a href="https://fixwei.com/plataforma/pages/respaldos/'.$enviarArchivo.'" target="_blank">Copia de seguridad '.$guardar_respaldo_fecha.'</a>';
             
             /// enviamos la ruta para descargar el archivo en un formato txt
             $divulgarDocumentoB='https://fixwei.com/plataforma/pages/respaldos/'.$enviarArchivo;
             
             /// enviamos la ruta para descargar el archivo LM en un formato zip
             $divulgarDocumentoC='<br><a href="https://fixwei.com/plataforma/pages/archivos/listadoMaestro.zip" target="_blank">Copia de seguridad listado maestro '.date("Y-m-d").'</a>';
             
             /// enviamos la ruta para descargar el archivo OB en un formato zip
             $divulgarDocumentoD='<br><a href="https://fixwei.com/plataforma/pages/archivos/Obsoleto.zip" target="_blank">Copia de seguridad listado maestro '.date("Y-m-d").'</a>';
             
             //Instanciamos $mail para el envio de correos
                        
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                 
                       
                        require 'correoEnviar/contenido.php';
                      
                        $mail->isHTML(true);
                        $mail->AddAddress('miguelangarita9208@gmail.com'); //$correos
                        $mail->Subject = utf8_decode('Copia de seguridad '.$guardar_respaldo_fecha.' Fixwei');
                        
                        //// usamos esta línea de código para enviar un documento
                        $fichero = file_get_contents($divulgarDocumentoB);
                        $mail->addStringAttachment($fichero, $guardar_respaldo_fecha);
                        /// end
                        
                        $mail->Body =utf8_decode(('
                        <html>
                        <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                        <title>HTML</title>
                        </head>
                        <body>
                        <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                        
                        <p>Descargar y visualiza el script de la copia de seguridad de la base de datos de la empresa Fixwei<b><em></em></b>.
                        <br><br>
                        En el correo encontrará los siguientes datos:<br>
                        - Copia de seguridad de la base de datos '.$divulgarDocumento.'.<br>
                        - Documentos comprimidos del listado maestro '.$divulgarDocumentoC.'.<br>
                        - Documentos comprimidos de obsoletos '.$divulgarDocumentoD.'.
                        <br><br>
                        Este correo es informativo por tanto, le pedimos no responda este mensaje.
                        </p>
                        </body>
                        </html>
                        '));
                        
                        //Avisar si fue enviado o no y dirigir al index
                        
                        if ($mail->Send()) {
                            
                        } else {
                            
                        }
                        $mail->ClearAddresses(); 
        }
    }
    
    
    
?>
