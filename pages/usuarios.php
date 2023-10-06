<?php
session_start();
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{ 

  require_once 'inactividad.php';
  require_once 'conexion/bd.php';

  //////////////////////PERMISOS////////////////////////

  $formulario = 'usuarios'; //Se cambia el nombre del formulario

  require_once 'permisosPlataforma.php';


  //////////////////////PERMISOS////////////////////////

  ?>
  <!DOCTYPE html>
  <html>
      <title>Usuarios</title>
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>FIXWEI - Usuarios</title>
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
              <h1>Usuarios</h1>
              <h6>Gestione los usuarios que harán parte del sistema.</h6><br>
            </div>
            
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Inicio</a></li>
                <li class="breadcrumb-item active">Usuarios</li>
              </ol>
            </div>
          </div>
          <div>
            <?php
            if($visibleI == FALSE){
            ?>
               <div class="row">
                <div class="col-sm">
                    <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarUsuario"><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>
                </div>

                <div class="col-sm">
                    <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/usuarios'"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
                </div>
                
                <div class="col-sm">
                    <button type="button" class="btn btn-block btn-info btn-sm"><a href="importacion/importar-usuario/registro_usuarios.xlsx" onClick="javascript:document["ver-form"].submit();"><font color="white"><i class="fas fa-cloud-download-alt"></i> Descargar Plantilla</font></a></button>
                </div>
                <div class="col-sm">
                 <form action="importacion2/importar-usuario/index" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                    <div class="custom-file">
                        <input type="file" name="file" class="custom-file-input" id="exampleInputFile" accept=".xls,.xlsx" required>
                                <!-- Agregamos esta linea para validar que solo sea el documento pdf-->
                                <script>
                                $('input[name="file"]').on('change', function(){
                                    var ext = $( this ).val().split('.').pop();
                                    if ($( this ).val() != '') {
                                      if(ext == "xls" || ext == "xlsx"){
                                        
                                      }
                                      else
                                      {
                                        $( this ).val('');
                                        //alert("Extensión no permitida: " + ext);
                                        const Toast = Swal.mixin({
                                          toast: true,
                                          position: 'top-end',
                                          showConfirmButton: false,
                                          timer: 3000
                                        });
                                    
                                    
                                        Toast.fire({
                                            type: 'warning',
                                            title: ` Extensión no permitida`
                                        })
                                      }
                                    }
                                  });
                                </script>
                                <!-- END -->
                        <label class="custom-file-label" for="exampleInputFile" required>Importar archivo</label>
                        
                    </div>
            </div>
            <div class="col-sm">
                <button type="submit" name="import" class="btn btn-block btn-info btn-sm"><a class="" href="#"><font color="white"><i class="fas fa-file-upload"></i> Importar</font></a></button>
            </div>
                </form>
              <div class="col-sm">
                  <button type="button" class="btn btn-block btn-danger btn-sm"><a href="usuariosEliminados"><font color="white"><i class="fas fa-list"></i> Usuarios eliminados</font></a></button>
              </div>
              </div>
            <?php 
            }else{
            ?>
              <div class="row">
                  <div class="col-sm">
                      <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/usuarios'"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
                  </div>
                  <div class="col-sm"></div>
                  <div class="col-sm"></div>
                  <div class="col-sm"></div>
                  <div class="col-sm"></div>
              </div>

            <?php
            }
            ?>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- /.row -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                    
                <?php
                $consultaCantidad=$mysqli->query("SELECT COUNT(*) FROM `usuario`");
                $extraerConsulta = $consultaCantidad->fetch_array(MYSQLI_ASSOC);
                $cantidadUsuarios = $extraerConsulta['COUNT(*)'];
                ?>
                  <h3 class="card-title"> </h3><br>
                  <h3 class="card-title" style="color:green;font-size:17px;"><?php echo $cantidadUsuarios; ?> usuarios activos</h3>
                  <br>
                  <?php ?>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-head-fixed text-center" id="example">
                    <thead>
                      <tr>
                        <th>Nombre y apellidos</th>
                        <th>Documento de identidad</th>
                        <th>Cargo</th>
                        <th class='text-left'>Estado</th>
                        <th>Ver más</th>
                        <th style="display:<?php echo$visibleE;?>;">Editar</th>
                        <th style="display:<?php echo$visibleD;?>;">Eliminar</th>
                        <th style="display:<?php echo$visibleD;?>;">Anular</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        require 'conexion/bd.php';
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $data = $mysqli->query("SELECT * FROM usuario WHERE estadoEliminado = 0 ORDER BY nombres ASC")or die(mysqli_error());
                          while($row = $data->fetch_assoc()){
                            $idEdit = $row['id'];
                            echo"<tr>";
                            echo "<td style='text-align:justify;'>".$row['nombres']." ".$row['apellidos']."</td>";
                            echo" <td style='text-align:justify;'>   ".$row['cedula']."</td>";
                            $id = $row['cedula'];
                            
                            //CARGO               
                            $roles=$row['cargo'];
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $validacionRoles = $mysqli->query("SELECT * from cargos WHERE id_cargos = '$roles' ");
                            $roles = $validacionRoles->fetch_array(MYSQLI_ASSOC);
                            $rol = $roles['nombreCargos'];
                            
                            if($roles != NULL){
                              echo "<td style='text-align:justify;'>" . $rol . "</td>";
                            }else{
                              echo "<td><b>" .  'No aplica' . "</b></td>";
                            }//FIN CARGO
                          
                            if($row['estadoAnulado'] != TRUE){
                                echo "<td class='text-left'><b><i class='nav-icon far fa-circle text-success'></i> Activo</b></td>";
                            }
                          
                            if($row['estadoAnulado'] == TRUE){
                                echo "<td class='text-left'><b><i class='nav-icon far fa-circle text-danger'></i> Anulado</b></td>";
                            }
                            
                            
                            $botonValidar = $row['estadoAnulado'];
                                                
                            echo"<form action='usuariosVer' method='POST'>";
                            echo"<input type='hidden' name='idUsuario' value= '$id' >";
                            echo"<td><button type='submit' class='btn btn-block btn-primary btn-sm'><i class='fas fa-eye'></i> Ver más</button></td>";
                            echo"</form>";
                            echo"<form action='usuariosEditar' method='POST'>";
                            echo"<input type='hidden' name='idUsuario' value= '$idEdit' >";
                            echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                            echo"</form>";
                          
                            /// validación de script y funcion de eliminacion
                                
                                /*
                                ?>
                                <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $idEdit;?>' >
                                <td style='display:<?php echo $visibleD;?>'><a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                                <script>
                                    function funcionFormula<?php echo $contador2++;?>() {
                                      document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                                    }
                                </script>
                                <?php*/
                            ?>  
                        <td style="text-align:justify;display:<?php echo $visibleD;?>;">
                        <button type="button" class='btn btn-block btn-danger btn-sm' data-toggle="modal"
                            data-target="#exampleModalCenter<?php echo $row['id'].''.$contador_modal++;?>">
                            <i class='fas fa-trash-alt'></i> Eliminar 
                        </button>
                                                                          
                                                                          <div class="modal fade" id="exampleModalCenter<?php echo $row['id'].''.$contador_modal_b++;?>" tabindex="-1" role="dialog"
                                                                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                                            <div class="modal-dialog" role="document">
                                                                              <div class="modal-content bg-danger" >
                                                                                <div class="modal-header"> 
                                                                                  <h4 class="modal-title">Alerta</h4>
                                                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                  </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <p>¿Est&aacute; seguro que desea eliminar?</p>
                                                                                    <div class="card-body">
                                                                                      <!-- line chart -->
                                                                                    <?php
                                                                                    // buscamos donde se encuentra anclado este cargo en centro de costo
                                                                                    $recorridoCentroDeCosto=$mysqli->query("SELECT * FROM centroCostos ");
                                                                                    $stroingCentroDeCosto='';
                                                                                    while($extraerRecorridoCentroDeCosto=$recorridoCentroDeCosto->fetch_array()){
                                                                                        $buscarCargosCosto=$extraerRecorridoCentroDeCosto['persona'];
                                                                                            if($buscarCargosCosto == $row['id']){
                                                                                                $stykeScroll='style="width:100%;height:100px;overflow-y:scroll;"';
                                                                                            }else{
                                                                                                $stykeScroll='';
                                                                                            }
                                                                                    }
                                                                                    ?>
                                                                                      <div id="container"  <?php echo $stykeScroll;?> >
                                                                                        <?php
                                                                                            
                                                                                            
                                                                                                // buscamos donde se encuentra anclado este cargo en centro de costo
                                                                                                /*$recorridoCentroDeCosto=$mysqli->query("SELECT * FROM cTrabajoUusuario ");
                                                                                                $stroingCentroDeCosto='';
                                                                                                while($extraerRecorridoCentroDeCosto=$recorridoCentroDeCosto->fetch_array()){
                                                                                                    $buscarCargosCosto=$extraerRecorridoCentroDeCosto['idUsuario'];
                                                                                                        if($buscarCargosCosto == $row['cedula']){
                                                                                                           /// consultamos el nombre del centro de trabajo
                                                                                                           $consultaNombreCT=$mysqli->query("SELECT * FROM centrodetrabajo WHERE id_centrodetrabajo='".$extraerRecorridoCentroDeCosto['idCtrabajo']."' ");
                                                                                                           $extraerConsultaNombreCT=$consultaNombreCT->fetch_array(MYSQLI_ASSOC);
                                                                                                           $stroingCentroDeCosto.='-'.$extraerConsultaNombreCT['nombreCentrodeTrabajo'].'<br>';
                                                                                                        }
                                                                                                }
                                                                                                if($stroingCentroDeCosto != NULL){
                                                                                                    echo $enviarMensajeCentroDeCosto='El cargo se encuentra asociado con los centro de trabajo:<br>'.$stroingCentroDeCosto;
                                                                                                }*/
                                                                                                $recorridoCentroDeCosto=$mysqli->query("SELECT * FROM centroCostos ");
                                                                                                $stroingCentroDeCosto='';
                                                                                                while($extraerRecorridoCentroDeCosto=$recorridoCentroDeCosto->fetch_array()){
                                                                                                    $buscarCargosCosto=$extraerRecorridoCentroDeCosto['persona'];
                                                                                                        if($buscarCargosCosto == $row['id']){
                                                                                                           /// consultamos el nombre del centro de trabajo
                                                                                                           $consultaNombreCT=$mysqli->query("SELECT * FROM centroCostos WHERE id='".$extraerRecorridoCentroDeCosto['id']."' ");
                                                                                                           $extraerConsultaNombreCT=$consultaNombreCT->fetch_array(MYSQLI_ASSOC);
                                                                                                           $stroingCentroDeCosto.='-'.$extraerConsultaNombreCT['nombre'].'<br>';
                                                                                                        }
                                                                                                }
                                                                                                if($stroingCentroDeCosto != NULL){
                                                                                                    echo $enviarMensajeCentroDeCosto='El cargo se encuentra asociado con los centro de costo:<br>'.$stroingCentroDeCosto;
                                                                                                }
                                                                                                
                                                                                                
                                                                                                
                                                                                            ////// preguntamos si el usuario tiene solicitudes pendientes para aprobar
                                                                                            $bloqueoBotonSD=FALSE;
                                                                                            $lecturaContadorSD='0';
                                                                                            $preguntando_solicitud_documental=$mysqli->query("SELECT estado,encargadoAprobar,QuienAprueba FROM solicitudDocumentos WHERE encargadoAprobar='".$row['cargo']."' AND QuienAprueba='".$row['cedula']."' ");
                                                                                            while($recorrido_preguntando_solicitud_documental=$preguntando_solicitud_documental->fetch_array()){
                                                                                                if($recorrido_preguntando_solicitud_documental['estado'] == 'Ejecutado' || $recorrido_preguntando_solicitud_documental['estado'] == 'Rechazado'){
                                                                                                    continue;
                                                                                                }else{
                                                                                                    $lecturaContadorSD++;
                                                                                                }
                                                                                            }
                                                                                            
                                                                                            if($lecturaContadorSD > 0){ 
                                                                                                ///// esta variable bloquea el botón Si, para evitar eliminar el registro por error
                                                                                                $bloqueoBotonSD=TRUE;
                                                                                            ?>
                                                                                            <br>
                                                                                            El usuario tiene pendientes en la solicitud documental.
                                                                                            <form action="usuariosSD" method="post" target="_blank">
                                                                                                <?php
                                                                                                if($root == 1){
                                                                                                ?>
                                                                                                <input name="usuario" value="<?php echo $row['id'];?>" type="hidden">
                                                                                                <button type="submit" style="border:0px;background:transparent;color:white;">ver más</button>
                                                                                                <?php
                                                                                                }else{
                                                                                                    echo 'Contacte al administrador del sistema.';
                                                                                                }
                                                                                                ?>
                                                                                            </form>
                                                                                            <?php
                                                                                            }
                                                                                            
                                                                                            
                                                                                            ////// verificamos que el usuario tenga actividades pendientes en gestión documental
                                                                                            /////Creación
                                                                                            $bloqueoBotonSG=FALSE;
                                                                                            $queryDoc = $mysqli->query("SELECT * FROM documento ")or die(mysqli_error($mysqli));
                                                                                            while($datosDoc = $queryDoc->fetch_array()){
                                                                                                
                                                                                                if($datosDoc['tipoSolicitud'] == 1){
                                                                                                    $elaboraValidacion = json_decode($datosDoc['elabora']);
                                                                                                    $revisaValidacion = json_decode($datosDoc['revisa']);
                                                                                                    $apruebaValidacion = json_decode($datosDoc['aprueba']);
                                                                                                    
                                                                                                    ///////////////////////////// para el elaborador
                                                                                                        if($elaboraValidacion[0] == 'usuarios'){
                                                                                                            $longitudValidacion = count($elaboraValidacion);
                                                                                                                                                
                                                                                                            for($i=1; $i<$longitudValidacion; $i++){
                                                                                                                                                    //saco el valor de cada elemento
                                                                                                                $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE id = '$elaboraValidacion[$i]'");
                                                                                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                                                                
                                                                                                                if($row['id'] == $elaboraValidacion[$i]){                                    
                                                                                                            	    $variableValidado=$nombres['id'];
                                                                                                                }else{
                                                                                                                    continue;
                                                                                                                }                                  
                                                                                                            
                                                                                                            } 
                                                                                                        }elseif($elaboraValidacion[0] == 'cargos'){
                                                                                                            $longitudCValidacion = count($elaboraValidacion);
                                                                                                                                                
                                                                                                            for($i=1; $i<$longitudCValidacion; $i++){
                                                                                                                                                    //saco el valor de cada elemento
                                                                                                                $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE cargo = '$elaboraValidacion[$i]' AND id='".$row['id']."' ");
                                                                                                                while($nombres = $queryNombres->fetch_array()){ 
                                                                                                                                                    
                                                                                                            	$variableValidado=$nombres['id'];
                                                                                                                }
                                                                                                            } 
                                                                                                        }
                                                                                                    
                                                                                                    /////////////////////////////// para el revisor
                                                                                                        if($revisaValidacion[0] == 'usuarios'){
                                                                                                            $longitudBValidacion = count($revisaValidacion);
                                                                                                                                                
                                                                                                            for($i=1; $i<$longitudBValidacion; $i++){
                                                                                                                                                    //saco el valor de cada elemento
                                                                                                                $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE id = '$revisaValidacion[$i]' ");
                                                                                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                                                                if($row['id'] == $revisaValidacion[$i]){                                    
                                                                                                            	    $variableValidadoB=$nombres['id'];
                                                                                                                }else{
                                                                                                                    continue;
                                                                                                                }
                                                                                                            } 
                                                                                                        }elseif($revisaValidacion[0] == 'cargos'){
                                                                                                            $longitudCValidacion = count($revisaValidacion);
                                                                                                                                                
                                                                                                            for($i=1; $i<$longitudCValidacion; $i++){
                                                                                                                                                    //saco el valor de cada elemento
                                                                                                                $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE cargo = '$revisaValidacion[$i]' AND id='".$row['id']."' ");
                                                                                                                while($nombres = $queryNombres->fetch_array()){ 
                                                                                                                                                    
                                                                                                            	$variableValidadoB=$nombres['id'];
                                                                                                                }
                                                                                                            } 
                                                                                                        }
                                                                                                    
                                                                                                    
                                                                                                    ////////////////////////////// para el aprobador
                                                                                                        if($apruebaValidacion[0] == 'usuarios'){
                                                                                                            $longitudCValidacion = count($apruebaValidacion);
                                                                                                                                                
                                                                                                            for($i=1; $i<$longitudCValidacion; $i++){
                                                                                                                                                    //saco el valor de cada elemento
                                                                                                                $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE id = '$apruebaValidacion[$i]'");
                                                                                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                                                                
                                                                                                                if($row['id'] == $apruebaValidacion[$i]){                                    
                                                                                                            	    $variableValidadoC=$nombres['id'];
                                                                                                                }else{
                                                                                                                    continue;
                                                                                                                }                                    
                                                                                                            
                                                                                                            } 
                                                                                                        }elseif($apruebaValidacion[0] == 'cargos'){
                                                                                                            $longitudCValidacion = count($apruebaValidacion);
                                                                                                                                                
                                                                                                            for($i=1; $i<$longitudCValidacion; $i++){
                                                                                                                                                    //saco el valor de cada elemento
                                                                                                                $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE cargo = '$apruebaValidacion[$i]' AND id='".$row['id']."' ");
                                                                                                                while($nombres = $queryNombres->fetch_array()){ 
                                                                                                                                                    
                                                                                                            	$variableValidadoC=$nombres['id'];
                                                                                                                }
                                                                                                            } 
                                                                                                        }
                                                                                                }
                                                                                                
                                                                                                if($datosDoc['tipoSolicitud'] == 2){
                                                                                                    $elaboraValidacion = json_decode($datosDoc['elaboraActualizar']);
                                                                                                    $revisaValidacion = json_decode($datosDoc['revisaActualizar']);
                                                                                                    $apruebaValidacion = json_decode($datosDoc['apruebaActualizar']);
                                                                                                    
                                                                                                    ///////////////////////////// para el elaborador
                                                                                                        if($elaboraValidacion[0] == 'usuarios'){
                                                                                                            $longitudValidacion = count($elaboraValidacion);
                                                                                                                                                
                                                                                                            for($i=1; $i<$longitudValidacion; $i++){
                                                                                                                                                    //saco el valor de cada elemento
                                                                                                                $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE id = '$elaboraValidacion[$i]'");
                                                                                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                                                                
                                                                                                                if($row['id'] == $elaboraValidacion[$i]){                                    
                                                                                                            	    $variableValidadoA=$nombres['id'];
                                                                                                                }else{
                                                                                                                    continue;
                                                                                                                }                                  
                                                                                                            
                                                                                                            } 
                                                                                                        }elseif($elaboraValidacion[0] == 'cargos'){
                                                                                                            $longitudCValidacion = count($elaboraValidacion);
                                                                                                                                                
                                                                                                            for($i=1; $i<$longitudCValidacion; $i++){
                                                                                                                                                    //saco el valor de cada elemento
                                                                                                                $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE cargo = '$elaboraValidacion[$i]' AND id='".$row['id']."' ");
                                                                                                                while($nombres = $queryNombres->fetch_array()){ 
                                                                                                                                                    
                                                                                                            	$variableValidadoA=$nombres['id'];
                                                                                                                }
                                                                                                            } 
                                                                                                        }
                                                                                                    
                                                                                                    /////////////////////////////// para el revisor
                                                                                                        if($revisaValidacion[0] == 'usuarios'){
                                                                                                            $longitudBValidacion = count($revisaValidacion);
                                                                                                                                                
                                                                                                            for($i=1; $i<$longitudBValidacion; $i++){
                                                                                                                                                    //saco el valor de cada elemento
                                                                                                                $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE id = '$revisaValidacion[$i]' ");
                                                                                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                                                                if($row['id'] == $revisaValidacion[$i]){                                    
                                                                                                            	    $variableValidadoBA=$nombres['id'];
                                                                                                                }else{
                                                                                                                    continue;
                                                                                                                }
                                                                                                            } 
                                                                                                        }elseif($revisaValidacion[0] == 'cargos'){
                                                                                                            $longitudCValidacion = count($revisaValidacion);
                                                                                                                                                
                                                                                                            for($i=1; $i<$longitudCValidacion; $i++){
                                                                                                                                                    //saco el valor de cada elemento
                                                                                                                $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE cargo = '$revisaValidacion[$i]' AND id='".$row['id']."' ");
                                                                                                                while($nombres = $queryNombres->fetch_array()){ 
                                                                                                                                                    
                                                                                                            	$variableValidadoBA=$nombres['id'];
                                                                                                                }
                                                                                                            } 
                                                                                                        }
                                                                                                    
                                                                                                    
                                                                                                    ////////////////////////////// para el aprobador
                                                                                                        if($apruebaValidacion[0] == 'usuarios'){
                                                                                                            $longitudCValidacion = count($apruebaValidacion);
                                                                                                                                                
                                                                                                            for($i=1; $i<$longitudCValidacion; $i++){
                                                                                                                                                    //saco el valor de cada elemento
                                                                                                                $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE id = '$apruebaValidacion[$i]'");
                                                                                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                                                                
                                                                                                                if($row['id'] == $apruebaValidacion[$i]){                                    
                                                                                                            	    $variableValidadoCA=$nombres['id'];
                                                                                                                }else{
                                                                                                                    continue;
                                                                                                                }                                    
                                                                                                            
                                                                                                            } 
                                                                                                        }elseif($apruebaValidacion[0] == 'cargos'){
                                                                                                            $longitudCValidacion = count($apruebaValidacion);
                                                                                                                                                
                                                                                                            for($i=1; $i<$longitudCValidacion; $i++){
                                                                                                                                                    //saco el valor de cada elemento
                                                                                                                $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE cargo = '$apruebaValidacion[$i]' AND id='".$row['id']."' ");
                                                                                                                while($nombres = $queryNombres->fetch_array()){ 
                                                                                                                                                    
                                                                                                            	$variableValidadoCA=$nombres['id'];
                                                                                                                }
                                                                                                            } 
                                                                                                        }
                                                                                                }
                                                                                                
                                                                                                if($datosDoc['tipoSolicitud'] == 3){
                                                                                                    $elaboraValidacion = json_decode($datosDoc['elaboraElimanar']);
                                                                                                    $revisaValidacion = json_decode($datosDoc['revisaElimanar']);
                                                                                                    $apruebaValidacion = json_decode($datosDoc['apruebaElimanar']);
                                                                                                    
                                                                                                    ///////////////////////////// para el elaborador
                                                                                                        if($elaboraValidacion[0] == 'usuarios'){
                                                                                                            $longitudValidacion = count($elaboraValidacion);
                                                                                                                                                
                                                                                                            for($i=1; $i<$longitudValidacion; $i++){
                                                                                                                                                    //saco el valor de cada elemento
                                                                                                                $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE id = '$elaboraValidacion[$i]'");
                                                                                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                                                                
                                                                                                                if($row['id'] == $elaboraValidacion[$i]){                                    
                                                                                                            	    $variableValidadoE=$nombres['id'];
                                                                                                                }else{
                                                                                                                    continue;
                                                                                                                }                                  
                                                                                                            
                                                                                                            } 
                                                                                                        }elseif($elaboraValidacion[0] == 'cargos'){
                                                                                                            $longitudCValidacion = count($elaboraValidacion);
                                                                                                                                                
                                                                                                            for($i=1; $i<$longitudCValidacion; $i++){
                                                                                                                                                    //saco el valor de cada elemento
                                                                                                                $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE cargo = '$elaboraValidacion[$i]' AND id='".$row['id']."' ");
                                                                                                                while($nombres = $queryNombres->fetch_array()){ 
                                                                                                                                                    
                                                                                                            	$variableValidadoE=$nombres['id'];
                                                                                                                }
                                                                                                            } 
                                                                                                        }
                                                                                                    
                                                                                                    /////////////////////////////// para el revisor
                                                                                                        if($revisaValidacion[0] == 'usuarios'){
                                                                                                            $longitudBValidacion = count($revisaValidacion);
                                                                                                                                                
                                                                                                            for($i=1; $i<$longitudBValidacion; $i++){
                                                                                                                                                    //saco el valor de cada elemento
                                                                                                                $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE id = '$revisaValidacion[$i]' ");
                                                                                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                                                                if($row['id'] == $revisaValidacion[$i]){                                    
                                                                                                            	    $variableValidadoBE=$nombres['id'];
                                                                                                                }else{
                                                                                                                    continue;
                                                                                                                }
                                                                                                            } 
                                                                                                        }elseif($revisaValidacion[0] == 'cargos'){
                                                                                                            $longitudCValidacion = count($revisaValidacion);
                                                                                                                                                
                                                                                                            for($i=1; $i<$longitudCValidacion; $i++){
                                                                                                                                                    //saco el valor de cada elemento
                                                                                                                $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE cargo = '$revisaValidacion[$i]' AND id='".$row['id']."' ");
                                                                                                                while($nombres = $queryNombres->fetch_array()){ 
                                                                                                                                                    
                                                                                                            	$variableValidadoBE=$nombres['id'];
                                                                                                                }
                                                                                                            } 
                                                                                                        }
                                                                                                    
                                                                                                    
                                                                                                    ////////////////////////////// para el aprobador
                                                                                                        if($apruebaValidacion[0] == 'usuarios'){
                                                                                                            $longitudCValidacion = count($apruebaValidacion);
                                                                                                                                                
                                                                                                            for($i=1; $i<$longitudCValidacion; $i++){
                                                                                                                                                    //saco el valor de cada elemento
                                                                                                                $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE id = '$apruebaValidacion[$i]'");
                                                                                                                $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                                                                                                                
                                                                                                                if($row['id'] == $apruebaValidacion[$i]){                                    
                                                                                                            	    $variableValidadoCE=$nombres['id'];
                                                                                                                }else{
                                                                                                                    continue;
                                                                                                                }                                    
                                                                                                            
                                                                                                            } 
                                                                                                        }elseif($apruebaValidacion[0] == 'cargos'){
                                                                                                            $longitudCValidacion = count($apruebaValidacion);
                                                                                                                                                
                                                                                                            for($i=1; $i<$longitudCValidacion; $i++){
                                                                                                                                                    //saco el valor de cada elemento
                                                                                                                $queryNombres = $mysqli->query("SELECT  * FROM usuario WHERE cargo = '$apruebaValidacion[$i]' AND id='".$row['id']."' ");
                                                                                                                while($nombres = $queryNombres->fetch_array()){ 
                                                                                                                                                    
                                                                                                            	$variableValidadoCE=$nombres['id'];
                                                                                                                }
                                                                                                            } 
                                                                                                        }
                                                                                                }
                                                                                            
                                                                                            }
                                                                                            
                                                                                            if($variableValidado == $row['id'] || $variableValidadoB == $row['id'] || $variableValidadoC == $row['id'] || $variableValidadoA == $row['id'] || $variableValidadoBA == $row['id'] || $variableValidadoCA == $row['id'] || $variableValidadoE == $row['id'] || $variableValidadoBE == $row['id'] || $variableValidadoCE == $row['id']){
                                                                                                ///// esta variable bloquea el botón Si, para evitar eliminar el registro por error
                                                                                                $bloqueoBotonSG=TRUE;
                                                                                            ?>
                                                                                            <br>
                                                                                            El usuario tiene pendientes en gestión documental.
                                                                                            <form action="usuariosGD" method="post" target="_blank">
                                                                                                <input name="usuario" value="<?php echo $row['id'];?>" type="hidden">
                                                                                                <input name="cargo" value="<?php echo $row['cargo'];?>" type="hidden">
                                                                                                <?php
                                                                                                if($root == 1){
                                                                                                ?>
                                                                                                <button type="submit" style="border:0px;background:transparent;color:white;">ver más</button>
                                                                                                <?php
                                                                                                }else{
                                                                                                    echo 'Contacte al administrador del sistema.';
                                                                                                }
                                                                                                ?>
                                                                                            </form>
                                                                                            <?php
                                                                                            }
                                                                                            ?>
                                                                                            
                                                                                            
                                                                                      </div>
                                                                                    </div>
                                                                                </div>
                                                                                <form action='controlador/usuarios/controladorUsuarios' method='POST'>
                                                                                    <input type="hidden" value="<?php echo $row['id'];?>" name='idUsuario' readonly>
                                                                                    <div class="modal-footer justify-content-between">
                                                                                      <!--<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>-->
                                                                                      <?php
                                                                                      //// si el usuario tiene solicitudes documentales o documentos en gestión, se bloquea el botón si, para evitar eliminar los datos por error
                                                                                      if($bloqueoBotonSD == TRUE){
                                                                                          
                                                                                      }elseif($bloqueoBotonSG == TRUE){
                                                                                         
                                                                                      }else{
                                                                                      ?>
                                                                                      <button type="submit" name='EliminarUsuario' class="btn btn-outline-light">Si</button>
                                                                                      <?php
                                                                                      }
                                                                                      ?>
                                                                                      <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                                                                                    </div>
                                                                                </form>
                                                                              </div>
                                                                            </div>
                                                                          </div>
                        </td>
                            <?php    
                            /// END
                                if($botonValidar == 0 || $botonValidar == NULL ){
                                
                                    /// validación de script y funcion de eliminacion
                                  ?>
                                  <input type='hidden' id='capturaVariableAnular<?php echo $contadorA++;?>'  value= '<?php echo $id;?>' >
                                  <td style='display:<?php echo $visibleD;?>'><a onclick='funcionFormulaAnular<?php echo $contador1A++;?>()' data-toggle='modal' data-target='#modal-dangerA' class='btn btn-block btn-warning btn-sm'><i class='fas fa-minus-circle'></i> Anular</a></td>
                                      <script>
                                            function funcionFormulaAnular<?php echo $contador2A++;?>()
                                            {
                                                  document.getElementById("capturarFormulaAnular").value = document.getElementById("capturaVariableAnular<?php echo $contador3A++;?>").value;
                                            }
                                      </script>
                                  <?php
                                    /// END
                                }else{
                                    echo"<form action='controlador/usuarios/controladorUsuarios' method='POST'>";
                                    echo"<input type='hidden' name='idUsuario' value= '$id' >";
                                    echo" <td style='display:$visibleD;'><button style='background:yellow;' type='submit' name='ActivarUsuario' class='btn btn-block btn-warning btn-sm'><i class='fas fa-lightbulb'></i> Activar</button></td>";
                                    echo"</form>";
                                    echo"</tr>";
                                }
                            
                          } 
                        ?>
                      <!--
                      <div class="modal fade" id="modal-danger">
                          <div class="modal-dialog">
                            <div class="modal-content bg-danger">
                              <div class="modal-header">
                                <h4 class="modal-title">Alerta</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p>¿Est&aacute; seguro que desea eliminar?</p>
                              </div>
                              <form action='controlador/usuarios/controladorUsuarios' method='POST'>
                              <div class="modal-footer justify-content-between">
                                <input type="hidden" id="capturarFormula" name='idUsuario' readonly>
                                <button type="submit" name='EliminarUsuario' class="btn btn-outline-light">Si</button>
                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                              </div>
                              </form>
                              
                            </div>
                          </div>
                      </div>
                      -->
                      <div class="modal fade" id="modal-dangerA">
                          <div class="modal-dialog">
                            <div class="modal-content bg-warning">
                              <div class="modal-header">
                                <h4 class="modal-title" style="color:white;">Alerta</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white;">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p style="color:white;">¿Est&aacute; seguro que desea anular?</p>
                              </div>
                              <!-- formulario para eliminar por el id -->
                              <form action='controlador/usuarios/controladorUsuarios' method='POST'>
                              <div class="modal-footer justify-content-between">
                                <input type="hidden" id="capturarFormulaAnular" name='idUsuario' readonly>
                                <button type="submit" name='AnularUsuario' class="btn btn-outline-light">Si</button>
                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                              </div>
                              </form>
                              <!-- END formulario para eliminar por el id -->
                            </div>
                          </div>
                      </div>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
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
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../dist/js/demo.js"></script>
  <!-- Script advertencia eliminar -->
  <script type="text/javascript">
    function ConfirmDelete(){
      var answer = confirm("¿Esta seguro de eliminar?");

      if(answer == true){
        return true;
      }else{
        return false;
      }
    }
    function ConfirmAnular(){
      var answer = confirm("¿Esta seguro de anular?");

      if(answer == true){
        return true;
      }else{
        return false;
      }
    }
  </script>

  <!-- para mostrar el archivo seleccionado en el file -->
  <script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function () {
    bsCustomFileInput.init();
  });
  </script>
  <!-- END -->

  <!-- archivos para el filtro de busqueda y lista de información -->

      <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
      <!--datables estilo bootstrap 4 CSS-->  
      <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
  
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

      <script type="text/javascript" src="datatables/datatables.min.js"></script>    
      
      <script type="text/javascript" src="main.js"></script>
  <!-- END -->
  <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- SweetAlert2 -->
  <script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
  <?php
  /// validaciones de alertas
  $validacionExiste=$_POST['validacionExiste'];
  $validacionExisteA=$_POST['validacionExisteA'];
  $validacionExisteB=$_POST['validacionExisteB'];
  $validacionAgregar=$_POST['validacionAgregar'];
  $validacionAgregarB=$_POST['validacionAgregarB'];
  $validacionActualizar=$_POST['validacionActualizar'];
  $validacionEliminar=$_POST['validacionEliminar'];
  $validacionEliminarB=$_POST['validacionEliminarB'];
  $Tipodocumeto=$_POST['Tipodocumeto'];

  //// Validaciones de la importación
  $validacionExisteImportacionA=$_POST['validacionExisteImportacionA'];
  $validacionExisteImportacionB=$_POST['validacionExisteImportacionB'];
  $validacionExisteImportacionC=$_POST['validacionExisteImportacionC'];
  $validacionExisteImportacionD=$_POST['validacionExisteImportacionD'];
  $validacionExisteImportacionE=$_POST['validacionExisteImportacionE'];
  echo 'alerta grupos: '.$validacionExisteImportacionF=$_POST['validacionExisteImportacionF']; echo ' - mensaje: '.$_POST['mensajeRepiteGrupo'];
  $validacionExisteImportacionG=$_POST['validacionExisteImportacionG'];
  $validacionExisteImportacionI=$_POST['validacionExisteImportacionI'];
 
  //// END
  
  // alertade edad
  $alertaEdadMensaje=" 'La edad y fecha de nacimiento es inferior a la permitida:  ".$_POST['variableFecha']."'"; 
  
  // alerta fecha invalida
  if($_POST['variableFechaB'] != NULL){
  $alertaEdadMensajeB=" 'Algunas fechas de nacimiento no son permitidas:  ".$_POST['variableFechaB']."'";
  }
  $alertaEdad=$_POST['alertaEdad'];
  $alertaFechaPermitida=$_POST['alertaFechaPermitida'];
  //$alertaFechaPermitida=" 'Algunas fechas de nacimiento no son permitidas ".$_POST['variableFecha']." ' "; //$_POST['alertaFechaPermitida'];
  // alerta numerico en la CC
  $noesNumerico=$_POST['noesNumerico'];
  
  // alerta telefono mal ingresado
  $noesNumericoT=$_POST['noesNumericoT'];
   
  // alerta correo
  $alertaConfirmacionCorreo=$_POST['alertaConfirmacionCorreo'];
  
  //// validación de campo vacio, identificando la columna que contiene el campo vacio
