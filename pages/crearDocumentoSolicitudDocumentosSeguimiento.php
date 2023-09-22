<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
//require_once 'inactividad.php';
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Seguimiento solicitud documentos</title>
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
            <h1></h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"></a></li>
              <li class="breadcrumb-item active"></li>
            </ol>
          </div>
        </div>
        
      </div><!-- /.container-fluid -->
    </section>
<?php

   $tipoSolicitud = $_POST['tipoSolicitud'];
   $id = $_POST['id'];
    
    
    require 'conexion/bd.php';
    $acentos = $mysqli->query("SET NAMES 'utf8'");
    $data = $mysqli->query("SELECT * FROM solicitudDocumentos WHERE id = '$id'")or die(mysqli_error());
    while($row = $data->fetch_assoc()){
        $solicitud = $row['tipoSolicitud'];
        $solicitudTipo = $row['tipoSolicitud'];
        
        if($solicitud != 1){
            $nomb = $row['nombreDocumento'];
            $query2 = $mysqli->query("SELECT * FROM documento WHERE id ='$nomb'");
            $col2 = $query2->fetch_array(MYSQLI_ASSOC);
            $nombre = $col2['nombres'];
            //$nombre = $col2['nombreDocumento2'];
            
        }else{
            $nombre = $row['nombreDocumento2'];
        }
        $tipo =$row['tipoDocumento'];//variable para traer el tipo doc
        $query = $mysqli->query("SELECT * FROM tipoDocumento WHERE id = '$tipo'");
        $col = $query->fetch_array(MYSQLI_ASSOC);
        $tipoDoc = $col['nombre'];
        //$nombre = $row['nombreDocumento'];
        $solicitud = $row['solicitud'];
        $ruta = $row['documento'];
        $estado = $row['estado'];
        $quienAprueba = $row['QuienAprueba'];
        $idDocumentoActualizar = $row['nombreDocumento'];
        $quienSolicita = $row['encargadoAprobar']; 
        
                   
        }
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
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
                <div class="card-body">
                
                    <!--<h6 class="description-header"><b>Tipo Documento:</b></h6>
                    <span class=""><?php //echo $tipoDoc;?></span>
                  
                    <h6 class="description-header"><b>Nombre:</b></h6>
                    <span class=""><?php //echo $nombre;?></span>
                 
                    <h6 class="description-header"><b>Descripción:</b></h6>
                    <span class=""><?php //echo $solicitud;?></span>
                 
                    <h6 class="description-header"><b>Estado:</b></h6>
                    <span class=""><?php //echo $estado;?></span>-->
                 
                  
                  <?php
                        $datos = $mysqli->query("SELECT * FROM comentarioSolicitud WHERE idSolicitud = '$id'");
                        $rows =  mysqli_num_rows($datos);
    
                        if($rows > 0){
                            $display = '';
                        }else{
                            $display = 'none';
                        }
                  ?>
                 
                
                 <script> 
                 window.onload=function(){
                    document.forms["miformulario"].submit();
                    }
                </script>
                    
                  
                   
                  <form name="miformulario" role="form" action="controlador/solicitudDocumentos/controller" method="post">
                      <input name="quienElabora" readonly value="<?php echo $sesion;?>" type="hidden">
                  <?php
                    if($estado == 'Rechazado'){
                       echo '<br><font color="red"><b>El documento se encuentra Rechazado</b></font>';
                       //// se actualiza el campo para quitar la notificación de rechazo en las notificaciones
                            if(isset($_POST['rechazoAplicar'])){
                                $rechazo=$_POST['rechazoAplicar'];
                                $rechazoDocumento= $mysqli->query("UPDATE solicitudDocumentos SET rechazoSolicitud='$rechazo' WHERE id='$id'  ");
                            }
                       /// END
                    }else{  
                          
                          
                         
                  ?>
                                <!-- <div class="form-group">
                                    <label>Acciones:</label> -->
                                    <select name="accion" id="select_acciones" class="form-control" style="visibility:hidden;" onchange="ShowSelected();">
                                      <option value="Aprobado">Aprobado</option>
                                    </select>
                               <!--  </div>
                                <div class="form-group">
                                    <label>Días Elaboración</label> -->
                                    <input type="hidden" class="form-control" name="dias" min="1">
                                <!-- </div>
                                
                                <div class="form-group">
                                    <label >Comentarios</label> -->
                                    <input type="hidden" class="form-control" name="comentarios" placeholder="">
                              <!--  </div> -->
                  <?php
                          
                    }
                  ?>
                <center>
                    <style>
                        .preloader {
                              width: 70px;
                              height: 70px;
                              border: 10px solid #eee;
                              border-top: 10px solid #666;
                              border-radius: 50%;
                              animation-name: girar;
                              animation-duration: 2s;
                              animation-iteration-count: infinite;
                              animation-timing-function: linear;
                            }
                            @keyframes girar {
                              from {
                                transform: rotate(0deg);
                              }
                              to {
                                transform: rotate(360deg);
                              }
                            }
                    </style> 
                    <div class="preloader"></div> Cargando
                </center>
                 
                </div>
                <!-- /.card-body -->
                
                <div class="card-footer" >
                  
                    <input type="hidden" name="id" value="<?php echo $id?>">
                    <input type="hidden" name="idDocumento" value="<?php echo $idDocumentoActualizar?>">
                    <input type='hidden' name='tipoSolicitud' value="<?php echo $tipoSolicitud;?>">
                    <input type='hidden' name='solicitud' value="<?php echo $solicitud;?>">
                     
                    <input readonly name="seguimientoSolicitudDocumentoCargado" value="1" type="hidden">
                    
                    <button style="visibility:hidden;" type="submit" name="seguimientoSolicitudDocumentoCargado" class="btn btn-primary float-right">Enviar</button>
              
                </div>
              </form>
               <!--
               <div class="card-footer" >
              
                <form name="miformulario" action="crearDocumentoB" method="POST" onsubmit="procesar(this.action);" >
                     <input type="hidden" name="validacionAgregar" value="1">
                    <input type="" name="idSolicitud" value="<?php //echo $id; ?>">
                    <input type="" name="solicitud" value="<?php //echo $solicitud; ?>">
                    <button type="submit" name="seguimiento" class="btn btn-success float-right">Asignar</button>
                </form>
              
              </div>
               -->
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

<!--Select dinamico-->
<script type="text/javascript">
function ShowSelected(){
/* Para obtener el valor */
    var cod = document.getElementById("select_acciones").value;
    
    if(cod == "Aprobado"){
        document.getElementById('diasDiv').style.display = '';
    }
    


}
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
            title: ' El nivel o la prioridad ya existe.'
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
</body>
</html>
<?php
}
?>