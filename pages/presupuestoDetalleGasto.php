<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'usuarios'; //Se cambia el nombre del formulario

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
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
    <title>Detalle Gasto</title>
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
            <h1>Detalles de gasto del presupuesto   <b><?php echo $nombre; ?></b> </h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Ver</li>
            </ol>
          </div>
        </div>
        <div>
        <div class="row">
            <?php
                if($visibleI == FALSE){
            ?>
           
            
            
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/presupuesto'"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
            </div>
            <div class="col-sm">
                <div class="col-sm">
                    <form action="presupuestoVer" method="POST">
                        <input name="idPresupuesto" value="<?php echo $idPresupuesto; ?>" type="hidden" readonly >
                    <button type="submit" class="btn btn-block btn-success btn-sm"><a><font color="white"><i class="fas fa-list"></i> Regresar</font></a></button>
                    </form>
                </div>
            </div>
            <div class="col-sm">
                <div class="col-sm">
                    <button type="submit" class="btn btn-block btn-success btn-sm"><a href="presupuesto"><font color="white"><i class="fas fa-list"></i> Vista PPL</font></a></button>
                </div>
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
               <? /* ?>  
                <div>
                            <input  type="radio" id="rad_si" name="radiobtn3" value="si" required>
                            <label  for="cargo">Habilitar filtros</label>
                            <input  type="radio" id="rad_no" name="radiobtn3" value="no" required>
                            <label  for="usuarios">Ocultar</label>
                </div> 
                
                <div class="card-tools">
                          <?php
                    //////conserva la consulta
                     $consultaBuscar=$_POST['buscar'];
                     $consultaBuscar2=$_POST['buscar2'];
                     $consultaBuscar3=$_POST['buscar3'];
                     $consultaBuscar4=$_POST['buscar4'];
                     $consultaBuscar5=$_POST['buscar5'];
                     $consultaBuscar6=$_POST['buscar6'];
                    if($consultaBuscar != NULL || $consultaBuscar2 != NULL || $consultaBuscar3 != NULL || $consultaBuscar4 != NULL || $consultaBuscar5 != NULL || $consultaBuscar6 != NULL || $consultaBuscar7 != NULL || $consultaBuscar8 != NULL || $consultaBuscar9 != NULL){
                         $filtroActivar='';  
                     }else{
                         $filtroActivar='none';
                     }
                    ?> 
                    <div id="aprovar_regitros" style="display:<?php echo $filtroActivar; ?>;">
                    <form action="" method="POST">  
                      <table>
                          <tr>
                              <td>
                                  <div class="input-group input-group-sm">
                                    Fecha inicial
                                  </div>
                              </td>
                              <td>
                                  <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="date" name="buscar" class="form-control float-right" value="<?php echo $consultaBuscar1; ?>" placeholder="Nombre del presupuesto">
                                      <div class="input-group-append">
                                      
                                    </div>
                                  </div>
                              </td>
                              <td>
                                  <div class="input-group input-group-sm">
                                    Fecha final
                                  </div>
                              </td>
                              <td>
                                  <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="date" name="buscar2" class="form-control float-right" value="<?php echo $consultaBuscar2; ?>" placeholder="Nombre del presupuesto">
                                      <div class="input-group-append">
                                      
                                    </div>
                                  </div>
                              </td>
                              <td>
                                  <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="buscar3" class="form-control float-right" value="<?php echo $consultaBuscar3; ?>" placeholder="Consecutivo">
                                      <div class="input-group-append">
                                      <!-- <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button> -->
                                    </div>
                                  </div>
                              </td>
                              <td>
                                  <div class="input-group input-group-sm" style="width: 150px;">
                                      <div class="input-group-append">
                                      <button type='submit' class='btn btn-block btn-info btn-sm'><i class='fas fa-search'></i>Buscar</button>
                                      </div>
                                  </div>      
                              </td>
                              
                          </tr>
                          
                          <tr>
                              <td>
                              </td>
                              <td>
                                  <input style="visibility:hidden;">
                              </td>
                          </tr>
                          
                          <tr>
                              <td>
                                  
                              </td>
                              <td>
                                  <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="buscar4" class="form-control float-right" value="<?php echo $consultaBuscar4; ?>" placeholder="Proceso">
                                      <div class="input-group-append">
                                      
                                    </div>
                                  </div>
                              </td>
                              <td>
                                  
                              </td>
                              <td>
                                  <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="buscar5" class="form-control float-right" value="<?php echo $consultaBuscar5; ?>" placeholder="Proveedor">
                                      <div class="input-group-append">
                                      
                                    </div>
                                  </div>
                              </td>
                              <td>
                                  <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="buscar6" class="form-control float-right" value="<?php echo $consultaBuscar6; ?>" placeholder="Aprobador">
                                      <div class="input-group-append">
                                     <!-- <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button> -->
                                    </div>
                                  </div>
                              </td>
                              <td>
                                        
                              </td>
                          </tr>
                      </table>
                    </form>
                </div>
                         
                            
                            
              </div>
              <? */ ?>
            </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 800px;">
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>N°</th>
                      <th>Orden de compra</th>
                      <th>Consecutivo</th>
                      <th>Proceso</th>
                      <th>Proveedor</th>
                      <th>Total costo</th>
                      <th>Aprobador</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>
                              1
                          </td>
                          <td>
                              Compra camaras
                          </td>
                          <td>
                              COT-050
                          </td>
                          <td>
                              Operaciones
                          </td>
                          <td>
                              Solo suministros
                          </td>
                          <td>
                              $ 6.250.000
                          </td>
                          <td>
                              Mauricio ruiz
                          </td>
                      </tr>
                     <?php/*
                     require 'conexion/bd.php';
                     //$acentos = $mysqli->query("SET NAMES 'utf8'");
                        $data = $mysqli->query("SELECT * FROM presupuestoGestionar WHERE idPresupuesto='$idPresupuesto' ORDER BY tipo ASC")or die(mysqli_error());
                     
                     $conteo=1;
                     while($row = $data->fetch_assoc()){
                        $id = $row['id'];
                    echo"<tr>";
                    echo"<td>".$conteo++."</td>";
                    echo "<td>".$row['tipo']."</td>";
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
                    
                    
                    echo"<form action='proveedoresVer' method='POST'>";
                    echo"<input type='hidden' name='idProveedor' value= '$id' >";
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
                                        
                        if($cc == $cedulaUsuario){ 
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
                       
                        echo" <td style='display:$visibleD;'><button disabled type='submit' name='Eliminar' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                       }             
                    /////////// finaliza el botón para el usuario editar y eliminar 
                   
                   //////////// validacion por cargo del boton de editar y eliminar
                                }else{
                                    
                                    
                                     if (in_array($cargo, $personalID)) {
                                            echo"<form action='idPresupuestoGestionar' method='POST'>";
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
                    
                  
               
                    
                        
                    } */
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

<!-- archivos para el filtro de busqueda y lista de información -->

    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>
<!-- END -->
</body>
</html>
<?php
}
?>