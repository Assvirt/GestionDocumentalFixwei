<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

///////// notificaciones para plataforma y correo
require_once 'conexion/bd.php';
$formulario = 'usuarios'; //Se cambia el nombre del formulario
$documento = $_SESSION["session_username"];
$queryGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario = '$documento'");

while($row = $queryGrupos->fetch_assoc()){
    $idGrupo = $row['idGrupo'];
    
    $queryPermisos = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo = '$idGrupo' AND formulario = '$formulario'");
    
    $permisos = $queryPermisos->fetch_array(MYSQLI_ASSOC);
    if($permisos['plataforma'] == TRUE){
        $permisoPlataforma = $permisos['plataforma'];    
    }
    if($permisos['correo'] == TRUE){
        $permisoCorreo = $permisos['correo'];    
    }
    
}

if($permisoPlataforma == FALSE){
    $visibleP = 'none';
}else{
    $visibleP = '';
}

if($permisoCorreo == FALSE){
    $visibleC = 'none';
}else{
    $visibleC = '';
}

//////// fin notificaciones correo plataforma
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Agregar Usuarios</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
</head>
<script>
   	
    function nobackbutton(){
    	
       window.location.hash="no-back-button";
    	
       window.location.hash="Again-No-back-button" //chrome
    	
       window.onhashchange=function(){window.location.hash="no-back-button";}
    	
    }
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
            <h1>Agregar Usuarios</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Agregar usuarios</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="usuarios"><font color="white"><i class="fas fa-list"></i> Listar usuarios</font></a></button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    
                </div>
                
           
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<!-- se genera una contraseña automatica -->
<?php
//la funcion la llamamos generar codigo y le damos un nombre a la variable que nos va a dar el ancho de la clave
function generarCodigo($longitud) {
//key es la variable que vamos a usar para llenar con la cadena de caracteres
//la inicializamos en 0
    $key = '';
//tupla es la lista con los caracteres a usar    
    $tupla = '1234567890abcdefghijklmnopqrstuvwxyz';
    //$tupla= str_shuffle($tupla);
 //max es el rango   
    $max = strlen($tupla)-1;
 //usamos un contador   
    //for($i=0;$i < $longitud;$i++) $key .= $tupla{mt_rand(0,$max)};

    for($i=0;$i < $longitud;$i++){
       $key .=  mt_rand(0,$max);
    }

 //retornamos la clave   
    return $key;
}   
//imprimimos la clave, los primeros 6 digitos
//ese numero se puede cambiar
//echo generarCodigo(8);
?>
<!-- Fin se genera una contraseña automatica -->



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
              <form role="form" action="controlador/usuarios/controladorUsuarios" method="POST" enctype="multipart/form-data" onsubmit="return v(this)">
                <div class="card-body">
                    
                <!-- parametros para la activacion de correo y plataforma -->
                    <div class="row"> 
                        <div class="form-group col-sm-6">
                          <input name="usuarioActividad" value="<?php echo $sesion;?>" type="hidden" readonly>
                          <!-- <label>Notificaciones por: </label>&nbsp;&nbsp; -->
                              <?php /// if($visibleP != 'none'){ ?>
                              
                              <!--  <label>Plataforma</label> -->
                                    <input style="border:0px;" name="plataforma" value="1" type="hidden" readonly>
                                <?php /* }else{  }
                          
                              if($visibleP != 'none' && $visibleC != 'none'){
                                  echo '-';
                              }
                          
                                    if($visibleC != 'none'){ */ ?>
                             <!--   <label>Correo</label> -->
                                    <input style="border:0px;" name="correo" value="1" type="hidden" readonly>
                                <?php // }else{  } ?>
                        </div>
                    </div>
                <!-- Fin parametros para la activacion de correo y plataforma -->
               
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Nombres:</label>
                            <input autocomplete="off" type="text" class="form-control"  name="nombre" placeholder="Nombres" pattern="[A-Za-z0-9_- ]{1,90}" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label>Apellidos:</label>
                            <input autocomplete="off" type="text" class="form-control"  name="apellidos" placeholder="Apellidos" pattern="[A-Za-z0-9_- ]{1,90}" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                        </div>                                
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label>Documento de identidad:</label>
                            <input autocomplete="off" type="number" class="form-control" id="descripcion" name="documento" placeholder="Documento de identidad" min='0' required>
                        </div>
                        <div class="form-group col-sm-3">
                            <label>Tipo de documento:</label><br>
                            CC
                            <input type="radio" name="tipo" value="C" required>
                            CE
                            <input type="radio" name="tipo" value="E" required>
                        </div>
                        <div class="form-group col-sm-3">
                            <?php
                             date_default_timezone_set('America/Bogota');
                             $fecha1=date('Y-m-j');
                             
                             $validnadoEdad=substr($fecha1,0,4);
                             $mesValidado=substr($fecha1,5,2);
                             $diaValidado=substr($fecha1,8,2);
                             $resultadoFechaEdad=$validnadoEdad-18;
                             if($diaValidado > 0 && $diaValidado < 10){
                               $enviarCero='0';
                             }
                             $fechaValidadoUsuario=$resultadoFechaEdad.'-'.$mesValidado.'-'.$enviarCero.''.$diaValidado;
                            ?>
                            
                            <label>Fecha de nacimiento:</label>
                            <input type="date" class="form-control"   max="<?php echo $fechaValidadoUsuario;?>" id="fechaNacmiento" name="fechaNacimiento" placeholder="Documento" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Foto (Máx 5MB):</label>
                            <!--<input type="file" class="form-control" id="nombreProceso" name="foto" >-->
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" class="custom-file-input" id="miInput" name="foto" accept=".jpg,.jpeg,.png,.gif,.jpeg,.bmp,.svg,.jfif,.PNG,.JPEG,.GIF,.JPG,.TIFF,.PPM,.PGM,.PBM,.PNM,.BPG,.PPM,.DRW,.ECW,.FITS,.FLIF,.XCF,.SVG">
                                    <!-- Agregamos esta linea para validar que solo sea el documento pdf-->
                                    <script>
                                    $('input[name="foto"]').on('change', function(){// <input type="file" name="archivo" class="custom-file-input" id="customFile" accept=".jpg,.jpeg,.png,.gif,.jpeg,.bmp,.svg">
                                        var ext = $( this ).val().split('.').pop();
                                        if ($( this ).val() != '') {
                                        if(ext == "jpg" || ext == "jpeg" || ext == "png" || ext == "gif" || ext == "jpe" || ext == "bmp" || ext =="svg"|| ext =="jfif" || ext == "PNG" || ext == "JPEG" || ext == "JPG" || ext == "TIFF" || ext =="PPM"|| ext =="PGM"|| ext =="PBM"|| ext =="PNM"|| ext =="BPG"|| ext =="PPM"|| ext =="DRW"|| ext =="ECW"|| ext =="FITS"|| ext =="FLIF"|| ext =="XCF"|| ext =="SVG"){
                                            
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
                                <label class="custom-file-label" >Subir Archivo</label>
                            </div>
                            </div>
                        </div>
                    </div>
                    <label><h7>Formatos Permitidos: PNG,JPG,JPEG,JFIF</h7></label>
                    <div class="row"><!--
                        <div class="form-group col-sm-6">
                            <label>Contraseña:</label>
                            <?php
                            /// código anterior echo generarCodigo(8);
                            $tupla = '1234567890abcdefghijklmnopqrstuvwxyz';
                            $enviarVariableCaracteres=substr(str_shuffle($tupla), 0, 10);
                            ?>
                        </div>
                        -->
                        <input type="hidden" value="<?php echo $enviarVariableCaracteres; ?>" name="pass" required>
                        
                        <div class="form-group col-sm-6">
                            <label>Correo electrónico:</label>
                            <input autocomplete="off" type="email" class="form-control" id="descripcion" name="email" placeholder="Correo electrónico" onkeypress="return ( (event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 64 || event.charCode == 95 || event.charCode == 46 || event.charCode == 45 || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                        </div>  
                        <div class="form-group col-sm-6">
                            <label>Teléfono:</label>
                            <input autocomplete="off" type="number" min="0" class="form-control" id="descripcion" name="telefono" placeholder="Teléfono" required>
                        </div>                      
                    </div>
                    <div class="row">
                        
                        <div class="form-group col-sm-6">
                            <label>Proceso:</label>
                            <?php
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultadoProcesos=$mysqli->query("SELECT * FROM procesos ORDER BY nombre");
                            ?>
                            <select type="text" class="form-control" id="descripcion" name="proceso" placeholder="Proceso" required>
                                <option value='' required>Seleccionar proceso</option>
                                <?php
                                while ($columnaProcesos = mysqli_fetch_array( $resultadoProcesos )) {
                                    if($columnaProcesos['estado'] == 'Eliminado'){
                                        continue;
                                    }
                                ?>
                                <option value="<?php echo $columnaProcesos['id']; ?>"><?php echo $columnaProcesos['nombre']; ?> </option>
                                <?php }  ?>
                            </select>
                         </div>
                         <div class="form-group col-sm-6">
                            <label>Cargo:</label>
                            <?php
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT * FROM cargos ORDER BY nombreCargos");
                            ?>
                            <select type="text" class="form-control" id="cargo" name="cargo" placeholder="cargo" required>
                                <option value=''>Seleccionar cargo</option>
                                <?php
                                while ($columna = mysqli_fetch_array( $resultado )) { ?>
                                <option value="<?php echo $columna['id_cargos']; ?>"><?php echo $columna['nombreCargos']; ?> </option>
                                <?php }  ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                       
                        <div class="form-group col-sm-6">
                            <label>Líder:</label>
                            <?php
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT * FROM cargos ORDER BY nombreCargos");
                                $resultadoCT =$mysqli->query("SELECT id_centrodetrabajo, nombreCentrodeTrabajo FROM centrodetrabajo");
                            ?>
                            <select type="text" class="form-control" id="lider" name="lider" placeholder="lider" required>
                                <option value='N/A'>N/A</option>
                                <?php
                                while ($columna = mysqli_fetch_array( $resultado )) { ?>
                                <option value="<?php echo $columna['id_cargos']; ?>"><?php echo $columna['nombreCargos']; ?> </option>
                                <?php }  ?>
                            </select>
                        </div>
                         <div class="form-group col-sm-6">
                            <label>Centro de trabajo:</label>
                           
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar centro trabajo" style="width: 100%;" name="cTrabajo[]" id="cTrabajo" required>
                                    <?php
                                    while ($columna = mysqli_fetch_array( $resultadoCT )) { ?>
                                    <option value="<?php echo $columna['id_centrodetrabajo']; ?>"><?php echo $columna['nombreCentrodeTrabajo']; ?> </option>
                                    <?php }  ?>      
                                </select>
                            </div>
                        </div>
                        <?php
                        /*
                        ?>
                        <div class="form-group col-sm-6">
                            <!--<label>Centro de costos:</label>-->
                            <?php
                            
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultado=$mysqli->query("SELECT * FROM centroCostos ORDER BY nombre");
                            ?>
                        
                            <select type="text" class="form-control" id="idCentroCostos" name="idCentroCostos" required>
                                <option value=''>Seleccionar centro de costos</option>
                                <?php
                                
                                while ($columna = mysqli_fetch_array( $resultado )) { 
                                $enviaridCentroTrabajo=$columna['idCentroTrabajo'];
                                $consultaCentroTrabajo=$mysqli->query("SELECT * FROM centrodetrabajo WHERE id_centrodetrabajo='$enviaridCentroTrabajo'"); 
                                $extraerCentroTrabajo=$consultaCentroTrabajo->fetch_array(MYSQLI_ASSOC);
                                $nombreCentroTrabajo=$extraerCentroTrabajo['nombreCentrodeTrabajo'];
                                
                                ?>
                                <option value="<?php echo $columna['id']; ?>"><?php echo $columna['codigo'].' - '.$columna['nombre'].' - '.$nombreCentroTrabajo; ?> </option>
                                <?php }  ?>
                            </select>
                        </div>
                        
                        <?php
                        */
                        ?>
                        
                    </div>
                    <div class="row">
                         
                        <?php
                                require_once'conexion/bd.php';
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $resultadoCT =$mysqli->query("SELECT id_centrodetrabajo, nombreCentrodeTrabajo FROM centrodetrabajo");
                            ?>
                       
                        <div class="form-group col-sm-6">
                            <label>ARL:</label>
                            <input autocomplete="off" type="text" class="form-control" name="arl" placeholder="ARL" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                        </div>
                    </div>
                    <div class="row">
                       
                        <div class="form-group col-sm-6">
                            <label>EPS:</label>
                            <input autocomplete="off" type="text" class="form-control" name="eps" placeholder="EPS" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>AFP:</label>
                            <input autocomplete="off" type="text" class="form-control" name="afp" placeholder="AFP" onkeypress="return ( (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 ||  event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)" required>
                        </div> 
                    </div>
                    
                    <?php
                            require_once'conexion/bd.php';
                            $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                            $resultado=$mysqli->query("SELECT * FROM grupo ORDER BY nombre");
                  ?>
                  <div class="form-group">
                    <label>Grupos</label>
                    <script>
                    $("#js-example-placeholder-single").select2({
                        placeholder: "Select a state",
                        allowClear: true
                    });
                  </script>
                    <select class="duallistbox" name="grupos[]"  multiple="multiple"> <!-- id="id_select" -->
                        <?php
                            while ($columna = mysqli_fetch_array( $resultado )) { ?>
                            <option value="<?php echo $columna['id']; ?>"><?php echo $columna['nombre']; ?> </option>
                        <?php }  ?>
                    </select>
                    <script>
                        function v(s){
                            if (s['grupos[]'].selectedIndex!=-1){
                                return true;
                            }else{
                                //alert("Debes seleccionar al menos 1 opción");
                                 const Toast = Swal.mixin({
                                  toast: true,
                                  position: 'top-end',
                                  showConfirmButton: false,
                                  timer: 3000
                                });
                                
                                
                                
                                    Toast.fire({
                                        type: 'warning',
                                        title: ' Debe seleccionar al menos 1 opción.'
                                    })
                                return false;
                            }
                        }
                    </script>
                  </div>
                  
                  <!-- Oculto este campo para no alterar la anterios estructura que habia con el login-->
                  <div class="form-group">
                    <input type="hidden" class="form-control" readonly display name="estado" value="Creado" placeholder="Estado" required>
                  </div>
        
                  <!--
                  
                  ACA SE AGREGAN ELEMENTOS NUEVOS
                  
                  SE PUEDE EXTRAER DE: 
                  https://fixwei.com/plataforma/pages/forms/general.html
                  https://fixwei.com/plataforma/pages/forms/advanced.html
                  https://fixwei.com/plataforma/pages/forms/editors.html
                  
                  -->
                  
                  
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer" >
                  
                <span id="ocultarValidarFecha" class="btn btn-success float-right" onclick="funcionFormula()" >Validar fecha</span>
                <button type="submit" id="mostrarBotonFinalizar" style="display:none;" class="btn btn-primary float-right" name="AgregarUsuario">Agregar</button>
                
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
<?php echo require_once'footer.php'; ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
                            
                            <!-- Capturamos la fecha del sistema para validar la fecha con el script -->
                            <input name="" id="capturandoFecha" value="<?php echo $resultadoFechaEdad;?>-12-31"  type="hidden">
                            <!-- END -->
                                <script>
                                   /// validamos si la fecha está bien digitada o no
                                    function funcionFormula(){
                                       //// capturamos las variables de las fechas
                                       fechaAprobacionPrimera = document.getElementById("fechaNacmiento").value;
                                       capturandoFechaSistema = document.getElementById("capturandoFecha").value;
                                       //// END
                                      // alert(fechaAprobacionPrimera);
                                       /// validamos si la fecha de aprobación es menor que la fecha de elaboración y revisor
                                       if(fechaAprobacionPrimera > capturandoFechaSistema ){  //alert('Entra a');
                                            //alert('La fecha de aprobación no puede ser menor a la fecha de revisión');
                                            const Toast = Swal.mixin({
                                              toast: true,
                                              position: 'top-end',
                                              showConfirmButton: false,
                                              timer: 3000
                                            });
                                            
                                            
                                                Toast.fire({
                                                    type: 'warning',
                                                    title: ' Fecha de nacimiento no permitida.'
                                                })
                                       }else{  //alert('Entra b');
                                            //// en caso que la fecha esté correcta nos ejecuta esta acción para activar el botón de manera automatica
                                              $(document).ready(function() {
                                                  // indicamos que se ejecuta la funcion a los 5 segundos de haberse
                                                  // cargado la pagina
                                                  setTimeout(clickbutton, 0000);
                                                
                                                  function clickbutton() {
                                                    // simulamos el click del mouse en el boton del formulario
                                                    $("#action-button").click();
                                                    //alert("Aqui llega"); //Debugger
                                                  }
                                                  $('#action-button').on('click',function() {
                                                   // console.log('action');
                                                  });
                                                }); 
                                            //// END
                                           
                                       }
                                       /// END
                                    }
                                    /// END  
                                </script>
                            <!-- al momento que se ejecuta el script de manera automatica, acciona este botón para simular el click y poder habilitar el botón oculto -->
                            <a href="#" id="action-button" style="display:none;" onclick="enviar()" >Mostrara botón</a>
                            <!-- END -->
                            <!-- al momento de ejecutar la simulación del botón de las fechas esta función se ejecuta para mostrar el botón de finalizar -->
                            <script>
                                function enviar(){
                                    document.getElementById('mostrarBotonFinalizar').style.display = '';
                                    document.getElementById('ocultarValidarFecha').style.display = 'none';
                                            
                                            
                                }
                            </script>
                            <!-- END -->
                            <script>
    const MAXIMO_TAMANIO_BYTES = 6000000; // 1MB = 1 millón de bytes

// Obtener referencia al elemento
const $miInput = document.querySelector("#miInput");

$miInput.addEventListener("change", function () {
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
            title: ` El tamaño máximo del archivo es de 5 MB`
        })
		// Limpiar
		$miInput.value = "";
	} else {
		// Validación asada. Envía el formulario o haz lo que tengas que hacer
	}
});

</script>
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
<!-- para mostrar el archivo seleccionado en el file -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<!-- END -->
<!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>

<script type="text/javascript">
  $(function() {
   
   
    
    
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