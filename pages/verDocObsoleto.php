<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
require 'conexion/bd.php';

$idDocumento = $_POST['idDocumento'];
$queryDoc = $mysqli->query("SELECT * FROM documento WHERE id = $idDocumento")or die(mysqli_error($mysqli));
$datosDoc = $queryDoc->fetch_assoc();

?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - DOCUMENTO OBSOLETO</title>
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
            <h1>Documentos Obsoletos</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Documentos Obsoletos</li>
            </ol>
          </div>
        </div>
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-10">
                    <div class="row">
                        <div class="col-sm">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="documentosObsoletos"><font color="white"><i class="fas fa-list"></i> Documentos Obsoletos</font></a></button>
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
                
           
            </div>
        <div>

        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <!-- TABLA PERMISOS-->
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-10">
                    <!-- Default box -->
                    <form action="controlador/controllerPermisos.php" method="POST"> 
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Información del documento</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          <?php
                            require_once 'conexion/bd.php';
                            //$acentos = $mysqli->query("SET NAMES 'utf8'");
                            $data = $mysqli->query("SELECT permisos.listar, permisos.crear, permisos.editar, permisos.eliminar, permisos.formulario, formularios.* FROM formularios INNER JOIN permisos WHERE formularios.modulo = 'config' AND permisos.formulario =formularios.idFormulario AND permisos.idGrupo = '$idGrupo' ORDER BY formularios.orden");
                          ?>
                          <div class="card-body">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Nombre del documento: </label>
                                    <span><?php echo $datosDoc['nombres']?></span>
                                    
                                    <input value="<?php echo $datosDoc['nombres']?>" type="text" class="form-control" name="nombreDocumento" placeholder="Nombre del documento" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Proceso:</label>
                                    <?php
                                        require_once'conexion/bd.php';
                                        $resultado=$mysqli->query("SELECT * FROM procesos ORDER BY nombre");
                                    ?>
                                    <select type="text" class="form-control" id="descripcion" name="proceso" placeholder="Proceso" required>
                                        <option value=''>Seleccionar proceso</option>
                                        <?php
                                        while ($columna = mysqli_fetch_array( $resultado )) { 
                                            if($datosDoc['proceso'] == $columna['id']){
                                                $selecPro = "selected";
                                            }else{
                                                $selecPro = "";
                                            }
                                        ?>
                                        <option value="<?php echo $columna['id']; ?>" <?php echo $selecPro; ?>><?php echo $columna['nombre']; ?> </option>
                                        <?php }  ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <?php
                                        require_once'conexion/bd.php';
                                        $resultado=$mysqli->query("SELECT * FROM normatividad");
                                        $arrayNormas = json_decode($datosDoc['norma']);
                                    ?>
                                    <label>Norma: </label>
                                      <select class="duallistbox" name="norma[]" multiple>
                                        <?php
                                            while ($columna = mysqli_fetch_array( $resultado )) { 
                                                if(in_array($columna['id'],$arrayNormas)){
                                                    $seleccionarNorm = "selected";        
                                                }else{
                                                    $seleccionarNorm ="";
                                                }
                                            ?>
                                            <option value="<?php echo $columna['id']; ?>" <?php echo $seleccionarNorm; ?>><?php echo $columna['nombre']; ?> </option>
                                        <?php }  ?>
                                      </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <?php
                                        
                                        if($datosDoc['metodo'] == "html"){
                                            $checkHTML = "checked";
                                            $disabledDoc = "disabled";
                                        }else{
                                            $checkDoc = "checked";
                                            $disabledHtml = "disabled";
                                        }
                                        
                                    ?>
                                    <label>Método de creación: </label><br>
                                    <div class="custom-control custom-radio">
                                      <input class="custom-control-input" type="radio" id="customRadio1" name="rad_metodo" value="documento" <?php echo $checkDoc; echo $disabledDoc; ?>>
                                      <label for="customRadio1" class="custom-control-label">Documento (PDF, WORD, EXCEL, AUTOCAD)</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                      <input class="custom-control-input" type="radio" id="customRadio2" name="rad_metodo" value="html" <?php echo $checkHTML; echo $disabledHtml; ?>>
                                      <label for="customRadio2" class="custom-control-label">Edicion HTML</label>
                                    </div>
                                    
                                    <div>
                                        <label>Tipo documeno:</label>
                                        <?php
                                            require_once'conexion/bd.php';
                                            //$acentos = $mysqli->query("SET NAMES 'utf8'");
                                            $resultado=$mysqli->query("SELECT * FROM tipoDocumento ORDER BY nombre");
                                        ?>
                                        <select type="text" class="form-control" id="descripcion" name="tipoDoc" placeholder="" required>
                                            <option value=''>Seleccionar tipo documento</option>
                                            <?php
                                            while ($columna = mysqli_fetch_array( $resultado )) {
                                                if($datosDoc['tipo_documento'] == $columna['id']){
                                                    $selectTipoDoc = "selected";
                                                }else{
                                                    $selectTipoDoc = "";
                                                }
                                            ?>
                                            <option value="<?php echo $columna['id']; ?>"  <?php echo $selectTipoDoc; ?>><?php echo $columna['nombre']; ?> </option>
                                            <?php }  ?>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label>Ubicación: </label>
                                        <input value="<?php echo $datosDoc['ubicacion']; ?>" type="text" class="form-control" name="ubicacion" placeholder="Ubicación" >
                                    </div>
                                </div>
        
                            </div>
                            
                            <?php
                            //aca voy a validar si son usuarios o cargos los que se encargan de elaborar, revisar, aprobar            
                            
                                $elabora = json_decode($datosDoc['elabora']);
                                $revisa = json_decode($datosDoc['revisa']);
                                $aprueba = json_decode($datosDoc['aprueba']);
                                
                                if($elabora[0] == 'cargos'){
                                    $checkedCElabora = "checked";            
                                }
                                
                                if($elabora[0] == 'usuarios'){
                                    $checkedUElabora = "checked"; 
                                }
                                
                                if($revisa[0] == 'cargos'){
                                    $checkedCRevisa = "checked";            
                                }
                                
                                if($revisa[0] == 'usuarios'){
                                    $checkedURevisa = "checked"; 
                                }
                                
                                if($aprueba[0] == 'cargos'){
                                    $checkedCAprueba = "checked";            
                                }
                                
                                if($aprueba[0] == 'usuarios'){
                                    $checkedUAprueba = "checked"; 
                                }
                                
                            ?>
                            
                            
                            
                            <div class="row" >
                                <div class="form-group col-sm-6">
                                    <label>Quién elabora: </label><br>
                                    <input type="radio" id="rad_cargoE" name="radiobtnE" value="cargos" <?php echo $checkedCElabora;?> >
                                    <label for="cargo">Cargo</label>
                                    <input type="radio" id="rad_usuarioE" name="radiobtnE" value="usuarios" <?php echo $checkedUElabora;?> >
                                    <label for="usuarios">Usuarios</label>
                                    <div class="select2-blue">
                                        <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoE[]" id="select_encargadoE" ></select>
                                    </div>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label>Quién revisa: </label><br>
                                    <input type="radio" id="rad_cargoR" name="radiobtnR" value="cargos" <?php echo $checkedCRevisa;?>>
                                    <label for="cargo">Cargo</label>
                                    <input type="radio" id="rad_usuarioR" name="radiobtnR" value="usuarios" <?php echo $checkedURevisa;?>>
                                    <label for="usuarios">Usuarios</label>
                                    <div class="select2-blue">
                                        <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoR[]" id="select_encargadoR" ></select>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Quién aprueba: </label><br>
                                    <input type="radio" id="rad_cargoA" name="radiobtnA" value="cargos" <?php echo $checkedCAprueba;?>>
                                    <label for="cargo">Cargo</label>
                                    <input type="radio" id="rad_usuarioA" name="radiobtnA" value="usuarios" <?php echo $checkedUAprueba;?>>
                                    <label for="usuarios">Usuarios</label>
        
                                    
                                    <div class="select2-blue">
                                        <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoA[]" id="select_encargadoA" ></select>
                                    </div>
                                    
                                    
                                    
                                    
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-sm-6">
                                <?php
                                    require_once'conexion/bd.php';
                                    $resultado=$mysqli->query("SELECT id, nombre FROM documentoExterno");
                                    $arrayDocE = json_decode($datosDoc['documento_externo']);
                                ?>
                                <label>Documentos externos: </label>
                                  <select class="duallistbox" name="documentos_externos[]" multiple >
                                    <?php
                                        while ($columna = mysqli_fetch_array( $resultado )) {
                                            if(in_array($columna['id'],$arrayDocE)){
                                                $seleccionarDocE = "selected";        
                                            }else{
                                                $seleccionarDocE ="";
                                            }
                                        ?>
                                        <option value="<?php echo $columna['id']; ?>" <?php echo $seleccionarDocE; ?>><?php echo $columna['nombre']; ?> </option>
                                    <?php }  ?>
                                  </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <?php
                                    require_once'conexion/bd.php';
                                    $resultado=$mysqli->query("SELECT id, nombre FROM definicion");
                                    $arrayDefiniciones = json_decode($datosDoc['definiciones']);
                                ?>
                                <label>Definiciones: </label>
                                  <select class="duallistbox" name="definiciones[]" multiple >
                                    <?php
                                        while ($columna = mysqli_fetch_array( $resultado )) { 
                                            if(in_array($columna['id'],$arrayDocE)){
                                                $seleccionarDef = "selected";        
                                            }else{
                                                $seleccionarDef ="";
                                            }
                                        ?>
                                        <option value="<?php echo $columna['id']; ?>" <?php echo $seleccionarDef; ?>><?php echo $columna['nombre']; ?> </option>
                                    <?php }  ?>
                                  </select>
                            </div>
    
    
                            <div class="form-group col-sm-6">
                                <label>Archivo en gestión: </label>
                                <input value="<?php echo $datosDoc['archivo_gestion'];?>" type="text" class="form-control" name="archivo_gestion" placeholder="Archivo en gestión" required>
                                    <br>
                                <label>Archivo central: </label>
                                <input value="<?php echo $datosDoc['archivo_central'];?>" type="text" class="form-control" name="archivo_central" placeholder="Archivo central" required>
                                    <br>
                                <label>Archivo histórico: </label>
                                <input value="<?php echo $datosDoc['archivo_historico'];?>"type="text" class="form-control" name="archivo_historico" placeholder="Archivo histórico" required>
                                
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <?php
                                    //aca voy a validar si son usuarios o cargos los que se encargan de elaborar, revisar, aprobar            
                                    
                                       $resposableDispoDoc = json_decode($datosDoc['responsable_disposicion']);
                            
                            
                                        if($resposableDispoDoc[0] == 'cargos'){
                                            $checkedDispoC = "checked";            
                                        }
                                        
                                        if($resposableDispoDoc[0] == 'usuarios'){
                                            $checkedDispoU = "checked"; 
                                        }
    
                                        
                                ?>
                                
                                <label>Disposición Documental: </label>
                                <textarea rows="3" class="form-control" name="diposicion_documental" placeholder="Disposición Documental" required><?php echo $datosDoc['disposicion_documental'];?></textarea>
                                <br>
                                <label>Responsable de disposición: </label><br>
                                    <input type="radio" id="rad_cargoD" name="radiobtnD" value="cargos" <?php echo $checkedDispoC;?> >
                                    <label for="cargo">Cargo</label>
                                    <input type="radio" id="rad_usuarioD" name="radiobtnD" value="usuarios" <?php echo $checkedDispoU;?> >
                                    <label for="usuarios">Usuarios</label>
        
                                    
                                    <div class="select2-blue">
                                        <select class="select2" multiple="multiple" data-placeholder="Seleccionar encargado" style="width: 100%;" name="select_encargadoD[]" id="select_encargadoD" required></select>
                                    </div>
                            </div>    
                            </div>
                            
                            
                               
                               
                               
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              
                          </div>
                          <!-- /.card-footer-->
                        </div>
                    </form>
                    <!-- /.card -->
                  </div>
                  <div class="col"></div>
                </div>
        </div>
    </section>
    <!-- TABLA PERMISOS-->
    
    
    <?php
        if($datosDoc['metodo'] == "documento"){
    ?>
    <!-- TABLA PERMISOS-->
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-10">
                    <!-- Default box -->
                    <form action="controlador/controllerPermisos.php" method="POST"> 
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Documento</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          <?php
                                    $nombrePDF = $datosDoc['nombrePDF'];
                                ?>
                          <div class="card-body">
                              <div id="example1"></div>
                                
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              
                          </div>
                          <!-- /.card-footer-->
                        </div>
                    </form>
                    <!-- /.card -->
                  </div>
                  <div class="col"></div>
                </div>
        </div>
    </section>
    <?php } ?>
    <!-- TABLA PERMISOS-->
    
    <?php
        if($datosDoc['metodo'] == "html"){
    ?>
    
    <!-- TABLA HTML-->
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-10">
                    <!-- Default box -->
                    <form action="controlador/controllerPermisos.php" method="POST"> 
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Documento HTML</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          <div class="card-body">
                            <textarea name="editor1" required><?php echo $datosDoc['htmlDoc']; ?></textarea>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              
                          </div>
                          <!-- /.card-footer-->
                        </div>
                    </form>
                    <!-- /.card -->
                  </div>
                  <div class="col"></div>
                </div>
        </div>
    </section>
    <?php } ?>
    <!-- TABLA HTML-->
    
    
    <!-- TABLA CONTROL DE CAMBIOS-->
    <section class="content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col"></div>
                  <div class="col-10">
                    <!-- Default box -->
                    <form action="controlador/controllerPermisos.php" method="POST"> 
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Control de cambios</h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          <div class="card-body">
                            <div style="padding: 20px;" class="tab-pane" id="timeline">
                                        <!-- The timeline -->
                                        <div class="timeline timeline-inverse">
                                          <!-- timeline time label -->
                                          <?php 
                                            $idSol = $datosDoc['id_solicitud'];
                                            $queryControl = $mysqli->query("SELECT * FROM controlCambios WHERE idDocumento = $idSol")or die(mysqli_error($mysqli));
                                            
                                            while($row = $queryControl->fetch_assoc()){
                                                $idUser = $row['idUsuario'];
                                                $queryUser = $mysqli->query("SELECT * FROM usuario WHERE cedula = $idUser ")or die(mysqli_error($mysqli));
                                                $datosUser = $queryUser->fetch_assoc();

                                                $nombreUsuario = $datosUser['nombres']." ".$datosUser['apellidos'];
                                          ?>
                                          
                                          <div class="time-label">
                                            <span class="bg-danger">
                                              <?php echo $row['fecha']?>
                                            </span>
                                          </div>

                                          <div>
                                            <i class="fas fa-user bg-info"></i>
                    
                                            <div class="timeline-item">
                                              
                                              <h3 class="timeline-header border-0"><a href="#"><?php echo $nombreUsuario?></a> <?php echo $row['comentario']?>
                                              </h3>
                                            </div>
                                          </div>
                                        <?php }?>
                                        </div>
                                     </div>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                              
                          </div>
                          <!-- /.card-footer-->
                        </div>
                    </form>
                    <!-- /.card -->
                  </div>
                  <div class="col"></div>
                </div>
        </div>
    </section>
    <!-- TABLA TABLA CONTROL DE CAMBIOS--->
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
<script>PDFObject.embed("archivos/documentos/<?php echo $nombrePDF;?>", "#example1");</script>

</body>
</html>
<?php
}
?>