<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'centroCostos'; //Se cambia el nombre del formulario

require_once 'permisosPlataforma.php';

//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
    <title>Centro de Costos</title>
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
            <h1>Centro de Costos</h1>
            <h6>Gestione los centros de costos definidos en su compañía<!--Gestione los centros que hacen parte de su compañía-->.</h6><br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Centro de Costos</li>
            </ol>
          </div>
        </div>
        <div>
            <?php
                if($visibleI == FALSE){
            ?>
            <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarCentroCostos"><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>
            </div>
        <!--    <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="#"><font color="white"><i class="fas fa-user-plus"></i> Agregar Nivel Cargo</font></a></button>
            </div> -->
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-warning btn-sm"><a href="exportacion/centroCostos"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="importacion2/importar-centroCostos/Centro_de_costos.xlsx" onClick="javascript:document["ver-form"].submit();"><font color="white"><i class="fas fa-cloud-download-alt"></i> Descargar Plantilla</font></a></button>
            </div>

            <div class="col-sm">
                <form action="importacion2/importar-centroCostos/index" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
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
            </div>
            <?php }else{?>
            <div class="row">
                <div class="col-sm">
                <button type="button" class="btn btn-block btn-warning btn-sm"><a href="exportacion/centroCostos"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
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
              <div class="card-body table-responsive p-0" style="height: 800px;">
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>Código</th>
                      <th>Prefijo</th>
                      <th>Centro de costo</th>
                      <th>Cargo del Dueño del Centro de Costos</th>
                      <th>Centro de Trabajo</th>
                      <?php
                      /// validamos, si existen usuarios, debe mostrar este campo, pero si no, este campo no aparece
                      $recorridoUsuarios=$mysqli->query("SELECT count(*) FROM usuario ");
                      $respuestaRecorridoUsuarios=$recorridoUsuarios->fetch_array(MYSQLI_ASSOC);
                      //if($respuestaRecorridoUsuarios['count(*)'] > '0'){
                      ?>
                      <th>Persona encargada</th>
                      <?php
                      /*}else{ }*/
                      ?>
                     <!-- <th>Ver más</th>-->
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
                     $consultaBuscar5=$_POST['buscar5'];
                     
                     if($consultaBuscar != NULL || $consultaBuscar2 != NULL || $consultaBuscar3 != NULL || $consultaBuscar4 != NULL || $consultaBuscar5 != NULL){
                        
                        if($consultaBuscar4 != NULL){
                         ///// se trae la consulta de la 3
                         $queryJefeInmediatoConsulta=$mysqli->query("SELECT * FROM cargos WHERE nombreCargos LIKE  '%$consultaBuscar4%' ");
    	                 $rowConsulta=$queryJefeInmediatoConsulta->fetch_array(MYSQLI_ASSOC);
    	                 $nombreJefeInmediato=$rowConsulta['id_cargos'];
    	                 ///////// fin
                        }
                        if($consultaBuscar5 != NULL){
                         ///// se trae la consulta de la 3
                         $queryConsultaCentroTrabajo=$mysqli->query("SELECT * FROM centrodetrabajo WHERE nombreCentrodeTrabajo LIKE  '%$consultaBuscar5%' ");
    	                 $rowConsultaCentroT=$queryConsultaCentroTrabajo->fetch_array(MYSQLI_ASSOC);
    	                 $nombreCentrodeTrabajo=$rowConsultaCentroT['id_centrodetrabajo'];
    	                 ///////// fin
                        }
                        
                         $data = $mysqli->query("SELECT * FROM centroCostos WHERE codigo LIKE '%$consultaBuscar%' AND prefijo LIKE '%$consultaBuscar2%' AND nombre LIKE '%$consultaBuscar3%'
                         AND idCargo LIKE '%$nombreJefeInmediato%' AND idCentroTrabajo LIKE '%$nombreCentrodeTrabajo%' ORDER BY codigo ASC")or die(mysqli_error());
                     }else{
                         $data = $mysqli->query("SELECT * FROM centroCostos ORDER BY codigo ASC")or die(mysqli_error());
                     }
                     while($row = $data->fetch_assoc()){
                 
                    echo"<tr>";
                    $id = $row['id'];
                    echo" <td style='text-align: justify;'>".$row['codigo']."</td>";
                    echo" <td style='text-align: justify;'>".$row['prefijo']."</td>";
                    echo" <td style='text-align: justify;'>".$row['nombre']."</td>";
                    
                    $idCargo = $row['idCargo'];
                    $idCtrabajo = $row['idCentroTrabajo'];
                    $cargo = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$idCargo'");
                    $fila = $cargo->fetch_array(MYSQLI_ASSOC);
                    $fila['nombreCargos'];
                    if($fila['nombreCargos'] != NULL){
            	        echo "<td style='text-align: justify;'>" . $fila['nombreCargos'] . "</td>";
            	    }else{
            	        echo "<td style='text-align: justify;'><b>" .  'No aplica' . "</b></td>";
            	    }
            	    $cTrabajo = $mysqli->query("SELECT * FROM centrodetrabajo WHERE id_centrodetrabajo = '$idCtrabajo'");
                    $fila2 = $cTrabajo->fetch_array(MYSQLI_ASSOC);
                    $fila2['nombreCentrodeTrabajo'];
                    if($fila2['nombreCentrodeTrabajo'] != NULL){
            	        echo "<td style='text-align: justify;'>" . $fila2['nombreCentrodeTrabajo'] . "</td>";
            	    }else{
            	        echo "<td style='text-align: justify;'><b>" .  'No aplica' . "</b></td>";
            	    }
            	   
                      /// validamos, si existen usuarios, debe mostrar este campo, pero si no, este campo no aparece
                      $recorridoUsuarios=$mysqli->query("SELECT count(*) FROM usuario ");
                      $respuestaRecorridoUsuarios=$recorridoUsuarios->fetch_array(MYSQLI_ASSOC);
                      //if($respuestaRecorridoUsuarios['count(*)'] > '0'){
                    
            	    $personaUsuario = $mysqli->query("SELECT * FROM usuario WHERE id = '".$row['persona']."'");
                    $filaPersona = $personaUsuario->fetch_array(MYSQLI_ASSOC);
                    $nombrePersonaResponsable=$filaPersona['nombres'].' '.$filaPersona['apellidos'];
            	    echo" <td style='text-align: justify;'>".$nombrePersonaResponsable."</td>";
                      /*}else{
                           
                      }*/
                   /* echo"<form action='centoCostosVer' method='POST'>";
                     echo"<input type='hidden' name='idGrupo' value='$id'>";
                     echo"<td><button type='submit' class='btn btn-block btn-primary btn-sm'><i class='fas fa-eye'></i> Ver más</button></td>";
                     echo"</form>";
                */  echo"<form action='centroCostosEditar' method='POST'>";
                    echo"<input type='hidden' name='idCentro' value= '$id' >";
                    echo" <td style='display:$visibleE;'><button type='submit'class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                    echo"</form>";
                    /*
                    echo"<form action='controlador/centroCostos/controllerCentroCostos' method='POST'>";
                    echo"<input type='hidden' name='idCentro' value= '$id' >";
                    echo" <td style='display:$visibleD;'><button onclick='return ConfirmDelete()' type='submit' name='eliminarCC' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                    echo"</form>";*/
                    /// validación de script y funcion de eliminacion
                    /*
                        ?>
                        <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $id;?>' >
                        <td style='display:<?php echo $visibleD;?>'><a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                        <script>
                            function funcionFormula<?php echo $contador2++;?>() {
                              document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                            }
                       </script>
                        <?php
                        */
                    
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
                                                                                    $recorridoCentroTrabajo=$mysqli->query("SELECT * FROM presupuesto ");
                                                                                    $stroingCentroDeTrabajoConteo='0';
                                                                                    while($extraerRecorridoCentroTrabajo=$recorridoCentroTrabajo->fetch_array()){
                                                                                        $buscarCargos=$extraerRecorridoCentroTrabajo['responsable'];
                                                                                        $buscarCargos=json_decode($buscarCargos);
                                                                                        for($i=0; $i<count($buscarCargos); $i++){
                                                                                            if($buscarCargos[$i] == $id){
                                                                                                 $stroingCentroDeTrabajoConteo++;
                                                                                            }
                                                                                        }
                                                                                    } 
                                                                                    
                                                                                    if($stroingCentroDeTrabajoConteo == '0'){
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
                                                                                                    
                                                                                                    // buscamos donde se encuentra anclado este cargo en usuarios
                                                                                                    $recorridoUsuarios=$mysqli->query("SELECT * FROM presupuesto ");
                                                                                                    $stroingUsuarios='';
                                                                                                    while($extraerRecorridoUsuarios=$recorridoUsuarios->fetch_array()){
                                                                                                        $buscarCargosUsuarios=$extraerRecorridoUsuarios['responsable'];
                                                                                                            if($buscarCargosUsuarios == $row['persona']){
                                                                                                               $stroingUsuarios.='-'.$extraerRecorridoUsuarios['nombre'].'<br>';
                                                                                                            }
                                                                                                    }
                                                                                                    if($stroingUsuarios != NULL){ 
                                                                                                        echo '<br>'.$enviarMensajeUsuario='El responsable del centro de costo se encuentra asociado al presupuesto:<br>'.$stroingUsuarios;
                                                                                                    }
                                                                                                    ?>
                                                                                      </div>
                                                                                    </div>
                                                                                </div>
                                                                                <form action='controlador/centroCostos/controllerCentroCostos' method='POST'>
                                                                                    <input type="hidden" value="<?php echo $row['id'];?>" id="capturarFormula" name='idCentro' readonly>
                                                                                    <div class="modal-footer justify-content-between">
                                                                                      <!--<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>-->
                                                                                      <button type="submit" name='eliminarCC' class="btn btn-outline-light">Si</button>
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
                            
                            <form action='controlador/centroCostos/controllerCentroCostos' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormula" name='idCentro' readonly>
                              <button type="submit" name='eliminarCC' class="btn btn-outline-light">Si</button>
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
$validacionExisteB=$_POST['validacionExisteB'];
$validacionExisteC=$_POST['validacionExisteC'];
$validacionExisteD=$_POST['validacionExisteD'];
$validacionAgregar=$_POST['validacionAgregar'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];
$validacionExisteNombre=$_POST['validacionExisteNombre'];

/// validaciones imprtacion
$validacionExisteImportacion=$_POST['validacionExisteImportacion'];
$validacionExisteImportacionB=$_POST['validacionExisteImportacionB'];
echo 'Prefijo '.$validacionExisteImportacionC=$_POST['validacionExisteImportacionC'];
$validacionExisteImportacionC1=$_POST['validacionExisteImportacionC1'];
$validacionExisteImportacionC2=$_POST['validacionExisteImportacionC2'];
$validacionExisteImportacionD=$_POST['validacionExisteImportacionD'];
$validacionExisteImportacionPrefijo=$_POST['validacionExisteImportacionPrefijo'];

$validacionExisteImportacionNumerico=$_POST['validacionExisteImportacionNumerico'];
/// END

//// validación de campo vacio, identificando la columna que contiene el campo vacio
$validacionExisteImportacionVacio=$_POST['validacionExisteImportacionVacio'];
$mensajeEnviarCampoVacio=" 'Algunos campos están vacios ".$_POST['mensajeEnviarCampoVacio']." ' ";
/// END

// campo repetido en el documento centro de costo
$validacionNombreRepiteDocumento=$_POST['validacionNombreRepiteDocumento'];
?>
<script type="text/javascript">
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 9000
    });
    
    
    <?php   
    if($validacionNombreRepiteDocumento == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: 'Algunos centro de trabajo están repetidos en el documento.'
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
     if($validacionExisteNombre == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El centro de costos ya existe: <br><?php echo $_POST['enviarNombreExistente'];?>'
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
     if($validacionExisteImportacionNumerico == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El responsable no existe: <?php echo $_POST['validacionExisteImportacionNumericoMensaje'];?>.'
        })
    <?php
    }
     if($validacionExisteImportacion == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Está intentando subir un archivo diferente.'
        })
    <?php
    }
    if($validacionExisteImportacionB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos códigos están repetidos en el documento.'
        })
    <?php
    }
    if($validacionExisteImportacionC == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos prefijos están repetidos en el documento.'
        })
    <?php
    }
    if($validacionExisteImportacionPrefijo == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos prefijos están vacios en el documento.'
        })
    <?php
    }
     if($validacionExisteImportacionC1 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El cargo del dueño del centro de costos no existe: <?php echo $_POST['validacionExisteImportacionC1Mensaje'];?>.'
        })
    <?php
    }
     if($validacionExisteImportacionC2 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos centros de trabajo no existe: <?php echo $_POST['validacionExisteImportacionC2Mensaje'];?>.'
        })
    <?php
    }
     if($_POST['validacionExisteImportacionC22'] != NULL){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos centros de trabajo contiene caracteres no permitidos " : <?php echo $_POST['validacionExisteImportacionC2Mensaje2'];?>.'
        })
    <?php
    }
    if($validacionExisteImportacionD == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Hay campos repetidos o inexistentes.'
        })
    <?php
    }
    
    
    if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El código o prefijo ya existe.'
        })
    <?php
    }
    if($validacionExisteB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El Centro de trabajo para ese código ya existe.'
        })
    <?php
    }
    if($validacionExisteC == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El código del centro de costos ya existe: <br> <?php echo $_POST['enviarcodigoExistente'];?>'
        })
    <?php
    }
    if($validacionExisteD == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El prefijo del centro de costos ya existe: <br> <?php echo $_POST['enviarprefijoExistente'];?>'
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
            title: 'El <?php echo $_POST['titulo'];?> contiene un (ENTER) no permitido en la celda <?php echo $_POST['alertaEnter'];?> '
        })
    
    <?php
    }
    
    if($_POST['mensajeRedireccionPersona'] != NULL){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Existen caracteres especiales en la celda: <?php echo $_POST['mensajeEnviarPersona']?>.'
        })
    <?php
    }
    
    if($_POST['enviarMensajeCaracter'] != NULL){
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaCodigo'){
        $mensajeCaracter='El código contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterCodigo'){
        $mensajeCaracter='El código contiene caracteres especiales no permitidos : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaPrefijo'){
        $mensajeCaracter='El prefijo contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterPrefijo'){
        $mensajeCaracter='El prefijo contiene caracteres especiales no permitidos : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaNombre'){
        $mensajeCaracter='El centro de costo contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterNombre'){
        $mensajeCaracter='El centro de costo contiene caracteres especiales no permitidos : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaCargo'){
        $mensajeCaracter='El cargo del dueño del centro de costo contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterCargo'){
        $mensajeCaracter='El cargo del dueño del centro de costo contiene caracteres especiales no permitidos : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaCt'){
        $mensajeCaracter='El centro de trabajo contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterCt'){
        $mensajeCaracter='El centro de trabajo contiene caracteres especiales no permitidos : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaResponsable'){
        $mensajeCaracter='El responsable contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterResponsable'){
        $mensajeCaracter='El responsable contiene caracteres especiales no permitidos : '.$_POST['enviarMensajeCaracter'];
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