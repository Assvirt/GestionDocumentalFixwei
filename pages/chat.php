<?php
session_start();
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
?>
<!DOCTYPE html>
<html>
    <title>Chat</title>
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
  
  <!-- se agregan los estilos para la agenda -->
    <!-- fullCalendar -->
  <link rel="stylesheet" href="../plugins/fullcalendar/main.min.css">
  <link rel="stylesheet" href="../plugins/fullcalendar-interaction/main.min.css">
  <link rel="stylesheet" href="../plugins/fullcalendar-daygrid/main.min.css">
  <link rel="stylesheet" href="../plugins/fullcalendar-timegrid/main.min.css">
  <link rel="stylesheet" href="../plugins/fullcalendar-bootstrap/main.min.css">
  <!-- Fin se agregan los estilos para la agenda -->
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
            <h1>Chat</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Mi Chat</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
         
         
          <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link" > </a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <!-- chat -->
                  <div class="active tab-pane" id="chat">
                    <!-- The timeline -->
                  
                  
                  <button style="width:100px;" Onclick="window.location='myperfil'" class="btn btn-block btn-info btn-sm"><b>Perfil</b></button><br>
                  <button style="width:100px;" Onclick="window.location='chat2'" class="btn btn-block btn-info btn-sm"><b>Mejora</b></button><br>
                  <div class="row"> 
                    <div class="col-6">
                        <!-- DIRECT CHAT PRIMARY -->
                        <div class="card card-prirary cardutline direct-chat direct-chat-primary">
                          <div class="card-header">
                            <h3 class="card-title">Conectados <li style="color:green;" class="fas fa-circle"></li></h3>
            
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                              </button>
                              <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts"
                                      data-widget="chat-pane-toggle">
                                <i class="fas fa-comments"></i></button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                              </button>
                            </div>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body" >
                            <!-- Conversations are loaded here -->
                            <div class="direct-chat-messages">
                              <!-- Message. Default to the left -->
                              <div class="direct-chat-msg">
                               <?php
                               //////////// los usuarios conectados
                                $sql= $mysqli->query("SELECT usuario.*,usuario.cedula, ConectadoUsuario.idUsuario, ConectadoUsuario.estadoUsuario FROM usuario INNER JOIN ConectadoUsuario WHERE usuario.cedula=ConectadoUsuario.idUsuario  ");
            		            while($row = $sql->fetch_assoc()){
            		                
            		                ////// validacion conectados por usuario
            		                $conectados=$row['estadoUsuario'];
            		                if($conectados == 'Conectado' || $conectados == 'Ausente' || $conectados || 'Reunion' || $conectados == 'Ocupado' || $conectados == 'desconectado'){
                        		    $usuarioConectado = $row['nombres'];
                        		    $idConectado = $row['id'];
                        		    $fotoConectado = $row['foto'];
                        		    $cedulaConectado = $row['cedula'];
                               ?>
                               <form action="" method="POST">
                                   <table>
                                    <tr>
                                           
                                        <td>
                                            <button type="submit" style="background:white;border:0px;">
                                                <?php if($fotoConectado != NULL){ ?><img style="border: 2px solid grey;margin: 0;padding: 0;border-radius: 800px;overflow: hidden;" src="data:image/jpg;base64, <?php echo base64_encode($fotoConectado); ?>" width="50" height="50" />
                                                <?php }else{?> <img style="border: 2px solid grey;margin: 0;padding: 0;border-radius: 800px;overflow: hidden;" src="https://viplifezorrilla.com/sisMercadeo/public/img/usuario.jpg" width="50" height="50" /> <?php } ?>
                                            </button>
                                            <style>
                                                  div#general2{
                                                      margin:auto;
                                                      /*margin-top:550px;*/
                                                      margin: -18px 0 0 45px;
                                                      width:100px;
                                                      height:800px;
                                                      position:absolute;
                                                  }
                                            </style>
                                            <div id="general2">   
                                            <?php
                                                /////// se valida según el estado de los usuarios para saber su estado de conexion
                                                    $nombreuser = $mysqli->query("SELECT * FROM ConectadoUsuario WHERE idUsuario = '$cedulaConectado'");
                                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                    $estadoPerfil=$columna['estadoUsuario'];
                                                    
                                                    if($estadoPerfil == 'Conectado'){
                                                        $resultadoColor='green';
                                                        $tituloColor='Conectado';
                                                    }elseif($estadoPerfil == 'Reunion'){
                                                        $resultadoColor='gray';
                                                        $tituloColor='En reuni&oacute;n';
                                                    }elseif($estadoPerfil == 'Ausente'){
                                                        $resultadoColor='orange';
                                                        $tituloColor='Ausente';
                                                    }elseif($estadoPerfil == 'Ocupado'){
                                                        $resultadoColor='red';
                                                        $tituloColor='Ocupado';
                                                    }elseif($estadoPerfil == 'desconectado'){
                                                        $resultadoColor='black';
                                                        $tituloColor='Desconectado';
                                                    }
                                                ///////// fin del proceso
                                            ?>
                                                <li style="color:<?php echo $resultadoColor;?>;" title="<?php echo $tituloColor; ?>" class="fas fa-circle"></li>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="direct-chat-text" style="width:100px;">
                                              <?php 
                                                echo $usuarioConectado; 
                                                echo '<input name="idIniciarChat" value='.$idConectado.' readonly type="hidden"></form>';
                                              ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                                
                                                $queryJefeInmediato=$mysqli->query("SELECT * FROM chat WHERE estado='Nuevo' AND de='$idConectado' AND para='$idparaChat' ");
                                                $rowDatos=$queryJefeInmediato->fetch_array(MYSQLI_ASSOC);
                                                $estadoMensaje=$rowDatos['estado'];
                                                if($estadoMensaje == 'Nuevo'){
                                            ?>
                                            <div class="direct-chat-text">
                                                <form action="controlador/comunicacionInterna/controllerComunicacionInterna" method="POST">
                                                <button type="submit" name="chatEstado" class="btn btn-block btn-danger"><?php echo $estadoMensaje; ?></button>
                                                <input name="idIniciarChat" value="<?php echo $idConectado; ?>" readonly type="hidden"></form>
                                            </div>
                                            <?php
                                                }else{ }
                                            ?>
                                        </td>
                                    </tr>
                                   </table>
                                <?php
            		                }else{ ////// cierre visualizacion usuarios conectados
            		                
            		                
            		                }
            		                
            		            }
                                ?>
                                <!-- /.direct-chat-text -->
                              </div>
                              <!-- /.direct-chat-msg -->
            
                              <!-- Message to the right -->
                              
                              <!-- /.direct-chat-msg -->
                            </div>
                            <!--/.direct-chat-messages-->
            
                          
                          </div>
                         
                        </div>
                        <!--/.direct-chat -->
                      </div>
                      
                      
                            <?php
                            ////////// datos del receptor
                                $idIniciarChat=$_POST['idIniciarChat'];
                                $queryJefeInmediato=$mysqli->query("SELECT * FROM usuario WHERE id='$idIniciarChat' ");
            	                 $rowDatos=$queryJefeInmediato->fetch_array(MYSQLI_ASSOC);
            	                 $nombreReceptor=$rowDatos['nombres'];
                    		     $fotoReceptor=$rowDatos['foto'];
                    		////////// datos del receptor
                    		
                            if($idIniciarChat != NULL){
                            ?>
                                <div class="col-4">
                           <div class="card card-prirary cardutline direct-chat direct-chat-primary">
                              <div class="card-header">
                                <h3 class="card-title"><?php echo $nombreReceptor; ?> <li style="color:green;" class="fas fa-circle"></li></h3>
                
                                <div class="card-tools">
                                  
                                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                  </button>
                                  
                                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                                  </button>
                                </div>
                              </div>
                      <!-- /.card-header -->
                              <div class="card-body">
                                <!-- Conversations are loaded here -->
                                
                                <div class="direct-chat-messages" >
                                  
                                   <?php 
                                            
                                    		//////// se valida para la conversacion por cada usuario
                                               $acentos = $mysqli->query("SET NAMES 'utf8'");
                                                $sql= $mysqli->query("SELECT * FROM chat WHERE de='$idparaChat' AND para='$idIniciarChat' OR de='$idIniciarChat' AND para='$idparaChat' order by id ");
                            		                    while($row = $sql->fetch_assoc()){
                            		                        $emisor=$row['de'];
                            		                        $receptor=$row['para'];
                            		                        
                            		                                 $queryJefeInmediato=$mysqli->query("SELECT * FROM usuario WHERE id='$emisor' ");
                                                	                 $rowDatos=$queryJefeInmediato->fetch_array(MYSQLI_ASSOC);
                                                	                 $nombreChat=$rowDatos['nombres'];
                                                        		     $fotoChat=$rowDatos['foto'];
                                                        		     
                                                 
                                                                ?>
                                                                        <div class="direct-chat-msg right">
                                                                            <div class="direct-chat-infos clearfix">
                                                                              <span class="direct-chat-name float-right"><?php echo utf8_decode($nombreChat); ?></span>
                                                                              <span class="direct-chat-timestamp float-left"><?php echo $fechaChat=$row['fecha'];?></span>
                                                                            </div>
                                                                            <!-- /.direct-chat-infos -->
                                                                            <?php if($fotoChat != NULL){ ?>
                                                                            <img class="direct-chat-img" src="data:image/jpg;base64, <?php  echo base64_encode($fotoChat); ?>" alt="Message User Image">
                                                                            <?php  }else{ ?>
                                                                            <img class="direct-chat-img" src="https://viplifezorrilla.com/sisMercadeo/public/img/usuario.jpg" alt="Message User Image">
                                                                            <?php } ?>
                                                                            <!-- /.direct-chat-img -->
                                                                            <div style="background:#007bff;color:white;" class="direct-chat-text">
                                                                              <?php  echo utf8_decode($mensaje=$row['mensaje']); ?>
                                                                            </div>
                                                                            <!-- /.direct-chat-text -->
                                                                        </div>
                                                    
                                                                       
                                                            <?php
                                                                } /// cierra el while
                                                            ?>
                                  
                                </div>
                                
                                
                              </div>
                      
                              <div class="card-footer">
                                    <form action="controlador/comunicacionInterna/controllerComunicacionInterna" method="post">
                                      <div class="input-group">
                                        <input type="text" name="mensaje" placeholder="Mensaje ..." class="form-control">
                                        <span class="input-group-append">
                                          <button type="submit" name="chat" class="btn btn-primary">Enviar</button>
                                        </span>
                                      </div>
                                      <input type="hidden" name="de" value="<?php echo $idparaChat; ?>">
                                      <input type="hidden" name="para" value="<?php echo $idIniciarChat; ?>">
                                     
                                    </form>
                                  </div>
                      
                            </div>
                           
                       </div>
                       
                            <?php
                                    }else{ }
                            ?>
                       
                  </div> 
                   
                   
                   
                  
                   
                   
                  <!-- fin chat -->
                  </div>
                  <div class="tab-pane" id="settings">
                 
                    
                     
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.0
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>

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
<!-- jQuery UI -->
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>

