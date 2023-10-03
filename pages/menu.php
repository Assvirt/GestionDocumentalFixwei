<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
//require_once 'inactividad.php';
// verificación menú
?>

  <!-- Navbar --><!--https://www.cual-es-mi-ip.net/-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" charset="utf-8">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="home.php" class="nav-link">Inicio</a>
      </li>
    </ul>
    
    <!--  agregamos validacion de notificacion de mensajes  generales -->
      

        <link href="style.css" type="text/css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
        <script>
        setInterval(function(){
            pushNotify();
        }, 10000);
        
        function pushNotify() {
            if (!("Notification" in window)) {
                alert("El navegador web no admite notificaciones de escritorio");
            }
            if (Notification.permission !== "granted")
                Notification.requestPermission();
            else {
                $.ajax({
                url : "respuesta_push.php",
                type: "POST",
                success: function(data, textStatus, jqXHR) {
                if ($.trim(data)){
                var data = jQuery.parseJSON(data);
                console.log(data);
                notification = createNotification( data.title, data.icon, data.body, data.url);
                
                setTimeout(function() {
                notification.close();
                }, 5000);
                }
                },
                error: function(jqXHR, textStatus, errorThrown) {}
                });
            }
        };
        
        function createNotification(title, icon, body, url) {
            var notification = new Notification(title, {
                icon: icon,
                body: body,
            });
            notification.onclick = function() {
                //window.open(url);
            };
            return notification;
        }
        
        </script>
    <!--END-->
        
        
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <!--
      <li class="nav-item d-none d-sm-inline-block">
        <a href="controlador/sesion/logout" class="nav-link"><font color="red"><i class="fas fa-sign-out-alt nav-icon"></i></font> Cerrar sesión</a>
      </li>-->
      <li class="nav-item dropdown">
        <?php 
            if($_SESSION['session_root'] == 1){}else{
        ?> 
        <button class="nav-link" style="background:transparent;border:0px;" Onclick="window.location='mensajeria'" > <!-- chatValiando data-toggle="dropdown" -->
          <i class="far fa-comments"></i>
          <?php
            require 'conexion/bd.php';
            $sesion=$_SESSION["session_username"];
                      $consultaUsuarioChat=$mysqli->query("SELECT * FROM login WHERE cc='$sesion' ");
                      $extrarerUsuarioChat=$consultaUsuarioChat->fetch_array(MYSQLI_ASSOC);
                      $verificarUsuarioChat=$extrarerUsuarioChat['user_id'];
                      
                      
                      $consultaUsuarioChat2=$mysqli->query("SELECT * FROM chat_message WHERE to_user_id='$verificarUsuarioChat' ORDER BY chat_message_id DESC");
                      $extrarerUsuarioChat2=$consultaUsuarioChat2->fetch_array(MYSQLI_ASSOC);
                      $notificacionChat=$extrarerUsuarioChat2['status'];
                      
                      
                      
                      ?>
                        <span id="notificacionCon"></span>
                    <script>
                      function recargarChat(){
                          $.ajax({
                                    url: "notificacionChatJs.php",
                                    type: "post",
                                    success: function(response){
                                        $("#notificacionCon").html(response);
                                    }
                                });
                      }
                            
                            //// realizamos un intervalo de recarga
                            setInterval("recargarChat()",1000);
                            // END
                    </script>
                        
                          
                          
                   
          
        </button>
        
       
        
        
        <?php
            }
        ?>
      </li>
      <!-- Mensaje visible -->
      <style>
          div#general{
              margin:auto;
              margin-top:550px;
              width:1100px;
              height:800px;
              position:fixed;
          }
      </style>
      <?php
        if($conteoMensajes == 0){ }else{
      ?>
                <div id="general">
                  <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-danger">
                          <span class="info-box-icon"><i class="fas fa-comments"></i></span>
            
                          <div class="info-box-content">
                            
                            <span class="info-box-number"><font color="#dc3545">Mensaje nuevo</font></span>
                            <span class="progress-description">
                              <a href="chat" style="color:white;">Mensaje nuevo</a>
                            </span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </div>
                  </div>
                <?php
                    } 
                ?>
      <!-- fin del proceso -->
      <!-- Notifications Dropdown Menu -->
      <!--<li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>-->
      <!-- 
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
      -->
    </ul>
  </nav>
  <!-- /.navbar -->


 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="home" class="brand-link">
      <img src="../dist/img/FWLogoMorado.png"
           alt="Fixwei Logo"
           class="brand-image img-circle elevation-4"
           style="opacity: .8">
      <span class="brand-text font-weight-light elevation-4"><h3>Fixwei</h3></span>
    </a>

