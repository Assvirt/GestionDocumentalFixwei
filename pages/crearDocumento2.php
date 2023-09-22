<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
require_once 'conexion/bd.php';
    
    $idSolicitud = $_POST['idSolicitud'];
    $nombreDoc = $_POST['nombreDocumento'];
    $norma = $_POST['norma'];
    $proceso = $_POST['proceso'];
    $metodo = $_POST['rad_metodo'];
    $tipoDoc = $_POST['tipoDoc'];
    $ubicacion = $_POST['ubicacion'];
    
    $elabora = $_POST['select_encargadoE'];
    $revisa = $_POST['select_encargadoR'];
    $aprueba = $_POST['select_encargadoA'];
    
    $codificacion = $_POST['radCodificacion'];
    $versionDeclarada = $_POST['versionDeclarada'];
    $consecutivoDeclarada = $_POST['consecutivoDeclarado']; 
    
    $radElabora = $_POST['radiobtnE'];
    $radRevisa = $_POST['radiobtnR'];
    $radAprueba = $_POST['radiobtnA'];
    $rol = $_POST['rol'];

?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Asignar documento</title>
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
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!--CKeditor-->
  <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
  
</head>
<script>
   	
    function nobackbutton(){
    	
       window.location.hash="no-back-button";
    	
       window.location.hash="Again-No-back-button" //chrome
    	
       window.onhashchange=function(){window.location.hash="no-back-button";}
    	
    }
