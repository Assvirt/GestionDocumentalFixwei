<?php
session_start();
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
//require_once 'inactividad.php';
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Solicitud de documentos</title>
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
            <h1>Ver más</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Ver más</li>
            </ol>
          </div>
        </div>
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                <div class="row">
                    <div class="col-sm">
                        <?php
                        if($_POST['cerrado'] == '1'){
                        ?>
                        <button type="button" class="btn btn-block btn-info btn-sm"><a href="solicitudDocumentosCerradas"><font color="white"><i class="fas fa-list "></i> Listar solicitudes</font></a></button>  
                        <?php
                        }else{
                        ?>
                        <button type="button" class="btn btn-block btn-info btn-sm"><a href="solicitudDocumentos"><font color="white"><i class="fas fa-list "></i> Listar solicitudes</font></a></button>  
                        <?php
                        }
                        ?>
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
        
      </div><!-- /.container-fluid -->
    </section>
<?php
     'Id solicitud: '.$id = $_POST['id'];
    
    
    require 'conexion/bd.php';
    $acentos = $mysqli->query("SET NAMES 'utf8'");
    $data = $mysqli->query("SELECT * FROM solicitudDocumentos WHERE id = '$id'")or die(mysqli_error());
    while($row = $data->fetch_assoc()){
        $quienSolicita=$row['quienSolicita'];
        $quienApruebaSolicitud=$row['QuienAprueba'];
        $solicitud = $row['tipoSolicitud'];
        if($solicitud != 1){  $tipoSolicitudValidar=2;
            $nomb = $row['nombreDocumento'];
            $query2 = $mysqli->query("SELECT * FROM documento WHERE id ='$nomb'");
            $col2 = $query2->fetch_array(MYSQLI_ASSOC);
            ///$nombre = $col2['nombres'];
            if($col2['nombres'] != null){
                $nombre = $col2['nombres'];   
            }else{
                $nombre = $row['nombreDocumento2'];
            }
            
             // enviamos el ID de solicitud de documentos para consultar la tabla de documentos y traer los datos de los aprobadores, revisores y elaboradores.
            $idSolicitudDocumentos=$row['nombreDocumento'];
            $consultandoDatos = $mysqli->query("SELECT * FROM documento WHERE id ='$idSolicitudDocumentos'");
            $extraerDatos = $consultandoDatos->fetch_array(MYSQLI_ASSOC);
            $saleTipoUno=$extraerDatos['id'];
            /// end
            
        }else{ $tipoSolicitudValidar=1;
            $nombre = $row['nombreDocumento'];
            // enviamos el ID de solicitud de documentos para consultar la tabla de documentos y traer los datos de los aprobadores, revisores y elaboradores.
            $idSolicitudDocumentos=$row['id'];
            $consultandoDatos = $mysqli->query("SELECT * FROM documento WHERE id_solicitud ='$idSolicitudDocumentos'");
            $extraerDatos = $consultandoDatos->fetch_array(MYSQLI_ASSOC);
            $saleTipoUno=$extraerDatos['id_solicitud'];
            /// end
            
            
            
        }
        
        
        $tipo =$row['tipoDocumento'];//variable para traer el tipo doc
        $query = $mysqli->query("SELECT * FROM tipoDocumento WHERE id = '$tipo'");
        $col = $query->fetch_array(MYSQLI_ASSOC);
        
        if($col['nombre'] != NULL){
            $tipoDoc = $col['nombre'];
        }else{
            $tipoDoc = $row['tpdG'];
        }
        
        //$tipoDoc = $col['nombre'];
        //$nombre = $row['nombreDocumento'];
        $solicitud = $row['solicitud'];
        $estado = $row['estado'];
        //$comentario = $row['comentarios'];
        $ruta = $row['documento'];
                   
        }
