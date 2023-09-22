<?php
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Comentarios</title>
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
  <!-- Navbar -->
  <?php echo require_once'menu.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
   
       
        <h5 class="mb-2">Comentarios</h5>
       <?php
            $recibe=$_GET['enviar'];
            $sql= $mysqli->query("SELECT * FROM comunicacionInterna WHERE id = '$recibe' order by id DESC");
    	    while($row = $sql->fetch_assoc()){
    	                     
    	                     
    	                     $idJefeInmediato=$row['idUsuario'];
                             $queryJefeInmediato=$mysqli->query("SELECT * FROM usuario WHERE id='$idJefeInmediato' ");
        	                 $rowDatos=$queryJefeInmediato->fetch_array(MYSQLI_ASSOC);
        	                 $nombreC=$rowDatos['nombres'];
        	                 $fotoC=$rowDatos['foto'];
       ?>
        <div class="row">
          <div class="col-md-6">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                <div class="user-block">
                  <?php if($fotoC != NULL){ ?>
                  <img class="img-circle" src="data:image/jpg;base64, <?php echo base64_encode($fotoC); ?>" alt="User Image">
                  <?php }else{ ?>
                  <img class="img-circle" src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSAFdnwsj9XmZPJzlH-h95QvIm7QjUsIlHkpQ&usqp=CAU" alt="User Image">
                  <?php } ?>
                  <span class="username"><a href="#"><?php echo $nombreC; ?></a></span>
                  <span class="description"><?php echo $fecha =  substr($row['fecha'],0,-11); //$row['fecha']; ?></span>
                </div>
                <!-- /.user-block -->
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Mark as read">
                    <i class="far fa-circle"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" onclick="window.location='myperfil'" class="btn btn-tool" ><i class="fas fa-times"></i> <!-- data-card-widget="remove" -->
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- post text -->
                <p><?php echo $comentario = $row['comentario']; ?></p>

                
                    <?php
                        if($archivo=$row['archivo'] != NULL){
                    ?>
                <!-- Attachment -->
                <div class="attachment-block clearfix">
                    <img src="data:image/jpg;base64, <?php echo base64_encode($archivo=$row['archivo']); ?>"  width="100%" height="" /> <!--  width="100" height="80" onmouseover="this.width=800;this.height=600;" onmouseout="this.width=100;this.height=80;"-->
                <!--
                  <img class="attachment-img" src="data:image/jpg;base64, <?php //echo base64_encode($archivo=$row['archivo']); ?>" alt="Attachment Image">
                -->
                </div>
                <!-- /.attachment-block -->
                <?php 
                        }else{ }
                            
                    }
                ?>
               
              
              </div>
              <!-- /.card-body -->
              
              <?php
            $sql= $mysqli->query("SELECT * FROM comunicacionInternaVer WHERE idComunicacionInterna='$recibe' order by id ASC");
    	    while($row = $sql->fetch_assoc()){
            ?>
              <div class="card-footer card-comments">
                <div class="card-comment">
                  <!-- User image -->
                  <?php
                             $idJefeInmediato=$row['idUsuario'];
                             $queryJefeInmediato=$mysqli->query("SELECT * FROM usuario WHERE id='$idJefeInmediato' ");
        	                 $rowDatos=$queryJefeInmediato->fetch_array(MYSQLI_ASSOC);
        	                 $usuarioCV=$rowDatos['nombres'];
        	                 $fotoCV=$rowDatos['foto'];
        	                 
        	     if($fotoCV != NULL){
                  ?>
                  <img class="img-circle img-sm" src="data:image/jpg;base64, <?php echo base64_encode($fotoCV); ?>" alt="User Image">
                  <?php
        	     }else{
                  ?>
                  <img class="img-circle img-sm"  src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSAFdnwsj9XmZPJzlH-h95QvIm7QjUsIlHkpQ&usqp=CAU" alt="User Image">
                  <?php
        	     }
                  ?>
                    <div class="comment-text">
                    <span class="username">
                      <?php 
                        echo $usuarioCV;
                      ?>
                      <span class="text-muted float-right"><?php echo $fecha = substr($row['fecha'],0,-11); ?></span>
                    </span><!-- /.username -->
                    <?php echo $comentario = $row['comentario']; ?>
                  </div>
                  <!-- /.comment-text -->
                </div>
                <!-- /.card-comment -->
               
              </div>
              <?php
    	            }   
              ?>
              <!-- /.card-footer -->
              <div class="card-footer">
                <form action="controlador/comunicacionInterna/controllerComunicacionInterna" method="post">
                  <?php
                  if($foto != NULL){
                  ?>
                  <img class="img-fluid img-circle img-sm" src="data:image/jpg;base64, <?php echo base64_encode($foto); ?>" alt="Alt Text">
                  <?php
                    }else{
                  ?>
                  <img class="img-fluid img-circle img-sm" src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSAFdnwsj9XmZPJzlH-h95QvIm7QjUsIlHkpQ&usqp=CAU" alt="Alt Text">
                  <?php
                    }
                  ?>
                  <!-- .img-push is used to add margin to elements next to floating images -->
                  <div class="img-push">
                      <?php
                             $idJefeInmediato=$sesion;
                             $queryJefeInmediato=$mysqli->query("SELECT * FROM usuario WHERE cedula='$idJefeInmediato' ");
        	                 $rowDatos=$queryJefeInmediato->fetch_array(MYSQLI_ASSOC);
        	                 $identificadorCV=$rowDatos['id'];
        	                 
                      ?>
                      <input name="enviar" type="hidden" value="<?php echo $recibe; ?>">
                      <input name="idUsuarioCV" value="<?php echo $identificadorCV; ?>" type="hidden">
                    <input type="text" class="form-control form-control-sm" name="comentarioVer" placeholder="Agregar comentario"><br>
                    <button type="submit" name="AddcomunicacionInternaVer" class="btn btn-danger">Publicar</button>
                  </div>
                </form>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

 

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
</body>
</html>
<?php
}
?>