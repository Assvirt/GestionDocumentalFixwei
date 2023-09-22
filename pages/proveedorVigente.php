<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
require_once 'conexion/bd.php';

$idSolicitud = $_POST['idSolicitud'];
$rol = $_POST['rol'];

$formulario = 'proveedoresActivos'; //aqui se cambia el nombre del formulario
//require_once 'permisosPlataforma.php';
$documento = $_SESSION["session_username"];
$queryGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario = '$documento'");

while($row = $queryGrupos->fetch_assoc()){
    $idGrupo = $row['idGrupo'];
    
    $queryPermisos = $mysqli->query("SELECT * FROM permisos WHERE idGrupo = '$idGrupo' AND formulario = '$formulario'");
    $permisos = $queryPermisos->fetch_array(MYSQLI_ASSOC);
    if($permisos['listar'] == TRUE){
        $permisoListar = $permisos['listar'];    
    }
    if($permisos['crear'] == TRUE){
        $permisoInsertar = $permisos['crear'];    
    }
    if($permisos['editar'] == TRUE){
        $permisoEditar = $permisos['editar'];    
    }
    if($permisos['eliminar'] == TRUE){
       $permisoEliminar = $permisos['eliminar'];    
    }
    
}

$root = $_SESSION['session_root'];

if($root == 1){
    $permisoListar = TRUE;
    $permisoInsertar = TRUE;
    $permisoEditar = TRUE;
    $permisoEliminar = TRUE;
}

if($permisoListar == FALSE){
    echo '<script language="javascript">window.location.href="accesoDenegado"</script>';
}

if($permisoInsertar == FALSE){
    $visibleI = 'none';
}else{
    $visibleI = '';
}

if($permisoEditar == FALSE){
    $visibleE = 'none';
}else{
    $visibleE = '';
}

if($permisoEliminar == FALSE){
    $visibleD = 'none';
}else{
    $visibleD = '';
}
//////////////////////PERMISOS////////////////////////





