<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

//$formulario = 'politicas'; //Se cambia el nombre del formulario

//require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
    <title>Pol&iacute;ticas</title>
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
            <h1>Pol&iacute;ticas</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Pol&iacute;ticas</li>
            </ol>
          </div>
        </div>
        <div>
            <?php
                if($visibleI == FALSE){
            ?>
            <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="agregarPoliticas"><font color="white"><i class="fas fa-plus-square"></i> Nueva Pol&iacute;ticas</font></a></button>
            </div>
            
            <div class="col-sm">
            </div>
            <div class="col-sm">
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
                <h3 class="card-title"></h3>
                
                
            </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed text-center" id="example">
                  <thead>
                    <tr>
                      <th>N°</th>
                      <th>Aprobador</th>
                      <th>Monto m&iacute;nimo</th>
                      <th>Monto m&aacute;ximo</th>
                      <!-- <th>Ver más</th> -->
                      <th style="display:<?php echo$visibleE;?>;">Editar</th>
                      <th style="display:<?php echo$visibleD;?>;">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     $acentos = $mysqli->query("SET NAMES 'utf8'");
                     
                        $data = $mysqli->query("SELECT * FROM politicas ORDER BY id ASC")or die(mysqli_error());
                     
                     $conteo=1;
                     while($row = $data->fetch_assoc()){
                        $id = $row['id'];
                    echo"<tr>";
                    echo"<td>".$conteo++."</td>";
                    $tipoResponsable=$row['tipoAprobador'];
                            $personalID =  json_decode($row['aprobador']);
                            $longitud = count($personalID);
                             if($tipoResponsable == 'usuario'){
                                    echo"<td>";
                                    for($i=0; $i<$longitud; $i++){
                                        
                                        $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalID[$i]'");
                                        $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                    
                                        echo $columna['nombres']." ".$columna['apellidos'];echo "<br>";
                                        $cedulaUsuario=$columna['cedula'];
                                    } echo"</td>";
                                 
                                }else{
                                    echo"<td>";
                                    for($i=0; $i<$longitud; $i++){
                                    $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$personalID[$i]'");
                                    $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                    echo $carga = $columna['nombreCargos']; echo "<br>";
                                    } "</td>";
                                }
                    $montoMinimo=$row['minimo'];
                    echo "<td> $ ". number_format($montoMinimo,0,'.',',')."</td>";
                    $montoMaximo=$row['maximo'];
                    echo "<td> $ ". number_format($montoMaximo,0,'.',',')."</td>";
                    /*
                    echo"<form action='politicasVer' method='POST'>";
                    echo"<input type='hidden' name='idPoliticas' value= '$id' >";
                    echo"<td><button type='submit' class='btn btn-block btn-primary btn-sm'><i class='fas fa-eye'></i> Ver más</button></td>";
                    echo"</form>";
                    */
                    echo"<form action='politicasEditar' method='POST'>";
                    echo"<input type='hidden' name='idPoliticas' value= '$id' >";
                    echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                    echo"</form>";
                    
                    
                    /// validación de script y funcion de eliminacion
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
                        
                    /*
                    echo"<form action='controlador/politicas/controller' method='POST'>";
                    echo"<input type='hidden' name='idPoliticas' value= '$id' >";
                    echo" <td style='display:$visibleD;'><button onclick='return ConfirmDelete()' type='submit' name='Eliminar' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>";
                    echo"</form>";
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
                            <form action='controlador/politicas/controller' method='POST'>
                            <div class="modal-footer justify-content-between">
                              <input type="hidden" id="capturarFormula" name='idPoliticas' readonly>
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
                <div>
                     
                        <?php
                        //////////// probando datos para el negativo a positivo
                        //$variableSaliente= ABS($numera);
                        ///// fin del proceso

                        ////////// se trae el último dato para no calcular
                            $traeMontMaximoNoCalcular=$mysqli->query("SELECT * FROM politicas ORDER BY id DESC LIMIT 0,1 ");
                            $datoMaximoNoCalcular=$traeMontMaximoNoCalcular->fetch_array(MYSQLI_ASSOC);
                            $noCalcular=$datoMaximoNoCalcular['maximo'];
                            //echo '<br>El &uacute;ltimo monto m&aacute;ximo para no calcular es: $.'.number_format($noCalcular,0,'.',',')."<br><br>";
                               
                        ///////// fin del procso
                         
                         $dataPolitica = $mysqli->query("SELECT * FROM politicas  ORDER BY id ASC")or die(mysqli_error()); //WHERE not maximo='$noCalcular'
                            while($row = $dataPolitica->fetch_assoc()){
                                 "<tablet>";
                                 "<tr>";
                                 "<td>";
                                 "Monto m&aacute;ximo $.".number_format($row['maximo'],0,'.',',');
                                $porcentaje=round(100*($row['maximo']/$noCalcular));
                                 " el porcentaje sería de: ".$porcentaje."%<br>";
                                 "</td>";
                                 "</tr>";
                                 "</tablet>";
                            }
                            $traeMontPMaximo=$mysqli->query("SELECT * FROM politicas ORDER BY id DESC LIMIT 1,1 ");
                            $datoPMaximo=$traeMontPMaximo->fetch_array(MYSQLI_ASSOC);
                             '<br>El pen&uacute;ltimo monto m&aacute;ximo es: $.'.number_format($datoPMaximo['maximo'],0,'.',',');
                            $traeMontMaximo=$mysqli->query("SELECT * FROM politicas ORDER BY id DESC LIMIT 0,1 ");
                            $datoMaximo=$traeMontMaximo->fetch_array(MYSQLI_ASSOC);
                             '<br>El &uacute;ltimo monto m&aacute;ximo es: $.'.number_format($datoMaximo['maximo'],0,'.',',');
                        
                        /*
                        ?>
                        <div class='progress'>
                        <?php
                       $dataPolitica = $mysqli->query("SELECT * FROM politicas   ORDER BY id ASC")or die(mysqli_error()); //WHERE not maximo='$noCalcular'
                            while($row = $dataPolitica->fetch_assoc()){
                                $porcentaje=round(100*($row['maximo']/$noCalcular))."%";
                                
                                //$porcentajeS='20'; 
                                ?>
                               
                                <div title="<?php echo $porcentaje;?>" class='progress-bar bg-<?php echo $row['color']; ?> progress-bar-striped' role='progressbar' aria-valuenow='40' aria-valuemin='0' aria-valuemax='100' style='width:<?php echo $porcentaje;?>'>
                                   <?php echo "(".$porcentaje=round(100*($row['maximo']/$noCalcular))."%)"; ?>
                                </div>
                        
                        
                        <?php
                            } 
                        ?>
                       </div>
                       <?php  */ ?>
                       <br><br>
                       <table class="table table-head-fixed text-center">
                         <tr>
                             <thead>
                                <?php
                                $dataPolitica = $mysqli->query("SELECT * FROM politicas ORDER BY id ASC")or die(mysqli_error()); // WHERE not maximo='$noCalcular'
                                while($row = $dataPolitica->fetch_assoc()){
                                $porcentaje=round(100*($row['maximo']/$noCalcular))."%";
                                $porcentaje2="100%";
                                //$porcentajeS='20'; 
                                ?>
                               
                                <th class=' bg-<?php echo $row['color']; ?> progress-bar-striped'>
                                <?php 
                                    echo '$ '.number_format($row['minimo'],0,'.',',').' - $ '.number_format($row['maximo'],0,'.',','); 
                                ?>
                                </th>
                                <?php
                                    }
                                ?> 
                             </thead>
                         </tr>
                         <tr>   
                       <?php
                            $dataPolitica = $mysqli->query("SELECT * FROM politicas ORDER BY id ASC")or die(mysqli_error()); // WHERE not maximo='$noCalcular'
                            while($row = $dataPolitica->fetch_assoc()){
                                $porcentaje=round(100*($row['maximo']/$noCalcular))."%";
                                $porcentaje2="100%";
                                //$porcentajeS='20'; 
                                ?>
                               
                                <td style="text-align:center;">
                                <?php 
                                    $porcentaje; 
                                    '<br>'; 
                                    $row['color']; 
                                    '<br>'; 
                                    $porcentaje; ?>
                                <?php
                                 "(".$porcentaje=round(100*($row['maximo']/$noCalcular))."%)-"; 
                                $tipoResponsable=$row['tipoAprobador'];
                                $personalID =  json_decode($row['aprobador']);
                                $longitud = count($personalID);
                                     if($tipoResponsable == 'usuario'){
                                            
                                            for($i=0; $i<$longitud; $i++){
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalID[$i]'");
                                                $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                            
                                                echo $columna['nombres']." ".$columna['apellidos'];echo "<br>";
                                                $cedulaUsuario=$columna['cedula'];
                                            } 
                                         
                                        }else{
                                          
                                            for($i=0; $i<$longitud; $i++){
                                            $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$personalID[$i]'");
                                            $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                            echo $carga = $columna['nombreCargos']; echo "<br>";
                                            } 
                                        }
                                ?>    
                                
                                </td>
                                
                        <?php
                            }
                        ?>
                        </tr>
                       </table>
                       <!-- se trae los porcentaje y los aprobadores -->
                       <?php
                       /*
                       ?>
                       <div class='progress'>
                       <?php
                       $dataPolitica = $mysqli->query("SELECT * FROM politicas ORDER BY id ASC")or die(mysqli_error()); // WHERE not maximo='$noCalcular'
                            while($row = $dataPolitica->fetch_assoc()){
                                $porcentaje=round(100*($row['maximo']/$noCalcular))."%";
                                $porcentaje2="100%";
                                //$porcentajeS='20'; 
                                ?>
                               
                                <div title="<?php echo $porcentaje;?>" class='progress-bar bg-<?php echo $row['color']; ?> progress-bar-striped' role='progressbar' value="hh" aria-valuenow='40' aria-valuemin='0' aria-valuemax='100' style='width:<?php echo $porcentaje;?>'>
                                <?php
                                echo "(".$porcentaje=round(100*($row['maximo']/$noCalcular))."%)-"; 
                                $tipoResponsable=$row['tipoAprobador'];
                                $personalID =  json_decode($row['aprobador']);
                                $longitud = count($personalID);
                                     if($tipoResponsable == 'usuario'){
                                            
                                            for($i=0; $i<$longitud; $i++){
                                                
                                                $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalID[$i]'");
                                                $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                            
                                                echo $columna['nombres']." ".$columna['apellidos'];echo "-";
                                                $cedulaUsuario=$columna['cedula'];
                                            } 
                                         
                                        }else{
                                          
                                            for($i=0; $i<$longitud; $i++){
                                            $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$personalID[$i]'");
                                            $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                            echo $carga = $columna['nombreCargos']; echo "-";
                                            } 
                                        }
                                ?>    
                                </div>
                        
                        
                        <?php
                            }
                        ?>
                       </div>
                       <br><br>
                       <!--  Fin del proceso   -->
                       <?php
                       */
                       ?>
                       
                       
                       
                        <!--
                        <div class='progress'>
                        <div class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                            <span class="sr-only">40% Complete (success)</span>
                        </div>
                        
                        <div class="progress-bar bg-danger progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                            <span class="sr-only">40% Complete (success)</span>
                        </div>
                        </div>
                        -->
                        
                         
        
        
                    </div>
                </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
  <!-- /.content-wrapper -->
<?php //echo require_once'footer.php'; ?>

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
<script>
    $(document).ready(function(){
        $('#rad_si').click(function(){
            document.getElementById('aprovar_regitros').style.display = '';
        });
        $('#rad_no').click(function(){
            document.getElementById('aprovar_regitros').style.display = 'none';
        });
    });
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



//// END
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
            title: ' El aprobador ya existe.'
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
<!-- archivos para el filtro de busqueda y lista de información -->
 
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