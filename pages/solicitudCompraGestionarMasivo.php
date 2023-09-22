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
<body class="hold-transition sidebar-mini" onload="nobackbutton();" oncopy="return false" onpaste="return false">
<div class="wrapper">


  <!-- Main Sidebar Container -->
  <?php echo require_once'menu.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  
    
     <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Solicitud  de compra</h1>
          </div>
          <?php
          	$sql= $mysqli->query("SELECT * FROM usuario WHERE cedula = '$sesion'");
          	while($row = $sql->fetch_assoc()){
		    $idparaChat = $row['id'];
		    $nombres = $row['nombres'];
		    $apellidos = $row['apellidos'];
		    $foto = $row['foto'];
		    $correo = $row['correo'];
		    $cc = $row['cedula'];}
		    
          ?>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Solicitud de compra</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
               
                <div class="col-9">
                    <div class="row">
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="ordenCompraMasiva"><font color="white"><i class="fas fa-list"></i> Listar masivo</font></a></button>
                        </div>
                        <div class="col-sm-3">
                        <!--<form action="solicitudCompraVerMas" method="post">
                             <input name="idOrdenCompra" value="<?php //echo $_POST['idOrdenCompra']; ?>" type="hidden">
                            <input name="gestionar" value="1" type="hidden">
                            <button type="submit" name="informacion" class="btn btn-block btn-info btn-sm"><font color="white"><i class="fas fa-list"></i> Información del pedido</font></button>
                            </form>
                        </div>-->
                    </div>
                </div>
                 
                <div class="col">
                  
                </div>
          
            </div>
        </div>
      </div><!-- /.container-fluid -->
       
    </section>
                <?php
                $idOrdenCompra=$_POST['idOrdenCompra'];
                $consultaSolicitud=$mysqli->query("SELECT * FROM solicitudCompra WHERE id='$idOrdenCompra' ");
                $extraerCnsultaSolicitud=$consultaSolicitud->fetch_array(MYSQLI_ASSOC);
                ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                  
               
                <h3 class="card-title">Solicitud N° <?php echo $extraerCnsultaSolicitud['id'];?></h3>
                
                
           
               </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <!--<div class="card-header">
                             <form action="registroProductosVisualizar"  method="post">
                                <input name="idOrdenCompra" value="<?php //echo $_POST['idOrdenCompra'];?>" type="hidden">
                                 <input name="gestionar" value="1" type="hidden">
                            <button type="submit"  class='btn btn-warning  btn-sm' id="" ><i class="fas fa-eye"></i> Visualizar Documentos</button>
                            </form>
                </div>-->
              </div>
              
            
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    
    
     <section class="content">
      <div class="container-fluid">
        <div class="row">
       
            <!-- AREA CHART -->
           
            
            <!-- desde el formulario atrapamos los id de los productos para agregar y por medio de ajax realizamos el insert-->
                    <div class="modal fade" id="modal-danger">
                        <div class="modal-dialog">
                          <div class="modal-content bg-success">
                            <div class="modal-header">
                              <h4 class="modal-title">Alerta</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>¿Est&aacute; seguro de almacenar?</p>
                            </div>
                             <!-- formulario para eliminar por el id -->
                            <form method="post" id="js-form" onsubmit="return false">
                            <div class="modal-body">
                             Cantidad
                             
                             <input type="number"  placeholder="Cantidad..." class="form-control" min='1' value="1"  id="js-reg3" name="reg3">
                             </div>
                            <div class="modal-footer justify-content-between">
                              <input type="hidden"  id="js-reg1" name="reg1" value="<?php echo $idOrdenCompra; ?>" >
                              <input type="hidden"  id="js-reg2" name="reg2">
                              <button type="reset" id="js-enviar" class="btn btn-outline-light" data-dismiss="modal" >Si</button>
                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                            </div>
                           
                             </form>
                             <!-- END formulario para eliminar por el id -->
                          </div>
                        </div>
                    </div>
            <!-- END el código de ajax se encuentra después del filtro  -->
                       
          </div>
          <!-- /.col (LEFT) -->
          <div class="col-md-12">
            <!-- LINE CHART -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Alistamiento </h3>
              </div>
              
              <div class="card-body">
                <div class="chart">
                     <!-- Medianto un for enviamos el id de la solicitud para traer los productos asignados -->
                     <form method="post" id="js-form" onsubmit="return false">
                        <input id="consultaProductos" value="<?php echo $idOrdenCompra; ?>" type="hidden">
                        <button id="js-consulta" style="display:none;"></button>
                     </form>
                     <!-- END -->
                     
                     <!-- listamos los datos de la tabla -->
                     <div id="mostrarDatos" style="display:none;"></div>
                     <!-- END-->
                     
                  
                  
                     <script>
                     
                     function recargarChat(){
                        // traemos los datos de la consulta, después de hacer el primer click, trae los datos actualizados después de agregar otro producto
                            $(document).on('click', '#js-consulta', function(e){
                            	e.preventDefault();
                            	var consultaProductos = $('#consultaProductos').val();
                                $.ajax({
                            		url: 'solicitudCompraGestionarJS.php', // Es importante que la ruta sea correcta si no, no se va a ejecutar
                            		method: 'POST',
                            		data: { consultaProductos: consultaProductos },
                            		beforeSend: function(){
                            			$('#mostrarDatos').css('display','block');
                            			//$('#estado p').html('Guardando datos...');
                            		},
                            		success: function(lista){
                            				$('#mostrarDatos').html(lista);
                            		}
                            	});
                            });
                        // END    
                        
                        // simulamos el click en el botón del formulario para traer los datos 
                        
                            $(document).ready(function() {
                              // indicamos que se ejecuta la funcion a los 5 segundos de haberse
                              // cargado la pagina
                              setTimeout(clickbutton, 0000);
                            
                              function clickbutton() {
                                // simulamos el click del mouse en el boton del formulario
                                $("#js-consulta").click();
                                //alert("Aqui llega"); //Debugger
                              }
                              $('#js-consulta').on('click',function() {
                               // console.log('action');
                              });
                            });
                            
                     }
                     setInterval("recargarChat()",1000);
                        // END
                    </script>  
                  
                  
                  
                </div>
              </div>
              
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
         
        <!-- /.row -->
           <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title"> </h3>
              </div>
              
              <div class="card-body">
                <div class="chart">
                    
                      <form role="form" action="controlador/solicitudCompra/controllerOCMasiva" method="POST" enctype="multipart/form-data" onsubmit="return checkSubmit();" >
                            &nbsp Aprobado <input name="opcion" value="aprobado" id="aprobar" type="radio" id="aprobado" checked required>&nbsp;
                            <!--Rechazado <input name="opcion" value="rechazado" id="rechazar" type="radio" id="rechazado" required>-->
                            <br>
                            <br>
                            <label>Observaciones:</label>
                            <br>
                            <textarea name="comentario" class="form-control" placeholder="Observaciones..." ></textarea>  
                            <br>
                            <input name="idUsuario" type="hidden" value = <?php echo $idparaChat;?>>
                            <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                            <input name="nombrePersona" type="hidden" value="<?php echo $nombres.' '.$apellidos;?>">
                            <?php
                            $validacionUltimapAorbacion=$mysqli->query("SELECT * FROM `solicitudCompraFlujo` WHERE idSolicitud='".$_POST['idOrdenCompra']."' AND idUsuario='$idparaChat' AND estado='ejecucion' AND rol='2' ");
                            $extraerValidacionAprobacion=$validacionUltimapAorbacion->fetch_array(MYSQLI_ASSOC);
                            $extraerDatpsValidacion=$extraerValidacionAprobacion['id'];
                            if($extraerDatpsValidacion != NULL){
                                
                                /// validamos la existencia del grupo con el listar habilitado solicitudComprador
                                $permiso=$mysqli->query("SELECT grupo.*, permisos.*, grupo.id AS idExisteGrupo FROM grupo INNER JOIN permisos WHERE permisos.formulario='ordenCom' AND permisos.listar='1' AND grupo.id = permisos.idGrupo");
                                $extraerPermiso=$permiso->fetch_array(MYSQLI_ASSOC);
                                'id: '.$permisoExistente=$extraerPermiso['idExisteGrupo'];
                                
                                /// validamos el permiso del grupo de distribución
                                $consultandoPermiso=$mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario='$cc' AND idGrupo='$permisoExistente' ");
                                $extraerPermiso=$consultandoPermiso->fetch_array(MYSQLI_ASSOC);
                                $extraerPermisoHabilitador=$extraerPermiso['id'];
                                
                               // if($extraerPermisoHabilitador != NULL){
                            ?>
                            <div id="comprador" style="display:;">
                                <br>
                                <label>Selecionar comprador</label>
                                <select name="comprador" class="form-control" id="selectorComprador">
                                    <option value=""></option>
                                    <?php
                                    $usuarios=$mysqli->query("SELECT * FROM usuario ORDER BY nombres ");
                                    while($extraerUsuarios=$usuarios->fetch_array()){
                                        /// validamos la existencia del grupo con el listar habilitado solicitudComprador
                                        
                                        $permiso=$mysqli->query("SELECT grupo.*, permisos.*, grupo.id AS idExisteGrupo FROM grupo INNER JOIN permisos WHERE permisos.formulario='ordenCom' AND permisos.listar='1' AND grupo.id = permisos.idGrupo ");
                                        while($extraerPermiso=$permiso->fetch_array()){
                                        'id: '.$permisoExistente=$extraerPermiso['idExisteGrupo'];
                                        }
                                        
                                        $consultandoPermisoSub=$mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario='".$extraerUsuarios['cedula']."'  AND idGrupo='$permisoExistente' ");
                                        $extraerPermisoSub=$consultandoPermisoSub->fetch_array(MYSQLI_ASSOC);
                                        $enviarIdVa=$extraerPermisoSub['idGrupo'];
                                        
                                        
                                        
                                        if($enviarIdVa == $permisoExistente){
                                            
                                        }else{
                                            continue;
                                        }
                                            
                                        
                                    ?>
                                    <option value="<?php echo $extraerUsuarios['id'];?>"><?php echo $extraerUsuarios['nombres'].' '.$extraerUsuarios['apellidos']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <br>
                            </div>
                            <?php
                                //}
                            }
                            
                            
                            if($extraerDatpsValidacion != NULL){
                                //if($extraerPermisoHabilitador != NULL){
                                ?>
                                <div id="notificacion" style="display:none;">
                                    <button type="submit" class="btn btn-primary float-right" name="agregarComentario">Agregar</button>
                                </div>
                                 <div id="notificacionComprador" style="display:;">
                                    <button type="submit" class="btn btn-primary float-right" name="notificarComprador">Notificar al comprador</button>
                                </div>
                                <?php       
                                //}else{
                                //echo '<font color="red">No tiene permiso para realizar esta acción</font>';
                                //}
                            }else{
                            ?>
                                <button type="submit" class="btn btn-primary float-right" name="agregarComentario">Agregar</button>
                            <?php
                            } 
                            ?>
                      </form>  
                            <script> //// validación para cambiar de proceso
                                $(document).ready(function(){
                                    $('#aprobar').click(function(){ 
                                        document.getElementById('comprador').style.display = '';
                                        document.getElementById('notificacion').style.display = 'none';
                                        document.getElementById('notificacionComprador').style.display = '';
                                        document.getElementById("selectorComprador").setAttribute("required","any"); 
                                    
                                    });
                                    $('#rechazar').click(function(){ 
                                        document.getElementById('comprador').style.display = 'none';
                                        document.getElementById('notificacion').style.display = '';
                                        document.getElementById('notificacionComprador').style.display = 'none';
                                        document.getElementById("selectorComprador").removeAttribute("required","any");
                                    });
                                });
                            </script>
                            
                </div>      
                 
                <div class="card-body">
                     
                     <script>
                     
                     function recargarChat(){
                        // traemos los datos de la consulta, después de hacer el primer click, trae los datos actualizados después de agregar otro producto
                            $(document).on('click', '#js-consulta', function(e){
                            	e.preventDefault();
                            	var consultaProductos = $('#consultaProductos').val();
                                $.ajax({
                            		url: 'solicitudCompraGestionarJS.php', // Es importante que la ruta sea correcta si no, no se va a ejecutar
                            		method: 'POST',
                            		data: { consultaProductos: consultaProductos },
                            		beforeSend: function(){
                            			$('#mostrarDatos').css('display','block');
                            			//$('#estado p').html('Guardando datos...');
                            		},
                            		success: function(lista){
                            				$('#mostrarDatos').html(lista);
                            		}
                            	});
                            });
                        // END    
                        
                        // simulamos el click en el botón del formulario para traer los datos 
                        
                            $(document).ready(function() {
                              // indicamos que se ejecuta la funcion a los 5 segundos de haberse
                              // cargado la pagina
                              setTimeout(clickbutton, 0000);
                            
                              function clickbutton() {
                                // simulamos el click del mouse en el boton del formulario
                                $("#js-consulta").click();
                                //alert("Aqui llega"); //Debugger
                              }
                              $('#js-consulta').on('click',function() {
                               // console.log('action');
                              });
                            });
                            
                     }
                     setInterval("recargarChat()",1000);
                        // END
                    </script>  
                  
                  
                  
                </div>
              </div>
              
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
     </section>
    
     <script>
                         enviando = false; //Obligaremos a entrar el if en el primer submit
                    
                        function checkSubmit() {
                            if (!enviando) {
                        		enviando= true;
                        		return true;
                            } else {
                                //Si llega hasta aca significa que pulsaron 2 veces el boton submit
                                //alert("El formulario ya se esta enviando");
                                return false;
                            }
                        }
                    </script>
    
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
<!--Librerias para el estilo del campo para cargar archivos -->


<!-- END-->
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
  
<script type='text/javascript'>
	    document.oncontextmenu = function(){return false}
    </script>


  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
 
     
    <!-- archivos para el filtro de busqueda y lista de información -->
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
 
    <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>
    <!-- END -->
    
    
    
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
