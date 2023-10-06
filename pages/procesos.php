<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'procesos'; //Se cambia el nombre del formulario
require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
    <title>Procesos</title>
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
            <h1>Procesos</h1>
            <h6>Gestione los Procesos definidos en su compañía.</h6><br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Procesos</li>
            </ol>
          </div>
        </div>
        <div>
            <?php
                if($visibleI == FALSE){
            ?>
            <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarProceso"><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="macroproceso"><font color="white"><i class="fas fa-user-plus"></i> Agregar Macroproceso</font></a></button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/procesos'"><font color="white"><i class="fas fa-download"></i> Exportar</font></button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="importacion/importar-procesos/proceso.xlsx" onClick="javascript:document["ver-form"].submit();"><font color="white"><i class="fas fa-cloud-download-alt"></i> Descargar Plantilla</font></a></button>
            </div>

            <div class="col-sm">
                <form action="importacion2/importar-procesos/index" method="post" enctype="multipart/form-data">
                    <div class="custom-file">
                        <input type="file" name="file" accept=".xls,.xlsx" multiple="" id="exampleInputFile" accept=".xls,.xlsx" required>
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
                        <label class="custom-file-label" for="exampleInputFile">Importar archivo</label>
                    </div>
                
            </div>
            <div class="col-sm">
                <button type="submit" class="btn btn-block btn-info btn-sm" name="import"><font color="white"><i class="fas fa-file-upload"></i> Importar</font></button>
            </div>
            </form>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-danger btn-sm"><a href="procesosEliminado"><font color="white"><i class="fas fa-list"></i> Procesos eliminados</font></a></button>
            </div>
            </div>
            <?php }else{?>
            <div class="row">
                <div class="col-sm">
                <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/procesos'"><font color="white"><i class="fas fa-download"></i> Exportar</font></button>
                </div>
                <div class="col-sm">
                <button type="button" class="btn btn-block btn-danger btn-sm"><a href="procesosEliminado"><font color="white"><i class="fas fa-list"></i> Procesos eliminados</font></a></button>
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
              <div class="card-body table-responsive p-0" style="height: 800px;">
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>Proceso</th>
                      <th>Descripci&oacute;n</th>
                      <th>Dueño Proceso</th>
                      <th>Prefijo</th>
                      <th>Macroproceso</th>
                      <th style="display:<?php echo$visibleE;?>;">Editar</th>
                      <th style="display:<?php echo$visibleD;?>;">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     /*llamado a la base de datos y consulta para traer los datos a mostrar en la tabla*/
                    require 'conexion/bd.php';
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $data = $mysqli->query("SELECT * FROM procesos WHERE estado IS NULL ORDER BY nombre ASC")or die(mysqli_error());
                    while($row = $data->fetch_assoc()){
                 
                    echo"<tr>";
                    echo" <td style='text-align:justify;'>".$row['nombre']."</td>";
                    echo" <td style='text-align:justify;'>".$row['descripcion']."</td>";
                    
                    if($row['importacion'] == '1'){    
                        $array = json_decode ($row['duenoProceso']);
                        //var_dump($array);
                        $longitud = count($array);
 
                        //Recorro todos los elementos
                    echo"<td style='text-align:justify;'>";
                        for($i=0; $i<$longitud; $i++){
                            //saco el valor de cada elemento
                            $queryNombres = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$array[$i]'");
                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                            
                        	echo "*".$nombres['nombreCargos']."<br>";
                        }
                    echo "</td>";
                    }else{    
                        $array = json_decode ($row['duenoProceso']);
                        //var_dump($array);
                        $longitud = count($array);
 
                        //Recorro todos los elementos
                    echo"<td style='text-align:justify;'>";
                        for($i=0; $i<$longitud; $i++){
                            //saco el valor de cada elemento
                            $queryNombres = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$array[$i]'");
                            $nombres = $queryNombres->fetch_array(MYSQLI_ASSOC); 
                            
                        	echo "*".$nombres['nombreCargos']."<br>";
                        }
                    echo "</td>";
                    }
                    echo" <td>".$row['prefijo']."</td>";
                    
                    $idMacroproceso=$row['macroproceso'];
                    $queryNombresMAcroprocesos = $mysqli->query("SELECT * FROM macroproceso WHERE id='$idMacroproceso' ");
                    $nombresMacroproceso = $queryNombresMAcroprocesos->fetch_array(MYSQLI_ASSOC); 
                    if($nombresMacroproceso != NULL){
                        echo" <td>".$nombresMacroproceso['nombre']."</td>";
                    }else{
                        echo" <td><b>No aplica</b></td>";
                    }
                    echo" <td style='display:$visibleE;'><button type='button' class='btn btn-block btn-success btn-sm' onclick=\"window.location='editarProceso?id=\ ". $row['id'] ." '\"><i class='fas fa-edit'></i> Editar</button></td>";
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
                                                                                    // buscamos donde se encuentra anclado este cargo en usuarios
                                                                                    $recorridoUsuarios=$mysqli->query("SELECT * FROM usuario ");
                                                                                    $stroingUsuariosConteo='0';
                                                                                    while($extraerRecorridoUsuarios=$recorridoUsuarios->fetch_array()){
                                                                                    $buscarCargosUsuarios=$extraerRecorridoUsuarios['proceso'];
                                                                                        if($buscarCargosUsuarios == $row['id']){
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
                                                                                                    // buscamos donde se encuentra anclado este cargo en usuarios
                                                                                                    $recorridoUsuarios=$mysqli->query("SELECT * FROM usuario ");
                                                                                                    $stroingUsuarios='';
                                                                                                    while($extraerRecorridoUsuarios=$recorridoUsuarios->fetch_array()){
                                                                                                        $buscarCargosUsuarios=$extraerRecorridoUsuarios['proceso'];
                                                                                                            if($buscarCargosUsuarios == $row['id']){
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
                                                                                <form action='controlador/procesos/controladorprocesos' method='POST'>
                                                                                    <input type="hidden" value="<?php echo $row['id'];?>" name='idDel' readonly>
                                                                                    <div class="modal-footer justify-content-between">
                                                                                      <!--<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>-->
                                                                                      <button type="submit" name='eliminarProceso' class="btn btn-outline-light">Si</button>
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
                    //echo" <td style='display:$visibleD;'><a href='controlador/procesos/controladorprocesos?idDel=\ ". $row['id'] ."'><button type='button' class='btn btn-block btn-danger btn-sm' onclick=\"return ConfirmDelete()\"><i class='fas fa-trash-alt'></i> Eliminar</button></a></td>";
                    
                    
                     
                     /// validación de script y funcion de eliminacion
                        ?>
                        <!--
                        <input type='hidden' id='capturaVariable<?php //echo $contador++;?>'  value= '<?php //echo $row['id'];?>' >
                        <td style='display:<?php //echo $visibleD;?>'><a onclick='funcionFormula<?php //echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                        <script>
                            function funcionFormula<?php //echo $contador2++;?>() {
                                /*alert("entre");*/
                              document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php //echo $contador3++;?>").value;
                            }
                       </script>
                       -->
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
                            
                            <form action='controlador/procesos/controladorprocesos' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormula" name='idDel' readonly>
                              <button type="submit" name='eliminarProceso' class="btn btn-outline-light">Si</button>
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
echo 'Mensaje alerta: '.$validacionExisteD=$_POST['validacionExisteD'];
$validacionExisteE=$_POST['validacionExisteE'];
$validacionAgregar=$_POST['validacionAgregar'];
echo ' --- mensaje= '.$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];


//// validaciones de importacion
$validacionExisteImportacion=$_POST['validacionExisteImportacion'];
$validacionExisteImportacionB=$_POST['validacionExisteImportacionB'];
$validacionExisteImportacionC=$_POST['validacionExisteImportacionC'];
$validacionExisteImportacionD=$_POST['validacionExisteImportacionD'];
$validacionExisteImportacionE=$_POST['validacionExisteImportacionE'];
$validacionExisteImportacionF=$_POST['validacionExisteImportacionF'];
$validacionExisteImportacionH=$_POST['validacionExisteImportacionG'];
$validacionExisteImportacionExito=$_POST['validacionExisteImportacionExito'];

/// END

/// macrpproceso
$validacionExisteImportacionBMacro=$_POST['validacionExisteImportacionBMacro'];

//// validación de campo vacio, identificando la columna que contiene el campo vacio
$validacionExisteImportacionVacio=$_POST['validacionExisteImportacionVacio'];
$mensajeEnviarCampoVacio=" 'Algunos campos están vacios ".$_POST['mensajeEnviarCampoVacio']." ' ";
/// END

/// campo validar repite celda dueño de proceso
$validacionRepiteDuenoProceso=$_POST['validacionRepiteDuenoProceso'];
?>
<script type="text/javascript">
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      <?php
      if($validacionExisteImportacionBMacro != NULL || $validacionExisteImportacionE != NULL || $validacionRepiteDuenoProceso != NULL){
      ?>
      timer: 12000
      <?php
      }else{
      ?>
      timer: 9000
      <?php
      }
      ?>
    });
    
    
    <?php
    if($validacionRepiteDuenoProceso == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: 'Algunos de los dueños de procesos están repetidos en el documento: <?php echo $_POST['mensajeRepetidoDuenoProceso'];?>'
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
    if($validacionExisteImportacionExito == 1){
     ?>
        Toast.fire({
            type: 'success',
            title: ' Registro agregado.' //Excel importado correctamente
        })
    <?php   
    }
    
    if($validacionExisteImportacionBMacro == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos macroprocesos no existen: <?php echo $_POST['validacionExisteImportacionBMacroMEnsaje'];?>.'
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
            title: ' Algunos procesos están repetidos en el documento.'
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
    if($validacionExisteImportacionD == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos procesos ya existen.' //nombres están repetidos
        })
    <?php
    }
    if($validacionExisteImportacionE == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos dueños de procesos no existen: <?php echo $_POST['validacionExisteImportacionEMensaje'];?>.'
        })
    <?php
    }
    if($validacionExisteImportacionF == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos prefijos ya existen.' //están repetidos
        })
    <?php
    }
    if($validacionExisteImportacionG == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos macroproceso no existen.'
        })
    <?php
    }
    if($validacionExisteImportacionH == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos elementos no existen o estan repetidos.'
        })
    <?php
    }
    
    
    
    
    if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El proceso ya existe.'
        })
    <?php
    }
    if($validacionExisteB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El prefijo ya existe.'
        })
    <?php
    }
    if($validacionExisteC == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El proceso ya existe.'
        })
    <?php
    }
    if($validacionExisteD == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El prefijo del proceso ya existe.'
        })
    <?php
    }
    if($validacionExisteE == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El proceso se encuentra en uso, no se puede eliminar.'
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
        $mensajeCaracter='El proceso contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterNombre'){
        $mensajeCaracter='El proceso contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaDescripcion'){
        $mensajeCaracter='La descripción contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterDescripcion'){
        $mensajeCaracter='La descripción contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaAsociado'){
        $mensajeCaracter='El dueño de proceso contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterAsociado'){
        $mensajeCaracter='El dueño de proceso contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaPrefijo'){
        $mensajeCaracter='El prefijo contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterPrefijo'){
        $mensajeCaracter='El prefijo contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaMacroproceso'){
        $mensajeCaracter='El macroproceso contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterMacroproceso'){
        $mensajeCaracter='El macroproceso contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
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