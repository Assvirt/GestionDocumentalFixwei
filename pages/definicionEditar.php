<?php
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
  <title>FIXWEI - Editar definición</title>
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
<body class="hold-transition sidebar-mini" onload="nobackbutton();" >
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
            <h1>Editar definición</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Editar definición</li>
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
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="definicion"><font color="white"><i class="fas fa-list"></i> Listar definición</font></a></button>
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
                
                $id = $_POST['idDefinicion']; 
                $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $query = $mysqli->query("SELECT * FROM definicion WHERE id = '$id'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $nombre = $row['nombre'];
                    $nombreN = $row['nombreN'];
                    $definicion = $row['definicion'];
                    $fuente = $row['fuente'];
                    
                    if($nombreN > 0){
                        if($nombreN != NULL ){
                            $nombreS = $row['nombreN'];
                        }
                    }else{
                        if($nombre != NULL){
                        $nombreS = $row['nombre'];    
                        }
                        
                    }
                    
                    
                ?>
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/definicion/controladordefinicion" method="POST"> <!--  -->
                <div class="card-body">
                  <div class="form-group">
                    <label>Nombre:</label>
                    <input autocomplete="off" pattern="[^'\x22]+" type="text" class="form-control" id="nombre" value="<?php echo $nombreS; ?>" name="nombre" placeholder="Nombre" onkeypress="return ( (event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 || event.charCode == 44 || event.charCode == 46)" required>
                  </div>
                  
                  <div class="form-group">
                    <label>Definici&oacute;n:</label>
                    <textarea type="text" class="form-control"  name="definicion" placeholder="Descripción"    required><?php echo $definicion; ?></textarea>
                  </div>
                  <div class="form-group">
                    <label>Fuente:</label>
                    <textarea type="text"  class="form-control"  name="fuente"  placeholder="Fuente" ><?php echo $fuente; ?></textarea>
                  </div>

                </div>
                <!-- /.card-body pattern="[^'\22]+" id="test2" -->

                <div class="card-footer" >
                  <input type="hidden" name="idDefinicion" value="<?php echo $id ;?>">
                  <button type="submit" class="btn btn-primary float-right" name="EditarDefinicion" id="agregarNorma">Actualizar</button>
                  <span id="alerta" style="display:none;color:red;">En el fórmulario no se permite el caracter ( ' ) </span>
                </div>
              </form>
              <script>
                 ///// definición
                    jQuery('#test').on('keyup', function() {
                       //jQuery(this).parent().append('<p>' + this.checkValidity() + ' ' + this.validity.patternMismatch + '</p>'); 
                    });
                    
                    
                    $('#test').keyup(validateTextarea);
                    
                    function validateTextarea() {
                            var errorMsg = "Caracteres invalidos ( ' )";
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
                        
                 ///// fuente
                 jQuery('#test2').on('keyup', function() {
                       //jQuery(this).parent().append('<p>' + this.checkValidity() + ' ' + this.validity.patternMismatch + '</p>'); 
                    });
                    
                    
                    $('#test2').keyup(validateTextarea2);
                    
                    function validateTextarea2() {
                            var errorMsg2 = "Caracteres invalidos ( ' )";
                            var textarea = this;
                            var pattern = new RegExp('^' + $(textarea).attr('pattern') + '$');
                            // check each line of text
                            $.each($(this).val().split("\n"), function () {
                                // check if the line matches the pattern
                                var hasError = !this.match(pattern);
                                if (typeof textarea.setCustomValidity === 'function') {
                                    textarea.setCustomValidity(hasError ? errorMsg2 : '');
                                } else {
                                    // Not supported by the browser, fallback to manual error display...
                                    $(textarea).toggleClass('error', !!hasError);
                                    $(textarea).toggleClass('ok', !hasError);
                                    if (hasError) {
                                        $(textarea).attr('title', errorMsg2);
                                    } else {
                                        $(textarea).removeAttr('title');
                                    }
                                }
                                return !hasError;
                            });
                        }
                 </script>
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
                                    document.getElementById('agregarNorma').style.display = 'none';
                                    document.getElementById('alerta').style.display = '';
                                }else{
                                    //console.log("no encontrado");
                                    document.getElementById('agregarNorma').style.display = '';
                                    document.getElementById('alerta').style.display = 'none';
                                }
                            });
                        });
                        
                        $(document).ready(function () {
                        $("#fuente").keyup(function () {
                                var value = $(this).val();
                                var cadena = document.getElementById('fuente').value;
                                
                                let buscar = "'";
                                
                                let resultado = cadena.indexOf(buscar);
                                
                                if(resultado !== -1){
                                    //console.log("encontrado");
                                    //alert("Encontrado");
                                    document.getElementById('agregarNorma').style.display = 'none';
                                    document.getElementById('alerta').style.display = '';
                                }else{
                                    //console.log("no encontrado");
                                    document.getElementById('agregarNorma').style.display = '';
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
                                    document.getElementById('agregarNorma').style.display = 'none';
                                    document.getElementById('alerta').style.display = '';
                                }else{
                                    //console.log("no encontrado");
                                    document.getElementById('agregarNorma').style.display = '';
                                    document.getElementById('alerta').style.display = 'none';
                                }
                            });
                        });
                        
                </script>
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
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>
</body>
</html>
<?php
}
?>