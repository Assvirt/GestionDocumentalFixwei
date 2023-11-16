<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
$ruta = $_POST['rutaSubir'];

?>
<?php
    $var = $_POST['rutaEditar'];
    $var2 = $_POST["nombre"];
    if($var2 == null){
            
            
            //echo '<script language="javascript">alert("Para editar elija un archivo o carpeta");
            //window.location.href="repositorio.php"</script>';
            ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="repositorio" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExisteF" value="1">
                <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $var;?>">
            </form> 
            <?php
        }else{


     //////////////// ARCHIVOS
    $varArchivo =$var2;
    $explorando=explode(".",$varArchivo);
    $enviarSinExtension= $explorando[0];
    $enviarConExtension= $explorando[1];                                       


    if($enviarConExtension){
        
        //echo "archivo";
        
    
    
    
    //var_dump($enviarConExtension);

?>
<!DOCTYPE html>
<html>
<head><meta charset="gb18030">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Editar Registros</title>
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
  <link rel="stylesheet" href="../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
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
            <h1>Editar Registro</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Editar Registro</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col-sm-3">
                            <form action="repositorio.php" method="POST">
                                <button type="submit" class="btn btn-primary float-left btn-sm" name=""><i class="fa fa-arrow-left"></i></button>
                                <input type="hidden" value="<?php echo $var;?>" name='verCarpetaCreada'>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col">
                    
                </div>
                
           
            </div>
        </div>
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
                <?php
    
    
                   
                
                    //echo "ruta : ".$var." nombre archivo: ".$var2;
                    // $explorando=explode(".",$var2);
                    //$enviarSinExtension= $explorando[0];
                    //$Extension = $explorando[1];
                     

                     //var_dump($enviarSinExtension);
                     
                     
                    // $info = new SplFileInfo($var2);
                    //var_dump($info->getExtension());
                    //$extension = $info->getExtension();
                    //echo "nombre sin extension ".$enviarSinExtension." la extension es :".$enviarConExtension." y la ruta es :".$var;
                    
                    
                    
                    $trearData = $mysqli->query("SELECT * FROM repositorioRegistro WHERE nombre ='$enviarSinExtension' AND extension='$enviarConExtension' AND ruta='$var'  ");
                    $datos = $trearData->fetch_array(MYSQLI_ASSOC);
                    $nombre  = $datos["nombre"];
                    $idDoc = $datos["idDocumento"];
                    $idProc = $datos["idProceso"];
                    $tipoDoc = $datos["idTipoDoc"];
                    $centroT = json_decode($datos["idCentroTrabajo"]);
                    $visualizar = $datos["visualizar"];
                    $idVisual = json_decode($datos["visualizarID"]);
                    $fecha = $datos["fechaCreacion"];
                    
                    if($visualizar == 'usuario'){
                        $checkedU='checked';
                        $habilitarU='';
                        $habilitarC='none';
                        $habilitarG='none';
                    }else{
                        $checkedU='';
                    }
                    if($visualizar == 'cargo'){
                        $checkedC='checked';
                        $habilitarU='none';
                        $habilitarC='';
                        $habilitarG='none';
                    }else{
                        $checkedC='';
                    }
                    if($visualizar == 'grupo'){
                        $checkedG='checked';
                        $habilitarU='none';
                        $habilitarC='none';
                        $habilitarG='';
                    }else{
                        $checkedG='';
                    }
                    //echo "nombre de documento".$nombre."fecha ".$fecha;
                    //var_dump($centroT);

                    
                    //echo "nombre de CT".$nombreCT; 
                ?>
                
                <div class="card card-primary">

              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/registros/controller.php" method="POST" enctype="multipart/form-data">
                  <input name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden">
                <div class="card-body">
                    
                    <div class="form-group">
                        <label>¿El registro esta asociado a un documento? </label><br>
                        <?php
                            if($idDoc != null){
                        ?>
                            
                            <input type="radio" id="rad_si1" name="radiobtn1" value="si" checked  readonly>
                            <label for="cargo">Si</label>
                            
                           
                                <div class="form-group">
                                    <label>Proceso:</label>
                                    <br>
                                    
                                    <?php
                                    $resultadoP = $mysqli->query("SELECT * FROM procesos where id = '$idProc' ");
                                    $datoP = $resultadoP->fetch_array(MYSQLI_ASSOC);
                                    echo $datoP["nombre"]."<br>";
            				        ?>
                                    
                                </div>
                                
                                <div class="form-group">
                                    <label>Tipo de documento:</label>
                                    <br>
                                    <?php
                                    $resultadoT = $mysqli->query("SELECT * FROM tipoDocumento where id = '$tipoDoc' ");
                                    $datoT = $resultadoT->fetch_array(MYSQLI_ASSOC);
                                    echo $datoT["nombre"]."<br>";
            				        ?>
                                </div>
                                
                                <div class="form-group">
                                    <label>Documento:</label>
                                    <br>
                                    <?php
                                    $resultadoD = $mysqli->query("SELECT * FROM documento where id = '$idDoc' ");
                                    $datoD = $resultadoD->fetch_array(MYSQLI_ASSOC);
                                    echo $datoD["nombres"]."<br>";
            				        ?>
                                </div>
                                
                                
                                
                           
                        <?php
                        }else{
                        ?>    
                            <input type="radio" id="rad_no1" name="radiobtn1" value="no" checked  readonly>
                            <label for="usuarios">No</label>
                        <?php
                        }
                        ?>   
                            
                    </div>
                    
                    <div class="form-group">
                            <label>Centro de trabajos:</label>
                                   
                                    <div class="select2-blue" readonly>
                                        
                                        <?php
                                        
                                        foreach($centroT as $key =>$value){
                                            $resultadoCT = $mysqli->query("SELECT id_centrodetrabajo, nombreCentrodeTrabajo FROM centrodetrabajo where id_centrodetrabajo = '$value' ");
                                            $dato = $resultadoCT->fetch_array(MYSQLI_ASSOC);
                                            echo $dato["nombreCentrodeTrabajo"]."<br>";
                                           
                                        }
                                        ?>
                                      <!--<input type="text" class="form-control" id="" value="<?php //echo $nombreCT;?>"  readonly>-->
                                            
                                           
                              
                                    </div>
                                </div>
                    
                    <!--<label>Nombre:</label>-->
                    <div class="form-group row" style="display:none;">
                  
                        
                        <input autocomplete="off" type="text" class="form-control " id="" name="nombreArchivo" placeholder="<?php echo $nombre;?>" value="<?php echo $nombre;?>" required pattern="[a-zA-Z0-9á-úñ-ZA ]{1,205}" title="No utilice caracteres especiales" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)"/>
                        
                    </div>
                    
                    
                     
                    <div class="form-group">
                        <label>Documento:</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="exampleInputFile" name="archivo" accept=".xls,.xlsx,.docx,.doc,.pdf, .png, .jpg, .jpeg"   >
                            <label class="custom-file-label" for="exampleInputFile">Seleccionar archivo</label>
                        </div>
                        <br><br>
                         
                        <button type="button" style="width:15%;"  class='btn btn-block btn-warning btn-sm'>
                                <i class="fas fa-download"></i>
                                <a style="color:black" href="<?php echo $var.$var2;?>" download="" target="_blank">Descargar</a>
                        </button>
                    </div>

                    
                    
                    <div class="form-group ">
                        <label>Autorizados para Visualizar: </label><br>
                            <input type="radio" id="rad_cargoAut" name="radiobtnAut" value="cargo" <?php echo $checkedC;?> >
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioAut" name="radiobtnAut" value="usuario" <?php echo $checkedU;?> >
                            <label for="usuarios">Usuarios</label>
                            <input type="radio" id="rad_grupoAut" name="radiobtnAut" value="grupo" <?php echo $checkedG;?>>
                            <label for="grupos">Grupos</label>
                            
                            <div class="select2-blue" id="listarCargos" style="display:<? echo $habilitarC;?>;">
                                
                                <label></label>
                                <!--  <select class="duallistbox" id="select_encargadoAut" name="select_encargadoAut[]" multiple="multiple">
                                   
                                </select>
                                    <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar aprobador" style="width: 100%;" name="select_encargadoAut[]" id="select_encargadoAut" required></select>
                            -->
                                <?php
                                if($visualizar == 'cargo'){
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $consultaCargos=$mysqli->query("SELECT * FROM cargos order by nombreCargos ASC");
                                $idVisualCargos = json_decode($datos["visualizarID"]);
                                ?>
                                <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar..." style="width: 100%;" name="select_encargadoAut[]"  >
                                    <?php
                                    while($extraerCargos=$consultaCargos->fetch_array()){
                                        if(in_array($extraerCargos['id_cargos'],$idVisualCargos)){
                                                            $seleccionarCtV = "selected";        
                                                        }else{
                                                            $seleccionarCtV ="";
                                                        }
                                    ?>
                                    <option value="<?php echo $extraerCargos['id_cargos']; ?>" <? echo $seleccionarCtV;?> ><?php echo $extraerCargos['nombreCargos']; ?></option>
                                    <?php
                                    }
                                 }
                                    ?>
                                </select>
                            </div>
                            <div class="select2-blue" id="listarUsuarios" style="display:<? echo $habilitarU;?>;">
                                
                                <label></label>
                                <!--  <select class="duallistbox" id="select_encargadoAut" name="select_encargadoAut[]" multiple="multiple">
                                   
                                </select>
                                    <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar aprobador" style="width: 100%;" name="select_encargadoAut[]" id="select_encargadoAut" required></select>
                            -->
                                <?php
                                if($visualizar == 'usuario'){
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $consultaUsuarios=$mysqli->query("SELECT * FROM usuario Order by nombres ASC");
                                 $idVisualUsuario = json_decode($datos["visualizarID"]);
                                ?>
                                <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar..." style="width: 100%;" name="select_encargadoAut[]"  >
                                    <?php
                                    while($extraerUsuarios=$consultaUsuarios->fetch_array()){
                                         if(in_array($extraerUsuarios['id'],$idVisualUsuario)){
                                                            $seleccionarUsuarios = "selected";        
                                                        }else{
                                                            $seleccionarUsuarios ="";
                                                        }
                                    ?>
                                    <option value="<?php echo $extraerUsuarios['id']; ?>" <? echo $seleccionarUsuarios;?> ><?php echo $extraerUsuarios['nombres'].' '.$extraerUsuarios['apellidos']; ?></option>
                                    <?php
                                    }
                                 }
                                    ?>
                                </select>
                            </div>
                            <div class="select2-blue" id="listarGrupos" style="display:<? echo $habilitarG;?>;" required>
                                
                                <label></label>
                                <!--  <select class="duallistbox" id="select_encargadoAut" name="select_encargadoAut[]" multiple="multiple">
                                   
                                </select>
                                    <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar aprobador" style="width: 100%;" name="select_encargadoAut[]" id="select_encargadoAut" required></select>
                            -->
                                <?php
                                if($visualizar == 'grupo'){
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $consultaGrupo=$mysqli->query("SELECT * FROM grupo Order by nombre ASC");
                                 $idVisualGrupo = json_decode($datos["visualizarID"]);
                                ?>
                                <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar..." style="width: 100%;" name="select_encargadoAut[]"  >
                                    <?php
                                    while($extraerGrupo=$consultaGrupo->fetch_array()){
                                        if(in_array($extraerGrupo['id'],$idVisualGrupo)){
                                                            $seleccionarGrupos = "selected";        
                                                        }else{
                                                            $seleccionarGrupos ="";
                                                        }
                                    ?>
                                    <option value="<?php echo $extraerGrupo['id']; ?>" <? echo $seleccionarGrupos;?> ><?php echo $extraerGrupo['nombre']; ?></option>
                                    <?php
                                    }
                                }
                                    ?>
                                </select>
                            </div>
                      </div>
                    
     

                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                    <input type="hidden" name="ruta" value="<?php echo $var;?>">
                    <input type="hidden" name="nombreAntes" value="<?php echo $enviarSinExtension;?>">
                    <input type="hidden" name="extension" value="<?php echo $enviarConExtension;?>">
                  
                    <input type="hidden" name="var" value="<?php echo $var;?>">
                    <input type="hidden" name="var2" value="<?php echo $var2;?>">
                      <input type="hidden" value="<?php echo $var;?>" name='verCarpetaCreada'>
                  
                  
                  <button type="submit" class="btn btn-primary float-right" name="editarRegistro">Editar Registro</button>
                </div>
              </form>
            </div>
            </div>    

        <div class="col">
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
?>
        
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
<!--Ocultar divs documentos-->
<script>
    $(document).ready(function(){
        $('#rad_si1').click(function(){
            document.getElementById('registros_documento').style.display = '';
        });
        $('#rad_no1').click(function(){
            document.getElementById('registros_documento').style.display = 'none';
        });
    });
</script>
<!--Oculta div-->
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
<!--Select dinamico-->
<script>
    $(document).ready(function(){
        $('#rad_cargoE').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoR").html(data);
            }); 
        });
        $('#rad_usuarioE').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoR").html(data);
            }); 
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoEs').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoV").html(data);
            }); 
        });
        $('#rad_usuarioEs').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoV").html(data);
            }); 
        });
        $('#rad_grupoEs').click(function(){
            rad_grupo = "grupo";
            $.post("selectDocumentos2.php", { rad_grupo: rad_grupo }, function(data){
                $("#select_encargadoV").html(data);
            }); 
        });
    });
