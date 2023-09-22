<?php
session_start();
if(!isset($_SESSION["session_username"])){
  require_once'cierreSesion.php';
}else{
    include 'conexion/bd.php';
    
    $_SESSION["session_username"];
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Chat</title>
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
  
  <!-- enlace para usar el chat -->
  <link rel="stylesheet" type="text/css" href="conversacion.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="//twemoji.maxcdn.com/twemoji.min.js"></script>
   <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
  <!-- END -->
  
  
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">


<?php require_once'menu.php'; ?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Chat</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Chat</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-4">
          
          <div class="col-sm-6">
            <!-- Modal 
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            -->
              
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Usuarios conetactados</h5>
                    <!--
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button> -->
                  </div>
                  <div class="modal-body">
                     <!-- traemos solo los usuarios que están conectados-->
                        <section id="usuarios"></section>
                    <!-- end-->
                  </div>
                </div>
              
            
          </div>
            
          <div class="col-sm-4">
            
            <!--
            <button href="#" id="abrirChatGrupal" class="btn btn-primary">Chat grupal</button>
            <button href="#" id="cerrarChatGrupal" class="btn btn-success" style="display:none;">Cerrar</button>
            -->
            <br><br>
            
            <?php
            include'pruebasRecibir.php';
           // if($_POST['solicitarChat'] != NULL){
            ?>
            <div class="card card-prirary cardutline direct-chat direct-chat-primary" id="abrirGrupal" > <!-- style="display:none;" -->
                  <div class="card-header">
                    <h3 class="card-title">
                        <input name="quienEscribo" id="quienEscribo" type="hidden" value="<?php echo $quienEscribo=$_POST['solicitarChat']; ?>">
                        <input name="capturandoDatoRecibe" id="capturandoDatoRecibe" type="hidden" value="<?php echo $quienEscribo=$_POST['solicitarChat']; ?>">
                        <?php
                        // netamente informativo
                        $informacionUsuario=$mysqli->query("SELECT * FROM usuario WHERE cedula='".$_POST['solicitarChat']."' ");
                        $extraeInformacionUsuario=$informacionUsuario->fetch_array(MYSQLI_ASSOC);
                        echo $extraeInformacionUsuario['nombres'].' '.$extraeInformacionUsuario['apellidos'];
                        // end
                        ?>
                    </h3>
                    <div class="card-tools">
                      <!--
                      <span data-toggle="tooltip" title="3 New Messages" class="badge bg-primary">3</span>
                      -->
                      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                      </button>
                      
                      <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages">
                      
                      <!-- dentro del section mensajes está la estructura para que muestra el lado derecho e izquuierdo de la conversación -->
                              <section id="mensajes"></section>
                              <!-- <section id="hide"></section> -->
                      <!-- END -->
                    
                    </div>
                    <!--/.direct-chat-messages-->
    
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    
                      <div class="input-group">
                           <section id="enviar">
                                <input type="text" id="msg" name="msg"   onkeyup="check(event)" placeholder="Escribir mensaje..." class="form-control">
                                <!--
                                <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="archivo" name="archivo" accept=".jpg,.jpeg,.png" >
                                    <label class="custom-file-label" >Subir Archivo</label>
                                </div>-->
                                
                            </section>
                        
                        <span class="input-group-append">
                          <a href="#" class="btn btn-primary">Enviar</a>
                        </span>
                      </div>
                    
                  </div>
            </div>
            <?php
           // }
            ?>
           
             
            <script>
                    
                        function recargar(){
                                $.ajax({
                                    url: "conversacionMensajes.php",
                                    type: "post",
                                    success: function(response){
                                        $("#mensajes").html(response);
                                    }
                                });
                                $.ajax({
                                    url: "conversacionMensajesUsuarios.php",
                                    type: "post",
                                    success: function(response){
                                        $("#usuarios").html(response);
                                    }
                                });
                            }
                            
                           
                           function check(e){
                               if(e.which==13){
                                    datos()
                               }
                           }
                           
                            
                        function datos(){ 
                            
                                /// se crea las variables para los id que se atrapan en los input
                                var mensaje = $("#msg").val();
                                var mensajeArchivo = $("#archivo").val();
                                var mensajeArchivo = $("#archivo").val();
                                var mensajeQuienEscribo = $("#quienEscribo").val();
                                // end
                                
                                /// cargamos los parametros que son los id de los input y se envia al otro archivo que recibe los datos por post
                                var parametros = {
                                    "mensaje" : mensaje,
                                    "mensajeArchivo" : mensajeArchivo,
                                    "mensajeQuienEscribo" : mensajeQuienEscribo
                                };
                                //// END
                                $.ajax({
                                    /// enviamos todos los datos al otro archivo que nos almacena por el metodo POST
                                    type: "post",
                                    data: parametros,
                                    url: "conversacionEnviar.php", // conversacionMensajes  conversacionEnviar
                                    // END
                                    
                                    /// recargamos el formulario y colocamos en blanco los campos
                                    success: function(response){ 
                                        $("#hide").html(response);
                                        $("#msg").val(''),
                                        $("#archivo").val(''),
                                        recargar();
                                    } 
                                    /// END
                                });
                            }
                        
                            //// realizamos un intervalo de recarga
                            setInterval("recargar()",1000);
                            // END
                       
                      
            </script>
          </div>
          
          
           
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
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
<!-- para mostrar el archivo seleccionado en el file -->
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