<!-- se trae los script para que funcione el calendario -->
<!-- fullCalendar 2.2.5 -->
<script src="../plugins/moment/moment.min.js"></script>
<script src="../plugins/fullcalendar/main.min.js"></script>
<script src="../plugins/fullcalendar-daygrid/main.min.js"></script>
<script src="../plugins/fullcalendar-timegrid/main.min.js"></script>
<script src="../plugins/fullcalendar-interaction/main.min.js"></script>
<script src="../plugins/fullcalendar-bootstrap/main.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    ini_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()

    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendarInteraction.Draggable;

    var containerEl = document.getElementById('external-events');
    var checkbox = document.getElementById('drop-remove');
    var calendarEl = document.getElementById('calendar');

    // initialize the external events
    // -----------------------------------------------------------------

    new Draggable(containerEl, {
      itemSelector: '.external-event',
      eventData: function(eventEl) {
        console.log(eventEl);
        return {
          title: eventEl.innerText,
          backgroundColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          borderColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          textColor: window.getComputedStyle( eventEl ,null).getPropertyValue('color'),
        };
      }
    });

    var calendar = new Calendar(calendarEl, {
      plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid' ],
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      //Random default events
      events    : [
        {
          title          : 'All Day Event',
          start          : new Date(y, m, 1),
          backgroundColor: '#f56954', //red
          borderColor    : '#f56954' //red
        },
        {
          title          : 'Long Event',
          start          : new Date(y, m, d - 5),
          end            : new Date(y, m, d - 2),
          backgroundColor: '#f39c12', //yellow
          borderColor    : '#f39c12' //yellow
        },
        {
          title          : 'Meeting',
          start          : new Date(y, m, d, 10, 30),
          allDay         : false,
          backgroundColor: '#0073b7', //Blue
          borderColor    : '#0073b7' //Blue
        },
        {
          title          : 'Lunch',
          start          : new Date(y, m, d, 12, 0),
          end            : new Date(y, m, d, 14, 0),
          allDay         : false,
          backgroundColor: '#00c0ef', //Info (aqua)
          borderColor    : '#00c0ef' //Info (aqua)
        },
        {
          title          : 'Birthday Party',
          start          : new Date(y, m, d + 1, 19, 0),
          end            : new Date(y, m, d + 1, 22, 30),
          allDay         : false,
          backgroundColor: '#00a65a', //Success (green)
          borderColor    : '#00a65a' //Success (green)
        },
        {
          title          : 'Click for Google',
          start          : new Date(y, m, 28),
          end            : new Date(y, m, 29),
          url            : 'http://google.com/',
          backgroundColor: '#3c8dbc', //Primary (light-blue)
          borderColor    : '#3c8dbc' //Primary (light-blue)
        }
      ],
      editable  : true,
      droppable : true, // this allows things to be dropped onto the calendar !!!
      drop      : function(info) {
        // is the "remove after drop" checkbox checked?
        if (checkbox.checked) {
          // if so, remove the element from the "Draggable Events" list
          info.draggedEl.parentNode.removeChild(info.draggedEl);
        }
      }    
    });

    calendar.render();
    // $('#calendar').fullCalendar()

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#add-new-event').css({
        'background-color': currColor,
        'border-color'    : currColor
      })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      //Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.html(val)
      $('#external-events').prepend(event)

      //Add draggable funtionality
      ini_events(event)

      //Remove event from text input
      $('#new-event').val('')
    })
  })
</script>

</body>
</html>
<?php
}
?>