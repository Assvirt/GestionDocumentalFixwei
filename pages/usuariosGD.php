<?php 
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
require 'conexion/bd.php';
//////////////////////PERMISOS////////////////////////

//////////////////////PERMISOS////////////////////////

  $formulario = 'usuarios'; //Se cambia el nombre del formulario

  require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - PENDIENTES GESTIÓN DOCUMENTAL</title>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!--CKeditor-->
  <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.min.js"></script>
  <style>
    .pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }
  </style>
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
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
            <h1>Pendientes gestión documental</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Pendientes gestión documental</li>
            </ol>
          </div>
        </div>
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-10">
                   
                </div>
                <div class="col">
                    
                </div>
                
           
            </div>
        <div>

        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    
    
    
     <section class="content" id="divulgacion" style="display:none;">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-10">
                    <!-- Default box -->
                    
                    
                    
                    
                    <!-- /.card -->
                  </div>
                  <div class="col"></div>
                </div>
        </div>
    </section>
    
    
    
    
    <!-- TABLA PERMISOS-->
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-10">
                    <!-- Default box -->
                   
                        <div class="card">
                          <div class="card-header">
                              <?php
                              /// se recupera la petición de post, del id del usuario, para traer el nombre y apellido del usuario
                              $consulta_usuario=$mysqli->query("SELECT * FROM usuario WHERE id='".$_POST['usuario']."' ");
                              $extraer_consulta_usuario=$consulta_usuario->fetch_array(MYSQLI_ASSOC);
                              /// reemplazamos las variables
                              $cargo=$extraer_consulta_usuario['cargo'];
                              $idUsuario=$extraer_consulta_usuario['id'];
                              ?>
                            <h3 class="card-title">Documentos pendientes del usuario <?php echo $extraer_consulta_usuario['nombres'].' '.$extraer_consulta_usuario['apellidos'];?></h3>
                            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          
                          <div class="card-body">
                            <!--INICIO ROW-->
                            <div class="row post">
                                
                              <div class="card-body table-responsive p-0" >
                                <table class="table table-head-fixed text-center" id="example">
                                  <thead>
                                    <tr>
                                      <th>Versión</th>
                                      <th>Código</th>
                                      <th>Nombre documento</th>
                                      <th>Tipo documento</th>
                                      <th>Proceso</th>
                                      <th>Estado</th>
                                      <th>Ver</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                                     $data = $mysqli->query("SELECT * FROM solicitudDocumentos WHERE estado = 'Aprobado'")or die(mysqli_error());
                                     
                                     $listarSolicitud = FALSE; //si no es el encargado de la solicitud continua. 
                                     $listarDocumento = FALSE; //si no puede ver el documento por que no es elaborador, revisor o aprobador no lo lista.
                                     
                                     
                                     while($row = $data->fetch_assoc()){
                                        
                                        /*
                                        * Validamos el tipo de soliticitud 
                                        * 1 = Documento nuevo
                                        * 2 = Actualizar documento
                                        * 3 = Eliminar documento
                                        */ 
                                        
                                        if($row['estado'] == "Ejecutado"){//Los documentos ejecutados ya estan en el listado maestro, esta linea hace que no se muestren 
                                            continue;
                                        }
                                        
                                        
                                    
                                        ///Codigo para saltar los documentos que no debe gestionar el usuario segun su cargo y el cargo encargado de la solicitud. 
                                        $encargadoSolicitud = $row['encargadoAprobar'];
                
                                        
                                        if($row['tipoSolicitud'] == 1){
                                            $idSol = $row['id'];
                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                            $queryDoc = $mysqli->query("SELECT * FROM documento WHERE id_solicitud = $idSol")or die(mysqli_error($mysqli));
                                            $datosDoc = $queryDoc->fetch_assoc();
                                            $tipoDocumento = $datosDoc['tipo_documento'];
                                            $proceso = $datosDoc['proceso'];
                                            
                                            if($datosDoc['estado'] != NULL){
                                                if($datosDoc['estado'] == "Pendiente"){
                                                
                                                    $quienElabora = json_decode($datosDoc['elabora']);
                                                    
                                                    if($quienElabora[0] == 'usuarios'){
                                                        if(in_array($idUsuario,$quienElabora)){
                                                            
                                                        }else{
                                                            continue;
                                                        }
                                                    }
                                                    
                                                    if($quienElabora[0] == 'cargos'){
                                                        if(in_array($cargo,$quienElabora)){ ///$cargoID
                                                            
                                                        }else{
                                                            continue;
                                                        }
                                                    }
                                                    
                                                }
                                                
                                                if($datosDoc['estado'] == "Elaborado"){
                                                    $quienRevisa= json_decode($datosDoc['revisa']);
                                                    
                                                    if($quienRevisa[0] == 'usuarios'){
                                                        if(in_array($idUsuario,$quienRevisa)){
                                                           
                                                        }else{
                                                            continue;
                                                        }
                                                    }
                                                    
                                                    if($quienRevisa[0] == 'cargos'){
                                                        if(in_array($cargo,$quienRevisa)){ //$cargoID
                                                            
                                                        }else{
                                                            continue;
                                                        }
                                                    }
                                                    
                                                }
                                                
                                                if($datosDoc['estado'] == "Revisado"){
                                                    $quienAprueba= json_decode($datosDoc['aprueba']);
                                                    
                                                    if($quienAprueba[0] == 'usuarios'){
                                                        if(in_array($idUsuario,$quienAprueba)){
                                                           
                                                        }else{
                                                            continue;
                                                        }
                                                    }
                                                    
                                                    if($quienAprueba[0] == 'cargos'){
                                                        if(in_array($cargo,$quienAprueba)){ ///$cargoID
                                                            
                                                        }else{
                                                            continue;
                                                        }
                                                    }
                                                    
                                                }
                                                
                                            }else{
                                                if($encargadoSolicitud != $cargo){ ///$cargoID
                                                    continue;
                                                }
                                            }
                                            
                                        }
                                        
                                        
                                        if($row['tipoSolicitud'] == 2){
                                            
                                            $idDoc = $row['nombreDocumento'];
                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                            $queryDoc2 = $mysqli->query("SELECT * FROM documento WHERE id = $idDoc")or die(mysqli_error($mysqli));
                                            $datosDoc2 = $queryDoc2->fetch_assoc();
                                            $tipoDocumento = $datosDoc2['tipo_documento'];
                                            $proceso = $datosDoc2['proceso'];
                                            
                                            
                                            if($datosDoc2['estadoActualiza'] != NULL){
                                           
                                                if($datosDoc2['estadoActualiza'] == "Pendiente"){
                                                
                                                    $quienElabora = json_decode($datosDoc2['elaboraActualizar']);
                                                    
                                                    if($quienElabora[0] == 'usuarios'){
                                                        if(in_array($idUsuario,$quienElabora)){
                                                            
                                                        }else{
                                                            continue;
                                                        }
                                                    }
                                                    
                                                    if($quienElabora[0] == 'cargos'){
                                                        if(in_array($cargo,$quienElabora)){ ///$cargoID
                                                            
                                                        }else{
                                                            continue;
                                                        }
                                                    }
                                                    
                                                }
                                                
                                                if($datosDoc2['estadoActualiza'] == "Elaborado"){
                                                    $quienRevisa= json_decode($datosDoc2['revisaActualizar']);
                                                    
                                                    if($quienRevisa[0] == 'usuarios'){
                                                        if(in_array($idUsuario,$quienRevisa)){
                                                            
                                                        }else{
                                                            continue;
                                                        }
                                                    }
                                                    
                                                    if($quienRevisa[0] == 'cargos'){
                                                        if(in_array($cargo,$quienRevisa)){ ///$cargoID
                                                            
                                                        }else{
                                                            continue;
                                                        }
                                                    }
                                                    
                                                }
                                                
                                                if($datosDoc2['estadoActualiza'] == "Revisado"){
                                                    $quienAprueba= json_decode($datosDoc2['apruebaActualizar']);
                                                    
                                                    if($quienAprueba[0] == 'usuarios'){
                                                        if(in_array($idUsuario,$quienAprueba)){
                                                            
                                                        }else{
                                                            continue;
                                                        }
                                                    }
                                                    
                                                    if($quienAprueba[0] == 'cargos'){
                                                        if(in_array($cargo,$quienAprueba)){ //$cargoID
                                                            
                                                        }else{
                                                            continue;
                                                        }
                                                    }
                                                    
                                                }
                                                
                                            }else{
                                                if($encargadoSolicitud != $cargo){ ///$cargoID
                                                    continue;
                                                }
                                            }
                                            
                                        }
                                        
                                        
                                        
                                        if($row['tipoSolicitud'] == 3){
                                            
                                            $idDoc = $row['nombreDocumento'];
                                            $acentos = $mysqli->query("SET NAMES 'utf8'");
                                            $queryDoc3 = $mysqli->query("SELECT * FROM documento WHERE id = $idDoc")or die(mysqli_error($mysqli));
                                            $datosDoc3 = $queryDoc3->fetch_assoc();
                                            $tipoDocumento = $datosDoc3['tipo_documento'];
                                            $proceso = $datosDoc3['proceso'];
                                            
                                            if($datosDoc3['estadoElimina'] != NULL){
                                            
                                                if($datosDoc3['estadoElimina'] == "Pendiente"){
                                                
                                                    $quienElabora = json_decode($datosDoc3['elaboraElimanar']);
                                                    
                                                    if($quienElabora[0] == 'usuarios'){
                                                        if(in_array($idUsuario,$quienElabora)){
                                                            
                                                        }else{
                                                            continue;
                                                        }
                                                    }
                                                    
                                                    if($quienElabora[0] == 'cargos'){
                                                        if(in_array($cargo,$quienElabora)){ //$cargoID
                                                            
                                                        }else{
                                                            continue;
                                                        }
                                                    }
                                                    
                                                }
                                                
                                                if($datosDoc3['estadoElimina'] == "Elaborado"){
                                                    $quienRevisa= json_decode($datosDoc3['revisaElimanar']);
                                                    
                                                    if($quienRevisa[0] == 'usuarios'){
                                                        if(in_array($idUsuario,$quienRevisa)){
                                                            
                                                        }else{
                                                            continue;
                                                        }
                                                    }
                                                    
                                                    if($quienRevisa[0] == 'cargos'){
                                                        if(in_array($cargo,$quienRevisa)){ //$cargoID
                                                            
                                                        }else{
                                                            continue;
                                                        }
                                                    }
                                                    
                                                }
                                                
                                                if($datosDoc3['estadoElimina'] == "Revisado"){
                                                    $quienAprueba= json_decode($datosDoc3['apruebaElimanar']);
                                                    
                                                    if($quienAprueba[0] == 'usuarios'){
                                                        if(in_array($idUsuario,$quienAprueba)){
                                                            
                                                        }else{
                                                            continue;
                                                        }
                                                    }
                                                    
                                                    if($quienAprueba[0] == 'cargos'){
                                                        if(in_array($cargo,$quienAprueba)){ //$cargoID
                                                            
                                                        }else{
                                                            continue;
                                                        }
                                                    }
                                                    
                                                }
                                                
                                            }else{
                                                if($encargadoSolicitud != $cargo){ ///$cargoID
                                                    continue;
                                                }
                                            }
                                            
                                        }
                                        
                
                                        
                                        //Datos segun el tipo de solicitud
                                        if($row['tipoSolicitud'] == 1){
                                             
                                            if($datosDoc['estado'] == "Pendiente" || !$datosDoc['estado']){
                                                $codigo = "<strong>Sin definir</strong>";
                                                $version = "<strong>Sin definir</strong>";
                                                $nombre = $row['nombreDocumento'];
                                                $estado = "<font color='red'>Pendiente</font>";
                                                
                                            }
                                            
                                            if($datosDoc['estado'] != NULL){
                                                $codigo = "<strong>".$datosDoc['codificacion']."</strong>";
                                                $version = "<strong>".$datosDoc['version']."</strong>";
                                                $nombre = $datosDoc['nombres'];
                                                $estado = "<font color='red'>".$datosDoc['estado']."</font>";
                                                
                                            }
                                            
                                        }
                                        
                                        
                                        
                                        if($row['tipoSolicitud'] == 2){
                                            $codigo = "<strong>".$datosDoc2['codificacion']."</strong>";
                                            $version = "<strong>".$datosDoc2['version']."</strong>";
                                            $nombre = $datosDoc2['nombres'];
                                            if($datosDoc2['estadoActualiza'] == NULL){
                                                $estado = "<font color='red'>Pendiente</font>";
                                            }else{
                                                $estado = "<font color='red'>".$datosDoc2['estadoActualiza']."</font>";
                                            }
                                           
                                        }
                                        
                                        if($row['tipoSolicitud'] == 3){
                                            $codigo = "<strong>".$datosDoc3['codificacion']."</strong>";
                                            $version = "<strong>".$datosDoc3['version']."</strong>";
                                            $nombre = $datosDoc3['nombres'];
                                            if($datosDoc3['estadoElimina'] == NULL){
                                                $estado = "<font color='red'>Pendiente</font>";    
                                            }else{
                                                $estado = "<font color='red'>".$datosDoc3['estadoElimina']."</font>";
                                            }
                                            
                                        }
                                        
                                        //Traigo datos de variables proceso y tipo de documento
                                        
                                        //PROCESO
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $queryDocumentos = $mysqli->query("SELECT nombre, prefijo, ruta from tipoDocumento WHERE id = '".$tipoDocumento."' ");
                                        $datosDocumento = $queryDocumentos->fetch_array(MYSQLI_ASSOC);
                                        $tipoDocumento = $datosDocumento['nombre'];
                                        $prefijoTipo = $datosDocumento['prefijo']; 
                                        $ruta = utf8_decode($datosDocumento['ruta']);
                                        
                                        //TIPO DE DOCUMENTO
                                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                                        $queryProcesos = $mysqli->query("SELECT nombre,prefijo from procesos WHERE id = '".$proceso."' ");
                                        $datosProceso = $queryProcesos->fetch_array(MYSQLI_ASSOC);
                                        $nomProceso = $datosProceso['nombre'];
                                        $prefijoProceso = $datosProceso['prefijo']; 
                                 
                                 
                                    
                                 
                                 /// si el documento no ha sido asignado, es decir, está sin definir, no debe mostrar
                                    if($version == '<strong>Sin definir</strong>'){
                                        continue;
                                    }
                                    
                                     echo"<tr>";
                                     
                                     echo" <td style='text-align: justify;' >".$version."</td>";
                                     echo" <td style='text-align: justify;' >".$codigo."</td>";
                                     echo" <td style='text-align: justify;' >".$nombre."</td>";
                                     echo" <td style='text-align: justify;' >".$tipoDocumento."</td>";
                                     echo" <td style='text-align: justify;' >".$nomProceso."</td>";
                                     echo" <td style='text-align: justify;' >".$estado."</td>";
                                     
                                     $queryDocumento = $mysqli->query("SELECT id,id_solicitud from documento WHERE id_solicitud = '".$row['id']."' ");
                                     $datoDocumento = $queryDocumento->fetch_array(MYSQLI_ASSOC);
                                     
                                     
                                     echo"<form action='creacionDocumentalAsignacionVer' method='POST' target='_blank'>";
                                            echo"<td>";
                                                echo"<input type='hidden' name='pendientesRol' value='1'>";
                                                echo"<input type='hidden' name='idDocumento' value='".$datoDocumento['id']."'>";
                                                echo"<input type='hidden' name='idSolicitud' value='".$row['id']."'>";
                                                echo"<button type='submit' class='btn btn-block btn-primary btn-sm'><i class='fas fa-eye'></i> Ver más</button>";
                                                
                                            echo"</td>";
                                        echo"</form>";
                                     
                                     
                                     
                                    echo"</tr>";
                                    }
                                    ?> 
                                  </tbody>
                                </table>
                              </div>
                                
                               
                                
                               
                            
                            </div>
                           
                          </div>
                          
                          <!-- /.card-body -->
                          <div class="card-footer">
                              
                          </div>
                          <!-- /.card-footer-->
                        </div>
                    
                    <!-- /.card -->
                  </div>
                  <div class="col"></div>
                </div>
        </div>
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
    const MAXIMO_TAMANIO_BYTES = 11000000; // 1MB = 1 millón de bytes

