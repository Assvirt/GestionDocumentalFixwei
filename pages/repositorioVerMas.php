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
        $var = $_POST["ruta"];
        $rutaPDF = $var;          
        $var2 = $_POST["nombre"];
      //var_dump($var2);             
        if($var2 == null){
            
            
           //echo '<script language="javascript">alert("Para visualizar carpeta solo haga click sobre ella");
            //window.location.href="repositorio.php"</script>';
            ?>
            <script> 
                 window.onload=function(){
               
                     document.forms["miformulario"].submit();
                 }
            </script>
             
            <form name="miformulario" action="repositorio" method="POST" onsubmit="procesar(this.action);" >
                <input type="hidden" name="validacionExisteE" value="1">
                <input type="hidden" name="verCarpetaCreada" value="<?PHP echo $var;?>">
            </form> 
            <?php
        }else{
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Cargar Registros</title>
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
            <h1>Ver Registro</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Ver Registro</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <div class="col">
                </div>
                <div class="col-10">
                    <div class="row">
                        
                        <div class="col sm-3">
                        
                        <form action="repositorio.php" method="POST">
                            <button type="submit" class="btn btn-primary float-left btn-sm" name=""><i class="fa fa-arrow-left"></i></button>
                            <input type="hidden" value="<?php echo $var;?>" name='verCarpetaCreada'>
                        </form>
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
            
                <?php
    
    
                   
                
                    //echo "ruta : ".$var." nombre archivo: ".$var2;
                    // $explorando=explode(".",$var2);
                    //$enviarSinExtension= $explorando[0];
                    //$Extension = $explorando[1];
                     
                     $varArchivo =$var2;
                     $explorando=explode(".",$varArchivo);
                     $enviarSinExtension= $explorando[0];
                     $enviarConExtension= $explorando[1];
                     //var_dump($enviarConExtension);
                     
                     
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
                    $idU = $datos["realiza"];
    
                    //echo "nombre de documento".$nombre."fecha ".$fecha;
                    //var_dump($centroT);

                    
                    //echo "nombre de CT".$nombreCT; 
                ?>
                <div class="col-10">
                    <div class="card card-primary">
    
                      <!-- /.card-header -->
                      <!-- form start -->
                      <form role="form" action="controlador/registros/controller.php" method="POST" enctype="multipart/form-data">
                          <input name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden">
                            <div class="card-body">
                                <div class="row">
                                
                                
                                    <div class="form-group col-sm-4">
                                        <label>Nombre del Archivo:</label><br>
                                        <?php echo $nombre;?>
                                        <!--<input type="text" class="form-control" id="" name="nombre" placeholder="" required readonly>-->
                                    </div>
                                    
                                    <div class="form-group col-sm-4">
                                        
                                        <?php
                                        $variable = false;
                                            if($idDoc == null){
                                               
                                                $variable = true;
                                                
                                            }
                                                
                                        ?>
                                                    <label>Proceso:</label>
                                                    <br>
                                                    
                                                    <?php
                                                    if($variable == false){
                                                    $resultadoP = $mysqli->query("SELECT * FROM procesos where id = '$idProc' ");
                                                    $datoP = $resultadoP->fetch_array(MYSQLI_ASSOC);
                                                    echo $variable1 = $datoP["nombre"]."<br>";
                                                    }else{
                                                        echo "N/A";
                                                    }
                            				        ?>
                            		 </div>
                                     <div class="form-group col-sm-4">               
                                               
                                                <!--    <label>Tipo de documento:</label>$fecha
                                                    <br>
                                                    < ?php
                                                    if($var == false){
                                                    $resultadoT = $mysqli->query("SELECT * FROM tipoDocumento where id = '$tipoDoc' ");
                                                    $datoT = $resultadoT->fetch_array(MYSQLI_ASSOC);
                                                    echo $datoT["nombre"]."<br>";
                                                    }else{
                                                        echo "N/A";
                                                    }
                            				        ?> -->
                            				        <label>Fecha de Cargue:</label>
                            				        <br>
                            				        <?php echo substr($fecha,0,-8);//$fecha; ?> 
                            				        
                                    </div>
                            </div>
                            
                                <div class="row">   
                                    
                                    <div class="form-group col-sm-4">
                                            
                            				        <label>Usuario de Cargue:</label>
                            				        <br>
                            				        <?
                            				        $resultadoD = $mysqli->query("SELECT * FROM usuario where id = '$idU' ");
                                                    $datoD = $resultadoD->fetch_array(MYSQLI_ASSOC);
                                                    echo $datoD["nombres"]." ".$datoD["apellidos"]."<br>";
                                                    $cargo = $datoD["cargo"];
                                                    $telefono = $datoD["telefono"];
                                                    ?>
                            				        
                                    </div>
                                    <div class="form-group col-sm-4">
                                            <!--    <label>Centro de trabajos:</label><br>
                                                       
                                                        
                                                            
                                                            < ?php
                                                            
                                                            foreach($centroT as $key =>$value){
                                                                $resultadoCT = $mysqli->query("SELECT id_centrodetrabajo, nombreCentrodeTrabajo FROM centrodetrabajo where id_centrodetrabajo = '$value' ");
                                                                $dato = $resultadoCT->fetch_array(MYSQLI_ASSOC);
                                                                echo $dato["nombreCentrodeTrabajo"]."<br>";
                                                               
                                                            }
                                                            ?>-->
                                                          <!--<input type="text" class="form-control" id="" value="<?php //echo $nombreCT;?>"  readonly>-->
                                                                
                                                <label>Cargo:</label>
                                                <br>
                                                <?php
                                                
                                                    $resultadoCargo = $mysqli->query("SELECT * FROM cargos where id_cargos = '$cargo' ");
                                                    $datoCargo = $resultadoCargo->fetch_array(MYSQLI_ASSOC);
                                                    echo $datoCargo["nombreCargos"]."<br>";
                                                ?>
                                                  
                                                         
                                    </div>
                                        
                                    <div class="form-group col-sm-4">
                                            
                                            <label>Teléfono:</label>
                                            <br>
                                            <?php 
                                                echo $telefono;
                                            ?>
                                                
                                            
                                    </div>
                                </div>    
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                                <label>Documento Asociado:</label>
                                                    <br>
                                                    <?php
                                                    if($variable == false){
                                                    $resultadoD = $mysqli->query("SELECT * FROM documento where id = '$idDoc' ");
                                                    $datoE = $resultadoD->fetch_array(MYSQLI_ASSOC);
                                                    echo $datoE["nombres"]."<br>";
                                                    $codificacion = $datoE["codificacion"];
                                                    }else{
                                                        echo "N/A";
                                                    }
                            				        ?>
                                    </div>
                                    <div class="form-group col-sm-4">
                                                <label>Código:</label>
                                                    <br>
                                                    <?php
                                                    if($variable == false){
                                                    
                                                    echo $codificacion;
                                                    }else{
                                                        echo "N/A";
                                                    }
                            				        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                                <label>Centro de trabajo:</label>
                                                <br>
                                                <?php
                                                $centroT = json_decode($datos["idCentroTrabajo"]);
                                                foreach($centroT as $key =>$value){
                                                    $resultadoCT = $mysqli->query("SELECT id_centrodetrabajo, nombreCentrodeTrabajo FROM centrodetrabajo where id_centrodetrabajo = '$value' ");
                                                    $dato = $resultadoCT->fetch_array(MYSQLI_ASSOC);
                                                    echo $dato["nombreCentrodeTrabajo"]."<br>";
                                                   
                                                }
                                                ?>   
                                    </div>
                                    <div class="form-group col-sm-4">
                                        
                                        
                                    
                                            <label>Autorizados para Visualizar: </label><br>
                                            <?php 
                                                if($visualizar == "cargo"){
                                                    
                                                
                                            ?>
                                                <input type="radio" id="rad_cargoAut" name="radiobtnAut" checked value="cargo">
                                                <label for="cargo">Cargo</label>
                                                <br>
                                                  
                                                    
                                                    <?php
                                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                    //$consultaCargos=$mysqli->query("SELECT * FROM usuario");
                                                    foreach($idVisual as $key =>$valueC){
                                                        $resultadoC = $mysqli->query("SELECT id_cargos, nombreCargos FROM cargos where id_cargos = '$valueC'");
                                                        $datoC = $resultadoC->fetch_array(MYSQLI_ASSOC);
                                                        $nombreC  = $datoC["nombreCargos"]."<br>";
                                                    echo $nombreC;
                                                    }
                                                    ?>
                                                 
                                                
                                            <?php
                                                }
                                                if($visualizar == "usuario"){
                                            
                                            ?>
                                                <input type="radio" id="rad_usuarioAut" name="radiobtnAut"  checked value="usuario">
                                                <label for="usuarios">Usuarios</label>
                                                <br>
                                                   
                                                    
                                                     <?php
                                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                    //$consultaCargos=$mysqli->query("SELECT * FROM usuario");
                                                    foreach($idVisual as $key =>$valueU){
                                                        $resultadoU = $mysqli->query("SELECT nombres, apellidos FROM usuario where id = '$valueU'");
                                                        $datoU = $resultadoU->fetch_array(MYSQLI_ASSOC);
                                                        $nombreU  = $datoU["nombres"]." ".$datoU["apellidos"]."<br>";
                                                    echo $nombreU;
                                                    }
                                                    ?>
                                                        
                                                    
                                                
                                            <?php
                                                }
                                                if($visualizar == "grupo"){
                                            
                                            ?>
                                                <input type="radio" id="rad_grupoAut" name="radiobtnAut" checked value="grupo">
                                                <label for="grupos">Grupos</label>
                                                <br>
                                                     <?php
                                                    
                                                    $consultaGrupo=$mysqli->query("SELECT * FROM grupo");
                                                    ?>
                                                    <?php
                                                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                    //$consultaCargos=$mysqli->query("SELECT * FROM usuario");
                                                    foreach($idVisual as $key =>$valueG){
                                                        $resultadoG = $mysqli->query("SELECT nombre FROM grupo where id = '$valueG'");
                                                        $datoG = $resultadoG->fetch_array(MYSQLI_ASSOC);
                                                        $nombreG  = $datoG["nombre"];
                                                    echo $nombreG;echo "<br>";
                                                    }
                                                    ?>
                                            
                    
                                            <?php
                                                }
                                            ?>
                                    </div>
                                </div>
                                <?php
                                    if($enviarConExtension == 'pdf'){
                                ?><br>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label>Ver Documento:</label>
                                        <br>
                                        
                                        <iframe  width="850" height="600" src="<?php echo $rutaPDF.$var2;?>"></iframe>
                                        
                                    </div>
                                    
                                </div>
                                <?php } ?>
                            </div>
                        </form>
                    </div>
                <!-- /.card-body -->

   
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
<!--Ckeditor-->

<script>PDFObject.embed("<?php echo $var.$var2;?>", "#example1");</script>
  <script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
</body>
</html>
<?php
}
}
?>