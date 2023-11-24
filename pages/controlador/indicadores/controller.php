<?php
error_reporting(E_ERROR);
//////// traemos la bd
require_once '../../conexion/bd.php';
////////// validamos el ingreso por el name del  boton del formulario

if(isset($_POST['Agregar'])){
    
    $quienCrea= $_POST['usuarioActividad'];
    $nombre = utf8_decode($_POST['nombre']);
    $desripcion = utf8_decode($_POST['descripcion']);
    $tipoIndicador = $_POST['tipoIndicador'];
    $variables=$_POST['variables'];
    
    if($variables=='Serie única'){
        $terminar='Pendiente2.2';
    }
    if($variables == 'Multiserie'){
        $terminar='Pendiente2';
    }
    
    $restrincion = $_POST['restrincion'];
    
    ///// resposable del indicador
        $radiobtn=$_POST['radiobtn'];
        $responsableIndicador = json_encode($_POST['select_encargadoRI']);
/*
        /// envio de correos para los responsables del indicador
        require '../usuarios/libreria/PHPMailerAutoload.php';
    
                $radiobtn;
                $arrayEncargado=$_POST['select_encargadoRI'];
                $nombreDocEnviar=$_POST['nombre'];
                if($radiobtn == 'usuario'){ 
                    $longitud = count($arrayEncargado); 
                    for($i=0; $i<$longitud; $i++){
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargado[$i]' ");
                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        
                        

                                            

                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                            
                                            //Configuracion servidor mail
                                            require '../../correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correoResponsable);
                                            $mail->Subject = utf8_decode('Responsable del indicador '.$nombreDocEnviar);
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
                                            <p>El indicador <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su revisión.</p>
                                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                            <br>
                                            <em>Mi perfil --> mis pendientes --> Indicadores --> responsable del indicador +</em>.
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
                                            
                                            } else {

                                            }
                                        
                                            
                    }
                }

                if($radiobtn == 'cargo'){
                
                    $longitud = count($arrayEncargado);
                    for($i=0; $i<$longitud; $i++){ 
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo='$arrayEncargado[$i]' ");
                        while($columna = $nombreuser->fetch_array()){
                             $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                             $correoResponsable=$columna['correo']; 
                            '<br>';
                            
                            //Create a new PHPMailer instance
                            $mail = new PHPMailer();
                            $mail->IsSMTP();
                            
                            //Configuracion servidor mail
                            require '../../correoEnviar/contenido.php';
                            
                            //Agregar destinatario
                            $mail->isHTML(true);
                            $mail->AddAddress($correoResponsable);
                            $mail->Subject = utf8_decode('Responsable del indicador '.$nombreDocEnviar);
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
                            <p>El indicador <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su revisión.</p>
                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                            <br>
                            <em>Mi perfil --> mis pendientes --> Indicadores --> responsable del indicador +</em>.
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
                            
                            } else {

                            }
                        
                            
                        }
                    }
                }
    */
        // END




    ///// fin
    
    $desdeMostrar=$_POST['desde'];
    '<br>';
    $identificandodia=substr($_POST['desde'], 8, 2);
    
    if($identificandodia > 28){
        $desde=substr($_POST['desde'], 0, 4).'-'.substr($_POST['desde'], 5, 2).'-28';
       
    }else{
        $desde=$_POST['desde'];
    }
    
    $hasta=$_POST['hasta'];
    $sentido=$_POST['sentido'];
    $proceso=$_POST['proceso'];
    
    /// norma[]
    $normal = json_encode($_POST['norma']);
    /// echo '<br>norma: '.json_encode($normal);
    /// END
    
    $frecuencia=$_POST['frecuencia'];
    $clasificacion=$_POST['clasificacion'];
    
    
    //// responsable del calculo
     $radiobtnC=$_POST['radiobtnC'];
     $responsableCalculo = json_encode($_POST['select_encargadoC']);

              
/*
                $radiobtn;
                $arrayEncargadoB=$_POST['select_encargadoC'];
                $nombreDocEnviar=$_POST['nombre'];
                if($radiobtnC == 'usuario'){ 
                    $longitud = count($arrayEncargadoB); 
                    for($i=0; $i<$longitud; $i++){
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargadoB[$i]' ");
                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        
                        

                                            

                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                            
                                            //Configuracion servidor mail
                                            require '../../correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correoResponsable);
                                            $mail->Subject = utf8_decode('Responsable del calculo indicador '.$nombreDocEnviar);
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
                                            <p>El indicador <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su revisión.</p>
                                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                            <br>
                                            <em>Mi perfil --> mis pendientes --> Indicadores --> responsable del calculo +</em>.
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
                                            
                                            } else {

                                            }
                                        
                                            
                    }
                }

                if($radiobtnC == 'cargo'){

                    $longitud = count($arrayEncargadoB);
                    for($i=0; $i<$longitud; $i++){ 
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo='$arrayEncargadoB[$i]' ");
                        while($columna = $nombreuser->fetch_array()){
                            $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                            $correoResponsable=$columna['correo']; 
                            '<br>';
                            
                            //Create a new PHPMailer instance
                            $mail = new PHPMailer();
                            $mail->IsSMTP();
                            
                            //Configuracion servidor mail
                            require '../../correoEnviar/contenido.php';
                            
                            //Agregar destinatario
                            $mail->isHTML(true);
                            $mail->AddAddress($correoResponsable);
                            $mail->Subject = utf8_decode('Responsable del calculo indicador '.$nombreDocEnviar);
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
                            <p>El indicador <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su revisión.</p>
                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                            <br>
                            <em>Mi perfil --> mis pendientes --> Indicadores --> responsable del calculo +</em>.
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
                            
                            } else {

                            }
                        
                            
                        }
                    }
                }
*/
                // END


    //echo '<br>datos: '.json_encode($responsableCalculo);
    
    //// Autorizados para Visualizar
    $radiobtnAut=$_POST['radiobtnAut'];
    $autorizadosVisualizar = json_encode($_POST['select_encargadoAut']);
    
    
    ////// Autorizados para editar
    $radiobtnEd=$_POST['radiobtnEd'];
    $select_encargadoEd=json_encode($_POST['select_encargadoEd']);
    
    
    
    ///////// consultamos la tabla y extraemos el nombre
    
        if($hasta < $desdeMostrar){  /// la validacion de las fechas si la fecha final es menor a la fecha dfinal nos arroja un error
            ?>
                    <script> 
                        window.onload=function(){
                    
                            document.forms["miformulario"].submit();
                        }
                    </script>
                    
                    <form name="miformulario" action="../../indicadores" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionExisteFecha" value="1">
                    </form> 
                <?php
        }else{
            
            // funcion para quitar espacios
                function Quitar_Espacios($nombre)
                {
                    $array = explode(' ',$nombre);  // convierte en array separa por espacios;
                    $nombre ='';
                    // quita los campos vacios y pone un solo espacio
                    for ($i=0; $i < count($array); $i++) { 
                        if(strlen($array[$i])>0) {
                            $nombre.= ' ' . $array[$i];
                        }
                    }
                return  trim($nombre);
                }
                /// END
            
                $nombre = Quitar_Espacios($nombre);
                
            $validacion = $mysqli->query("SELECT * FROM indicadores WHERE nombre = '$nombre' ")or die (mysqli_error());
            $numRows = mysqli_num_rows($validacion);
            if($numRows > 0){
                //echo 'funciona';
                //echo '<script language="javascript">alert("El tipo de indicador ya existen");
                //window.location.href="../../indicadores"</script>';
                ?>
                    <script> 
                        window.onload=function(){
                    
                            document.forms["miformulario"].submit();
                        }
                    </script>
                    
                    <form name="miformulario" action="../../indicadores" method="POST" onsubmit="procesar(this.action);" >
                        <input type="hidden" name="validacionExiste" value="1">
                    </form> 
                <?php
            }else{
                
                //echo 'no sirve';
                $mysqli->query("INSERT INTO indicadores (desdeMostrar,radioEditar,autorizadoEditar,quienCrea,nombre, descripcion, tipoIndicador, radioIndicador, resposableIndicador, desde, hasta, sentido, proceso, norma, frecuencia, clasificacion, radioCalculo, responsableCalculo,radioVisualizar,autorizadoVisualizar,terminar,terminar2,restrincion)
                VALUES('$desdeMostrar','$radiobtnEd','$select_encargadoEd','$quienCrea','$nombre','$desripcion','$tipoIndicador','$radiobtn','$responsableIndicador','$desde','$hasta','$sentido','$proceso','$normal','$frecuencia','$clasificacion','$radiobtnC','$responsableCalculo','$radiobtnAut','$autorizadosVisualizar','$terminar','$terminar','$restrincion') ")or die(mysqli_error($mysqli));
                //header ('location: ../../indicadores');
                
                //echo '<script language="javascript">alert("Guardado con éxito");
                //window.location.href="../../indicadores"</script>';
            
                
                    if($variables == 'Serie única'){  
                                ?>
                                    <script>
                                            window.onload=function(){
                                                //alert("");
                                                document.forms["miformulario"].submit();
                                                }
                                    </script>
                                    <form name="miformulario" action="../../indicadoresAgregar2.2" method="POST" onsubmit="procesar(this.action);" >
                                    <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                                    <input name="variablesSU" value="<?php echo $variables; ?>" type="hidden" readonly>
                                    </form>
                                    
                                <?php
                    }
                    
                    if($variables == 'Multiserie'){
                                ?>
                                    <script>
                                            window.onload=function(){
                                                //alert("");
                                                document.forms["miformulario"].submit();
                                                }
                                    </script>
                                    <form name="miformulario" action="../../indicadoresAgregar2" method="POST" onsubmit="procesar(this.action);" >
                                    <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                                    <input name="variablesMS" value="<?php echo $variables; ?>" type="hidden" readonly>
                                    </form>
                                    
                                <?php
                    }
                    
                    
                    
                }
            
        //////// 
        }
    
}elseif(isset($_POST['actualizar'])){ //echo 'aca';
    
    $idIndicador=$_POST['idIndicador'];
    $nombre = utf8_decode($_POST['nombre']);
    
    /////// se debe actualizar el nombre de la tabla de gestionar
    
    ////// end
    
    $desripcion = utf8_decode($_POST['descripcion']);
    $tipoIndicador = $_POST['tipoIndicador'];
    
    $restrincion = $_POST['restrincion'];
    
    ///// resposable del indicador
    $radiobtn=$_POST['radiobtn'];
    $responsableIndicador = json_encode($_POST['select_encargadoRI']);
    ///// fin
    
    //$desde=$_POST['desde'];
    
    $desdeMostrar=$_POST['desde'];
    '<br>';
    $identificandodia=substr($_POST['desde'], 8, 2);
    
    if($identificandodia > 28){
        $desde=substr($_POST['desde'], 0, 4).'-'.substr($_POST['desde'], 5, 2).'-28';
       
    }else{
        $desde=$_POST['desde'];
    }
    
    $hasta=$_POST['hasta'];
    $sentido=$_POST['sentido'];
    $proceso=$_POST['proceso'];
    
    /// norma[]
    $normal = json_encode($_POST['norma']);
    /// echo '<br>norma: '.json_encode($normal);
    /// END
    
    $frecuencia=$_POST['frecuencia'];
    $clasificacion=$_POST['clasificacion'];
    
    
    //// responsable del calculo
    $radiobtnC=$_POST['radiobtnC'];
    $responsableCalculo = json_encode($_POST['select_encargadoC']);
    //echo '<br>datos: '.json_encode($responsableCalculo);
    
    //// Autorizados para Visualizar para cargos
    $radiobtnAut=$_POST['radiobtnAut'];
    $autorizadosVisualizarCargos = json_encode($_POST['select_encargadoAut']);
    
    ///// Autorizados para visualizar para Usuarios
    $autorizadosVisualizarUsuarios = json_encode($_POST['select_encargadoAutU']);
    
    
    ///// validamos cuál de los 2 está ingresando para realizar la actualización en el mismo campo
    if($radiobtnAut == 'cargo'){
        $autorizadosVisualizar = $autorizadosVisualizarCargos;
    }
    
    if($radiobtnAut == 'usuario'){
        $autorizadosVisualizar = $autorizadosVisualizarUsuarios;
    }
    /// END
    
    ////// Autorizados para editar
    $radiobtnEd=$_POST['radiobtnEd'];
    $select_encargadoEd=json_encode($_POST['select_encargadoEd']);
    
    
    
    $formula=$_POST['formula'];
    
    $variables=$_POST['variables'];
    
    if($variables=='Serie única'){
        $terminar='Pendiente2.2';
    }
    if($variables == 'Multiserie'){
        $terminar='Pendiente2';
    }
    
if($hasta < $desdeMostrar){  /// la validacion de las fechas si la fecha final es menor a la fecha dfinal nos arroja un error
     ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../indicadores" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExisteFecha" value="1">
            </form> 
        <?php
 }else{     

    if($select_encargadoEd == 'null' || $autorizadosVisualizar == 'null' || $responsableCalculo == 'null' || $responsableIndicador == 'null'){ // si los autorizados para editar viene nulo me debe devolver
                        ?>
                            <script>
                                    window.onload=function(){
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresEditar1" method="POST" onsubmit="procesar(this.action);" >
                               <input name="id" value="<?php echo $idIndicador; ?>" type="hidden" readonly>
                               <!--<input type="hidden" name="validacionExisteExistencia" value="1">-->
                            </form>
                            
                        <?php
    }else{
        
    // funcion para quitar espacios
        function Quitar_Espacios($nombre)
        {
            $array = explode(' ',$nombre);  // convierte en array separa por espacios;
            $nombre ='';
            // quita los campos vacios y pone un solo espacio
            for ($i=0; $i < count($array); $i++) { 
                if(strlen($array[$i])>0) {
                    $nombre.= ' ' . $array[$i];
                }
            }
          return  trim($nombre);
        }
        /// END
       
        $nombre = Quitar_Espacios($nombre);    
    
    $mysqli->query("UPDATE indicadoresGestionar SET nombreG='$nombre' WHERE idIndicador='$idIndicador' ")or die(mysqli_error($mysqli));
    
    $mysqli->query("UPDATE indicadores SET desdeMostrar='$desdeMostrar', radioEditar='$radiobtnEd', autorizadoEditar='$select_encargadoEd', nombre='$nombre', descripcion='$desripcion', tipoIndicador='$tipoIndicador', radioIndicador='$radiobtn', resposableIndicador='$responsableIndicador', 
    desde='$desde', hasta='$hasta', sentido='$sentido', proceso='$proceso', norma='$normal', frecuencia='$frecuencia', clasificacion='$clasificacion', radioCalculo='$radiobtnC', 
    responsableCalculo='$responsableCalculo',radioVisualizar='$radiobtnAut',autorizadoVisualizar='$autorizadosVisualizar',restrincion='$restrincion',formula='$formula' WHERE id='$idIndicador' ")or die(mysqli_error($mysqli));
        
        if($mysqli != NULL){
                        ?>
                            <script>
                                    window.onload=function(){
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresEditar1" method="POST" onsubmit="procesar(this.action);" >
                               <input name="id" value="<?php echo $idIndicador; ?>" type="hidden" readonly>
                                <input name="siguiente" value="siguiente" type="hidden" readonly>
                            </form>
                            
                        <?php
        }
    }
 }    
    
}elseif(isset($_POST['agregarNuevaMeta'])){
    
    $idIndicador=$_POST['idIndicador'];
    $quienCrea=$_POST['quienCrea'];
    $unidad=$_POST['unidad'];
    $metaActual=$_POST['metaActual'];
    $desde=$_POST['desde'];
    $hasta=$_POST['hasta'];
    $zp=$_POST['zp'];
    $za=$_POST['za'];
    $zc=$_POST['zc'];
    $ze=$_POST['ze'];
    
    date_default_timezone_set('America/Bogota');
    $fecha1=date('Y-m-j h:i:s A');
    $mesActual = intval(substr($fecha1, 5, 2));
    /// END
    //$anoPresente = intval(substr($fecha1, 0, 4)); // variable anterior $indicadorDesde
     $anoPresente = substr($hasta, 0, 4);
    /// consultamos el id para validar la fecha entrante con la existente
    $consultaIdExistente=$mysqli->query("SELECT * FROM indicadoresMetas WHERE idIndicador='$idIndicador' AND anoPresente='$anoPresente' ");
    $extraeIdExistente=$consultaIdExistente->fetch_array(MYSQLI_ASSOC);
    '<br>desde: '.$consultaDesde=$extraeIdExistente['desde'];
    '<br>hasta: '.$consultaHasta=$extraeIdExistente['hasta'];
    //// END
    
    if($desde <= $consultaHasta){
        //echo 'las fechas son iguales o menor';
       // echo '<script language="javascript">alert("Error, la fecha seleccionada ya se encuentra asignada");</script>';
        
                        ?>
                            <script>
                                    window.onload=function(){
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresEditar1" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteB" value="1">
                               <input name="id" value="<?php echo $idIndicador; ?>" type="hidden" readonly>
                               <input name="siguiente" value="siguiente" type="hidden" readonly>
                            </form>
                            
                        <?php
        
        
    }else{
        
        
        //echo 'agrega';
         
                                            date_default_timezone_set('America/Bogota');$fecha1=date('Y-m-j');
                                            $anoPresente = intval(substr($fecha1, 0, 4)); // variable anterior $indicadorDesde 
                                            /// END
                                        
                                            //$anoPresente = substr($hasta, 0, 4); // variable anterior $indicadorDesde
                                            
    $mysqli->query("INSERT INTO indicadoresMetas (idIndicador,quienCrea,unidad,metaActual,desde,hasta,zp,za,zc,ze,anoPresente)
    VALUES('$idIndicador','$quienCrea','$unidad','$metaActual','$desde','$hasta','$zp','$za','$zc','$ze','$anoPresente')")or die(mysqli_error($mysqli));
    
    
        if($mysqli != NULL){
                        ?>
                            <script>
                                    window.onload=function(){
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresEditar1" method="POST" onsubmit="procesar(this.action);" >
                               <input name="id" value="<?php echo $idIndicador; ?>" type="hidden" readonly>
                               <input name="siguiente" value="siguiente" type="hidden" readonly>
                            </form>
                            
                        <?php
        } 
        
    
        
        
    }
    
    
        
        
        
    
}elseif(isset($_POST['actualizarMeta'])){
    $idIndicador=$_POST['idIndicador'];
    $unidad=$_POST['unidad'];
    $metaActual=$_POST['metaActual'];
    $desde=$_POST['desde'];
    $hasta=$_POST['hasta'];
    $zp=$_POST['zp'];
    $za=$_POST['za'];
    $zc=$_POST['zc'];
    $ze=$_POST['ze'];
    
    /// consultamos para verificar si el indicador viene sin meta o con meta
    $consultaMetasValidacion=$mysqli->query("SELECT * FROM indicadoresMetas WHERE idIndicador='$idIndicador' AND id='".$_POST['metaPrincipal']."' ");
    $extraerDatosMetasVali=$consultaMetasValidacion->fetch_array(MYSQLI_ASSOC);
    
    if($extraerDatosMetasVali['metas'] == 'No'){
        $mysqli=TRUE;
    }else{
    
        $mysqli->query("UPDATE indicadoresMetas SET unidad='$unidad',metaActual='$metaActual',desde='$desde',hasta='$hasta', zp='$zp', za='$za', zc='$zc', ze='$ze' WHERE idIndicador='$idIndicador' AND id='".$_POST['metaPrincipal']."' ")or die(mysqli_error($mysqli));
    }
    /// end
    if($mysqli != NULL){
                        ?>
                            <script>
                                    window.onload=function(){
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadores" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionActualizar" value="1">
                            </form>
                            
                        <?php
        }
}elseif(isset($_POST['borrarMetaIdIndicador'])){
$idIndicador=$_POST['idIndicador'];
$variablesIdPrincipal=$_POST['variablesIdPrincipal'];

$mysqli->query("DELETE FROM indicadoresMetas WHERE id = '$idIndicador'  ")or die(mysqli_error($mysqli));
                        ?>
                            <script>
                                    window.onload=function(){
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresEditar1" method="POST" onsubmit="procesar(this.action);" >
                               <input name="id" value="<?php echo $variablesIdPrincipal; ?>" type="hidden" readonly>
                               <input name="siguiente" value="siguiente" type="hidden" readonly>
                            </form>
                            
                        <?php

}elseif(isset($_POST['AgregarVariablesEditar'])){
   
   //// para mantener la vista de variables habilitada
    $idEditarVariable=$_POST['idEditarVariable'];
   /// END
    
    $id=$_POST['id'];
    
    $variables= utf8_decode($_POST['variables']);
    $nombre = utf8_decode($_POST['nombre2']);
    $desripcion = utf8_decode($_POST['descripcion2']);
    $simbolo=  utf8_decode($_POST['simbolo']);
    $unidad=  utf8_decode($_POST['unidad']);
    
    $validacion = $mysqli->query("SELECT * FROM indicadoresVariables WHERE simbolo = '$simbolo' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
        
        if($numRows != NULL){
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("La variable ya existe");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresEditar1" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExisteC" value="1">
                               <input name="id" value="<?php echo $id; ?>" type="hidden" readonly>
                                <input type="hidden" name="idEditarVariable" value="<?php echo $idEditarVariable; ?>">
                            </form>
                            
                        <?php
        }
        
        
        
    }else{
        
    $mysqli->query("INSERT INTO indicadoresVariables (variables,nombreVariable, descripcionVariable, simbolo, unidad)
    VALUES('$variables','$nombre','$desripcion','$simbolo','$unidad')   ")or die(mysqli_error($mysqli));
 
    
    
        if($mysqli != NULL){
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresEditar1" method="POST" onsubmit="procesar(this.action);" >
                               <input name="id" value="<?php echo $id; ?>" type="hidden" readonly>
                                <input type="hidden" name="idEditarVariable" value="<?php echo $idEditarVariable; ?>">
                            </form>
                            
                        <?php
        }
    }    
}elseif(isset($_POST['AgregarVariables'])){
    
    $quienCrea= $_POST['usuarioActividad'];
    $idContinuaIndicador=$_POST['idContinuaIndicador'];
    
    $variables= utf8_decode($_POST['variables']);
    $nombre = utf8_decode($_POST['nombre2']);
    $desripcion = utf8_decode($_POST['descripcion2']);
    $simbolo=  utf8_decode($_POST['simbolo']);
    $unidad=  utf8_decode($_POST['unidad']);
    
    $validacion = $mysqli->query("SELECT * FROM indicadoresVariables WHERE simbolo = '$simbolo' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){
        
        if($numRows != NULL){
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("La variable ya existe");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresAgregar2" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionExiste" value="1">
                               <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                               <input name="variablesIdPrincipal" value="<?php echo $idContinuaIndicador; ?>" type="hidden" readonly>
                               <input name="calculadoraMostrar" value="TRUE" type="hidden" readonly>
                            </form>
                            
                        <?php
        }
        
        
        
    }else{
        
    $mysqli->query("INSERT INTO indicadoresVariables (variables,nombreVariable, descripcionVariable, simbolo, unidad,usuario)
    VALUES('$variables','$nombre','$desripcion','$simbolo','$unidad','$quienCrea')   ")or die(mysqli_error($mysqli));
    
    //$mysqli->query("UPDATE indicadores SET  terminar='Pendiente2'  WHERE id = '$idContinuaIndicador'  ")or die(mysqli_error($mysqli));
    
    
        if($mysqli != NULL){
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresAgregar2" method="POST" onsubmit="procesar(this.action);" >
                                <input type="hidden" name="validacionAgregar" value="1">
                               <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                               <input name="variablesIdPrincipal" value="<?php echo $idContinuaIndicador; ?>" type="hidden" readonly>
                               <input name="calculadoraMostrar" value="TRUE" type="hidden" readonly>
                            </form>
                            
                        <?php
        }
    }    
}elseif(isset($_POST['AgregarVariablesActualizar'])){
    
    $quienCrea= $_POST['quienCrea'];
    $idContinuaIndicador=$_POST['id'];
    $muestraCalculadora=$_POST['calculadoraMostrar'];
    $variablesIdPrincipal=$_POST['variablesIdPrincipal'];
   
    $nombre = utf8_decode($_POST['nombre2']);
    $simbolo=  utf8_decode($_POST['simbolo']);
   
    
    $mysqli->query("UPDATE indicadoresVariables SET  nombreVariable='$nombre',  simbolo='$simbolo'   WHERE id = '$idContinuaIndicador'  ")or die(mysqli_error($mysqli));
    //$mysqli->query("UPDATE indicadores SET  terminar='Pendiente2'  WHERE id = '$idContinuaIndicador'  ")or die(mysqli_error($mysqli));
        if($mysqli != NULL){
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresAgregar2" method="POST" onsubmit="procesar(this.action);" >
                                 <input type="hidden" name="validacionActualizar" value="1">
                               <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                               <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden" readonly>
                               <input name="calculadoraMostrar" value="<?php echo $muestraCalculadora; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
        }
        
}elseif(isset($_POST['AgregarVariablesEliminar'])){
    
    $quienCrea= $_POST['quienCrea'];
    $idContinuaIndicador=$_POST['id'];
    $muestraCalculadora=$_POST['calculadoraMostrar'];
    $variablesIdPrincipal=$_POST['variablesIdPrincipal'];
   
    $nombre = utf8_decode($_POST['nombre2']);
    $simbolo=  utf8_decode($_POST['simbolo']);
   
    
    $mysqli->query("DELETE FROM indicadoresVariables WHERE id = '$idContinuaIndicador'  ")or die(mysqli_error($mysqli));
    //$mysqli->query("UPDATE indicadores SET  terminar='Pendiente2'  WHERE id = '$idContinuaIndicador'  ")or die(mysqli_error($mysqli));
        if($mysqli != NULL){
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresAgregar2" method="POST" onsubmit="procesar(this.action);" >
                                 <input type="hidden" name="validacionEliminar" value="1">
                               <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                               <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden" readonly>
                               <input name="calculadoraMostrar" value="<?php echo $muestraCalculadora; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
        }
        
}elseif(isset($_POST['AgregarVariablesAplicar'])){
    
    $quienCrea= $_POST['quienCrea']; /// quienCrea
    $idContinuaIndicador=$_POST['id']; //// idIndicadorVariable
    $muestraCalculadora=$_POST['calculadoraMostrar']; // mantiene la calculadora activa
    $variablesIdPrincipal=$_POST['variablesIdPrincipal']; //// idIndicador
   
   
   
    
    $mysqli->query("INSERT INTO indicadoresVariablesAsociadas (idIndicador,idVariable,quienCrea)VALUES('$variablesIdPrincipal','$idContinuaIndicador','$quienCrea') ")or die(mysqli_error($mysqli));
    
        
        if($mysqli != NULL){
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresAgregar2" method="POST" onsubmit="procesar(this.action);" >
                               <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                               <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden" readonly>
                               <input name="calculadoraMostrar" value="<?php echo $muestraCalculadora; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
        }
        
        
}elseif(isset($_POST['AgregarVariablesDesaplicar'])){
    
    $quienCrea= $_POST['quienCrea']; /// quienCrea
    $idContinuaIndicador=$_POST['id']; //// idIndicadorVariable
    $muestraCalculadora=$_POST['calculadoraMostrar']; // mantiene la calculadora activa
    $variablesIdPrincipal=$_POST['variablesIdPrincipal']; //// idIndicador
    $desaplicar=$_POST['desaplicar']; //// id para desaplicar
   
   
    
    $mysqli->query("DELETE FROM indicadoresVariablesAsociadas WHERE id='$desaplicar'  ")or die(mysqli_error($mysqli));
    
        
        if($mysqli != NULL){
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresAgregar2" method="POST" onsubmit="procesar(this.action);" >
                               <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                               <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden" readonly>
                               <input name="calculadoraMostrar" value="<?php echo $muestraCalculadora; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
        }
        
        
}elseif(isset($_POST['AgregarFormula'])){
    $quienCrea= $_POST['quienCrea']; /// quienCrea
    $variablesIdPrincipal=$_POST['variablesIdPrincipal']; //// idIndicador
    $formula=$_POST['formula'];
    
    $mysqli->query("UPDATE indicadores SET  formula='$formula', terminar='Pendiente3'   WHERE id = '$variablesIdPrincipal'  ")or die(mysqli_error($mysqli));
    
    
    if($mysqli != NULL){
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresAgregar3" method="POST" onsubmit="procesar(this.action);" >
                               <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                               <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
        }
    
}elseif(isset($_POST['AgregarZonas'])){ 
    
    $quienCrea= $_POST['quienCrea']; /// quienCrea
    $variablesIdPrincipal=$_POST['variablesIdPrincipal']; //// idIndicador
    
    $metas=$_POST['metas'];
    $unidad=utf8_decode($_POST['unidad']);
    $metaActual=utf8_decode($_POST['metaActual']);
    $desde=$_POST['desde'];
    $hasta=$_POST['hasta'];
    
    $zp=$_POST['zp'];
    $za=$_POST['za'];
    $zc=$_POST['zc'];
    $ze=$_POST['ze'];
    
    $validacion = $mysqli->query("SELECT * FROM indicadoresMetas WHERE metaActual = '$metaActual' AND quienCrea='$quienCrea' AND idIndicador='$variablesIdPrincipal' ")or die (mysqli_error());
    $numRows = mysqli_num_rows($validacion);
    if($numRows > 0){ 
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("La meta ya existe");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadoresAgregar3" method="POST" onsubmit="procesar(this.action);" >
                                 <input type="hidden" name="validacionExiste" value="1">
                               <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                               <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden" readonly>
                            </form>
                            
                        <?php
    }else{
        date_default_timezone_set('America/Bogota');$fecha1=date('Y-m-j');
        $anoPresente = intval(substr($fecha1, 0, 4)); // variable anterior $indicadorDesde                                  
        //$anoPresente = substr($hasta, 0, 4);                                  
            
             $consultaIndicador=$mysqli->query("SELECT * FROM indicadores WHERE id='$variablesIdPrincipal'");
        $extraerConsultaIndicador=$consultaIndicador->fetch_array(MYSQLI_ASSOC);
        $nombreDocEnviar=utf8_encode($extraerConsultaIndicador['nombre']);
        $radiobtn=$extraerConsultaIndicador['radioIndicador'];
        $arrayEncargado=json_decode($extraerConsultaIndicador['resposableIndicador']);
        
            
                require '../usuarios/libreria/PHPMailerAutoload.php';
    
                $radiobtn;
                //$arrayEncargado=$_POST['select_encargadoRI'];
                //$nombreDocEnviar=$_POST['nombre'];
                if($radiobtn == 'usuario'){ 
                    $longitud = count($arrayEncargado); 
                    for($i=0; $i<$longitud; $i++){
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargado[$i]' ");
                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        
                        

                                            

                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                            
                                            //Configuracion servidor mail
                                            require '../../correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correoResponsable);
                                            $mail->Subject = utf8_decode('Responsable del indicador '.$nombreDocEnviar);
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
                                            <p>El indicador <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su revisión.</p>
                                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                            <br>
                                            <em>Mi perfil --> mis pendientes --> Indicadores --> responsable del indicador +</em>.
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
                                            
                                            } else {

                                            }
                                        
                                            
                    }
                }

                if($radiobtn == 'cargo'){
                
                    $longitud = count($arrayEncargado);
                    for($i=0; $i<$longitud; $i++){ 
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo='$arrayEncargado[$i]' ");
                        while($columna = $nombreuser->fetch_array()){
                             $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                             $correoResponsable=$columna['correo']; 
                            '<br>';
                            
                            //Create a new PHPMailer instance
                            $mail = new PHPMailer();
                            $mail->IsSMTP();
                            
                            //Configuracion servidor mail
                            require '../../correoEnviar/contenido.php';
                            
                            //Agregar destinatario
                            $mail->isHTML(true);
                            $mail->AddAddress($correoResponsable);
                            $mail->Subject = utf8_decode('Responsable del indicador '.$nombreDocEnviar);
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
                            <p>El indicador <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su revisión.</p>
                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                            <br>
                            <em>Mi perfil --> mis pendientes --> Indicadores --> responsable del indicador +</em>.
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
                            
                            } else {

                            }
                        
                            
                        }
                    }
                }
            
            
            $radiobtnC=$extraerConsultaIndicador['radioCalculo'];
            $arrayEncargadoB=json_decode($extraerConsultaIndicador['responsableCalculo']);
              
                $radiobtn;
                //$arrayEncargadoB=$_POST['select_encargadoC'];
                //$nombreDocEnviar=$_POST['nombre'];
                if($radiobtnC == 'usuario'){ 
                    $longitud = count($arrayEncargadoB); 
                    for($i=0; $i<$longitud; $i++){
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargadoB[$i]' ");
                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        
                        

                                            

                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                            
                                            //Configuracion servidor mail
                                            require '../../correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correoResponsable);
                                            $mail->Subject = utf8_decode('Responsable del calculo indicador '.$nombreDocEnviar);
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
                                            <p>El indicador <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su revisión.</p>
                                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                            <br>
                                            <em>Mi perfil --> mis pendientes --> Indicadores --> responsable del calculo +</em>.
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
                                            
                                            } else {

                                            }
                                        
                                            
                    }
                }

                if($radiobtnC == 'cargo'){

                    $longitud = count($arrayEncargadoB);
                    for($i=0; $i<$longitud; $i++){ 
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo='$arrayEncargadoB[$i]' ");
                        while($columna = $nombreuser->fetch_array()){
                            $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                            $correoResponsable=$columna['correo']; 
                            '<br>';
                            
                            //Create a new PHPMailer instance
                            $mail = new PHPMailer();
                            $mail->IsSMTP();
                            
                            //Configuracion servidor mail
                            require '../../correoEnviar/contenido.php';
                            
                            //Agregar destinatario
                            $mail->isHTML(true);
                            $mail->AddAddress($correoResponsable);
                            $mail->Subject = utf8_decode('Responsable del calculo indicador '.$nombreDocEnviar);
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
                            <p>El indicador <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su revisión.</p>
                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                            <br>
                            <em>Mi perfil --> mis pendientes --> Indicadores --> responsable del calculo +</em>.
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
                            
                            } else {

                            }
                        
                            
                        }
                    }
                }
                
            $mysqli->query("INSERT INTO indicadoresMetas (idIndicador,quienCrea,metas,unidad,metaActual,desde,hasta,anoPresente,zp,za,zc,ze)
            VALUES('$variablesIdPrincipal','$quienCrea','$metas','$unidad','$metaActual','$desde','$hasta','$anoPresente','$zp','$za','$zc','$ze')")or die(mysqli_error($mysqli));
            $mysqli->query("UPDATE indicadores SET terminar='Terminado', plataformaH='1' WHERE id='$variablesIdPrincipal' ")or die(mysqli_error($mysqli));
            if($mysqli != NULL){
        
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadores" method="POST" onsubmit="procesar(this.action);" >
                               <input type="hidden" name="validacionAgregar" value="1">
                               <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                               <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden" readonly>
                            </form> <!-- indicadoresAgregar3 -->
                            
                        <?php
                        
        }
    }
    
    
    
}elseif(isset($_POST['AgregarZonasB'])){ 
    
    $quienCrea= $_POST['quienCrea']; /// quienCrea
    $variablesIdPrincipal=$_POST['variablesIdPrincipal']; //// idIndicador
    
    $metas=$_POST['metas'];
   
   
        date_default_timezone_set('America/Bogota');$fecha1=date('Y-m-j');
        $anoPresente = intval(substr($fecha1, 0, 4)); // variable anterior $indicadorDesde                                  
        //$anoPresente = substr($hasta, 0, 4);                
        
        $consultaIndicador=$mysqli->query("SELECT * FROM indicadores WHERE id='$variablesIdPrincipal'");
        $extraerConsultaIndicador=$consultaIndicador->fetch_array(MYSQLI_ASSOC);
        $nombreDocEnviar=utf8_encode($extraerConsultaIndicador['nombre']);
        $radiobtn=$extraerConsultaIndicador['radioIndicador'];
        $arrayEncargado=json_decode($extraerConsultaIndicador['resposableIndicador']);
        
            
                require '../usuarios/libreria/PHPMailerAutoload.php';
    
                $radiobtn;
                //$arrayEncargado=$_POST['select_encargadoRI'];
                //$nombreDocEnviar=$_POST['nombre'];
                if($radiobtn == 'usuario'){ 
                    $longitud = count($arrayEncargado); 
                    for($i=0; $i<$longitud; $i++){
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargado[$i]' ");
                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        
                        

                                            

                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                            
                                            //Configuracion servidor mail
                                            require '../../correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correoResponsable);
                                            $mail->Subject = utf8_decode('Responsable del indicador '.$nombreDocEnviar);
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
                                            <p>El indicador <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su revisión.</p>
                                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                            <br>
                                            <em>Mi perfil --> mis pendientes --> Indicadores --> responsable del indicador +</em>.
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
                                            
                                            } else {

                                            }
                                        
                                            
                    }
                }

                if($radiobtn == 'cargo'){
                
                    $longitud = count($arrayEncargado);
                    for($i=0; $i<$longitud; $i++){ 
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo='$arrayEncargado[$i]' ");
                        while($columna = $nombreuser->fetch_array()){
                             $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                             $correoResponsable=$columna['correo']; 
                            '<br>';
                            
                            //Create a new PHPMailer instance
                            $mail = new PHPMailer();
                            $mail->IsSMTP();
                            
                            //Configuracion servidor mail
                            require '../../correoEnviar/contenido.php';
                            
                            //Agregar destinatario
                            $mail->isHTML(true);
                            $mail->AddAddress($correoResponsable);
                            $mail->Subject = utf8_decode('Responsable del indicador '.$nombreDocEnviar);
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
                            <p>El indicador <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su revisión.</p>
                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                            <br>
                            <em>Mi perfil --> mis pendientes --> Indicadores --> responsable del indicador +</em>.
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
                            
                            } else {

                            }
                        
                            
                        }
                    }
                }
            
            
            $radiobtnC=$extraerConsultaIndicador['radioCalculo'];
            $arrayEncargadoB=json_decode($extraerConsultaIndicador['responsableCalculo']);
              
                $radiobtn;
                //$arrayEncargadoB=$_POST['select_encargadoC'];
                //$nombreDocEnviar=$_POST['nombre'];
                if($radiobtnC == 'usuario'){ 
                    $longitud = count($arrayEncargadoB); 
                    for($i=0; $i<$longitud; $i++){
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$arrayEncargadoB[$i]' ");
                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                        $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                        $correoResponsable=$columna['correo']; 
                        '<br>';
                        
                        

                                            

                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                            
                                            //Configuracion servidor mail
                                            require '../../correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correoResponsable);
                                            $mail->Subject = utf8_decode('Responsable del calculo indicador '.$nombreDocEnviar);
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
                                            <p>El indicador <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su revisión.</p>
                                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                                            <br>
                                            <em>Mi perfil --> mis pendientes --> Indicadores --> responsable del calculo +</em>.
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
                                            
                                            } else {

                                            }
                                        
                                            
                    }
                }

                if($radiobtnC == 'cargo'){

                    $longitud = count($arrayEncargadoB);
                    for($i=0; $i<$longitud; $i++){ 
                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE cargo='$arrayEncargadoB[$i]' ");
                        while($columna = $nombreuser->fetch_array()){
                            $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                            $correoResponsable=$columna['correo']; 
                            '<br>';
                            
                            //Create a new PHPMailer instance
                            $mail = new PHPMailer();
                            $mail->IsSMTP();
                            
                            //Configuracion servidor mail
                            require '../../correoEnviar/contenido.php';
                            
                            //Agregar destinatario
                            $mail->isHTML(true);
                            $mail->AddAddress($correoResponsable);
                            $mail->Subject = utf8_decode('Responsable del calculo indicador '.$nombreDocEnviar);
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
                            <p>El indicador <b>'.$nombreDocEnviar.'.</b> se encuentra pendiente para su revisión.</p>
                            Se recomienda ingresar al sistema y realizar la actividad encargada establecida en la siguiente ruta:
                            <br>
                            <em>Mi perfil --> mis pendientes --> Indicadores --> responsable del calculo +</em>.
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
                            
                            } else {

                            }
                        
                            
                        }
                    }
                }
                                          
            $mysqli->query("INSERT INTO indicadoresMetas (idIndicador,quienCrea,metas)
            VALUES('$variablesIdPrincipal','$quienCrea','No')")or die(mysqli_error($mysqli));
            $mysqli->query("UPDATE indicadores SET terminar='Terminado', plataformaH='1' WHERE id='$variablesIdPrincipal' ")or die(mysqli_error($mysqli));
            if($mysqli != NULL){
        
                        ?>
                            <script>
                                    window.onload=function(){
                                        //alert("");
                                        document.forms["miformulario"].submit();
                                        }
                            </script>
                            <form name="miformulario" action="../../indicadores" method="POST" onsubmit="procesar(this.action);" >
                               <input type="hidden" name="validacionAgregar" value="1">
                               <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden" readonly>
                               <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden" readonly>
                            </form> <!-- indicadoresAgregar3 -->
                            
                        <?php
                        
        }
    
    
    
    
}elseif(isset($_POST['Eliminar'])){ /// elimina el indicador y lo que contiene el indicador
    
    $id= $_POST['id'];
    $mysqli->query("DELETE from indicadores  WHERE id = '$id'")or die(mysqli_error($mysqli));
    $mysqli->query("DELETE FROM indicadoresVariablesAsociadas WHERE idIndicador = '$id'  ")or die(mysqli_error($mysqli));
    $mysqli->query("DELETE FROM indicadoresMetas WHERE idIndicador = '$id'  ")or die(mysqli_error($mysqli));
    $mysqli->query("DELETE FROM indicadoresVariables WHERE idIndicador = '$id'  ")or die(mysqli_error($mysqli));
    $mysqli->query("DELETE FROM indicadoresGestionar WHERE idIndicador = '$id'  ")or die(mysqli_error($mysqli));
    //header ('location: ../../indicadores');
        ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="../../indicadores" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionEliminar" value="1">
            </form> 
        <?php
    
}elseif(isset($_POST['eliminandoAnalisis'])){
    $eliminarAnalisis=$_POST['eliminarAnalisis'];
    $NombreEliminarAnalisis=$_POST['NombreEliminarAnalisis'];
    $quienCrea=$_POST['quienCrea'];
    $variablesIdPrincipal=$_POST['variablesIdPrincipal'];
    
    $filename = '../../archivos/indicadores/'.$NombreEliminarAnalisis;
    
    if($quienCrea != NULL){
        if (file_exists($filename)) {
            $success = unlink($filename);
            
            if (!$success) {
                 throw new Exception("Cannot delete $filename");
            }
        } 
    }
     $mysqli->query("DELETE FROM indicadoresGestionar WHERE id = '$eliminarAnalisis'  ")or die(mysqli_error($mysqli));
                                ?>
                                    <script>
                                            window.onload=function(){
                                                //alert("Datos almacenados con éxito ");
                                                document.forms["miformulario"].submit();
                                                }
                                    </script>
                                    <form name="miformulario" action="../../indicadoresGestionar" method="POST" onsubmit="procesar(this.action);" >
                                         <input type="hidden" name="validacionEliminar" value="1">
                                        <input name="quienCrea" value="<?php echo $quienCrea; ?>" type="hidden">
                                        <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" type="hidden">
                                    </form>
                                    
                                <?php
    
}
  
?>