</script>

<script language="javascript">
			$(document).ready(function(){
				$("#cbx_cedi").change(function () {

					$('#cbx_posicion').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
					
					$("#cbx_cedi option:selected").each(function () {
						id_cedi = $(this).val();
						$.post("selectDinamico2.php", { id_cedi: id_cedi }, function(data){
							$("#cbx_bodega").html(data);
						});            
					});
				})
			});
			
			$(document).ready(function(){
				$("#cbx_bodega").change(function () {
					$("#cbx_bodega option:selected").each(function () {
						id_bodega = $(this).val();
						$.post("selectDinamico3.php", { id_bodega: id_bodega, id_cedi: id_cedi }, function(data){
							$("#cbx_posicion").html(data);
						});           
					});
				})
			});
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoAut').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoAut").html(data);
            }); 
        });
        $('#rad_usuarioAut').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoAut").html(data);
            }); 
        });
        $('#rad_grupoAut').click(function(){
            rad_grupo = "grupo";
            $.post("selectDocumentos2.php", { rad_grupo: rad_grupo }, function(data){
                $("#select_encargadoAut").html(data);
            }); 
        });
    });
</script>
<script>
        $(document).ready(function(){
            $('#rad_cargoAut').click(function(){
                document.getElementById('listarCargos').style.display = '';
                document.getElementById('listarUsuarios').style.display = 'none';
                document.getElementById('listarGrupos').style.display = 'none';
            });
            $('#rad_usuarioAut').click(function(){
                document.getElementById('listarCargos').style.display = 'none';
                document.getElementById('listarUsuarios').style.display = '';
                document.getElementById('listarGrupos').style.display = 'none';
               
            });
            $('#rad_grupoAut').click(function(){
                document.getElementById('listarCargos').style.display = 'none';
                document.getElementById('listarUsuarios').style.display = 'none';
                document.getElementById('listarGrupos').style.display = '';
               
            });
});
</script>

