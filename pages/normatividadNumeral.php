<?php
error_reporting(E_ERROR);
//Prueba
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
              <?php 
                    $id=$_POST['idNormatividad'];
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $query = $mysqli->query("SELECT * FROM normatividad WHERE id = '$id'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $nombre = $row['nombre'];
                    $abreviatura = $row['abreviatura'];
                    $descripcion = $row['descripcion'];
                ?>
            <h1>Agregar numeral a la normatividad <b><?php echo $nombre; ?></b></h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Numeral</li>
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
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="normatividad"><font color="white"><i class="fas fa-list"></i> Listar normas</font></a></button>
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
          $idNumeral=$_POST['idNumeral'];
          
          
          if(isset($_POST['botonEditarNumeral'])){
          ?>
             
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <?php 
                    $id=$_POST['idNormatividad'];
                    $query = $mysqli->query("SELECT * FROM numeralNorma WHERE id = '$idNumeral'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $nombre = $row['nombre'];
                    $numeral = $row['numeral'];
                    $descripcion = $row['descripcion'];
                ?>
              <!-- form start -->
              <form role="form" action="controlador/normatividad/controllerNumeral" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Numeral:</label>
                    <input type="text" autocomplete="off"  name="numeral" id="numeral" class="form-control" value="<?php echo $numeral;?>"  placeholder="Numeral" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Nombre:</label>
                    <input type="text" autocomplete="off"  name="nombre" id="nombre" class="form-control" value="<?php echo $nombre;?>"   placeholder="Nombre" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250  || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Descripci&oacute;n:</label>
                    <textarea type="text"  name="descripcion"  class="form-control"  placeholder="Descripci&oacute;n" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || event.charCode == 13)" required><?php echo $descripcion;?></textarea>
                  </div>
                  
                  
      
                  
                </div>
                <!-- /.card-body -->

                 <div class="card-footer" >
                    <input name="idNormatividad" type="hidden" value="<?php echo $id; ?>">
                    <input name="idNumeral" type="hidden" value="<?php echo $idNumeral; ?>">
                    <button type="submit" name="editarNumeral" id="agregarNumeral" class="btn btn-primary float-right">Actualizar</button> 
                     <span id="alerta" style="display:none;color:red;">En el fórmulario no se permite el caracter ( ' ) </span>
                  </div>
                  </form>
                  <div class="card-footer" >
                  <form action="normatividadNumeral" method="POST">
                      <input name="idNormatividad" type="hidden" value="<?php echo $id; ?>">
                    <input name="idNumeral" type="hidden" value="<?php echo $idNumeral; ?>">
                  <button type="submit"  class="btn btn-success float-right">Cerrar</button>
                </div>
              </form>
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
              <form role="form" action="controlador/normatividad/controllerNumeral" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Numeral:</label>
                    <input type="text" autocomplete="off"  name="numeral" id="numeral" class="form-control"  placeholder="Numeral" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250  || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Nombre:</label>
                    <input type="text" autocomplete="off"  name="nombre" id="nombre" class="form-control"   placeholder="Nombre" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Descripci&oacute;n:</label>
                    <textarea type="text"  name="descripcion" class="form-control"   placeholder="Descripci&oacute;n" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || event.charCode == 13)" required></textarea>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                    <input name="idNormatividad" type="hidden" value="<?php echo $id; ?>">
                  <button type="submit" name="agregarNumeral" id="agregarNumeral" class="btn btn-primary float-right">Agregar</button>
                   <span id="alerta" style="display:none;color:red;">En el fórmulario no se permite el caracter ( ' ) </span>
                </div>
              </form>
            </div>
                
            <?php
                }
                /////////////// Fin se valida que botón entra para el formulario de editar o de agregar-....
            ?>
            <script>
                        jQuery('#test').on('keyup', function() {
                           //jQuery(this).parent().append('<p>' + this.checkValidity() + ' ' + this.validity.patternMismatch + '</p>'); 
                        });
                        
                        
                        $('#test').keyup(validateTextarea);
                        
                        function validateTextarea() {
                                var errorMsg = "( ' ) ( '' ).";
                                var textarea = this;
                                var pattern = new RegExp('^' + $(textarea).attr('pattern') + '$');
                                // check each line of text
                                $.each($(this).val().split("\n"), function () {
                                    // check if the line matches the pattern
                                    var hasError = !this.match(pattern);
                                    if (typeof textarea.setCustomValidity === 'function') {
                                        textarea.setCustomValidity(hasError ? errorMsg : '');
                                    } else {
                                        // Not supported by the browser, fallback to manual error display...
                                        $(textarea).toggleClass('error', !!hasError);
                                        $(textarea).toggleClass('ok', !hasError);
                                        if (hasError) {
                                            $(textarea).attr('title', errorMsg);
                                        } else {
                                            $(textarea).removeAttr('title');
                                        }
                                    }
                                    return !hasError;
                                });
                            }
                  </script>
            </div> 

<script>
                       $(document).ready(function () {
                        $("#nombre").keyup(function () {
                                var value = $(this).val();
                                var cadena = document.getElementById('nombre').value;
                                
                                let buscar = "'";
                                
                                let resultado = cadena.indexOf(buscar);
                                
                                if(resultado !== -1){
                                    //console.log("encontrado");
                                    //alert("Encontrado");
                                    document.getElementById('agregarNumeral').style.display = 'none';
                                    document.getElementById('alerta').style.display = '';
                                }else{
                                    //console.log("no encontrado");
                                    document.getElementById('agregarNumeral').style.display = '';
                                    document.getElementById('alerta').style.display = 'none';
                                }
                            });
                        });
                        
                        $(document).ready(function () {
                        $("#numeral").keyup(function () {
                                var value = $(this).val();
                                var cadena = document.getElementById('numeral').value;
                                
                                let buscar = "'";
                                
                                let resultado = cadena.indexOf(buscar);
                                
                                if(resultado !== -1){
                                    //console.log("encontrado");
                                    //alert("Encontrado");
                                    document.getElementById('agregarNumeral').style.display = 'none';
                                    document.getElementById('alerta').style.display = '';
                                }else{
                                    //console.log("no encontrado");
                                    document.getElementById('agregarNumeral').style.display = '';
                                    document.getElementById('alerta').style.display = 'none';
                                }
                            });
                        });
                        
                        $(document).ready(function () {
                        $("#descripcion").keyup(function () {
                                var value = $(this).val();
                                var cadena = document.getElementById('descripcion').value;
                                
                                let buscar = "'";
                                
                                let resultado = cadena.indexOf(buscar);
                                
                                if(resultado !== -1){
                                    //console.log("encontrado");
                                    //alert("Encontrado");
                                    document.getElementById('agregarNumeral').style.display = 'none';
                                    document.getElementById('alerta').style.display = '';
                                }else{
                                    //console.log("no encontrado");
                                    document.getElementById('agregarNumeral').style.display = '';
                                    document.getElementById('alerta').style.display = 'none';
                                }
                            });
                        });
                        
                </script>
        
                
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
                      <th>Numeral</th>
                      <th>Nombre</th>
                      <th>Descripci&oacute;n</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                     $data = $mysqli->query("SELECT * FROM numeralNorma WHERE idNorma = '$id'")or die(mysqli_error());
                     while($row = $data->fetch_assoc()){
                 
                    echo"<tr>";
                    echo" <td>".$row['numeral']."</td>";
                    echo" <td>".$row['nombre']."</td>";
                    echo" <td style='text-align: justify;'>".nl2br($row['descripcion'])."</td>";
                    $idNumeral=$row['id'];
                    echo"<form action='normatividadNumeral' method='POST'>";
                    echo"<input type='hidden' name='idNumeral' value= '$idNumeral' > <input type='hidden' name='idNormatividad' value= '$id' >";
                   
                    echo" <td><button type='submit' name='botonEditarNumeral' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                    echo"</form>";
                    /*
                    echo"<form action='controlador/normatividad/controllerNumeral' method='POST'>";
                    echo"<input type='hidden' name='idNumeral' value= '$idNumeral' > <input type='hidden' name='idNormatividad' value= '$id' >";
                    echo" <td><button onclick='return ConfirmDelete()' type='submit' name='eliminarNumeral' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                    echo"</form>";*/
                    /// validación de script y funcion de eliminacion
                        ?>
                        <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $idNumeral;?>' >
                        <td><a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
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
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>¿Est&aacute; seguro que desea eliminar?</p>
                            </div>
                             <!-- formulario para eliminar por el id -->
                            <form action='controlador/normatividad/controllerNumeral' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormula" name='idNumeral' readonly>
                              <input name="idNormatividad" type="hidden" value="<?php echo $id; ?>">
                                <input name="idNumeral" type="hidden" value="<?php echo $idNumeral; ?>">
                              <button type="submit" name='eliminarNumeral' class="btn btn-outline-light">Si</button>
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
            title: ' El numeral ya existe.'
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
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
</body>
</html>
<?php
}
?>