?>    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col-sm">
                
            </div>
            <div class="col-9">
            
            <div class="card card-primary">
                <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" >
                <div class="card-body">
                  <div class="form-group">
                    <h6 class="description-header"><b>Tipo Documento:</b></h6>
                    <span class=""><?php echo $tipoDoc;?></span>
                  </div>
                  <div class="form-group">
                    <h6 class="description-header"><b>Nombre:</b></h6>
                    <span class=""><?php echo $nombre;?></span>
                  </div>
                  <div class="form-group">
                    <h6 class="description-header"><b>Descripción de la solicitud:</b></h6>
                    <span class=""><?php echo $solicitud;?></span>
                  </div>
                  <div class="form-group">
                    <h6 class="description-header"><b>Estado:</b></h6>
                    <span class=""><?php echo $estado;?></span>
                    <?php 
                        //$acentos = $mysqli->query("SET NAMES 'utf8'");
                        $id = $_POST['id'];
                        $datos = $mysqli->query("SELECT * FROM comentarioSolicitud WHERE idSolicitud = '$id' ");
                        $rows =  mysqli_num_rows($datos);
                        if($_POST['estadoTramie'] == 'tramiteSolicitud'){
                            echo '<br><font color="red">El documento se encuentra en trámite</font>'; //La solicitud se encuentra
                        }elseif($_POST['estadoTramie'] == 'tramiteDocumento'){
                            echo '<br><font color="red">El documento se encuentra en trámite</font>'; 
                        }
                  ?>
                  </div>
                  
                  <div class="form-group">
                      <h6 class="description-header"><b>Solicitante:</b></h6>
                      <span class=""><?php 
                                        $queryNombresSolicitante = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$quienSolicita'");
                                        $nombresSolicitante = $queryNombresSolicitante->fetch_array(MYSQLI_ASSOC); 
                                        echo "<font style=''>".$nombresSolicitante['nombres']." ".$nombresSolicitante['apellidos']."</font><br>";
                                     ?>
                      </span>
                  </div>
                   <div class="form-group">
                      <h6 class="description-header"><b>Aprobador:</b></h6>
                      <span class=""><?php
                                        $queryNombresEncargado = $mysqli->query("SELECT * FROM usuario WHERE cedula = '$quienApruebaSolicitud'");
                                        $nombresEncargado = $queryNombresEncargado->fetch_array(MYSQLI_ASSOC); 
                                        echo "<font style=''>".$nombresEncargado['nombres']." ".$nombresEncargado['apellidos']."</font><br>";
                                     ?>
                      </span>
                  </div>
                  <div class="form-group">
                    <!--<h6 class="description-header"><b>Comentarios anteriores:</b></h6>-->
                    <?php
                    while($columnas = $datos->fetch_assoc()){
                        $comentarios = $columnas['comentario'];
                    ?>
                    <table><tr><td><span class=""><?php //echo $comentarios;?></span></td></tr></table>
                    <?php }?>
                  </div>
                  <div class="row">
                    <?php
                        if($idSolicitudDocumentos == $saleTipoUno){
                            if($tipoSolicitudValidar == 1){
                            echo '
                            <div class="form-group">
                                <h6 class="description-header"><b>Flujo de aprobación, creación de un documento:</b></h6>';
                            
                            
                                $consultandoDatos = $mysqli->query("SELECT * FROM documento WHERE id_solicitud ='$idSolicitudDocumentos'");
                                $extraerDatos = $consultandoDatos->fetch_array(MYSQLI_ASSOC);
                                $quienElabora=json_decode($extraerDatos['elabora']);
                                echo '*Quién elabora:<br>';
                                if($quienElabora[0] == 'cargos' || $quienElabora[0] == 'usuarios'){
                                    
                                    if($quienElabora[0] == 'cargos'){
                                        
                                        /// variable que contiene quién fue el que elaboro en el flujo, para los cargos se debe consultar el id del usuario y extraer el cargo para comparar
                                        $validando_usuario=$mysqli->query("SELECT id,cargo FROM usuario WHERE id='".$extraerDatos['elaborado']."' ");
                                        $extraer_validando_usuario=$validando_usuario->fetch_array(MYSQLI_ASSOC);
                                    
                                        $quienGEstionoElaborado=$extraer_validando_usuario['cargo'];
                                        
                                        $longitud = count($quienElabora);
                                        for($i=1; $i<$longitud; $i++){
                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienElabora[$i]'");
                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC);  
                                        	//echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                        	
                                        	    //// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                 $extraerDatos['asumeFlujo'];
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estado'] == 'Pendiente'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['cargo'] == $quienElabora[$i]){
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font>";
                                                        echo ' <b>gestionando '.$traer_consulta['nombres'].' '.$traer_consulta['apellidos'].'...</b><br>';
                                                    }else{
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienElabora[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                }
                                        } 
                                    }
                                    if($quienElabora[0] == 'usuarios'){
                                        /// variable que contiene quién fue el que elaboro en el flujo
                                        $quienGEstionoElaborado=$extraerDatos['elaborado'];
                                        
                                        $longitud = count($quienElabora);
                                        for($i=1; $i<$longitud; $i++){
                                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienElabora[$i]'");
                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                        	//echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                        	    
                                        	    //// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estado'] == 'Pendiente'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['id'] == $quienElabora[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionando...</b><br>';
                                                    }else{
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienElabora[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                }
                                        } 
                                         
                                    }
                                }else{
                                    echo $extraerDatos['elabora'].'<br>';
                                }
                                
                                echo '<br>*Quién revisa:<br>';
                                $quienRevisa=json_decode($extraerDatos['revisa']);
                                if($quienRevisa[0] == 'cargos' || $quienRevisa[0] == 'usuarios'){
                                    
                                    
                                    if($quienRevisa[0] == 'cargos'){
                                        
                                        /// variable que contiene quién fue el que elaboro en el flujo, para los cargos se debe consultar el id del usuario y extraer el cargo para comparar
                                        $validando_usuario=$mysqli->query("SELECT id,cargo FROM usuario WHERE id='".$extraerDatos['revisadoo']."' ");
                                        $extraer_validando_usuario=$validando_usuario->fetch_array(MYSQLI_ASSOC);
                                    
                                        $quienGEstionoElaborado=$extraer_validando_usuario['cargo'];
                                        
                                        $longitud = count($quienRevisa);
                                        for($i=1; $i<$longitud; $i++){
                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienRevisa[$i]'");
                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC);  
                                        	//echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                        	    
                                        	    //// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estado'] == 'Elaborado'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['cargo'] == $quienRevisa[$i]){
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font>";
                                                        echo ' <b>gestionando '.$traer_consulta['nombres'].' '.$traer_consulta['apellidos'].'...</b><br>';
                                                    }else{
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                     if($quienGEstionoElaborado == $quienRevisa[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                }
                                        } 
                                    }
                                    if($quienRevisa[0] == 'usuarios'){
                                        /// variable que contiene quién fue el que elaboro en el flujo
                                        $quienGEstionoElaborado=$extraerDatos['revisadoo'];
                                        
                                        $longitud = count($quienRevisa);
                                        for($i=1; $i<$longitud; $i++){
                                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienRevisa[$i]'");
                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                        	//echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                        	    
                                        	    //// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estado'] == 'Elaborado'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['id'] == $quienRevisa[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionando...</b><br>';
                                                    }else{
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienRevisa[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                }
                                        } 
                                         
                                    }
                                }else{
                                    echo $extraerDatos['revisa'].'<br>';
                                }
                                
                                echo '<br>*Quién aprueba:<br>';
                                $quienAprueba=json_decode($extraerDatos['aprueba']);
                                if($quienAprueba[0] == 'cargos' || $quienAprueba[0] == 'usuarios'){
                                    if($quienAprueba[0] == 'cargos'){
                                        /// variable que contiene quién fue el que elaboro en el flujo, para los cargos se debe consultar el id del usuario y extraer el cargo para comparar
                                        $validando_usuario=$mysqli->query("SELECT id,cargo FROM usuario WHERE id='".$extraerDatos['aprobado']."' ");
                                        $extraer_validando_usuario=$validando_usuario->fetch_array(MYSQLI_ASSOC);
                                    
                                        $quienGEstionoElaborado=$extraer_validando_usuario['cargo'];
                                        
                                        $longitud = count($quienAprueba);
                                        for($i=1; $i<$longitud; $i++){
                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienAprueba[$i]'");
                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC);  
                                        	//echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                        	
                                        	    //// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estado'] == 'Revisado'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['cargo'] == $quienAprueba[$i]){
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font>";
                                                        echo ' <b>gestionando '.$traer_consulta['nombres'].' '.$traer_consulta['apellidos'].'...</b><br>';
                                                    }else{
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienAprueba[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                }
                                        } 
                                    }
                                    if($quienAprueba[0] == 'usuarios'){
                                        /// variable que contiene quién fue el que elaboro en el flujo
                                        $quienGEstionoElaborado=$extraerDatos['aprobado'];
                                        $longitud = count($quienAprueba);
                                        for($i=1; $i<$longitud; $i++){
                                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienAprueba[$i]'");
                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                        	//echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                        	    
                                        	    //// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estado'] == 'Revisado'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['id'] == $quienAprueba[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionando...</b><br>';
                                                    }else{
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienAprueba[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                }
                                        } 
                                         
                                    }
                                }else{
                                    echo $extraerDatos['aprueba'].'<br>';
                                }
                                echo '<br><b>Estado del documento</b>: '.$extraerDatos['estado'];
                                
                            echo '</div>';
                            }
                            /////////////////////////////////////////////////////// si el tipo de documento es una actualización o eliminación del documento
                            if($tipoSolicitudValidar == 2){
                            echo '
                            <div class="form-group col-sm-6">
                                <h6 class="description-header"><b>Flujo de aprobación, creación de un documento:</b></h6>';
                                $consultandoDatos = $mysqli->query("SELECT * FROM documento WHERE id ='$idSolicitudDocumentos'");
                                $extraerDatos = $consultandoDatos->fetch_array(MYSQLI_ASSOC);
                                $quienElabora=json_decode($extraerDatos['elabora']);
                                echo '*Quién elabora:<br>';
                                if($quienElabora[0] == 'cargos' || $quienElabora[0] == 'usuarios'){
                                    if($quienElabora[0] == 'cargos'){
                                        
                                        /// variable que contiene quién fue el que elaboro en el flujo, para los cargos se debe consultar el id del usuario y extraer el cargo para comparar
                                        $validando_usuario=$mysqli->query("SELECT id,cargo FROM usuario WHERE id='".$extraerDatos['elaborado']."' ");
                                        $extraer_validando_usuario=$validando_usuario->fetch_array(MYSQLI_ASSOC);
                                    
                                        $quienGEstionoElaborado=$extraer_validando_usuario['cargo'];
                                        
                                        $longitud = count($quienElabora);
                                        for($i=1; $i<$longitud; $i++){
                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienElabora[$i]'");
                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC);  
                                        	//echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                        	
                                        	//// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                $extraerDatos['asumeFlujo'];
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estado'] == 'Pendiente'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['cargo'] == $quienElabora[$i]){
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font>";
                                                        echo ' <b>gestionando '.$traer_consulta['nombres'].' '.$traer_consulta['apellidos'].'...</b><br>';
                                                    }else{
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienElabora[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                }
                                                
                                        } 
                                    }
                                    if($quienElabora[0] == 'usuarios'){
                                        
                                        /// variable que contiene quién fue el que elaboro en el flujo
                                        $quienGEstionoElaborado=$extraerDatos['elaborado'];
                                        
                                        $longitud = count($quienElabora);
                                        for($i=1; $i<$longitud; $i++){
                                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienElabora[$i]'");
                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                        	//echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                        	    
                                        	    //// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estado'] == 'Pendiente'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['id'] == $quienElabora[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionando...</b><br>';
                                                    }else{
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    
                                                    if($quienGEstionoElaborado == $quienElabora[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                }
                                        
                                        } 
                                    }
                                    
                                }else{
                                    echo $extraerDatos['elabora'].'<br>';
                                }
                                
                                echo '<br>*Quién revisa:<br>';
                                $quienRevisa=json_decode($extraerDatos['revisa']);
                                if($quienRevisa[0] == 'cargos' || $quienRevisa[0] == 'usuarios'){
                                    if($quienRevisa[0] == 'cargos'){
                                        
                                        /// variable que contiene quién fue el que elaboro en el flujo, para los cargos se debe consultar el id del usuario y extraer el cargo para comparar
                                        $validando_usuario=$mysqli->query("SELECT id,cargo FROM usuario WHERE id='".$extraerDatos['revisadoo']."' ");
                                        $extraer_validando_usuario=$validando_usuario->fetch_array(MYSQLI_ASSOC);
                                    
                                        $quienGEstionoElaborado=$extraer_validando_usuario['cargo'];
                                    
                                        $longitud = count($quienRevisa);
                                        for($i=1; $i<$longitud; $i++){
                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienRevisa[$i]'");
                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC);  
                                        	//echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                        	    
                                        	    //// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estado'] == 'Elaborado'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['cargo'] == $quienRevisa[$i]){
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font>";
                                                        echo ' <b>gestionando '.$traer_consulta['nombres'].' '.$traer_consulta['apellidos'].'...</b><br>';
                                                    }else{
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienRevisa[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                }
                                        } 
                                    }
                                    if($quienRevisa[0] == 'usuarios'){
                                        /// variable que contiene quién fue el que elaboro en el flujo
                                        $quienGEstionoElaborado=$extraerDatos['revisadoo'];
                                        
                                        $longitud = count($quienRevisa);
                                        for($i=1; $i<$longitud; $i++){
                                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienRevisa[$i]'");
                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                        	//echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                        	
                                        	//// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estado'] == 'Elaborado'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['id'] == $quienRevisa[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionando...</b><br>';
                                                    }else{
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienRevisa[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                }
                                                
                                        } 
                                         
                                    }
                                }else{
                                    echo $extraerDatos['revisa'].'<br>';
                                }
                                
                                echo '<br>*Quién aprueba:<br>';
                                $quienAprueba=json_decode($extraerDatos['aprueba']);
                                if($quienAprueba[0] == 'cargos' || $quienAprueba[0] == 'usuarios'){
                                    if($quienAprueba[0] == 'cargos'){
                                        
                                        /// variable que contiene quién fue el que elaboro en el flujo, para los cargos se debe consultar el id del usuario y extraer el cargo para comparar
                                        $validando_usuario=$mysqli->query("SELECT id,cargo FROM usuario WHERE id='".$extraerDatos['aprobado']."' ");
                                        $extraer_validando_usuario=$validando_usuario->fetch_array(MYSQLI_ASSOC);
                                    
                                        $quienGEstionoElaborado=$extraer_validando_usuario['cargo'];
                                        
                                        $longitud = count($quienAprueba);
                                        for($i=1; $i<$longitud; $i++){
                                            $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienAprueba[$i]'");
                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC);  
                                        	//echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                        	
                                        	//// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estado'] == 'Revisado'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['cargo'] == $quienAprueba[$i]){
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font>";
                                                        echo ' <b>gestionando '.$traer_consulta['nombres'].' '.$traer_consulta['apellidos'].'...</b><br>';
                                                    }else{
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienAprueba[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                }
                                        	
                                        } 
                                    }
                                    if($quienAprueba[0] == 'usuarios'){
                                        
                                        /// variable que contiene quién fue el que elaboro en el flujo
                                        $quienGEstionoElaborado=$extraerDatos['aprobado'];
                                        
                                        $longitud = count($quienAprueba);
                                        for($i=1; $i<$longitud; $i++){
                                            $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienAprueba[$i]'");
                                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                        	//echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                        	
                                        	    //// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estado'] == 'Revisado'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['id'] == $quienAprueba[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionando...</b><br>';
                                                    }else{
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienAprueba[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                }
                                                
                                        } 
                                         
                                    }
                                }else{
                                    echo $extraerDatos['aprueba'].'<br>';
                                }
                                echo '<br><b>Estado del documento</b>: '.$extraerDatos['estado'];
                            echo '</div>';
                            //////////////////////////////////////////////// documento en actualización
                                    if($extraerDatos['elaboraActualizar'] != NULL){
                                    echo '
                                    <div class="form-group col-sm-6">
                                        <h6 class="description-header"><b>Flujo de aprobación, actualización de un documento:</b></h6>';
                                        $consultandoDatos = $mysqli->query("SELECT * FROM documento WHERE id ='$idSolicitudDocumentos'");
                                        $extraerDatos = $consultandoDatos->fetch_array(MYSQLI_ASSOC);
                                        $quienElabora=json_decode($extraerDatos['elaboraActualizar']);
                                        echo '*Quién elabora:<br>';
                                        if($quienElabora[0] == 'cargos'){
                                            
                                            /// variable que contiene quién fue el que elaboro en el flujo, para los cargos se debe consultar el id del usuario y extraer el cargo para comparar
                                            $validando_usuario=$mysqli->query("SELECT id,cargo FROM usuario WHERE id='".$extraerDatos['elaborado']."' ");
                                            $extraer_validando_usuario=$validando_usuario->fetch_array(MYSQLI_ASSOC);
                                    
                                            $quienGEstionoElaborado=$extraer_validando_usuario['cargo'];
                                            
                                            
                                            $longitud = count($quienElabora);
                                            for($i=1; $i<$longitud; $i++){
                                                $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienElabora[$i]'");
                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC);  
                                            	//echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                            	
                                            	//// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estadoActualiza'] == 'Pendiente'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['cargo'] == $quienElabora[$i]){
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font>";
                                                        echo ' <b>gestionando '.$traer_consulta['nombres'].' '.$traer_consulta['apellidos'].'...</b><br>';
                                                    }else{
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienElabora[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                }
                                            	
                                            } 
                                        }
                                        if($quienElabora[0] == 'usuarios'){
                                            
                                            /// variable que contiene quién fue el que elaboro en el flujo
                                            $quienGEstionoElaborado=$extraerDatos['elaborado'];
                                            
                                            $longitud = count($quienElabora);
                                            for($i=1; $i<$longitud; $i++){
                                                $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienElabora[$i]'");
                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                            	//echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                            	
                                            	//// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estadoActualiza'] == 'Pendiente'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['id'] == $quienElabora[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionando...</b><br>';
                                                    }else{
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienElabora[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                }
                                                
                                            } 
                                             
                                        }
                                        
                                        echo '<br>*Quién revisa:<br>';
                                        $quienRevisa=json_decode($extraerDatos['revisaActualizar']);
                                        if($quienRevisa[0] == 'cargos'){
                                            
                                            /// variable que contiene quién fue el que elaboro en el flujo, para los cargos se debe consultar el id del usuario y extraer el cargo para comparar
                                            $validando_usuario=$mysqli->query("SELECT id,cargo FROM usuario WHERE id='".$extraerDatos['revisadoo']."' ");
                                            $extraer_validando_usuario=$validando_usuario->fetch_array(MYSQLI_ASSOC);
                                    
                                            $quienGEstionoElaborado=$extraer_validando_usuario['cargo'];
                                    
                                            $longitud = count($quienRevisa);
                                            for($i=1; $i<$longitud; $i++){
                                                $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienRevisa[$i]'");
                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC);  
                                            	//echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                            	
                                            	//// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estadoActualiza'] == 'Elaborado'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['cargo'] == $quienRevisa[$i]){
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font>";
                                                        echo ' <b>en gestión '.$traer_consulta['nombres'].' '.$traer_consulta['apellidos'].'...</b><br>';
                                                    }else{
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienRevisa[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                }
                                                
                                            } 
                                        }
                                        if($quienRevisa[0] == 'usuarios'){
                                            
                                            /// variable que contiene quién fue el que elaboro en el flujo
                                            $quienGEstionoElaborado=$extraerDatos['revisadoo'];
                                            
                                            $longitud = count($quienRevisa);
                                            for($i=1; $i<$longitud; $i++){
                                                $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienRevisa[$i]'");
                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                            	//echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                            	
                                            	//// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estadoActualiza'] == 'Elaborado'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['id'] == $quienRevisa[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionando...</b><br>';
                                                    }else{
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienRevisa[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                }
                                            	
                                            } 
                                             
                                        }
                                        
                                        echo '<br>*Quién aprueba:<br>';
                                        $quienAprueba=json_decode($extraerDatos['apruebaActualizar']);
                                        
                                        if($quienAprueba[0] == 'cargos'){
                                            
                                            /// variable que contiene quién fue el que elaboro en el flujo, para los cargos se debe consultar el id del usuario y extraer el cargo para comparar
                                            $validando_usuario=$mysqli->query("SELECT id,cargo FROM usuario WHERE id='".$extraerDatos['aprobado']."' ");
                                            $extraer_validando_usuario=$validando_usuario->fetch_array(MYSQLI_ASSOC);
                                    
                                            $quienGEstionoElaborado=$extraer_validando_usuario['cargo'];
                                            
                                            $longitud = count($quienAprueba);
                                            for($i=1; $i<$longitud; $i++){
                                                $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienAprueba[$i]'");
                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC);  
                                                
                                                //// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estadoActualiza'] == 'Revisado'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['cargo'] == $quienAprueba[$i]){
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font>";
                                                        echo ' <b>gestionando '.$traer_consulta['nombres'].' '.$traer_consulta['apellidos'].'...</b><br>';
                                                    }else{
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienAprueba[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                }
                                            } 
                                        }
                                        if($quienAprueba[0] == 'usuarios'){
                                            
                                            /// variable que contiene quién fue el que elaboro en el flujo
                                            $quienGEstionoElaborado=$extraerDatos['aprobado'];
                                            
                                            $longitud = count($quienAprueba);
                                            for($i=1; $i<$longitud; $i++){
                                                $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienAprueba[$i]'");
                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                            	//echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                            	
                                            	//// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estadoActualiza'] == 'Revisado'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['id'] == $quienAprueba[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionando...</b><br>';
                                                    }else{
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienAprueba[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                }
                                            	
                                            } 
                                             
                                        }
                                    echo '<br><b>Estado del documento</b>: '.$extraerDatos['estadoActualiza'];
                                    echo '</div>';
                                    }
                                     
                            /////////////////////////////////////////////////////// END
                            //////////////////////////////////////////////// documento en eliminación
                                    if($extraerDatos['elaboraElimanar'] != NULL){
                                    echo '
                                    <div class="form-group col-sm-6">
                                        <h6 class="description-header"><b>Flujo de aprobación, eliminación de un documento:</b></h6>';
                                        $consultandoDatos = $mysqli->query("SELECT * FROM documento WHERE id ='$idSolicitudDocumentos'");
                                        $extraerDatos = $consultandoDatos->fetch_array(MYSQLI_ASSOC);
                                        $quienElabora=json_decode($extraerDatos['elaboraElimanar']);
                                        echo '*Quién elabora:<br>';
                                        if($quienElabora[0] == 'cargos'){
                                            
                                            /// variable que contiene quién fue el que elaboro en el flujo, para los cargos se debe consultar el id del usuario y extraer el cargo para comparar
                                            $validando_usuario=$mysqli->query("SELECT id,cargo FROM usuario WHERE id='".$extraerDatos['elaborado']."' ");
                                            $extraer_validando_usuario=$validando_usuario->fetch_array(MYSQLI_ASSOC);
                                    
                                            $quienGEstionoElaborado=$extraer_validando_usuario['cargo'];
                                            
                                            
                                            $longitud = count($quienElabora);
                                            for($i=1; $i<$longitud; $i++){
                                                $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienElabora[$i]'");
                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC);  
                                            	//echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                            	
                                            	//// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estadoElimina'] == 'Pendiente'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['cargo'] == $quienElabora[$i]){
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font>";
                                                        echo ' <b>gestionando '.$traer_consulta['nombres'].' '.$traer_consulta['apellidos'].'...</b><br>';
                                                    }else{
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienElabora[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                }
                                            	
                                            	
                                            } 
                                        }
                                        if($quienElabora[0] == 'usuarios'){
                                            
                                            /// variable que contiene quién fue el que elaboro en el flujo
                                            $quienGEstionoElaborado=$extraerDatos['elaborado'];
                                            
                                            $longitud = count($quienElabora);
                                            for($i=1; $i<$longitud; $i++){
                                                $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienElabora[$i]'");
                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                            	//echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                            	
                                            	//// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estadoElimina'] == 'Pendiente'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['id'] == $quienElabora[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionando...</b><br>';
                                                    }else{
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienElabora[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                }
                                            	
                                            } 
                                             
                                        }
                                        
                                        echo '<br>*Quién revisa:<br>';
                                        $quienRevisa=json_decode($extraerDatos['revisaElimanar']);
                                        if($quienRevisa[0] == 'cargos'){
                                            
                                            /// variable que contiene quién fue el que elaboro en el flujo, para los cargos se debe consultar el id del usuario y extraer el cargo para comparar
                                            $validando_usuario=$mysqli->query("SELECT id,cargo FROM usuario WHERE id='".$extraerDatos['revisadoo']."' ");
                                            $extraer_validando_usuario=$validando_usuario->fetch_array(MYSQLI_ASSOC);
                                    
                                            $quienGEstionoElaborado=$extraer_validando_usuario['cargo'];
                                            
                                            
                                            $longitud = count($quienRevisa);
                                            for($i=1; $i<$longitud; $i++){
                                                $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienRevisa[$i]'");
                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC);  
                                            	//echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                            	
                                            	//// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estadoElimina'] == 'Elaborado'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['cargo'] == $quienRevisa[$i]){
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font>";
                                                        echo ' <b>en gestión '.$traer_consulta['nombres'].' '.$traer_consulta['apellidos'].'...</b><br>';
                                                    }else{
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienRevisa[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                }
                                            	
                                            } 
                                        }
                                        if($quienRevisa[0] == 'usuarios'){
                                            
                                            /// variable que contiene quién fue el que elaboro en el flujo
                                            $quienGEstionoElaborado=$extraerDatos['revisadoo'];
                                            
                                            $longitud = count($quienRevisa);
                                            for($i=1; $i<$longitud; $i++){
                                                $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienRevisa[$i]'");
                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                            	//echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                            	
                                            	//// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estadoElimina'] == 'Elaborado'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['id'] == $quienRevisa[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionando...</b><br>';
                                                    }else{
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienRevisa[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                }
                                            	
                                            } 
                                             
                                        }
                                        
                                        echo '<br>*Quién aprueba:<br>';
                                        $quienAprueba=json_decode($extraerDatos['apruebaElimanar']);
                                        if($quienAprueba[0] == 'cargos'){
                                            
                                            /// variable que contiene quién fue el que elaboro en el flujo, para los cargos se debe consultar el id del usuario y extraer el cargo para comparar
                                            $validando_usuario=$mysqli->query("SELECT id,cargo FROM usuario WHERE id='".$extraerDatos['aprobado']."' ");
                                            $extraer_validando_usuario=$validando_usuario->fetch_array(MYSQLI_ASSOC);
                                    
                                            $quienGEstionoElaborado=$extraer_validando_usuario['cargo'];
                                            
                                            
                                            $longitud = count($quienAprueba);
                                            for($i=1; $i<$longitud; $i++){
                                                $queryNombres = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienAprueba[$i]'");
                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC);  
                                            	//echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                            	
                                            	//// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estadoElimina'] == 'Revisado'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['cargo'] == $quienAprueba[$i]){
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font>";
                                                        echo ' <b>en gestión '.$traer_consulta['nombres'].' '.$traer_consulta['apellidos'].'...</b><br>';
                                                    }else{
                                                        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienAprueba[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''> ".$nombres['nombreCargos']."</font><br>";
                                                    }
                                                }
                                            	
                                            } 
                                        }
                                        if($quienAprueba[0] == 'usuarios'){
                                            
                                            /// variable que contiene quién fue el que elaboro en el flujo
                                            $quienGEstionoElaborado=$extraerDatos['aprobado'];
                                            
                                            $longitud = count($quienAprueba);
                                            for($i=1; $i<$longitud; $i++){
                                                $queryNombres = $mysqli->query("SELECT * FROM usuario WHERE id = '$quienAprueba[$i]'");
                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                            	//echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                            	
                                            	//// consultamos quien tiene el documento el proceso
                                                /// se consulta el id del usuario asumeFlujo, se trae el id cargo de ese usuario y se compara con los cargos listados
                                                
                                                if($extraerDatos['asumeFlujo'] != NULL && $extraerDatos['estadoElimina'] == 'Revisado'){
                                                    //// consultamos que usuario tiene el cargo
                                                    $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$extraerDatos['asumeFlujo']."' ");
                                                    $traer_consulta=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    if($traer_consulta['id'] == $quienAprueba[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionando...</b><br>';
                                                    }else{
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                    
                                                }else{
                                                    if($quienGEstionoElaborado == $quienAprueba[$i]){
                                                        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font>";
                                                        echo ' <b>gestionó</b><br>';
                                                    }else{
                                            	        echo "-<font style=''>".$nombres['nombres']." ".$nombres['apellidos']."</font><br>";
                                                    }
                                                }
                                            	
                                            } 
                                             
                                        }
                                    echo '<br><b>Estado del documento</b>: '.$extraerDatos['estadoElimina'];
                                    echo '</div>';
                                    }
                            /////////////////////////////////////////////////////// END
                            }
                       
                        }
                        /// end
                    ?>
                  </div>
                  <div class="form-group">
                    <h6 class="description-header"><b>Comentario:</b></h6>
                    <?php
                    $extraerComentario = $mysqli->query("SELECT * FROM comentarioSolicitud WHERE idSolicitud = '$id' ORDER BY id DESC  ");
                    $extraerDatos = $extraerComentario->fetch_array(MYSQLI_ASSOC);
                    $comentarios = $extraerDatos['comentario'];
                    ?>
                    <span class=""><?php echo $comentarios;?></span>
                  </div>
                  
                  <div class="card-header">
                  <div class="card-title">
                      
                      <?php 
                      $ruta;
                      if($estado == 'documento'){ }else{
                          if($ruta == 'sin datos' || $ruta == NULL){
                      ?>
                            <button type="button" disabled class="btn btn-block btn-warning btn-sm">
                                <i class="fas fa-download"></i>
                                <a style="color:black" href="#" >Descargar</a>
                            </button>
                          <?php
                          }else{
                          ?>
                            <button type="button"  class="btn btn-block btn-warning btn-sm">
                                <i class="fas fa-download"></i>
                                <a style="color:black" href="<?php echo $ruta;?>" download="<?php echo $ruta;?>">Descargar</a>
                            </button>
                          
                      <?php 
                          }
                      }
                      ?>
                  </div>
                  
                  
                 
                  
                   </div> 
                   
                   <div class="col-sm-12">
                            <div class="card">
                               <!-- <center>
                                    <br>
                                    <!--
                                    <p><h4>Control de cambios</h4></p>-->
                               <!-- </center>
                                
                                  
                                        <!-- The timeline -->
                                        
                                          <!-- timeline time label -->
                                          <?php 
                                          /*
                                            $idSol = $datosDoc['id_solicitud'];
                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                            $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = '$id' ")or die(mysqli_error($mysqli));
                                            
                                            while($row = $queryControl->fetch_assoc()){
                                                $idUser = $row['idUsuario'];
                                                $rol = $row['rol'];
                                               if($idUser == null){
                                                    $nombreUsuario = $row['idUsuarioB'];
                                                    $rol = $row['rol'];
                                                    
                                                    
                                                    ////// si el id del usuario viene en número me debe consultar el usuario
                                                        $nombreUsuario;
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
                                                }*/
                                          ?>
                                          
                                         <!-- <div class="time-label">
                                            <span class="bg-danger">
                                              <?php //echo $row['fecha']?>
                                            </span>
                                          </div>-->
                                        <!--
                                          <div>
                                            <i class="fas fa-user bg-info"></i>
                    
                                            <div class="timeline-item">
                                              
                                              <h3 class="timeline-header border-0"><b><?php //echo $rol?></b> - <a href="#"><?php //echo $nombreUsuarioSale?></a> <?php //echo $row['comentario']?>
                                              </h3>
                                            </div>
                                          </div>-->
                                        <?php }?>
                                        
                                     
                            </div>
                        </div>
                   

                
                <!-- /.form-group -->
              

                  
                </div>
                <!-- /.card-body -->

                
              </form>
            </div>
            </div>    

        <div class="col">
            </div>
            
           
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
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

<script>
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
</script>

<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
    
<?php
$validacionProceso=$_POST['validacionProceso'];
?>

  <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- SweetAlert2 -->
  <script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
  <script type="text/javascript">
    $(function() {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
      
      
      <?php 
      if($validacionProceso == 1){
      ?>
          Toast.fire({
              type: 'info',
              title: 'La solicitud ya está en trámite, otro usuario la pidió y está en gestión.'
          })
      <?php
      }
      ?>
      
    });

  </script>
    

</body>
</html>
<?php
//}
?>