<!-- consulta para traer el usuario que inicia la sesion -->
	<?php 
		$sesion=$_SESSION["session_username"];
		
	//aqui se busca el rol	
		require 'conexion/bd.php';
		$acentos = $mysqli->query("SET NAMES 'utf8'");
		$sql= $mysqli->query("SELECT * FROM usuario WHERE cedula = '$sesion'");
		
		while($row = $sql->fetch_assoc()){
		    $idparaChat = $row['id'];
		    $nombres = $row['nombres'];
		    $apellidos = $row['apellidos'];
		    $foto = $row['foto'];
		    $correo = $row['correo'];
		    $cc = $row['cedula'];
		    $estadoAnuladoSistema = $row['estadoAnulado'];
		    $tel = $row['telefono'];
		    
		    //// dato para validar la clave en el token de seguridad para pagina administrativa
		    $validacionClave = $row['clave'];
		    /// fin de la variable
		    
		    /// datos para agregar en el perfil del usuario
		    $idProcesoUsuario = $row['proceso'];
		    $cargo = $row['cargo'];
		    $lider = $row['lider'];
		    //// fin de las variables
		}
		
		//// validamos que el usuario exista, si es eliminado nos cierre la sesión
                     
                                    $existenciaEliminados = $mysqli->query("SELECT * FROM usuarioEliminado WHERE cedula = '$sesion'");
                                    $idExistenciaEliminadosUsuarios = $existenciaEliminados->fetch_array(MYSQLI_ASSOC);
                                    $idEliminados= $idExistenciaEliminadosUsuarios['idUsuario'];
                                    $ccEliminadoExistencia=$idExistenciaEliminadosUsuarios['cedula'];
                   
                    $rootAdmin = $_SESSION['session_root'];
                    
                    
                    
                    if($rootAdmin == 1){
                    
                    }else{
                    
                      
                      if($cc == $sesion){
                        //  echo 'mantiene la sesión';
                      }else{
                         //echo 'Cierra la sesión';
                        
                            //echo '<script language="javascript">confirm("El usuario fue inhabilitado, la sesión fue finalizada");
                            //window.location.href="controlador/sesion/logout"</script>';    
                        ?>  <meta  http-equiv="refresh" content="2; URL='https://fixwei.com/plataforma/pages/controlador/sesion/logout">
                            <div style="position: fixed;margin: 30px 0 0 500px" id="cerrarA">
                                <div class="modal-dialog">
                                  <div class="modal-content bg-danger">
                                    <div class="modal-header">
                                      <h4 class="modal-title">Alerta</h4>
                                      <button type="button" id="closeA" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <p>El usuario fue inhabilitado, la sesión fue finalizada.</p>
                                    </div>
                                     <!-- formulario para eliminar por el id -->
                                    
                                    <div class="modal-footer justify-content-between">
                                     </div>
                                     
                                     <!-- END formulario para eliminar por el id -->
                                  </div>
                                </div>
                            </div>
                        <?php    
                      }
                      
                      if($estadoAnuladoSistema == TRUE ){ /// si el usuario está anulado debe  sacarme del sistema
                      
                            //echo '<script language="javascript">confirm("El usuario fue inhabilitado, la sesión fue finalizada");
                            //window.location.href="controlador/sesion/logout"</script>';    
                            ?>
                            <meta  http-equiv="refresh" content="2; URL='https://fixwei.com/plataforma/pages/controlador/sesion/logout">
                            <div style="position: fixed;margin: 30px 0 0 500px" id="cerrarA">
                                <div class="modal-dialog">
                                  <div class="modal-content bg-danger">
                                    <div class="modal-header">
                                      <h4 class="modal-title">Alerta</h4>
                                      <button type="button" id="closeA" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <p>El usuario fue inhabilitado, la sesión fue finalizada.</p>
                                    </div>
                                     <!-- formulario para eliminar por el id -->
                                    
                                    <div class="modal-footer justify-content-between">
                                     </div>
                                     
                                     <!-- END formulario para eliminar por el id -->
                                  </div>
                                </div>
                            </div>
                        <?php   
                      }
                      
                      if($sesion == $ccEliminadoExistencia){  /*'los id existen';
                            //echo '<script language="javascript">confirm("El usuario fue inhabilitado anteriormente, debe eliminar el registro por completo y crearlo nuevamente");
                           // window.location.href="controlador/sesion/logout"</script>';
                        ?>
                            <meta  http-equiv="refresh" content="2; URL='https://fixwei.com/plataforma/pages/controlador/sesion/logout">
                            <div style="position: fixed;margin: 30px 0 0 500px" id="cerrarA">
                                <div class="modal-dialog">
                                  <div class="modal-content bg-danger">
                                    <div class="modal-header">
                                      <h4 class="modal-title">Alerta</h4>
                                      <button type="button" id="closeA" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <p>El usuario fue inhabilitado anteriormente, debe eliminar el registro por completo y crearlo nuevamente.</p>
                                    </div>
                                     <!-- formulario para eliminar por el id -->
                                    
                                    <div class="modal-footer justify-content-between">
                                     </div>
                                     
                                     <!-- END formulario para eliminar por el id -->
                                  </div>
                                </div>
                            </div>
                        <?php 
                          
                      */}
                    }
                    
                      
        //// END
		
		                            $sacarNombreCargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$cargo'");
                                    $datosDelCargoSacar = $sacarNombreCargo->fetch_array(MYSQLI_ASSOC);
                                    $mandarCargoAPresupuesto= $datosDelCargoSacar['nombreCargos']; echo "<br>";
		
	    
			  
	?> 