?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Crear proveedor vigente</title>
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
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!--CKeditor-->
  <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
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
            <h1>Crear Proveedor Vigente</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Crear proveedor Vigente</li>
            </ol>
          </div>
        </div>
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
                <div class="row">
                    <div class="col-sm">
                       <button type="button" class="btn btn-block btn-info btn-sm"><a href="proveedores"><font color="white"><i class="fas fa-list"></i> Listar proveedores</font></a></button>
                    
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
            </div>
            <div class="col">
            </div>   
        </div>
      
        
      </div><!-- /.container-fluid -->
    </section>
    
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
         
        <div class="row">
            
            <div class="col">
            </div>
           
            <div class="col-9">
                    
            <div class="card card-primary">
            
                                     
             
                    <div class="card-body">
                        
                    <div class="card-body table-responsive p-0" >
                        <table class="table table-head-fixed text-center" >
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>NIT</th>
                                    <th>Proveedor</th>
                                    <th>Email</th>
                                    <th>Ver más</th>
                                    <th style="display:<?php echo $visibleE;?>;" >Editar</th>
                                    <th style="display:<?php echo $visibleE;?>;" >Documentos</th>
                                    <th style="display:<?php echo $visibleD;?>;" >Eliminar</th>
                                    <th style="display:<?php echo $visibleD;?>;" >Ejecutar</th>
                                </tr>    
                            </thead>
                            <tbody>
                                <?php
                                
                                $consultandoProveedorMasivo=$mysqli->query("SELECT * FROM proveedores WHERE estado='Ejecucion' ORDER BY id");
                                $conteo='1';
                                $contadorDocumentos=1;
                                while($recorridoProveedores=$consultandoProveedorMasivo->fetch_array()){
                                    $id=$recorridoProveedores['id'];
                                ?>
                                <tr>
                                    <td><?php echo $conteo++; ?></td>
                                    <td>
                                        <?php echo $recorridoProveedores['nit'].'-'.$recorridoProveedores['nitDigito'];?>
                                    </td>
                                    <td> 
                                        <?php echo $recorridoProveedores['razonSocial'];?>
                                    </td>
                                    <?php/*
                                    <td>
                                        <?php echo $recorridoProveedores['descripcion'];?>
                                    </td>*/
                                    ?>
                                    <td>
                                         <?php echo $recorridoProveedores['email'];?>
                                    </td>
                                    
                                    <?php
                                    $idProveedores=$recorridoProveedores['id'];
                                         ?>
                                    </td>
                                    
                                    <td>
                                    <?php
                                    echo"<form action='proveedoresVer' method='POST'>";
                                    echo"<input type='hidden' name='idProveedor' value= '$id' >";
                                    echo"<input type='hidden' name='masivo' value='1' >";
                                    echo"<button type='submit' class='btn btn-block btn-primary btn-sm'><i class='fas fa-eye'></i> Ver más</button>";
                                    echo"</form>";
                                    ?>    
                                    </td>
                                    
                                    
                                    <td style="display:<?php echo $visibleE;?>;">
                                        <form action="proveedoresEditar" method="POST">
                                        <input type='hidden' name='idProveedor' value= '<?php echo $id; ?>' >
                                        <input type='hidden' name='masivo' value='1' >
                                        <button  type='submit' name="editarProveedorMasivo" class='btn btn-block btn-success btn-sm'><i class='fas fa-edit'></i> Editar</button>
                                        </form>
                                    </td>
                                   
                                    <td style="display:<?php echo $visibleE;?>;" >
                                    <form action="subirDocumentoMasivo" method="POST">
                                        <input name="idProveedor" value="<?php echo $recorridoProveedores['id']; ?>" type="hidden">
                                        <input name="masivoEnviar" type="hidden" value="1">
                                        <button type='submit' value="<?php $recorridoProveedores['id']; ?>" class='btn btn-block btn-warning btn-sm' >
                                            <i class='fas fa-file-upload'></i> Documentos
                                        </button>
                                        
                                    </form>
                                    </td>
                                    
                                    <td style="display:<?php echo $visibleD;?>;">
                                         
                                    <input type='hidden' id='capturaVariable<?php echo $contador++;?>'  value= '<?php echo $id;?>' >
                                    <a onclick='funcionFormula<?php echo $contador1++;?>()' style='color:white;' data-toggle='modal' data-target='#modal-danger' class='btn btn-block btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Eliminar</a>
                                    <script>
                                        function funcionFormula<?php echo $contador2++;?>() {
                                           
                                          document.getElementById("capturarFormula").value = document.getElementById("capturaVariable<?php echo $contador3++;?>").value;
                                        }
                                   </script>
                       
                                        
                                    </td>
                                    
                                    
                                        
                                    <td style="display:<?php echo $visibleD;?>;" >
                                        <?php
                                        // consultams existencia de documentos
                                        $consultandoDocmentos=$mysqli->query("SELECT * FROM uploadsP WHERE user='".$recorridoProveedores['id']."' ");
                                        $extraerConsultandoDocumentos=$consultandoDocmentos->fetch_array(MYSQLI_ASSOC);
                                        
                                        if($extraerConsultandoDocumentos['id'] != NULL){
                                            $contadorDocumentos++;
                                        ?>
                                        <form action="controlador/proveedor/controllerAlmacenamientoMasivo" method="POST">
                                            <input name="idProveedor" value="<?php echo $recorridoProveedores['id']; ?>" type="hidden">
                                            <input value="<?php echo $idparaChat;?>" name="Usuario" type="hidden">
                                            <button type='submit' name="ejecutadorIndividual" class='btn btn-block btn-info btn-sm' >
                                                <i class='fas fa-check'></i> Ejecutar
                                            </button>
                                        </form>
                                        <?php
                                        }else{
                                        ?>
                                        <button disabled  class='btn btn-block btn-info btn-sm' >
                                                <i class='fas fa-check'></i> Ejecutar
                                        </button>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                   
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>    
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
                            <form action='controlador/proveedor/controllerProveedor' method='POST'> <!--  -->
                            <div class="modal-footer justify-content-between">
                              <input type='hidden' name='masivo' value='1' >
                              <input type="hidden" id="capturarFormula" name='idProveedor' readonly>
                              <button type="submit" name='Eliminar' class="btn btn-outline-light">Si</button>
                              <button type="button" class="btn btn-outline-light" data-dismiss="modal">No</button>
                            </div>
                             </form>
                             <!-- END formulario para eliminar por el id -->
                          </div>
                        </div>
                    </div>    
                        
                        <?php //echo $conteo;
                        if($conteo > 1){
                            if($conteo == $contadorDocumentos){
                            ?>
                            <div class="card-body" style="display:<?php echo $visibleD;?>;">
                                <form action="controlador/proveedor/controllerAlmacenamientoMasivo" method="POST">
                                 <input value="<?php echo $idparaChat;?>" name="Usuario" type="hidden">    
                                <button type='submit' name="ejecutador" class='btn btn-block btn-info btn-sm float-left' style="width:20%;"><i class="fas fa-tasks"></i> Ejecutar todo</button>
                                </form>
                            </div>
                            <?php    
                            }else{
                            ?>
                            <div class="card-body" style="display:<?php echo $visibleD;?>;">
                                <button disabled class='btn btn-block btn-info btn-sm float-left' style="width:20%;"><i class="fas fa-tasks"></i> Ejecutar todo</button>
                            </div>
                            <?php    
                            }
                        
                        }
                            $solicitud = $_POST['solicitud']; 
                        ?>
                        <p>
                            <?php 
                                echo $solicitud;
                            
                            $buscandoNombre=$mysqli->query("SELECT * FROM solicitudDocumentos WHERE id='$idSolicitud' ");
                            $traerNombreSolicitud=$buscandoNombre->fetch_array(MYSQLI_ASSOC);
                            
                            ?>
                        </p>
                        
                            <br><br>
                        
                    </div>
            </div>
            </div>    

            <div class="col">
            </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>


  <section class="content" style="display:<?php echo $visibleI; ?>;">
      <div class="container-fluid">
        <!-- /.row -->
         
        <div class="row">
            
            <div class="col">
            </div>
           
            <div class="col-9">
                    
                <div class="card card-primary">
                   <?php
                   /*
                   ?>
                    <br>
                    <div class="row">
                        &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                        <div class="col-9">
                            <div class="row">
                                <div class="col-sm">
                                        <button type="button" class="btn btn-block btn-info btn-sm"><a href="importacion/importar-proveedoresActivos/Proveedores-activos.xlsx" onClick="javascript:document["ver-form"].submit();"><font color="white"><i class="fas fa-cloud-download-alt"></i> Descargar Plantilla</font></a></button>
                                </div>
                                <div class="col-sm">
                                        <button type="button" class="btn btn-block btn-warning btn-sm" Onclick="window.location='excel2'"><a href="#"><font color="white"><i class="fas fa-cloud-download-alt"></i> Plantilla De Datos</font></a></button>
                                </div>
                                <form action="importacion/importar-proveedoresActivos/index" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                                    
                                <div class="col-sm">
                                    <input value="<?php //echo $idparaChat;?>" name="Usuario" type="hidden">
                                    <div class="custom-file">
                                        <input type="file" name="file" class="custom-file-input" id="exampleInputFile" accept=".xls,.xlsx" required>
                                                <!-- Agregamos esta linea para validar que solo sea el documento pdf-->
                                                <script>
                                                $('input[name="file"]').on('change', function(){
                                                    var ext = $( this ).val().split('.').pop();
                                                    if ($( this ).val() != '') {
                                                      if(ext == "xls" || ext == "xlsx"){
                                                        
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
                                                <!-- END -->
                                        <label class="custom-file-label" for="exampleInputFile" required>Importar archivo</label>
                                        
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
                    <?php
                    */
                    ?>         
                    
                    
                    
                <form style="display:<?php echo $visibleI;?>;" role="form" action="controlador/proveedor/controllerProveedor" method="POST" enctype="multipart/form-data">
                <input name="realizador" value="<?php echo $idparaChat;?>" type="hidden">
                <div class="card-body">
                    
                <!-- parametros para la activacion de correo y plataforma -->
                    <div class="row"> 
                        <div class="form-group col-sm-6">
                          <input name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden" readonly>
                              <?php if($visibleP != 'none'){ ?>
                              
                                
                                    <input style="border:0px;" name="plataforma" value="1" type="hidden" readonly>
                                <?php }else{  }
                          
                              if($visibleP != 'none' && $visibleC != 'none'){
                                   '-';
                              }
                          
                                    if($visibleC != 'none'){ ?>
                                    <input style="border:0px;" name="correo" value="1" type="hidden" readonly>
                                <?php }else{  } ?>
                        </div>
                    </div>
                <!-- Fin parametros para la activacion de correo y plataforma -->
                    
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label>Nit:</label>
                            <input type="number" min="0" class="form-control"  name="nit" placeholder="Nit" onkeypress="return soloLetras(event)" onkeydown="noPuntoComa( event )" required  onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218 )">
                        </div>
                        <div class="form-group col-sm-2">
                            <label style="color:white;">.</label>
                            <input type="number" min="0" class="form-control"  name="nitDigito" placeholder="Dígito" required >
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label>Contacto:</label>
                            <input type="text" class="form-control"  name="contacto" placeholder="Contacto" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                        </div>                                
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Raz&oacute;n social:</label>
                            <input type="text" class="form-control" name="razonSocial" placeholder="Raz&oacute;n social" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Correo Electr&oacute;nico:</label>
                            <input type="email" class="form-control" name="email" placeholder="Correo" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Móvil:</label>
                            <input type="text" class="form-control" name="movil" placeholder="Móvil" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" >
                        </div>
                    
                        <div class="form-group col-sm-3">
                            <label>Código Ciiu:</label>
                            <input type="number" min="0" class="form-control" name="codigoCiiu" placeholder="Código Ciiu" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                        </div>
                        <div class="form-group col-sm-3">
                            <label>Descripción para el Texto:</label>
                            <textarea type="text" class="form-control" name="descripcion" placeholder="Descripci&oacute;n para el texto" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)"></textarea>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Criticidad:</label>
                            <select type="text" class="form-control" name="criticidad" placeholder="Criticidad" required>
                                <option value=""></option>
                                <?php
                                $consultaTipoProveedor=$mysqli->query("SELECT * FROM proveedoresCriticidad ORDER BY tipo");
                                while($extraerConsultaTipoprove=$consultaTipoProveedor->fetch_array()){
                                ?>
                                <option value="<?php echo $extraerConsultaTipoprove['id'];?>"><?php echo $extraerConsultaTipoprove['tipo'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>                        
                    
                        <div class="form-group col-sm-6">
                            <label>Grupo:</label>
                            <?php
                                require_once'conexion/bd.php';
                                //$acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT * FROM proveedoresGrupo ORDER BY grupo");
                            ?>
                            <select type="text" class="form-control" name="grupo" placeholder="Grupo" required>
                                <option value=''></option>
                                <?php
                                while ($columna = mysqli_fetch_array( $resultado )) { ?>
                                <option value="<?php echo $columna['id']; ?>"><?php echo $columna['grupo']; ?> </option>
                                <?php }  ?>
                            </select>
                        </div>
                       </div>
                       
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Método de pago :</label>
                            
                            <br>
                            Crédito <input id="habilitarCredito" type="radio" name="terminoPago" value="credito" required>&nbsp;
                            Contado <input id="habilitarContado" type="radio" name="terminoPago" value="contado" required>&nbsp;
                            Contraentrega <input id="habilitarContraEntrefa" type="radio" name="terminoPago" value="contraentrega" required>&nbsp;
                            Otro <input id="habilitarOtro" type="radio" name="terminoPago" value="otro" required>
                         </div>
                         
                         <div class="form-group col-sm-6">
                            <label style="display:none;" id="nd">Número de días</label>
                            <label style="display:none;" id="io">Ingrese otro método de pago</label>
                            <input type="number" style="display:none;" id="mostrar" class="form-control" name="terminoPagoNumeros" placeholder="Días" min="0" >
                            <input type="text" style="display:none;" id="otro" class="form-control" name="otro" placeholder="Ingrese metodo de pago" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                            
                          <script> //// validación para cambiar de proceso
                                $(document).ready(function(){
                                    $('#habilitarCredito').click(function(){ 
                                        document.getElementById('mostrar').style.display = '';
                                        document.getElementById('otro').style.display = 'none';
                                        document.getElementById('nd').style.display = '';
                                        document.getElementById('io').style.display = 'none';
                                    });
                                    $('#habilitarContado').click(function(){  
                                        document.getElementById('mostrar').style.display = 'none';
                                        document.getElementById('otro').style.display = 'none';
                                        document.getElementById('nd').style.display = 'none';
                                        document.getElementById('io').style.display = 'none';
                                    });
                                    $('#habilitarContraEntrefa').click(function(){ 
                                        document.getElementById('mostrar').style.display = 'none';
                                        document.getElementById('otro').style.display = 'none';
                                        document.getElementById('nd').style.display = 'none';
                                        document.getElementById('io').style.display = 'none';
                                    });
                                    $('#habilitarOtro').click(function(){ 
                                        document.getElementById('otro').style.display = '';
                                        document.getElementById('mostrar').style.display = 'none';
                                        document.getElementById('nd').style.display = 'none';
                                        document.getElementById('io').style.display = '';
                                    });
                                  
                                });
                            </script>
                         </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Ciudad:</label>
                            <?php
                                require_once'conexion/bd.php';
                                //$acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT municipios.id,municipios.nombre AS Municipio, departamentos.nombre AS Departamento FROM municipios INNER JOIN departamentos ON municipios.departamento_id = departamentos.id");
                            ?>
                            <select type="text" class="form-control" name="ciudad" placeholder="" required>
                                <option value=''></option>
                                <?php
                                while ($columna = mysqli_fetch_array( $resultado )) { ?>
                                <option value="<?php echo $columna['id']; ?>"><?php echo $columna['id'].' - '. $columna['Departamento'].' - '.$columna['Municipio']; ?> </option>
                                <?php }  ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Direcci&oacute;n:</label>
                            <input type="text" class="form-control" name="direccion" placeholder="Direcci&oacute;n" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                        </div>
                        
                    </div>
                    <div class="row">
                        
                        <div class="form-group col-sm-6">
                            <label>Frecuencia actualizaci&oacute;n de documentos (Meses):</label>
                            <input type="number" class="form-control" name="frecuenciaAD" placeholder="Frecuencia actualizaci&oacute;n de documentos" min="0" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Tel&eacute;fono:</label>
                            <input type="number" class="form-control" name="telefono" placeholder="Tel&eacute;fono" min="0" required>
                        </div>
                        
                    </div>
                    <div class="row">
                        
                        <div class="form-group col-sm-6">
                            <label>Tiempo para evaluaci&oacute;n (Meses):</label>
                            <input type="number" class="form-control" name="tiempoE" placeholder="Tiempo para evaluaci&oacute;n" min="0" required>
                        </div>
                      
                         <div class="form-group col-sm-6">
                            <label>Persona natural:</label>
                            <input type="radio" name="personaNJ" value="natural" required>
                            &nbsp;
                            <label>Persona jurídica:</label>
                            <input type="radio" name="personaNJ" value="jurídica" required>
                        </div>
                    </div>
                    <div class="row">
                       
                        <div class="form-group col-sm-6">
                            <label>Tipo de proveedor:</label>
                            <select  class="form-control" name="tipoproveedor"  required>
                                <option value=""></option>
                                
                                <?php
                                $consultaTipoProveedor=$mysqli->query("SELECT * FROM proveedoresTipo ORDER BY tipo");
                                while($extraerConsultaTipoprove=$consultaTipoProveedor->fetch_array()){
                                ?>
                                <option value="<?php echo $extraerConsultaTipoprove['id'];?>"><?php echo $extraerConsultaTipoprove['tipo'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                       
                    </div>
                    
                   <input value="<?php echo $idparaChat;?>" name="Usuario" type="hidden">
                   
                        <!--<div class="form-group col-sm-6">
                            <label>Aprobación de proveedor: </label><br>
                            <input type="radio" id="rad_cargoRI" name="radiobtn" value="cargo" required>
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioRI" name="radiobtn" value="usuario" required>
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width:100%;" name="select_encargadoRI[]" id="select_encargadoRI" required></select>
                            </div>
                        </div>
                        -->
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                  
                  <button type="submit" class="btn btn-primary float-right" name="AgregarProveedorMasivo">Agregar</button>
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
  </div>
  <!-- /.content-wrapper -->
<?php //echo //require_once'footer.php'; ?>
 
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<!-- para mostrar el archivo seleccionado en el file -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<!-- END -->

<!--Ckeditor-->
<script>
    CKEDITOR.replace( 'editor1' );
</script>
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
<!-- Select2 -->
<script src="../plugins/select2/js/select2.full.min.js"></script>
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
<!--Select dinamico-->


<script>
    $(document).ready(function(){
        $('#rad_cargoRI').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoRI").html(data);
            }); 
        });
        $('#rad_usuarioRI').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoRI").html(data);
            }); 
        });
    });
