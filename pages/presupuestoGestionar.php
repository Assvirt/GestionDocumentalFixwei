<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'usuarios'; //Se cambia el nombre del formulario
//traemos datos de presupuesto para permisos
 $tipoUC = $_POST['tipo']; //tipo usuario cargo
$cedulaU = $_POST['cedula']; //cedula de usuario
 $cargoU = $_POST['cargo']; //cargo de usuario
$sqlcargo = $mysqli->query("SELECT id_cargos as id FROM cargos WHERE nombreCargos = '$cargoU'");
$col = $sqlcargo->fetch_array(MYSQLI_ASSOC);
$idCargoU = $col['id'];
 $idCargoU; 



$documento = $_SESSION["session_username"];
$queryGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario = '$documento'");



while($row = $queryGrupos->fetch_assoc()){
    $idGrupo = $row['idGrupo'];
    
    $queryPermisos = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupo' AND formulario = '$formulario'");
    
    $permisos = $queryPermisos->fetch_array(MYSQLI_ASSOC);
    if($permisos['listar'] == TRUE){
        $permisoListar = $permisos['listar'];    
    }
    if($permisos['crear'] == TRUE){
        $permisoInsertar = $permisos['crear'];    
    }
    if($permisos['editar'] == TRUE){
        $permisoEditar = $permisos['editar'];    
    }
    if($permisos['eliminar'] == TRUE){
        $permisoEliminar = $permisos['eliminar'];    
    }
    
}


if($permisoListar == FALSE){
    echo '<script language="javascript">window.location.href="accesoDenegado"</script>';
}

if($permisoInsertar == FALSE){
    $visibleI = 'none';
}else{
    $visibleI = '';
}

if($permisoEditar == FALSE){
    $visibleE = 'none';
}else{
    $visibleE = '';
}

if($permisoEliminar == FALSE){
    $visibleD = 'none';
}else{
    $visibleD = '';
}

//validacion de tipo para usar o cedula o cargo

