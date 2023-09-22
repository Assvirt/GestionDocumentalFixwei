<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'proveedores'; //Se cambia el nombre del formulario

require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
    <title>Proveedores</title>
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
            <h1>Proveedores</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Proveedores</li>
            </ol>
          </div>
        </div>
        <div>
            <?php
                if($visibleI == FALSE){
            ?>
            <div class="row">
            <!--
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarProveedor"><font color="white"><i class="fas fa-plus-square"></i> Nuevo proveedor</font></a></button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarProveedoresGrupos"><font color="white"><i class="fas fa-user-plus"></i> Grupos</font></a></button>
            </div>
            -->
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/proveedores'"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
            </div>
            
            <div class="col-sm">
                 <form action='proveedorProductos' method='POST'>
                    <button type='submit' class='btn btn-block btn-info btn-sm'><i class='fas fa-cubes'></i> Productos</button></td>
                 </form>
            </div>
             <div class="col-sm">
                <button type="button" class="btn btn-block btn-danger btn-sm"><a href="proveedoresBloquearV"><font color="white"><i class="fas fa-list"></i> Bloqueados</font></a></button>
            </div>
            <div class="col-sm">
                 <form action='proveedorVigente' method='POST'> <!-- itle="Deshabilitado hasta verificación de aprobador" disabled -->
                    <button type='submit' t class='btn btn-block btn-info btn-sm'><i class='fas fa-plus-square'></i> Proveedores Vigentes</button></td>
                 </form>
            </div>
            <div class="col-sm">
            </div>
            <div class="col-sm">
            </div>
            <!--
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="importacion/importar-proveedor/proveedores.xlsx" onClick="javascript:document["ver-form"].submit();"><font color="white"><i class="fas fa-cloud-download-alt"></i> Descargar Plantilla</font></a></button>
            </div>

            <div class="col-sm">
                <form action="importacion/importar-proveedor/index" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                    <div class="custom-file">
                        <input type="file" name="file" class="custom-file-input" id="exampleInputFile" required>
                        <label class="custom-file-label" for="exampleInputFile">Importar archivo</label>
                        
                    </div>
                
            </div>
            <div class="col-sm">
                <button type="submit" name="import" class="btn btn-block btn-info btn-sm"><a class="" href="#"><font color="white"><i class="fas fa-file-upload"></i> Importar</font></a></button>
            </div>
            </form>
            -->
            </div>
            <?php }else{?>
            <div class="row">
                <div class="col-sm">
                    <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/proveedores'"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
                </div>
                
                <div class="col-sm">
                    
                </div>
    
                <div class="col-sm">
                </div>
                <div class="col-sm">
                </div>
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
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>N°</th>
                      <th>Nit</th>
                      <th>Proveedor</th>
                      <th>Código Ciiu</th>
                      <!--<th>Descripci&oacute;n para el Texto</th>-->
                      <!--<th>Criticidad</th>-->
                      <th>Grupo</th>
                      <th>Correo Electrónico</th>
                      <th>Tel&eacute;fono</th>
                      <th>Actualizaci&oacute;n</th>
                      <!--<th>Meses para evaluaci&oacute;n</th>-->
                      <!--<th style="display:<?php //echo $visibleI;?>;">Documentos</th>-->
                      <!--<th style="display:<?php //echo $visibleI;?>;">Productos</th>-->
                      <th>Ver más</th>
                      
                      <th style="display:<?php echo $visibleE;?>;">Editar</th>
                      <th style="display:<?php echo $visibleD;?>;">Eliminar</th>
                       <th style="display:<?php echo $visibleD;?>;">Bloquear</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $data = $mysqli->query("SELECT * FROM proveedores WHERE estado='Aprobado' ORDER BY razonSocial ASC")or die(mysqli_error());
                     
                     $conteo=1;
                      ''.$numeroConCeros = str_pad($conteo, 4, "00000", STR_PAD_LEFT);
                     while($row = $data->fetch_assoc()){
                        $id = $row['id'];
                        
                        //if($row['estado'] == 'Pendiente'){
                        //    continue;
                        //}
                        
                    echo"<tr>";
                    echo"<td>".$conteo++."</td>";
                    echo "<td>".$row['nit']."-".$row['nitDigito']."</td>";
                    echo" <td>".$row['razonSocial']."</td>";
                    echo" <td>".$row['codigoCiiu']."</td>";
                    //echo" <td>".$row['descripcion']."</td>";
                    //echo" <td>".$row['criticidad']."</td>";
            	    $idGrupo=$row['grupo'];
            	    $queryConsultaGrupo=$mysqli->query("SELECT * FROM proveedoresGrupo WHERE id='$idGrupo' ");
    	            $rowConsulta=$queryConsultaGrupo->fetch_array(MYSQLI_ASSOC);
    	            $nombregrupo=$rowConsulta['grupo'];
            	    echo" <td>".$nombregrupo."</td>";
            	    echo" <td>".$row['email']."</td>";
            	    echo" <td>".$row['telefono']."</td>";
            	    $mesesRevision = $row['frecuenciaActualizacionD'];
            	        if($row['fecha'] == NULL){
                            
                            $fechaAprobado = 'N/A';//date("d-m-Y", strtotime($row['fecha']));
                            /*Calculo fecha de revision*/
                            $fechaRevisar = 'N/A';//date("d-m-Y",strtotime($fechaAprobado."+ $mesesRevision month"));
                            
                        }else{
                            $fechaUltimaRevision = $row['fecha'];
                            $fechaRevisar = date("d-m-Y",strtotime($fechaUltimaRevision."+ $mesesRevision month"));
                        }
                        
                        date_default_timezone_set('America/Bogota');
                        $fecha1=date('d-m-Y');
                     
                        
                        $fecha_actual = strtotime($fecha1);
                        $fecha_entrada = strtotime($fechaRevisar); //$fechaUltimaRevision
                        	
                       
                         if($fecha_actual > $fecha_entrada){ 
                              
                            // se le notifica los documentos vencidos
                            $realizador=$row['realizador'];
                            $nombreDocEnviar=$row['razonSocial'];
                            $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$realizador' ");
                            $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                            $nombreResponsable=utf8_encode($columna['nombres'].' '.$columna['apellidos']); 
                            $correoResponsable=$columna['correo']; 
                            '<br>';
                        
                        
                            require 'controlador/usuarios/libreria/PHPMailerAutoload.php';
                                            

                                            //Create a new PHPMailer instance
                                            $mail = new PHPMailer();
                                            $mail->IsSMTP();
                                            
                                            //Configuracion servidor mail
                                            require 'correoEnviar/contenido.php';
                                            
                                            //Agregar destinatario
                                            $mail->isHTML(true);
                                            $mail->AddAddress($correoResponsable);
                                            $mail->Subject = utf8_decode('Actualización de proveedor ');
                                            //$mail->Body = $_POST['message'];
                                            
                                            $mail->Body = utf8_decode('
                                            <html>
                                            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                            <title>HTML</title>
                                            </head>
                                            <body>
                                            <img src="https://fixwei.com/plataforma/pages/iconos/correo.png" width="200px" height="100px"><br>
                                            
                                            <p>Estimado (a). <b><em>'.$nombreResponsable.'</em></b>.
                                            <br>
                                            <p>Los documentos del proveedor <b>'.utf8_decode($nombreDocEnviar).'.</b> se encuentran desactualizados.</p>
                                            <br>
                                            <em></em>
                                            <br>
                                            <br><br><a target="_black" href="http://fixwei.com/plataforma/pages/examples/login">Acceder</a>.
                                            <br><br>
                                             Este correo es informativo y por tanto, le pedimos no responda este mensaje.
                                            </p>
                                            </body>
                                            </html>
                                            ');
                                            
                                            //Avisar si fue enviado o no y dirigir al index
                                        
                                            if ($mail->Send()) {
                                            echo 'enviado';
                                            } else {
                                            echo 'error';
                                            }
                            // END
                             
                           $mysqli->query("UPDATE proveedores SET estado='Pendiente' , bloqueoCarpeta= NULL WHERE id='$id' ");
                           $mensajeDelProveedor='<font color="red">Documentos vencidos, fecha de caducidad '.$row['fecha'].'</font>';
                        }else{
                            $mensajeDelProveedor=$fechaRevisar;
                        }
                        
                       
                        
                        
            	    echo "<td>  ".$mensajeDelProveedor."</td>"; //".$fecha_actual." ".$fecha_entrada."
            	    
            	    
            	    //echo" <td>".$row['frecuenciaActualizacion']."</td>";
            	    //echo" <td>".$row['tiempoEvaluacion']."</td>";
                    /*                    
                    echo"<form action='proveedorDocumetos' method='POST'>";
                    echo"<input type='hidden' name='idProveedor' value= '$id' >";
                    echo"<td style='display:$visibleI;'><button type='submit' class='btn btn-block btn-primary btn-sm'><i class='fas fa-file-upload'></i> Documentos</button></td>";
                    echo"</form>";
                   
                     echo"<form action='proveedorProductos' method='POST'>";
                    echo"<input type='hidden' name='idProveedor' value= '$id' >";
                    echo"<td style='display:$visibleI;'><button type='submit' class='btn btn-block btn-info btn-sm'><i class='fas fa-cubes'></i> Productos</button></td>";
                    echo"</form>";
                     */
                    
                    
                    echo"<form action='proveedoresVer' method='POST'>";
                    echo"<input type='hidden' name='idProveedor' value= '$id' >";
                    echo"<td><button type='submit' class='btn btn-block btn-primary btn-sm'><i class='fas fa-eye'></i> Ver más</button></td>";
                    echo"</form>";
                    
                    echo"<form action='proveedoresEditar' method='POST'>";
                    echo"<input type='hidden' name='idProveedor' value= '$id' >";
                    echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                    echo"</form>";
                    
                    /*
                    echo"<form action='controlador/proveedor/controllerProveedor' method='POST'>";
                    echo"<input type='hidden' name='idProveedor' value= '$id' >";
                    echo" <td style='display:$visibleD;'><button onclick='return ConfirmDelete()' type='submit' name='Eliminar' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                    echo"</form>";
                    */
                    /// validación de script y funcion de eliminacion
                    
                    
                    // validación para no eliminar un proveedor si ya existen productos comprometidos
                        ?>
                        <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $id;?>' >
                        <td style='display:<?php echo $visibleD;?>'><a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                        <script>
                            function funcionFormula<?php echo $contador2++;?>() {
                               
                              document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                            }
                       </script>
                        <?php
                        
                        /// END
                    echo"<form action='proveedoresBloquear' method='POST'>";
                    echo"<input type='hidden' name='idProveedor' value= '$id' >";
                    echo" <td style='display:$visibleD;'><button type='submit' class='btn btn-block btn-warning btn-sm'><i class='fas fa-lock'></i> Bloquear</button></td>";
                    echo"</form>";
                    
                    echo"</tr>";
                    
                        
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
                            <form action='controlador/proveedor/controllerProveedor' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormula" name='idProveedor' readonly>
                              <button type="submit" name='Eliminar' class="btn btn-outline-light">Si</button>
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
$validacionExisteE=$_POST['validacionExisteE'];
$validacionAgregar=$_POST['validacionAgregar'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];


//// validaciones de importacion
$validacionExisteImportacion=$_POST['validacionExisteImportacion'];
$validacionExisteImportacionA=$_POST['validacionExisteImportacionA'];
$validacionExisteImportacionB=$_POST['validacionExisteImportacionB'];
$validacionExisteImportacionC=$_POST['validacionExisteImportacionC'];
$validacionExisteImportacionD=$_POST['validacionExisteImportacionD'];
$validacionExisteImportacionE=$_POST['validacionExisteImportacionE'];
$validacionExisteImportacionF=$_POST['validacionExisteImportacionF'];
$validacionExisteImportacionH=$_POST['validacionExisteImportacionG'];
$validacionExisteImportacionExito=$_POST['validacionExisteImportacionExito'];
$validacionExisteImportacionVacio=$_POST['validacionExisteImportacionVacio'];
/// END

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
    if($validacionExisteImportacionExito == 1){
     ?>
        Toast.fire({
            type: 'success',
            title: ' Excel importado correctamente.'
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
    if($validacionExisteImportacionA == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos proveedores ya existen.'
        })
    <?php
    }
    if($validacionExisteImportacionB == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos nit están repetidos en el documento.'
        })
    <?php
    }
    if($validacionExisteImportacionC == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos grupos no existen en el sistema.'
        })
    <?php
    }
    if($validacionExisteImportacionD == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' La criticidad seleccionada no existe en el sistema.'
        })
    <?php
    }
    if($validacionExisteImportacionE == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Está intentando ingresar texto en campos númericos.'
        })
    <?php
    }
    if($validacionExisteImportacionF == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: ' Proveedor bloqueado.'
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
            title: ' El proveedor  ya existe.'
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
            title: ' El nombre del proceso ya existe.'
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
   if($validacionExisteImportacionVacio == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos campos están vacios.'
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