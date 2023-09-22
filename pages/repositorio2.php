<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

//rename("repositorio/año 2020/","repositorio/años 2020");


if(isset($_POST['rutaAtras'])){
    $rutaVer = $_POST['rutaAtras'];
    
    if($rutaVer != "raiz/"){
        
    }
    
    //echo "Ruta Atras:".$rutaAtras;echo "<br>";
    //echo "Ruta actual:".$rutaVer; echo "<br>";
            
    $rutaDividida = explode('/',$rutaVer);
           
            
    //echo "n1: ". 
    $n1 = count($rutaDividida)-1;// echo "<br>";
    //echo "n2: ".
    $n2 = count($rutaDividida)-2;// echo "<br>";
            
    unset($rutaDividida[$n1],$rutaDividida[$n2]);
            
    $tamano = count($rutaDividida);
            
    $rutaAtras = "";
    
    if($tamano != 0){
          
        for($i = 0; $i < $tamano ;$i++){
        
            $rutaAtras .= $rutaDividida[$i]."/";
                    
        }
    }

    //echo "<br>";
    //echo "Ruta Atras:".$rutaAtras;echo "<br>";
    
}else{
    
    $subCarperta = $_POST['verCarpeta'];//Recibo el nombre de la carpeta que quiero ver 

    if($subCarperta != NULL){
        
        if(opendir($_SESSION["ruta_carpeta"])){
            //$rutaAtras = $_SESSION["ruta_carpeta"];
            
            $_SESSION["ruta_carpeta"] .= $subCarperta."/";
            $rutaVer=$_SESSION["ruta_carpeta"];
        }else{
            //$_SESSION["ruta_carpeta"] = "repositorio/";
            //$rutaVer = "repositorio/";
        }
        
    }else{
        $_SESSION["ruta_carpeta"] = "raiz/";
        $rutaVer = "raiz/";
        
        if(isset($_POST['verCarpetaCreada'])){
            $rutaVer=$_POST['verCarpetaCreada'];
            $_SESSION["ruta_carpeta"] = $rutaVer;
        }
        
    }
    
    //echo "Ruta Atras:".$rutaAtras;echo "<br>";
    //echo "Ruta actual:".$rutaVer; echo "<br>";
        
    $rutaDividida = explode('/',$rutaVer);
           
            
    $n1 = count($rutaDividida)-1; 
    $n2 = count($rutaDividida)-2; 
            
    unset($rutaDividida[$n1],$rutaDividida[$n2]);
            
    $tamano = count($rutaDividida);
            
    //$nombreEditar = $rutaDividida[$tamano];
            
    $rutaAtras = "";
    
    if($tamano != 0){
        
        for($i = 0; $i < $tamano;$i++){
    
            $rutaAtras .= $rutaDividida[$i]."/";
                    
        }
        
    }
    
    //echo "<br>";
    //echo "Ruta Atras:".$rutaAtras;echo "<br>";
    
}

if(isset($_POST['verCarpetaCreada'])){
    $rutaVer=$_POST['verCarpetaCreada'];
    $_SESSION["ruta_carpeta"] = $rutaVer;
}


/*Extraer nombre actual carpeta*/

    $dividir = explode('/',$rutaVer);
    //print_r($dividir);
     $countDividir = count($dividir)-2;
     $nombreEditar = $dividir[$countDividir];



require_once 'conexion/bd.php';

//////////////////////PERMISOS////////////////////////

$formulario = 'repositorio'; //aqui se cambia el nombre del formulario

