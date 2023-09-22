<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["session_username"])){
   require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

///////// notificaciones para plataforma y correo
require_once 'conexion/bd.php';
$formulario = 'politicas'; //Se cambia el nombre del formulario

require_once 'permisosPlataforma.php';
//////////////////////PERMISOS////////////////////////
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Editar Proveedor</title>
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
 <?php
                    $idProveedor=$_POST['idProveedor'];
                    $query = $mysqli->query("SELECT * FROM proveedores WHERE id= '$idProveedor'");
                    $row = $query->fetch_array(MYSQLI_ASSOC);
                    $idSolicitante = $row['id'];
                    $nit = $row['nit'];
                    $nitDigito= $row['nitDigito'];
                    $contacto = $row['contacto'];
                    $razonSocial = $row['razonSocial'];
                    $email = $row['email'];
                    $movil = $row['telefono'];
                    $codigoCiiu= $row['codigoCiiu'];
                    $descripcion = $row['descripcion'];
                    $criticidad = $row['criticidad'];
                    $grupo = $row['grupo'];
                    $terminoP = $row['terminoPago'];
                    $tipoPago = $row['tipo'];
                    $ciudad = $row['ciudad'];
                    $frecuenciaA = $row['frecuenciaActualizacion'];
                    $direccion = $row['direccion'];
                    $frecuenciaAD = $row['frecuenciaActualizacionD'];
                    $telefono = $row['telefono'];
                    $tiempoE = $row['tiempoEvaluacion'];
                    $tipoproveedor=$row['tipoproveedor'];
                    $personaNaturalJuridica = $row['personaNJ'];
                    if($personaNaturalJuridica == 'natural'){
                        $checkedActivoN='checked';
                    }else{
                        $checkedActivoJ='checked';
                    }
                      $proveedorEstado = $row['estado'];
                ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Editar Proveedor</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Editar proveedor</li>
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
                            <?php
                            if($proveedorEstado == 'Aprobado'){
                            ?>
                                <button type="button" class="btn btn-block btn-info btn-sm"><a href="proveedores"><font color="white"><i class="fas fa-list"></i> Listar proveedores</font></a></button>
                            <?php
                                
                            }else{
                            
                                if($_POST['masivo'] != NULL){
                                ?>
                                <button type="button" class="btn btn-block btn-info btn-sm"><a href="proveedorVigente"><font color="white"><i class="fas fa-list"></i> Listar proveedores</font></a></button>
                                <?php
                                }else{
                                ?>
                                <button type="button" class="btn btn-block btn-info btn-sm"><a href="proveedoresInscripcion"><font color="white"><i class="fas fa-list"></i> Listar proveedores</font></a></button>
                                <?php
                                }
                            }
                            ?>
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
            </div>
            <div class="col-9">
               
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="controlador/proveedor/controllerProveedor" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    
                    <input name="masivo" value="<?php echo $_POST['masivo']; ?>" type="hidden">
               
                    <input value="<?php echo $idSolicitante; ?>" name="idProveedor" type="hidden">
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label>Nit:</label>
                            <input type="number" min="0" class="form-control"  name="nit" placeholder="Nit" value="<?php echo $nit; ?>" onkeypress="return soloLetras(event)" onkeydown="noPuntoComa( event )" required  onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                        </div>
                        <div class="form-group col-sm-2">
                            <label style="color:white;">.</label>
                            <input type="number" min="0" class="form-control"  name="nitDigito" placeholder="Dígito" value="<?php echo $nitDigito; ?>" required >
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label>Contacto:</label>
                            <input type="text" class="form-control" value="<?php echo $contacto; ?>" name="contacto" placeholder="Contacto" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                        </div>                                
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Raz&oacute;n social:</label>
                            <input type="text" class="form-control" value="<?php echo $razonSocial; ?>" name="razonSocial" placeholder="Raz&oacute;n social" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Correo Electr&oacute;nico:</label>
                            <input type="email" class="form-control" value="<?php echo $email; ?>" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Móvil:</label>
                            <input type="number" class="form-control" name="movil" placeholder="movil" value="<?php echo $movil; ?>" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                        </div>
                        <div class="form-group col-sm-3">
                            <label>Código Ciiu:</label>
                            <input type="number" min="0" class="form-control" name="codigoCiiu" value="<?php echo $codigoCiiu; ?>" placeholder="Código Ciiu" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                        </div>
                        <div class="form-group col-sm-3">
                            <label>Descripción para el Texto:</label>
                            <textarea type="text" class="form-control" name="descripcion" placeholder="Descripci&oacute;n para el texto" required onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)"><?php echo $descripcion;?></textarea>
                        </div>
                    </div>
                    
                    <div class="row">
                        
                        <div class="form-group col-sm-6">
                            <label>Criticidad:</label>
                            <select type="email" class="form-control" name="criticidad" placeholder="Criticidad" required>
                                
                                 <?php
                                $consultaTipoProveedor=$mysqli->query("SELECT * FROM proveedoresCriticidad WHERE id='$criticidad' ORDER BY tipo");
                                while($extraerConsultaTipoprove=$consultaTipoProveedor->fetch_array()){
                                ?>
                                <option value="<?php echo $extraerConsultaTipoprove['id'];?>"><?php echo $extraerConsultaTipoprove['tipo'];?></option>
                                <?php
                                }
                                
                                $consultaTipoProveedor=$mysqli->query("SELECT * FROM proveedoresCriticidad WHERE NOT id='$criticidad' ORDER BY tipo");
                                while($extraerConsultaTipoprove=$consultaTipoProveedor->fetch_array()){
                                ?>
                                <option value="<?php echo $extraerConsultaTipoprove['id'];?>"><?php echo $extraerConsultaTipoprove['tipo'];?></option>
                                <?php
                                }
                                ?>
                                <!--
                                <option value="Critico">Critico</option>
                                <option value="Medio">Medio</option>
                                <option value="Bajo">Bajo</option>
                                -->
                            </select>
                        </div>  
                        <div class="form-group col-sm-6">
                            <label>Grupo:</label>
                            <?php
                           
                            $queryGrupos = $mysqli->query("SELECT * FROM proveedoresGrupo WHERE id= '$grupo'");
                            $rowGrupos = $queryGrupos->fetch_array(MYSQLI_ASSOC);
                            $nombreGrupo = $rowGrupos['grupo'];
                            ?>
                            <select type="text" class="form-control" name="grupo" placeholder="Grupo" required>
                                <option value="<?php echo $grupo; ?>"><?php echo $nombreGrupo; ?></option>
                                <?php
                                //require_once'conexion/bd.php';
                                $resultado=$mysqli->query("SELECT * FROM proveedoresGrupo ORDER BY grupo");
                                
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
                            <?php
                            if($terminoP > 0){
                                $checked='checked';
                                $none='';
                            }else{
                                $none='none';
                                if( $tipoPago == 'credito'){
                                    $checkedA='checked';
                                    
                                }else{
                                    $checkedA = '';
                                }
                                if( $tipoPago == 'contado'){
                                    $checkedB='checked';
                                }else{
                                    $checkedB ='';
                                }
                                if( $tipoPago == 'contraentrega'){
                                    $checkedC='checked';    
                                }else{
                                    $checkedC = '';
                                }
                                if( $tipoPago == 'otro'){
                                    $checkedD='checked'; 
                                }else{
                                    $checkedD ='';
                                }
                                   
                            }
                            
                            /// validamos si el campo para el value viene en 0 que el minimo me permita ser 0
                            if($terminoP == '0'){
                                    $minimo='0';
                                }else{
                                    $minimo='1';
                                }
                            ?>
                            <!-- T&eacute;rmino de pago (d&iacute;as) -->
                            Crédito <input id="habilitarCredito" type="radio" name="terminoPago" value="credito" <?php echo $checked; ?> required>&nbsp;&nbsp;
                            Contado <input id="habilitarContado" type="radio" name="terminoPago" value="contado" <?php echo $checkedB; ?> required>&nbsp;&nbsp;
                            Contraentrega <input id="habilitarContraEntrefa" type="radio" name="terminoPago" <?php echo $checkedC; ?> value="contraentrega" required>&nbsp;&nbsp;
                            Otro <input id="habilitarOtro" type="radio" name="terminoPago" <?php echo $checkedD; ?> value="otro" required>
                            </div>
                            <?php
                            if($checkedD == 'checked'){
                                $tipoB = '';
                            }else{
                                $tipoB = 'none';
                            }
                            
                            if($checkedB == 'checked'){
                                $tipoC = 'none';
                            }else{
                                $tipoC = '';
                            }
                            
                            
                            
                           
                            ?>
                           <div class="form-group col-sm-6"> 
                            <label style="display:<?php echo $none;?>;" id="nd">Número de días</label>
                            <label style="display:<?php echo $tipoB; ?>;" id="io">Ingrese otro método de pago</label>
                            <input type="number" style="display:<?php echo $none;?>;" id="mostrar" value="<?php echo $terminoP; ?>" class="form-control" name="terminoPagoNumeros" placeholder="Días" min="<?php echo $minimo;?>" >
                            <br>
                            <?php
                            /// validar que en este campo no entre el valor 0
                            if($row['terminoPago'] == '0'){
                                $enviarValorSinCero='';
                            }else{
                                $enviarValorSinCero=$row['terminoPago'];
                            }
                            ?>
                            <input type="text" style="display:<?php echo $tipoB; ?>;" id="otro" name="otro" class="form-control" value="<?php echo  $enviarValorSinCero; ?>" name="otro" placeholder="Ingrese metodo de pago" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 209 || event.charCode == 241 || event.charCode == 32  || event.charCode == 225 || event.charCode == 233 || event.charCode == 237 || event.charCode == 243 || event.charCode == 250 || event.charCode == 44 || event.charCode == 46 || event.charCode == 193 || event.charCode == 201 || event.charCode == 205 || event.charCode == 211 || event.charCode == 218)">
                            
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
                            //$queryCiudad = $mysqli->query("SELECT * FROM municipios WHERE id = '$ciudad' ORDER BY codigo");
                            $resultado=$mysqli->query("SELECT municipios.id AS idCodigo,municipios.nombre AS Municipio, departamentos.nombre AS Departamento FROM municipios INNER JOIN departamentos ON municipios.departamento_id = departamentos.id AND municipios.id='$ciudad'");
                            $rowCiudad = $resultado->fetch_array(MYSQLI_ASSOC);
                            $idCiudad = $rowCiudad['idCodigo'];
                            $nombreCiudad = $rowCiudad['Municipio'];
                            $codigoCiudad = $rowCiudad['Departamento'];
                            
                            ?>
                            <select type="text" class="form-control" name="ciudad" placeholder="Ciudad" required>
                                <option value="<?php echo $idCiudad; ?>"><?php echo $idCiudad.' - '.$codigoCiudad .' - '.$nombreCiudad; ?></option>
                                <?php
                                //require_once'conexion/bd.php';
                                $resultado=$mysqli->query("SELECT municipios.id,municipios.nombre AS Municipio, departamentos.nombre AS Departamento FROM municipios INNER JOIN departamentos ON municipios.departamento_id = departamentos.id AND not municipios.id='$ciudad'");
                                
                                while ($columna = mysqli_fetch_array( $resultado )) { ?>
                                <option value="<?php echo $columna['id']; ?>"><?php echo $columna['id'].' - '.$columna['Departamento'].' - '.$columna['Municipio']; ?> </option>
                                <?php }  ?>
                            </select>
                            <!--<input type="text" class="form-control" value="<?php //echo $columna['nombre']; ?>" name="ciudad" placeholder="Ciudad" required>-->
                        </div>
                        <!--
                        <div class="form-group col-sm-6">
                            <label>Frecuencia de actualizaci&oacute;n (Meses):</label>
                            <input type="number" class="form-control" value="<?php //echo $frecuenciaA; ?>" name="frecuenciaA" placeholder="Frecuencia de actualizaci&oacute;n" min="0" required>
                        </div>
                        -->
                         <div class="form-group col-sm-6">
                            <label>Direcci&oacute;n:</label>
                            <input type="text" class="form-control" value="<?php echo $direccion; ?>" name="direccion" placeholder="Direcci&oacute;n" required>
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="form-group col-sm-6">
                            <label>Frecuencia actualizaci&oacute;n de documentos (Meses):</label>
                            <input type="number" class="form-control" value="<?php echo $frecuenciaAD; ?>" name="frecuenciaAD" placeholder="Frecuencia actualizaci&oacute;n de documentos" min="0" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Tel&eacute;fono:</label>
                            <input type="number" class="form-control" value="<?php echo $telefono; ?>" name="telefono" placeholder="Tel&eacute;fono" min="0" required>
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="form-group col-sm-6">
                            <label>Tiempo para evaluaci&oacute;n (Meses):</label>
                            <input type="number" class="form-control" value="<?php echo $tiempoE; ?>" name="tiempoE" placeholder="Tiempo para evaluaci&oacute;n" min="0" required>
                        </div> 
                        <div class="form-group col-sm-6">
                            <label>Persona natural:</label>
                            <input type="radio" name="personaNJ" value="natural" <?php echo $checkedActivoN; ?> required>
                            &nbsp;
                            <label>Persona jurídica:</label>
                            <input type="radio" name="personaNJ" value="jurídica" <?php echo $checkedActivoJ; ?> required>
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="form-group col-sm-6">
                            <label>Tipo de proveedor:</label>
                            <select  class="form-control" name="tipoproveedor"  required>
                                <?php
                                $consultaTipoProveedor=$mysqli->query("SELECT * FROM proveedoresTipo WHERE id='$tipoproveedor' ORDER BY tipo");
                                while($extraerConsultaTipoprove=$consultaTipoProveedor->fetch_array()){
                                ?>
                                <option value="<?php echo $extraerConsultaTipoprove['id'];?>"><?php echo $extraerConsultaTipoprove['tipo'];?></option>
                                <?php
                                }
                                
                                $consultaTipoProveedor=$mysqli->query("SELECT * FROM proveedoresTipo WHERe NOT id='$tipoproveedor'  ORDER BY tipo");
                                while($extraerConsultaTipoprove=$consultaTipoProveedor->fetch_array()){
                                ?>
                                <option value="<?php echo $extraerConsultaTipoprove['id'];?>"><?php echo $extraerConsultaTipoprove['tipo'];?></option>
                                <?php
                                }
                                ?>
                                <!--
                                <option value="A">Tipo A</option>
                                <option value="B">Tipo B</option>
                                <option value="C">Tipo C</option>
                                -->
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                             <?php 
                                $radioIndicador =  $row['radio'];
                                if($radioIndicador == 'cargo'){
                                    $checkedC='checked';
                                }
                                if($radioIndicador == 'usuario'){
                                    $checkedU='checked';
                                }
                            
                            
                            if($_POST['masivo'] != NULL){
                            ?>
                            <input value="<?php echo $idparaChat;?>" name="Usuario" type="hidden">
                            <?php
                            }else{
                            ?>
                            <label>Aprobación de proveedor: </label><br>
                            <input type="radio" id="rad_cargoRI" name="radiobtn" value="cargo" <?php echo $checkedC; ?> required>
                            <label for="cargo">Cargo</label>
                            <input type="radio" id="rad_usuarioRI" name="radiobtn" value="usuario" <?php echo $checkedU; ?> required>
                            <label for="usuarios">Usuarios</label>
                            <div class="select2-blue">
                                <select class="select2" multiple="multiple" data-placeholder="Seleccionar" style="width:100%;" name="select_encargadoRI[]" id="select_encargadoRI" required>
                                <?php
                                    if($radioIndicador == 'cargo'){
                                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                                        $cargoAsociados =  json_decode($row['aprobador']);
                                        /// END
                                        $consultaCargos=$mysqli->query("SELECT * FROM cargos ORDER BY nombreCargos ");
                                        while ($columna = $consultaCargos->fetch_array()) { 
                                            
                                                    if(in_array($columna['id_cargos'],$cargoAsociados)){
                                                            $seleccionarCt = "selected";        
                                                        }else{
                                                            $seleccionarCt ="";
                                                        }
                                    ?>
                                    <option value="<?php echo $columna['id_cargos']; ?>" <?php echo $seleccionarCt; ?>  ><?php echo $columna['nombreCargos']; ?> </option>
                                    <?php 
                                        }
                                    }
                                    
                                    
                                     if($radioIndicador == 'usuario'){
                                        $acentos2 = $mysqli->query("SET NAMES 'utf8'");
                                        $cargoAsociados =  json_decode($row['aprobador']);
                                        /// END
                                        $consultaCargos=$mysqli->query("SELECT * FROM usuario ORDER BY id ");
                                        while ($columna = $consultaCargos->fetch_array()) { 
                                            
                                                    if(in_array($columna['id'],$cargoAsociados)){
                                                            $seleccionarCt = "selected";        
                                                        }else{
                                                            $seleccionarCt ="";
                                                        }
                                    ?>
                                    <option value="<?php echo $columna['id']; ?>" <?php echo $seleccionarCt; ?>  ><?php echo $columna['nombres'].' '.$columna['apellidos']; ?> </option>
                                    <?php 
                                        }
                                    }
                                ?>
                                </select>
                            </div>
                            <?php
                            }
                            ?>
                            
                        </div>
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
                  
                  <button type="submit" class="btn btn-primary float-right" name="EditarProveedor">Actualizar</button>
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
<script>
    function soloLetras(e) {
      var key = e.keyCode || e.which,
        tecla = String.fromCharCode(key).toLowerCase(),
        letras = " -0123456789",
        especiales = [9, 37, 39, 46],
        tecla_especial = false;

      for (var i in especiales) {
        if (key == especiales[i]) {
          tecla_especial = true;
          break;
        }
      }

      if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
      }
      
    }
function noPuntoComa( event ) {
  
    var e = event || window.event;
    var key = e.keyCode || e.which;

    if ( key === 110 || key === 190 || key === 188 ) {     
        
       e.preventDefault();     
    }
}    
</script>
</body>
</html>
<?php
}
?>