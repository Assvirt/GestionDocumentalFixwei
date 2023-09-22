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
        <div class="col-sm-6">
               <?php
                $idOrdenCompra=$_POST['idOrdenCompra'];
                $consultaSolicitud=$mysqli->query("SELECT * FROM solicitudCompra WHERE id='$idOrdenCompra' ");
                $extraerCnsultaSolicitud=$consultaSolicitud->fetch_array(MYSQLI_ASSOC);
                $estadoGeneral=$extraerCnsultaSolicitud['estado'];
                ?>
            <h1><?php $extraerCnsultaSolicitud['id'];?></h1>
        <div>
            <div class="row">
               
                <div class="col-9">
                    <div class="row">
                        
                        <div class="col-sm-3">
                        <form action="solicitudCompraVerMas" method="post">
                             <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                            
                            </form>
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
              <div class="row">
                <div class="col-9">
                    <div class="row">
                        <div class="col-sm">
                          <button  type="button" class="btn btn-block btn-info btn-sm"><a href="solicitudCompra"><font color="white"><i class="fas fa-list"></i> Listar solicitud</font></a></button>
                        </div>
                        <div class="col-sm">
                        <form action="solicitudCompraVerMas" method="post">
                             <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                            <input name="" value="1" type="hidden">
                            <button type="submit" name="informacion" class="btn btn-block btn-info btn-sm"><font color="white"><i class="fas fa-list"></i> Información del pedido</font></button>
                            </form>
                        </div>
                    </div>
                </div>
                 
                <div class="col">
                  
                </div>
          
            </div>

              <br>
            <div class="card">
              <div class="card-header">
                  
                <?php
                $idOrdenCompra=$_POST['idOrdenCompra'];
                $consultaSolicitud=$mysqli->query("SELECT * FROM solicitudCompra WHERE id='$idOrdenCompra' ");
                $extraerCnsultaSolicitud=$consultaSolicitud->fetch_array(MYSQLI_ASSOC);
                $estadoGeneral=$extraerCnsultaSolicitud['estado'];
                
                
                ///// cuando el comprador modifica los productos o no, debe obligar a volver a calcular
                
                if($_POST['compradorEditar'] != NULL){
                   $updateSolicitud=$mysqli->query("UPDATE solicitudCompra SET modificacion='1' WHERE id='$idOrdenCompra' ");
                }
                
                /// END
                
                
                ?>
                <h3 class="card-title">Solicitud N° <?php echo $extraerCnsultaSolicitud['id'];?></h3>
           
               </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <div class="card-header">
                <table>
                    <thead>
                        <th>
                            <form action="registoProductosfile_upload"  method="post">
                                <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra'];?>" type="hidden">
                            <button type="submit" class="btn btn-block btn-info btn-sm"><font color="white"><i class="fas fa-file-upload"></i> Subir Documentos</font></button>
                            </form>
                            <span class='btn btn-primary  btn-sm' id="close" style="display:none;"><i class="fas fa-file-upload"></i> Cerrar</span>
                        </th>
                        <th style="visibility: hidden">-</center></th> 
                        <th>
                            <form action="registroProductosVisualizar"  method="post">
                                <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra'];?>" type="hidden">
                            <button type="submit"  class='btn btn-warning  btn-sm' id="" ><i class="fas fa-eye"></i> Visualizar Documentos</button>
                            </form>
                        </th> 

                  
                       
                   
                 </thead> 
                </table>  
               
               <?php
                $consultandoResponsables=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idSolicitud='".$_POST['idOrdenCompra']."' ");
                $extraerValidacion=$consultandoResponsables->fetch_array(MYSQLI_ASSOC);
                $idSolicitudValidacion=$extraerValidacion['idSolicitud'];
               
               
               // validamos si en alguno rechazo la solicitud
                $consultandoResponsablesValidacion=$mysqli->query("SELECT count(*) FROM solicitudCompraFlujo WHERE idSolicitud='".$_POST['idOrdenCompra']."' AND estado='rechazado' ");
                while($extraerValidacionValidacion=$consultandoResponsablesValidacion->fetch_array()){
                $conteoValidacionRechazo=$extraerValidacionValidacion['count(*)'];
                }
               
               if($conteoValidacionRechazo > 0 && $extraerCnsultaSolicitud['idUsuario'] == $cc){
                 ?><br><br>
                <center>
                    <h6 style="color:red;">Para visualizar los comentarios del rechazo de la solicitud, dar clic en el botón información del pedido</h6>
                  <!--<form action="controlador/solicitudCompra/controllerAlistamiento" method="post" onsubmit="return checkSubmit();">
                        <input name="idOrdenCompra" value="<?php //echo $_POST['idOrdenCompra']; ?>" type="hidden">
                        <button type="submit" class="btn btn-primary " name="notificar">Notificar nuevamente</button>
                    </form>-->
                </center>
                 <?php
               }else{
               
                if($estadoGeneral == 'Aprobado'){
                    echo '<center><font color="green">Solicitud aprobada</font></center>';
                }else{
                   if($extraerValidacion['idSolicitud'] != NULL){ 
                       if($_POST['compradorEditar'] != NULL){
                        echo '<center><font color="green">En proceso Orden de compra</font></center>';   
                       }else{
                        echo '<center><font color="red">Solicitud en revisión</font></center>';
                       }
                   }else{
                   ?>
                   
                       
                    
                  
                              
                    
                         <div class="modal fade" id="modal-evento">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content bg-info">
                                <div class="modal-header">
                                  <h4 class="modal-title">Registro</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form action="controlador/solicitudCompra/controllerAlistamiento" method="post" onsubmit="return checkSubmit();">
                                <div class="modal-body">
                                    
                                            <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                                            <table class="table table-head-fixed text-center" >
                                                 <thead>
                                                     <tr>
                                                    <?php
                                                    $array = json_decode ($extraerCnsultaSolicitud['centroCosto']);
                                                    $longitud = count($array);
                                                            if($longitud == 1){
                                                                $porcentaje='100';
                                                            }else{
                                                                
                                                            }
                                                        for($i=0; $i<$longitud; $i++){
                                                           
                                                            $validacionCentroCostoExt = $mysqli->query("SELECT * FROM centroCostos WHERE id='$array[$i]' ");
                                                            $columnaValidandoCentroCosto = $validacionCentroCostoExt->fetch_array(MYSQLI_ASSOC); 
                                                            echo '<td>';
                                                        	echo " ".$columnaValidandoCentroCosto['nombre']; 
                                                        	echo "<input style='width:;' class='form-control' name='porcentaje[]' value='$porcentaje' type='number' min='1' placeholder='Ingresar porcentaje...' required>";
                                                            echo "<input style='width:;' class='form-control' name='usuario[]' value='".$columnaValidandoCentroCosto['persona']."' type='hidden' required >";
                                                            
                                                            echo '</td>';
                                                            
                                                        }
                                                    
                                                    ?>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <table class="table table-head-fixed text-center" >
                                                <tr>
                                                    <th>
                                                        Encargado de la última aprobación
                                                        <select class="form-control" style='width:;' name="aprobador" required>
                                                            <option></option>
                                                            <?php
                                                            $consultaUsuarios=$mysqli->query("SELECT * FROM usuario ORDER BY nombres ");
                                                            while($extraerUsuarios=$consultaUsuarios->fetch_array()){
                                                                $consultaCargo=$mysqli->query("SELECT * FROM cargos WHERE id_cargos='".$extraerUsuarios['cargo']."' ");
                                                                $extraerCargos=$consultaCargo->fetch_array(MYSQLI_ASSOC);
                                                            ?>
                                                            <option value="<?php echo $extraerUsuarios['id'];?>"><?php echo $extraerUsuarios['nombres'].' '.$extraerUsuarios['apellidos'].' -- Cargo ( '.$extraerCargos['nombreCargos'].' )';?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                        
                                        <!--<button type="submit" id="alistamiento"  class="btn btn-primary" name="alistamiento">Agregar</button>-->
                                   
                                </div>
                                
                               
                                <div class="modal-footer justify-content-between">
                                    <button type="submit" id="alistamiento" name="alistamiento" class="btn btn-outline-light">Agregar</button>
                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
                                </div>
                                </form>
                              </div>
                            </div>
                        </div>
                   
                    <?php
                   }
                }
               }
                ?>
                
                </div>
              </div>
              
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
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
     
     <section class="content-header">
         <div class="container-fluid">
            <div class="row">
                <div class="col-sm">
                <!-- AREA CHART -->
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-9">
                                    <div class="row">
                                        <div class="col-sm">
                                             <form action="exportacion/registroProductos" method="post">
                                                <input name="usuario" value="<?php echo $idparaChat;?>" type="hidden">
                                                <button type="submit" class="btn btn-block btn-warning btn-sm" ><a href="#"><font color="white"><i class="fas fa-download"></i> Exportar</font></a></button>
                                            </form>
                                        </div>    
                                        <div class="col-sm">
                                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="importacion/importar-solicitudCompra/solicitudDeProductos.xlsx" onClick="javascript:document["ver-form"].submit();"><font color="white"><i class="fas fa-cloud-download-alt"></i> Descargar Plantilla</font></a></button>
                                        </div>

                                        <div class="col-sm">
                                            
                                            <form action="importacion/importar-solicitudCompra/index" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                                            <div class="custom-file">
                                                 <input type="file" name="file" class="custom-file-input" id="exampleInputFile" accept=".xlsx" required>
                                                
                                                 <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                                                 <label class="custom-file-label" for="exampleInputFile">Importar archivo</label>
                                            </div>
                                        </div>
                                            <div class="col-sm">
                                                <button type="submit" name="import" class="btn btn-block btn-info btn-sm"><a class="" href="#"><font color="white"><i class="fas fa-file-upload"></i> Importar</font></a></button>
                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>
                                
                                <div class="col">
                                  
                                </div>
                          
                            </div>
                                           
                                               
                                                
                                            
                            <script>
                                $('input[name="file"]').on('change', function(){
                                    var ext = $( this ).val().split('.').pop();
                                    if ($( this ).val() != '') {
                                      if(ext == "xlsx" ){
                                        
                                      }
                                      else
                                      {
                                        $( this ).val('');
                                        //alert("Extensión no permitida: " + ext);
                                        const Toast = Swal.mixin({
                                          toast: true,
                                          position: 'top-end',
                                          showConfirmButton: false,
                                          timer: 3000
                                        });
                                    
                                    
                                        Toast.fire({
                                            type: 'warning',
                                            title: ` Extensión no permitida`
                                        })
                                      }
                                    }
                                  });
                            </script>
                        </div>                
                    <div class="card-body">
                        <div class="chart">
                            <div class="card-body table-responsive p-0" >
                                <div class="card-header">
                                     <table class="table table-head-fixed text-center" id="example">
                                         <thead>
                                            <tr>
                                                <th>Grupo</th>
                                                <th>Subgrupo</th>
                                                <!--<th>Consecutivo</th>-->
                                                <th>Producto</th>
                                                <th>Identificador</th>
                                                <th>Código</th>
                                                <th>Impuesto</th>
                                                <th>Tipo producto</th>
                                                <?php
                                                 if($estadoGeneral == 'Aprobado'){}else{
                                                ?>
                                                <th>Agregar</th>
                                                <?php
                                                 }
                                                ?>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $consultaProductos=$mysqli->query("SELECT * FROM proveedorProductos ORDER BY nombre");
                                            while($extraerConsulta=$consultaProductos->fetch_array()){
                                                $id=$extraerConsulta['id'];
                                            ?>
                                            <tr>
                                                <td><?php  
                                                   
                                                    $grupo=$mysqli->query("SELECT * FROM proveedoresProductoGrupo WHERE id='". $extraerConsulta['grupo']."' ");
                                                    $extraerGrupo=$grupo->fetch_array(MYSQLI_ASSOC);
                                                    echo $extraerGrupo['grupo'];
                                                    $subgrupo=$mysqli->query("SELECT * FROM proveedoresProductoSubGrupo WHERE id='". $extraerGrupo['sub']."' ");
                                                    $extraerSubgrupo=$subgrupo->fetch_array(MYSQLI_ASSOC);
                                                    
                                                    ?>
                                                </td>
                                                <td><?php echo $extraerSubgrupo['grupo'];?></td>
                                                <!--<td><?php //echo $extraerConsulta['codigoG'];?></td>-->
                                                <td><?php echo $extraerConsulta['nombre'];?></td>
                                                <td><?php 
                                                    $consultaidentificadorProducto=$mysqli->query("SELECT * FROM proveedoresProductoIdentificador WHERE id='".$extraerConsulta['identificador']."' ");
                                                    $traerDAtosconsultaidentificadorProducto=$consultaidentificadorProducto->fetch_array(MYSQLI_ASSOC);
                                                    echo $traerDAtosconsultaidentificadorProducto['grupo'];
                                                    ?>
                                                </td>
                                                <td><?php echo $extraerConsulta['codigo'];?></td>
                                                <td><?php 
                                                    $consultaImpuesto=$extraerConsulta['impuesto'];
                                                    $validarImpuesto=$mysqli->query("SELECT * FROM proveedoresTipoImpuesto WHERE id='$consultaImpuesto' ");
                                                    $extraerValidarImpuesto=$validarImpuesto->fetch_array(MYSQLI_ASSOC);
                                                    echo $extraerValidarImpuesto['grupo'].' '.$extraerValidarImpuesto['descripcion'].' %';
                                                    ?>
                                                </td>
                                                <td><?php 
                                                        if($extraerConsulta['tipoProducto']){
                                                            echo 'Bienes';
                                                        }else{
                                                            echo 'Servicios';
                                                        }
                                                    ?>
                                                </td>
                                                <?php
                                                 if($estadoGeneral == 'Aprobado'){
                                                     
                                                 }else{
                                                     
                                                    ///// validamos la existencia del flujo para bloquear el botón de agregar productos
                                                    $preguntaFlujoPendienteBloqueoBoton=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idSolicitud='".$_POST['idOrdenCompra']."' AND estado='pendiente' ");
                                                    $extraerPreguntaFlujoPendienteBloqueoBoton=$preguntaFlujoPendienteBloqueoBoton->fetch_array(MYSQLI_ASSOC);
                                                    if($extraerPreguntaFlujoPendienteBloqueoBoton['id'] != NULL){
                                                    ?>
                                                    <td><button disabled style='color:white;' class='btn btn-block btn-success btn-sm'><i class="fas fa-plus-square"></i> Alistar</button></td>
                                                    <?php
                                                    }else{
                                                        ?>
                                                        <!-- desde aca enviamos el id al formulario -->
                                                            <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $extraerConsulta['id'];?>' >
                                                            <td><a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-success btn-sm'><i class="fas fa-plus-square"></i> Alistar</a></td>
                                                            <script>
                                                                function funcionFormula<?php echo $contador2++;?>() {
                                                                    /*alert("entre");*/
                                                                  document.getElementById("js-reg2").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                                                                }
                                                           </script>
                                                        <!-- END -->
                                                        <?php
                                                    }
                                                 }
                                                ?>
                                                    
                                                
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                     </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
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
                                <form method="post" id="js-form" onsubmit="return false" >
                                <div class="modal-body">
                                 Cantidad
                                 
                                 <input type="number"  placeholder="Cantidad..." class="form-control" min='1' value="1"  id="js-reg3" name="reg3">
                                 <br>
                                 Comentario
                                  <input type="text"  placeholder="Comentario..." class="form-control"  id="js-reg4" name="reg4" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                                 </div>
                                <div class="modal-footer justify-content-between">
                                  <input type="hidden"  id="js-reg1" name="reg1" value="<?php echo $idOrdenCompra; ?>" >
                                  <input type="hidden"  id="js-reg2" name="reg2">
                                  <button type="reset" id="js-enviar" class="btn btn-outline-light" data-dismiss="modal">Si</button>
                                  <button type="button" class="btn btn-outline-light" data-dismiss="modal"  onClick="funcion_reiniciar();">No</button>
                                </div>
                               
                                 </form>
                                 <!-- END formulario para eliminar por el id -->
                              </div>
                            </div>
                        </div>
                <!-- END el código de ajax se encuentra después del filtro  -->
                           
              </div>
            </div>  
        </div>      
        <div class="row">
           
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
                        // traemos los datos de la consulta, después de hacer el primer click, trae los datos actualizados después de agregar otro producto
                            $(document).on('click', '#js-consulta', function(e){
                            	e.preventDefault();
                            	var consultaProductos = $('#consultaProductos').val();
                                $.ajax({
                            		url: 'registroProductosJs.php', // Es importante que la ruta sea correcta si no, no se va a ejecutar
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
                            
                            
                        // END
                    </script>  
                  
                  
                  
                    <?php
                    /// Validamos si existe alguien en el flujo para bloquer el boton
                    $preguntaFlujo=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idSolicitud='".$_POST['idOrdenCompra']."' ");
                    $extraerPreguntaFlujo=$preguntaFlujo->fetch_array(MYSQLI_ASSOC);
                    
                    
                    /// Validamos si existe alguien en el flujo con el estado pendiente para mostrar botón en proceso
                    $preguntaFlujoPendiente=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idSolicitud='".$_POST['idOrdenCompra']."' AND estado='pendiente' ");
                    $extraerPreguntaFlujoPendiente=$preguntaFlujoPendiente->fetch_array(MYSQLI_ASSOC);
                    
                    
                    if($estadoGeneral == 'Pendiente' && $extraerPreguntaFlujo['id'] == NULL){
                       ?>
                            <span style="width:20%;" class='btn btn-block btn-success btn-sm' data-toggle='modal' data-target='#modal-evento' > Cierre de productos <span>
                        <?php 
                    }
                    
                    /*if($estadoGeneral == 'Pendiente' && $extraerPreguntaFlujo['id'] == NULL){
                       ?>
                            <span style="width:20%;" class='btn btn-block btn-success btn-sm' data-toggle='modal' data-target='#modal-evento' > Cierre de productos <span>
                        <?php 
                    }*/
                    
                    
                     /// Validamos si existe alguien en el flujo con el estado este en rechazado 
                    $preguntaFlujoPendiente=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idSolicitud='".$_POST['idOrdenCompra']."' AND estado='rechazado' ");
                    $extraerPreguntaFlujoPendiente=$preguntaFlujoPendiente->fetch_array(MYSQLI_ASSOC);
                    if($estadoGeneral == 'Pendiente' && $extraerPreguntaFlujo['id'] != NULL){
                       ?>
                        <form action="controlador/solicitudCompra/controllerAlistamiento" method="post" onsubmit="return checkSubmit();">
                        <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                        <button style="width:20%;" type="submit" class="btn btn-block btn-success btn-sm" name="notificar"> Cierre de productos </button>
                        </form>
                        <?php 
                    }
                    
                    
                    
                    /*if($estadoGeneral == 'Pendiente' && $extraerPreguntaFlujo['id'] != NULL && $extraerPreguntaFlujoPendiente['estado'] == 'pendiente'){ /// verificamos el estado general esté en  pendiente
                    
                        //// confirmamos si existe un rechazo por parte de algún rol para realizar la notificación nuevamente
                        $preguntaFlujoRechazado=$mysqli->query("SELECT * FROM solicitudCompraFlujo WHERE idSolicitud='".$_POST['idOrdenCompra']."' AND estado='rechazado' ");
                        $extraerPreguntaFlujoRechazado=$preguntaFlujoRechazado->fetch_array(MYSQLI_ASSOC);
                        if($extraerPreguntaFlujoRechazado['id'] != NULL){
                        ?>
                            <span style="width:20%;" class='btn btn-block btn-success btn-sm' data-toggle='modal' data-target='#modal-evento' > Cierre de productos 1<span>
                        <?php
                        }else{
                          ?>
                          <button style="width:20%;" class='btn btn-block btn-info btn-sm' disabled> En proceso de solicitud</button>
                          <?php
                        }
                    }else{ 
                    ?>
                    <form action="controlador/solicitudCompra/controllerAlistamiento" method="post" onsubmit="return checkSubmit();">
                        <input name="idOrdenCompra" value="<?php echo $_POST['idOrdenCompra']; ?>" type="hidden">
                        <button style="width:20%;" type="submit" class="btn btn-block btn-success btn-sm" name="notificar"> Cierre de productos 2</button>
                    </form>
                    <?php
                    }*/
                    ?>
                  
                 
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            
                        <script>
                            $(document).on('click', '#js-enviar', function(e){
                            	e.preventDefault();
                            	var reg1 = $('#js-reg1').val(), 
                            	    reg3 = $('#js-reg3').val(),
                            	    reg2 = $('#js-reg2').val(),
                            	    reg4 = $('#js-reg4').val();
                            
                            	$.ajax({
                            		url: 'registroProductosInsert.php', // Es importante que la ruta sea correcta si no, no se va a ejecutar
                            		method: 'POST',
                            		data: { reg1: reg1, reg2: reg2, reg3: reg3, reg4: reg4 },
                            		beforeSend: function(){
                            			$('#mostrarDatos').css('display','block');
                            			//$('#estado p').html('Guardando datos...');
                            		},
                            		success: function(r){
                            			//if (r == '200' ) { // Si el php anterior, imprimió 200
                            				$('#mostrarDatos').html(r);
                            				document.getElementById("js-form").reset();
                            				//location.reload();
                            			//} else {
                            			//	$('#estado').html('<hr><p>Error al guardar los datos.</p><hr>');
                            			//}
                            		}
                            	});
                            });
                          </script>  
                        
                       <script>
                            function funcion_reiniciar(){
                            document.getElementById("js-form").reset();
                            }
                        </script>
                                   

          </div>
          <!-- /.col (RIGHT) -->
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
	    //document.oncontextmenu = function(){return false}
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
  
  
    $validacionProductoExiste=$_POST['validacionProductoExiste'];
    $validacionCodigoExiste=$_POST['validacionCodigoExiste'];
    $validacionIdentificadorExiste=$_POST['validacionIdentificadorExiste'];
    $validacionNumericoExiste=$_POST['validacionNumericoExiste'];
    $validacionValidarPorcentaje=$_POST['validacionValidarPorcentaje'];
 
 
    //// validación de campo vacio, identificando la columna que contiene el campo vacio
    $validacionExisteImportacionVacio=$_POST['validacionExisteImportacionVacio'];
    $mensajeEnviarCampoVacio=" 'Algunos campos están vacios ".$_POST['mensajeEnviarCampoVacio']." ' ";
    /// END
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
      if($validacionExisteImportacionVacio == 1){
      ?>
        Toast.fire({
            type: 'warning',
            title: <?php echo $mensajeEnviarCampoVacio;?>
        })
      <?php
      }
      if($validacionValidarPorcentaje == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El total de porcentaje asignado no puede superar el 100%.'
          })
        <?php
      }
      if($validacionNumericoExiste == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' Esta intentando ingresar letras en un campo númerico.'
          })
        <?php
      }
      if($validacionProductoExiste == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El producto no existe.'
          })
        <?php
      }
      if($validacionCodigoExiste == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El código no existe.'
          })
        <?php
      }
      if($validacionIdentificadorExiste == 1){
        ?>
          Toast.fire({
              type: 'warning',
              title: ' El identificador no existe.'
          })
        <?php
      }
      
      
      
      
      
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
 
    <script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function () {
    bsCustomFileInput.init();
  });
  </script>
  <!-- END -->
  
</body>
</html>
<?php

}
?>
<!-- END -->
</body>
</html>