require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Repositorio</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
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
            <h1>Repositorio</h1>
            <h6>Gestione la información documentada y/u otros archivos de su compañía.</h6><br>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Repositorio</li>
            </ol>
          </div>
        </div>
        <div>
            <?php
                if($visibleI == FALSE){
            ?>
            <div class="row">
             
            <div class="col-sm">
                <form action="cargarRegistros" method="POST" target="_blank">
                    <input type="hidden" name="rutaSubir" value="<?php echo $rutaVer;?>">          
                    <button type="submit" class="btn btn-block btn-info btn-sm float-right"> <i class="fas fa-file-upload"></i> Subir Archivo</button>
                </form>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm" data-toggle="modal" data-target="#modal-carpeta"><font color="white"><i class="fas fa-plus-square"></i> Nueva carpeta</font></button>
            </div>
            <div class="col-sm">
                <form action="listaRegistros" method="POST" target="_blank">
                    <input type="hidden" name="ruta" value="<?php echo $rutaVer;?>">          
                    <button type="submit" id="enviar" class="btn btn-block btn-primary btn-sm float-right"> <i class="fas fa-eye"></i> Ver Más</button>
                </form>
            </div>
            <div class="col sm">
                <button type="submit" data-toggle="modal" data-target="#modal-editar-carpeta" class="btn btn-block btn-success float-left btn-sm" name="EditarCarpeta"><i class="fas fa-edit"></i> Editar </button>
                <form action="controlador/repositorio/controllerRepositorio.php" method="POST">
                           
                    <input type="hidden" value="<?php echo $rutaVer;?>" name='rutaEliminar'>
                            
                </form>
            </div>
            <div class="col sm">
                <form action="controlador/repositorio/controllerRepositorio.php" method="POST">
                    <button type="submit" onclick='return ConfirmAnular()' class="btn btn-block btn-danger float-left btn-sm" name="EliminarCarpeta"><i class="fas fa-trash-alt"></i> Eliminar</button>
                    <input type="hidden" value="<?php echo $rutaVer;?>" name='rutaEliminar'>
                </form>
            </div>
            <div class="col sm">
                <form action="controlador/repositorio/controllerRepositorio.php" method="post">
                    <button type="submit" id="enviar" class="btn btn-block btn-warning float-left btn-sm" name="dato"><i class="fas fa-sun"></i> DATO</button>
                    <input type="hidden" value="<?php echo $rutaVer;?>" name=''>
                </form>
            </div>   
                                
            <div class="col-sm">
            </div>
            
            <div class="col-sm">
            </div>
            <div class="col-sm">
            </div>
            </div>
            <?php }else{?>
            <div class="row">
                <div class="col-sm">
                    <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/usuarios'"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
                </div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
                <div class="col-sm"></div>
            </div>

            <?php }?>
        </div>
      </div><!-- /.container-fluid -->
      
      <!--Modals-->
        <div class="modal fade" id="modal-carpeta">
            <div class="modal-dialog">
              <div class="modal-content">
                  <form action="controlador/repositorio/controllerRepositorio.php" method="POST">
                    <div class="modal-header">
                      <h4 class="modal-title">Crear carpeta</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                
                      <label>Nombre carpeta:</label><br>
                      <input type="text" name="nombreCarpeta" placeholder="Nombre carpeta" class="form-control">
                      <input type="hidden" name="rutaCarpeta" value="<?php echo $rutaVer;?>">
                      <div class="form-group ">
                        <label>Autorizados para Visualizar: </label><br>
                            <input type="radio" id="rad_cargoAut" name="radiobtnAut" value="cargo">
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioAut" name="radiobtnAut" value="usuario">
                            <label for="usuarios">Usuarios</label>
                            <input type="radio" id="rad_grupoAut" name="radiobtnAut" value="grupo">
                            <label for="grupos">Grupos</label>
                            
                            <div class="select2-blue" id="listarCargos" style="display:none;">
                                
                                <label></label>
                                <!--  <select class="duallistbox" id="select_encargadoAut" name="select_encargadoAut[]" multiple="multiple">
                                   
                                </select>
                                    <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar aprobador" style="width: 100%;" name="select_encargadoAut[]" id="select_encargadoAut" required></select>
                            -->
                                 <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $consultaCargos=$mysqli->query("SELECT * FROM cargos");
                                ?>
                                <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar..." style="width: 100%;" name="select_encargadoAut[]"  >
                                    <?php
                                    while($extraerCargos=$consultaCargos->fetch_array()){
                                    ?>
                                    <option value="<?php echo $extraerCargos['id_cargos']; ?>"><?php echo $extraerCargos['nombreCargos']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="select2-blue" id="listarUsuarios" style="display:none;">
                                
                                <label></label>
                                <!--  <select class="duallistbox" id="select_encargadoAut" name="select_encargadoAut[]" multiple="multiple">
                                   
                                </select>
                                    <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar aprobador" style="width: 100%;" name="select_encargadoAut[]" id="select_encargadoAut" required></select>
                            -->
                                 <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $consultaCargos=$mysqli->query("SELECT * FROM usuario");
                                ?>
                                <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar..." style="width: 100%;" name="select_encargadoAut[]"  >
                                    <?php
                                    while($extraerCargos=$consultaCargos->fetch_array()){
                                    ?>
                                    <option value="<?php echo $extraerCargos['id']; ?>"><?php echo $extraerCargos['nombres'].' '.$extraerCargos['apellidos']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="select2-blue" id="listarGrupos" style="display:none;">
                                
                                <label></label>
                                <!--  <select class="duallistbox" id="select_encargadoAut" name="select_encargadoAut[]" multiple="multiple">
                                   
                                </select>
                                    <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar aprobador" style="width: 100%;" name="select_encargadoAut[]" id="select_encargadoAut" required></select>
                            -->
                                 <?php
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $consultaGrupo=$mysqli->query("SELECT * FROM grupo");
                                ?>
                                <select class="duallistbox" multiple="multiple" data-placeholder="Seleccionar..." style="width: 100%;" name="select_encargadoAut[]"  >
                                    <?php
                                    while($extraerGrupo=$consultaGrupo->fetch_array()){
                                    ?>
                                    <option value="<?php echo $extraerGrupo['id']; ?>"><?php echo $extraerGrupo['nombre']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                      </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button type="submit" name="crearSubCarpeta" class="btn btn-primary">Crear carpeta</button>
                    </div>
                </form>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <!--Modals editar carpeta
        <div class="modal fade" id="modal-editar-carpeta">
            <div class="modal-dialog">
              <div class="modal-content">
                  <form action="controlador/repositorio/controllerRepositorio.php" method="POST">
                    <div class="modal-header">
                      <h4 class="modal-title">Editar nombre carpeta</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                
                      <label>Nombre carpeta:</label><br>
                      <input type="text" name="nombreCarpeta" placeholder="Nombre carpeta" value="< ?php echo $nombreEditar;?>" class="form-control">
                      <input type="hidden" name="rutaCarpeta" value="< ?php echo $rutaVer;?>">
                      <input type="hidden" name="rutaAtras" value="< ?php echo $rutaAtras;?>">
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button type="submit" name="editarSubCarpeta" class="btn btn-primary">Editar carpeta</button>
                    </div>
                </form>
              </div>
              <!-- /.modal-content 
            </div>-->
            <!-- /.modal-dialog
        </div> -->
        <!-- /.modal -->
        

      
      
    </section>

    
       
        
        <!-- /.col -->
        
        <?php
        $acentos = $mysqli->query("SET NAMES 'utf8'");
            $data = $mysqli->query("SELECT * FROM registros WHERE carpeta = '$rutaVer'");
            $numRegistros = mysqli_num_rows($data);
            
             $_SESSION["ruta_carpeta"] = $rutaVer;
            
            if($rutaVer == "raiz/"){
                $ocultaAtras = false;
            }else{
                $ocultaAtras = true;
            }
            
            
        ?>
        
        
       
         
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                  <?php
                    if($ocultaAtras){
                  ?>
                  <div class="col sm-3">
                        
                        <form action="" method="POST">
                            <button type="submit" class="btn btn-primary float-right btn-sm" name="AgregarRegistro"><i class="fa fa-arrow-left"></i></button>
                            <input type="hidden" value="<?php echo $rutaAtras;?>" name='rutaAtras'>
                        </form>
                    </div>
                    <?php
                    }
                    ?>
                    
              </div>      
              
            
                 <!--     <h3 class="card-title">Directorio Actual: < ?php echo $rutaVer; ?>< ?php echo $mensaje;?></h3><br>
                      <h3 class="card-title">Ruta atras: < ?php echo $rutaAtras;?></h3><br>
                      <h3 class="card-title">Registros: < ?php echo $numRegistros; ?></h3> --->
                         
                        
                        
              <!--          <div class="row" style="display:< ?php echo $ocultaAtras;?>">
                    
                    <div class="col sm-4">
                        <form action="controlador/repositorio/controllerRepositorio.php" method="POST">
                            <button type="submit" onclick='return ConfirmAnular()' class="btn btn-danger float-left btn-sm" name="EliminarCarpeta"><i class="fa fa-trash"></i>Eliminar carpeta</button>
                            <input type="hidden" value="< ?php echo $rutaVer;?>" name='rutaEliminar'>
                        </form>
                    </div>
                    
                    <div class="col sm-4">
                         <button type="submit" data-toggle="modal" data-target="#modal-editar-carpeta" class="btn btn-success float-left btn-sm" name="EditarCarpeta"><i class="fa fa-trash"></i>Editar nombre carpeta</button>
                        <form action="controlador/repositorio/controllerRepositorio.php" method="POST">
                           
                            <input type="hidden" value="< ?php echo $rutaVer;?>" name='rutaEliminar'>
                            
                        </form>
                    </div>
                    
                    <div class="col sm-3">
                        
                        <form action="" method="POST">
                            <button type="submit" class="btn btn-primary float-right btn-sm" name="AgregarRegistro"><i class="fa fa-arrow-left"></i></button>
                            <input type="hidden" value="< ?php echo $rutaAtras;?>" name='rutaAtras'>
                        </form>
                    </div>
                    
                </div>    
                
                
                
                
            </div>
            <!-- /.card-header -->
                   <?php
                            /*echo $rutaVer;
                            
                            echo "SESION:".$_SESSION["ruta_carpeta"];echo "<br>";
                            echo "Ruta ve: ".$rutaVer;
                            echo "<br>";*/
                            
                            
                            $directorio = opendir($rutaVer);
                            ?>
                <div class="card-body table-responsive p-0">
                    <table class="table table-head-fixed text-center" id="example">
                                      <thead>
                                        <tr>
                                            <th>Seleccionar</th>
                                            <th>Nombre</th>
                                            <th>Tipo Documento</th>
                    
                                        </tr>
                                      </thead>
                                      <tbody>
                                          
                                    
                                    <?
                                  
                                  while($elemento = readdir($directorio)){
                                        if($elemento != '.' && $elemento != '..'){
                                            
                                            //////////////// CARPETAS
                                                $var = "../../".$rutaVer.$elemento;
                                                //echo $var;
                                                $datos = $mysqli->query("SELECT * FROM repositorioCarpeta WHERE ruta = '$var'");
                                                $extraerDatos = $datos->fetch_array(MYSQLI_ASSOC);
                                                
                                                //// permiso de visualizar carpetas
                                                $permisoVerMas = FALSE;
                                                $quienElabora = $extraerDatos["visualizar"];
                                                $quienElaboraID = json_decode($extraerDatos["visualizarID"]);
                                                if($quienElabora == "cargo"){
                                                    if(in_array($cargo,$quienElaboraID)){
                                                        $permisoVerMas = TRUE;
                                                    }
                                                }
                                                
                                                if($quienElabora == "usuario"){
                                                    if(in_array($idparaChat,$quienElaboraID)){
                                                        $permisoVerMas = TRUE;
                                                    }
                                                }
                                                
                                                $consultarIdGrupo=$mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario='$sesion' ");
                                                while($extraerGruposId=$consultarIdGrupo->fetch_array()){
                                                   $enviarIdGrupo=$extraerGruposId['idGrupo']; 
                                                }
                                                
                                                
                                                if($quienElabora == "grupo"){
                                                    if(in_array($enviarIdGrupo,$quienElaboraID)){
                                                        $permisoVerMas = TRUE;
                                                    }
                                                }
                                                
                                                if($permisoVerMas == FALSE){
                                                    $habilitarVisualizar = "disabled";
                                                }else{
                                                    $habilitarVisualizar = "";
                                                }
                                                //// END
                                                
                                                
                                            ///// END
                                            
                                            
                                            
                                            
                                            if($habilitarVisualizar == 'disabled'){
                                                    continue;
                                                }
                                             ?>
                                    <tr>
                                        
                                        <td class=""><form id="formid"><input type="checkbox" name="countries" value="<?php echo $elemento;?>"></form></td>
                                        <td class="">
                                                <?    
                                    
                                        if(is_dir($rutaVer.$elemento)){
                                            
                                            
                                     ?>
                                                 <div class="">
                                                     <form action="" method="POST">
                                                         <button class="btn" type="submit"><span style=" color: blue;  " ><i class="fa fa-folder fa-2x" ></i></span>
                                                         <span style="float:right; padding:5; "><h6><?php echo $elemento;?></h6></span>
                                                         </button>
                                                         <input type="hidden" name="verCarpeta" value="<?php echo $elemento;?>">
                                                         <input type="hidden" name="nombreCarpeta" value="<?php echo $elemento;?>">
                                                     </form>
                                                 </div>
                                     <?php
                                        }else{
                                            ?>
                                            
                                                 <button class="btn" type="submit"><span style=" color: gray;  " ><i class="fas fa-file-alt fa-2x " ></i></span><span style="float:right; padding:5; " ><h6><?php echo $elemento;?></h6></span></button>
                                             
                                            <?php
                                        }
                                    
                                    ?>
                                        </td>
                                        <div class="">
                                        <td class=""><?php
                                        
                                        if(is_dir($rutaVer.$elemento)){
                                           echo "Carpeta";
                                        }else{
                                           echo "Archivo"; 
                                        }
                                    } 
                                        
                                        
                                        ?></td>
                                        </div>
                                    </tr>
                                      <?
                                  }
                              
                              ?>
                         </tbody>
                        </table>     
                </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid --> 
    </section>  
     
     
   
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
<script>
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
</script>
<!-- Select2 -->
<script src="../plugins/select2/js/select2.full.min.js"></script>
<script type="text/javascript">
	function ConfirmDelete(){
		var answer = confirm("¿Esta seguro de eliminar?");

		if(answer == true){
			return true;
		}else{
			return false;
		}
	}
	function ConfirmAnular(){
		var answer = confirm("¿Esta seguro de anular?");

		if(answer == true){
			return true;
		}else{
			return false;
		}
	}
</script>
<script>
function myFunction() {
  alert("I am an alert box!");
}
</script>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    
    function ConfirmAnular(){
		var answer = confirm("¿Esta seguro de eliminar esta carpeta? Recuerde que al borrar una carpeta eliminara todos sus registros.");

		if(answer == true){
			return true;
		}else{
			return false;
		}
	}
</script>
<!-- archivos para el filtro de busqueda y lista de información -->

    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>
<!-- END -->
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
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
<script type="text/javascript">
$(document).ready(function() {
    $('#enviar').click(function(){
        var selected = '';    
        $('#formid input[type=checkbox]').each(function(){
            if (this.checked) {
                selected += $(this).val()+', ';
            }
        }); 

        if (selected != '') 
            alert('Has seleccionado: '+selected);  
        else
            alert('Debes seleccionar  una opción.');

        return false;
    });         
});    
</script>


</body>
</html>
<?php
}
?>