// Obtener referencia al elemento
const $miInput = document.querySelector("#miInput");

$miInput.addEventListener("change", function () {
	// si no hay archivos, regresamos
	if (this.files.length <= 0) return;

	// Validamos el primer archivo únicamente
	const archivo = this.files[0];
	if (archivo.size > MAXIMO_TAMANIO_BYTES) {
		const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
		//alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
		const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
    
    
        Toast.fire({
            type: 'warning',
            title: ` El tamaño máximo del archivo es de 10 MB`
        })
		// Limpiar
		$miInput.value = "";
	} else {
		// Validación asada. Envía el formulario o haz lo que tengas que hacer
	}
});
</script>
<!-- para mostrar el archivo seleccionado en el file -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<!-- end -->

                                    
<?php
$validacionAgregar=$_POST['validacionAgregar'];
$validacionVacio=$_POST['validacionVacio'];
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
      if($validacionAgregar == 1){
      ?>
          Toast.fire({
              type: 'success',
              title: 'Divulgación enviada.'
          })
      <?php
      }
       if($validacionVacio == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: 'Debe seleccionar el personal de divulgación.'
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
      ?>
      
    });

  </script>



<script>
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
</script>
<!-- Select2 -->
<script src="../plugins/select2/js/select2.full.min.js"></script>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>
<!--Select dinamico-->
<script>
    $(document).ready(function(){
        $('#rad_cargoD').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoD").html(data);
            }); 
        });
        $('#rad_usuarioD').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoD").html(data);
            }); 
        });
        
        /* Aca se carga los datos que ya se an seleccioando*/            
        var radios = document.getElementsByName('radiobtnD');

        
        for (var i = 0, length = radios.length; i < length; i++) {
          if (radios[i].checked) {
            // do whatever you want with the checked radio
            //alert(radios[i].value);
            var rad_post = document.getElementById("idDocumento").value;
            var grupo = radios[i].value;
            var radEncargadoDD = "radEncargadoDD";
            
            //alert(rad_post);
            
            $.post("selectDocumentos2.php", { rad_post: rad_post, grupo: grupo, radEncargadoDD: radEncargadoDD}, function(data){
                $("#select_encargadoD").html(data);
            }); 
            // only one radio can be logically checked, don't check the rest
            break;
          }
        }
        
    });
</script>
<!--Ckeditor-->
<script>
    CKEDITOR.replace( 'editor1' );
</script>
<script>
    CKEDITOR.replace( 'editor12' );
</script>
<script>PDFObject.embed("archivos/documentos/<?php echo $nombrePDF;?>", "#example1");</script>
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
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