</body>
</html>

<?php
    }else{
        
?>
<!DOCTYPE html>
<html>
<head><meta charset="gb18030">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Editar Carpetas</title>
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
  <link rel="stylesheet" href="../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
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
            <h1>Editar Carpeta</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Editar Carpeta</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="repositorio.php"><font color="white"><i class="fas fa-list"></i> Repositorio </font></a></button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    
                </div>
                
           
            </div>
        </div>
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

              <!-- /.card-header -->
              <!-- form start -->
              <?php
                    $trearData = $mysqli->query("SELECT * FROM repositorioCarpeta WHERE nombre ='$var2'   ");
                    $datos = $trearData->fetch_array(MYSQLI_ASSOC);
                    $nombre  = $datos["nombre"];
                    $visualizarB = $datos["visualizar"];
                    if($visualizarB == 'usuario'){
                        $checkedU='checked';
                        $habilitarU='';
                        $habilitarC='none';
                        $habilitarG='none';
                    }else{
                        $checkedU='';
                    }
                    if($visualizarB == 'cargo'){
                        $checkedC='checked';
                        $habilitarU='none';
                        $habilitarC='';
                        $habilitarG='none';
                    }else{
                        $checkedC='';
                    }
                    if($visualizarB == 'grupo'){
                        $checkedG='checked';
                        $habilitarU='none';
                        $habilitarC='none';
                        $habilitarG='';
                    }else{
                        $checkedG='';
                    }
              ?>
                  
                <div class="card-body">
                    <form role="form" action="controlador/repositorio/controllerRepositorio" method="POST" enctype="multipart/form-data">
                    
                        <div class="form-group">
                    
                        <label>Nombre Editar:</label>
                        <input autocomplete="off" type="text" class="form-control "  name="nombreCarpeta" placeholder="<?php echo $nombre;?>" value="<?php echo $nombre;?>" required pattern="[a-zA-Z0-9á-úñ ]{1,205}" title="No utilice caracteres especiales" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" />
                        </div>
                        
                        <div class="form-group ">
                        <label>Autorizados para Visualizar: </label><br>
                            <input type="radio" id="rad_cargoAut" name="radiobtnAut" value="cargo" <?php echo $checkedC;?> >
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioAut" name="radiobtnAut" value="usuario" <?php echo $checkedU;?> >
                            <label for="usuarios">Usuarios</label>
                            <input type="radio" id="rad_grupoAut" name="radiobtnAut" value="grupo" <?php echo $checkedG;?> >
                            <label for="grupos">Grupos</label>
                            
                            <div class="select2-blue" id="listarCargos" style="display:<? echo $habilitarC;?>;">
                                
                                <label></label>
                                <!--  <select class="duallistbox" id="select_encargadoAut" name="select_encargadoAut[]" multiple="multiple">
                                   
                                </select>
                                    <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar aprobador" style="width: 100%;" name="select_encargadoAut[]" id="select_encargadoAut" required></select>
                            -->
                                 <?php
                                 if($visualizarB == 'cargo'){
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $consultaCargos=$mysqli->query("SELECT * FROM cargos order by nombreCargos ASC");
                                $idVisualCargosB = json_decode($datos["visualizarID"]);
                                ?>
                                <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar..." style="width: 100%;" name="select_encargadoAut[]"  >
                                    <?php
                                    while($extraerCargosB=$consultaCargos->fetch_array()){
                                        if(in_array($extraerCargosB['id_cargos'],$idVisualCargosB)){
                                                            $seleccionarCtVB = "selected";        
                                                        }else{
                                                            $seleccionarCtVB ="";
                                                        }
                                    ?>
                                    <option value="<?php echo $extraerCargosB['id_cargos']; ?>" <? echo $seleccionarCtVB;?> ><?php echo $extraerCargosB['nombreCargos']; ?></option>
                                    <?php
                                    }
                                 }
                                    ?>
                                </select>
                            </div>
                            <div class="select2-blue" id="listarUsuarios" style="display:<? echo $habilitarU;?>;">
                                
                                <label></label>
                                <!--  <select class="duallistbox" id="select_encargadoAut" name="select_encargadoAut[]" multiple="multiple">
                                   
                                </select>
                                    <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar aprobador" style="width: 100%;" name="select_encargadoAut[]" id="select_encargadoAut" required></select>
                            -->
                                <?php
                                if($visualizarB == 'usuario'){
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $consultaUsuariosB=$mysqli->query("SELECT * FROM usuario Order by nombres ASC");
                                 $idVisualUsuarioB = json_decode($datos["visualizarID"]);
                                ?>
                                <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar..." style="width: 100%;" name="select_encargadoAut[]"  >
                                    <?php
                                    while($extraerUsuariosB=$consultaUsuariosB->fetch_array()){
                                         if(in_array($extraerUsuariosB['id'],$idVisualUsuarioB)){
                                                            $seleccionarUsuariosB = "selected";        
                                                        }else{
                                                            $seleccionarUsuariosB ="";
                                                        }
                                    ?>
                                    <option value="<?php echo $extraerUsuariosB['id']; ?>" <? echo $seleccionarUsuariosB;?> ><?php echo $extraerUsuariosB['nombres'].' '.$extraerUsuariosB['apellidos']; ?></option>
                                    <?php
                                    }
                                 }
                                    ?>
                                </select>
                            </div>
                            <div class="select2-blue" id="listarGrupos" style="display:<? echo $habilitarG;?>;">
                                
                                <label></label>
                                <!--  <select class="duallistbox" id="select_encargadoAut" name="select_encargadoAut[]" multiple="multiple">
                                   
                                </select>
                                    <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar aprobador" style="width: 100%;" name="select_encargadoAut[]" id="select_encargadoAut" required></select>
                            -->
                                <?php
                                if($visualizarB == 'grupo'){
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $consultaGrupo=$mysqli->query("SELECT * FROM grupo Order by nombre ASC");
                                 $idVisualGrupoB = json_decode($datos["visualizarID"]);
                                ?>
                                <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar..." style="width: 100%;" name="select_encargadoAut[]"  >
                                    <?php
                                    while($extraerGrupoB=$consultaGrupo->fetch_array()){
                                        if(in_array($extraerGrupoB['id'],$idVisualGrupoB)){
                                                            $seleccionarGruposB = "selected";        
                                                        }else{
                                                            $seleccionarGruposB ="";
                                                        }
                                    ?>
                                    <option value="<?php echo $extraerGrupoB['id']; ?>" <? echo $seleccionarGruposB;?> ><?php echo $extraerGrupoB['nombre']; ?></option>
                                    <?php
                                    }
                                }
                                    ?>
                                </select>
                            </div>
                      </div>
                    <br>
                    <br>

                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                    <input type="hidden" name="ruta" value="<?php echo $var;?>">
                    <input type="hidden" name="nombre" value="<?php echo $var2;?>">
                  <button type="submit" class="btn btn-primary float-right" name="editarCarpeta">Editar Carpeta</button>
             </form> 
             </div>
              
            </div>
            </div>    

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

<script>
    $(document).ready(function(){
        $('#rad_si1').click(function(){
            document.getElementById('registros_documento').style.display = '';
        });
        $('#rad_no1').click(function(){
            document.getElementById('registros_documento').style.display = 'none';
        });
    });
</script>
<!--Oculta div-->
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
<!--Select dinamico-->
<script>
    $(document).ready(function(){
        $('#rad_cargoE').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoR").html(data);
            }); 
        });
        $('#rad_usuarioE').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoR").html(data);
            }); 
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoEs').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoV").html(data);
            }); 
        });
        $('#rad_usuarioEs').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoV").html(data);
            }); 
        });
        $('#rad_grupoEs').click(function(){
            rad_grupo = "grupo";
            $.post("selectDocumentos2.php", { rad_grupo: rad_grupo }, function(data){
                $("#select_encargadoV").html(data);
            }); 
        });
    });
