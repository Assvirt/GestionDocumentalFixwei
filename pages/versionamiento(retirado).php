<?php
session_start();
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
  <title>FIXWEI - Versión y consecutivo</title>
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
            <h1>Versión y consecutivo</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Versión y consecutivo</li>
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
    
<!--
    <section class="content">
      <div class="container-fluid">
        <!-- /.row
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
            <!-- /.card
          </div>
          <div class="col"></div>
        </div>
        <!-- /.row 
      </div><!-- /.container-fluid
    </section>
    
-->

    <?php
    
    if(isset($_POST['editar'])){
        
        $idEditar = $_POST['idEditar'];
        $datos = $mysqli->query("SELECT * FROM versionamiento WHERE id = '$idEditar'");
        $datosCod = $datos->fetch_array(MYSQLI_ASSOC);
        
        $idProceso = $datosCod['idProceso'];
        $idTipoDoc = $datosCod['idTipoDocumento'];
        
        
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
                <h3 class="card-title">Versión y consecutivo</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/versiones/versionamineto.php" method="POST">
                  <input name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-sm-6">
                        <label>Proceso:</label>
                            <?php
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT * FROM procesos ORDER BY nombre");
                            ?>
                            <select type="text" class="form-control" id="proceso" name="idProceso" placeholder="Proceso" required>
                                <option value=''>Seleccionar proceso</option>
                                <?php
                                while ($columna = mysqli_fetch_array( $resultado )) {
                                    if($idProceso == $columna['id']){
                                        $selectProceso="selected";
                                    }else{
                                        $selectProceso="";
                                    }
                                
                                ?>
                                <option value="<?php echo $columna['id']; ?>" <?php echo $selectProceso; ?>><?php echo $columna['nombre']; ?> </option>
                                <?php }  ?>
                            </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Tipo de documento:</label>
                        <?php
                            require_once'conexion/bd.php';
                            $mysqli->query("SET NAMES 'utf8'");
                            $resultado=$mysqli->query("SELECT * FROM tipoDocumento ORDER BY nombre");
                            ?>
                        <select type="text" class="form-control" id="idTipoDoc" name="idTipoDoc" placeholder="" required>
                            <option value=''>Seleccionar tipo documento</option>
                            <?php
                                while ($columna = mysqli_fetch_array( $resultado )) { 
                                    if($idTipoDoc == $columna['id']){
                                        $selectTipoDoc ="selected";
                                    }else{
                                        $selectTipoDoc ="";
                                    }
                                ?>
                                <option value="<?php echo $columna['id']; ?>" <?php echo $selectTipoDoc; ?>><?php echo $columna['nombre']; ?> </option>
                            <?php }  ?>
                        </select>
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label>Versión incial:</label>
                        <input type="number" class="form-control" value="<?php echo $datosCod['versionInicial'];?>" name="versionInicial" min='1' >
                    </div>
                            
                    <div class="form-group col-sm-6">
                        <label>Consecutivo:</label>
                        <input type="number" class="form-control" value="<?php echo $datosCod['consecutivoInicial'];?>" name="consecutivoInicial" min='1' >
                    </div>
                    
                  </div>


                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                    <input type="hidden" name='idEditar' value="<?php echo $idEditar; ?>">
                  <button type="submit" name="actualizar" class="btn btn-primary float-right">Actualizar</button>
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
    
    <?php
        
    }else{
    
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
                <h3 class="card-title">Codificación de documentos</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/versiones/versionamineto.php" method="POST">
                  <input name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-sm-6">
                        <label>Proceso:</label>
                            <?php
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT * FROM procesos ORDER BY nombre");
                            ?>
                            <select type="text" class="form-control" id="proceso" name="idProceso" placeholder="Proceso" required>
                                <option value=''>Seleccionar proceso</option>
                                <?php
                                while ($columna = mysqli_fetch_array( $resultado )) { ?>
                                <option value="<?php echo $columna['id']; ?>"><?php echo $columna['nombre']; ?> </option>
                                <?php }  ?>
                            </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Tipo de documento:</label>
                        <?php
                            require_once'conexion/bd.php';
                            $mysqli->query("SET NAMES 'utf8'");
                            $resultado=$mysqli->query("SELECT * FROM tipoDocumento ORDER BY nombre");
                            ?>
                        <select type="text" class="form-control" id="idTipoDoc" name="idTipoDoc" placeholder="" required>
                            <option value=''>Seleccionar tipo documento</option>
                            <?php
                                while ($columna = mysqli_fetch_array( $resultado )) { ?>
                                <option value="<?php echo $columna['id']; ?>"><?php echo $columna['nombre']; ?> </option>
                            <?php }  ?>
                        </select>
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label>Versión incial:</label>
                        <input type="number" class="form-control" name="versionInicial" min='1' >
                    </div>
                            
                    <div class="form-group col-sm-6">
                        <label>Consecutivo:</label>
                        <input type="number" class="form-control" name="consecutivoInicial" min='1' >
                    </div>
                    
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
                  <button type="submit" name="agregar" class="btn btn-primary float-right">Agregar</button>
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
    <?php
    }
    ?>
    
    
    
    
    <?php
        if($visibleD == FALSE){
    ?>
    
    <!-- Main content table add-->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col">
            </div>
            <div class="col-12">
                <div class="card">
              <div class="card-header">
                <h3 class="card-title">Orden codificación</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-condensed text-center">
                  <thead>
                    <tr>
                      <th>Proceso</th>
                      <th>Tipo de documento</th>
                      <th style="width: 10px">Versión</th>
                      <th style="width: 10px">Consecutivo</th>
                      <th style="width: 200px">Editar</th>
                      <th style="width: 200px">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php
                     
                     $data = $mysqli->query("SELECT * FROM versionamiento ORDER BY id")or die(mysqli_error());
                     $n = 1;
                     while($row = $data->fetch_assoc()){
                         
                     $tipo = $row['idTipoDocumento'];
                     //$tipo = 4;
                     $nombreTipoDocumento = $mysqli->query("SELECT * FROM tipoDocumento WHERE id ='$tipo'")or die(mysqli_error($mysqli));
                     $colu = $nombreTipoDocumento->fetch_array(MYSQLI_ASSOC);
                     $nombreT = $colu['nombre'];
                     
                     $proceso =  $row['idProceso'];
                     $nombreProceso = $mysqli->query("SELECT * FROM procesos WHERE id ='$proceso'")or die(mysqli_error());
                     $col3 = $nombreProceso->fetch_array(MYSQLI_ASSOC);
                     $nombreP = $col3['nombre'];
                         
                    $idDel =$row['id'];
                    echo"<tr>";
                    echo" <td>".$nombreP."</td>";
                    echo" <td>".$nombreT."</td>";
                    echo" <td>".$row['versionInicial']."</td>";
                    echo" <td>".$row['consecutivoInicial']."</td>";
                    echo"<td>
                        <form action='' method='POST'>
                            <input type='hidden' value='$idDel' name='idEditar'>
                            <button style='display:$visibleD;' type='submit' name='editar' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button>
                        </form>
                    </td>";
                    echo"<td>
                        <form action='controlador/versiones/versionamineto.php' method='POST'>
                            <input type='hidden' value='$idDel' name='idDel'>
                            <button style='display:$visibleD;' onclick='return ConfirmDelete()' type='submit' name='eliminar' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button>
                        </form>
                    </td>";
                    echo"</tr>";
                    $n++;
                    }
                    ?> 
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer" >
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
	function ConfirmDelete(){
		var answer = confirm("¿Esta seguro de eliminar?");

		if(answer == true){
			return true;
		}else{
			return false;
		}
	}
</script>	

</body>
</html>
<?php
}
?>