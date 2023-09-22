<html>
<head>
<style>
/**
Establezca los márgenes de la página en 0, por lo que el pie de página y el encabezado
puede ser de altura y anchura completas.
**/

/*@page {
/*margin: 0cm 0cm;*/
/*margin: 0cm;
size: A4;
}*/

@page { 
    size: A4; margin: 0; 
} 

.page_break {
        page-break-before: always;
    }


/** Defina ahora los márgenes reales de cada página en el PDF **/
main {
font-family: "Source Sans Pro",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
margin-top: 1.5cm; /*arriba*/
margin-left: 1.9cm; /*izquierda*/
margin-right: 1.9cm; /*derecha*/
margin-bottom: 2cm; /*abajo*/
}

/** Definir las reglas del encabezado **/
header {
position: fixed; /*fixed*/
top: 0cm;
left: 0cm;
right: 0cm;
height: 2cm;

/** Estilos extra personales **/
background-color: #03a9f4;
color: white;
text-align: center;
line-height: 1.5cm;
}

/** Definir las reglas del pie de página **/
footer {
position: fixed;
bottom: 0cm;
left: 0cm;
right: 0cm;
height: 2cm;


/** Estilos extra personales **/
background-color: #03a9f4;
color: white;
text-align: center;
line-height: 1.5cm;
}
</style>
</head>
<body>
<?php
    require '../conexion/bd.php';
    $idActa =$_POST['idActa'];
                                $nombrePlantilla = $_POST['id'];
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $acta = $mysqli->query("SELECT * FROM actas WHERE id = '$idActa' ");
                                while($col = $acta->fetch_assoc()) { 
                                    $nombreActa = $col['nombreActa'];
                                    $proceso = $col['proceso'];
                                    $ubicacion = $col['ubicacion'];
                                    $fechaini = $col['fechaInicio'];
                                    $fechaCierre = $col['fechaCierre'];
                                    $quienCita = $col['quienCita'];
                                    $quienCitaID =  json_decode($col['quienCitaID']); 
                                    //var_dump($quienCitaID);
                                    $longitud = count($quienCitaID);
                                    $quienElabora = $col['quienElabora'];
                                    $quienElaboraID = json_decode($col['quienElaboraID']);
                                    $longitud2 = count($quienElaboraID);
                                    $aprobacion = $col['aprobacionCompromisos'];
                                    $compromisos = $col['compromisos'];
                                    $compromisosID = json_decode($col['compromisosID']);
                                    ///acta requiere arpovacion 
                                    $radioActaSiNO = $col['aprobarActa'];//requiere compromisos
                                    $radioActaTipo = $col['quienAprueba'];//quien compromisos
                                    $selectActaAprobacion = json_decode($col['quienApruebaId']);
                                    $longitudActas = count($selectActaAprobacion);
                                    
                                    if($compromisosID != NULL){
                                        $longitud3 = count($compromisosID);
                                    }
                                    $convocados = $col['convocado'];
                                    $convocadosID = json_decode($col['convocadoID']);
                                    $convocadosID2 = json_decode($col['convocadoID']);
                                    $longitud4 = count($convocadosID);
                                    $asistentes = $col['asistente'];
                                    $asistentesID = json_decode($col['asistenteID']);
                                    $longitud5 = count($asistentesID);
                                    //aqui va todo lo de EXTERNOS
                                    $jsonConvocado = json_decode($col['nombreConvocadoEXT']);
                                    if($jsonConvocado != NULL){
                                        $longitud6 = count($jsonConvocado);
                                    }
                                    $jsonTipo = json_decode($col['tipoEmpresaCovEXT']);
                                    if($jsonTipo != NULL){
                                        $longitud7 = count($jsonTipo);
                                    }
                                    $jsonNombre = json_decode($col['nombreEmpresa']);
                                    if($jsonNombre != NULL){
                                        $longitud8 = count($jsonNombre);
                                    }
                                    $jsonCargo = json_decode($col['cargoConvocadoEXT']);
                                    //var_dump($jsonCargo);
                                    if($jsonCargo != NULL){
                                        $longitud9 = count($jsonCargo);
                                    }
                                    
                                    ///////
                                    
                                    $permisoActa = $col['permisosActa'];  /// usuario, grupo o cargo
                                    $publico = $col['publico'];  // si o no
                                    $responsablesID = json_decode($col['responsablesActa']); 
                                    if($responsablesID != NULL){
                                        $longitud10 = count($responsablesID);
                                    }
                                    $editor = $col['acta'];
                                    $comentario = $col['comentario'];
                                    $estado = $col['estado'];
                                    $idEncabezado=$col['idEncabezado'];
                                    $idEncabezadoPlantilla=$col['idEncabezadoPlantilla'];
                                }
    ?>
