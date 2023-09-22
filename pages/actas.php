<?php
error_reporting(E_ERROR);
//Variables para carga de sesion
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
//require_once 'inactividad.php';

$celdulaUser = $_SESSION['session_username']; 
$cargoID = $_SESSION['session_cargo']; 
$idUsuario = $_SESSION['session_idUsuario'];

//////////////////////PERMISOS////////////////////////

$formulario = 'actas'; //aqui se cambia el nombre del formulario para las actas

require_once 'permisosPlataforma.php';
//////////////////////PERMISOS///////////////////////////
error_reporting(E_ERROR);
?>

<!DOCTYPE html>
<html>
    
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Actas</title>
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
            <h1>Actas</h1>
            <h6>Establezca la información, actividades y desarrollo de una reunión.</h6><br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Actas</li>
            </ol>
          </div>
        </div>
        <div>
            <?php
            if($root == 0){
                if($visibleI == FALSE){
            ?>
            <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarActa2"><font color="white"><i class="fas fa-plus-square"></i> Crear</font></a></button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="cargarActa"><font color="white"><i class="fas fa-upload"></i> Cargar acta</font></a></button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="plantillasActas"><font color="white"><i class="fas fa-plus-square"></i> Crear por plantilla</font></a></button>
            </div>
            <div class="col-sm">
                <form action="exportacion/actas" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="idGrupo" value="<?php echo $idGrupo;?>">
                    <input type="hidden" name="cargo" value="<?php echo $cargoID;?>">
                    <input type="hidden" name="idUsuario" value="<?php echo $idUsuario;?>">
                    <button type="submit" class="btn btn-block btn-warning btn-sm" style="color:white"><i class="fas fa-download"></i> Exportar</font></button>
 
                </form>
            </div>
            

            </form>
            <div class="col-sm">
            </div>
            </div>
            <?php 
                }else{
               
            ?>
                 <div class="row">
                    <div class="col-sm">
                        <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/cargos'"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
                    </div>
                    <div class="col-sm"></div>
                    <div class="col-sm"></div>
                    <div class="col-sm"></div>
                    <div class="col-sm"></div>
                </div>   
            <?php    
                }
            }
            
            if($root == 1){
            ?>
            <div class="row">
                <div class="col-sm">
                    <button type="button" class="btn btn-block btn-info btn-sm"><a href="plantillas"><font color="white"><i class="fas fa-plus-square"></i> Crear Plantilla</font></a></button>
                </div>
                <div class="col-sm">
                    <button type="button" class="btn btn-block btn-info btn-sm"><a href="crearEncabezadoLista"><font color="white"><i class="fas fa-newspaper"></i> Crear encabezado</font></a></button>
                </div>
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
                <h3 class="card-title"></h3>
               
            </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>N° Acta</th>
                      <th>Fecha</th>
                      <th>Nombre Acta</th>
                      <th>Elaborador</th>
                      <th>Proceso</th>
                      <th>Estado</th>
                      <th>Ver Más</th>
                      <th style="display:<?php echo $visibleE;?>;">Editar</th>
                      <th style="display:<?php echo $visibleD;?>;">Eliminar</th>
                      <!--<th style="display:<?php //echo $visibleD;?>;">Seguimiento</th>-->
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                     $consultaBuscar=$_POST['buscar'];
                   
                     $consultaBuscar3=$_POST['buscar3'];
                     $consultaBuscar4=$_POST['buscar4'];
                     
                     
                     $data = $mysqli->query("SELECT * FROM actas ORDER BY id DESC")or die(mysqli_error()); // WHERE finalizada = 1
                     
                     while($row = $data->fetch_assoc()){
                         
                         $idActa = $row['id'];
                         $permisoListaActa = FALSE;
                         $permisoEditar = FALSE;
                         $permisoSeguimiento = FALSE;
                         //echo "Permisos vista actas".$row['id'];
                         
                        //Quien elabora
                        $quienElabora = $row['quienElabora'];
                        $quienElaboraID = json_decode($row['quienElaboraID']);
                        if($quienElabora == "cargo"){
                            if(in_array($cargoID,$quienElaboraID)){
                                $permisoListaActa = TRUE;
                                $permisoEditar = TRUE;
                                $permisoSeguimiento = TRUE;
                            }
                        }
                        
                        if($quienElabora == "usuario"){
                            if(in_array($idUsuario,$quienElaboraID)){
                                $permisoListaActa = TRUE;
                                $permisoEditar = TRUE;
                                $permisoSeguimiento = TRUE;
                            }
                        }
                        
                        
                        //Quien aprueba
                        $apruebaActa = $row['aprobarActa'];// si / no
                        $quieAbrueba= $row['quienAprueba'];// usuario / cargo
                        $quienApruebaID = json_decode($row['quienApruebaId']);
                        
                        if($apruebaActa == "si"){
                            if($quieAbrueba == "cargo"){
                                if(in_array($cargoID,$quienApruebaID)){
                                    $permisoListaActa = TRUE;
                                    $permisoEditar = TRUE;
                                    $permisoSeguimiento = TRUE;
                                }
                            }
                            
                            if($quieAbrueba == "usuario"){
                                if(in_array($idUsuario,$quienApruebaID)){
                                    $permisoListaActa = TRUE;
                                    $permisoEditar = TRUE;
                                    $permisoSeguimiento = TRUE;
                                }
                            }
                        }
                        

                        //Quienes tiene compromisos
                        
                        $queryCompromisos = $mysqli->query("SELECT responsableCompromiso, responsableID, entregarA, entregarAID FROM `compromisos` WHERE idActa = '$idActa' AND estado != 'Aprobado'");
                        
                        while($datoCompromiso = $queryCompromisos->fetch_assoc()){
                            $responsableCompromiso = $datoCompromiso['responsableCompromiso']; 
                            $responsableID = json_decode($datoCompromiso['responsableID']);
                            $entregarA = $datoCompromiso['entregarA'];
                            $entregarAID = json_decode($datoCompromiso['entregarAID']);
                            
                            if($responsableCompromiso == "cargo"){
                                if(in_array($cargoID,$responsableID)){
                                    $permisoSeguimiento = TRUE;
                                }
                            }
                            
                            if($responsableCompromiso == "usuario"){
                                if(in_array($idUsuario,$responsableID)){
                                    $permisoSeguimiento = TRUE;
                                }
                            }
                            
                            if($entregarA == "cargo"){
                                if(in_array($cargoID,$entregarAID)){
                                    $permisoSeguimiento = TRUE;
                                }
                            }
                            
                            if($entregarA == "usuario"){
                                if(in_array($idUsuario,$entregarAID)){
                                    $permisoSeguimiento = TRUE;
                                }
                            }
                            
                            if($permisoSeguimiento == TRUE){
                                break;
                            }
                            
                        }
                        
                        //$datoCompromiso = $queryCompromisos->fetch_array(MYSQLI_ASSOC);         
                        
                        //Para quien es visible  //Si el acta es abierta a todo el publico debe dejar verla 
                        $permisoActa = $row['permisosActa'];  /// usuario, grupo o cargo
                        $publico = $row['publico'];  // si o no
                        $responsablesID = json_decode($row['responsablesActa']); 
                        
                        if($publico == "no" && $row['estado'] == 'Aprobado'){
                            if($permisoActa == "cargo"){
                                if(in_array($cargoID,$responsablesID)){
                                    $permisoListaActa = TRUE;
                                }
                            }
                            
                            if($permisoActa == "usuario"){
                                if(in_array($idUsuario,$responsablesID)){
                                    $permisoListaActa = TRUE;
                                }
                            }
                            
                            if($permisoActa == "grupo"){
                                //echo "GRUPO";
                                foreach($arrayGrupos as $idGrupo){
                                    if(in_array($idGrupo,$responsablesID)){
                                        $permisoListaActa = TRUE;
                                        if($permisoListaActa == TRUE){ break; }
                                    }
                                }
                                
                            }
                        }
                        
                        
                        if($permisoSeguimiento == TRUE){
                            if($row['estado'] == "Pendiente" || $row['estado'] == "Rechazado"){
                                $permisoSeguimiento = FALSE;
                            }
                            
                            if($row['estado'] == "Aprobado"){
                                $permisoSeguimiento = TRUE; 
                            }
                        }
                        
                        
                        
                        
                        
                        if($publico == "si"){
                            $permisoListaActa = TRUE;
                        }
                         
                         
                        if($permisoListaActa == FALSE){
                            continue;
                        }
                         
                        if($permisoEditar == FALSE){
                            $habilitaEditar = "disabled";
                        }else{
                            $habilitaEditar = "";     
                        }
                        
                        
                        if($permisoSeguimiento == FALSE){
                            $habilitarSeguimieto = "disabled";
                        }else{
                            $habilitarSeguimieto = "";
                        }
                         
                        $fechaOrginal = $row['fechaInicio'];
                        $fechaNueva = date('Y/m/d h:i A', strtotime($fechaOrginal));
                 
                    echo"<tr>";
                    
                     $id = $row['id'];
                    echo" <td>". $id ."</td>";
                    echo" <td style='text-align:justify;'>".$fechaNueva."</td>";
                    echo" <td style='text-align:justify;'>".$row['nombreActa']."</td>";
                    $quienElabora = $row['quienElabora'];
                    $quienElaboraID =  json_decode($row['quienElaboraID']);
                        //var_dump($quienCitaID);
                    $longitud = count($quienElaboraID);
                    echo "<td style='text-align:justify;'>";
                    if($quienElabora == 'usuario'){
                                    
                                    for($i=0; $i<$longitud; $i++){
                                        
                                        $nombreuser = $mysqli->query("SELECT nombres, apellidos FROM usuario WHERE id = '$quienElaboraID[$i]'");
                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo $columna['nombres']." ".$columna['apellidos'];echo"<br>";
                                     
                                    }
                                 
                                }else{
                                    
                                    for($i=0; $i<$longitud; $i++){
                                    $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$quienElaboraID[$i]'");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    echo $columna['nombreCargos'];echo"<br>";
                                    }
                                }
                    echo "</td>";            
                    
                    $proceso = $row['proceso'];
                    $queryProceso=$mysqli->query("SELECT * FROM procesos WHERE id='$proceso' ");
	                $rowDatos=$queryProceso->fetch_array(MYSQLI_ASSOC);
	                $nombreProceso=$rowDatos['nombre'];
                    echo "<td style='text-align:justify;'>" . $nombreProceso . "</td>";
                    echo" <td style='text-align:justify;'>".$row['estado']."</td>";
                    
                    
                     
                    if($row['actaCargada'] == 1){
                        echo"<form action='verActaC' method='post'>";
                        echo"<input type='hidden' name='idActa' value='$id'>";
                        echo"<td><button type='submit' class='btn btn-block btn-primary btn-sm'><i class='fas fa-eye'></i> Ver Más</button></td>";
                        echo"</form>";
                    }else{
                        echo"<form action='verActa' method='post'>";
                        echo"<input type='hidden' name='idActa' value='$id'>";
                        echo"<td><button type='submit' class='btn btn-block btn-primary btn-sm'><i class='fas fa-eye'></i> Ver Más</button></td>";
                        echo"</form>";
                    }
                    
                    if($row['actaCargada'] == 1){
                        
                        if($row['estado'] == 'Aprobado'){
                            echo" <td style='display:$visibleE;'><button disabled class='btn btn-block btn-success btn-sm' $habilitaEditar><i class='fas fa-edit'></i> Editar</button></td>";
                        }else{
                            echo"<form action='editarActaC' method='POST'>";
                            echo"<input type='hidden' name='idActa' value= '$id' >";
                            echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-success btn-sm' $habilitaEditar><i class='fas fa-edit'></i> Editar</button></td>";
                            echo"</form>";
                        }
                            
                        
                    }else{
                        if($row['estado'] == 'Aprobado'){
                            echo" <td style='display:$visibleE;'><button disabled class='btn btn-block btn-success btn-sm' $habilitaEditar><i class='fas fa-edit'></i> Editar</button></td>";
                        }else{
                            echo"<form action='editarActa' method='POST'>";
                            echo"<input type='hidden' name='idActa' value= '$id' >";
                            echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-success btn-sm' $habilitaEditar><i class='fas fa-edit'></i> Editar</button></td>";
                            echo"</form>";    
                        }
                    }
                    
                    /*
                     echo"<form action='controlador/actas/controller' method='POST'>";
                     echo"<input type='hidden' name='idActa' value= '$id' >";
                     echo" <td style='display:$visibleE;'><button type='submit' name='eliminarActa' class='btn btn-block btn-danger btn-sm' onclick=\"return ConfirmDelete()\" $habilitaEditar><i class='fas fa-edit'></i> Eliminar</button></td>";
                     echo"</form>";*/
                     /// validaci��n de script y funcion de eliminacion
                        ?>
                        <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $id;?>' >
                        <td style='display:<?php echo $visibleD;?>'><a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                        <script>
                            function funcionFormula<?php echo $contador2++;?>() {
                                /*alert("entre");*/
                              document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                            }
                       </script>
                        <?php
                        /// END
                     /*
                     echo"<form action='seguimientoActasVista' method='POST'>";
                     echo"<td><input type='hidden' name='idActa' value='$id'>";
                     echo"<button style='display:$visibleD;' type='submit' class='btn btn-block btn-primary btn-sm' $habilitarSeguimieto><i class='fas fa-eye'></i>Seguimiento</button></td>";
                     echo"</form>";
                    echo"</tr>";
                    */
                    }
                    ?>
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
                             <!-- formulario para eliminar por el id -->
                            <form action='controlador/actas/controller' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormula" name='idActa' readonly>
                              <button type="submit" name='eliminarActa' class="btn btn-outline-light">Si</button>
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
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<?php
/// validaciones de alertas
$validacionExiste=$_POST['validacionExiste'];
$validacionAgregar=$_POST['validacionAgregar'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];
?>
<script type="text/javascript">
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
    
    
    <?php
    if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El nivel o la prioridad ya existe.'
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