if($tipoUC == 'cargo'){
    //compare el session con el cargo
    
    
    
    if($idGrupo == $idCargoU){
        
        $permission = true;
    }
}else{
    //compare el session con la cedula 
    //es lo mismo de arriba pero no tengo muy claro como hacerlo.. o si sirva de algo
    if($documento == $cedulaU){
        
        $permission = true;
    }
}
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
    <title>Gestionar</title>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI</title>
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
              <?php
              $idPresupuesto=$_POST['idPresupuesto'];
               
                    $query = $mysqli->query("SELECT * FROM presupuesto WHERE id= '$idPresupuesto'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $idPresupuestoSalida = $row['id'];
                    $nombre = $row['nombre'];
                    
              ?>
            <h1>Gestionar presupuesto para <b><?php echo $nombre; ?></b> </h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Gestionar</li>
            </ol>
          </div>
        </div>
        <div>
        <div class="row">
            <?php
                if($visibleI == FALSE){
            ?>
            <?php
                     require 'conexion/bd.php';
                     //$acentos = $mysqli->query("SET NAMES 'utf8'");
                     
                     
                        $data = $mysqli->query("SELECT * FROM presupuesto WHERE id='$idPresupuesto' ")or die(mysqli_error());
                     
                     $conteo=1;
                     while($row = $data->fetch_assoc()){
                        $id = $row['id'];
                        $tipoResponsable=$row['tipoResponsable'];
                        $personalID =  json_decode($row['responsable']);
                        $longitud = count($personalID);
                             if($tipoResponsable == 'usuario'){
                                    
                                    for($i=0; $i<$longitud; $i++){
                                        
                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalID[$i]'");
                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                    
                                        $columna['nombres']." ".$columna['apellidos'];echo "<br>";
                                        $cedulaUsuarioV=$columna['cedula'];
                                    }
                                 
                                }else{
                                    
                                    for($i=0; $i<$longitud; $i++){
                                    $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$personalID[$i]'");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    $columna['nombreCargos']; 
                                    }
                                }
                    
                    
            	    
                    /////// validacion por usuario para botones de editar y eliminar
                        if($tipoResponsable == 'usuario'){
                                      
                                        for($i=0; $i<$longitud; $i++){ //// inicia for
                                            
                                            $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalID[$i]' AND cedula='$cc' ");
                                            while($columna = $nombreuser->fetch_assoc()){
                                                $cedulaUsuarioV=$columna['cedula']; //echo "<br>";
                                            }
                                        }  /////// cierre del for
                                        
                        if($cc == $cedulaUsuarioV){ 
                           
                        ?>
                        <div class="col-sm">
                            <form action="agregarPresupuestoGestion" method="POST">
                                <input value="<?php echo $idPresupuesto; ?>" name="idPresupuesto" type="hidden" readonly >
                            <button type="submit" disabled class="btn btn-block btn-info btn-sm"><disabled><a href="#"><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>
                            </form>
                        </div>
                        <div class="col-sm">
                            <form action="agregarPresupuestoGestionarGC" method="POST">
                                <input value="<?php echo $idPresupuesto; ?>" name="idPresupuesto" type="hidden" readonly >
                            <button type="submit" disabled class="btn btn-block btn-info btn-sm"><disabled><a href="#"><font color="white"><i class="fas fa-plus-square"></i> Grupo de costos</font></a></button>
                            </form>
                        </div>
                        <div class="col-sm">
                            <form action="agregarPresupuestoGestionarSGC" method="POST">
                                <input value="<?php echo $idPresupuesto; ?>" name="idPresupuesto" type="hidden" readonly >
                            <button type="submit" disabled class="btn btn-block btn-info btn-sm"><disabled><a href="#"><font color="white"><i class="fas fa-plus-square"></i> Grupo de gastos</font></a></button>
                            </form>
                        </div>
                        
                        <?php
                        }else{ 
                          
                        ?>    
                        <div class="col-sm">
                            <button type="submit" disabled class="btn btn-block btn-info btn-sm"><disabled><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>
                        </div>
                        <div class="col-sm">
                            <button type="submit" disabled class="btn btn-block btn-info btn-sm"><disabled><a href=""><font color="white"><i class="fas fa-plus-square"></i> Grupo de costos</font></a></button>
                        </div>
                        <div class="col-sm">
                            <button type="submit" disabled class="btn btn-block btn-info btn-sm"><disabled><a href=""><font color="white"><i class="fas fa-plus-square"></i> Grupo de gastos</font></a></button>
                        </div>
                        
                        <?php    
                        }             
                    /////////// finaliza el botón para el usuario editar y eliminar 
                   
                   //////////// validacion por cargo del boton de editar y eliminar
                                }else{
                                    
                                    
                                     if (in_array($cargo, $personalID) ) {
                                        ?>
                                        <div class="col-sm">
                                            <form action="agregarPresupuestoGestion" method="POST">
                                                <input value="<?php echo $idPresupuesto; ?>" name="idPresupuesto" type="hidden" readonly >
                                            <button type="submit" disabled class="btn btn-block btn-info btn-sm"><disabled><a href=""><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>
                                            </form>
                                        </div>
                                        <div class="col-sm">
                                            <form action="agregarPresupuestoGestionarGC" method="POST">
                                                <input value="<?php echo $idPresupuesto; ?>" name="idPresupuesto" type="hidden" readonly >
                                            <button type="submit" disabled class="btn btn-block btn-info btn-sm"><disabled><a href="#"><font color="white"><i class="fas fa-plus-square"></i> Grupo de costos</font></a></button>
                                            </form>
                                        </div>
                                        <div class="col-sm">
                                            <form action="agregarPresupuestoGestionarSGC" method="POST">
                                                <input value="<?php echo $idPresupuesto; ?>" name="idPresupuesto" type="hidden" readonly >
                                            <button type="submit" disabled class="btn btn-block btn-info btn-sm"><disabled><a href="#"><font color="white"><i class="fas fa-plus-square"></i> Grupo de gastos</font></a></button>
                                            </form>
                                        </div>
                                        <?php   
                                        }else{
                                        ?>   
                                        <div class="col-sm">
                                            <button type="submit" disabled class="btn btn-block btn-info btn-sm"><disabled><a href="#"><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>
                                        </div>
                                        <div class="col-sm">
                                            <button type="submit" disabled class="btn btn-block btn-info btn-sm"><disabled><a href="#"><font color="white"><i class="fas fa-plus-square"></i> Grupo de costos</font></a></button>
                                        </div>
                                        <div class="col-sm">
                                            <button type="submit" disabled class="btn btn-block btn-info btn-sm"><disabled><a href="#"><font color="white"><i class="fas fa-plus-square"></i> Grupo de gastos</font></a></button>
                                        </div>
                                        <?php   
                                        }
                                    
                                    
                                    
                                    
                                    
                                } //////// finaliza el  validaciones con los botones
                    
                    
              
                    
                        
                    }  /// finaliza permiso botones
                    ?>
            
            
            
            <div class="col-sm">
                <div class="col-sm">
            <button type="button" class="btn btn-block btn-success btn-sm"><a href="presupuesto"><font color="white"><i class="fas fa-list"></i> Regresar</font></a></button>
            </div>
            </div>
            <div class="col-sm">
            </div>
            <div class="col-sm">
            </div>
            <div class="col-sm">
            </div>
            </div>
            <?php }else{?>
            

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
                  <?php
                  //////// se valida con el id del presupuesto para traer el valor del presupuesto
                    //require 'conexion/bd.php';
                    $queryPresupuesto = $mysqli->query("SELECT * FROM presupuesto WHERE id='$idPresupuesto'");
                    $datosPrespuesto = $queryPresupuesto->fetch_array(MYSQLI_ASSOC);
                    $TotalPresupuestoGeneral=$datosPrespuesto['totalPresupuesto'];
                    ///// fin del proceso
                  $data = $mysqli->query("SELECT * FROM presupuestoGestionar WHERE idPresupuesto='$idPresupuesto' ORDER BY tipo ASC")or die(mysqli_error());
                     while($row = $data->fetch_assoc()){
                         $disponibl+=$totalPresupuesto=$row['totalPresupuesto'];
                     }
                     $disponible=$TotalPresupuestoGeneral-$disponibl;
                  ?>
                <h3 class="card-title">De los <b>$ <?php echo number_format($TotalPresupuestoGeneral,0,'.',','); ?></b> del presupuesto actual van <b>$ <?php echo  number_format($disponibl,0,'.',','); ?></b> asignados,
                <?php if($disponible == 0){ echo 'el presupuesto  está completo.'; }else{ ?> de los cuales <b>$ <?php echo  number_format($disponible,0,'.',','); ?></b> están sin asignar.<?php } ?></h3>
                
                
                <div class="card-tools">
                            
                         
                            
                            
              </div>
            </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 800px;">
                <table class="table table-head-fixed text-center">
                  <thead>
                    <tr>
                      <th>N°</th>
                      <th>Procesos/Centro de costos</th>
                      <th>Total presupuesto</th>
                      <th>Total ejecutado</th>
                      <th>Responsable</th>
                      <th>Participaci&oacute;n</th>
                      <th>Avance</th>
                      <th>Ver más</th>
                      <th style="display:<?php echo$visibleE;?>;">Editar</th>
                      <th style="display:<?php echo$visibleD;?>;">Eliminar</th>
                     
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     //$acentos = $mysqli->query("SET NAMES 'utf8'");
                     $consultaBuscar=$_POST['buscar'];
                     $consultaBuscar2=$_POST['buscar2'];
                     $consultaBuscar3=$_POST['buscar3'];
                     $consultaBuscar4=$_POST['buscar4'];
                     $consultaBuscar5=$_POST['buscar5'];
                     $consultaBuscar6=$_POST['buscar6'];
                     $consultaBuscar7=$_POST['buscar7'];
                     $consultaBuscar8=$_POST['buscar8'];
                     $consultaBuscar9=$_POST['buscar9'];
                     
                     if($consultaBuscar != NULL || $consultaBuscar2 != NULL || $consultaBuscar3 != NULL || $consultaBuscar4 != NULL || $consultaBuscar5 != NULL || $consultaBuscar6 != NULL || $consultaBuscar7 != NULL || $consultaBuscar8 != NULL || $consultaBuscar9 != NULL){
                         
                         
                        
                         
                     }else{
                        $data = $mysqli->query("SELECT * FROM presupuestoGestionar WHERE idPresupuesto='$idPresupuesto' ORDER BY tipo ASC")or die(mysqli_error());
                     }
                     $conteo=1;
                     while($row = $data->fetch_assoc()){
                        $id = $row['id'];
                    echo"<tr>";
                    echo"<td>".$conteo++."</td>";
                     //echo "<td>".$row['tipo']."</td>";
                     $tipoProcesoCosto=$row['tipoProcesoCosto'];
                     $procesoCostoDatos=json_decode($row['procesoCosto']);
                     $longitudP = count($procesoCostoDatos);
                   
                    if($tipoProcesoCosto == 'proceso'){
                                    echo"<td>";
                                    for($i=0; $i<$longitudP; $i++){
                                        
                                        $nombreProceso = $mysqli->query("SELECT * FROM procesos WHERE id = '$procesoCostoDatos[$i]'");
                                        $columnaP = $nombreProceso->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo $columnaP['nombre'];echo "<br>";
                                       
                                    } echo"</td>";
                                 
                                }else{
                                    echo"<td>";
                                    for($i=0; $i<$longitudP; $i++){
                                    $nombreCentro = $mysqli->query("SELECT * FROM centroCostos WHERE id = '$procesoCostoDatos[$i]'");
                                    $columnaC = $nombreCentro->fetch_array(MYSQLI_ASSOC);
                                    echo $columnaC['nombre']; echo "<br>";
                                    } "</td>";
                                }
                   
                   
                   
                    $totalPresupuesto=$row['totalPresupuesto'];
                    echo "<td> $ ". number_format($totalPresupuesto,0,'.',',') ."</td>";
                    $totalEjecutado=$row['totalEjecutado'];
                    echo "<td> $ ". number_format($totalEjecutado,0,'.',',')."</td>";
                    $tipoResponsable=$row['tipoResponsable'];
                            $personalID =  json_decode($row['responsable']);
                            $longitud = count($personalID);
                            
                             if($tipoResponsable == 'usuario'){
                                    echo"<td>";
                                    for($i=0; $i<$longitud; $i++){
                                        
                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalID[$i]'");
                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo $columna['nombres']." ".$columna['apellidos'];echo "<br>";
                                        $cedulaUsuario=$columna['cedula'];
                                    } echo"</td>";
                                 
                                }else{
                                    echo"<td>";
                                    for($i=0; $i<$longitud; $i++){
                                    $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$personalID[$i]'");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    echo $columna['nombreCargos']; echo "<br>";
                                    } "</td>";
                                }        
                            $porcentaje=100*$totalPresupuesto/$TotalPresupuestoGeneral;
                            $mostrarPorcentaje+=100*$totalPresupuesto/$TotalPresupuestoGeneral;
                            echo" <td>".round($porcentaje)."%</td>";
                            echo" <td>".$row['avance']."</td>";
                    
                    
                    echo"<form action='presupuestoGestionarVer' method='POST'>";
                    echo"<input type='hidden' name='idProveedor' value= '$id' >";
                    echo"<input type='hidden' name='idPresupuesto' value= '$idPresupuesto' >";
                    echo"<td><button type='submit' class='btn btn-block btn-primary btn-sm'><i class='fas fa-eye'></i> Ver más</button></td>";
                    echo"</form>";
                    
                    /////// validacion por usuario para botones de editar y eliminar
                        if($tipoResponsable == 'usuario'){
                                      
                                        for($i=0; $i<$longitud; $i++){ //// inicia for
                                            
                                            $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalID[$i]' AND cedula='$cc' ");
                                            while($columna = $nombreuser->fetch_assoc()){
                                                $cedulaUsuario=$columna['cedula']; //echo "<br>";
                                            }
                                        }  /////// cierre del for
                                      
                        if($cc == $cedulaUsuario || $permission == TRUE){  
                        echo"<form action='presupuestoGestionarEditar' method='POST'>";
                        echo"<input type='hidden' name='idPresupuestoGestionar' value= '$id' >";
                        echo"<input type='hidden' name='idPresupuesto' value= '$idPresupuesto' >";
                        echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                        echo"</form>";
                        echo"<form action='controlador/presupuesto/controllerPresupuestoGestionar' method='POST'>";
                        echo"<input type='hidden' name='idPresupuestoGestionar' value= '$id' >";
                        echo"<input type='hidden' name='idPresupuesto' value= '$idPresupuesto' >";
                        echo" <td style='display:$visibleD;'><button onclick='return ConfirmDelete()' type='submit' name='Eliminar' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                        echo"</form>";
                        }else{ 
                       
                        echo" <td style='display:$visibleE;'><button type='submit' disabled class='btn btn-block btn-success btn-sm'><disabled><i class='fas fa-edit'></i> Editar</button></td>";
                       
                        echo" <td style='display:$visibleD;'><button disabled type='submit' name='Eliminar' class='btn btn-block btn-danger btn-sm'><disabled><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                       }             
                    /////////// finaliza el botón para el usuario editar y eliminar 
                   
                   //////////// validacion por cargo del boton de editar y eliminar
                                }else{
                                    
                                    
                                     if (in_array($cargo, $personalID) || $permission == TRUE) { 
                                            echo"<form action='presupuestoGestionarEditar' method='POST'>";
                                            echo"<input type='hidden' name='idPresupuestoGestionar' value= '$id' >";
                                            echo"<input type='hidden' name='idPresupuesto' value= '$idPresupuesto' >";
                                            echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                                            echo"</form>";
                                            echo"<form action='controlador/presupuesto/controllerPresupuestoGestionar' method='POST'>";
                                            echo"<input type='hidden' name='idPresupuestoGestionar' value= '$id' >";
                                            echo"<input type='hidden' name='idPresupuesto' value= '$idPresupuesto' >";
                                            echo" <td style='display:$visibleD;'><button onclick='return ConfirmDelete()' type='submit' name='Eliminar' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                                            echo"</form>";
                                        }else{
                                           
                                            echo" <td style='display:$visibleE;'><button type='submit' disabled class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                                           
                                            echo" <td style='display:$visibleD;'><button  disabled type='submit' name='Eliminar' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                                           
                                        }
                                    
                                    
                                    
                                    
                                    
                                } //////// finaliza el  validaciones con los botones
                    
                  
               
                    
                        
                    } echo "</tr><tr><td> Se esta usando el <b>".round($mostrarPorcentaje)."%</b></td></tr>";
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
<script>
    $(document).ready(function(){
        $('#rad_si').click(function(){
            document.getElementById('aprovar_regitros').style.display = '';
        });
        $('#rad_no').click(function(){
            document.getElementById('aprovar_regitros').style.display = 'none';
        });
    });
</script>
</body>
</html>
<?php
}
?>