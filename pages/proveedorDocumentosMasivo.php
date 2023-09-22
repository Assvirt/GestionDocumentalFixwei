<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'politicas'; //Se cambia el nombre del formulario

require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
    <title>Proveedores Documentos</title>
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
               <?php
                    $consulta=$mysqli->query("SELECT * FROM proveedordocumentosCarpetas WHERE id='".$_POST['idCarpeta']."' ");
                    $extarer=$consulta->fetch_array(MYSQLI_ASSOC);
                    'Carpeta <b>'.$nombreCarpeta=utf8_decode($extarer['nombre']); echo '</b>';
                    $estadoCarpeta=$extarer['estado'];
                    if($estadoCarpeta == 'aprobado' || $estadoCarpeta == 'Pendiente' ){
                        $disabledAprobado='disabled';
                    }else{
                        $disabledAprobado='';
                    }
                
                    $idProveedor=$_POST['idProveedor'];
                    $query = $mysqli->query("SELECT * FROM proveedores WHERE id= '$idProveedor'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $idEnviarProveedor = $row['id'];
                    $nit = $row['nit'];
                    $proveedor = $row['razonSocial'];
              ?>
            <h1>Documentos del Proveedor Vigente<br> <?php echo $proveedor; ?></h1>
            
            
           
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Documentos del Proveedor Vigente</li>
            </ol>
          </div>
        </div>
        <div>
           
            <div class="row">
            
             <?php
                if($visibleI == FALSE){
            ?>
             <div class="col-sm"><!-- Vista PPAL -->
            <form action="subirDocumentoMasivo" method="POST">
                    <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                    <button type="submit" class="btn btn-block btn-success btn-sm"><a href="#"><font color="white"><i class="fas fa-list"></i> Regresar</font></a></button>
            </form>
               <!-- <button type="button" class="btn btn-block btn-success btn-sm"><a href="proveedores"><font color="white"><i class="fas fa-list"></i> Regresar</font></a></button>-->
            </div>
            <div class="col-sm">
                <form action="agregarProveedorDocumentoMasivo" method="POST">
                    <input name="idCarpeta" value="<?php echo $_POST['idCarpeta']; ?>" type="hidden" readonly>
                    <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                    <button type="submit" class="btn btn-block btn-info btn-sm"><a href="#"><font color="white"><i class="fas fa-plus-square"></i> Nuevo documento</font></a></button>
                </form>
            </div>
            <?php
                }
            echo '<div class="col-sm">';
                    $data = $mysqli->query("SELECT * FROM proveedordocumentos WHERE idCarpeta='".$_POST['idCarpeta']."' ORDER BY nombre ASC")or die(mysqli_error());
                    $conteo=0;
                    while($row = $data->fetch_assoc()){
                        $conteo++;
                        $ruta=$row['soporte']; //echo '<br>';
                        $row['nombre'];
                    }
                   
                      
                       if($conteo > 0){ 
                            unlink('archivos/documentoProveedor/'.$nombreCarpeta.'.zip');
                            $zip = new ZipArchive();
                            $archivo="archivos/documentoProveedor/".$nombreCarpeta.".zip";
                            
                            if($zip->open($archivo,ZIPARCHIVE::CREATE)==true){
                                //$acentos = $mysqli->query("SET NAMES 'utf8'");
                                $data = $mysqli->query("SELECT * FROM proveedordocumentos WHERE idCarpeta='".$_POST['idCarpeta']."' ORDER BY nombre ASC")or die(mysqli_error());
                                while($row = $data->fetch_assoc()){
                                    if($row['soporte'] != NULL){
                                        $zip->addFile(($row['soporte']));
                                        //echo ($row['soporte']); echo '<br>'; 
                                    }
                                }
                                
                                $zip->close();
                                //echo 'Agregado '.$archivo;
                                echo "<button type='button'  class='btn btn-block btn-warning btn-sm' >
                                                        <a style='color:white' href='archivos/documentoProveedor/".$nombreCarpeta.".zip'><i class='fas fa-download'></i> Descargar documentos</a>
                                                    </button>";
                            }else{
                                echo 'Ups ! algo salío mal, ponerse  en contacto con los programadores.';
                            }
                        }
            echo '</div>';
            ?>
            <!--
            <div class="col-sm">
                <form action="proveedoresVer" method="POST">
                    <input name="idProveedor" value="<?php  $idProveedor; ?>" type="hidden" readonly>
                <button type="submit" class="btn btn-block btn-success btn-sm"><a href="#"><font color="white"><i class="fas fa-list"></i> Regresar</font></a></button>
                </form>
            </div>
            -->
           
            <div class="col-sm">
                   
                <?php
                /*
                           
                            
                    require 'conexion/bd.php';
                    //$acentos = $mysqli->query("SET NAMES 'utf8'");
                    $data = $mysqli->query("SELECT * FROM proveedordocumentos WHERE idCarpeta='".$_POST['idCarpeta']."' ORDER BY nombre ASC")or die(mysqli_error());
                    $conteo=0;
                    while($row = $data->fetch_assoc()){
                        $conteo++;
                        $ruta=$row['soporte']; //echo '<br>';
                        $row['nombre'];
                    }
                   
                      
                        if($conteo > 0){ 
                            unlink('archivos/documentoProveedor/'.$nombreCarpeta.'.zip');
                            $zip = new ZipArchive();
                            $archivo="archivos/documentoProveedor/".$nombreCarpeta.".zip";
                            
                            if($zip->open($archivo,ZIPARCHIVE::CREATE)==true){
                                $data = $mysqli->query("SELECT * FROM proveedordocumentos WHERE idCarpeta='".$_POST['idCarpeta']."' ORDER BY nombre ASC")or die(mysqli_error());
                                while($row = $data->fetch_assoc()){
                                    if($row['soporte'] != NULL){
                                        $zip->addFile($row['soporte']);
                                    }
                                }
                                
                                $zip->close();
                                //echo 'Agregado '.$archivo;
                                echo "<button type='button'  class='btn btn-block btn-warning btn-sm' >
                                                        <a style='color:white' href='archivos/documentoProveedor/".$nombreCarpeta.".zip'><i class='fas fa-download'></i> Descargar documentos</a>
                                                    </button>";
                            }else{
                                echo 'Ups ! algo salío mal, ponerse  en contacto con los programadores.';
                            }
                        }
                        */
                ?>
            </div>
            <div class="col-sm">
            </div>
            <div class="col-sm">
                
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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"></h3>
                <div class="card-body table-responsive p-1 card-tools">
                      <?php  echo 'Carpeta <b>'.$nombreCarpeta; echo '</b>'; ?> 
                    
              </div>
            </div>
              <!-- /.card-header -->
              
              <?php
               
                       $validandoAprobador=$mysqli->query("SELECT * FROM proveedores WHERE id='$idProveedor' ");
                       while($extraerValidacionAProbdor=$validandoAprobador->fetch_array()){
                       
                       
                        $quienElaboraConteoV = $extraerValidacionAProbdor['radio']; 
                        $quienElaboraIDconteoV = json_decode($extraerValidacionAProbdor['aprobador']);
                        
                        if($quienElaboraConteoV == "cargo"){
                            if(in_array($cargo,$quienElaboraIDconteoV)){
                                $habilitarAprbacion='1';
                            }
                        }
                        
                        if($quienElaboraConteoV == "usuario"){
                            if(in_array($idparaChat,$quienElaboraIDconteoV)){
                                $habilitarAprbacion='1';
                            }
                        }
                       }
                
              
              
              
              
                    
                    
                    
                if($habilitarAprbacion == 1){
              ?>
              <form action="controlador/proveedor/controllerDocumento" method="post">
              <div class="card-header">
                
                    <input type='hidden' name='idProveedor' value= '<?php echo $idProveedor;?>' >
                    <input type='hidden' name='idCarpeta' value="<?php echo $_POST['idCarpeta']; ?>" >
                    
                <?php
                $estadoCarpeta=$extarer['estado'];
                if($estadoCarpeta == 'aprobado'){
                    $checkedA='checked';
                    $disabledEstadoComentado='disabled';
                }
                if($estadoCarpeta == 'rechazado'){
                    $checkedB='checked'; 
                    $disabledEstadoComentado='disabled';
                }
                ?>
                    
              
                <?php
                }
              ?>
              <div class="card-body table-responsive p-0" >
                
                <table class="table table-head-fixed text-center">
                  <thead>
                    <tr>
                      <th>N°</th>
                      <th>Nombre documento</th>
                      <th>Soporte</th>
                      <!--<th style="display:<?php //echo$visibleE;?>;">Editar</th>-->
                      <th style="display:<?php echo$visibleD;?>;">Eliminar</th>
                    
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     //$acentos = $mysqli->query("SET NAMES 'utf8'");
                     $data = $mysqli->query("SELECT * FROM proveedordocumentos WHERE idCarpeta='".$_POST['idCarpeta']."' ORDER BY nombre ASC")or die(mysqli_error());
                     $conteo=1;
                     while($row = $data->fetch_assoc()){
                        $id = $row['id'];
                    echo"<tr>";
                    echo"<td>".$conteo++."</td>";
                    echo "<td style='text-align:justify;'>".utf8_encode($row['nombre'])."</td>";
                    
                    $ruta=$row['soporte'];
                    
                        echo"<td>
                          <button  type='button'  class='btn btn-block btn-warning btn-sm'>
                            <i class='fas fa-download'></i>
                            <a style='color:black' href='$ruta' download='' target='_blank'>Descargar</a>
                          </button>
                        </td>";
                    
                 
                    echo"<form action='agregarProveedorDocumentoEditar' method='POST'>";
                    echo"<input type='hidden' name='id' value= '$id' >";
                    echo"<input type='hidden' name='idProveedor' value= '$idProveedor' >";
                    echo"<input type='hidden' name='idCarpeta' value=".$_POST['idCarpeta']." >";
                    
                    
                    // validamos que el aporbador no pueda editar o eliminar un documento
                    $consultaProveedores=$mysqli->query("SELECT * FROM proveedores WHERE id='$idProveedor' ");
                    $extraerConsultaProveedor=$consultaProveedores->fetch_array(MYSQLI_ASSOC);
                  
                            $tipoResponsableV=$extraerConsultaProveedor['radio'];
                            $personalIDV =  json_decode($extraerConsultaProveedor['aprobador']);
                            $longitudV = count($personalIDV);
                   
                            if($tipoResponsableV == 'usuario'){
                                            for($i=0; $i<$longitudV; $i++){ //// inicia for
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalIDV[$i]' ");
                                                while($columna = $nombreuser->fetch_assoc()){
                                                    $cedulaUsuario=$columna['id'];
                                                }
                                            }  /////// cierre del for
                            }else{    
                                            for($i=0; $i<$longitudV; $i++){ //// inicia for
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM cargos WHERE id_cargos = '$personalIDV[$i]' ");
                                                while($columna = $nombreuser->fetch_assoc()){
                                                    $cedulaUsuario=$columna['id_cargos']; 
                                                }
                                            }  /////// cierre del for    
                                
                            }
                            
                            if($tipoResponsableV == 'usuario'){
                                if($cedulaUsuario == $idparaChat){
                                    $hbilitarPermisoAprpbador='disabled';
                                }else{
                                    $hbilitarPermisoAprpbador='';
                                }
                            }else{
                                if($cedulaUsuario == $cargo){
                                    $hbilitarPermisoAprpbador='disabled';
                                }else{
                                    $hbilitarPermisoAprpbador='';
                                }
                                
                            }
                            
                    
                   // echo" <td style='display:$visibleE;'><button type='submit' $hbilitarPermisoAprpbador class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";// $disabledAprobado
                    
                    
                    echo" </form>";
                    
                    
                    
                     ?>
                     <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $id;?>' >
                     <td style='display:<?php echo $visibleD;?>'><a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                        
                        <script>
                            function funcionFormula<?php echo $contador2++;?>() {
                              document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                            }
                       </script>
                    <?php   
                    
                    /*
                    if($disabledAprobado == 'disabled'){
                        echo "<td style='display:$visibleD;'><button $disabledAprobado type='submit' class='btn btn-block btn-danger btn-sm'><i class='fas fa-edit'></i> Eliminar</button></td>";
                    }else{
                        ?>
                        <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $id;?>' >
                        <?php
                        if($hbilitarPermisoAprpbador == 'disabled'){
                            
                            echo "<td style='display:$visibleD;'><button disabled type='submit' class='btn btn-block btn-danger btn-sm'><i class='fas fa-edit'></i> Eliminar</button></td>";
                    
                        }else{
                        ?>
                        <td style='display:<?php echo $visibleD;?>'><a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                        <?php
                        }
                        ?>
                        <script>
                            function funcionFormula<?php echo $contador2++;?>() {
                              document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                            }
                       </script>
                    <?php   
                    }
                    */
                    
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
                            <form action='controlador/proveedor/controllerAlmacenamientoMasivo' method='POST'>
                               <input name="idProveedor" value="<?php echo $idProveedor; ?>" type="hidden" readonly>
                               <input name="idCarpeta" value="<?php echo $_POST['idCarpeta']; ?>" type="hidden" readonly>
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormula" name='id' readonly>
                              <button type="submit" name='eliminar' class="btn btn-outline-light">Si</button>
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
$validacionExisteImportacionB=$_POST['validacionExisteImportacionB'];
$validacionExisteImportacionC=$_POST['validacionExisteImportacionC'];
$validacionExisteImportacionD=$_POST['validacionExisteImportacionD'];
$validacionExisteImportacionE=$_POST['validacionExisteImportacionE'];
$validacionExisteImportacionF=$_POST['validacionExisteImportacionF'];
$validacionExisteImportacionH=$_POST['validacionExisteImportacionG'];
$validacionExisteImportacionExito=$_POST['validacionExisteImportacionExito'];
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
            title: ' Algunos nombres están repetidos.'
        })
    <?php
    }
    if($validacionExisteImportacionE == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos dueños de procesos no existen.'
        })
    <?php
    }
    if($validacionExisteImportacionF == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos prefijos están repetidos.'
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
            title: ' El documento ya existe.'
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
            type: 'success',
            title: ' Documentos aprobados.'
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
    ?>
    
  });

</script>
</body>
</html>
<?php
}
?>