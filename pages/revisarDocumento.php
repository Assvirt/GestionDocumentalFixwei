<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{

    $idDocumento = $_POST['idDocumento'];
    $idSolicitud = $_POST['idSolicitud'];
    require 'conexion/bd.php';
    
    $arraryOld = array();
    
    $queryDoc = $mysqli->query("SELECT idAnterior FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
    $datosDoc = $queryDoc->fetch_assoc();
    $versionAnterior = $datosDoc['idAnterior'];
    
    array_push($arraryOld,$idDocumento);
    
    
    if($versionAnterior != NULL){
        array_push($arraryOld,$versionAnterior);
        //echo $versionAnterior;
        do{
        //echo $versionAnterior;
        $queryDoc2 = $mysqli->query("SELECT idAnterior FROM documento WHERE id = $versionAnterior")or die(mysqli_error($mysqli));
        $datosDoc2 = $queryDoc2->fetch_assoc();
        $versionAnterior = $datosDoc2['idAnterior'];
        
            if($versionAnterior != NULL){
                array_push($arraryOld,$versionAnterior);
            }
        }while($versionAnterior != NULL);
    }
    //array_push($arraryOld,$idDocumento);
    
    
    
    //print_r($arraryOld);

   /* function idAnterior($versionAnterior){ Funcion recursiva para traer las versiones anteriores
        $arrayIds = array();
        echo "Version anterior f1:".$versionAnterior;
        
        
        
        if($versionAnterior != NULL){
            require 'conexion/bd.php';
            $queryDoc = $mysqli->query("SELECT idAnterior FROM documento WHERE id = $versionAnterior")or die(mysqli_error($mysqli));
            $datosDoc = $queryDoc->fetch_assoc();
            echo "Version anterior f:".$versionAnterior = $datosDoc['idAnterior'];
        
            idAnterior($versionAnterior);
            
        }
        
        
        
    }

    
    
                                    
    echo $versionAnterior; echo "<br>";
    
    idAnterior($versionAnterior);
    
    */
    
    
    /////////////////////////////
    
    /*
    
    function factorial($n){
        if($n==1)
            return 1;
        else
            return $n * factorial($n-1);
    }
     
    $resultado = factorial(3);
    echo "Resultado".$resultado;
    
    
    $acentos = $mysqli->query("SET NAMES 'utf8'");
    $queryDoc = $mysqli->query("SELECT * FROM documento WHERE id = $versionAnterior")or die(mysqli_error($mysqli));
    $datosDoc = $queryDoc->fetch_assoc();
    $versionAnterior = $datosDoc['idAnterior'];
    
    echo $versionAnterior; echo "<br>";
    
    */
                                    /*
                                    if($datosDoc['idAnterior'] != NULL){
                                        echo "Hay otra version".$datosDoc['idAnterior'];
                                    }
                                    */


?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Revisión Documental</title>
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
  <!--CKeditor-->
  <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.min.js"></script>
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
  <?php echo require_once'menu.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Revisión Documental</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Revisión Documental</li>
            </ol>
          </div>
        </div>
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-10">
                    <div class="row">
                        <div class="col-sm">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="revisionDocumental"><font color="white"><i class="fas fa-list"></i> Revisión Documental</font></a></button>
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
        <div>

        </div>
      </div><!-- /.container-fluid -->
    </section>
                        <?php
                           
                            
                            $arrayInvertido = array_reverse($arraryOld);
                            
                            
                            $tamanoArray = count($arrayInvertido);
                            
                            $contenidoA=0;
                            $contenidoB=0;
                            for($i = 0; $i < $tamanoArray; $i++){
                                    
                                   
                                    if($arrayInvertido[$i] != NULL && $arrayInvertido[$i] != ' ' ){
                                    
                                    require_once 'conexion/bd.php';
                                    $mysqli->query("SET NAMES 'utf8'");
                                    $queryDoc = $mysqli->query("SELECT * FROM documento WHERE id = $arrayInvertido[$i]")or die(mysqli_error($mysqli));
                                    $datosDoc = $queryDoc->fetch_assoc();
                                    
                                    $tipo = $datosDoc['tipo_documento'];
                                    $proceso = $datosDoc['proceso'];
                                    
                                    $mysqli->query("SET NAMES 'utf8'");
                                    $nombreTipoDocumento = $mysqli->query("SELECT * FROM tipoDocumento WHERE id ='$tipo'")or die(mysqli_error($mysqli));
                                    $colu = $nombreTipoDocumento->fetch_array(MYSQLI_ASSOC);
                                    $nombreT = $colu['nombre'];
                                    
                                    $mysqli->query("SET NAMES 'utf8'");
                                    $nombreProceso = $mysqli->query("SELECT * FROM procesos WHERE id ='$proceso'")or die(mysqli_error($mysqli));
                                    $col3 = $nombreProceso->fetch_array(MYSQLI_ASSOC);
                                    $nombreP = $col3['nombre'];
                                    
                                    $idSolicitud = $datosDoc['id_solicitud'];
                                    }
                        ?> 
    <!-- TABLA PERMISOS-->
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-10">
                    <!-- Default box -->
                    
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Información del documento</h3>
                                
                                <div class="card-tools">
                                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                                  <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fas fa-times"></i></button>
                                </div>
                            </div>
                          
                                
                                <div class="card-body">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            
                                            
                                                <div class="row" style="padding-left: 50px;" >
                                                    <div class="col-sm-3">
                                                      <!-- text input -->
                                                      <div class="form-group">
                                                        <label>Nombre Documento:</label><br>
                                                        <?php echo $datosDoc['nombres'];?>
                                                      </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                      <div class="form-group">
                                                        <label>Proceso:</label><br>
                                                        <?php echo $nombreP;?>
                                                      </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                      <div class="form-group">
                                                        <label>Tipo documento:</label><br>
                                                        <?php echo $nombreT;?>
                                                      </div>
                                                    </div>
                                                </div>
                                            <!--d-flex justify-content-center-->
                                                
                                                <div class="row" style="padding-left: 50px;">
                                                    
                                                    <div class="col-sm-3">
                                                      <!-- text input -->
                                                      <div class="form-group">
                                                        <label>Código:</label><br>
                                                        <?php echo $datosDoc['codificacion'];?>
                                                      </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                      <div class="form-group">
                                                        <label>Versión:</label><br>
                                                        <?php echo $datosDoc['version'];?>
                                                      </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                      <div class="form-group">
                                                        <label>Meses para la próxima revisión:</label><br> <?php echo $datosDoc['mesesRevision'];?>
                                                      </div>
                                                    </div>
                                                    <br>
                                                    
                                                    <?php 
                                                    
                                                    if($datosDoc['metodo'] == "html"){
                                                        echo "<div class='col-sm-3'>";
                                                        echo"<form action='verDocumento' method='POST' target='_blank'>";
                                                            echo"<input type='hidden' name='idDocumento' value='".$datosDoc['id']."'>";
                                                            echo"<input type='hidden' name='idSolicitud' value='".$datosDoc['id_solicitud']."'>";
                                                            echo"<button type='submit' class='btn btn-block btn-warning btn-sm'><i class='fas fa-eye'></i> Ver documento</button>";
                                                        echo"</form>";
                                                        echo "</div>";
                                                      
                                                    ?>  
                                                    
                                                </div>
                                                
                                                
                                                    <?php }
                                                    
                                                    if($datosDoc['metodo'] == "documento"){

                                                        //$rutaPDF =  "archivos/documentos/".$datosDoc['nombrePDF'];
                                                        //$rutaOtro = "archivos/documentos/".$datosDoc['nombreOtro'];
                                                        
                                                        if($datosDoc['nombrePDF'] == NULL){
                                                            $disabledPDF = "disabled";
                                                            $rutaPDF = "#";
                                                        }else{
                                                            $disabledPDF= "#";
                                                            $rutaPDF = "archivos/documentos/".$datosDoc['nombrePDF'];
                                                        }
                                                        
                                                        if($datosDoc['nombreOtro'] == NULL){
                                                            $disabledOtro = "disabled";
                                                            $rutaOtro = "#";
                                                        }else{
                                                            $disabledOtro = "";
                                                            $rutaOtro = "archivos/documentos/".$datosDoc['nombreOtro'];
                                                        }

                                                    ?>
                                                    
                                                    
                                                    <div class="col-sm-3">
                                                      <div class="form-group">
                                                        <label>Descargar documento:</label><br>
                                                        <button type="submit" name="addPermisosConfig" class="btn btn-sm btn-warning float-left  <?php echo $disabledPDF;?>">
                                                            <i class="fas fa-download" ></i><a style='color:black' href='<?php echo $rutaPDF;?>' target="_blank" >Descargar documento</a>
                                                        </button>
                                                      </div>
                                                    </div>
                                                    
                                                </div>
                                                
                                                <div class="row" style="padding-left: 50px;">
                                                    <div class="col-sm-3">
                                                      <div class="form-group">
                                                        <label>Documento editable:</label><br>
                                                        <button type="submit" name="addPermisosConfig" class="btn btn-sm btn-warning float-left  <?php echo $disabledOtro;?>">
                                                            <i class="fas fa-download" ></i><a style='color:black' href='<?php echo $rutaOtro;?>' target="_blank" >Descargar documento</a>
                                                        </button>
                                                      </div>
                                                    </div>
                                                </div>
                                                
                                                <?php } ?>
                           
                                                <br><br>
                                    
                                    </div>
                                </div>
                                        
                        </div>
                                    
                            
                        </div>
                    
                    <!-- /.card -->
                  </div>
                  <div class="col"></div>
                </div>
        </div>
    </section>
    <!-- TABLA PERMISOS-->
    
    
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-10">
                    <!-- Default box -->
                    <form action="controlador/controllerPermisos.php" method="POST"> 
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Control de Cambios</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          <div class="card-body">
                            <div style="padding: 20px;" class="tab-pane" id="timeline">
                                       
                                <?php   $idDocumento;
                                         
                                         
                                  if(isset($verObsoletos)){
                                       'obsoleto';
                                  }else{
                                        'listado';
                                  }      
                                         
                                'Entra id: '.$_POST['idDocumento'];
                                    // ahora sacamos la información del último control de cambio realiado
                                
                                $consultandoDocumento=$mysqli->query("SELECT * FROm documento WHERE id='".$arrayInvertido[$i]."' "); //enviarIdDocumento
                                $extraerConsultaDocumento=$consultandoDocumento->fetch_array(MYSQLI_ASSOC);
                                 'Id solicitud: '.$extraerIdSolicitud=$extraerConsultaDocumento['id_solicitud'];
                            
                            
                                $consultamosExistenciaComentario=$mysqli->query("SELECT * FROM controlCambiosFlujo WHERE idDocumento='".$arrayInvertido[$i]."' ");
                                $extrarConsultaExistenciaComentario=$consultamosExistenciaComentario->fetch_array(MYSQLI_ASSOC);
                                if($extrarConsultaExistenciaComentario['idDocumento'] != NULL){
                                    
                                    if($extrerSolicitudDocumento['tipoSolicitud'] == '3'){  '<br>Cuando está en una solicitud de eliminación.';
                                        if(isset($verObsoletos)){
                                            $informacionDelTexto=$extrarConsultaExistenciaComentario['informacion'];    
                                        }else{
                                            $informacionDelTexto=$extrarConsultaExistenciaComentario['comentarioAnterior']; 
                                        }
                                    }else{
                                        $informacionDelTexto=$extrarConsultaExistenciaComentario['informacion'];
                                    } 
                                    
                                    
                                }else{
                                
                                    $consultaControlCambios=$mysqli->query("SELECT * FROM  controlCambiosParametrizacion ");
                                    $extraerControlCambios=$consultaControlCambios->fetch_array(MYSQLI_ASSOC);
                                    $informacionDelTexto=$extraerControlCambios['informacion'];
                                }
    
                           
                            // end
                            ?>
                            <textarea name="editor12<?php echo $contenidoA++; ?>" readonly required><?php echo $informacionDelTexto;?></textarea>
                            
                            <script>
                                CKEDITOR.replace( 'editor12<?php echo $contenidoB++; ?>' );
                            </script>
                            </div>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              
                          </div>
                          <!-- /.card-footer-->
                        </div>
                    </form>
                    <!-- /.card -->
                  </div>
                  <div class="col"></div>
                </div>
        </div>
    </section>
    
    
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                  <div class="col"></div>
                  <div class="col-10">
                    <!-- Default box -->
                    <?php
                    /*
                    ?>
                    <form action="controlador/controllerPermisos.php" method="POST"> 
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Comentarios</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          <div class="card-body">
                            <div style="padding: 20px;" class="tab-pane" id="timeline">
                                        <!-- The timeline -->
                                        <div class="timeline timeline-inverse">
                                          <!-- timeline time label -->
                                               <?php 
                                                     "id solicicutd: ".$idSolicitud;
                                                    
                                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                    $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '$idSolicitud'")or die(mysqli_error($mysqli));
                                                    
                                                    while($row = $queryControl->fetch_assoc()){
                                                        $idUser = $row['idUsuario'];
                                                        $rol = $row['rol'];
                                                        
                                                        
                                                    if($idUser == null){
                                                    $nombreUsuario = $row['idUsuarioB'];
                                                    $rol = $row['rol'];
                                                    
                                                    
                                                    ////// si el id del usuario viene en número me debe consultar el usuario
                                                        $nombreUsuario;
                                                        
                                                        if(is_numeric($nombreUsuario)){
                                                            
                                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                            $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = $nombreUsuario ")or die(mysqli_error($mysqli));
                                                            $datosUser = $queryUser->fetch_assoc();
                                                            $nombreUsuarioSale = $datosUser['nombres']." ".$datosUser['apellidos'];
                                                            
                                                        }else{
                                                           $nombreUsuarioSale=$nombreUsuario;
                                                        }
                                                        
                                                    ///// end
                                                    
                                                    
                                                    
                                                    
                                                    }else{
                                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                        $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$idUser' ")or die(mysqli_error($mysqli));
                                                        $datosUser = $queryUser->fetch_assoc();
                                                        $nombreUsuarioSale = $datosUser['nombres']." ".$datosUser['apellidos'];
                                                    }
                                                      
                                                  ?>
                                                  
                                                  <div class="time-label">
                                                    <span class="bg-danger">
                                                      <?php echo substr($row['fecha'], 0, -8);?>
                                                    </span>
                                                  </div>
        
                                                  <div>
                                                    <i class="fas fa-user bg-info"></i>
                            
                                                    <div class="timeline-item">
                                                      
                                                      <h3 class="timeline-header border-0"><b><?php echo $rol?></b> - <a href="#"><?php echo $nombreUsuarioSale?></a><br> <?php echo $row['comentario']?>
                                                      </h3>
                                                    </div>
                                                  </div>
                                                <?php } ?>
                                        </div>
                            </div>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              
                          </div>
                          <!-- /.card-footer-->
                        </div>
                    </form>
                    <?php
                    */
                    ?>
                    
                    <form action="controlador/controllerPermisos.php" method="POST"> 
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Comentarios</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          <div class="card-body">
                            <div style="padding: 20px;" class="tab-pane" id="timeline">
                                        <!-- The timeline -->
                                        <div class="timeline timeline-inverse">
                                          <!-- timeline time label -->
                                          <?php 
                                            
                                          
                                          ' - id principal '.$datosDoc['id'].'<br><br>';
                                        ///// realizamos el recorrido de los procesos para la tabla    
                                         '<br>Respaldo: '.$idRespaldoEnviar=$datosDoc['id_solicitudRespaldo'];
                                        '<br>';
                                        if($extrerSolicitudDocumento['tipoSolicitud'] == '3' && $datosDoc['estadoElimina'] == 'Rechazado'){
                                             'entra a la eliminación';
                                             ' - '.$datosDoc['id'];
                                             '<br>';
                                            
                                             '<br>';
                                            //// se pregunta si viene por vigente
                                            $preguntandoVigente=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='".$datosDoc['id_solicitudRespaldo']."' ");
                                            $resultadoPreguntaVigente=$preguntandoVigente->fetch_array(MYSQLI_ASSOC);
                                            $respuestaVigentePregunta=$resultadoPreguntaVigente['docVigente'];
                                            
                                            if($respuestaVigentePregunta == '1'){
                                                 'idA:----- '.$enviarIdConsultaContolrCambios=$datosDoc['id_solicitudRespaldo'];
                                                $recorridoContrtolCambios=$mysqli->query("SELECT * FROM controlCambios WHERE idDocumento='".$enviarIdConsultaContolrCambios."' GROUP BY idDocumento");
                                                
                                                while($extraerRecorridoRespaldo=$recorridoContrtolCambios->fetch_array()){
                                                    $extraerRecorridoRespaldo['id'];
                                                    /// sudconsulta de solicitudes
                                                     '<br><br>'.$extraerRecorridoRespaldo['idDocumento'];  '<br>';
                                                    $subConsultaSolicitudes=$mysqli->query("SELECT MAX(id) AS comentarios FROM solicitudDocumentos WHERE id='".$extraerRecorridoRespaldo['idDocumento']."' AND estado='Ejecutado' ORDER BY id DESC  ");
                                                    $extraerSubConsultaSoli=$subConsultaSolicitudes->fetch_array(MYSQLI_ASSOC);
                                                    $string.=($extraerSubConsultaSoli['comentarios']);
                                                }
                                                $newStrinG=trim($string);
                                                $idSol=$newStrinG;   
                                                 'este es: '.$idSol;
                                                
                                            }else{
                                                 'idB:----- '.$idSol=$datosDoc['id'];
                                                 $saleValidacionB=1;
                                            }
                                            
                                            $recorridoContrtolCambiosValidando=$mysqli->query("SELECT * FROM controlCambios WHERE idDocumento='".$idSol."' GROUP BY idDocumento");
                                            $extraerRecorridoRespaldoValidando=$recorridoContrtolCambiosValidando->fetch_array(MYSQLI_ASSOC);
                                             '<br>tipo: '.$validandoRespaldoRecorrido=$extraerRecorridoRespaldoValidando['tipoSolicitud'];
                                           
                                               
                                                
                                        }else{  
                                             '--id: soli: '.$extrerSolicitudDocumento['id'];
                                             if($extrerSolicitudDocumento['tipoSolicitud'] == '3'){
                                                  '<br>-- Entra a la solicitud para mantener los datos anterior: --<br>';
                                                 $idSol=$datosDoc['id'];
                                                 $saleValidacionElimnaYmantenerControl='1';
                                                 
                                             }else{
                                                    '<br>--id normal '.$idSol = $datosDoc['id_solicitud'];
                                             }
                                        }   
                                            
                                            
                                           
                                            
                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                            if($saleValidacionB == '1' && $validandoRespaldoRecorrido <> '1'){ 
                                                 'diferente a una id: '.$idSol;
                                                 '<br> tipo de solicitud: '.$validandoRespaldoRecorrido;
                                                    if($validandoRespaldoRecorrido == NULL){
                                                         '<br>Entra al Null con este id: '.$idRespaldoEnviar;
                                                        $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '$idRespaldoEnviar'  ")or die(mysqli_error($mysqli)); //tipoSolicitud IS NULL
                                                        
                                                        if(mysqli_num_rows($queryControl) > 0 ){
                                                             '<br>Se ejecuta el SQL';
                                                        }else{
                                                             '<br>No se ejecuta el SQL'.$idSol;
                                                             '<br>tipo de solicitu: '.$extrerSolicitudDocumento['tipoSolicitud'];
                                                            $noEjecutaSql=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE nombreDocumento='$idSol' AND estado='Ejecutado' AND tipoSolicitud='2'  ORDER BY id DESC ");
                                                            $extraerNoEjecutaSql=$noEjecutaSql->fetch_array(MYSQLI_ASSOC);
                                                             '<br> Debe salir: '.$extraerNoEjecutaSql['id'];
                                                            $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '".$extraerNoEjecutaSql['id']."'  ")or die(mysqli_error($mysqli)); //tipoSolicitud IS NULL
                                                        
                                                        }
                                                        
                                                        
                                                    }else{
                                                         '<br>No entra al Null';
                                                        $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idRespaldo = '$idSol' AND tipoSolicitud ='1' ")or die(mysqli_error($mysqli)); //tipoSolicitud IS NULL
                                                    }
                                                }else{  
                                                 '<br>a buscar comentarios anteriores';
                                                if($saleValidacionElimnaYmantenerControl == 1){  
                                                     '-- con 1-';
                                                    if(isset($verObsoletos)){
                                                        /// prgeuntamos si viene NULL o NO NULL
                                                        $verificandoNull=$mysqli->query("SELECT * FROM controlCambios WHERE idRespaldo = '$idSol' AND tipoSolicitud='3' ");
                                                        while($respuestaVerificacionNull=$verificandoNull->fetch_array()){
                                                         'Desde obsoleto: '.$respuestaVerificacionNull['tipoSolicitud'];  '<br>';
                                                        }
                                                        /// END
                                                    }else{
                                                        /// prgeuntamos si viene NULL o NO NULL
                                                        $verificandoNull=$mysqli->query("SELECT * FROM controlCambios WHERE idRespaldo = '$idSol' ");
                                                        while($respuestaVerificacionNull=$verificandoNull->fetch_array()){
                                                         'Normal: '.$respuestaVerificacionNull['tipoSolicitud'];  '<br>';
                                                        }
                                                        /// END    
                                                    }
                                                
                                                    //$queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idRespaldo = '$idSol' AND tipoSolicitud IS NULL ")or die(mysqli_error($mysqli));
                                                     '<br> Id conslta: '.$idSol;
                                                    if(isset($verObsoletos)){
                                                    $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idRespaldo = '$idSol' AND tipoSolicitud ='3' ")or die(mysqli_error($mysqli));
                                                    }else{
                                                     '<br>Se rechaza el documento de eliminación después de aprobar una actualizaión id para rescatar: '.$idRescatarAprobadorActuaRechazarElimi=$datosDoc['id_solicitudRespaldo'];
                                                    
                                                    if($datosDoc['estadoActualiza'] == 'Aprobado'){
                                                     '<br>Con el estado aprobado: '.$idRescatarAprobadorActuaRechazarElimi;
                                                    
                                                    $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '$idRescatarAprobadorActuaRechazarElimi' AND tipoSolicitud IS NULL ")or die(mysqli_error($mysqli));
                                                    if(mysqli_num_rows($queryControl) > 0 ){
                                                             '<br>Se ejecuta el SQL segunda parte';
                                                        }else{
                                                             '<br>No se ejecuta el SQL segunda parte: '.$idSol;
                                                             '<br>tipo de solicitu: '.$extrerSolicitudDocumento['tipoSolicitud'];
                                                            $noEjecutaSql=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE nombreDocumento='$idSol' AND estado='Ejecutado' AND tipoSolicitud='2'  ORDER BY id DESC ");
                                                            $extraerNoEjecutaSql=$noEjecutaSql->fetch_array(MYSQLI_ASSOC);
                                                             '<br> Debe salir: '.$extraerNoEjecutaSql['id'];
                                                            $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '".$extraerNoEjecutaSql['id']."'  ")or die(mysqli_error($mysqli)); //tipoSolicitud IS NULL
                                                        
                                                        }
                                                        
                                                        
                                                    }else{
                                                    $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idRespaldo = '$idSol' AND tipoSolicitud ='1' ")or die(mysqli_error($mysqli));
                                                    }
                                                        
                                                    }
                                                }else{  
                                                     '-- sin  1: '.$idSol; //idDocumento=$idSol 
                                                    if($datosDoc['estadoActualiza'] == 'Aprobado'){
                                                     '<br>Rescatando comentarios cuando el estado actualiza es aprobado :'.$idRespaldoEnviar;
                                                        if($idRespaldoEnviar != NULL){  '<br>Detecta que viene el id de respaldo';
                                                        $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '$idRespaldoEnviar'  ")or die(mysqli_error($mysqli));    
                                                        }else{  '<br>El id de respaldo, viene vacio';
                                                        $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '$idSol'  ")or die(mysqli_error($mysqli));    
                                                        }
                                                    }else{   '<br>Solicitud: '.$datosDoc['id_solicitud'];
                                                    $objeticvoVerificacion=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='".$datosDoc['id_solicitud']."' ");
                                                    $objetivoVerificacionporSiAca=$objeticvoVerificacion->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($datosDoc['estadoElimina'] == 'Rechazado' && $objetivoVerificacionporSiAca['estado'] == 'Rechazado'){
                                                         '<br>los 2 restados va rechazados';
                                                        $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '$idRespaldoEnviar'  ")or die(mysqli_error($mysqli));
                                                    }else{
                                                         '<br>Estado normal';
                                                        $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '$idSol'  ")or die(mysqli_error($mysqli));    
                                                    }
                                                    
                                                    
                                                        
                                                    }
                                                         
                                                }
                                                   
                                            }
                                            while($row = $queryControl->fetch_assoc()){
                                                $idUser = $row['idUsuario'];
                                                $rol = $row['rol'];
                                                if($idUser == null){
                                                    $nombreUsuario = $row['idUsuarioB'];
                                                    $rol = $row['rol'];
                                                    
                                                    
                                                    ////// si el id del usuario viene en número me debe consultar el usuario
                                                        $nombreUsuarioS=substr($nombreUsuario,0,-1);
                                                        
                                                        if(is_numeric($nombreUsuarioS)){
                                                            
                                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                            $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$nombreUsuario' ")or die(mysqli_error($mysqli));
                                                            $datosUser = $queryUser->fetch_assoc();
                                                            $nombreUsuarioSale = $datosUser['nombres']." ".$datosUser['apellidos'];
                                                            
                                                        }else{
                                                           $nombreUsuarioSale=$nombreUsuario;
                                                        }
                                                        
                                                    ///// end
                                                    
                                                    
                                                    
                                                    
                                                }else{
                                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                    $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$idUser' ")or die(mysqli_error($mysqli));
                                                    $datosUser = $queryUser->fetch_assoc();
                                                    $nombreUsuarioSale = $datosUser['nombres']." ".$datosUser['apellidos'];
                                                }
                                          ?>
                                          
                                          <div class="time-label">
                                            <span class="bg-danger">
                                              <?php echo substr($row['fecha'],0,-8);?>
                                            </span>
                                          </div>

                                          <div>
                                            <i class="fas fa-user bg-info"></i>
                    
                                            <div class="timeline-item">
                                              
                                              <h3 class="timeline-header border-0"><b><?php echo $rol?></b> - <a href="#"><?php if($row['nombre'] != NULL){ echo $row['nombre']; }else{ echo $nombreUsuarioSale; } ?></a> <?php echo nl2br($row['comentario']);?>
                                              </h3>
                                            </div>
                                          </div>
                                        <?php }
                                        ?>
                                        </div>
                                     </div>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              
                          </div>
                          <!-- /.card-footer-->
                        </div>
                    </form>
                    <!-- /.card -->
                  </div>
                  <div class="col"></div>
                </div>
        </div>
    </section>
    
    
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                  <div class="col"></div>
                  <div class="col-10">
                    <!-- Default box -->
                    <form action="controlador/controllerPermisos.php" method="POST"> 
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Revisión Documental</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          <div class="card-body">
                            <div style="padding: 20px;" class="tab-pane" id="timeline">
                                        <!-- The timeline -->
                                        <div class="timeline timeline-inverse">
                                          <!-- timeline time label -->
                                               
                                                <?php 
                                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                $queryControl = $mysqli->query("SELECT * FROM comnetariosRevision WHERE idDocumento = '$arrayInvertido[$i]'")or die(mysqli_error($mysqli));
                                                    
                                                if(mysqli_num_rows($queryControl) < 1){
                                                    echo "<center>Sin revisión</center>";
                                                }
                                                    
                                                while($row = $queryControl->fetch_assoc()){
                                                        $idUser = $row['idUsuario'];
                                                        $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$idUser' ")or die(mysqli_error($mysqli));
                                                        $datosUser = $queryUser->fetch_assoc();
        
                                                        $nombreUsuario = $datosUser['nombres']." ".$datosUser['apellidos'];
                                                  ?>
                                                  
                                                  <div class="time-label">
                                                    <span class="bg-danger">
                                                      <?php echo $row['fecha'];?>
                                                    </span>
                                                  </div>
        
                                                  <div>
                                                    <i class="fas fa-user bg-info"></i>
                            
                                                    <div class="timeline-item">
                                                      
                                                      <h3 class="timeline-header border-0"><b><?php echo "Encargado solicitud ";?></b> - <a href="#"><?php echo $nombreUsuario;?></a><br> <?php echo $row['comentario']?>
                                                      </h3>
                                                    </div>
                                                  </div>
                                                <?php
                                                }
                                                ?>
                                        </div>
                            </div>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              
                          </div>
                          <!-- /.card-footer-->
                        </div>
                    </form>
                    <!-- /.card -->
                  </div>
                  <div class="col"></div>
                </div>
        </div>
    </section>
    
<?php
    }
    
    if($root == '1'){
        
    }else{
?>

<section class="content">
        <div class="container-fluid">
                            <!-- /.card-body -->
                            <div class="card-footer">
                              
                                <form action="verDocumentoRevisar" method="POST"> 
                                    <input type="hidden" name="idDocumento" value="<?php echo $idDocumento;?>">
                                    <input type="hidden" name="idSolicitud" value="<?php echo $_POST['idSolicitud'];?>">
                                    <button type="submit" name="addPermisosConfig" class="btn btn-primary float-right">Revisar documento</button>
                                </form>
                            </div>
                            <!-- /.card-footer-->
        </div>
</section>
<?php
}
?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php echo require_once'footer.php'; ?>

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
<!--Ckeditor-->

<script>PDFObject.embed("archivos/documentos/<?php echo $nombrePDF;?>", "#example1");</script>
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
<script>
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
</script>
</body>
</html>
<?php
}
?>