<!-- Envuelva el contenido de su PDF dentro de una etiqueta principal -->
<main id="maininformacion" style="background:;size:A4;display: block;break-before: always; page-break-before: always;">
    
    
    <p style="text-align:justify;">
        
        
        
                <?php
                if($idEncabezado != NULL){
                    $queryEncabezado = $mysqli->query("SELECT * FROM encabezado WHERE id = '$idEncabezado' ");
                    $encabezado = $queryEncabezado->fetch_array(MYSQLI_ASSOC);
                    echo $encabezado['encabezado'];
                }else{
                    $queryEncabezado = $mysqli->query("SELECT * FROM encabezado WHERE principal = '1' ");
                    $encabezado = $queryEncabezado->fetch_array(MYSQLI_ASSOC);
                    echo $encabezado['encabezado'];
                }
                ?>                   
        <br>
        <div class="row" style="text-align:justify;">
            <table width="100%">
                <tr>
                    <td>
                        <div class="form-group col-md-6">
                            <label for=""><b>Nombre:</b></label>
                            <?php echo $nombreActa; ?>
                        </div>
                    </td>
                    <td>
                        <div class="form-group col-md-6">
                            <label><b>Proceso:</b></label>
                            <?php
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $resultado = $mysqli->query("SELECT * FROM procesos ORDER BY id");
                            while($row = $resultado->fetch_assoc()) { 
                                if($row['id'] == $proceso){
                                    $selectPro = "selected";
                                    echo $row['nombre'];
                                }
                            } 
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1"><b>Ubicación:</b></label>
                            <?php echo $ubicacion; ?>
                        </div>
                    </td>
                    <td>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1"><b>Fecha y hora de inicio:</b></label>
                            <?php echo date('Y/m/d h:i A', strtotime($fechaini));?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1"><b>Fecha y hora de cierre:</b></label>
                            <?php echo date('Y/m/d h:i A', strtotime($fechaCierre));?>
                        </div>
                    </td>
                    <td>
                        <div class="form-group col-md-6">
                            <label><b>Quién Cita:</b></label><br>
                            <label for="usuarios"><?php  $quienCita;?></label>
                            <?php 
                            if($quienCita == 'usuario'){
                                                                    
                                for($i=0; $i<$longitud; $i++){
                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $nombreuser = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$quienCitaID[$i]'");
                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                    echo $columna['nombres']." ".$columna['apellidos'];echo "<br>";
                                                                     
                                }
                                                                 
                            }else{
                                                                    
                                for($i=0; $i<$longitud; $i++){
                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienCitaID[$i]'");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    echo $columna['nombreCargos'];echo "<br>";
                                }
                            }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group col-md-6">
                            <label><b>Quién Elabora:</b></label><br>
                            <p>
                            <?php 
                            if($quienElabora == 'usuario'){
                                                            
                                for($i=0; $i<$longitud2; $i++){
                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $nombreuser2 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$quienElaboraID[$i]'");
                                    $columna2 = $nombreuser2->fetch_array(MYSQLI_ASSOC);
                                    echo $columna2['nombres']." ".$columna2['apellidos'];echo "<br>";
                                }
                                                             
                            }else{
                                                                
                                for($i=0; $i<$longitud2; $i++){
                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $nombrecargo2 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienElaboraID[$i]'");
                                    $columna2 = $nombrecargo2->fetch_array(MYSQLI_ASSOC);
                                    echo $columna2['nombreCargos'];echo "<br>";
                                }
                            }
                            ?>
                        </div>
                    </td>
                    <td>
                        <div class="form-group col-md-6">
                            <label><b>¿El acta necesita de aprobación? :</b></label><br>
                            <?php
                            if($radioActaSiNO == 'si'){
                                    echo "Si";
                                ?>
                                <p>
                                <?php 
                                if($radioActaTipo == 'usuario'){
                                                                    
                                    for($i=0; $i<$longitudActas; $i++){
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $nombreuser3 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$selectActaAprobacion[$i]'");
                                        $columna3 = $nombreuser3->fetch_array(MYSQLI_ASSOC);
                                        echo $enviarNombreRechazo=$columna3['nombres']." ".$columna3['apellidos'];echo "<br>";
                                    }
                                }else{
                                                                    
                                    for($i=0; $i<$longitudActas; $i++){
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $nombrecargo3 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$selectActaAprobacion[$i]'");
                                        $columna3 = $nombrecargo3->fetch_array(MYSQLI_ASSOC);
                                        echo $enviarNombreRechazo=$columna3['nombreCargos'];echo "<br>";
                                    }
                                }
                                ?>
                                </p>
                                <?php
                            }else{
                                echo "No";
                            }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group col-md-6">
                            <label><b>Estado del acta:</b></label><br>
                            <?php
                            echo $estado;
                            ?>
                        </div>
                    </td>
                    <td>
                        <div class="form-group col-md-6">
                            <label><b>Convocados:</b></label><br>
                            <p>
                            <?php 
                            if($convocados == 'usuario'){
                                                                
                                for($i=0; $i<$longitud4; $i++){
                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $nombreuser4 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$convocadosID[$i]'");
                                    $columna4 = $nombreuser4->fetch_array(MYSQLI_ASSOC);
                                    echo $columna4['nombres']." ".$columna4['apellidos'];echo "<br>";
                                                                 
                                }
                                                             
                            }else{
                                                                
                                for($i=0; $i<$longitud4; $i++){
                                    //echo $convocadosID2[$i];
                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $nombrecargo4 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$convocadosID2[$i]'");
                                    $columna4 = $nombrecargo4->fetch_array(MYSQLI_ASSOC);
                                    echo $columna4['nombreCargos'];echo "<br>";
                                }
                            }
                            ?>
                            </p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group col-md-6">
                            <label><b>Asistentes:</b></label><br>
                            <p>
                            <?php 
                            if($asistentes == 'usuario'){
                                                            
                                for($i=0; $i<$longitud5; $i++){
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $nombreuser5 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$asistentesID[$i]'");
                                $columna5 = $nombreuser5->fetch_array(MYSQLI_ASSOC);
                                                        
                                echo $columna5['nombres']." ".$columna5['apellidos'];echo "<br>";
                                                         
                                }
                                                             
                            }else{
                                                                
                                for($i=0; $i<$longitud5; $i++){
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $nombrecargo5 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$asistentesID[$i]'");
                                $columna5 = $nombrecargo5->fetch_array(MYSQLI_ASSOC);
                                echo $columna5['nombreCargos'];echo "<br>";
                                }
                            }
                            ?>
                        </div>
                    </td>
                </tr>
            </table>
            <?php
            /// preguntamos si existe registro en convocado
            if($jsonConvocado == ",,,,,,,,,"){ }else{
            ?><br><br>
            <table width="100%">
                <tr>
                    <td>
                        <div class="col-3">   
                            <label for=""><b>Nombres:</b></label><br><br>
                            <?php
                            $arrayConvocados = explode(',',$jsonConvocado);
                            foreach($arrayConvocados as $convocado){
                              
                                if($convocado == ''){
                                    continue;
                                }else{
                                    echo $convocado;echo"<br>";  
                                }
                                                        
                            }
                            ?>
                        </div>
                    </td>
                    <td>
                        <div class="col-3">
                            <label for=""><b>Tipos Empresa:</b></label><br><br>
                            <?php
                            $arrayTipo = explode(',',$jsonTipo);
                            foreach($arrayTipo as $tipo){
                                  
                                if($tipo == ''){
                                    continue;
                                }else{
                                    echo $tipo;echo"<br>";  
                                }
                            }
                            ?>
                        </div>
                    </td>
                    <td>
                        <div class="col-3">
                            <label for=""><b>Empresa:</b></label><br><br>
                            <?php
                            $arrayEmpresaNombre = explode(',',$jsonNombre);
                            foreach($arrayEmpresaNombre as $nombreE){
                                  
                                if($nombreE == ''){
                                    continue;
                                }else{
                                    echo $nombreE;echo"<br>";  
                                }
                                                    
                            }
                            ?>
                        </div>
                    </td>
                    <td>
                        <div class="col-3">
                            <label for=""><b>Cargo:</b></label><br><br>
                            <?php
                            $arrayCargos = explode(',', $jsonCargo);
                            //print_r($arrayCargos);
                                                //echo $longitud9;
                                                foreach($arrayCargos as $cargo){
                                  
                                if($cargo == ''){
                                    continue;
                                }else{
                                    echo $cargo;echo"<br>";  
                                }
                            }
                            ?>
                        </div>
                    </td>
                </tr>
            </table>
            <?php
            }
            ?>
            <br>
            <div class="row">
                <div class="form-group col-md-"> <!-- 12 -->
                                        <label><b>¿Acta abierta a todo público? :</b></label><br>
                                        <?php
                                        if($publico == 'no'){
                                                echo "No";
                                            ?>
                                            <br>
                                            <label>Autorizados para visualizar: </label><br>
                                                        
                                            <?php 
                                            if($permisoActa == 'usuario'){
                                                                
                                                for($i=0; $i<$longitud10; $i++){
                                                                
                                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                    $nombreuser6 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$responsablesID[$i]'");
                                                    $columna6 = $nombreuser6->fetch_array(MYSQLI_ASSOC);
                                                                
                                                    echo $columna6['nombres']." ".$columna6['apellidos'];echo "<br>";
                                                     
                                                }
                                                             
                                            }elseif($permisoActa == 'grupo'){
                                                                
                                                                
                                                for($i=0; $i<$longitud10; $i++){
                                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                    $nombrecargo6 = $mysqli->query("SELECT nombre FROM grupo WHERE id = '$responsablesID[$i]'");
                                                    $columna6 = $nombrecargo6->fetch_array(MYSQLI_ASSOC);
                                                    echo $columna6['nombre'];echo "<br>";
                                                }
                                            }else{
                                                                
                                                                
                                                for($i=0; $i<$longitud10; $i++){
                                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                    $nombrecargo6 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$responsablesID[$i]'");
                                                    $columna6 = $nombrecargo6->fetch_array(MYSQLI_ASSOC);
                                                    echo $columna6['nombreCargos'];echo "<br>";
                                                }
                                            }
                                        
                                        
                                        }else{
                                            echo "Si";
                                        }
                                        ?>
                                        <br><br>
                                        <label><b>Seguimiento del acta:</b></label>
                                                    
                                                    
                                        <?php
                                            $consultaSeguimiento = $mysqli->query("SELECT * FROM actas WHERE id = '$idActa'");
                                            $extraerContenidoActa = $consultaSeguimiento->fetch_array(MYSQLI_ASSOC);
                                            echo $contenidoDelActa = $extraerContenidoActa['acta'];
                                            //echo nl2br($contenidoDelActa);
                                        ?>
                </div>
            </div>
        </div>
        <br>
        <?php
        $acentos = $mysqli->query("SET NAMES 'utf8'");
        $compromisos = $mysqli->query("SELECT * FROM compromisos WHERE idActa = '$idActa' ORDER BY id ASC");
                    
        if(mysqli_num_rows($compromisos) > 0){
        ?>
        <div>
            <center><h3>COMPROMISOS </h3></center><br>
            <?php
            $n = 1;
            while($col = $compromisos->fetch_assoc()) {
                $compromiso = $col['compromiso'];
                $responsableCompromiso = $col['responsableCompromiso'];
                $responsableCompromisoID =  json_decode($col['responsableID']);
                $longitud11 = count($responsableCompromisoID);
                $fechaPrimera =  $col['fechaEntrega'];
                $fechaFormato = date('Y/m/d h:i A', strtotime($fechaPrimera));
                                                    
                $entregarA = $col['entregarA'];
                $entregarAID =  json_decode($col['entregarAID']);
                $longitud12 = count($entregarAID);
                $estadoCompromiso=$col['estado'];
                                                    
            ?>
            <div class="form-group col-md-6">
                <h3>Compromiso N° <?php echo $n;?></h3>
            </div>
            <br>
            <div class="row">
                <table width="100%">
                    <tr>
                        <td>
                            <div class="form-group col-md-6">
                                <label><b>Detalles del compromiso:</b></label><br>
                                <span><?php echo $compromiso;?></span>
                            </div>
                        </td>
                        <td>
                            <div class="form-group col-md-6">
                                <label><b>Estado:</b></label><br>
                                <span><?php echo $estadoCompromiso;?></span>
                            </div> 
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group col-sm-6">
                                <label><b>Responsable:</b></label><br>
                                <p>
                                <?php 
                                if($responsableCompromiso == 'usuario'){
                                                                    
                                                                    for($i=0; $i<$longitud11; $i++){
                                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                                        $nombreuser11 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$responsableCompromisoID[$i]'");
                                                                        $columna11 = $nombreuser11->fetch_array(MYSQLI_ASSOC);
                                                                    
                                                                        
                                                                                    $idCompromiso=$col['id'];
                                                                                    $queryArhivo = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso' AND id_responsable = '$responsableCompromisoID[$i]' ORDER BY id DESC");
                                                                                    $datosArchivo = $queryArhivo->fetch_array(MYSQLI_ASSOC);
                                                                                    $existeArchivo = $datosArchivo['rutaAvance'];
                                                                                    utf8_decode($rutaArchivo = "archivos/compromisos/acta".$idActa."/".$datosArchivo['rutaAvance']);
                                                                                    $estadoCompromiso = $datosArchivo['estado'];
                                                                    
                                                                            echo $columna11['nombres']." ".$columna11['apellidos'];  echo "<br><br>"; 
                                                                    }
                                                                 
                                }else{
                                    for($i=0; $i<$longitud11; $i++){
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $nombrecargo11 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$responsableCompromisoID[$i]'");
                                        $columna11 = $nombrecargo11->fetch_array(MYSQLI_ASSOC);
                                                                    
                                                                    
                                        $idCompromiso=$col['id'];
                                        $queryArhivo = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso' AND id_responsable = '$responsableCompromisoID[$i]' ORDER BY id DESC");
                                        $datosArchivo = $queryArhivo->fetch_array(MYSQLI_ASSOC);
                                        $existeArchivo = $datosArchivo['rutaAvance'];
                                        utf8_decode($rutaArchivo = "archivos/compromisos/acta".$idActa."/".$datosArchivo['rutaAvance']);
                                        $estadoCompromiso = $datosArchivo['estado'];
                                                                    
                                                                    
                                        echo $columna11['nombreCargos'];echo "<br><br>";
                                    }
                                }
                                ?>
                                </p>
                            </div>
                        </td>
                        <td>
                            <div class="form-group col-md-6">
                                <label style="color:transparent;"><b>Descargar:</b></label><br>
                                <p>
                                <?php 
                                if($responsableCompromiso == 'usuario'){
                                                                    
                                    for($i=0; $i<$longitud11; $i++){
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $nombreuser11 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$responsableCompromisoID[$i]'");
                                        $columna11 = $nombreuser11->fetch_array(MYSQLI_ASSOC);
                                                                    
                                                                        
                                        $idCompromiso=$col['id'];
                                        $queryArhivo = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso' AND id_responsable = '$responsableCompromisoID[$i]' ORDER BY id DESC");
                                        $datosArchivo = $queryArhivo->fetch_array(MYSQLI_ASSOC);
                                        $existeArchivo = $datosArchivo['rutaAvance'];
                                        utf8_decode($rutaArchivo = "archivos/compromisos/acta".$idActa."/".$datosArchivo['rutaAvance']);
                                        $estadoCompromiso = $datosArchivo['estado'];
                                                                    
                                                                          
                                        /*if($datosArchivo['rutaAvance'] != NULL){
                                ?>
                                            <button style="color: #1f2d3d;background-color: #ffc107;border-color: #ffc107;box-shadow: none;" type='button'  class='btn btn-warning btn-sm' <?php echo $disabledDownload;?>>
                                                <a style='color:black' href='<?php echo $rutaArchivo;?>' target="_blank"><i class='fas fa-download'></i> Descargar evidencia</a>
                                            </button>
                                <?php
                                        }else{
                                ?>
                                            <button style="color: #1f2d3d;background-color: #ffc107;border-color: #ffc107;box-shadow: none;" disabled  class='btn btn-warning btn-sm' <?php echo $disabledDownload;?>>
                                                <a style='color:black'><i class='fas fa-download'></i> Descargar evidencia</a>
                                            </button>
                                <?php
                                        }*/
                                echo "<br><br>";
                                                                            
                                    }
                                                                 
                                }else{
                                                                    
                                    for($i=0; $i<$longitud11; $i++){
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $nombrecargo11 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$responsableCompromisoID[$i]'");
                                        $columna11 = $nombrecargo11->fetch_array(MYSQLI_ASSOC);
                                                                    
                                                                    
                                        $idCompromiso=$col['id'];
                                        $queryArhivo = $mysqli->query("SELECT * FROM `compromisosIndividuales` WHERE id_compromiso = '$idCompromiso' AND id_responsable = '$responsableCompromisoID[$i]' ORDER BY id DESC");
                                        $datosArchivo = $queryArhivo->fetch_array(MYSQLI_ASSOC);
                                        $existeArchivo = $datosArchivo['rutaAvance'];
                                        utf8_decode($rutaArchivo = "archivos/compromisos/acta".$idActa."/".$datosArchivo['rutaAvance']);
                                        echo $estadoCompromiso = $datosArchivo['estado'];
                                                                    
                                                                   
                                        /*                                   
                                        if($datosArchivo['rutaAvance'] != NULL){
                                ?>
                                            <button style="color: #1f2d3d;background-color: #ffc107;border-color: #ffc107;box-shadow: none;" type='button'  class='btn btn-warning btn-sm' <?php echo $disabledDownload;?>>
                                            <a style='color:black' href='<?php echo $rutaArchivo;?>' target="_blank"><i class='fas fa-download'></i> Descargar evidencia</a>
                                            </button>
                                <?php
                                        }else{
                                ?>
                                            <button style="color: #1f2d3d;background-color: #ffc107;border-color: #ffc107;box-shadow: none;" disabled  class='btn btn-warning btn-sm' <?php echo $disabledDownload;?>>
                                            <a style='color:black'><i class='fas fa-download'></i> Descargar evidencia</a>
                                            </button>         
                                                                     
                                <?php
                                        } */
                                        echo "<br><br>";
                                    }
                                }
                                                                
                                ?>
                                </p>
                            </div> 
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group col-md-6">
                                <label><b>Fecha entrega:</b></label><br>
                                    <span><?php echo $fechaFormato;?></span>
                            </div>
                        </td>
                        <td>
                            <div class="form-group col-sm-6">
                                <label><b>Entregar a:</b></label><br>
                                <p>
                                <?php 
                                if($entregarA == 'usuario'){
                                                                    
                                    for($i=0; $i<$longitud12; $i++){
                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $nombreuser12 = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$entregarAID[$i]'");
                                    $columna12 = $nombreuser12->fetch_array(MYSQLI_ASSOC);
                                                                    
                                    echo $columna12['nombres']." ".$columna12['apellidos'];echo "<br>";
                                                                     
                                    }
                                                                 
                                }else{
                                                                    
                                    for($i=0; $i<$longitud12; $i++){
                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                    $nombrecargo12 = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$entregarAID[$i]'");
                                    $columna12 = $nombrecargo12->fetch_array(MYSQLI_ASSOC);
                                    echo $columna12['nombreCargos'];echo "<br>";
                                    }
                                }
                                ?>
                                                                
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>                                    
            <br>                                        
                                                    
                                                    
            <style>
            .timeline>div {
                margin-bottom: 15px;
                margin-right: 10px;
                position: relative;
            }
            .timeline>.time-label>span {
                border-radius: 4px;
                background-color: #fff;
                display: inline-block;
                font-weight: 600;
                padding: 5px;
            }
            .bg-danger, .bg-danger>a {
                color: #fff!important;
            }
                
            .bg-danger {
                background-color: #dc3545!important;
            }
            
            /*
            .timeline-inverse>div>.timeline-item {
                box-shadow: none;
                background: #f8f9fa;
                border: 1px solid #dee2e6;
            }*/
            
            
            </style>                                    
                                                
                                                
                                                <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label><b>Comentarios:</b></label>
                                                            <div class="card-body">
                                                                <div style="padding: 20px;" class="tab-pane" id="timeline">
                                                                            <!-- The timeline -->
                                                                            <div class="timeline timeline-inverse">
                                                                              <!-- timeline time label -->
                                                                              <?php 
                                                                                $idSol = $datosDoc['id_solicitud'];
                                                                                $queryControl = $mysqli->query("SELECT * FROM controlCambiosCompromisos WHERE idCompromiso = '$idCompromiso'")or die(mysqli_error($mysqli));
                                                                                
                                                                                while($row = $queryControl->fetch_assoc()){
                                                                                    $idUser = $row['usuario'];
                                                                                    $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$idUser' ")or die(mysqli_error($mysqli));
                                                                                    $datosUser = $queryUser->fetch_assoc();
                                    
                                                                                    $nombreUsuario = $datosUser['nombres']." ".$datosUser['apellidos'];
                                                                                    
                                                                              ?>
                                                                              
                                                                              <div class="time-label">
                                                                                <span class="bg-danger">
                                                                                  <?php echo substr($row['fecha'],0,-8);//$row['fecha']?>
                                                                                </span>
                                                                              </div>
                                    
                                                                              <div>
                                                                                <i class="fas fa-user bg-info"></i>
                                                        
                                                                                <div class="timeline-item" >
                                                                                  
                                                                                  <h3 class="timeline-header border-0"><a href="#" style="color:#007bff;text-decoration:none">&nbsp;&nbsp;<?php echo $nombreUsuario?></a> <?php echo $row['comentario'].' - '.$row['historia']?>
                                                                                  </h3>
                                                                                </div>
                                                                              </div>
                                                                            <?php }?>
                                                                            </div>
                                                                         </div>
                                                              </div>
                                                        </div>
                                               
                                                    </div>
                                            
                                            
                                            
                                            </div>
            <?php
            $n++;
            }
            ?>
        </div>
        <?php
        }
        ?>
    </p>
    
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<button type="button" id="action-button" onclick="window.print();return false;" style="display:none;">
</button>
<script>
    /*
    $(document).ready(function() {
    // indicamos que se ejecuta la funcion a los 5 segundos de haberse
    // cargado la pagina
    setTimeout(clickbutton, 1000);
                                
    function clickbutton() {
    //simulamos el click del mouse en el boton del formulario
        $("#action-button").click();
        //alert("Aqui llega"); //Debugger
    }
    $('#action-button').on('click',function() {
        // console.log('action'); 
    });
    });
    */
    //document.getElementById('main').style.display = 'none';
    
       let nav = document.getElementById('main');
         
       window.onbeforeprint = () => { //Antes de cargar la impresión
         //nav?.classList.add('main');
         
       }
    
       window.onafterprint = () => { //Al cancelar/guardar la impresión
        // nav?.classList.remove('main');
            setTimeout(tiempoCerrar, 0000);
            function tiempoCerrar() {
                window.close();
            }
     
       }
       
    window.print();
    //setTimeout(tiempoOcultar, 2000);
    //function tiempoOcultar() {
    //    document.getElementById('maininformacion').style.display = 'none';    
    //}
       
</script>
</body>
</html>