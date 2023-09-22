<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

//////////////////////PERMISOS////////////////////////
require_once 'conexion/bd.php';

$formulario = 'solicitudCom'; //Se cambia el nombre del formulario
require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////

?>
<!DOCTYPE html>
<html>
    <title>Solicitud de compra</title>
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
            <h1>Solicitud  de compra</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Solicitud de compra</li>
            </ol>
          </div>
        </div>
        <div>
            <?php
                if($visibleI == FALSE){
            ?>
            <div class="row">
            
            
           
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="AgregarSolicitudCompra"><font color="white"><i class="fas fa-plus-square"></i> Nuevo solicitud</font></a></button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="solicitudCompraTipo"><font color="white"><i class="fas fa-plus-square"></i> Tipo de Gasto</font></a></button>
            </div>
            <!--<div class="col-sm">
                <button type="button" class="btn btn-block btn-info btn-sm"><a href="solicitudCompraUrgencia"><font color="white"><i class="fas fa-plus-square"></i> Urgencia</font></a></button>
            </div>-->
            
            
            <div class="col-sm">
                    <button type="button" class="btn btn-block btn-info btn-sm"><a href="solicitudCompraSolicitud"><font color="white"><i class="fas fa-plus-square"></i> Tipo de solicitud</font></a></button>
            </div>
            <div class="col-sm">
                
                
                <?php
                /// validamos si el usuario tiene el permiso del grupo de distribución
                $permisoHabilitado=$mysqli->query("SELECT * FROM `permisos` WHERE formulario='informes' AND listar='1'");
                $extrerPermisoHabilitado=$permisoHabilitado->fetch_array(MYSQLI_ASSOC);
                $idPermisosGrupo=$extrerPermisoHabilitado['idGrupo'];
                
                
                $consultaGrupoExistenteValidacion=$mysqli->query("SELECT * FROM `grupoUusuario` WHERE idGrupo='$idPermisosGrupo' AND idUsuario='$cc' ");
                $extraerValidacionGrupo=$consultaGrupoExistenteValidacion->fetch_array(MYSQLI_ASSOC);
                $habilitarPermisoBotonGrupo=$extraerValidacionGrupo['id'];
                
                
                
                
                if($habilitarPermisoBotonGrupo != NULL){
                ?>
                <form action="exportacion/solicitudCompras" method="post">
                    <input name="usuario" value="<?php echo $idparaChat;?>" type="hidden">
                    <button type="submit" class="btn btn-block btn-warning btn-sm" ><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
                </form>
                <?php
                }
                ?>
                
            </div>
             
            
            </div>
            <?php }else{?>
            

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
                     
                      <th>Solicitud de compra</th>
                      <th>Fecha de solicitud</th>
                      <!--<th>Tipo de solicitud</th>-->
                      <th>Solicitante</th>
                      <th>Proceso</th>
                      <th>Centro de costo</th>
                      <th>Centro de Trabajo</th>
                      <th>Aprobador</th>
                      <th>Estado</th>
                      <th>Ver m&aacute;s</th>
                      <!---
                      <th style="display:<?//php echo$visibleE;?>;">Editar</th>
                      -->
                      <th style="display:<?php echo$visibleE;?>;">Editar</th>
                       <th style="display:<?php echo$visibleD;?>;">Gestionar</th>
                       <th style="display:<?php echo$visibleD;?>;">Productos</th>
                        <th style="display:<?php echo$visibleD;?>;">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php
                     require 'conexion/bd.php';
                     //$acentos = $mysqli->query("SET NAMES 'utf8'");
                  
                    
                        $acentos = $mysqli->query("SET NAMES 'utf8'");
                        $data = $mysqli->query("SELECT * FROM solicitudCompra  ORDER BY id ASC")or die(mysqli_error());
                        //$idCompra = $row['id'];
                     $conteo=1;
                     while($row = $data->fetch_assoc()){
                         
                         
                         ///// estados de la solicitud de compra
                         if($row['estado'] == 'Aprobado' || $row['estado'] == 'Ejecucion'){
                           continue;   
                         }
                         
                         //// estado='Pendiente'
                         
                         
                         
                         
                        $id = $row['id'];
                    echo"<tr>";
                   
                    echo"<td>".$id."</td>"; //$conteo++
                    echo "<td>".$row['fechaSolicitud']."</td>";
                 $proceso = $row['proceso'];
                  
                        
                    $rowUsuario=$row['idUsuario'];
                        $validacionUsuarioExt = $mysqli->query("SELECT * FROM usuario WHERE cedula='$rowUsuario' ");
                        $columnaValidandoUsuario = $validacionUsuarioExt->fetch_array(MYSQLI_ASSOC);
                        echo "<td>".$columnaValidandoUsuario['nombres']." ".$columnaValidandoUsuario['apellidos']."</td>";
                        $validandoProceso=$columnaValidandoUsuario['proceso'];
                        $validandoLider=$columnaValidandoUsuario['lider'];
                        
                        $validacionProcesoExt = $mysqli->query("SELECT * FROM procesos WHERE id='$proceso' ");
                        $columnaValidandoProceso = $validacionProcesoExt->fetch_array(MYSQLI_ASSOC);
                        echo "<td>".$columnaValidandoProceso['nombre']."</td>";
                        
                        $rowCentroCosto=$row['centroCosto']."</td>";
                    
                        $array = json_decode ($row['centroCosto']);
                        $longitud = count($array);
                        echo "<td>";
                            for($i=0; $i<$longitud; $i++){
                              
                                $validacionCentroCostoExt = $mysqli->query("SELECT * FROM centroCostos WHERE id='$array[$i]' ");
                                $columnaValidandoCentroCosto = $validacionCentroCostoExt->fetch_array(MYSQLI_ASSOC); 
                                
                            	echo "*".$columnaValidandoCentroCosto['nombre']."<br>";
                            }
                        echo "</td>";
                        
                        $rowCentroTrabajo=$row['centroTrabajo'];
                     
                        $validacionCentroTrabajoExt = $mysqli->query("SELECT * FROM centrodetrabajo WHERE id_centrodetrabajo='$rowCentroTrabajo' ");
                        $columnaValidandoCentroTrabajo = $validacionCentroTrabajoExt->fetch_array(MYSQLI_ASSOC);
                        echo "<td>".$columnaValidandoCentroTrabajo['nombreCentrodeTrabajo']."</td>";    
                     
                     
                      
                        $usuarioIdAprobador=$mysqli->query("SELECT * FROM solicitudCompraFlujo  WHERE idSolicitud='$id' AND rol='2' ");
                        $columnaValidandoAprobador=$usuarioIdAprobador->fetch_array(MYSQLI_ASSOC);
                        'U:'.$idUsuarioFlujo=$columnaValidandoAprobador['idUsuario'];
                        
                        $usuarioAprobador=$mysqli->query("SELECT * FROM usuario WHERE id='$idUsuarioFlujo' ");
                        $extraerUsuarioAProbador=$usuarioAprobador->fetch_array(MYSQLI_ASSOC);
                        
                        if($idUsuarioFlujo != NULL){
                            echo "<td>".$extraerUsuarioAProbador['nombres']." ".$extraerUsuarioAProbador['apellidos']."</td>";   
                        }else{
                            echo "<td>En proceso de solicitud</td>";
                        }
                        
                        ///// verificamos si ya existe productos asignados
                        $usuarioAlistamiento=$mysqli->query("SELECT * FROM solicitudAlistamiento WHERE idSolicitud='$id' ");
                        $extraerUsuarioAlistamiento=$usuarioAlistamiento->fetch_array(MYSQLI_ASSOC);
                        
                        
                        if($extraerUsuarioAlistamiento['id'] != NULL){
                            if($row['estado'] == 'Pendiente'){
                               
                               //// veriricamos si existe un rechazado
                                $usuarioIdAprobadorPreguntaRechzado=$mysqli->query("SELECT * FROM solicitudCompraFlujo  WHERE idSolicitud='$id' AND estado='rechazado' ");
                                $columnaValidandoAprobadorPreguntaRechzado=$usuarioIdAprobadorPreguntaRechzado->fetch_array(MYSQLI_ASSOC);
                                
                                if($columnaValidandoAprobadorPreguntaRechzado['id'] != NULL){
                                     $nviarEstado='Rechazado';
                                }else{
                                   if($idUsuarioFlujo != NULL){
                                        $nviarEstado='Solicitada';   
                                   }else{
                                        $nviarEstado='En proceso de solicitud';
                                   }
                                }
                               
                            }else{
                               if($row['estado'] == 'Rechazado'){
                                $nviarEstado='Rechazado';//$row['estado'];   
                               }else{
                                   /// antes de mostrar que fue aprobado, contamos la cantidad de personas para aprobar con el rol 1
                                   $usuarioIConteoRol1=$mysqli->query("SELECT count(*) FROM solicitudCompraFlujo  WHERE idSolicitud='$id' AND rol='1' ");
                                   $columnaValidandConteoRol1=$usuarioIConteoRol1->fetch_array(MYSQLI_ASSOC);
                                    'cantidad: '.$contandoRol1Varios=$columnaValidandConteoRol1['count(*)'];
                                   
                                   /// revisamos si todos están aprobados
                                   $usuarioIConteoRol1Aprobados=$mysqli->query("SELECT count(*) FROM solicitudCompraFlujo  WHERE idSolicitud='$id' AND rol='1' AND estado='aprobado' ");
                                   $columnaValidandConteoRol1Aprobados=$usuarioIConteoRol1Aprobados->fetch_array(MYSQLI_ASSOC);
                                    ' - cantidad A: '.$contandoRol1VariosAprobados=$columnaValidandConteoRol1Aprobados['count(*)'];
                                    
                                   if($contandoRol1Varios == $contandoRol1VariosAprobados && $row['estado'] == 'Revisado'){
                                       $nviarEstado='Revisado';//$row['estado'];
                                   }else{
                                       $nviarEstado='Aprobado';//$row['estado'];
                                   }
                                       
                               }
                               
                            }    
                        }else{
                           $nviarEstado='En proceso de solicitud';
                        }
                       
                   
                    echo "<td>".$nviarEstado."</td>";
                   
                    
                    
                    echo"<td><form action='solicitudCompraVerMas' method='POST'>";
                    echo"<input type='hidden' name='idSolicitudCompra' value= '$id' >";
                    echo "<button type='submit' class='btn btn-block btn-primary btn-sm'><i class='fas fa-eye'></i> Ver más</button>";
                    echo"</form></td>";
                    
                    $validacionEstado= $row['estado'];
                    if($validacionEstado == 'Aprobado'){
                   
                    //echo" <td style='display:$visibleE;'><button disabled class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                    echo" <td style='display:$visibleE;'><button disabled class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                    
                    }else{
                        //if($rowUsuario == $cc){
                        echo"<form action='solicitudCompraEditar' method='POST'>";
                        echo"<input type='hidden' name='idSolicitudCompra' value= '$id' >";
                        echo" <td style='display:$visibleE;'><button type='submit' class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                        echo"</form>";
                        /*}else{
                        echo" <td style='display:$visibleE;'><button disabled class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button></td>";
                        }*/
                    }
                    
                    
                    /// validamos la existencia para gestionar
                    
                    $consultaGestionar=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idSolicitud='$id' ");
                    $extraerGestionar=$consultaGestionar->fetch_array(MYSQLI_ASSOC);
                    
                    
                    if($validacionEstado == 'Aprobado'){
                   
                        echo" <td style='display:$visibleD;'><button  disabled class='btn btn-block btn-warning btn-sm'><i class='fas fa-clipboard'></i> Gestionar</button></td>";
                    }else{
                        if($extraerGestionar['id'] != NULL){
                        
                        
                        // validamos quienes pueden aprobar la solicitud
                        $consultandoResponsables=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idSolicitud='$id' AND idUsuario='$idparaChat' AND rol='1' ");
                        $extraerValidacion=$consultandoResponsables->fetch_array(MYSQLI_ASSOC);
                            $validarUsuarioGestionar=$extraerValidacion['idUsuario'];
                            $validarUsuarioGestionarResponsable=$extraerValidacion['estado'];
                            $validarUsuarioGestionarRol=$extraerValidacion['rol'];
                        
                        $consultandoResponsablesB=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idSolicitud='$id' AND idUsuario='$idparaChat' AND rol='2' ");
                        $extraerValidacionB=$consultandoResponsablesB->fetch_array(MYSQLI_ASSOC);
                            $validarUsuarioGestionarB=$extraerValidacionB['idUsuario'];
                            $validarUsuarioGestionarResponsableB=$extraerValidacionB['estado'];
                            $validarUsuarioGestionarRolB=$extraerValidacionB['rol'];
                            
                                
                                if($validarUsuarioGestionarResponsableB == 'pendiente' && $validarUsuarioGestionarRolB == '2'){
                                    echo"<form action='solicitudCompraGestionar' method='POST'>";
                                    echo"<input type='hidden' name='idOrdenCompra' value= '$id' >";
                                    echo" <td style='display:$visibleD;'><button  type='submit' class='btn btn-block btn-warning btn-sm'><i class='fas fa-clipboard'></i> Gestionar</button></td>";
                                    echo"</form>";
                                }elseif($validarUsuarioGestionarResponsable == 'pendiente' && $validarUsuarioGestionarRol == '1'){
                                    echo"<form action='solicitudCompraGestionar' method='POST'>";
                                    echo"<input type='hidden' name='idOrdenCompra' value= '$id' >";
                                    echo" <td style='display:$visibleD;'><button  type='submit' class='btn btn-block btn-warning btn-sm'><i class='fas fa-clipboard'></i> Gestionar </button></td>";
                                    echo"</form>"; 
                                    
                                }else{
                                    echo" <td style='display:$visibleD;'><button  disabled class='btn btn-block btn-warning btn-sm'><i class='fas fa-clipboard'></i> Gestionar</button></td>";
                                }
                          
                        
                        
                        }else{
                        echo" <td style='display:$visibleD;'><button  disabled class='btn btn-block btn-warning btn-sm'><i class='fas fa-clipboard'></i> Gestionar</button></td>";
                        }
                    }
                    
                    
                    
                    //if($validacionEstado == 'Aprobado'){
                    // echo" <td style='display:$visibleF;'><button disabled  class='btn btn-block btn-info btn-sm'><i class='fas fa-boxes'></i> Productos</button></td>";    
                    //}else{
                        
                        /// validamos cantidades aprobadas
                        $consultandoResponsablesPrductosValidaciones=$mysqli->query("SELECT count(*) FROM solicitudCompraFlujo WHERE idSolicitud='$id' AND estado='aprobado' ");
                        $extraerValidacionPrductosValidaciones=$consultandoResponsablesPrductosValidaciones->fetch_array(MYSQLI_ASSOC);
                        $cantidadAprobadaSolicitud=$extraerValidacionPrductosValidaciones['count(*)'];
                        $consultandoResponsablesPrductosValidacionesRechazado=$mysqli->query("SELECT count(*) FROM solicitudCompraFlujo WHERE idSolicitud='$id' AND estado='rechazado' ");
                        $extraerValidacionPrductosValidacionesRechazado=$consultandoResponsablesPrductosValidacionesRechazado->fetch_array(MYSQLI_ASSOC);
                        $cantidadAprobadaSolicitudRechazado=$extraerValidacionPrductosValidacionesRechazado['count(*)'];
                        // END
                        
                        
                        $consultandoResponsablesPrductos=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idSolicitud='$id' AND idUsuario='$idparaChat' ");
                        $extraerValidacionPrductos=$consultandoResponsablesPrductos->fetch_array(MYSQLI_ASSOC);
                            $usuarioProducto=$extraerValidacionPrductos['idUsuario'];
                            $estadoProducto=$extraerValidacionPrductos['estado'];
                            $rolProducto=$extraerValidacionPrductos['rol'];
                        
                        
                        $consultaComprador=$mysqli->query("SELECT * FROM solicitudComprador WHERE idSolicitud='$id' ");
                        $extraerConsultaComprador=$consultaComprador->fetch_array(MYSQLI_ASSOC);
                        $idCompradrSolicitante=$extraerConsultaComprador['idUsuario'];
                        
                        if($idCompradrSolicitante == $idparaChat){
                                echo"<form action='registroProductos' method='POST'>";
                                echo"<input type='hidden' name='compradorEditar' value= '1' >";
                                echo"<input type='hidden' name='idOrdenCompra' value= '$id' >";
                                echo" <td style='display:$visibleF;'><button type='submit'  class='btn btn-block btn-info btn-sm'><i class='fas fa-boxes'></i> Productos</button></td>";
                                echo"</form>";  
                        }else{
                            if($usuarioProducto == $idparaChat && $estadoProducto == 'pendiente' && $rolProducto == '2'){
                                echo"<form action='registroProductos' method='POST'>";
                                echo"<input type='hidden' name='idOrdenCompra' value= '$id' >";
                                echo" <td style='display:$visibleF;'><button type='submit'  class='btn btn-block btn-info btn-sm'><i class='fas fa-boxes'></i> Productos</button></td>";
                                echo"</form>";
                            }elseif($usuarioProducto == $idparaChat && $estadoProducto == 'pendiente' && $rolProducto == '1'){
                                echo"<form action='registroProductos' method='POST'>";
                                echo"<input type='hidden' name='idOrdenCompra' value= '$id' >";
                                echo" <td style='display:$visibleF;'><button type='submit'  class='btn btn-block btn-info btn-sm'><i class='fas fa-boxes'></i> Productos</button></td>";
                                echo"</form>";
                            }elseif($cc == $rowUsuario && $cantidadAprobadaSolicitud == '0' ){
                                echo"<form action='registroProductos' method='POST'>";
                                echo"<input type='hidden' name='idOrdenCompra' value= '$id' >";
                                echo" <td style='display:$visibleF;'><button type='submit'  class='btn btn-block btn-info btn-sm'><i class='fas fa-boxes'></i> Productos</button></td>";
                                echo"</form>";
                            }elseif($cc == $rowUsuario &&  $cantidadAprobadaSolicitudRechazado >= '0'){
                                echo"<form action='registroProductos' method='POST'>";
                                echo"<input type='hidden' name='idOrdenCompra' value= '$id' >";
                                echo" <td style='display:$visibleF;'><button type='submit'  class='btn btn-block btn-info btn-sm'><i class='fas fa-boxes'></i> Productos</button></td>";
                                echo"</form>";
                            }else{
                             echo" <td style='display:$visibleF;'><button disabled  class='btn btn-block btn-info btn-sm'><i class='fas fa-boxes'></i> Productos </button></td>";
                            }
                        }
                    
                    
                    if($validacionEstado == 'Aprobado'){
                    ?>
                    <td style='display:<?php echo $visibleD;?>'><button disabled style='color:white;' data-toggle='modal' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>
                    <?php
                    }else{
                        
                        if($rowUsuario == $cc){
                    ?>
                        <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $id;?>' >
                        <td style='display:<?php echo $visibleD;?>'><a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a></td>
                        <script>
                            function funcionFormula<?php echo $contador2++;?>() {
                                /*alert("entre");*/
                              document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                            }
                           </script>
                           <!---
                           <button class="btn btn-primary" disabled>
                            <span class="spinner-border spinner-border-sm"></span>
                            Loading..
                            </button>-->                            
                    
                    <?php
                        }else{
                        ?>
                           <td style='display:<?php echo $visibleD;?>'><button disabled style='color:white;' data-toggle='modal' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</button></td>
                        <?php 
                        }
                    }
                    
                    
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
                              <form action='controlador/solicitudCompra/controllerSolicitudCompra' method='POST'>
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

<?php
  $validacionActualizar=$_POST['validacionActualizar'];
  $validacionEliminar=$_POST['validacionEliminar'];
?>

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

    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>
    
      <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- SweetAlert2 -->
  <script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
  <?php
  /// validaciones de alertas
  $validacionExiste=$_POST['validacionExiste'];
  $validacionExisteA=$_POST['validacionExisteA'];
  $validacionExisteB=$_POST['validacionExisteB'];
  $validacionAgregar=$_POST['validacionAgregar'];
  $validacionAgregarB=$_POST['validacionAgregarB'];
  $validacionActualizar=$_POST['validacionActualizar'];
  $validacionEliminar=$_POST['validacionEliminar'];
  $validacionEliminarB=$_POST['validacionEliminarB'];
  $Tipodocumeto=$_POST['Tipodocumeto'];

  //// Validaciones de la importación
  $validacionExisteImportacionA=$_POST['validacionExisteImportacionA'];
  $validacionExisteImportacionB=$_POST['validacionExisteImportacionB'];
  $validacionExisteImportacionC=$_POST['validacionExisteImportacionC'];
  $validacionExisteImportacionD=$_POST['validacionExisteImportacionD'];
  $validacionExisteImportacionE=$_POST['validacionExisteImportacionE'];
  $validacionExisteImportacionF=$_POST['validacionExisteImportacionF'];
  $validacionExisteImportacionG=$_POST['validacionExisteImportacionG'];
  $validacionExisteImportacionI=$_POST['validacionExisteImportacionI'];
  $validacionExisteImportacionVacio=$_POST['validacionExisteImportacionVacio'];
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
      
      if($Tipodocumeto == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El tipo de documento no es valido.'
          })
        <?php
      }
      
      if($validacionExisteImportacionVacio == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos campos están vacios.'
          })
      <?php
      }
       if($validacionExisteImportacionA == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos cargos no existen en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionB == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos lideres no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionC == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos procesos no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionD == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos centro de costos no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionE == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos centro de trabajo no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionF == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos grupos no existe en el sistema.'
          })
      <?php
      }
      if($validacionExisteImportacionG == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos usuarios ya existen.'
          })
      <?php
      }
      if($validacionExisteImportacionI == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Está intentando subir un archivo diferente.'
          })
      <?php
      }
      
      
      if($validacionExiste == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' El usuario ya existe.'
          })
      <?php
      }
      if($validacionExisteA == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' La fecha seleccionada no debe superar la del presente año.'
          })
      <?php
      }
      if($validacionExisteB == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' La cédula ya existe con otro usuario, asegúrese que el número de documento permanezca al usuario que se encuentra editando.'
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
      if($validacionAgregarB == 1){
      ?>
          Toast.fire({
              type: 'success',
              title: 'Registro activado.'
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
      if($validacionEliminarB == 1){
      ?>
          Toast.fire({
              type: 'error',
              title: 'Registro Anulado.'
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
<!-- END -->
</body>
</html>