$validacionExisteImportacionVacio=$_POST['validacionExisteImportacionVacio'];
$mensajeEnviarCampoVacio=" 'Algunos campos están vacios ".$_POST['mensajeEnviarCampoVacio']." ' ";
/// END

/// campos repetidos dentro de centro de trabajo
$validacionRepiteRepiteCentroTrabajo=$_POST['validacionRepiteRepiteCentroTrabajo'];

/// campos repetidos dentro de grupos de distribución
$validacionRepiteRepiteGruposDistri=$_POST['validacionRepiteRepiteGruposDistri'];

$validacionExisteImportacionGExiste=$_POST['validacionExisteImportacionGExiste'];
?>
  <script type="text/javascript">
    $(function() {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        
        <?php
        if($validacionRepiteRepiteCentroTrabajo == 1 || $validacionRepiteRepiteGruposDistri == 1){
        ?>
        timer: 12000
        <?php
        }else{
        ?>
        timer: 7000
        <?php
        }
        ?>
        
      });
      
      
      <?php  
      if($_POST['mensajeAlertaFechaFallo'] == 1){
      ?>
        Toast.fire({
            type: 'warning',
            title: 'Algunas fechas de nacimiento no son permitidas, excede los caracteres permitidos.'
        })
      <?php
      } 
       if($validacionExisteImportacionGExiste == 1){
      ?>
        Toast.fire({
            type: 'warning',
            title: 'Algunos usuarios ya existen: <?php echo $_POST['mensaje_existente_usuario'];?>'
        })
      <?php
      } 
       if($validacionRepiteRepiteCentroTrabajo == 1){
      ?>
        Toast.fire({
            type: 'warning',
            title: 'Algunos campos están repetidos en el centro de trabajo: <?php echo $_POST['mensajeRepetidoCentroTrabajo'];?>'
        })
      <?php
      }
       if($validacionRepiteRepiteGruposDistri == 1){
      ?>
        Toast.fire({
            type: 'warning',
            title: 'Algunos campos están repetidos en el grupo de distribución: <?php echo $_POST['mensajeRepetidoGrupos'];?>'
        })
      <?php
      }
      
       if($validacionExisteImportacionVacio == 1){
      ?>
        Toast.fire({
            type: 'warning',
            title: <?php echo $mensajeEnviarCampoVacio;?>
        })
      <?php
      } 
      if($noesNumerico == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El documento de identidad no es válido: <?php echo $_POST['mensajeCedula'];?>'
          })
        <?php
      }
      
      if($noesNumericoT == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' Está intentando subir un teléfono invalido: <?php echo $_POST['mensajeTelefono'];?>'
          })
        <?php
      }
      
      if($Tipodocumeto == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El tipo de documento no es valido.'
          })
        <?php
      }
      
      if($alertaEdad == 1){ //' La edad y fecha de nacimiento es inferior a la permitida.'
      ?>
          Toast.fire({
              type: 'warning',
              title: <?php echo $alertaEdadMensaje;?>
          })
      <?php
      }
      if($_POST['variableFechaB'] != NULL){ //' La edad y fecha de nacimiento es inferior a la permitida.'
      ?>
          Toast.fire({
              type: 'warning',
              title: <?php echo $alertaEdadMensajeB;?>
          })
      <?php
      }
      
      
      
      
      if($alertaFechaPermitida == 1){ 
      ?>
          Toast.fire({
              type: 'warning',
              title:  'Algunas fechas de nacimiento no son permitidas: <?php echo $_POST['mensajeFechaNoPermitido'];?>'
          })
      <?php
      }
      
      if($alertaConfirmacionCorreo == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos de los correos electrónicos no son válidos: <?php echo $_POST['mensajeCorreo'];?>'
          })
      <?php
      }
      /*if($validacionExisteImportacionVacio == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos campos están vacios.'
          })
      <?php
      }*/
       if($validacionExisteImportacionA == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos cargos no existen en el sistema: <?php echo $_POST['mensajeCargo'];?>'
          })
      <?php
      }
      if($validacionExisteImportacionB == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos lideres no existen en el sistema: <?php echo $_POST['mensajeLider']?>'
          })
      <?php
      }
      if($validacionExisteImportacionC == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos procesos no existen en el sistema: <?php echo $_POST['mensajeProceso'];?>'
          })
      <?php
      }
      if($validacionExisteImportacionD == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos centros de costos no existen en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionE == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos centros de trabajo no existen en el sistema: <?php echo $_POST['mensajeCentroTrabajo'];?>'
          })
      <?php
      }
      if($validacionExisteImportacionF == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos grupos de distribución no existen en el sistema: <?php echo $_POST['mensajeRepiteGrupo'];?>'
          })
      <?php
      }
      if($validacionExisteImportacionG == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos documentos de identidad están repetidos en el documento: <?php echo $_POST['mensajeRepiteCC'];?>'
          })
      <?php
      }
      if($validacionExisteImportacionI == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Está intentando subir un archivo diferente.'
          })
      <?php
      }
      
      
      if($validacionExiste == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' El usuario ya existe.'
          })
      <?php
      }
      if($validacionExisteA == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' La fecha seleccionada no debe superar la del presente año.'
          })
      <?php
      }
      if($validacionExisteB == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' El número de cédula pertenece a otro usuario.'
          })
      <?php
      }
      
      if($validacionAgregar == 1){
      ?>
          Toast.fire({
              type: 'success',
              title: 'Registro agregado.'
          })
      <?php
      }
      if($validacionAgregarB == 1){
      ?>
          Toast.fire({
              type: 'success',
              title: 'Registro activado.'
          })
      <?php
      }
      
      if($validacionActualizar == 1){
      ?>
          Toast.fire({
              type: 'info',
              title: 'Registro actualizado.'
          })
      <?php
      }
      
      if($validacionEliminar == 1){ 
      ?>
          Toast.fire({
              type: 'error',
              title: 'Registro eliminado.'
          })
      
      <?php
      }
      if($validacionEliminarB == 1){
      ?>
          Toast.fire({
              type: 'error',
              title: 'Registro Anulado.'
          })
      
      <?php
      }
      
    if($_POST['alertaEnter'] != NULL){ /// arrojamos el mensaje del enter
    ?>
        Toast.fire({
            type: 'warning',
            title: '<?php echo $_POST['titulo'];?> contiene un (ENTER) no permitido en la celda <?php echo $_POST['alertaEnter'];?> '
        })
    
    <?php
    }
      
      if($_POST['enviarMensajeCaracter'] != NULL){
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaNombre'){
        $mensajeCaracter='El nombre contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterNombre'){
        $mensajeCaracter='El nombre contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaApellido'){
        $mensajeCaracter='El apellido contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterApellido'){
        $mensajeCaracter='El apellido contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaTipo'){
        $mensajeCaracter='El tipo de documento contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterTipo'){
        $mensajeCaracter='El tipo de documento contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaDocumento'){
        $mensajeCaracter='El documento de identidad contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterDocumento'){
        $mensajeCaracter='El documento de identidad contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaFecha'){
        $mensajeCaracter='La fecha de nacimiento contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterFecha'){
        $mensajeCaracter='La fecha de nacimiento contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaCorreo'){
        $mensajeCaracter='El correo contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterCorreo'){
        $mensajeCaracter='El correo contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaTelefono'){
        $mensajeCaracter='El teléfono contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterTelefono'){
        $mensajeCaracter='El teléfono contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaProceso'){
        $mensajeCaracter='El proceso contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterProceso'){
        $mensajeCaracter='El proceso contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaCargo'){
        $mensajeCaracter='El cargo contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterCargo'){
        $mensajeCaracter='El cargo contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaLider'){
        $mensajeCaracter='El líder contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterLider'){
        $mensajeCaracter='El líder contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaCentroTrabajo'){
        $mensajeCaracter='El centro de trabajo contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterCentroTrabajo'){
        $mensajeCaracter='El centro de trabajo contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaArl'){
        $mensajeCaracter='La ARL contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterArl'){
        $mensajeCaracter='La ARL contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaEps'){
        $mensajeCaracter='La EPS contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterEps'){
        $mensajeCaracter='La EPS contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaAfp'){
        $mensajeCaracter='La AFP contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterAfp'){
        $mensajeCaracter='La AFP contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaGrupo'){
        $mensajeCaracter='El grupo de distribución contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterGrupo'){
        $mensajeCaracter='El grupo de distribución contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        
       
    ?>
        Toast.fire({
            type: 'warning',
            title: '<?php echo $mensajeCaracter;?> '
        })
    
    <?php
    }
      ?>
      
    });

  </script>
  <script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
</body>
</html>
<?php

}
?>