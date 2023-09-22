<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'centroTrabajo'; //Se cambia el nombre del formulario
require_once 'permisosPlataforma.php';

//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
    <title>Centro de Trabajo</title>
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
            <h1>Centro de Trabajo</h1>
            <h6>Gestione los centros de Trabajo con los que cuenta su compañía.</h6><br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Centro de Trabajo</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
            <?php
                if($visibleI == FALSE){
            ?>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="addCentrodetrabajo"><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>
            </div>
        <!--    <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="#"><font color="white"><i class="fas fa-user-plus"></i> Agregar Nivel Cargo</font></a></button>
            </div> -->
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-warning btn-sm"><a href="exportacion/centrodetrabajo"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="importacion/importar-centrodetrabajo/centro_de_trabajo.xlsx" onClick="javascript:document["ver-form"].submit();"><font color="white"><i class="fas fa-cloud-download-alt"></i> Descargar Plantilla</font></a></button>
            </div>

            <div class="col-sm">
                <form action="importacion2/importar-centrodetrabajo/index" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
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
                <button type="button" class="btn btn-block btn-warning btn-sm"><a href="exportacion/centrodetrabajo"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
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
                      <th>Centro de trabajo</th>
                      <th>Prefijo</th>
                      <th>Cargos asociados</th>
                      <th style="display:<?php echo$visibleE;?>;">Editar</th>
                      <th style="display:<?php echo$visibleD;?>;">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     $data = $mysqli->query("SELECT * FROM centrodetrabajo  ORDER BY nombreCentrodeTrabajo ASC ")or die(mysqli_error());
                     while($row = $data->fetch_assoc()){
                 
                    echo"<tr>";
                    $id = $row['id_centrodetrabajo'];
                    
                    echo" <td style='text-align:justify;'>".$row['nombreCentrodeTrabajo']."</td>";
                    
                    echo" <td style='text-align:justify;'>".$row['prefijoCentrodeTrabajo']."</td>";
                    
                    
            	    
            	    if($row['estilo'] == '1'){ // si viene por importación no me trae ID si no me trae nombres
            	        
            	        echo $asociadoss=str_replace(',]',']',$row['cargosAsociadoss']);
            	        $personalCargosAsociados =  json_decode($asociadoss);
            	        $longitud = count($personalCargosAsociados);
                            // traemos el JSON para sacar los ID y traer los nombres de los cargos asociados
                            if($row['cargosAsociadoss'] == '[""]'){
                                echo "<td style='text-align:justify;'><b>" .  'No aplica' . "</b></td>";
                            }else{
                                if($row['cargosAsociadoss'] != NULL){
                                        echo"<td style='text-align:justify;'>";
                                        for($i=0; $i<$longitud; $i++){
                                            
                                            $nombreuCargos = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$personalCargosAsociados[$i]'");
                                            $columna = $nombreuCargos->fetch_array(MYSQLI_ASSOC);
                                        
                                            echo '*'.$columna['nombreCargos']; echo "<br>";
                                           
                                        } echo"</td>";
                                    
                        	    }else{
                        	       
                        	        echo "<td style='text-align:justify;'><b>" .  'No aplica' . "</b></td>";
                        	        
                        	    }
                            }
            	    }else{
            	    
            	    $personalID =  json_decode($row['cargosAsociadoss']);
            	    $longitud = count($personalID);
                            // traemos el JSON para sacar los ID y traer los nombres de los cargos asociados
                        if($row['cargosAsociadoss'] == '0'){
                             echo "<td style='text-align:justify;'><b>" .  'No aplica' . "</b></td>";
                        }else{
                            if($row['cargosAsociadoss'] != NULL){
                                    echo"<td style='text-align:justify;'>";
                                    for($i=0; $i<$longitud; $i++){
                                        
                                        $nombreuCargos = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$personalID[$i]'");
                                        $columna = $nombreuCargos->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo '*'.$columna['nombreCargos']; echo "<br>";
                                       
                                    } echo"</td>";
                                
                    	    }else{
                    	       
                    	        echo "<td style='text-align:justify;'><b>" .  'No aplica' . "</b></td>";
                    	        
                    	    }    
                        }
            	    }
                    echo"<form action='centrodetrabajoEditar' method='POST'>";
                    echo"<input type='hidden' name='idCentro' value= '$id' >";
                    echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                    echo"</form>";
                    ?>
                    
                    <td style="text-align:justify;display:<?php echo $visibleD;?>;">
                         <button type="button" class='btn btn-block btn-danger btn-sm' data-toggle="modal"
                            data-target="#exampleModalCenter<?php echo $row['id_centrodetrabajo'].''.$contador_modal++;?>">
                            <i class='fas fa-trash-alt'></i> Eliminar 
                         </button>
                                                                          
                                                                          <div class="modal fade" id="exampleModalCenter<?php echo $row['id_centrodetrabajo'].''.$contador_modal_b++;?>" tabindex="-1" role="dialog"
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
                                                                                        $buscarCargosCosto=$extraerRecorridoCentroDeCosto['idCentroTrabajo'];
                                                                                            if($buscarCargosCosto == $id){
                                                                                                $stykeScroll='style="width:100%;height:100px;overflow-y:scroll;"';
                                                                                            }else{
                                                                                                $stykeScroll='';
                                                                                            }
                                                                                    }
                                                                                    ?>
                                                                                      <div id="container"  <?php echo $stykeScroll;?> >
                                                                                        <?php
                                                                                            
                                                                                            
                                                                                                // buscamos donde se encuentra anclado este cargo en centro de costo
                                                                                                $recorridoCentroDeCosto=$mysqli->query("SELECT * FROM centroCostos ");
                                                                                                $stroingCentroDeCosto='';
                                                                                                while($extraerRecorridoCentroDeCosto=$recorridoCentroDeCosto->fetch_array()){
                                                                                                    $buscarCargosCosto=$extraerRecorridoCentroDeCosto['idCentroTrabajo']; 
                                                                                                  
                                                                                                        if($buscarCargosCosto == $id){
                                                                                                           $stroingCentroDeCosto.='-'.$extraerRecorridoCentroDeCosto['nombre'].'<br>';
                                                                                                        }
                                                                                                }
                                                                                                if($stroingCentroDeCosto != NULL){
                                                                                                    echo $enviarMensajeCentroDeCosto='El centro de trabajo se encuentra asociado con los centro de costo:<br>'.$stroingCentroDeCosto;
                                                                                                }
                                                                                                echo '<br>';
                                                                                                // buscamos donde se encuentra anclado este cargo en centro de costo
                                                                                                $recorridoUsuarios=$mysqli->query("SELECT * FROM  usuario "); 
                                                                                                $stroingUsuarios='';
                                                                                                while($extraerRecorridoUsuarios=$recorridoUsuarios->fetch_array()){
                                                                                                    
                                                                                                    $consultandoCCtrabajoAsociado=$mysqli->query("SELECT * FROM cTrabajoUusuario WHERE idUsuario='".$extraerRecorridoUsuarios['cedula']."' ");
                                                                                                    $extarer_consultandoCCtrabajoAsociado=$consultandoCCtrabajoAsociado->fetch_array(MYSQLI_ASSOC);
                                                                                                    
                                                                                                    $buscUsuarios=$extarer_consultandoCCtrabajoAsociado['idCtrabajo'];  
                                                                                                  
                                                                                                        if($buscUsuarios == $id){
                                                                                                           $stroingUsuarios.='-'.$extraerRecorridoUsuarios['nombres'].' '.$extraerRecorridoUsuarios['apellidos'].'<br>';
                                                                                                        }
                                                                                                }
                                                                                                if($stroingUsuarios != NULL){
                                                                                                    echo $enviarMensajeUsuarios='El centro de trabajo se encuentra asociado con los usuarios:<br>'.$stroingUsuarios;
                                                                                                }
                                                                                              
                                                                                            
                                                                                            ?>
                                                                                      </div>
                                                                                    </div>
                                                                                </div>
                                                                                <form action='controlador/centrodetrabajo/controladorcentrodetrabajo' method='POST'>
                                                                                    <input type="hidden" value="<?php echo $row['id_centrodetrabajo'];?>" name='idCentro' readonly>
                                                                                    <div class="modal-footer justify-content-between">
                                                                                      <!--<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>-->
                                                                                      <button type="submit" name='EliminarCargos' class="btn btn-outline-light">Si</button>
                                                                                      <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                                                                                    </div>
                                                                                </form>
                                                                              </div>
                                                                            </div>
                                                                          </div>
                            
                            
                            
                    </td>
                    <!--
                        <input type='hidden' id='capturaVariable<?php //echo $contador++;?>'  value= '<?php //echo $id;?>' >
                        <td style='display:<?php //echo $visibleD;?>'><a onclick='funcionFormula<?php //echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                        <script>
                            function funcionFormula<?php //echo $contador2++;?>() {
                                /*alert("entre");*/
                              document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                            }
                       </script>
                    -->
                    
                    
                    <?php
                       
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
                           
                            <form action='controlador/centrodetrabajo/controladorcentrodetrabajo' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormula" name='idCentro' readonly>
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
$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];