</script>
<body class="hold-transition sidebar-mini" onload="nobackbutton();" oncopy="return false" onpaste="return false">
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
            <h1>Asignar documento</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Asignar documento</li>
            </ol>
          </div>
        </div>
        <!--<div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                <div class="row">
                    <div class="col-sm">
                        <button type="button" class="btn btn-block btn-success btn-sm"><a href="crearDocumento"><font color="white"><i class="fas fa-chevron-left"></i> Regresar</font></a></button>
                    </div>
                    <div class="col-sm">
                    </div>
                    <div class="col-sm">
                    </div>
                    <div class="col-sm">
                    </div>
                    <div class="col-sm">
                    </div>
                </div>
            </div>
            <div class="col">
            </div>   
        </div>-->
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php
                if($metodo != "documento"){
              ?>
              <div class="col">
                <div class="form-group col-sm-12">
                    <button type="" name="siguiente" class="btn btn-primary float-left" onclick="window.open('uploadImg')"> <i class="fas fa-file-upload"></i> Subir imagen</button>    
                </div>
                </div>
              
              <?php } ?>
              <form role="form" action="crearDocumento3" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        
                        <?php
                            if($metodo != "documento"){
                        ?>
                        <div class="form-group col-sm-12">
                            <textarea name="editor1" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required></textarea>
                        </div>
                        <?php }else{?>
                        
                        <?php
                            //if($metodo == "documento"){
                        ?>
                        <div class="form-group col-sm-6">
                            <label for="exampleInputFile">Importar documento PDF</label>
                            <div class="input-group">
                              <div class="custom-file">
                                
                                <!-- Agregamos esta linea para validar que solo sea el documento pdf
                                <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                                END -->

                                <input autocomplete="off" type="file" class="custom-file-input" id="miInput" name="archivopdf" accept="application/pdf" required>
                                
                                <!-- Agregamos esta linea para validar que solo sea el documento pdf-->
                                <script>
                                $('input[name="archivopdf"]').on('change', function(){
                                    var ext = $( this ).val().split('.').pop();
                                    if ($( this ).val() != '') {
                                      if(ext == "pdf"){
                                        
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
                                <label class="custom-file-label" for="exampleInputFile">Seleccionar archivo</label>
                              </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="exampleInputFile">Importar documento editable (.docx, .xlsx, .dwg , .pptx)</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input autocomplete="off" type="file" class="custom-file-input" id="miInput2" name="archivootro" accept=".xls,.xlsx,.docx,.doc,.dwg" required>
                                <!-- Agregamos esta linea para validar que solo sea el documento pdf-->
                                <script>
                                $('input[name="archivootro"]').on('change', function(){
                                    var ext = $( this ).val().split('.').pop();
                                    if ($( this ).val() != '') {
                                      if(ext == "docx" || ext == "xls" || ext == "xlsx" || ext == "doc" || ext == "dwg"|| ext =="pptx"|| ext =="ppt"){
                                        
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
                                <label class="custom-file-label" for="exampleInputFile">Seleccionar archivo</label>
                              </div>
                            </div>
                        </div>
                        <?php }?>
                        
                        
                        
                        <div class="form-group col-sm-6">
                            <?php
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT id, nombre FROM documentoExterno");
                                
                                    $consultandoDatosTemporales=$mysqli->query("SELECT * FROM documentoDatosTemporales WHERE solicitud='$idSolicitud' ");
                                    $extraerConsultaDatosTemporales=$consultandoDatosTemporales->fetch_array(MYSQLI_ASSOC);
                                    $arrayExterno = json_decode($extraerConsultaDatosTemporales['externo']);
                            ?>
                            <label>Documentos externos: </label>
                              <select class="duallistbox" name="documentos_externos[]" multiple >
                                <?php
                                    while ($columna = mysqli_fetch_array( $resultado )) {
                                        
                                        if($arrayExterno != NULL){ 
                                            if(in_array($columna['id'],$arrayExterno)){
                                                $seleccionarExterno = "selected";        
                                            }else{
                                                $seleccionarExterno ="";
                                            }
                                        }
                                ?>
                                    <option value="<?php echo $columna['id']; ?>" <?php echo $seleccionarExterno;?> ><?php echo $columna['nombre']; ?> </option>
                                <?php }  ?>
                              </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <?php 
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT * FROM definicion ORDER by nombre, nombreN ASC");
                                
                                    $consultandoDatosTemporales=$mysqli->query("SELECT * FROM documentoDatosTemporales WHERE solicitud='$idSolicitud' ");
                                    $extraerConsultaDatosTemporales=$consultandoDatosTemporales->fetch_array(MYSQLI_ASSOC);
                                    $arrayDefiniciones = json_decode($extraerConsultaDatosTemporales['definicion']);
                              
                                
                            ?>
                            <label>Definiciones: </label>
                              <select class="duallistbox" name="definiciones[]" multiple >
                                  
                                  
                                <?php
                                    while ($columna = mysqli_fetch_array( $resultado )) {
                                        
                                        if($arrayDefiniciones != NULL){ 
                                            if(in_array($columna['id'],$arrayDefiniciones)){
                                                $seleccionarDef = "selected";        
                                            }else{
                                                $seleccionarDef ="";
                                            }
                                        }
                                        
                                        $id = $columna['id'];
                                        $nombre = $columna['nombre'];
                                        $nombreN =$columna['nombreN'];
                                        /*
                                        if($nombreN != NULL){
                                            echo "<option value='$id' > $nombreN</option>";
                                        }*/ 
                                        if($nombre != NULL){
                                            echo "<option value='$id' ".$seleccionarDef." > $nombre</option>";
                                            
                                        }
                                                                           
                                    
                                    ?>
                                        
                                <?php }  ?>
                              </select>
                        </div>


                        <div class="form-group col-sm-6">
                            <label>Archivo en gestión: </label>
                            <input autocomplete="off" type="text" class="form-control" name="archivo_gestion" value="<?php echo $_POST['archivo_gestion']; ?>" placeholder="Archivo en gestión" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                                <br>
                            <label>Archivo central: </label>
                            <input autocomplete="off" type="text" class="form-control" name="archivo_central" value="<?php echo $_POST['archivo_central']; ?>" placeholder="Archivo central" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                                <br>
                            <label>Archivo histórico: </label>
                            <input autocomplete="off" type="text" class="form-control" name="archivo_historico" value="<?php echo $_POST['archivo_historico']; ?>" placeholder="Archivo histórico" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                            
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label>Disposición Documental: </label>
                            <textarea rows="3" class="form-control" name="diposicion_documental" placeholder="Disposición Documental" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) ||  event.charCode == 13 || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required><?php echo $_POST['diposicion_documental']; ?></textarea>
                            <br>
                            <label>Responsable de disposición: </label><br>
                            <?php
                                    $resposableDispoDoc = json_decode($extraerConsultaDatosTemporales['responsable']);
                        
                        
                                    if($resposableDispoDoc[0] == 'cargos'){
                                        $checkedDispoC = "checked";            
                                    }
                                    
                                    if($resposableDispoDoc[0] == 'usuarios'){
                                        $checkedDispoU = "checked"; 
                                    }
                            ?>
                                <input autocomplete="off" type="radio" id="rad_cargoD" name="radiobtnD" value="cargos" <?php echo $checkedDispoC;?> >
                                <label for="cargo">Cargo</label>
                                <input autocomplete="off" type="radio" id="rad_usuarioD" name="radiobtnD" value="usuarios" <?php echo $checkedDispoU;?> >
                                <label for="usuarios">Usuarios</label>
    
                                
                                <div class="select2-blue">
                                    <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoD[]" id="select_encargadoD" required>
                                    </select>
                                </div>
                        </div>
                        
                        
                    </div>
                        
        
                  <!--
                  
                  ACA SE AGREGAN ELEMENTOS NUEVOS
                  
                  SE PUEDE EXTRAER DE: 
                  https://fixwei.com/plataforma/pages/forms/general.html
                  https://fixwei.com/plataforma/pages/forms/advanced.html
                  https://fixwei.com/plataforma/pages/forms/editors.html
                  
                  -->
                  
                  
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                    <!--Envio variables ocultas-->
                    
                    <input autocomplete="off" type="hidden" name="rol" value="<?php echo $rol;?>"> 
                    <input autocomplete="off" type="hidden" name="idSolicitud" id="idSolicitudAlerta" value="<?php echo $idSolicitud ;?>" >
                    <input autocomplete="off" type="hidden" name="nombreDocumento" value="<?php echo $nombreDoc ;?>" >
                    
                    <input autocomplete="off" type="hidden" name="proceso" value="<?php echo $proceso ;?>" >
                    <input autocomplete="off" type="hidden" name="rad_metodo" value="<?php echo $metodo ;?>" >
                    <input autocomplete="off" type="hidden" name="tipoDoc" value="<?php echo $tipoDoc ;?>" >
                    <input autocomplete="off" type="hidden" name="ubicacion" value="<?php echo $ubicacion ;?>" >
                    
                    <?php
                    if($_POST['alerta'] != NULL){
                    ?>
                    <input autocomplete="off" type="hidden" name="select_encargadoE" value='<?php echo $_POST['select_encargadoERT'];?>' >
                    <input autocomplete="off" type="hidden" name="select_encargadoR" value='<?php echo $_POST['select_encargadoRRT'];?>' >
                    <input autocomplete="off" type="hidden" name="select_encargadoA" value='<?php echo $_POST['select_encargadoART'];?>' >
                    <input autocomplete="off" type="hidden" name="norma" value='<?php echo $_POST['normaRT']; ?>' >
                    <?php
                    }else{
                    ?>
                    <input autocomplete="off" type="hidden" name="norma" value='<?php echo serialize($norma);?>' >
                    <input autocomplete="off" type="hidden" name="select_encargadoE" value='<?php echo serialize($elabora) ;?>' >
                    <input autocomplete="off" type="hidden" name="select_encargadoR" value='<?php echo serialize($revisa) ;?>' >
                    <input autocomplete="off" type="hidden" name="select_encargadoA" value='<?php echo serialize($aprueba) ;?>' >
                    <?php
                    }
                    ?>
                    <input autocomplete="off" type="hidden" name="radCodificacion" value="<?php echo $codificacion;?>">
                    <input autocomplete="off" type="hidden" name="radCodificacion" value="<?php echo $codificacion;?>">
                    <input autocomplete="off" type="hidden" name="versionDeclarada" value="<?php echo $versionDeclarada;?>">
                    <input autocomplete="off" type="hidden" name="consecutivoDeclarado" value="<?php echo $consecutivoDeclarada;?>">
                    
                    <input autocomplete="off" type="hidden" name="radiobtnE" value="<?php echo $radElabora; ?>">
                    <input autocomplete="off" type="hidden" name="radiobtnR" value="<?php echo $radRevisa; ?>">
                    <input autocomplete="off" type="hidden" name="radiobtnA" value="<?php echo $radAprueba; ?>">
                    
                    
                  <button  type="submit" name="agregarDoc" class="btn btn-success float-right">Siguiente >></button>
                  <!-- id="validarOcultar" -->
                  <style>
                                .preloader {
                                    width: 70px;
                                    height: 70px;
                                    border: 10px solid #eee;
                                    border-top: 10px solid #666;
                                    border-radius: 50%;
                                    animation-name: girar;
                                    animation-duration: 2s;
                                    animation-iteration-count: infinite;
                                    animation-timing-function: linear;
                                    }
                                    @keyframes girar {
                                    from {
                                        transform: rotate(0deg);
                                    }
                                    to {
                                        transform: rotate(360deg);
                                    }
                                    }
                            </style> 
                            <div id="cargando" class="preloader float-right" style="display:none;"></div>
                            <script>
                                $(document).ready(function(){
                                    $('#validarOcultar').click(function(){
                                        document.getElementById('cargando').style.display = '';
                                        document.getElementById('validarOcultar').style.display = 'none';
                                    });
                                });
                            </script>
                </div>
              </form>
            </div>
            </div>    

<?php
if($_POST['alerta'] != NULL){
?>
                        <script>
                            $(document).ready(function() {
                              // indicamos que se ejecuta la funcion a los 5 segundos de haberse
                              // cargado la pagina
                              setTimeout(clickbutton, 0000);
                            
                              function clickbutton() {
                                // simulamos el click del mouse en el boton del formulario
                                $("#action-button-bloqueado").click();
                                //alert("Aqui llega"); //Debugger
                              }
                              $('#action-button-bloqueado').on('click',function() {
                               // console.log('action');
                              });
                            });
                       </script> 
                       <button id="action-button-bloqueado" style="display:none;" data-toggle="modal" data-target='#modal-danger-alerta-Bloqueo'></button>
                    
                        <div class="modal fade" id="modal-danger-alerta-Bloqueo">
                            <div class="modal-dialog">
                              <div class="modal-content bg-danger">
                                <div class="modal-header">
                                  <h4 class="modal-title">Alerta</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>El nombre del archivo contiene caracteres inválidos, por favor digite el nombre completo del archivo e intente cargar.</p>
                                </div>
                                 <!-- END formulario para eliminar por el id -->
                              </div>
                            </div>
                        </div>
<?php
}

if($_POST['alerta2'] != NULL){
?>
                        <script>
                            $(document).ready(function() {
                              // indicamos que se ejecuta la funcion a los 5 segundos de haberse
                              // cargado la pagina
                              setTimeout(clickbutton, 0000);
                            
                              function clickbutton() {
                                // simulamos el click del mouse en el boton del formulario
                                $("#action-button-bloqueado").click();
                                //alert("Aqui llega"); //Debugger
                              }
                              $('#action-button-bloqueado').on('click',function() {
                               // console.log('action');
                              });
                            });
                       </script> 
                       <button id="action-button-bloqueado" style="display:none;" data-toggle="modal" data-target='#modal-danger-alerta-Bloqueo'></button>
                    
                        <div class="modal fade" id="modal-danger-alerta-Bloqueo">
                            <div class="modal-dialog">
                              <div class="modal-content bg-danger">
                                <div class="modal-header">
                                  <h4 class="modal-title">Alerta</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>El nombre del archivo contiene caracteres inválidos, por favor digite el nombre completo del archivo e intente cargar.</p>
                                </div>
                                 <!-- END formulario para eliminar por el id -->
                              </div>
                            </div>
                        </div>
<?php
}
?>


        <div class="col">
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
const $miInput2 = document.querySelector("#miInput2");

$miInput2.addEventListener("change", function () {
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
          timer: 5000
        });
    
    
        Toast.fire({
            type: 'warning',
            title: ` El tamaño máximo del archivo es de 10 MB`
        })
		// Limpiar
		$miInput2.value = "";
	} else {
		// Validación asada. Envía el formulario o haz lo que tengas que hacer
	}
});
</script>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
            var rad_postAlerta = document.getElementById("idSolicitudAlerta").value;
            var grupo = radios[i].value;
            var envioAlertaNombre = "envioAlertaNombre";
            
            //alert(rad_postAlerta);
            
            $.post("selectDocumentos2.php", { rad_postAlerta: rad_postAlerta, grupo: grupo, envioAlertaNombre: envioAlertaNombre}, function(data){
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
<!-- bs-custom-file-input -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>

<script type="text/javascript">
  $(function() {
    
    
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