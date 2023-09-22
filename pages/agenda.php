<?php
//Agenda
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';
?>
<!DOCTYPE html>
<html>
    <title>Perfil</title>
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
   <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
            <h1>Perfil</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Mi Perfil</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            
            
            
            
            
            
            <!-- PENDIENTES -->
            <?php require_once'notificacionesVista.php'; ?>
            <!-- FIN PENDIENTES -->
            
            
            
            <!-- gestion de actas -->
            
            <!-- fin de gestion de actas-->
            
            
            <!-- /.card -->

            <!-- About Me Box 
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                  B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">Malibu, California</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span>
                </p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
              </div>
             
            </div>
            /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="myperfil" >Cerrar agenda</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                
                 
                  <!-- se agrega agendas -->
                  <div class="active tab-pane" id="agenda">
                    
                    <section class="content-header">
                      <div class="container-fluid">
                        <div class="row mb-2">
                          <div class="col-sm-6">
                            <h1>Agenda</h1>
                          </div>
                        </div>
                      </div><!-- /.container-fluid -->
                    </section>
                    <section class="content">
                      <div class="container-fluid">
                        <div class="row">
                         
                        <?php
                            $entraSolicitud=$_POST['solicitud'];
                            if($entraSolicitud === 'Crear reunion'){
                        ?> 
                          <div class="col-9">
                                <h1 style="color:black;">Crear reunión</h1>
                         
                          <div class="form-group">
                        <form action="controlador/comunicacionInterna/controllerComunicacionInterna" method="POST">
                              <label>Fecha de Reuni&oacute;n:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="far fa-clock"></i></span>
                                        </div>
                                        <input type="date" name="fecha" class="form-control float-right" id="reservationtime">
                                </div>
                          </div>
                          <br>
                          <div class="form-group">
                              <label>Hora:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="far fa-clock"></i></span>
                                        </div>
                                        <input type="time" name="hora" class="form-control float-right" id="reservationtime">
                                </div>
                          </div>
                          <div class="form-group col-sm-6">
                            <label>Personal: </label><br>
                            <input type="radio" id="rad_cargoE" name="radiobtn" value="cargo">
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioE" name="radiobtn" value="usuario">
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoE[]" id="select_encargadoE" required></select>
                            </div>
                        </div>
                         <div class="form-group">
                          <label>Tem&aacute;tica:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                    </div>
                                    <input type="text" name="tematica" class="form-control float-right" id="reservationtime">
                                    <input type="hidden" name="idUsuario" value="<?php echo $sesion;?>">
                                    <input type="hidden" name="asunto" value="<?php echo $entraSolicitud; ?>" >
                                </div>
                          </div>
                          <div class="form-group">
                          <label>Descripci&oacute;n de tarea:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                    </div>
                                    <input type="text" name="descripcion" class="form-control float-right" id="reservationtime">
                                </div>
                          </div>
                          <div class="form-group">
                          <label>Sitio:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                                    </div>
                                    <input type="text" name="sitio" class="form-control float-right" id="reservationtime">
                                </div>
                          </div>
                          <?php
                            $query = $mysqli->query("SELECT * FROM agendaEtiqueta WHERE nombre='$entraSolicitud' AND idUsuario='$sesion' ");
                            $row = $query->fetch_array(MYSQLI_ASSOC);
                            $colorEtiqueta= $row['etiqueta'];
                            $idEtiqueta= $row['id'];
                          
                          if($colorEtiqueta != NULL){
                          ?>
                          <!--
                          <div class="form-group">
                          <label>Color de etiqueta:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                    </div>
                                    
                                </div>
                          </div>-->
                          <div class="input-group-append">
                                  <button id="add-new-event" type="submit" name="agenda" class="btn btn-primary">Guardar</button>
                                <input style="visibility:hidden;" type="color" value="<?php echo $colorEtiqueta;?>" disabled class="form-control float-right" id="reservationtime">
                                <input type="hidden" name="color" value="<?php echo $idEtiqueta;?>" >
                          </div>
                          <?php
                          }else{
                              echo '<font color="red"><b>Debe personalizar la etiqueta antes de agendar la actividad</b></font>';
                          }
                          ?>
                         </form> 
                          
                          
                          </div>
                          <?php
                          }elseif($entraSolicitud === 'Crear tarea'){
                        ?> 
                          <div class="col-9">
                                <h1 style="color:black;"><?php
                                 echo $entraSolicitud;
                                ?></h1>
                         
                          <div class="form-group">
                        <form action="controlador/comunicacionInterna/controllerComunicacionInterna" method="POST">
                          <label>Fecha de Entrega:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                    <input type="date" name="fecha" class="form-control float-right" id="reservationtime">
                                </div>
                          </div>
                          <br>
                          <div class="form-group">
                          <label>Hora:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                    <input type="time" name="hora" class="form-control float-right" id="reservationtime">
                                </div>
                          </div>
                          <div class="form-group col-sm-6">
                            <label>Personal: </label><br>
                            <input type="radio" id="rad_cargoE" name="radiobtn" value="cargo">
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioE" name="radiobtn" value="usuario">
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width: 100%;" name="select_encargadoE[]" id="select_encargadoE" required></select>
                            </div>
                        </div>
                         <div class="form-group">
                          <label>Tem&aacute;tica:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                    </div>
                                    <input type="text" name="tematica" class="form-control float-right" id="reservationtime">
                                    <input type="hidden" name="idUsuario" value="<?php echo $sesion;?>">
                                    <input type="hidden" name="asunto" value="<?php echo $entraSolicitud; ?>" >
                                </div>
                          </div>
                          <div class="form-group">
                          <label>Descripci&oacute;n de tarea:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                    </div>
                                    <input type="text" name="descripcion" class="form-control float-right" id="reservationtime">
                                </div>
                          </div>
                          <div class="form-group">
                          <label>Sitio:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                                    </div>
                                    <input type="text" name="sitio" class="form-control float-right" id="reservationtime">
                                </div>
                          </div>
                           <?php
                            $query = $mysqli->query("SELECT * FROM agendaEtiqueta WHERE nombre='$entraSolicitud' AND idUsuario='$sesion' ");
                            $row = $query->fetch_array(MYSQLI_ASSOC);
                            $colorEtiqueta= $row['etiqueta'];
                            $idEtiqueta= $row['id'];
                          
                          if($colorEtiqueta != NULL){
                          ?>
                          <!--
                          <div class="form-group">
                          <label>Color de etiqueta:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                    </div>-->
                                    
                                <!--</div>
                          </div>-->
                          <div class="input-group-append">
                                  <button id="add-new-event" type="submit" name="agenda" class="btn btn-primary">Guardar</button>
                                <input style="visibility:hidden;" type="color" value="<?php echo $colorEtiqueta;?>" disabled class="form-control float-right" id="reservationtime">
                                <input type="hidden" name="color" value="<?php echo $idEtiqueta;?>" >
                          </div>
                          <?php
                          }else{
                              echo '<font color="red"><b>Debe personalizar la etiqueta antes de agendar la actividad</b></font>';
                          }
                          ?>
                         </form> 
                          
                          
                          </div>
                          <?php
                          }elseif($entraSolicitud === 'Reuniones programadas'){
                        ?> 
                          <div class="col-9">
                                <h1 style="color:black;">Reuniones y tareas programadas</h1>
                         
                              <div class="form-group">
                           
                                <div class="tab-pane" id="timeline">
                                       <div class="timeline timeline-inverse">
                                           
                                  <!-- timeline time label $idparaChat -->
                                  <?php
                                $sql= $mysqli->query("SELECT * FROM agenda WHERE idUsuario='$sesion'  ORDER BY fecha ASC");
                                     $conteoActasA = 0;
                		            while($row = $sql->fetch_assoc()){
                		               
                                        $idAgenda=$row['id'];
                                        $idCreacionUsuario = $row['idUsuario'];
                                  
                                  /// se trae el id para montar los colores -->
                                    $idColorv=$row['color'];
                                        $query = $mysqli->query("SELECT * FROM agendaEtiqueta WHERE id='$idColorv'");
                                        $colorE = $query->fetch_array(MYSQLI_ASSOC);
                                        $colorEtiqueta= $colorE['etiqueta'];
                                        $colorTitulo= $colorE['titulo'];
                                        $colorSubtitulo= $colorE['subtitulo'];
                                        
                                  /// fin del proceso -->  
                                  
                                  
                                    $tipoPersonalValidando = $row['tipoPersonal'];
        		                    $personalIDValidando =  json_decode($row['personal']);
                                    $longitudValidando = count($personalIDValidando);
                                
                                        if($tipoPersonalValidando == 'usuario'){
                                            
                                            for($i=0; $i<$longitudValidando; $i++){
                                                
                                                $nombreActas = $mysqli->query("SELECT nombres, apellidos,cedula FROM usuario WHERE id = '$personalIDValidando[$i]' ");
                                                $columnaValidando = $nombreActas->fetch_array(MYSQLI_ASSOC);
                                                //echo $cedulaGuardaro=$columnaValidando['cedula'];
                                                
                                                $cn = mysqli_num_rows($nombreActas);
                                                
                                                if($cn > 0){
                                                $conteoActasA++;  
                                                ?>
                                                <div class="time-label">
                                                    <span class="bg-danger">
                                                      <?php echo $fecha=$row['fecha'];  ?>
                                                    </span>
                                                    
                                                  </div>
                                                  
                                                  <div>
                                                    <i class="fas fa-envelope bg-primary"></i>
                            
                                                    <div class="timeline-item">
                                                      <span class="time" style="color:<?php echo $colorSubtitulo;?>;">
                                                          <i class="far fa-clock"></i> <?php echo $fecha=$row['hora'];?>
                                                            <?php
                                                            if($sesion == $idCreacionUsuario){
                                                            ?>    
                                                            <a name="eliminarAgenda" onclick="window.location='controlador/comunicacionInterna/controllerComunicacionInterna?eliminarAgenda=<?php echo $idAgenda;?>'" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                                            <?php
                                                            }
                                                            ?>
                                                      </span>
                            
                                                      <h3 class="timeline-header" style="background:<?php echo $colorEtiqueta;?>;color:<?php echo $colorSubtitulo;?>;"><a style="color:<?php echo $colorTitulo;?>;" href="#"><?php $asunto=$row['asunto']; if($asunto == 'Crear reunion'){ echo'Reunión programada'; }else{ echo 'Tarea programada'; }   ?></a> <?php echo $row['tematica'];?></h3>
                            
                                                      <div class="timeline-body">
                                                        <?php echo $tematica=$row['descripcion']; ?><br><br>Personal convocado:<br>
                                                      
                                                       <?php 
                                                        $tipoPersonal = $row['tipoPersonal'];
                                                        $personalID =  json_decode($row['personal']);
                                                        $longitud = count($personalID);
                                                            if($tipoPersonal == 'usuario'){
                                                                
                                                                for($i=0; $i<$longitud; $i++){
                                                                    
                                                                    $nombreuser = $mysqli->query("SELECT * FROM usuario WHERE id = '$personalID[$i]'");
                                                                    $columna = $nombreuser->fetch_array(MYSQLI_ASSOC);
                                                                
                                                                    echo $columna['nombres']." ".$columna['apellidos'];echo "<br>";
                                                                }
                                                           
                                                             
                                                            }
                                                            /*
                                                            else{
                                                                
                                                                for($i=0; $i<$longitud; $i++){
                                                                $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$personalID[$i]'");
                                                                $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                                echo $columna['nombreCargos'];echo "<br>";
                                                                }
                                                            }*/
                                                            
                                                            ?>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  
                                                  <div>
                                                    <i class="far fa-clock bg-gray"></i>
                                                  </div>
                                                <?php
                                                }
                                                
                                            } //// cierre del for
                                        } //// cierre del if
                                  
                                        if($tipoPersonalValidando == 'cargo'){
                                                    
                                                    for($i=0; $i<$longitudValidando; $i++){
                                                        
                                                        $nombrecargo = $mysqli->query("SELECT cargos.nombreCargos,cargos.id_cargos,usuario.cargo FROM cargos INNER JOIN usuario WHERE cargos.id_cargos = '$personalIDValidando[$i]' 
                                                        AND cargos.id_cargos=usuario.cargo ");
                                                        $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                        //echo $columna['nombreCargos'];
                                                        
                                                        $cn = mysqli_num_rows($nombrecargo);
                                                        
                                                        if($cn > 0){
                                                        $conteoActasA++;  
                                                        ?>
                                                        <div class="time-label">
                                                            <span class="bg-danger">
                                                              <?php echo $fecha=$row['fecha'];  ?>
                                                            </span>
                                                            
                                                          </div>
                                                          
                                                          <div>
                                                            <i class="fas fa-envelope bg-primary"></i>
                                    
                                                            <div class="timeline-item">
                                                              <span class="time" style="color:<?php echo $colorSubtitulo;?>;">
                                                                  <i class="far fa-clock"></i> <?php echo $fecha=$row['hora'];?>
                                                                    <?php
                                                                    if($sesion == $idCreacionUsuario){
                                                                    ?>    
                                                                    <a name="eliminarAgenda" onclick="window.location='controlador/comunicacionInterna/controllerComunicacionInterna?eliminarAgenda=<?php echo $idAgenda;?>'" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                              </span>
                                    
                                                              <h3 class="timeline-header" style="background:<?php echo $colorEtiqueta;?>;color:<?php echo $colorSubtitulo;?>;"><a style="color:<?php echo $colorTitulo;?>;" href="#"><?php $asunto=$row['asunto']; if($asunto == 'Crear reunion'){ echo'Reunión programada'; }else{ echo 'Tarea programada'; }   ?></a> <?php echo $row['tematica'];?></h3>
                                    
                                                              <div class="timeline-body">
                                                                <?php echo $tematica=$row['descripcion']; ?><br><br>Personal convocado:<br>
                                                              
                                                               <?php 
                                                                $tipoPersonal = $row['tipoPersonal'];
                                                                $personalID =  json_decode($row['personal']);
                                                                $longitud = count($personalID);
                                                                    if($tipoPersonal == 'cargo'){
                                                                        
                                                                         for($i=0; $i<$longitud; $i++){
                                                                        $nombrecargo = $mysqli->query("SELECT nombreCargos FROM cargos WHERE id_cargos = '$personalID[$i]'");
                                                                        $columna = $nombrecargo->fetch_array(MYSQLI_ASSOC);
                                                                        echo $columna['nombreCargos'];echo "<br>";
                                                                        }
                                                                   
                                                                     
                                                                    }
                                                                    /*
                                                                    else{
                                                                        
                                                                       
                                                                    }*/
                                                                    
                                                                    ?>
                                                              </div>
                                                            </div>
                                                          </div>
                                                          
                                                          <div>
                                                            <i class="far fa-clock bg-gray"></i>
                                                          </div>
                                                        <?php
                                                        }
                                                        
                                                    } //// cierre del for
                                                } //// cierre del if
                                 
                		            
                		            }
                                    ?>
                                </div>
                            </div>
                                
                        </div>
                         
                        
                          
                          
                          </div>
                          <?php
                          }
                          ?>
                          <!-- /.col -->
                        </div>
                        <!-- /.row -->
                      </div><!-- /.container-fluid -->
                    </section>
                  </div>
                  <!-- Fin se agrega agendas -->
                  
                 
                  
                  
                  
                
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
<script>
    $(function () {
        $('.selectpicker').selectpicker();
    });
</script>
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
        $('#rad_cargoE').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoE").html(data);
            }); 
        });
        $('#rad_usuarioE').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoE").html(data);
            }); 
        });
    });
</script>
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<?php
/// validaciones de alertas
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