</script>

<script language="javascript">
			$(document).ready(function(){
				$("#cbx_cedi").change(function () {

					$('#cbx_posicion').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
					
					$("#cbx_cedi option:selected").each(function () {
						id_cedi = $(this).val();
						$.post("selectDinamico2.php", { id_cedi: id_cedi }, function(data){
							$("#cbx_bodega").html(data);
						});            
					});
				})
			});
			
			$(document).ready(function(){
				$("#cbx_bodega").change(function () {
					$("#cbx_bodega option:selected").each(function () {
						id_bodega = $(this).val();
						$.post("selectDinamico3.php", { id_bodega: id_bodega, id_cedi: id_cedi }, function(data){
							$("#cbx_posicion").html(data);
						});           
					});
				})
			});
</script>

<script>
    $(document).ready(function(){
        $('#rad_cargoAut').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoAut").html(data);
            }); 
        });
        $('#rad_usuarioAut').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoAut").html(data);
            }); 
        });
        $('#rad_grupoAut').click(function(){
            rad_grupo = "grupo";
            $.post("selectDocumentos2.php", { rad_grupo: rad_grupo }, function(data){
                $("#select_encargadoAut").html(data);
            }); 
        });
    });
</script>
<script>
        $(document).ready(function(){
            $('#rad_cargoAut').click(function(){
                document.getElementById('listarCargos').style.display = '';
                document.getElementById('listarUsuarios').style.display = 'none';
                document.getElementById('listarGrupos').style.display = 'none';
            });
            $('#rad_usuarioAut').click(function(){
                document.getElementById('listarCargos').style.display = 'none';
                document.getElementById('listarUsuarios').style.display = '';
                document.getElementById('listarGrupos').style.display = 'none';
               
            });
            $('#rad_grupoAut').click(function(){
                document.getElementById('listarCargos').style.display = 'none';
                document.getElementById('listarUsuarios').style.display = 'none';
                document.getElementById('listarGrupos').style.display = '';
               
            });
});
</script>
 <script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
</body>
</html>

<?php
        }
    }
}
?>