<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

//////////////////////PERMISOS////////////////////////

$formulario = 'repositorio'; //aqui se cambia el nombre del formulario

require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////


$ruta = $_POST['ruta'];//ruta que se quieren ver los registros.
?>
<!DOCTYPE html>
<html>
    
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Lista de registros</title>
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
<body class="hold-transition sidebar-mini">
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
            <h1>Lista de regitros: <?php echo $ruta;?></h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Lista de regitros</li>
            </ol>
          </div>
        </div>
        <div>
            <?php
                if($visibleI == FALSE){
            ?>
            <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="repositorio.php"><font color="white"><i class="fas fa-list"></i> Repositorio</font></a></button>
            </div>
            <div class="col-sm">
                <form action="exportacion/registros" method="POST">
                    <input type="hidden" name="ruta" value="<?php echo $ruta;?>">
                    <button type="submit" class="btn btn-block btn-warning btn-sm"><font color="white"><i class="fas fa-download"></i> Exportar</font></button>
                </form>
            </div>
            <div class="col-sm">
            </div>
            <div class="col-sm">
            </div>
            <div class="col-sm">
                
            </div>
            </div>
            <?php }else{?>
            <div class="row">
                <div class="col-sm">
                    <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/usuarios'"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
                </div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
            </div>

            <?php }?>
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
                <h3 class="card-title">Lista</h3>
                <br>
                <div>
                          <?php require_once'habilitarOcultar.php';?>
                </div>
                <div class="card-tools">
                    <?php
                    
                    
                    
                    //////conserva la consulta
                     $consultaBuscar=$_POST['buscar'];
                     $fechaBuscar = $_POST['fechaBuscar'];
                     $procesoBuscar = $_POST['procesoBuscar'];
                     $tipoDocBuscar = $_POST['tipoDocBuscar'];
                     $estado = $_POST['estado'];
                     $aprobadorB = $_POST['aprobador'];
                     $fechaAprobacion= $_POST['fechaA'];
                     $SelectAprobador=$_POST['SelectAprobador'];
                     
                    if($consultaBuscar != NULL || $fechaBuscar != NULL || $procesoBuscar != NULL || $tipoDocBuscar != NULL || $estado != NULL || $aprobadorB != NULL || $fechaAprobacion != NULL || $SelectAprobador != NULL){
                         $filtroActivar='';  
                     }else{
                         $filtroActivar='none';
                     }
                    ?>        
                            
                            
                            
                    <div id="aprovar_regitros" style="display:<?php echo $filtroActivar; ?>;">
                        <form action="" method="POST">  
                        <input type="hidden" name='ruta' value='<?php echo $ruta?>'>
                          <table>
                          <tr>
                              <td>
                                  <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="buscar" class="form-control float-right" value="<?php echo $consultaBuscar; ?>" placeholder="Nombre">
                                      <div class="input-group-append">
                                      
                                    </div>
                                  </div>
                              </td>
                              <td>
                                  <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="date" name="fechaBuscar" class="form-control float-right" value="" placeholder="Fecha">
                                      <div class="input-group-append">
                                      
                                      </div>
                                  </div>      
                              </td>
                              <td>
                                  <div class="input-group input-group-sm" style="width: 150px;">
                                    <?php
                                        require_once'conexion/bd.php';
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $resultado=$mysqli->query("SELECT nombre, id FROM procesos ORDER BY nombre");
                                    ?>
                                    <select type="text" class="form-control" id="descripcion" name="procesoBuscar">
                                        <option value=''>Seleccionar proceso</option>
                                        <?php
                                        while ($columna = mysqli_fetch_array( $resultado )) {
                                            if($procesoBuscar == $columna['id']){
                                                $selecProce = "selected";    
                                            }else{
                                                $selecProce = "";
                                            }
                                        ?>
                                        <!-- <option value="<?php //echo $columna['id']; ?>" <?php //echo $selecProce; ?>><?php //echo $columna['nombre']; ?> </option> -->
                                        
                                        <option value="<?php echo $columna['id']; ?>" ><?php echo $columna['nombre']; ?> </option>
                                        <?php }  ?>
                                    </select>
                                  </div>      
                              </td>
                              <td>
                                  <div class="input-group input-group-sm" style="width: 150px;">
                                    <?php
                                        require_once'conexion/bd.php';
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $resultado=$mysqli->query("SELECT nombre, id FROM tipoDocumento ORDER BY nombre");
                                    ?>
                                    <select type="text" class="form-control" id="descripcion" name="tipoDocBuscar"  >
                                        <option value=''>Seleccionar tipo documento</option>
                                        <?php
                                        while ($columna = mysqli_fetch_array( $resultado )) {
                                             
                                             if($tipoDocBuscar == $columna['id']){
                                                $selecTipoDoc = "selected";    
                                            }else{
                                                $selecTipoDoc = "";
                                            }
                                        ?>
                                        <!-- <option value="<?php //echo $columna['id']; ?>" <?php //echo $selecTipoDoc;?>><?php //echo $columna['nombre']; ?> </option>
                                         -->
                                        <option value="<?php echo $columna['id']; ?>" ><?php echo $columna['nombre']; ?> </option>
                                        <?php }  ?>
                                    </select>
                                  </div>      
                              </td>
                              
                             <!--
                              <td>
                                  <div class="input-group input-group-sm" style="width: 150px;">
                                      <div class="input-group-append">
                                      <button type='button' Onclick="window.location='usuarios'" class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Limpiar busqueda</button>
                                      </div>
                                  </div>      
                              </td> -->
                          </tr>
                      </table>
                      <table>
                          <tr>
                              <td>
                                  <font color="white">Hola</font>
                              </td>
                          </tr>
                      </table>
                      <table>
                          <tr>
                              <td>
                                  <div class="input-group input-group-sm" style="width: 150px;">
                                    <select type="text" class="form-control"  name="SelectAprobador" placeholder="Aprobador" value="">
                                        <option value="">Seleccionar Aprobador</option>
                                        <option value="cargos">Cargos</option>
                                        <option value="usuarios">Usuarios</option>
                                    </select>
                                  </div>      
                              </td>
                              <td>
                                  <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" class="form-control"  name="aprobador" placeholder="Aprobador" value="<?php echo $aprobadorB; ?>">
                                  </div>      
                              </td>
                              <td>
                                  <div class="input-group input-group-sm" style="width: 150px;">
                                    <select type="text" class="form-control" id="descripcion" name="estado" placeholder="Estado" >
                                        <option value="">Seleccionar estado</option>
                                        <option value="Aprobado">Aprobado</option>
                                        <option value="Pendiente">Pendiente</option>
                                        <option value="Rechazado">Rechazado</option>
                                        </select>
                                  </div>      
                              </td>
                              <td>
                                  <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="date" class="form-control"  name="fechaA" > 
                                  </div>      
                              </td>
                              <td>
                                  <div class="input-group input-group-sm" style="width: 150px;">
                                      <div class="input-group-append">
                                      <button type='submit'  class='btn btn-block btn-info btn-sm'><i class='fas fa-search'></i>Buscar</button>
                                      </div>
                                  </div>      
                              </td>
                          </tr>
                      </table>
                    </form>    
                </div>
              </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 800px;">
                <table class="table table-head-fixed text-center">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nombre del regitro</th>
                      <th>Fecha de creación</th>
                      <th>Proceso</th>
                      <th>Tipo de documento</th>
                      <th>Aprobador</th>
                      <th>Estado</th>
                      <th>Fecha de aprobación</th>
                      <th>Ver más</th>
                      <th style="display:<?php echo$visibleE;?>;">Editar</th>
                      <th style="display:<?php echo$visibleD;?>;">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                     
                  /* echo $procesoBuscar;
                   echo $consultaBuscar;
                   echo $fechaBuscar;
                   echo $tipoDocBuscar;
                   echo $estado;
                   echo $fechaAprobacion; */
                   
                     if($consultaBuscar != NULL || $fechaBuscar != NULL || $procesoBuscar != NULL || $tipoDocBuscar != NULL || $estado != NULL || $fechaAprobacion != NULL || $aprobadorB != NULL || $SelectAprobador != NULL){ // DATE(fechaCreacion)
                      
                        $ruta = trim($ruta);
                        $data = $mysqli->query("SELECT * FROM registros WHERE carpeta = '$ruta' AND nombre LIKE '%$consultaBuscar%' AND fechaCreacion LIKE '%$fechaBuscar%' AND  estado LIKE '%$estado%'  ")or die(mysqli_error());
                        
                        if($procesoBuscar != NULL || $fechaAprobacion != NULL){
                        $data = $mysqli->query("SELECT * FROM registros WHERE carpeta = '$ruta' AND idProceso='$procesoBuscar' OR fechaAprobacion LIKE '%$fechaAprobacion%' OR idTipoDocumento LIKE '%$tipoDocBuscar%'  ")or die(mysqli_error());
                        }
                        
                        if($tipoDocBuscar != NULL ){
                        $data = $mysqli->query("SELECT * FROM registros WHERE carpeta = '$ruta' AND idTipoDocumento='$tipoDocBuscar'  ")or die(mysqli_error());
                        }
                        
                        if($SelectAprobador != NULL || $aprobadorB  != NULL){
                         
                            $data = $mysqli->query("SELECT * FROM registros WHERE carpeta = '$ruta' AND aprobador='$SelectAprobador'  ")or die(mysqli_error());
                        }
                       
                     }else{
                        
                        $data = $mysqli->query("SELECT * FROM registros WHERE carpeta = '$ruta' ORDER BY id DESC" )or die(mysqli_error());
                     
                         
                     }
                     $n = 1;
                     //echo $ruta;
                     while($row = $data->fetch_assoc()){
                         
                        $idRegistro= $row['id'];
                        $quienAprueba = $row['aprobador'];
                        $quienApruebaID = json_decode($row['aprobadorID']);
                        $longitud = count($quienApruebaID);
                        $idEdit = $row['id'];
                        $idProceso = $row['idProceso'];
                        $idTipoDocumento = $row['idTipoDocumento'];
                        
                        if($idProceso == NULL && $idTipoDocumento == NULL ){
                            
                            $proceso = "<b>No Aplica</b>";
                            $tipoDocumento = "<b>No Aplica</b>";
                        }else{
                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                            $queryConsultaProcesos=$mysqli->query("SELECT nombre FROM procesos WHERE id = $idProceso ");
    	                    $rowConsultaP=$queryConsultaProcesos->fetch_array(MYSQLI_ASSOC);
    	                    $proceso = $rowConsultaP['nombre'];
    	                    
    	                    $acentos = $mysqli->query("SET NAMES 'utf8'");
    	                    $queryTipoDoc=$mysqli->query("SELECT nombre FROM tipoDocumento WHERE id = $idTipoDocumento ");
    	                    $rowConsultaTD=$queryTipoDoc->fetch_array(MYSQLI_ASSOC);
    	                    $tipoDocumento = $rowConsultaTD['nombre'];
    	                    
                        }
                        
                        
                        
                    echo"<tr>";
                    echo "<td>".$n."</td>";
                    echo "<td>".$row['nombre']."</td>";
                    echo "<td>".$row['fechaCreacion']."</td>";
                    echo "<td>".$proceso."</td>";
                    echo "<td>".$tipoDocumento."</td>";
                    ?>
                    <td>
                    <?php
                    
                        if($quienAprueba == 'usuarios'){
                                    
                            for($i=0; $i<$longitud; $i++){
                            
                                $nombreuser = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$quienApruebaID[$i]'");
                                $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                            
                                echo "- ".$aprobador = $columna['nombres']." ".$columna['apellidos']; echo "<br>";
                                     
                            }
                        }
                        if($quienAprueba == 'cargos'){
                                    
                            for($i=0; $i<$longitud; $i++){
                                $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienApruebaID[$i]'");
                                $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                echo "- ".$aprobador = $columna['nombreCargos'];echo "<br>";
                            }
                        }
                        if($quienAprueba == NULL){
                            echo "<strong>No Aplica</strong>";
                        }
                        
                    ?>
                    </td>
                    <?php
                    
                    echo "<td>".$row['estado']."</td>";
                    
                    
                    
                    
                    if($row['fechaAprobacion'] == NULL){
                        echo "<td><strong> No aplica</strong></td>";
                    }else{
                        echo "<td>".$row['fechaAprobacion']."</td>";
                    }
                    
                   
                                        
                    echo"<form action='verRegistro' method='POST'>";
                    echo"<input type='hidden' name='idRegistro' value= '$idRegistro' >";
                    echo"<input type='hidden' name='idDocumento' value= '$idDocumento' >";
                    echo"<input type='hidden' name='ruta' value= '$ruta' >";
                    echo"<td><button type='submit' class='btn btn-block btn-primary btn-sm'><i class='fas fa-eye'></i> Ver más</button></td>";
                    echo"</form>";
                    echo"<form action='editarRegistro' method='POST'>";
                    echo"<input type='hidden' name='idRegistro' value= '$idRegistro' >";
                    echo"<input type='hidden' name='idDocumento' value= '$idDocumento' >";
                    echo"<input type='hidden' name='ruta' value='$ruta' >";
                    echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                    echo"</form>";
                    echo"<form action='controlador/registros/controller.php' method='POST'>";
                    echo"<input type='hidden' name='idRegistro' value= '$idRegistro' >";
                    echo"<input type='hidden' name='idDocumento' value= '$idDocumento' >";
                    echo"<input type='hidden' name='ruta' value= '$ruta' >";
                    
                    echo" <td style='display:$visibleD;'><button onclick='return ConfirmDelete()' type='submit' name='eliminar' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                    echo"</form>";
                    echo"</tr>";
                    $n++;    
                    } 
                    ?>
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
</script>

</body>
</html>
<?php
}
?>