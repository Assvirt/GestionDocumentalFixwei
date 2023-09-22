<?php
session_start();
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
///////// notificaciones para plataforma y correo
require_once 'conexion/bd.php';


//////////////////////PERMISOS////////////////////////
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Consecutivo Orden de Compra</title>
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
  <?php 
    echo require_once'menu.php'; 
    if($rootAdmin == '1'){

    
    }else{
          echo '<script language="javascript">window.location.href="accesoDenegado"</script>';
    }
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Consecutivo Orden de Compra</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Consecutivo Orden de Compra</li>
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
                            <button type="button" class="btn btn-block btn-success btn-sm"><a href="solicitudComprador"><font color="white"><i class="fas fa-list"></i> Regresar a Orden de Compra</font></a></button>
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
          /////////////// se valida que botón entra para el formulario de editar o de agregar-....
          $idProveedorGrupo=$_POST['idProveedorGrupo'];
          
          
          if(isset($_POST['botonValidarEditar'])){
          ?>
               
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php 
                    $query = $mysqli->query("SELECT * FROM consecutivoOC WHERE id = '$idProveedorGrupo'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    
                    if(is_numeric($row['caracter'])){
                        $grupoA = $row['caracter'];
                    }elseif($row['caracter'] == 'Fecha'){
                        $grupoC ='checked';
                    }else{
                        $grupoB = $row['caracter'];
                    }
                    
                    $idDatos = $row['id'];
                    
                ?>
              <form role="form" action="controlador/ordenCompra" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Caracter:</label>
                    <input type="text" class="form-control" name="grupo" value="<?php echo $grupoB; ?>" placeholder="Caracter" >
                    <br>
                    <label>Númerico (auto-incrementable):</label>
                    <input type="number" min="0" class="form-control" name="descripcion" value="<?php echo $grupoA; ?>" placeholder="Númerico" id="descripcionObli" >
                    <br>
                    <label>Fecha:</label>
                    <input type="checkbox" name="fecha" id="fechaObli" value="1" <?php echo $grupoC;?>>
                    <!--<br>
                    <label>Descripci&oacute;n:</label>
                    <textarea type="text" class="form-control"  name="descripcion" placeholder="Descripci&oacute;n" required><?php //echo $descripcion; ?></textarea>-->
                    <input type="hidden" name="idProveedorGrupo" value="<?php echo $idDatos; ?>">
                  </div>
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                  <button type="submit" class="btn btn-primary float-right" name="Editar">Actualizar</button>
                </div>
              </form>
              <div class="card-footer">
                  <button type="button" onclick="window.location='agregarProveedoresGrupo'" class="btn btn-success float-right">Cerrar</button>
              </div>
            </div>
            <?php
                }else{
            ?>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/ordenCompra" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Caracter:</label>
                    <input type="text" class="form-control" name="grupo" placeholder="Caracter" id="grupoObli" >
                    <br>
                    <label>Númerico (auto-incrementable):</label>
                    <input type="number" min="0" class="form-control" name="descripcion" placeholder="Númerico" id="descripcionObli" >
                    <br>
                    <label>Fecha:</label>
                    <input type="checkbox" name="fecha" id="fechaObli" value="1">
                    
                    <!--<textarea type="number" class="form-control"  name="descripcion" placeholder="Descripci&oacute;n" required></textarea>-->
                   
                  </div>
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                  
                  <button type="submit" class="btn btn-primary float-right" name="Agregar">Agregar</button>
                </div>
              </form>
            </div>
            
            <?php
                }
                /////////////// Fin se valida que botón entra para el formulario de editar o de agregar-....
            ?>
            
            
            
            </div>    

        <div class="col">
            </div>
            
           
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
      
    </section>  

  <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
          <div class="col-9">
            <div class="card">    
        <div class="card-body table-responsive p-0" style="height: 800px;">
                <table class="table table-head-fixed text-center">
                  <thead>
                    <tr>
                      <th>Caracter</th>
                      <th>Descripci&oacute;n</th>
                      <th>Aplicar consecutivo</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     
                     // consulta para bloquear botón
                      $bloqueo = $mysqli->query("SELECT * FROM consecutivoOC WHERE aplicado='1' ")or die(mysqli_error());
                      $extraerBloqueo=$bloqueo->fetch_array(MYSQLI_ASSOC);
                      
                      if($extraerBloqueo['aplicado'] == '1'){
                          $bloquear='none';
                      }else{
                          $bloquear='';
                      }
                     //
                     
                     
                     
                     
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                     $data = $mysqli->query("SELECT * FROM consecutivoOC order by id")or die(mysqli_error());
                     $contadorConsecutivo='0';
                     while($row = $data->fetch_assoc()){
                 
                    echo"<tr>";
                    echo" <td>".$row['caracter']."</td>";
                    echo" <td>".$row['descripcion']."</td>";
                    $id=$row['id'];
                    
                    if(is_numeric($row['caracter'])){
                        
                        ///// validación de la variable aplicada
                        
                        if($row['aplicado'] == '1'){
                        echo" <td><button disabled class='btn btn-block btn-warning btn-sm'><i class='fas fa-edit'></i> Aplicado</button></td>";
                        }else{
                        echo"<form action='controlador/ordenCompra' method='POST'>";
                        echo"<input type='hidden' name='idProveedorGrupo' value= '$id' >";
                        echo" <td><button style='display:$bloquear;' type='submit' name='aplicar'  class='btn btn-block btn-warning btn-sm'><i class='fas fa-edit'></i> Aplicar consecutivo</button></td>";
                        echo"</form>";
                        }
                       
                    
                        
                    }else{
                        echo '<td></td>';
                    }
                    
                    if($row['aplicado'] == '1'){
                        echo" <td><button disabled class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                    }else{
                    echo"<form action='' method='POST'>";
                    echo"<input type='hidden' name='idProveedorGrupo' value= '$id' >";
                    echo" <td><button type='submit' name='botonValidarEditar' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                    echo"</form>";
                    }
                     ?>
                        <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $id;?>' >
                        <td style='display:<?php echo $visibleD;?>'><a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                        <script>
                            function funcionFormula<?php echo $contador2++;?>() {
                                /*alert("entre");*/
                              document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                            }
                       </script>
                        <?php
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
                            <form action='controlador/ordenCompra' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormula" name='idProveedorGrupo' readonly>
                              <button type="submit" name='proveedoresGrupoEliminar' class="btn btn-outline-light">Si</button>
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
      </div>
      </div>
      <div class="col">
            </div>
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
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
</script>
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
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
$validacionVacio=$_POST['validacionVacio'];


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
    
    if($validacionVacio == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Debe ingresar un caracter o un número'
        })
    <?php
    }
    if($validacionExisteImportacion == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Est�� intentando subir un archivo diferente.'
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
            title: ' Algunos nit est��n repetidos en el documento.'
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
            title: ' Est�� intentando ingresar texto en campos n��mericos.'
        })
    <?php
    }
    if($validacionExisteImportacionF == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos prefijos est��n repetidos.'
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
            title: ' El grupo  ya existe.'
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
    ?>
    
  });

</script>
</body>
</html>
<?php
}
?>