<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'cargos'; //Se cambia el nombre del formulario
require_once 'permisosPlataforma.php';
/*
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
}*/
//////////////////////PERMISOS////////////////////////

?>

<!DOCTYPE html>
<html>
    <title>Cargos</title>
<head><meta charset="gb18030">
  
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
            <h1>Cargos</h1>
            <h6>Gestione los cargos con los que cuenta su compañía.</h6><br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Cargos</li>
            </ol>
          </div>
        </div>
        <div>
            <?php
                if($visibleI == FALSE){
            ?>
            <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarCargos"><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarCargoNivel"><font color="white"><i class="fas fa-user-plus"></i> Agregar Nivel Cargo</font></a></button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-warning btn-sm"><a href="exportacion/cargos"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="importacion/importar-cargos/plantilla_cargos.xlsx" onClick="javascript:document["ver-form"].submit();"><font color="white"><i class="fas fa-cloud-download-alt"></i> Descargar Plantilla</font></a></button>
            </div>

            <div class="col-sm">
                 <form action="importacion2/importar-cargos/index" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
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
             </form>
            </div>
            
           
            </div>
            <?php }else{?>
            <div class="row">
                <div class="col-sm">
                    <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/cargos'"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
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
                <h3 class="card-title"></h3>
                
                
              </div>
              
               
              
              
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="">
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>Cargos</th>
                      <th>Descripci&oacute;n</th>
                      <th>Jefe inmediato</th>
                      <th>Nivel cargo</th>
                      <th style="display:<?php echo$visibleE;?>;">Editar</th>
                      <th style="display:<?php echo$visibleD;?>;">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                     $consultaBuscar=$_POST['buscar'];
                     $consultaBuscar2=$_POST['buscar2'];
                     $consultaBuscar3=$_POST['buscar3'];
                     $consultaBuscar4=$_POST['buscar4'];
                     
                    
	                 
                     if($consultaBuscar != NULL || $consultaBuscar2 != NULL || $consultaBuscar3 != NULL || $consultaBuscar4 != NULL){
                         
                         if($consultaBuscar3 != NULL){
                         ///// se trae la consulta de la 3
                         $queryJefeInmediatoConsulta=$mysqli->query("SELECT * FROM cargos WHERE nombreCargos LIKE  '%$consultaBuscar3%' ");
    	                 $rowConsulta=$queryJefeInmediatoConsulta->fetch_array(MYSQLI_ASSOC);
    	                 $nombreJefeInmediato=$rowConsulta['id_cargos'];
    	                 ///////// fin
                         }
                         
    	                 ///// se trae la consulta de la 4
    	                 if($consultaBuscar4 != NULL){
                             $queryConsultaNivel=$mysqli->query("SELECT * FROM nivelcargo WHERE nivelCargo LIKE '%$consultaBuscar4%' ");
        	                 $rowNivel=$queryConsultaNivel->fetch_array(MYSQLI_ASSOC);
        	                 $traeConsultaNivel=$rowNivel['id'];
                         }
    	                 ///////// fin
    	                 
                        $data = $mysqli->query("SELECT * FROM cargos WHERE nombreCargos LIKE '%$consultaBuscar%' AND descripcionCargos LIKE '%$consultaBuscar2%' AND jefeInmediatoCargos LIKE '%$nombreJefeInmediato%' AND nivelCargo LIKE '%$traeConsultaNivel%'  ORDER BY nombreCargos ASC")or die(mysqli_error());
                        
                     }else{
                        $data = $mysqli->query("SELECT * FROM cargos ORDER BY nombreCargos ASC")or die(mysqli_error()); 
                     }
                     while($row = $data->fetch_assoc()){
                 
                    echo"<tr>";
                    $id = $row['id_cargos'];
                    echo" <td style='text-align:justify;'>".$row['nombreCargos']."</td>";
                    echo" <td style='text-align:justify;'>".$row['descripcionCargos']."</td>";
                     $idJefeInmediato=$row['jefeInmediatoCargos'];
                     $queryJefeInmediato=$mysqli->query("SELECT * FROM cargos WHERE id_cargos='$idJefeInmediato' ");
	                 $rowDatos=$queryJefeInmediato->fetch_array(MYSQLI_ASSOC);
	                 $nombreJefeInmediato=$rowDatos['nombreCargos'];
                    if($nombreJefeInmediato != NULL){
            		echo "<td style='text-align:justify;'>" . $nombreJefeInmediato . "</td>";
            		}else{
            		echo "<td style='text-align:justify;'><b>" . 'N/A' . "</b></td>";    
            		}
                    $idNivelCargo=$row['nivelCargo'];
            	    $queryCargo=$mysqli->query("SELECT * FROM nivelcargo WHERE id='$idNivelCargo' ");
            	    $rowDatos=$queryCargo->fetch_array(MYSQLI_ASSOC);
            	    $NombreCargo=$rowDatos['nivelCargo'];
            	    
            	    if($NombreCargo != NULL){
            	        echo "<td style='text-align:justify;'>" . $NombreCargo . "</td>";
            	    }else{
            	        echo "<td style='text-align:justify;'><b>" .  'N/A' . "</b></td>";
            	    }
                    echo"<form action='cargosEditar' method='POST'>";
                    echo"<input type='hidden' name='idCargos' value= '$id' >";
                    echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                    echo"</form>";
                   
                    /// validación de script y funcion de eliminacion
                        ?>
                        <td style='text-align:justify;display:<?php echo$visibleD;?>'>
                    
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
                                                                                    /// si existe datos muestra el scroll, caso contrario anula el scroll
                                                                                    $recorridoCentroTrabajo=$mysqli->query("SELECT * FROM centrodetrabajo ");
                                                                                    $stroingCentroDeTrabajoConteo='0';
                                                                                    while($extraerRecorridoCentroTrabajo=$recorridoCentroTrabajo->fetch_array()){
                                                                                        $buscarCargos=$extraerRecorridoCentroTrabajo['cargosAsociadoss'];
                                                                                        $buscarCargos=json_decode($buscarCargos);
                                                                                        for($i=0; $i<count($buscarCargos); $i++){
                                                                                            if($buscarCargos[$i] == $id){
                                                                                                 $stroingCentroDeTrabajoConteo++;
                                                                                            }
                                                                                        }
                                                                                    } 
                                                                                    
                                                                                    
                                                                                    // buscamos donde se encuentra anclado este cargo en centro de costo
                                                                                    $recorridoCentroDeCosto=$mysqli->query("SELECT * FROM centroCostos ");
                                                                                    $stroingCentroDeCostoConteo='0';
                                                                                    while($extraerRecorridoCentroDeCosto=$recorridoCentroDeCosto->fetch_array()){
                                                                                        $buscarCargosCosto=$extraerRecorridoCentroDeCosto['idCargo'];
                                                                                        if($buscarCargosCosto == $id){
                                                                                            $stroingCentroDeCostoConteo++;
                                                                                        }
                                                                                    }
                                                                                    
                                                                                    
                                                                                    // buscamos donde se encuentra anclado este cargo en usuarios
                                                                                    $recorridoUsuarios=$mysqli->query("SELECT * FROM usuario ");
                                                                                    $stroingUsuariosConteo='0';
                                                                                    while($extraerRecorridoUsuarios=$recorridoUsuarios->fetch_array()){
                                                                                    $buscarCargosUsuarios=$extraerRecorridoUsuarios['cargo'];
                                                                                        if($buscarCargosUsuarios == $id){
                                                                                           $stroingUsuariosConteo++;
                                                                                        }
                                                                                    }
                                                                                    
                                                                                    if($stroingCentroDeTrabajoConteo == '0' && $stroingCentroDeCostoConteo == '0' && $stroingUsuariosConteo == '0'){
                                                                                         $stykeScroll='';
                                                                                    }else{
                                                                                         $stykeScroll='style="width:100%;height:100px;overflow-y:scroll;"';
                                                                                    }
                                                                                     
                                                                                      ?>
                                                                                      
                                                                                      
                                                                                      <div id="container" <?php echo $stykeScroll;?> >
                                                                                      <style>
                                                                                        .container_slider{
                                                                                          color: black;  
                                                                                          margin: auto;
                                                                                          background-color: white;
                                                                                          width: 100%; /*800px*/
                                                                                          padding: 30px;
                                                                                        }
                                                                                        
                                                                                        ul, li {
                                                                                            padding: 0;
                                                                                            margin: 0;
                                                                                            list-style: none;
                                                                                        }
                                                                                        
                                                                                        ul.slider{
                                                                                          position: relative;
                                                                                          width: 100%; /*800px*/
                                                                                          height: 300px;
                                                                                        }
                                                                                        
                                                                                        ul.slider li {
                                                                                            position: absolute;
                                                                                            left: 0px;
                                                                                            top: 0px;
                                                                                            opacity: 0;
                                                                                            width: inherit;
                                                                                            height: inherit;
                                                                                            transition: opacity .5s;
                                                                                            background:#fff;
                                                                                        }
                                                                                        
                                                                                        ul.slider li img{
                                                                                          width: 100%;
                                                                                          height: 300px;
                                                                                          object-fit: cover;
                                                                                        }
                                                                                        
                                                                                        ul.slider li:first-child {
                                                                                            opacity: 1; /*Mostramos el primer <li>*/
                                                                                        }
                                                                                        
                                                                                        ul.slider li:target {
                                                                                            opacity: 1; /*Mostramos el <li> del enlace que pulsemos*/
                                                                                        }
                                                                                        
                                                                                        .menu_slider{
                                                                                          text-align: center;
                                                                                          margin: 20px;
                                                                                        }
                                                                                        
                                                                                        .menu_slider li{
                                                                                          display: inline-block;
                                                                                          text-align: center;
                                                                                        }
                                                                                        
                                                                                        .menu_slider li a{
                                                                                          display: inline-block;
                                                                                          color: black;
                                                                                          text-decoration: none;
                                                                                          background-color: white;
                                                                                          padding: 10px;
                                                                                          width: 20px;
                                                                                          height: 20px;
                                                                                          font-size: 20px;
                                                                                          border-radius: 100%;
                                                                                        }
                                                                                        </style>
                                                                                                <?php
                                                                                                   // buscamos donde se encuentra anclado este cargo al centro de trabajo
                                                                                                    $recorridoCentroTrabajo=$mysqli->query("SELECT * FROM centrodetrabajo ");
                                                                                                    $stroingCentroDeTrabajo='';
                                                                                                    while($extraerRecorridoCentroTrabajo=$recorridoCentroTrabajo->fetch_array()){
                                                                                                        $buscarCargos=$extraerRecorridoCentroTrabajo['cargosAsociadoss'];
                                                                                                        $buscarCargos=json_decode($buscarCargos);
                                                                                                        for($i=0; $i<count($buscarCargos); $i++){
                                                                                                            if($buscarCargos[$i] == $id){
                                                                                                                 $stroingCentroDeTrabajo.='-'.$extraerRecorridoCentroTrabajo['nombreCentrodeTrabajo'].'<br>';
                                                                                                            }
                                                                                                        }
                                                                                                    }
                                                                                                    if($stroingCentroDeTrabajo != NULL){
                                                                                                        echo $enviarMensajeCentroTrabajo='El cargo se encuentra asociado con los centro de trabajo:<br>'.$stroingCentroDeTrabajo;
                                                                                                    }
                                                                                                    
                                                                                                    
                                                                                                    // buscamos donde se encuentra anclado este cargo en centro de costo
                                                                                                    $recorridoCentroDeCosto=$mysqli->query("SELECT * FROM centroCostos ");
                                                                                                    $stroingCentroDeCosto='';
                                                                                                    while($extraerRecorridoCentroDeCosto=$recorridoCentroDeCosto->fetch_array()){
                                                                                                        $buscarCargosCosto=$extraerRecorridoCentroDeCosto['idCargo'];
                                                                                                         if($buscarCargosCosto == $id){ 
                                                                                                               $stroingCentroDeCosto.='-'.$extraerRecorridoCentroDeCosto['nombre'].'<br>';
                                                                                                            }
                                                                                                    }
                                                                                                    if($stroingCentroDeCosto != NULL){  
                                                                                                        echo '<br>El cargo se encuentra asociado con los centro de costo:<br>'.$stroingCentroDeCosto;
                                                                                                        
                                                                                                    }
                                                                                                    
                                                                                                    // buscamos donde se encuentra anclado este cargo en usuarios
                                                                                                    $recorridoUsuarios=$mysqli->query("SELECT * FROM usuario ");
                                                                                                    $stroingUsuarios='';
                                                                                                    while($extraerRecorridoUsuarios=$recorridoUsuarios->fetch_array()){
                                                                                                        $buscarCargosUsuarios=$extraerRecorridoUsuarios['cargo'];
                                                                                                            if($buscarCargosUsuarios == $id){
                                                                                                               $stroingUsuarios.='-'.$extraerRecorridoUsuarios['nombres'].' '.$extraerRecorridoUsuarios['apellidos'].'<br>';
                                                                                                            }
                                                                                                    }
                                                                                                    if($stroingUsuarios != NULL){ 
                                                                                                        echo '<br>'.$enviarMensajeUsuario='El cargo se encuentra asociado a los usuarios:<br>'.$stroingUsuarios;
                                                                                                    }
                                                                                                    ?>
                                                                                      </div>
                                                                                    </div>
                                                                                </div>
                                                                                <form action='controlador/cargos/controladorCargos' method='POST'>
                                                                                    <input type="hidden" value="<?php echo $row['id_cargos'];?>" name='idCargos' readonly>
                                                                                    <div class="modal-footer justify-content-between">
                                                                                      <!--<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>-->
                                                                                      <button type="submit" name='EliminarCargos' class="btn btn-outline-light">Si</button>
                                                                                      <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                                                                                    </div>
                                                                                </form>
                                                                              </div>
                                                                            </div>
                                                                          </div>
                            
                            
                            
                            <!--
                            <a onclick='funcionFormula<?php //echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a>
                            -->
                        </td>
                        
                        <?php
                        /// END
                    
                    echo"</tr>";
                    
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
                             
                            <div class="modal-footer justify-content-between">
                              
                              <button type="submit" name='EliminarCargos' class="btn btn-outline-light">Si</button>
                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                            </div>
                             </form>
                            
                          </div>
                        </div>
                    </div>
                    -->
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

<!-- para mostrar el archivo seleccionado en el file -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<!-- END -->
<!-- archivos para el filtro de busqueda y lista de informaci��n -->

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

//// validaciones de importación
$validacionAgregarA=$_POST['validacionAgregarA'];
$validacionExisteImportacionAA=$_POST['validacionExisteImportacionAA'];
$validacionExisteImportacionA=$_POST['validacionExisteImportacionA'];
$validacionExisteImportacionB=$_POST['validacionExisteImportacionB'];
$validacionExisteImportacionC=$_POST['validacionExisteImportacionC'];
$validacionExisteImportacionD=$_POST['validacionExisteImportacionD'];
$validacionExisteImportacionE=$_POST['validacionExisteImportacionE'];
$validacionExisteImportacionVacio=$_POST['validacionExisteImportacionVacio'];
//// END

//// validación de campo vacio, identificando la columna que contiene el campo vacio
$validacionExisteImportacionVacio=$_POST['validacionExisteImportacionVacio'];
$mensajeEnviarCampoVacio=" 'Algunos campos están vacios ".$_POST['mensajeEnviarCampoVacio']." ' ";
/// END
?>
<script type="text/javascript">
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      <?php
       if($validacionExisteImportacionD != NULL){
      ?>
      timer: 9000
      <?php
       }else{
      ?>
      timer: 9000
      <?php
       }
      ?>
    });
    
    
    <?php
     if($validacionExisteImportacionVacio == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: <?php echo $mensajeEnviarCampoVacio;?>
        })
    <?php
    } 
    if($validacionAgregarA == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: 'Registro agregado.'
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
    if($validacionExisteImportacionAA == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Está intentando subir un archivo diferente.'
        })
    <?php
    }
    if($validacionExisteImportacionA == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos cargos están repetidos en el documento.'
        })
    <?php
    }
    if($validacionExisteImportacionB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos cargos ya existen:<br> <?php echo $_POST['enviarCargoExistenteBDRegistro'];?>' //están repetidos
        })
    <?php
    }
    if($validacionExisteImportacionC != NULL){ 
    ?> 
        Toast.fire({
            type: 'warning',
            title: ' Algunos de los jefes inmediatos no existen: <br> <?php echo $_POST['EnviarvalidacionExisteImportacionC'];?> ' //están repetidos o
        })
    <?php
    }
    
    if($validacionExisteImportacionD != NULL){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos de los niveles de cargo no existen: <?php echo $validacionExisteImportacionD;?>.' //están repetidos o
        })
    <?php
    }
    if($validacionExisteImportacionE == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos cargos están repetidos en el documento.' //Algunos elementos no existen o están repetidos
        })
    <?php
    }
    
    if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El cargo ya existe.'
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
        $mensajeCaracter='El cargo contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterNombre'){
        $mensajeCaracter='El cargo contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaDescripcion'){
        $mensajeCaracter='La descripción contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterDescripcion'){
        $mensajeCaracter='La descripción contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaJefeInmediato'){
        $mensajeCaracter='El jefe inmediato contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterJefeInmediato'){
        $mensajeCaracter='El jefe inmediato contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaNivelCargo'){
        $mensajeCaracter='El nivel cargo contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterNivelCargo'){
        $mensajeCaracter='El nivel cargo contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
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