<!-- End consulta para traer el usuario que inicia la sesion -->




    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <?php   /// en caso que inicie el super Admin
               $root=$_SESSION["session_root"];
               if($root == 1){
                    $queryRoot=$mysqli->query("SELECT * FROM cliente");
                    $rowRootImg=$queryRoot->fetch_array(MYSQLI_ASSOC);
                    $imagen=$rowRootImg['img'];
                    
                    if($imagen != NULL){
        ?>
                  <img src="data:image/jpg;base64, <?php echo base64_encode($imagen); ?>" class="img-circle elevation-2" alt="User Image">
        <?php
                    }else{
        ?>
                      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSAFdnwsj9XmZPJzlH-h95QvIm7QjUsIlHkpQ&usqp=CAU" class="img-circle elevation-2" alt="User Image">
        <?php
                      }

               }else{
            
                  if($foto != NULL){
        ?>
                  <img src="data:image/jpg;base64, <?php echo base64_encode($foto); ?>" class="img-circle elevation-2" alt="User Image">
                  <?php 
                  }else{
                  ?>
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSAFdnwsj9XmZPJzlH-h95QvIm7QjUsIlHkpQ&usqp=CAU" class="img-circle elevation-2" alt="User Image">
        <?php
                  } 
              } 
        ?>
          
        </div>
        <div class="info">
            <?php
           // echo "Root".$root;
           if($root == 1){ 
            ?>
          <a href="myperfil" class="d-block ">Administrador del Sistema</a>
          <?php
          }else{
          ?>
          <a href="myperfil" class="d-block "><?php echo $nombres." ".$apellidos; ?></a>
          <?php
          }
          ?>
          <style>
            ul {
                padding:0px;
            }
            ul, li {
                list-style:none;
            }
            .menu li ul {
                display:none;
            }
            
            .menu li:hover ul {
                display:block;
            }
            .menu li {
                position:relative;
            }
            .menu li a:hover {
                color:red;
            }
          </style>
         
        </div>
        
      </div>