</script>


<!--Oculta div versionamiento-->
<script>
    $(document).ready(function(){
        $('#rad_manual').click(function(){
            document.getElementById('codificacionManual').style.display = '';
            document.getElementById("id_version").setAttribute("required","any");
            document.getElementById("consecutivo").setAttribute("required","any");
            document.getElementById("idDocumento").setAttribute("required","any");
        });
        $('#rad_automatica').click(function(){
            document.getElementById('codificacionManual').style.display = 'none';
            document.getElementById("id_version").removeAttribute("required","any");
            document.getElementById("consecutivo").removeAttribute("required","any");
            document.getElementById("idDocumento").removeAttribute("required","any");
        });
    });
</script>
<!-- script que valida version y consecutivo -->
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
    

<!-- END -->
<!-- SweetAlert2 -->
<link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<script>
    const MAXIMO_TAMANIO_BYTES = 11000000; // 1MB = 1 millón de bytes



    // Obtener referencia al elemento
    const $myInputPDF = document.querySelector("#myInputPDF");

    $myInputPDF.addEventListener("change", function () {
        // si no hay archivos, regresamos
        if (this.files.length <= 0) return;

        // Validamos el primer archivo únicamente
        const archivo = this.files[0];
        if (archivo.size > MAXIMO_TAMANIO_BYTES) {
            const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
            //alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
            });
        
        
            Toast.fire({
                type: 'warning',
                title: ` El tamaño máximo del archivo es de 10 MB`
            })
            // Limpiar
            $myInputPDF.value = "";
        } else {
            //alert(`alerta`);
            // Validación asada. Envía el formulario o haz lo que tengas que hacer
        }
    });