//// validaciones de importación
$validacionExisteImportacionA=$_POST['validacionExisteImportacionA'];
$validacionExisteImportacionB=$_POST['validacionExisteImportacionB'];
$validacionExisteImportacionC=$_POST['validacionExisteImportacionC'];
$validacionExisteImportacionD=$_POST['validacionExisteImportacionD'];
$validacionExisteImportacionE=$_POST['validacionExisteImportacionE'];
$validacionExisteImportacionF=$_POST['validacionExisteImportacionF'];
$validacionExisteImportacionG=$_POST['validacionExisteImportacionG'];
$validacionExisteImportacionRepiteAsociado=$_POST['validacionExisteImportacionRepiteAsociado'];
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
      if($validacionExisteImportacionF != NULL || $_POST['mensajeAsociados'] != NULL){
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
    if($validacionExisteImportacionRepiteAsociado == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: 'Algunos cargos asociados están repetidos en el documento: <?php echo $_POST['mensajeAsociados'];?>'
        })
    <?php
    }
    /* if($validacionExisteImportacionVacio == 1){
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
            title: ' Está intentando subir un archivo diferente.'
        })
    <?php
    }
     if($validacionExisteImportacionB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos centros de trabajo están repetidos en el documento.'
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
            title: ' Algunos prefijos ya existen.'
        })
    <?php
    }
     if($validacionExisteImportacionE == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos centro de trabajo ya existen.'
        })
    <?php
    }
     if($validacionExisteImportacionF == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos cargos asociados no existen: <?php echo $_POST['validacionExisteImportacionFMensaje'];?>'
        })
    <?php
    }
     if($validacionExisteImportacionG == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El centro de trabajo ya existe.'
        })
    <?php
    }
     if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El centro de trabajo o el prefijo ya existe.'
        })
    <?php
    }
     if($validacionExisteA == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El centro de trabajo ya existe.'
        })
    <?php
    }
    if($validacionExisteB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El prefijo del centro de trabajo ya existe.'
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
        $mensajeCaracter='El centro de trabajo contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterNombre'){
        $mensajeCaracter='El centro de trabajo contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaPrefijo'){
        $mensajeCaracter='El prefijo contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterPrefijo'){
        $mensajeCaracter='El prefijo contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'celdaAsociado'){
        $mensajeCaracter='El cargo asociado contiene un caracter especial no permitido " : '.$_POST['enviarMensajeCaracter'];
        }
        if($_POST['enviarMensajeCaracterTipo'] == 'caracterAsociado'){
        $mensajeCaracter='El cargo asociado contiene caracteres especiales no permitidos: '.$_POST['enviarMensajeCaracter'];
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