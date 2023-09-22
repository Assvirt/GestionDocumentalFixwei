<?php
session_start();
error_reporting(E_ERROR);
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'codificacion'; //Se cambia el nombre del formulario

require_once 'permisosPlataforma.php';

//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Codificación de documentos</title>
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
  <?php echo require_once'menu.php'; ?>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Codificación de documentos</h1>
            <h6>Gestione los prefijos y símbolos para la creación de Documentos.</h6><br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Codificación de documentos</li>
            </ol>
          </div>
        </div>
        <div>
            <!-- <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col-sm">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="#"><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>
                        </div>
                        <div class="col-sm">
                            <button type="button" class="btn btn-block btn-warning btn-sm"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
                        </div>
                        <div class="col-sm">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="#"><font color="white"><i class="fas fa-cloud-download-alt"></i> Descargar Plantilla</font></a></button>
                        </div>
            
                        <div class="col-sm">
                            <form>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Importar archivo</label>
                                    
                                </div>
                            </form>
                        </div>
                        <div class="col-sm">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a class="" href="#"><font color="white"><i class="fas fa-file-upload"></i> Importar</font></a></button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    
                </div>
                
           
            </div>-->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col"></div>
          <div class="col-9">
            <div class="card">
                <center>
                    <br><br>
                <?php
                require 'conexion/bd.php';
                $data = $mysqli->query("SELECT * FROM codificacion ORDER BY id")or die(mysqli_error());
                
                if(mysqli_num_rows($data) < 1){
                    echo "<h3>No hay codificación definida</h3>";
                }
                
                while($row = $data->fetch_assoc()){
                    echo $row['codificacion']." ";    
                }
                
                ?>
                    <br><br>
                </center>
            </div>
            <!-- /.card -->
          </div>
          <div class="col"></div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    


    <?php
        if($visibleI == FALSE){
    ?>
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
              <form role="form" action="controlador/codificacion" method="POST">
                  <input name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-sm-6">
                        <label>Variable</label>
                        <select class="form-control" id="selectPrefijo" required>
                          <option value='0'></option>
                          <option value='Proceso'>Proceso</option>
                          <option value='Tipo de documento'>Tipo de documento</option>
                          <option value='Versión'>Versión</option>
                          <option value='Consecutivo'>Consecutivo</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Símbolo</label>
                        <select class="form-control" id="selectSimbolo" required>
                            <option value='-'> - </option>
                            <option value='/'> / </option>
                            <option value=' '> </option>
                        </select>
                    </div>
                    
                  </div>
                  <div class="form-group">
                        <label></label>
                        <input type="text" class="form-control" name="txtCondificacion" id="txtCodificacion" placeholder=" " required>
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
                  <button type="submit" name="agregarCod" class="btn btn-primary float-right">Agregar</button>
                </div>
              </form>
            </div>
            </div>    

        <div class="col">
            </div>
            
           
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <?php }?>
    
    <?php
        if($visibleD == FALSE){
    ?>
    
    <!-- Main content table add-->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                <div class="card">
              <div class="card-header">
                <h3 class="card-title">Orden codificación</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-condensed text-center">
                  <thead>
                    <tr>
                      <th style="width: 10px">Orden</th>
                      <th>Codificación</th>
                      <th style="width: 200px">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php
                     
                     $data = $mysqli->query("SELECT * FROM codificacion ORDER BY id")or die(mysqli_error());
                     $n = 1;
                     while($row = $data->fetch_assoc()){
                    $idDel =$row['id'];
                    echo"<tr>";
                    echo" <td>".$n."</td>";
                    echo" <td>".$row['codificacion']."</td>";
                    /*
                    echo"<td>
                        <form action='controlador/codificacion' method='POST'>
                            <input type='hidden' value='$idDel' name='idDel'>
                            <button style='display:$visibleD;' type='submit' name='eliminaCod' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button>
                        </form>
                    </td>";
                    */
                        /// validación de script y funcion de eliminacion
                        ?>
                        <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $idDel;?>' >
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
                    $n++;
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
                            <form action='controlador/codificacion' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormula" name='idDel' readonly>
                              <button type="submit" name='eliminaCod' class="btn btn-outline-light">Si</button>
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
              <div class="card-footer" >
                      <a style='color:white;' data-toggle='modal' data-target='#modal-dangerTodo' class='btn btn-danger float-right'><i class='fas fa-trash-alt'></i> Eliminar Todo</a>
                        <div class="modal fade" id="modal-dangerTodo">
                            <div class="modal-dialog">
                              <div class="modal-content bg-danger">
                                <div class="modal-header">
                                  <h4 class="modal-title">Alerta</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>¿Est&aacute; seguro que desea eliminar todo?</p>
                                </div>
                                 <!-- formulario para eliminar por el id -->
                                <form action='controlador/codificacion' method='POST'>
                                <div class="modal-footer justify-content-between">
                                  <button type="submit" name='eliminaCodAll' class="btn btn-outline-light">Si</button>
                                  <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                                </div>
                                 </form>
                                 <!-- END formulario para eliminar por el id -->
                              </div>
                            </div>
                        </div>
                </div>
            </div>
            </div>
            <div class="col">
            </div>
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <?php }?>
    
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
<!-- jQuery mover elementos -->
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- Bootstrap Duallistbox -->
<script>
    $('.duallistbox').bootstrapDualListbox()
</script>
<!-- -->
<script type="text/javascript">
$(document).ready(function(){
    $('#cities').sortable({
        revert: true,
        opacity: 0.6, 
        cursor: 'move',
        update: function() {
            var order = $('#cities').sortable("serialize")+'&action=orderState';
            $.post("ajax.php", order, function(theResponse){
                $('#success').html('Gracias por ordenar las ciudades!').slideDown('slow').delay(1000).slideUp('slow');
            });
        }
    });
});
</script>
<script>
$("#selectPrefijo").change(function() {
    var str = "";
    $("#selectPrefijo option:selected").each(function() {
      str += $( this ).val() + " ";
    });
    $('#txtCodificacion').val(str);
  }).trigger( "change" );
</script>

<script>
$("#selectSimbolo").change(function() {
    var str = "";
    $("#selectSimbolo option:selected").each(function() {
      str += $( this ).val() + " ";
    });
    $('#txtCodificacion').val(str);
  }).trigger( "change" );
</script>
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<?php
/// validaciones de alertas
$validacionExiste=$_POST['validacionExiste'];
$validacionAgregar=$_POST['validacionAgregar'];
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
            title: ' El nivel o la prioridad ya existe.'
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
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
</body>
</html>
<?php
}
?>