// myInpuEditable

   // Obtener referencia al elemento
   const $myInpuEditable = document.querySelector("#myInpuEditable");

$myInpuEditable.addEventListener("change", function () {
    // si no hay archivos, regresamos
    if (this.files.length <= 0) return;

    // Validamos el primer archivo únicamente
    const archivo = this.files[0];
    if (archivo.size > MAXIMO_TAMANIO_BYTES) {
        const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
        //alert(`El tamaño máximo del archivo es de ${tamanioEnMb} MB`);
        const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
        });
    
    
        Toast.fire({
            type: 'warning',
            title: ` El tamaño máximo del archivo es de 10 MB`
        })
        // Limpiar
        $myInpuEditable.value = "";
    } else {
        // Validación asada. Envía el formulario o haz lo que tengas que hacer
    }
});
</script>
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
  <!-- archivos para el filtro de busqueda y lista de informaci��n -->

    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main.js"></script>
<!-- END -->  
<?php
/// validaciones de alertas
$validacionExisteImportacionVacio=$_POST['validacionExisteImportacionVacio'];
$validacionExisteImportacion1=$_POST['validacionExisteImportacion1'];
$validacionExisteImportacion2=$_POST['validacionExisteImportacion2'];
$validacionExisteImportacion3=$_POST['validacionExisteImportacion3'];
$validacionExisteImportacion4=$_POST['validacionExisteImportacion4'];
$validacionExisteImportacion5=$_POST['validacionExisteImportacion5'];
$validacionExisteImportacion6=$_POST['validacionExisteImportacion6'];
$validacionExisteImportacion7=$_POST['validacionExisteImportacion7'];
$validacionExisteImportacion8=$_POST['validacionExisteImportacion8'];
$validacionExisteImportacion9=$_POST['validacionExisteImportacion9'];
$validacionExisteImportacion10=$_POST['validacionExisteImportacion10'];
$validacionExisteImportacion11=$_POST['validacionExisteImportacion11'];
$validacionActualizar=$_POST['validacionActualizar'];
$validacionExisteImportacionExito=$_POST['validacionExisteImportacionExito'];
$validacionEliminar=$_POST['validacionEliminar'];
$validacionExisteImportacionMetodoPago=$_POST['validacionExisteImportacionMetodoPago'];
$alertaConfirmacionCorreo=$_POST['alertaConfirmacionCorreo'];
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
    if($alertaConfirmacionCorreo == 1){
      ?>
          Toast.fire({
              type: 'warning',
              title: ' Algunos de los correos no son validos.'
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
    
    if($validacionExisteImportacionVacio == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Algunos campos están vacios.'
        })
    <?php
    }
     if($validacionExisteImportacion1 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El nit ya existe.'
        })
    <?php
    }
     if($validacionExisteImportacion2 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El nit se repite en el documento.'
        })
    <?php
    }
     if($validacionExisteImportacion3 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El nombre del proveedor ya existe.'
        })
    <?php
    }
     if($validacionExisteImportacion4 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El nombre del proveedor se repite en el documento.'
        })
    <?php
    }
      if($validacionExisteImportacion5 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' La criticidad no existe.'
        })
    <?php
    }
    
      if($validacionExisteImportacion6 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El grupo no existe.'
        })
    <?php
    }
    
      if($validacionExisteImportacion7 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El método de pago no existe.'
        })
    <?php
    }
    
      if($validacionExisteImportacion8 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El código de la ciudad no existe.'
        })
    <?php
    }
      if($validacionExisteImportacion9 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El tipo de persona no existe.'
        })
    <?php
    }
      if($validacionExisteImportacion10 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' El tipo de proveedor no existe.'
        })
    <?php
    } 
      if($validacionExisteImportacion11 == 1){
    ?>
        Toast.fire({
            type: 'warning',
            title: ' Está intentando ingresar letras en un campo númerico.'
        })
    <?php
    }
    
    
    
    
    if($validacionExisteImportacionExito == 1){
    ?>
        Toast.fire({
            type: 'success',
            title: 'Excel importado con éxito.'
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
    
    if($validacionExisteImportacionMetodoPago == 1){
    ?>
        Toast.fire({
            type: 'error',
            title: 'El método de pago es incorrecto.'
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