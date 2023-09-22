<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Agregar Unidad de Medida</title>
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
<body class="hold-transition sidebar-mini" onload="nobackbutton();" oncopy="return false" onpaste="return false" >
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
            <h1>Agregar Unidad de Medida</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Agregar Unidad de Medida</li>
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
                            <button type="button" class="btn btn-block btn-success btn-sm"><a href="indicadores"><font color="white"><i class="fas fa-list"></i> Regresar a Indicadores</font></a></button>
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
          $id=$_POST['id'];
          
          
          if(isset($_POST['botonValidarEditar'])){
          ?>
               
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php 
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $query = $mysqli->query("SELECT * FROM indicadoresUnidad WHERE id = '$id'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $tipo = $row['unidad'];
                    $nombre = $row['nombre'];
                   
                    $idDatos = $row['id'];
                    
                ?>
              <form role="form" action="controlador/indicadores/controllerUnidad" method="POST">
                <div class="card-body">
                  <div class="form-group">
                      <label>Nombre de la Unidad de Medida:</label>
                    <input type="text" autocomplete="off" class="form-control"  name="nombre" value="<?php echo $nombre; ?>" placeholder="Unidad de Medida" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                    <label>Unidad de Medida:</label>
                    <input type="text" class="form-control"  name="unidad" value="<?php echo $tipo; ?>" placeholder="Unidad de Medida" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || event.charCode == 33 || event.charCode == 35 || event.charCode == 36 || event.charCode == 37 || event.charCode == 38 || event.charCode == 47 || event.charCode == 40 || event.charCode == 41 || event.charCode == 61 || event.charCode == 63 || event.charCode == 161 || event.charCode == 191 || event.charCode == 43 || event.charCode == 42 || event.charCode == 45)" required>
                    <input type="hidden" name="id" value="<?php echo $idDatos; ?>">
                  </div>
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                  <button type="submit" class="btn btn-primary float-right" name="Actualizar">Actualizar</button>
                </div>
              </form>
              <div class="card-footer">
                  <button type="button" onclick="window.location='indicadoresUnidad'" class="btn btn-success float-right">Cerrar</button>
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
              <form role="form" action="controlador/indicadores/controllerUnidad" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Nombre de la Unidad de Medida:</label>
                    <input type="text" autocomplete="off" class="form-control" id="nombreProceso" name="nombre" placeholder="Nombre de la Unidad de Medida" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required> 
                    <br>
                    <label>Unidad de Medida:</label>
                    <input type="text" class="form-control" id="nombreProceso" name="unidad" placeholder="Unidad de Medida" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || event.charCode == 33 || event.charCode == 35 || event.charCode == 36 || event.charCode == 37 || event.charCode == 38 || event.charCode == 47 || event.charCode == 40 || event.charCode == 41 || event.charCode == 61 || event.charCode == 63 || event.charCode == 161 || event.charCode == 191 || event.charCode == 43 || event.charCode == 42 || event.charCode == 45)" required>
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
                      <th>Nombre</th>
                      <th>Unidad</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                     $data = $mysqli->query("SELECT * FROM indicadoresUnidad order by unidad")or die(mysqli_error());
                     while($row = $data->fetch_assoc()){
                    
                    echo"<tr>";
                    echo "<td>".$row['nombre'];
                    echo" <td>".$row['unidad']."</td>";
                  
                    $id=$row['id'];
                    echo"<form action='indicadoresUnidad' method='POST'>";
                    echo"<input type='hidden' name='id' value= '$id' >";
                    echo" <td><button type='submit' style='width:50%;' name='botonValidarEditar' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                    echo"</form>";
                    /*
                    echo"<form action='controlador/indicadores/controllerUnidad' method='POST'>";
                    echo"<input type='hidden' name='id' value= '$id' >";
                    echo" <td style='text-align: center;'><button style='width:50%;' onclick='return ConfirmDelete()' type='submit'  name='Eliminar' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                    echo"</form>";
                    */
                     /// validaci��n de script y funcion de eliminacion
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
                        /// END
                   
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
                            </div>
                            <div class="modal-body">
                              <p>¿Est&aacute; seguro que desea eliminar?</p>
                            </div>
                             <!-- formulario para eliminar por el id -->
                            <form action='controlador/indicadores/controllerUnidad' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormula" name='id' readonly>
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
<?php
/// validaciones de alertas
$validacionExiste=$_POST['validacionExiste'];
$validacionAgregar=$_POST['validacionAgregar'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionEliminar=$_POST['validacionEliminar'];
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
    if($validacionExiste == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' La unidad ya existe.'
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
  <script type="text/javascript">
$(document).ready(function () {
   
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
   
    $("body").on("contextmenu",function(e){
        return false;
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
?>