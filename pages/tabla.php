<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
require_once 'conexion/bd.php';

//////////////////////PERMISOS////////////////////////

$formulario = 'usuarios'; //Se cambia el nombre del formulario

require_once 'permisosPlataforma.php';


//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
    <title>Usuarios</title>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Usuarios</title>
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
            <h1>Usuarios</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Usuarios</li>
            </ol>
          </div>
        </div>
        <div>
            <?php
                if($visibleI == FALSE){
            ?>
            <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarUsuario"><font color="white"><i class="fas fa-plus-square"></i> Agregar</font></a></button>
            </div>

            <div class="col-sm">
                <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='exportacion/usuarios'"><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
            </div>
            
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="importacion/importar-usuario/usuario.xlsx" onClick="javascript:document["ver-form"].submit();"><font color="white"><i class="fas fa-cloud-download-alt"></i> Descargar Plantilla</font></a></button>
            </div>

            <div class="col-sm">
                <form action="importacion/importar-usuario/index" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                    <div class="custom-file">
                        <input type="file" name="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Importar archivo</label>
                        
                    </div>
            </div>
            <div class="col-sm">
                <button type="submit" name="import" class="btn btn-block btn-info btn-sm"><a class="" href="#"><font color="white"><i class="fas fa-file-upload"></i> Importar</font></a></button>
            </div>
            </form>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-danger btn-sm"><a href="usuariosEliminados"><font color="white"><i class="fas fa-list"></i> Usuarios eliminados</font></a></button>
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
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                  <?php 
                    require 'conexion/bd.php';
                    $Contadordata = $mysqli->query("SELECT count(*) FROM usuario WHERE estadoEliminado = 0 ")or die(mysqli_error());
                    $ContadorUsuarios= $Contadordata -> fetch_array(MYSQLI_ASSOC);
                    $cantidadUsuarios=$ContadorUsuarios['count(*)'];
                  
                  ?>
                  
                
                <h3 class="card-title" style="color:green;font-size:17px;"><?php echo $cantidadUsuarios; ?> usuarios activos</h3>
                <br>
             
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 800px;">
                 
                  
                  <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>Nombre y apellidos</th>
                      <th>Documento</th>
                      <th>Cargo</th>
                      <th class='text-left'>Estado</th>
                      <th>Ver más</th>
                      <th style="display:<?php echo$visibleE;?>;">Editar</th>
                      <th style="display:<?php echo$visibleD;?>;">Eliminar</th>
                      <th style="display:<?php echo$visibleD;?>;">Anular</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                     $consultaBuscar=$_POST['buscar'];
                     $consultaBuscar1=$_POST['buscar1'];
                     $consultaBuscar2=$_POST['buscar2'];
                     $consultaBuscar3=$_POST['buscar3'];
                     
                     
                     if($consultaBuscar != NULL || $consultaBuscar1 != NULL || $consultaBuscar2 != NULL || $consultaBuscar3 != NULL){
                         
                         if($consultaBuscar3 != NULL){
                         ///// se trae la consulta de la 3
                         $queryJefeInmediatoConsulta=$mysqli->query("SELECT * FROM cargos WHERE nombreCargos LIKE  '%$consultaBuscar3%' ");
    	                 $rowConsulta=$queryJefeInmediatoConsulta->fetch_array(MYSQLI_ASSOC);
    	                 $nombreJefeInmediato=$rowConsulta['id_cargos'];
    	                 ///////// fin
                         }
                         
                        $data = $mysqli->query("SELECT * FROM usuario WHERE estadoEliminado = 0 AND nombres LIKE '%$consultaBuscar%' AND apellidos LIKE '%$consultaBuscar1%' AND cedula like '%$consultaBuscar2%' AND cargo LIKE '%$nombreJefeInmediato%' ORDER BY nombres ASC")or die(mysqli_error());
                     
                         
                     }else{
                        $data = $mysqli->query("SELECT * FROM usuario WHERE estadoEliminado = 0 ORDER BY nombres ASC")or die(mysqli_error());
                     }
                     while($row = $data->fetch_assoc()){
                        $idEdit = $row['id'];
                    echo"<tr>";
                    echo "<td>".$row['nombres']." ".$row['apellidos']."</td>";
                    echo" <td>".$row['cedula']."</td>";
                    $id = $row['cedula'];
                    
                    //CARGO               
                    $roles=$row['cargo'];
                    $acentos = $mysqli->query("SET NAMES 'utf8'");
                    $validacionRoles = $mysqli->query("SELECT * from cargos WHERE id_cargos = '$roles' ");
                    $roles = $validacionRoles->fetch_array(MYSQLI_ASSOC);
                    $rol = $roles['nombreCargos'];
                    
                    if($roles != NULL){
            	        echo "<td>" . $rol . "</td>";
            	    }else{
            	        echo "<td><b>" .  'No aplica' . "</b></td>";
            	    }//FIN CARGO
            	    
            	    if($row['estadoAnulado'] != TRUE){
            	        echo "<td class='text-left'><b><i class='nav-icon far fa-circle text-success'></i> Activo</b></td>";
            	    }
            	    
            	    if($row['estadoAnulado'] == TRUE){
            	        echo "<td class='text-left'><b><i class='nav-icon far fa-circle text-danger'></i> Anulado</b></td>";
            	    }
                    
                    
                    $botonValidar = $row['estadoAnulado'];
                                        
                    echo"<form action='usuariosVer' method='POST'>";
                    echo"<input type='hidden' name='idUsuario' value= '$id' >";
                    echo"<td><button type='submit' class='btn btn-block btn-primary btn-sm'><i class='fas fa-eye'></i> Ver más</button></td>";
                    echo"</form>";
                    echo"<form action='usuariosEditar' method='POST'>";
                    echo"<input type='hidden' name='idUsuario' value= '$idEdit' >";
                    echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                    echo"</form>";
                    echo"<form action='controlador/usuarios/controladorUsuarios' method='POST'>";
                    echo"<input type='hidden' name='idUsuario' value= '$idEdit' >";
                    echo" <td style='display:$visibleD;'><button onclick='return ConfirmDelete()' type='submit' name='EliminarUsuario' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                    echo"</form>";
                    if($botonValidar == 0 || $botonValidar == NULL ){
                        echo"<form action='controlador/usuarios/controladorUsuarios' method='POST'>";
                        echo"<input type='hidden' name='idUsuario' value= '$id' >";
                        echo" <td style='display:$visibleD;'><button onclick='return ConfirmAnular()' type='submit' name='AnularUsuario' class='btn btn-block btn-warning btn-sm'><i class='fas fa-minus-circle'></i> Anular</button></td>";
                        echo"</form>";
                    }else{
                        echo"<form action='controlador/usuarios/controladorUsuarios' method='POST'>";
                        echo"<input type='hidden' name='idUsuario' value= '$id' >";
                        echo" <td style='display:$visibleD;'><button style='background:yellow;' type='submit' name='ActivarUsuario' class='btn btn-block btn-warning btn-sm'><i class='fas fa-lightbulb'></i> Activar</button></td>";
                        echo"</form>";
                        echo"</tr>";
                    }
                        
                    } 
                    ?>
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
	function ConfirmAnular(){
		var answer = confirm("¿Esta seguro de anular?");

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
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>
<!-- END -->    
</body>
</html>
<?php
}
?>


 