<?php

                $seguridadPreguntar=$mysqli->query("SELECT * FROM seguridadDelete WHERE estado ='bloqueado'  ");
                $resultadoSeguridadPreguntar=$seguridadPreguntar->fetch_array(MYSQLI_ASSOC);
                
                if($resultadoSeguridadPreguntar['id'] && $root == 1){
                ?>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="home" class="nav-link">
                              <i class="nav-icon fas fa-tachometer-alt"></i>
                              <p>
                                Menú bloqueado
                              </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <?php        
                }else{
?>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="home" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          
        <?php
            include_once'menuGrupos.php';
        ?>    
          
          <!-- Menu de configuraciones -->
          <?php
          ///// si no tenemos privilegios en ninguno, la configuracion se oculta
          if($menuPermisoListarUsuarios == FALSE && $menuPermisoListarGruposD == FALSE && $menuPermisoListarCentroCosto == FALSE && $menuPermisoListarCargo == FALSE && $menuPermisoListarCentroTrabajo == FALSE && $menuPermisoListarProcesos == FALSE && $menuPermisoListarMacroprocesos == FALSE && $menuPermisoListarDefiniciones == FALSE && $menuPermisoListarCodificacion == FALSE && $menuPermisoListarNormativa == FALSE && $menuPermisoListarTipoDocumento == FALSE){
              
          }else{
          ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Configuraci&oacute;n
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <!--  <li class="nav-item">
                <a href="myperfil" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mi perfil</p>
                </a>
              </li> -->
              <?php
              if($root == 1){
              ?>
              <li class="nav-item">
                <a href="cliente" class="nav-link"> <!-- cliente -->
                  <i class="far fa-circle nav-icon"></i>
                  <p>Parametrizaci&oacute;n Cliente</p>
                </a>
              </li>
              <?php
                }
              ?>
              <!--
              <li class="nav-item">
                <a href="comunicaciones" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Comunicaciones</p>
                </a>
              </li>
              -->
              <?php
              if($menuPermisoListarCargo == FALSE){}else{
              ?>
              <li class="nav-item">
                <a href="cargos" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cargos</p>
                </a>
              </li>
              <?php
              }
              
              if($menuPermisoListarProcesos == FALSE){}else{
              ?>
              <li class="nav-item">
                <a href="procesos" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Procesos</p>
                </a>
              </li>
              <?php
              }
              
              if($menuPermisoListarCentroTrabajo == FALSE){}else{
              ?>
              <li class="nav-item">
                <a href="centrodetrabajo" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Centro de trabajo</p>
                </a>
              </li>
              <?php
              }
              
              if($menuPermisoListarGruposD == FALSE){}else{
              ?>
              <li class="nav-item">
                <a href="grupos" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Grupos de distribución</p>
                </a>
              </li>
              <?php
              }
              
              if($menuPermisoListarUsuarios == FALSE){}else{
              ?>
              <li class="nav-item">
                <a href="usuarios" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Usuarios</p>
                </a>
              </li>
              <?php
              }
              
              if($menuPermisoListarCentroCosto == FALSE){}else{
              ?>
              <li class="nav-item">
                <a href="centroCostos" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Centro de costos</p>
                </a>
              </li>
              <?php
              }
              
              if($menuPermisoListarMacroprocesos == FALSE){}else{ /*
              ?>
              <li class="nav-item">
                <a href="macroproceso" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Macroprocesos</p>
                </a>
              </li>
              <?php
              */}
              
              if($menuPermisoListarTipoDocumento == FALSE){}else{
              ?>
              <li class="nav-item">
                <a href="tipoDocumento" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tipo de documento</p>
                </a>
              </li>
              <?php
              }
              
              if($menuPermisoListarCodificacion == FALSE){}else{
              ?>
              <li class="nav-item">
                <a href="agregarCodificacion" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Codificación</p>
                </a>
              </li>
              <?php
              }
              
             if($menuPermisoListarDefiniciones == FALSE){}else{ 
              ?>
              <li class="nav-item">
                <a href="definicion" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Definici&oacute;n</p>
                </a>
              </li>
              <?php
              }
              ?>
              
              <?php
              
              if($menuPermisoListarNormativa == FALSE){}else{
              ?>
              <li class="nav-item">
                <a href="normatividad" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Normatividad</p>
                </a>
              </li>
              <?php
              }
              ?>
              
            </ul>
          </li>
          <?php
          }
          /// END
          ?>
          <!-- End menu de configuraciones-->

          <!-- Menu de Gestion Documental -->
          <?php
          if($menuPermisoListarListadoMaestro == FALSE && $menuPermisoListarSolicitudDocumentos == FALSE && $menuPermisoListarCreacionDocumental == FALSE && $menuPermisoListarDocumentoExterno == FALSE && $menuPermisoListarDocumentoObsoleto == FALSE && $menuPermisoListarRevisionDocumental == FALSE ){}else{
          ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-file"></i>
              <p>
                Gesti&oacute;n Documental
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <?php
                if($menuPermisoListarSolicitudDocumentos == FALSE){}else{
                ?>
              <li class="nav-item">
                <a href="solicitudDocumentos" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Solicitud documental</p>
                </a>
              </li>
              <?php
                }
                if($menuPermisoListarCreacionDocumental == FALSE){}else{
              ?>
              <li class="nav-item">
                <a href="creacionDocumental" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Creación documental</p>
                </a>
              </li>
              <?php
                }
              if($menuPermisoListarListadoMaestro == FALSE){}else{
              ?>
              <li class="nav-item">
                <a href="listadoMaestro" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listado maestro</p>
                </a>
              </li>
              <?php
              }
              if($menuPermisoListarRevisionDocumental == FALSE){}else{
              ?>
              <li class="nav-item">
                <a href="revisionDocumental" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Revisión documental</p>
                </a>
              </li>
              <?php
              }
              if($menuPermisoListarDocumentoExterno == FALSE){}else{
              ?>
              <li class="nav-item">
                <a href="documentoExterno" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Documentos externos</p>
                </a>
              </li>
              <?php
              }
              if($menuPermisoListarDocumentoObsoleto == FALSE){}else{
              ?>
              <li class="nav-item">
                <a href="documentosObsoletos" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Documentos obsoletos</p>
                </a>
              </li>
              <?php
              }
              ?>
            </ul>
          </li>
          <?php
            }
          ?>
          <!-- End menu de Gestion Documental--> 
          <?php
          if($menuPermisoListarRepositorio == FALSE){}else{
          ?>
            <li class="nav-item">
                <a href="repositorio" class="nav-link">
                  <i class="far fa-hdd nav-icon"></i>
                  <p>Repositorio</p>
                </a>
            </li>
          <?php
          }
          ?>
          <!-- Menu de indicadores -->
          
            <?php
             if($menuPermisoListarIndicadores == FALSE){}else{
            ?>
              <li class="nav-item">
                <a href="indicadores" class="nav-link">
                  <i class="nav-icon fas fa-chart-pie"></i>
                  <p>Indicadores</p>
                </a>
              </li>
            <?php
            }
            ?>
          <!-- End menu de indicadores-->
          <!-- Menu de Actas -->

            <?php
            if($menuPermisoListarActas == FALSE){}else{
            ?>
              <li class="nav-item">
                <a href="actas" class="nav-link">
                  <i class="fas fa-file-signature nav-icon"></i>
                  <p>Actas</p>
                </a>
              </li>
            <?php
            }
            ?>
         
          <!-- End menu de actas-->
           <!-- Menu de Compras -->
           <?php
           if($menuPermisoListarPoliticas == FALSE && $menuPermisoListarProveedores == FALSE && $menuPermisoListarSolicitudCompras == FALSE && $menuPermisoListarOrdenCompra == FALSE && $menuPermisoListarPresupuesto == FALSE && $menuPermisoListarVerificacionOC == FALSE && $menuPermisoListarVerificacionEntradasSalidas == FALSE){}else{
           ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-shopping-cart"></i>
              <p>
                Compras
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
               <!--
                <li class="nav-item">
                <a href="politicas" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Politicas</p>
                </a>
                </li>
              -->
                <?php
                 if($menuPermisoListarPoliticas == FALSE){}else{
                ?>
              
              <li class="nav-item">
                <a href="proveedoresInscripcion" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inscripción <br>y aprobación de proveedor</p>
                </a>
              </li>
              <?php
                 }
                  if($menuPermisoListarProveedores == FALSE){}else{
              ?>
              
              <li class="nav-item">
                <a href="proveedores" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Proveedores</p>
                </a>
              </li>
              <?php
                  }
                  if($menuPermisoListarSolicitudCompras == FALSE){}else{
             
                    ////////// validamos por grupo de distribución
                    /// validamos la existencia del grupo con el listar habilitado
                    $permiso=$mysqli->query("SELECT grupo.*, permisos.*, grupo.id AS idExisteGrupo FROM grupo INNER JOIN permisos WHERE permisos.formulario='solicitudComprador' AND permisos.listar='1' AND grupo.id = permisos.idGrupo");
                    $extraerPermiso=$permiso->fetch_array(MYSQLI_ASSOC);
                    $permisoExistente=$extraerPermiso['idExisteGrupo'];
                                        
                    /// validamos el permiso del grupo de distribución
                    $consultandoPermiso=$mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario='$cc' AND idGrupo='$permisoExistente' ");
                    $extraerPermiso=$consultandoPermiso->fetch_array(MYSQLI_ASSOC);
                    $extraerPermisoHabilitador=$extraerPermiso['id'];
                                        
                    //if($extraerPermisoHabilitador != NULL){
                    /*
                    ?>
                        <li class="nav-item">
                            <a href="solicitudComprador" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Solicitud de compra</p>
                            </a>
                        </li>
                      <?php
                      */
                    //}else{
                    ?>
                        <li class="nav-item">
                            <a href="solicitudCompra" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Solicitud de compra</p>
                            </a>
                        </li>
                    <?php
                    //}
                  }
              if($menuPermisoListarOrdenCompra == FALSE){}else{
              ?>
              <li class="nav-item">
                <a target="" href="solicitudComprador" class="nav-link"> <!-- ordenCompra -->
                  <i class="far fa-circle nav-icon"></i>
                  <p>Orden de compra</p>
                </a>
              </li>
              <?php
                  }
                  
                if($menuPermisoListarVerificacionOC == FALSE){}else{
            ?>
            <li class="nav-item">
                <a target="" href="verificarSolicitud" class="nav-link"> 
                  <i class="far fa-circle nav-icon"></i>
                  <p>Verificar orden de compra</p>
                </a>
              </li>
            <?php
                }
                  if($menuPermisoListarPresupuesto == FALSE){}else{
              ?>
              <li class="nav-item">
                <a href="presupuesto" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Presupuesto</p>
                </a>
              </li>
              <?php
                  }
            
             if($menuPermisoListarVerificacionEntradasSalidas == FALSE){}else{
              ?>
              
              
               <li class="nav-item">
                <a href="ordenCompraEntradas" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Entradas y salidas</p>
                </a>
              </li>
              <?php
             }
              ?>
            </ul>
          </li>
           <?php
           }
           ?>
          <!-- End menu de Compras--> 
          
          <!-- Menu de tutoriales -->
           
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book-reader"></i>
              <p>
                Tutoriales
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="tutorial" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Videos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="manual" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manual</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i> 
              <p>
                Capacitación
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="evaluacion" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Evaluación</p>
                </a>
              </li>
            </ul>
          </li>
         
         
          <!--<li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book-reader"></i>
              <p>
                Evaluación
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
               
              </li>
              <li class="nav-item">
                <a href="" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>----</p>
                </a>
              </li>
            </ul>
          </li>-->
          <!-- End menu de Compras--> 
          
          <!-- Token para ingresar al admin de la página 
          <li class="nav-item has-treeview">
            <a href="http://assvirt.com/plataforma/pages/examples/login" target="_blank" class="nav-link">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>
                Admin p&aacute;gina
              </p>
            </a>
          </li>
           End Token para ingresar al admin de la página-->
        
            <li class="nav-item">
                <a href="controlador/sesion/logout" class="nav-link">
                <font color="red"><i class="fas fa-sign-out-alt nav-icon"></i></font>
                <p class="text"> Cerrar sesión</p>
                </a>
            </li>
            <li class="nav-item">
                            <!-- enlace para usar el chat -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                <!-- END -->
                <section id="Listausuarios"></section>
                        <script>
                                   function recargar(){
                                                $.ajax({
                                                    url: "menuSeguridadUsuario.php",
                                                    type: "post",
                                                    success: function(response){
                                                        $("#Listausuarios").html(response);
                                                    }
                                                });
                                   }
                                            //// realizamos un intervalo de recarga
                                            setInterval("recargar()",1000);
                                            // END
                        </script>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
      
<?php
}
?>      
      
      
    </div>
    <!-- /.sidebar -->
  </aside>
  <!--  CHAT -->





<!-- End CHAT -->
  <?php
}

?>